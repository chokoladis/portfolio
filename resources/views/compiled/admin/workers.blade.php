@php
    use App\Http\Controllers\HelperController;
@endphp
@if(!$workers->count())
    <div class="result_query">
        {{ __('По данному запросу нет записей') }}
    </div>
@else
    <table class="uk-table">
        <thead>
            <tr>
                @foreach (trans('crud.Workers.fields_list_admin') as $filed_code => $trans)
                    <th>{{ $trans }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach($workers as $worker)
                @php 
                    $class = $worker->deleted_at ? 'deleted ' : '';
                    if ($worker->stats){
                        $class .= $worker->stats->viewed_admin_at ? '' : 'not_viewed_admin ';
                    }
                @endphp
                    <tr class="{{ $class }}">
                        <td>
                            {{  $worker->id  }} | {{  $worker->code  }}
                        </td>
                        <td>
                            @if ($worker->url_avatar)
                                <img src="{{ config('filesystems.clients.workers').$worker->url_avatar }}">
                            @else 
                                <span uk-icon="icon: user; ratio:2"></span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('admin.users.edit', $worker->user->id) }}">
                                {{ $worker->user->fio }}
                            </a>
                        </td>
                        <td style="min-width: 140px;">
                            <a href="tel:{{ $worker->phone }}">{{ HelperController::phoneOutFormated($worker->phone) }}</a>
                        </td>
                        <td>
                            <p class="short">
                                {{ $worker->about }}
                            </p>
                        </td>
                        <td>
                            {{  $worker->created_at  }}
                        </td>
                        <td>
                            @if (!$worker->deleted_at)
                                <div class="custom-btn clr-primary js_work_edit">
                                    <a href="{{ route('admin.workers.edit', $worker->code) }}">
                                        <span uk-icon="icon:pencil" title="{{ __('Редактировать') }}"></span>
                                    </a>
                                </div>
                                <div class="custom-btn clr-warning js_admin_work_del" data-route="{{ route('admin.workers.delete', $worker->code) }}">
                                    <span uk-icon="icon:crosshairs" title="{{ __('Пометить на удаление') }}"></span>
                                </div>
                            @else
                                <div class="custom-btn clr-danger js_admin_work_forceDel" data-route="{{ route('admin.workers.forceDelete', $worker->code) }}">
                                    <span uk-icon="icon:trash" title="{{ __('Удалить') }}"></span>
                                </div>
                                <div class="custom-btn clr-warning js_admin_work_restore" data-route="{{ route('admin.workers.restore', $worker->code) }}">
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
        {{$workers->links()}}
    </div>
@endif