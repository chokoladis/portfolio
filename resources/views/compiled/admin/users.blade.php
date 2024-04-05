@if(!$users->count())
    <div class="result_query">
        {{ __('По данному запросу нет записей') }}
    </div>
@else
    <table class="uk-table">
        <thead>
            <tr>
                @foreach (trans('crud.Users.fields_list_admin') as $filed_code => $trans)
                    <th>{{ $trans }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
                <tr>
                    <td>
                        {{  $user->id  }}
                    </td>
                    <td>
                        {{ $user->fio }}
                    </td>
                    <td>
                        <a href="mailto:{{ $user->email }}">{{ $user->email }}</a>
                    </td>
                    <td>
                        {{ $user->role }}
                    </td>
                    <td>
                        {{  $user->created_at  }}
                    </td>
                    <td>
                        <div class="custom-btn clr-primary js_user_edit">
                            <a href="{{ route('admin.users.edit', $user->id) }}">
                                <span uk-icon="icon:pencil" title="{{ __('Редактировать') }}"></span>
                            </a>
                        </div>                                              
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div class="paginastion">
        {{$users->links()}}
    </div>
@endif