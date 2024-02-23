@extends('layouts.admin')

@section('content')

    
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">{{ __('Feedback') }}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="/admin/">{{ __('Home') }}</a></li>
                    <li class="breadcrumb-item active">{{ __('Feedback') }}</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    
    <section class="content">
        <div class="container-fluid">

            @php dump($feedback); @endphp

        </div>
    </section>
    
    
@endsection