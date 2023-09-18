<div class="workers_list">
    
    @foreach($workers as $worker)
        <div class="work {{ $addClass }}" data-id="{{ $work->id }}">
            <!-- <div class="border"></div> -->
            <div class="content">
                <h3>{{  $work->title  }}</h3>
                <p>{{  $work->description  }}</p>
                <a href="{{ $work->url_work }}">{{ $work->url_work }}</a>
                @if (!empty($work->url_files))
                    <div class="works_gallery">
                        @foreach(explode(',', $work->url_files) as $filesPath)
                                @php 
                                    //if ($filesPath) $imgclass = (Storage::disk('s3')->exists($filesPath))?'':'img_404';
                                @endphp
                                <img src="/storage/works/img/{{ $filesPath }}" class="{{ $imgclass }}">
                        @endforeach
                    </div>
                @endif
            </div>
            <!-- todo -->
            <!-- how use multi can-methods ? -->
            @can('viewAdmin', auth()->user())
                <div class="area_actions">
                    <div class="custom-btn clr-danger js_work_del">
                        <span uk-icon="icon:trash" title="Удалить"></span>
                    </div>
                    <div class="custom-btn clr-primary js_work_edit">
                        <span uk-icon="icon:pencil" title="Редактировать"></span>
                    </div>
                </div>
            @endcan
        </div>
    @endforeach

</div>
<div class="paginastion">
    {{$workers->links()}}
</div>