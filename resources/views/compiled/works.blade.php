<div class="works_list">
    
    @foreach($works as $work)
        @php 
            $addClass = (!empty($work->url_files))?' work_have_preview':'';
        @endphp
        <div class="work {{ $addClass }}" data-id="{{ $work->id }}">
            <!-- <div class="border"></div> -->
            <div class="content">
                <h3>{{  $work->title  }}</h3>
                <p>{{  $work->description  }}</p>
                <a href="{{ $work->url_work }}">{{ $work->url_work }}</a>
                <!-- <h3>{{  $work->title  }}</h3> -->
                @if (!empty($work->url_files))
                    @foreach(explode(',', $work->url_files) as $filesPath)
                        <img src="{{ $filesPath }}" alt="" class="work_preview">
                    @endforeach
                @endif
            </div>
            <div class="work_actions">
                <div class="work_action custom-btn clr-danger js_work_del">
                    <span uk-icon="icon:trash"></span>
                </div>
                <div class="work_action custom-btn">
                    <span uk-icon="icon:pencil"></span>
                </div>
            </div>
        </div>
    @endforeach

</div>