@extends('layouts.main')

@section('page.title') Регистрация @endsection

@section('content')
    <main>
        <div class="container">
            <div class="uk-flex uk-flex-center">
                <div class="uk-width-1-1 uk-width-3-5@s uk-width-1-3@l">
                    <div class="uk-card">
                        <div class="uk-card-title uk-text-center">{{ __('Регистрация') }}</div>

                        <div class="uk-card-body">
                            <form method="POST" action="{{ route('register') }}">
                                @csrf

                                <div class="uk-width-1-1 mb-3">
                                    <label for="name" class="uk-form-label">{{ __('Имя') }}</label>

                                    <div class="">
                                        <input id="name" type="text" class="uk-input @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" maxlength="30" autofocus>

                                        @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="uk-width-1-1 mb-3">
                                    <label for="email" class="uk-form-label">{{ __('Email') }}</label>

                                    <div class="">
                                        <input id="email" type="email" class="uk-input @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" maxlength="70">

                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="uk-width-1-1 mb-3">
                                    <label for="password" class="uk-form-label">{{ __('Пароль') }}</label>

                                    <div class="">
                                        <input id="password" type="password" class="uk-input @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                        @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="uk-width-1-1 mb-3">
                                    <label for="password-confirm" class="uk-form-label">{{ __('Подтвердите свой пароль') }}</label>

                                    <div class="">
                                        <input id="password-confirm" type="password" class="uk-input" name="password_confirmation" required autocomplete="new-password">
                                    </div>
                                </div>

                                
                                <div class="uk-flex uk-flex-center">
                                    <button type="submit" class="uk-button uk-button-primary">
                                        {{ __('Зарегистрироваться') }}
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
