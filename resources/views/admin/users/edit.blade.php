@php
    use App\Models\User;    
@endphp

@extends('layouts.admin')

{{-- @push('styles')
    @vite(['resources/scss/admin/works.scss'])
@endpush --}}

@section('title-content') {{ $user->name }} @endsection

@section('breadcrumb'){{ Breadcrumbs::render('admin.users.edit', $user) }}@endsection

@section('content')
     
    <section class="content">
        <div class="container-fluid">
            <form action="{{ route('admin.users.update', $user) }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                @php 
                    dump($user);
                    
                    $name_val = old('name') ? old('name') : $user->name;
                    $email_val = old('email') ? old('email') : $user->email;
                    $role_val = old('role') ? old('role') : $user->role;
                    $pass_val = old('password') ? old('password') : $user->password;
                @endphp

                <div class="uk-margin">
                    <p>{{ trans('crud.Users.fields.name') }}</p>
                    <input type="text" name="name" class="uk-input" aria-label="Input" value="{{ $name_val }}">

                    @if($errors->has('name'))
                        <div class="error">{{ $errors->first('name') }}</div>
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
        </div>
    </section>

@endsection