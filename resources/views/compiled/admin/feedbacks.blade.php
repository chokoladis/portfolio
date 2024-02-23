@if(!$feedbacks->count())
    <div class="result_query">
        {{ __('По данному запросу нет записей') }}
    </div>
@else
    <table class="uk-table">
        <thead>
            <tr>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach($feedbacks as $item)
                <tr>
                    <td>
                        {{  $item->id  }}
                    </td>
                    <td>
                        {{  $item->id_address  }}
                    </td>
                    <td>
                        {{  $item->fio  }}
                    </td>
                    <td>
                        <a href="mailto:{{ $item->mail }}" class="link">
                            <i>{{ $item->mail }}</i>
                        </a>
                    </td>
                    <td>
                        {{  $item->phone  }}
                    </td>
                    <td>
                        {{  $item->comment  }}
                    </td>
                    <td>
                        {{  $item->created_at  }}
                    </td>
                    <td>
                        <div class="custom-btn clr-primary">
                            <a href="{{ route('admin.feedback.show', $item->id) }}">{{ __('Просмотр') }}</a>
                        </div>
                        <div class="custom-btn clr-danger js_item_del">
                            <a href="{{ route('admin.feedback.delete', $item->id) }}">{{ __('Удалить') }}</a>
                        </div>                                                             
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div class="paginastion">
        {{ $feedbacks->links() }}
    </div>
@endif