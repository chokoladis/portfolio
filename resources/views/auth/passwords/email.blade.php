@extends('layouts.main')

@section('content')
    <main>
        <div class="container">
            <div class="uk-flex uk-flex-center">
                <div class="uk-width-1-1 uk-width-3-5@s uk-width-1-3@l">
                    <div class="uk-card">
                        <div class="uk-card-title uk-text-center">{{ __('Сбросить пароль') }}</div>

                        <div class="uk-card-body">
                            @if (session('status'))
                                <div class="alert alert-success" role="alert">
                                    {{ session('status') }}
                                </div>
                            @endif

                            <form method="POST" action="{{ route('password.email') }}">
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
                                    <button type="submit" class="uk-button uk-button-primary uk-button-small">
                                        {{ __('Получить ссылку') }}
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
