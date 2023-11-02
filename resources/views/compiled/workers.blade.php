<div class="workers_list">
    
    @if(count($workers) < 1 && auth()->user() === null)
        <div class="title">
            <img src="" alt="">
            <h2>Ой, на сайте ни одного workers профиля</h2>
        </div>
        <p>Вы можете <a href="{{ route('login') }}">авторизоваться</a> и создать первый <b>профиль-workers</b> на сайте</p>
    @elseif(count($workers) > 0)
        @foreach($workers as $worker)
            <div class="worker">
                <div class="avatar">
                    @php    
                        echo $worker->url_avatar ? '<img src="'.$worker->url_avatar.'">':'<span uk-icon="icon: user; ratio:2"></span>';
                    @endphp
                </div>                
                <div class="content">
                    <h4>{{ $worker->name }}</h4>
                    <p>{{ $worker->about }}</p>
                    <ul class="links">
                        <li class='tel'>
                            <!-- <img src="/storage/general/vibrating-phone.png" alt="vibrating-phone"> -->
                            <a href="tel:{{ $worker->phone }}">{{ $worker->phone }}</a></li>
                        <!-- socials -->
                    </ul>                    
                </div>
                <div class="bg" style="background-image: url({{ $worker->url_avatar ?? '/storage/general/users2.png' }})"></div>
            </div>
        @endforeach
    @endif

</div>
<div class="paginastion">
    {{$workers->links()}}
</div>