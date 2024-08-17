@php
    use Illuminate\Support\Facades\Route; 
@endphp

@props(['route', 'a_class'])

@php     
    $a_class = $a_class ?? '' ;
    $route_out_slesh = mb_substr($route,0,1) == '/' ? mb_substr( $route, 1, mb_strlen($route) - 1 ) : $route;
    $is_active = request()->is($route_out_slesh) || Route::is($route) ? true : false; 
@endphp

<li {{ $attributes->class([
        ( $is_active ? 'animated active' : 'animated')
    ])  }}>
    <a class="{{ $a_class }}" href="{{ $route }}">{{ $slot }}</a>
</li>