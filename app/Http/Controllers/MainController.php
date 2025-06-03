<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{TeaType, Product, OriginRegion, TeaVariety, FermentationDegree, News};
use App\Exports\OrdersExport;
use App\Exports\OrdersDetailExport;
use Maatwebsite\Excel\Facades\Excel;

class MainController extends Controller
{
    // Отображение главной страницы
    public function index()
    {
        // Получаем случайные 4 товара
        $randomProducts = Product::inRandomOrder()->limit(4)->get();
        $randomNews = News::inRandomOrder()->limit(4)->get();

        return view('index', compact('randomProducts', 'randomNews'));
    }

    // Отображение страницы новостей

    public function news(Request $request)
    {
        $sortBy = $request->get('sort', 'created_at');
        $sortOrder = $request->get('order', 'desc');

        // Валидация параметров сортировки
        $allowedSortFields = ['created_at', 'title', 'updated_at'];
        $allowedSortOrders = ['asc', 'desc'];

        if (!in_array($sortBy, $allowedSortFields)) {
            $sortBy = 'created_at';
        }

        if (!in_array($sortOrder, $allowedSortOrders)) {
            $sortOrder = 'desc';
        }

        $news = News::with('user')
            ->orderBy($sortBy, $sortOrder)
            ->get();

        return view('news', compact('news', 'sortBy', 'sortOrder'));
    }

    // Отображение страницы 'О нас'
    public function about()
    {
        return view('about');
    }

    // Отображение страницы контактов
    public function contact()
    {
        return view('contact');
    }

    // Отображение страницы администратора
    public function admin()
    {
        $products = Product::withTrashed()->paginate(12);
        $teaTypes = TeaType::withTrashed()->get();
        $originRegions = OriginRegion::withTrashed()->get();
        $teaVarieties = TeaVariety::withTrashed()->get();
        $fermentationDegrees = FermentationDegree::withTrashed()->get();
        return view('admin.index', compact('products', 'teaTypes', 'originRegions', 'teaVarieties', 'fermentationDegrees'));
    }

    /**
     * Экспорт заказов в Excel
     */
    public function export(Request $request)
    {
        // Получаем параметры фильтрации
        $dateFrom = $request->input('date_from');
        $dateTo = $request->input('date_to');
        $status = $request->input('status');

        // Формируем имя файла
        $fileName = 'orders_report_' . date('Y-m-d') . '.xlsx';

        // Определяем тип отчета (обычный или детальный)
        $detailed = $request->has('detailed');

        if ($detailed) {
            return Excel::download(new OrdersDetailExport(null, $dateFrom, $dateTo, $status), $fileName);
        } else {
            return Excel::download(new OrdersExport(null, $dateFrom, $dateTo, $status), $fileName);
        }
    }
}
