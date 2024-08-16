@php
    use App\Http\Controllers\HelperController;
@endphp
@if(!$workers->count())
    <div class="result_query">
        {{ __('По данному запросу нет записей') }}
    </div>
@else
    <div class="workers_list">
        
        @if(count($workers) < 1 && auth()->user() === null)
            <div class="title">
                <img src="" alt="">
                <h2>Ой, на сайте ни одного workers профиля</h2>
            </div>
            <p>Вы можете <a href="{{ route('login') }}">авторизоваться</a> и создать первый <b>профиль-workers</b> на сайте</p>
        @elseif(count($workers) > 0)
            @foreach($workers as $worker)
                <div class="worker" onclick="location.href='{{ route('workers.detail', $worker->code) }}'">
                    <div class="avatar">
                        @php    
                            echo $worker->url_avatar ? '<img src="'.config('filesystems.img.workers').$worker->url_avatar.'">':'<span uk-icon="icon: user; ratio:2"></span>';
                        @endphp
                    </div>                
                    <div class="content">
                        <h4>{{ $worker->user->fio }}</h4>
                        <p>{{ $worker->about }}</p>
                        <ul class="links">
                            <li class='link-tel'>
                                <a href="tel:{{ $worker->phone }}">{{ HelperController::phoneOutFormated($worker->phone) }}</a></li>
                                @php
                                    if ($worker->socials !== null){
                                        $arSocials = json_decode($worker->socials, 1);

                                        foreach($arSocials as $socialKey => $link){
                                            $link = htmlspecialchars($link);
                                            $socialKey = htmlspecialchars($socialKey);
                                            echo '<li class="social '.$socialKey.'"><a href="'.$link.'" title="'.$link.'"></a></li>';
                                        }
                                    }
                                @endphp
                        </ul>
                        <div class="addition_info">
                            <div class="date">
<<<<<<< Updated upstream
                                {{ $worker->created_at->format('d.m.Y H:i') }} 
                            </div>
                            <span class="splash">|</span>
                            <div class="views">
                                <span uk-icon="eye"></span> {{ $worker->view_count }}
=======
                                {{ $worker->created_at->diffForHumans() }} 
                            </div>
                            <span class="splash">|</span>
                            <div class="views">
                                <span uk-icon="eye"></span> {{ $worker->stats?->view_count }}
>>>>>>> Stashed changes
                            </div>
                        </div>
                    </div>
                    <div class="bg" style="background-image: url({{ $worker->url_avatar 
                        ? config('filesystems.img.workers').$worker->url_avatar 
                        : '/storage/general/users2.png' }})"></div>
                </div>
            @endforeach
        @endif

    </div>
    <div class="paginastion">
        {{$workers->links()}}
    </div>
@endif