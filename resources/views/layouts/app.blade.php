<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', config('app.name', 'Laravel'))</title>
    @if (file_exists(public_path('build/manifest.json')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
    <style>
        body { font-family: Arial, Helvetica, sans-serif; margin:0; }
        nav.top { background:#0f172a; color:#fff; padding:10px 16px; display:flex; gap:12px; align-items:center; }
        nav.top a { color:#cbd5e1; text-decoration:none; }
        nav.top a:hover { color:#fff; text-decoration:underline; }
        nav.top .spacer { flex:1; }
        .container { max-width: 1000px; margin: 16px auto; }
        .card { border:1px solid #e5e7eb; background:#fff; }
        .card h1 { margin:0; padding:16px; font-size:22px; }
        .card .body { padding: 0 16px 16px 16px; }
        .alert-success { color:#065f46; background:#d1fae5; padding:8px; margin:0 0 12px 0; }
        .alert-error { color:#b91c1c; background:#fee2e2; padding:8px; margin:0 0 12px 0; }
        .muted { color:#6b7280; }
        form.inline { display:inline; }
        button.link { background:none; border:none; color:#cbd5e1; cursor:pointer; padding:0; }
        button.link:hover { color:#fff; text-decoration:underline; }
    </style>
</head>
<body>
<nav class="top">
    <a href="/">Trang chủ</a>
    <a href="{{ route('articles.index') }}">Bài viết</a>

    @auth
        <a href="{{ route('articles.create') }}">Viết bài</a>
        @if(auth()->user()->is_admin ?? false)
            <a href="{{ route('admin.articles.index') }}">Quản trị</a>
            <a href="{{ route('admin.articles.create') }}">Tạo bài (Admin)</a>
        @endif
        <span class="spacer"></span>
        <span class="muted">{{ auth()->user()->name }}</span>
        <form class="inline" method="POST" action="{{ route('logout') }}">@csrf
            <button type="submit" class="link">Đăng xuất</button>
        </form>
    @endauth

    @guest
        <span class="spacer"></span>
        <a href="{{ route('login') }}">Đăng nhập</a>
        <a href="{{ route('register') }}">Đăng ký</a>
    @endguest
</nav>

<div class="container">
    @hasSection('content')
        @yield('content')
    @else
        {{ $slot ?? '' }}
    @endif

    <footer style="text-align:center; color:#6b7280; font-size:12px; padding:12px 0;">
        © HUIT – Khoa CNTT. Laravel 12 Lab.
    </footer>
</div>
</body>
</html>
