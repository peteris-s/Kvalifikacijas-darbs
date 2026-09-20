<?php

namespace App\Http\Controllers;

use App\Models\WarehouseLocation;
use Illuminate\Http\Request;

class WarehouseLocationController extends Controller
{
    public function index()
    {
        $locations = WarehouseLocation::whereNull('parent_id')
            ->with('children')
            ->orderBy('name')
            ->get();

        return view(
            'warehouse-locations.index',
            compact('locations')
        );
    }

    public function create()
    {
        $parents = WarehouseLocation::whereNull('parent_id')
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

        // Zona nevar atrasties zem citas zonas.
        if ($validated['type'] === 'zone') {
            $validated['parent_id'] = null;
        }

        // Plauktam obligāti jābūt piesaistītam zonai.
        if (
            $validated['type'] === 'shelf' &&
            empty($validated['parent_id'])
        ) {
            return back()
                ->withErrors([
                    'parent_id' =>
                        'Plauktam jāizvēlas noliktavas zona.'
                ])
                ->withInput();
        }

        // Pārbaudām, ka plaukta parent tiešām ir zona.
        if ($validated['type'] === 'shelf') {

            $parent = WarehouseLocation::find(
                $validated['parent_id']
            );

            if (!$parent || $parent->type !== 'zone') {
                return back()
                    ->withErrors([
                        'parent_id' =>
                            'Plauktu drīkst pievienot tikai noliktavas zonai.'
                    ])
                    ->withInput();
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
            ]
        );

        if ($validated['type'] === 'zone') {
            $validated['parent_id'] = null;
        }

        if (
            $validated['type'] === 'shelf' &&
            empty($validated['parent_id'])
        ) {
            return back()
                ->withErrors([
                    'parent_id' =>
                        'Plauktam jāizvēlas noliktavas zona.'
                ])
                ->withInput();
        }

        if ($validated['type'] === 'shelf') {

            $parent = WarehouseLocation::find(
                $validated['parent_id']
            );

            if (!$parent || $parent->type !== 'zone') {
                return back()
                    ->withErrors([
                        'parent_id' =>
                            'Plauktu drīkst pievienot tikai noliktavas zonai.'
                    ])
                    ->withInput();
            }
        }

        $warehouseLocation->update($validated);

        return redirect()
            ->route('warehouse-locations.index')
            ->with(
                'success',
                'Noliktavas atrašanās vieta veiksmīgi rediģēta.'
            );
    }

    public function destroy(WarehouseLocation $warehouseLocation)
    {
        if ($warehouseLocation->children()->exists()) {
            return redirect()
                ->route('warehouse-locations.index')
                ->with(
                    'error',
                    'Zonu nevar dzēst, kamēr tajā atrodas plaukti.'
                );
        }

        $warehouseLocation->delete();

        return redirect()
            ->route('warehouse-locations.index')
            ->with(
                'success',
                'Noliktavas atrašanās vieta veiksmīgi dzēsta.'
            );
    }
}