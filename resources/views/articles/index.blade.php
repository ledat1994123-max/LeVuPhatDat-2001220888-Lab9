@extends('layouts.app')

@section('title', 'Danh sách bài viết')

@section('content')
<div class="card">
    <h1>Danh sách bài viết</h1>
    <div class="body">
        @if (session('success'))
            <div class="alert-success">{{ session('success') }}</div>
        @endif
        <table>
            <thead>
                <tr>
                    <th style="width:60px;">ID</th>
                    <th>Tiêu đề</th>
                    <th style="width:260px;">Hình ảnh</th>
                    <th style="width:200px;">Hành động</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($articles as $article)
                    <tr>
                        <td>{{ $article->id }}</td>
                        <td>{{ $article->title }}</td>
                        <td>
                            @if(!empty($article->image_path))
                                <img src="{{ asset('storage/'.$article->image_path) }}" alt="{{ $article->title }}" style="max-width:200px; height:auto; display:block; margin:6px auto;">
                            @endif
                        </td>
                        <td>
                            {{-- Link Xem: dùng route theo ngữ cảnh (admin.* hay công khai) --}}
                            <a class="btn-link" href="{{ route(request()->routeIs('admin.*') ? 'admin.articles.show' : 'articles.show', $article) }}">Xem</a>
                            @if (request()->routeIs('admin.*'))
                                |
                                <a class="btn-link" href="{{ route('admin.articles.edit', $article) }}">Sửa</a>
                                |
                                <form action="{{ route('admin.articles.destroy', $article) }}" method="post" style="display:inline" onsubmit="return confirm('Bạn chắc chắn muốn xoá?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-link" style="background:none;border:none;padding:0;cursor:pointer">Xoá</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4">Chưa có bài viết.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
