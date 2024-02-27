@if(!$works->count())
    <div class="result_query">
        {{ __('По данному запросу нет записей') }}
    </div>
@else
    <table class="uk-table">
        <thead>
            <tr>
                @foreach (trans('crud.Example_work.fields_admin') as $filed_code => $trans)
                    <th>{{ $trans }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach($works as $work)
                @php 
                    if (str_contains($work->url_work, 'https://') ||
                        str_contains($work->url_work, 'http://')){
                        $link = $work->url_work;
                    } else {
                        $link = 'https://'.$work->url_work;
                    }
                @endphp
                    <tr>
                        <td>
                            {{  $work->id  }} | {{  $work->slug  }}
                        </td>
                        <td>
                            {{ $work->user->name }}
                        </td>
                        <td>
                            {{  $work->title  }}
                        </td>
                        <td>
                            {{  $work->description  }}
                        </td>
                        <td>
                            <a href="{{ $link }}" class="link">
                                <span uk-icon="icon:location" title="{{ __('Ссылка на результат') }}"></span>
                                <i>{{ $work->url_work }}</i>
                            </a>
                        </td>
                        <td>
                            {{  $work->created_at  }}
                        </td>
                        <td>
                            {{-- todo rework --}}
                            <div class="custom-btn clr-primary js_work_edit">
                                <a href="{{ route('admin.work.edit', $work->slug) }}">{{ __('Редактировать') }}</a>
                            </div>
                            <div class="custom-btn clr-danger js_work_del">
                                <a href="{{ route('admin.work.delete', $work->slug) }}">{{ __('Удалить') }}</a>
                            </div>                                                            
                        </td>
                    </tr>
                </div>
            @endforeach
        </tbody>
    </table>
    <div class="paginastion">
        {{$works->links()}}
    </div>
@endif