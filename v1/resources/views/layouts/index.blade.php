<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>@yield('title') :: {{  config('app.name') }}</title>
</head>
<body>

<header>
    <h1>{{ config('app.name') }}</h1>

    <nav>
        @foreach($nav['header-menu']['items'] as $item )
            <a href="/{{ $item['object_slug'] }}.html" data-id="{{ $item['object_slug'] }}">{{ $item['title'] }}</a>
        @endforeach
    </nav>

</header>


<article>
    @yield('article')
</article>

<footer>

    <h1>{{ config('app.name') }}</h1>

    <nav>
        @foreach($nav['footer-menu']['items'] as $item )
            <a href="/{{ $item['object_slug'] }}.html" data-id="{{ $item['object_slug'] }}">{{ $item['title'] }}</a>
        @endforeach
    </nav>


</footer>


</body>
</html>
