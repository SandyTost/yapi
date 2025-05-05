<?php

namespace App\Http\Controllers;

use App\Models\OriginRegion;
use App\Http\Requests\OriginRegion\{StoreOriginRegionRequest, UpdateOriginRegionRequest};

class OriginRegionController extends Controller
{
    /**
     * Добавление нового региона происхождения
     */
    public function store(StoreOriginRegionRequest $request)
    {
        $validated = $request->validated();
        OriginRegion::create([
            'name' => $validated['name'],
        ]);

        return redirect()->back()->with('success', 'Регион происхождения успешно добавлен!');
    }

    /**
     * Обновление региона происхождения
     */
    public function update(UpdateOriginRegionRequest $request, OriginRegion $originRegion)
    {
        $validated = $request->validated();
        $originRegion->update([
            'name' => $validated['name'],
        ]);

        return redirect()->back()->with('success', 'Регион происхождения успешно изменен');
    }

    /**
     * Мягкое удаление региона
     */
    public function destroy(OriginRegion $originRegion)
    {
        $originRegion->products()->each(function ($product) {
            $product->delete();
        });

        $originRegion->delete();

        return back()->with('success', 'Регион и связанные товары удалены');
    }


    /**
     * Восстановление удаленного региона
     */
    public function restore($originRegion)
    {
        $region = OriginRegion::withTrashed()->findOrFail($originRegion);
        $region->restore();
        $region->products()->onlyTrashed()->restore();

        return back()->with('success', 'Регион и связанные товары восстановлены');
    }
}
