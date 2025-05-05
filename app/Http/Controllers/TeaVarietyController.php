<?php

namespace App\Http\Controllers;

use App\Models\TeaVariety;
use App\Http\Requests\TeaVariety\{StoreTeaVarietyRequest, UpdateTeaVarietyRequest};

class TeaVarietyController extends Controller
{
    /**
     * Добавление нового сорта чая
     */
    public function store(StoreTeaVarietyRequest $request)
    {
        $validated = $request->validated();
        TeaVariety::create([
            'name' => $validated['name'],
        ]);

        return redirect()->back()->with('success', 'Сорт чая успешно добавлен!');
    }

    /**
     * Обновление сорта чая
     */
    public function update(UpdateTeaVarietyRequest $request, TeaVariety $teaVariety)
    {
        $validated = $request->validated();
        $teaVariety->update([
            'name' => $validated['name'],
        ]);

        return redirect()->back()->with('success', 'Сорт чая успешно изменен');
    }

    /**
     * Мягкое удаление сорта чая
     */
    public function destroy(TeaVariety $teaVariety)
    {
        $teaVariety->products()->each(function ($product) {
            $product->delete();
        });

        $teaVariety->delete();

        return back()->with('success', 'Сорт чая и связанные товары удалены');
    }

    /**
     * Восстановление удаленного сорта чая
     */
    public function restore($teaVariety)
    {
        $variety = TeaVariety::withTrashed()->findOrFail($teaVariety);
        $variety->restore();
        $variety->products()->onlyTrashed()->restore();

        return back()->with('success', 'Сорт чая и связанные товары восстановлены');
    }
}
