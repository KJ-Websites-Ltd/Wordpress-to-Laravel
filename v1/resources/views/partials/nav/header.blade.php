<nav class="nav header">

    @foreach($items as $item )
        <a href="/{{ $item['object_slug'] }}.html" data-id="{{ $item['object_slug'] }}">{{ $item['title'] }}</a>
    @endforeach
</nav>
