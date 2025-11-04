@extends('layouts.app')

@section('title', 'Sửa bài viết')

@section('content')
<div class="card">
    <h1>Sửa bài viết</h1>
    <div class="body">
        @if ($errors->any())
            <div class="alert-error">Vui lòng kiểm tra lại các trường bên dưới.</div>
        @endif

        <form action="{{ route(request()->routeIs('admin.*') ? 'admin.articles.update' : 'articles.update', $article) }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div style="margin-bottom:10px;">
                <label>Tiêu đề</label><br>
                <input type="text" name="title" value="{{ old('title', $article->title) }}" style="width: 400px;">
                @error('title')
                    <div style="color:#b91c1c">{{ $message }}</div>
                @enderror
            </div>

            <div style="margin-bottom:10px;">
                <label>Nội dung</label><br>
                <textarea name="body" rows="6" style="width: 400px;">{{ old('body', $article->body) }}</textarea>
                @error('body')
                    <div style="color:#b91c1c">{{ $message }}</div>
                @enderror
            </div>

            <div style="margin-bottom:10px;">
                <label>Ảnh hiện tại</label><br>
                @if(!empty($article->image_path))
                    <img src="{{ asset('storage/'.$article->image_path) }}" alt="{{ $article->title }}" style="max-width:200px; height:auto; display:block; margin:6px 0;">
                @else
                    <span class="muted">Chưa có ảnh</span>
                @endif
            </div>

            <div style="margin-bottom:10px;">
                <label>Thay ảnh (tuỳ chọn)</label><br>
                <input type="file" name="image" accept=".jpg,.jpeg,.png">
                @error('image')
                    <div style="color:#b91c1c">{{ $message }}</div>
                @enderror
            </div>

            <div style="margin-bottom:10px;">
                <label>Tags (tuỳ chọn)</label><br>
                <input type="text" name="tags" value="{{ old('tags', $article->tags) }}" style="width: 400px;">
                @error('tags')
                    <div style="color:#b91c1c">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit">Cập nhật</button>
            <a class="btn-link" href="{{ route(request()->routeIs('admin.*') ? 'admin.articles.index' : 'articles.index') }}" style="margin-left:8px;">Danh sách</a>
        </form>
    </div>
</div>
@endsection
