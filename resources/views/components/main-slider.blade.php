@php
    use Illuminate\Support\Facades\Route;
@endphp

@props(['folder'])

@php
    if (!isset($folder))
        return true;

    $files = \App\Http\Controllers\HelperController::getMainSliderFiles($folder);
@endphp

<div class="slider" id="main-slider" uk-slider="autoplay:true, autoplay-interval: 4000, finity:true, pause-on-hover: true">
    <div class="uk-container">
        <div class="uk-slider-items uk-grid">
{{--            uk-child-width-1-1--}}
            @foreach ($files as $item)
                <div class="slide">
                    <img src="{{ $item }}" alt="slide-image">
                </div>
            @endforeach
        </div>
    </div>
</div>
