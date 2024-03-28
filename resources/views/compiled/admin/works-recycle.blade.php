@if(!$works->count())
    <div class="result_query">
        {{ __('По данному запросу нет записей') }}
    </div>
@else
    <table class="uk-table">
        <thead>
            <tr>
                <th></th>
                @foreach (trans('crud.Example_work.fields_admin') as $filed_code => $trans)
                    <th>{{ $trans }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach($works as $work)
                @php 
                    $class = '';
                    if (str_contains($work->url_work, 'https://') ||
                        str_contains($work->url_work, 'http://')){
                        $link = $work->url_work;
                    } else {
                        $link = 'https://'.$work->url_work;
                    }

                    if ($work->stats){
                        $class = $work->stats->viewed_admin_at ? '' : 'not_viewed_admin ';
                    }
                @endphp
                    <tr class="deleted {{ $class }}">
                        <td>
                            <input type="checkbox" name="work-action" id="{{ $work->id }}" class="uk-checkbox work-action-checkbox">
                        </td>
                        <td>
                            {{  $work->id  }} | {{  $work->slug  }}
                        </td>
                        <td>
                            {{ $work->user->name }}
                        </td>
                        <td class="js_title_work">
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
                            @if (!$work->deleted_at)
                                <div class="custom-btn clr-primary js_work_edit">
                                    <a href="{{ route('admin.works.edit', $work->slug) }}">
                                        <span uk-icon="icon:pencil" title="{{ __('Редактировать') }}"></span>
                                    </a>
                                </div>
                                <div class="custom-btn clr-warning js_admin_work_del" data-route="{{ route('admin.works.delete', $work->slug) }}">
                                    <span uk-icon="icon:crosshairs" title="{{ __('Пометить на удаление') }}"></span>
                                </div>
                            @else
                                <div class="custom-btn clr-danger js_admin_work_forceDel" data-route="{{ route('admin.works.forceDelete', $work->slug) }}">
                                    <span uk-icon="icon:trash" title="{{ __('Удалить') }}"></span>
                                </div>
                                <div class="custom-btn clr-warning js_admin_work_restore" data-route="{{ route('admin.works.restore', $work->slug) }}">
                                    <span uk-icon="icon:history" title="{{ __('Вернуть') }}"></span>
                                </div>                            
                            @endif
                                                                                   
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