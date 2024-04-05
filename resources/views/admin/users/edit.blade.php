@php
    use App\Models\User;    
@endphp

@extends('layouts.admin')

@section('title-content') {{ $user->fio }} @endsection

@section('breadcrumb'){{ Breadcrumbs::render('admin.users.edit', $user) }}@endsection

@section('content')
     
    <section class="content">
        <div class="container-fluid">
            <form action="{{ route('admin.users.update', $user) }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                @php
                    if (session('arErrors')){
                        foreach (session('arErrors') as $error) {
                            echo '<div class="uk-alert-danger" uk-alert>
                                    <a href class="uk-alert-close" uk-close></a>
                                    <p>'.$error.'</p>
                                </div>';
                        }
                    }
                    $fio_val = old('fio') ? old('fio') : $user->fio;
                    $email_val = old('email') ? old('email') : $user->email;
                    $role_val = old('role') ? old('role') : $user->role;
                    $pass_val = old('password') ? old('password') : $user->password;
                @endphp

                <div class="uk-margin">
                    <p>{{ trans('crud.Users.fields.fio') }}</p>
                    <input type="text" name="fio" class="uk-input" aria-label="Input" value="{{ $fio_val }}">

                    @if($errors->has('fio'))
                        <div class="error">{{ $errors->first('fio') }}</div>
                    @endif
                </div>
                <div class="uk-margin">
                    <p>{{ trans('crud.Users.fields.email') }}</p>
                    <input type="email" name="email" class="uk-input" aria-label="Input" value="{{ $email_val }}">

                    @if($errors->has('email'))
                        <div class="error">{{ $errors->first('email') }}</div>
                    @endif
                </div>
                <div class="uk-margin">
                    <p>{{ trans('crud.Users.fields.role') }}</p>
                    <select name="role" class="uk-select">
                        @php
                            foreach(User::ROLES as $role) {
                                $selected = $role_val == $role ? 'selected' : '';
                                echo '<option '.$selected.'>'.$role.'</option>';
                            }                                
                        @endphp
                    </select>
                    @if($errors->has('role'))
                        <div class="error">{{ $errors->first('role') }}</div>
                    @endif
                </div>
                <div class="uk-margin">
                    <p>{{ trans('crud.Users.fields.password') }}</p>
                    <input type="password" name="password" class="uk-input" aria-label="Input" value="{{ $pass_val }}">

                    @if($errors->has('password'))
                        <div class="error">{{ $errors->first('password') }}</div>
                    @endif
                </div>
            
                <div class="buttons">
                    <input type="submit" value="{{ __('Изменить') }}" class="uk-button uk-button-default">
                </div>
                    
            </form>

            <x-model-additional :model="$user" crud="Users"></x-model-additional>
        </div>
    </section>

@endsection