<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\NewsRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\News;

class NewsController extends Controller
{
    public function create() {
        return view('admin.news.create');
    }

    public function store(NewsRequest $request)
    {
        // Получаем валидированные данные
        $validated = $request->validated();
        $validated['user_id'] = Auth::id();

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('news_images', 'public');
        }

        $news = News::create($validated);
        return redirect()->route('news')->with('success', 'Новость успешно добавлена!');
    }

    public function destroy(News $news) {
        $news->delete();
        return redirect()->route('news')->with('success', 'Новость успешно удалена!');
    }

    public function edit(News $news) {
        return view('admin.news.edit', [
            'news' => $news,
        ]);
    }

    public function update(Request $request, News $news) {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('image')) {
            if ($news->image) {
                Storage::delete($news->image);
            }
            $data['image'] = $request->file('image')->store('news_images', 'public');
        }

        $news->update($data);

        return redirect()->route('news', $news)->with('success', 'Новость успешно обновлена');
    }
}
