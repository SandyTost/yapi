<?php

namespace App\Http\Controllers;

use App\Http\Requests\Product\{StoreProductRequest, UpdateProductRequest};
use App\Models\{
    TeaType,
    Product,
    OriginRegion,
    TeaVariety,
    FermentationDegree,
    StorageCondition
};
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Отображение католога
     */
    public function index(Request $request)
    {
        $query = Product::query();

        // Фильтрация по названию товара
        if ($request->has('search') && $request->input('search') != '') {
            $query->where('name', 'like', '%' . $request->input('search') . '%');
        }

        // Фильтрация по типу чая
        if ($request->has('tea-type')) {
            $query->where('tea_type_id', $request->input('tea-type'));
        }

        // Фильтрация по региону происхождения
        if ($request->has('origin')) {
            $query->where('origin_region_id', $request->input('origin'));
        }

        // Фильтрация по сорту чая
        if ($request->has('sort')) {
            $query->where('tea_variety_id', $request->input('sort'));
        }

        // Фильтрация по степени ферментации
        if ($request->has('fermentation')) {
            $query->where('fermentation_degree_id', $request->input('fermentation'));
        }

        // Фильтрация по цене
        if ($request->has('min-price') && $request->input('min-price') != '') {
            $query->where('price', '>=', $request->input('min-price'));
        }

        if ($request->has('max-price') && $request->input('max-price') != '') {
            $query->where('price', '<=', $request->input('max-price'));
        }

        // Получаем отфильтрованные товары с пагинацией
        $products = $query->paginate(12);

        // Загружаем все данные для фильтров
        $teaTypes = TeaType::all();
        $originRegions = OriginRegion::all();
        $teaVarieties = TeaVariety::all();
        $fermentationDegrees = FermentationDegree::all();

        return view('catalog', compact('products', 'teaTypes', 'originRegions', 'teaVarieties', 'fermentationDegrees'));
    }

    /**
     * Отображение формы добавления товара
     */
    public function create()
    {
        $teaTypes = TeaType::all();
        $originRegions = OriginRegion::all();
        $teaVarieties = TeaVariety::all();
        $fermentationDegrees = FermentationDegree::all();
        return view('admin.product.create', compact('teaTypes', 'originRegions', 'teaVarieties', 'fermentationDegrees'));
    }

    /**
     * Добавление товара
     */
    public function store(StoreProductRequest $request)
    {
        $validated = $request->validated();

        // Обработка загрузки изображения
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('product', 'public');
            $validated['image'] = 'storage/' . $imagePath;
        }

        // Найти или создать условие хранения
        $storageCondition = StorageCondition::firstOrCreate([
            'description' => trim($validated['storage']),
        ]);

        // Создание товара
        Product::create([
            'name' => $validated['name'],
            'description' => $validated['description'],
            'image' => $validated['image'],
            'price' => $validated['price'],
            'tea_type_id' => $validated['tea_type_id'],
            'origin_region_id' => $validated['origin_region_id'],
            'tea_variety_id' => $validated['tea_variety_id'],
            'fermentation_degree_id' => $validated['fermentation_degree_id'],
            'storage_condition_id' => $storageCondition->id,
        ]);

        return redirect()->route('admin.index')->with('success', 'Товар успешно добавлен');
    }


    /**
     * Отображение страницы продукта
     */
    public function show(Product $product)
    {
        return view('product', compact('product'));
    }

    /**
     * Открытие страницы редактирования товара
     */
    public function edit(Product $product)
    {
        // Получаем все необходимые данные для редактирования
        $teaTypes = TeaType::all();
        $originRegions = OriginRegion::all();
        $teaVarieties = TeaVariety::all();
        $fermentationDegrees = FermentationDegree::all();
        $storageConditions = StorageCondition::all(); // Условие хранения чая

        // Передаем все данные в представление
        return view('admin.product.edit', compact(
            'product',
            'teaTypes',
            'originRegions',
            'teaVarieties',
            'fermentationDegrees',
            'storageConditions'
        ));
    }

    /**
     * Обновление информации о товаре
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        // Получаем валидированные данные
        $validated = $request->validated();

        // Обработка изображения
        if ($request->hasFile('image')) {
            // Сохраняем изображение в директории "product" в публичном хранилище
            $imagePath = $request->file('image')->store('product', 'public');
            // Обновляем поле изображения в базе данных
            $validated['image'] = 'storage/' . $imagePath;
        }

        // Обновляем данные товара в базе
        $product->update([
            'name' => $validated['name'],
            'description' => $validated['description'],
            'price' => $validated['price'],
            'tea_type_id' => $validated['tea_type'],
            'origin_region_id' => $validated['origin'],
            'tea_variety_id' => $validated['sort'],
            'fermentation_degree_id' => $validated['fermentation'],
            'storage_condition_id' => $validated['storage'],
            'image' => $validated['image'] ?? $product->image,
        ]);

        return redirect()->route('products.edit', $product)->with('success', 'Товар успешно обновлен!');
    }

    /**
     * Удаление товара
     */
    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->back()->with('success', 'Товар успешно удален');
    }

    /**
     * Восстановление удаленного товара
     */
    public function restore($id)
    {
        // Используем withTrashed() для поиска удаленных товаров
        $product = Product::withTrashed()->findOrFail($id);
        $product->restore();

        return redirect()->back()->with('success', 'Товар успешно восстановлен');
    }
}
