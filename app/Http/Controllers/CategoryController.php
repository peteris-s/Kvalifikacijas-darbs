<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Validation\Rule;

class CategoryController extends Controller
{
    /**
     * Parāda visas kategorijas hierarhiskā secībā.
     */
    public function index()
    {
        $allCategories = Category::with([
                'parent',
                'children',
            ])
            ->withCount([
                'products',
                'children',
            ])
            ->orderBy('name')
            ->get();

        /*
         * Sakārtojam kategorijas hierarhiski:
         *
         * Elektronika
         *   Datori
         *     Portatīvie datori
         */
        $categories = collect();

        $rootCategories = $allCategories
            ->whereNull('parent_id')
            ->sortBy('name');

        foreach ($rootCategories as $rootCategory) {
            $this->addCategoryWithChildren(
                $rootCategory,
                $allCategories,
                $categories
            );
        }

        return view(
            'categories.index',
            compact('categories')
        );
    }


    /**
     * Rekursīvi pievieno kategoriju un tās
     * apakškategorijas pareizajā secībā.
     */
    private function addCategoryWithChildren(
        Category $category,
        Collection $allCategories,
        Collection $result
    ): void {
        $result->push($category);

        $children = $allCategories
            ->where('parent_id', $category->id)
            ->sortBy('name');

        foreach ($children as $child) {
            $this->addCategoryWithChildren(
                $child,
                $allCategories,
                $result
            );
        }
    }


    /**
     * Parāda kategorijas pievienošanas formu.
     */
    public function create()
    {
        $categories = Category::with('parent')
            ->orderBy('name')
            ->get();

        return view(
            'categories.create',
            compact('categories')
        );
    }


    /**
     * Saglabā jaunu kategoriju.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'parent_id' => [
                'nullable',
                'integer',
                'exists:categories,id',
            ],

            'name' => [
                'required',
                'string',
                'max:255',
                'unique:categories,name',
            ],

            'description' => [
                'nullable',
                'string',
                'max:1000',
            ],
        ]);


        Category::create([
            'parent_id' => $validated['parent_id'] ?? null,
            'name' => $validated['name'],
            'description' => $validated['description'] ?? null,
        ]);


        return redirect()
            ->route('categories.index')
            ->with(
                'success',
                'Kategorija veiksmīgi pievienota.'
            );
    }


    /**
     * Parāda kategorijas rediģēšanas formu.
     */
    public function edit(Category $category)
    {
        $categories = Category::with('parent')
            ->where('id', '!=', $category->id)
            ->orderBy('name')
            ->get();

        return view(
            'categories.edit',
            compact('category', 'categories')
        );
    }


    /**
     * Saglabā kategorijas izmaiņas.
     */
    public function update(
        Request $request,
        Category $category
    ) {
        $validated = $request->validate([
            'parent_id' => [
                'nullable',
                'integer',
                'exists:categories,id',
                Rule::notIn([$category->id]),
            ],

            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('categories', 'name')
                    ->ignore($category->id),
            ],

            'description' => [
                'nullable',
                'string',
                'max:1000',
            ],
        ]);


        /*
         * Neļaujam izveidot ciklisku hierarhiju.
         *
         * Piemēram:
         *
         * Elektronika
         *   └── Datori
         *
         * Elektroniku nedrīkst pārvietot
         * zem kategorijas "Datori".
         */
        if (!empty($validated['parent_id'])) {

            $newParent = Category::findOrFail(
                $validated['parent_id']
            );

            $currentParent = $newParent;

            while ($currentParent !== null) {

                if ($currentParent->id === $category->id) {

                    return back()
                        ->withInput()
                        ->withErrors([
                            'parent_id' =>
                                'Kategoriju nevar ievietot zem tās pašas apakškategorijas.',
                        ]);
                }

                $currentParent = $currentParent->parent;
            }
        }


        $category->update([
            'parent_id' => $validated['parent_id'] ?? null,
            'name' => $validated['name'],
            'description' => $validated['description'] ?? null,
        ]);


        return redirect()
            ->route('categories.index')
            ->with(
                'success',
                'Kategorija veiksmīgi rediģēta.'
            );
    }


    /**
     * Dzēš kategoriju.
     */
    public function destroy(Category $category)
    {
        /*
         * Neļaujam dzēst kategoriju,
         * ja tai ir piesaistītas preces.
         */
        if ($category->products()->exists()) {

            return redirect()
                ->route('categories.index')
                ->with(
                    'error',
                    'Kategoriju nevar dzēst, jo tai ir piesaistītas preces.'
                );
        }


        /*
         * Neļaujam dzēst kategoriju,
         * ja tai ir apakškategorijas.
         */
        if ($category->children()->exists()) {

            return redirect()
                ->route('categories.index')
                ->with(
                    'error',
                    'Kategoriju nevar dzēst, jo tai ir apakškategorijas.'
                );
        }


        $category->delete();


        return redirect()
            ->route('categories.index')
            ->with(
                'success',
                'Kategorija veiksmīgi dzēsta.'
            );
    }
}