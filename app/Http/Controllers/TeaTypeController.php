<?php

namespace App\Http\Controllers;

use App\Models\TeaType;
use App\Http\Requests\TeaType\{StoreTeaTypeRequest, UpdateTeaTypeRequest};

class TeaTypeController extends Controller
{
    /**
     * Создание нового типа чая
     */
    public function store(StoreTeaTypeRequest $request)
    {
        $validated = $request->validated();
        TeaType::create([
            'name' => $validated['name'],
        ]);

        return redirect()->back()->with('success', 'Тип чая успешно добавлен!');
    }

    /**
     * Обновление типа чая
     */
    public function update(UpdateTeaTypeRequest $request, TeaType $teaType)
    {
        $validated = $request->validated();
        $teaType->update([
            'name' => $validated['name'],
        ]);

        return redirect()->back()->with('success', 'Тип чая успешно изменен');
    }

    /**
     * Мягкое удаление типа чая
     */
    public function destroy(TeaType $teaType)
    {
        $teaType->products()->each(function ($product) {
            $product->delete();
        });

        $teaType->delete();

        return back()->with('success', 'Тип чая и связанные товары удалены');
    }

    /**
     * Восстановление удаленного типа чая
     */
    public function restore($id)
    {
        $teaType = TeaType::withTrashed()->findOrFail($id);
        $teaType->restore();

        $teaType->products()->onlyTrashed()->restore();

        return back()->with('success', 'Тип чая и связанные товары восстановлены');
    }
}
