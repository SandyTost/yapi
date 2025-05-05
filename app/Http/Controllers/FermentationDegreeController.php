<?php

namespace App\Http\Controllers;

use App\Models\FermentationDegree;
use App\Http\Requests\FermentationDegree\{StoreFermentationDegreeRequest, UpdateFermentationDegreeRequest};

class FermentationDegreeController extends Controller
{
    /**
     * Добалвение новой степени ферментации
     */
    public function store(StoreFermentationDegreeRequest $request)
    {
        $validated = $request->validated();
        FermentationDegree::create([
            'name' => $validated['name'],
        ]);

        return redirect()->back()->with('success', 'Степень ферментации успешно добавлен!');
    }

    /**
     * Обновление степени ферментации
     */
    public function update(UpdateFermentationDegreeRequest $request, FermentationDegree $fermentationDegree)
    {
        $validated = $request->validated();
        $fermentationDegree->update([
            'name' => $validated['name'],
        ]);

        return redirect()->back()->with('success', 'Степень ферментации успешно изменена');
    }

    /**
     * Мягкое удаление степени ферментации
     */
    public function destroy(FermentationDegree $fermentationDegree)
    {
        $fermentationDegree->products()->each(function ($product) {
            $product->delete();
        });

        $fermentationDegree->delete();

        return back()->with('success', 'Степень ферментации и связанные товары удалены');
    }


    /**
     * Восставление удаленной степени ферментации
     */
    public function restore($fermentationDegree)
    {
        $fermentation = FermentationDegree::withTrashed()->findOrFail($fermentationDegree);
        $fermentation->restore();
        $fermentation->products()->onlyTrashed()->restore();

        return back()->with('success', 'Степень ферментации и связанные товары восстановлены');
    }
}
