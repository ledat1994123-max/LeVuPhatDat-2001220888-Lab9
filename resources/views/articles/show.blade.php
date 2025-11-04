@extends('layouts.app')

@section('title', $article->title)

@section('content')
<div class="card">
    <h1>{{ $article->title }}</h1>
    <div class="body">
        @if (session('success'))
            <div class="alert-success">{{ session('success') }}</div>
        @endif

        @if(!empty($article->image_path))
            <p>
                <img src="{{ asset('storage/'.$article->image_path) }}" alt="{{ $article->title }}" style="max-width:600px; height:auto;">
            </p>
        @endif

        <div style="white-space:pre-wrap; line-height:1.6;">{{ $article->body }}</div>

        @if(!empty($article->tags))
            <p class="muted" style="margin-top:8px;">Tags: {{ $article->tags }}</p>
        @endif

        <p style="margin-top:12px;">
            @if (request()->routeIs('admin.*'))
                <a class="btn-link" href="{{ route('admin.articles.edit', $article) }}">Sửa</a>
                |
                <a class="btn-link" href="{{ route('admin.articles.index') }}">Danh sách</a>
            @else
                <a class="btn-link" href="{{ route('articles.index') }}">Danh sách</a>
            @endif
        </p>
    </div>
</div>
@endsection
