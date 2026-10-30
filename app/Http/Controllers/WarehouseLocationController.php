<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\WarehouseLocation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class WarehouseLocationController extends Controller
{
    public function index()
    {
        $locations = WarehouseLocation::whereNull('parent_id')
            ->with('children')
            ->orderBy('name')
            ->get();

        $productsByLocation = Product::orderBy('name')
            ->get()
            ->groupBy('warehouse_location_id');

        return view(
            'warehouse-locations.index',
            compact('locations', 'productsByLocation')
        );
    }

    public function create()
    {
        $parents = WarehouseLocation::whereNull('parent_id')
            ->where('type', 'zone')
            ->orderBy('name')
            ->get();

        return view(
            'warehouse-locations.create',
            compact('parents')
        );
    }

    public function store(Request $request)
    {
        $validated = $request->validate(
            [
                'name' => [
                    'required',
                    'string',
                    'max:255',
                ],
                'type' => [
                    'required',
                    'in:zone,shelf',
                ],
                'parent_id' => [
                    'nullable',
                    'exists:warehouse_locations,id',
                ],
                'description' => [
                    'nullable',
                    'string',
                    'max:1000',
                ],
            ],
            [
                'name.required' =>
                    'Ievadi atrašanās vietas nosaukumu.',
                'type.required' =>
                    'Izvēlies atrašanās vietas tipu.',
                'type.in' =>
                    'Nederīgs atrašanās vietas tips.',
                'parent_id.exists' =>
                    'Izvēlētā zona neeksistē.',
            ]
        );

        if ($validated['type'] === 'zone') {
            $validated['parent_id'] = null;
        }

        if ($validated['type'] === 'shelf') {
            if (empty($validated['parent_id'])) {
                throw ValidationException::withMessages([
                    'parent_id' =>
                        'Plauktam jāizvēlas noliktavas zona.',
                ]);
            }

            $parent = WarehouseLocation::find(
                $validated['parent_id']
            );

            if (
                !$parent ||
                $parent->type !== 'zone' ||
                $parent->parent_id !== null
            ) {
                throw ValidationException::withMessages([
                    'parent_id' =>
                        'Plauktu drīkst pievienot tikai galvenajai noliktavas zonai.',
                ]);
            }
        }

        WarehouseLocation::create($validated);

        return redirect()
            ->route('warehouse-locations.index')
            ->with(
                'success',
                'Noliktavas atrašanās vieta veiksmīgi pievienota.'
            );
    }

    public function edit(WarehouseLocation $warehouseLocation)
    {
        $parents = WarehouseLocation::whereNull('parent_id')
            ->where('type', 'zone')
            ->where('id', '!=', $warehouseLocation->id)
            ->orderBy('name')
            ->get();

        return view(
            'warehouse-locations.edit',
            compact('warehouseLocation', 'parents')
        );
    }

    public function update(
        Request $request,
        WarehouseLocation $warehouseLocation
    ) {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
            ],
            'type' => [
                'required',
                'in:zone,shelf',
            ],
            'parent_id' => [
                'nullable',
                'exists:warehouse_locations,id',
            ],
            'description' => [
                'nullable',
                'string',
                'max:1000',
            ],
        ]);

        DB::transaction(function () use (
            $validated,
            $warehouseLocation
        ) {
            $location = WarehouseLocation::query()
                ->lockForUpdate()
                ->findOrFail($warehouseLocation->id);

            // Zona ar plauktiem nevar kļūt par plauktu.
            if (
                $location->type === 'zone' &&
                $validated['type'] === 'shelf' &&
                $location->children()->exists()
            ) {
                throw ValidationException::withMessages([
                    'type' =>
                        'Šo zonu nevar pārveidot par plauktu, jo tajā jau atrodas plaukti.',
                ]);
            }

            // Plaukts, kurā atrodas preces,
            // nevar kļūt par zonu.
            if (
                $location->type === 'shelf' &&
                $validated['type'] === 'zone' &&
                Product::where(
                    'warehouse_location_id',
                    $location->id
                )->exists()
            ) {
                throw ValidationException::withMessages([
                    'type' =>
                        'Šo plauktu nevar pārveidot par zonu, jo tajā atrodas preces.',
                ]);
            }

            // Zona vienmēr ir augšējā līmenī.
            if ($validated['type'] === 'zone') {
                $validated['parent_id'] = null;
            }

            // Plauktam obligāti jāatrodas zonā.
            if ($validated['type'] === 'shelf') {
                if (empty($validated['parent_id'])) {
                    throw ValidationException::withMessages([
                        'parent_id' =>
                            'Plauktam jāizvēlas noliktavas zona.',
                    ]);
                }

                if (
                    (int) $validated['parent_id'] ===
                    (int) $location->id
                ) {
                    throw ValidationException::withMessages([
                        'parent_id' =>
                            'Noliktavas vieta nevar būt pati sev vecāks.',
                    ]);
                }

                $parent = WarehouseLocation::query()
                    ->whereKey($validated['parent_id'])
                    ->where('type', 'zone')
                    ->whereNull('parent_id')
                    ->first();

                if (!$parent) {
                    throw ValidationException::withMessages([
                        'parent_id' =>
                            'Plauktu drīkst piesaistīt tikai galvenajai noliktavas zonai.',
                    ]);
                }
            }

            $location->update($validated);
        });

        return redirect()
            ->route('warehouse-locations.index')
            ->with(
                'success',
                'Noliktavas atrašanās vieta veiksmīgi rediģēta.'
            );
    }

    public function destroy(WarehouseLocation $warehouseLocation)
    {
        DB::transaction(function () use ($warehouseLocation) {
            $location = WarehouseLocation::query()
                ->lockForUpdate()
                ->findOrFail($warehouseLocation->id);

            if ($location->children()->exists()) {
                throw ValidationException::withMessages([
                    'location' =>
                        'Zonu nevar dzēst, kamēr tajā atrodas plaukti.',
                ]);
            }

            if (
                Product::where(
                    'warehouse_location_id',
                    $location->id
                )->exists()
            ) {
                throw ValidationException::withMessages([
                    'location' =>
                        'Noliktavas vietu nevar dzēst, kamēr tajā atrodas preces.',
                ]);
            }

            $location->delete();
        });

        return redirect()
            ->route('warehouse-locations.index')
            ->with(
                'success',
                'Noliktavas atrašanās vieta veiksmīgi dzēsta.'
            );
    }
}
