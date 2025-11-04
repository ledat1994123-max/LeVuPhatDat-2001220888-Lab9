<?php

namespace App\Http\Controllers;
use App\Http\Requests\StoreArticleRequest;
use App\Http\Requests\UpdateArticleRequest;
use App\Models\Article;
use Illuminate\Support\Facades\Storage;

class ArticleController extends Controller
{
    // Hiển thị form tạo bài viết
    public function create()
    {
        return view('articles.create');
    }

    // Hiển thị danh sách bài viết
    public function index()
    {
        $articles = Article::latest()->get();
        return view('articles.index', compact('articles'));
    }

    public function store(StoreArticleRequest $request)
    {
        $data = $request->validated();
        // Xử lý ảnh (nếu có)
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('articles', 'public');
            $data['image_path'] = $path;
        }
        $article = Article::create($data);

        $isAdminRoute = $request->routeIs('admin.*');
        return redirect()->route($isAdminRoute ? 'admin.articles.index' : 'articles.index')
            ->with('success', 'Tạo bài viết thành công');
    }

    // Trang chi tiết bài viết
    public function show(Article $article)
    {
        return view('articles.show', compact('article'));
    }

    // Hiển thị form sửa
    public function edit(Article $article)
    {
        return view('articles.edit', compact('article'));
    }

    // Cập nhật bài viết
    public function update(UpdateArticleRequest $request, Article $article)
    {
        $data = $request->validated();
        if ($request->hasFile('image')) {
            if (!empty($article->image_path) && Storage::disk('public')->exists($article->image_path)) {
                Storage::disk('public')->delete($article->image_path);
            }
            $data['image_path'] = $request->file('image')->store('articles', 'public');
        }
        $article->update($data);

        $isAdminRoute = $request->routeIs('admin.*');
        return redirect()->route($isAdminRoute ? 'admin.articles.show' : 'articles.show', $article)
            ->with('success', 'Cập nhật bài viết thành công');
    }

    // Xoá bài viết
    public function destroy(Article $article)
    {
        $isAdminRoute = request()->routeIs('admin.*');
        if (!empty($article->image_path) && Storage::disk('public')->exists($article->image_path)) {
            Storage::disk('public')->delete($article->image_path);
        }
        $article->delete();

        return redirect()->route($isAdminRoute ? 'admin.articles.index' : 'articles.index')
            ->with('success', 'Xoá bài viết thành công');
    }
}
