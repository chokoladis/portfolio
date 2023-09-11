@extends('layouts.main')

@section('content')
    <main>
        <div class="container">
            <div class="card-header">{{ __('Wellcome') }}</div>

            <div class="card-body">
                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif
            </div>
        </div>
    </main>
@endsection