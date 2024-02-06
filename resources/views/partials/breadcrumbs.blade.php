<ul class="uk-breadcrumb">
    @foreach ($breadcrumbs as $breadcrumb)
        @if (!is_null($breadcrumb->url) && !$loop->last)
            <li><a href="{{ $breadcrumb->url }}">{{ $breadcrumb->title }}</a></li>
        @else
            <li class="active"><span>{{ $breadcrumb->title }}</span></li>
        @endif
    @endforeach
</ul>