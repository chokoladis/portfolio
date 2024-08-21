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
                                @php
                                    $gData = array(
                                        'client_id'     => config('auth.socials.google.client_id'),
                                        'redirect_uri'  => config('auth.socials.google.redirect_uri'),
                                        'response_type' => 'code',
                                        'scope'         => 'https://www.googleapis.com/auth/userinfo.email https://www.googleapis.com/auth/userinfo.profile',
                                    );
                                    
                                    $gUrl = 'https://accounts.google.com/o/oauth2/auth?' . urldecode(http_build_query($gData));

                                    $yData = array(
                                        'client_id'     => config('auth.socials.yandex.client_id'),
                                        'redirect_uri'  => config('auth.socials.yandex.redirect_uri'),
                                        'response_type' => 'code',
                                    );
                                    
                                    $yUrl = 'https://oauth.yandex.ru/authorize?' . urldecode(http_build_query($yData));
                                @endphp

                                <div class="services_auth">
                                    <p>{{ __('Войти с помощью:')}}</p>
                                    <div class="services">
                                        <a href="{{ $gUrl }}">
                                            <img src="/storage/general/google_icon_min.png" alt="google">
                                        </a>
                                        <a href="{{ $yUrl }}">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="none" viewBox="0 0 26 26"><path fill="#FC3F1D" d="M26 13c0-7.18-5.82-13-13-13S0 5.82 0 13s5.82 13 13 13 13-5.82 13-13Z"></path><path fill="#fff" d="M17.55 20.822h-2.622V7.28h-1.321c-2.254 0-3.38 1.127-3.38 2.817 0 1.885.758 2.816 2.448 3.943l1.322.932-3.749 5.828H7.237l3.575-5.265c-2.059-1.495-3.185-2.817-3.185-5.265 0-3.012 2.058-5.07 6.023-5.07h3.9v15.622Z"></path></svg>
                                        </a>
                                    </div>
                                </div>
                                
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
