@extends('layouts.main')
@section('main-content')

<div class="card">
    <div class="card-body">
    @if (session()->has('success'))
    <div class="alert alert-success col-md-8" role="alert">
        {{ session('success') }}
    </div>
    @endif

    @if (session()->has('errors'))
    <div class="alert alert-danger col-md-8" role="alert" id="alert">
        {{ session('errors') }}
    </div>
    @endif

    
    </div>
</div>

@endsection