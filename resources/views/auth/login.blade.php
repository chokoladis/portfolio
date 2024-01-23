@extends('layouts.main')

@section('page.title'){{ __('Вход') }}@endsection

@section('content')
    <main>
        <div class="container">
            <div class="uk-flex uk-flex-center">
                <div class="uk-width-1-1 uk-width-3-5@s uk-width-1-3@l">
                    <div class="uk-card">
                        <div class="uk-card-title uk-text-center">{{ __('Вход') }}</div>

                        <div class="uk-card-body">
                            <form method="POST" action="{{ route('login') }}">
                                @csrf

                                <div class="uk-width-1-1 mb-3">
                                    <label for="email" class="uk-form-label">{{ __('Email') }}</label>

                                    <div class="">
                                        <input id="email" type="email" class="uk-input @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

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
                                    <input type="checkbox" name="remember" id="remember"  
                                        class="uk-checkbox @error('remember') is-invalid @enderror" 
                                        autocomplete="on" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="uk-form-label" for="remember">
                                        {{ __('Запомнить меня') }}
                                    </label>
                                </div>
                                
                                <div class="uk-width-1-1 mb-3">
                                    <button type="submit" class="uk-button uk-button-primary uk-margin-small-right">
                                        {{ __('Войти') }}
                                    </button>

                                    @if (Route::has('password.request'))
                                        <a class="uk-button uk-button-link" href="{{ route('password.request') }}">
                                            {{ __('Забыл пароль') }}
                                        </a>
                                    @endif
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
