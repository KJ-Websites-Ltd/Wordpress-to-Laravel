<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>@yield('title') :: {{  config('app.name') }}</title>
</head>
<body>

@component('partials.header', ['title' => config('app.name'), 'nav' =>  $nav['header-menu']['items'] ])
@endcomponent


<article>
    @yield('article')
</article>

@component('partials.footer', ['title' => config('app.name'), 'nav' =>  $nav['footer-menu']['items'] ])
@endcomponent


</body>
</html>
