@if(!$works->count())
    <div class="result_query">
        {{ __('По данному запросу нет записей') }}
    </div>
@else
    <div class="works_list">
        @foreach($works as $work)
            @php
                $addClass = (!empty($work->url_files))?' work_have_preview':'';
                $imgclass = '';

                if (str_contains($work->url_work, 'https://') ||
                    str_contains($work->url_work, 'http://')){
                    $link = $work->url_work;
                } else {
                    $link = 'https://'.$work->url_work;
                }

                $views = $work->stats?->view_count;
                                    
                if ($views) {
                    $views = $views > 1000 ? $views / 1000 . 'k' : $views;
                } else {
                    $views = '-';
                }
            @endphp
            <div class="work {{ $addClass }}" data-id="{{ $work->slug }}">
                <div class="content" onclick="location.href='{{ route('work.detail', $work->slug) }}'">
                    <h3>{{  $work->title  }}</h3>
                    <p>{{  $work->description  }}</p>
                    <a href="{{ $link }}" class="link">
                        <span uk-icon="icon:location" title="{{ __('Ссылка')}}"></span>
                        <i>{{ $work->url_work }}</i>
                    </a>
                    @if (!empty($work->url_files))
                        <div class="works_gallery">
                            @php
                                foreach(explode(',', $work->url_files) as $filesPath){
                                    if (is_image($filesPath)){
                                        echo '<img src="'. config('filesystems.clients.works').trim($filesPath).'" class="'.$imgclass.'">';
                                    }
                                }
                            @endphp
                        </div>
                    @endif
                    <div class="addition_info">
                        <div class="date">
                            {{ $work->created_at->diffForHumans() }} 
                        </div>
                        <span class="splash">|</span>
                        <div class="views">
                            <span uk-icon="eye"></span> {{ $views }}
                        </div>
                    </div>
                </div>
                @can('viewAdmin', auth()->user())
                    <div class="area_actions">
                        <div class="custom-btn clr-danger js_work_del">
                            <span uk-icon="icon:trash" title="{{ __('Удалить')}}"></span>
                        </div>
                        <div class="custom-btn clr-primary js_work_edit">
                            <span uk-icon="icon:pencil" title="{{ __('Редактировать')}}"></span>
                        </div>
                    </div>
                @endcan
            </div>
        @endforeach

    </div>
    <div class="paginastion">
        {{$works->links()}}
    </div>
@endif