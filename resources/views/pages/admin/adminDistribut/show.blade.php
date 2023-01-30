@extends('dashboard.layouts.admin', ['sbMaster' => true, 'sbActive' => 'data.distribut'])
@section('admin-content')
    <div class="row mb-3">
        <div class="col-md-4">
            <a href="{{ route('distribut.index') }}" class="btn btn-dark mb-3">
                <i class="fas fa-fw fa-arrow-left"></i> 
                Back
            </a>
        </div>
    </div>

    <h1 class="h2 text-gray-800 text-center">Detail Distribut</h1>

    <div class="row justify-content-between my-5">
        <div class="col-md-4">
            @if ($distribut->image)
                <img src="{{ asset('storage/' . $distribut->image) }}" alt="profile-distribut" 
                    class="img-fluid shadow-lg rounded" style="width: 100%; height: 100%; object-fit: cover;">
            @else
                <img src="{{ asset('assets/images/default-user.png') }}" alt="profile-distribut" 
                    class="img-fluid shadow-lg rounded" style="width: 100%; height: 100%; object-fit: cover;">
            @endif
        </div>
        <div class="col-md-8">
            <h3 class="text-gray-900">{{ $distribut->name_distr }}</h3>
            <article class="my-3 fs-5 text-gray-900">
                {!! $distribut->detail_distr !!}
            </article>
        </div>
    </div>
@endsection