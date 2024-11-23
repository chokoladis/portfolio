@php
    use \App\Services\FileService;
@endphp
@if($works->count())
    <div class="works_list">
        @foreach($works as $work)
            @php
//                url_files -> files

                if (!empty($work->files)){
                    $arFilesId = json_encode($work->files, 1);
                    $previewId = $arFilesId[0];

//                    $preview = FileService::getById($previewId);
                    $preview = $previewId;
                }

//                $previewUrl = $preview ? $preview->path.'/'.$preview->name : FileService::DEFAULT_IMG_PATH;
                $previewUrl = $preview ? $preview : FileService::DEFAULT_IMG_PATH;

                $urlWork = getCorrectUrl($work->url_work);
                $views = getCorrectCountViews($work->stats?->view_count);
            @endphp
            <div class="work" data-id="{{ $work->slug }}">
                <div class="content" onclick="location.href='{{ route('work.detail', $work->slug) }}'">
                    <h3>{{  $work->title  }}</h3>
                    <p>{{  $work->description  }}</p>
                    @if($urlWork)
                        <a href="{{ $urlWork }}" class="link">
                            <span uk-icon="icon:location" title="{{ __('Ссылка')}}"></span>
                            <i>{{ $work->url_work }}</i>
                        </a>
                    @endif
                    @if (!empty($work->url_files))
                        <div class="works_gallery">
                            @php
                                foreach(explode(',', $work->url_files) as $filesPath){
                                    if (is_image($filesPath)){
                                        echo '<img src="'. config('filesystems.clients.Example_work').trim($filesPath).'">';
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
@else
    <div class="result_query">
        {{ __('По данному запросу нет записей') }}
    </div>
@endif
