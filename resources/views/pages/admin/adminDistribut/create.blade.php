@extends('dashboard.layouts.admin', ['sbMaster' => true, 'sbActive' => 'data.distribut'])
@section('admin-content')
    <a class="btn btn-dark" href="{{ route('distribut.index') }}">
        <i class="fas fa-fw fa-arrow-left"></i>
        Back
    </a>

    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card border-0 shadow-lg my-5">
                <div class="card-header">
                    <h1 class="h2 text-gray-800 text-center">Add Distribut</h1>
                </div>
                <div class="card-body">
                    <form action="{{ route('distribut.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="name_distr" class="form-label">Name Distribut</label>
                            <input type="text" class="form-control @error('name_distr') is-invalid @enderror"
                                id="name_distr" name="name_distr" required value="{{ old('name_distr') }}">
                                @error('name_distr')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                        </div>
                        <div class="mb-3">
                            <label for="slug" class="form-label">Slug</label>
                            <input type="text" class="form-control @error('slug') is-invalid @enderror" id="slug"
                                name="slug" value="{{ old('slug') }}">
                                @error('slug')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                        </div>
                        <div class="mb-3">
                            <label for="image" class="form-label">Profile</label>
                            <img class="img-preview img-fluid mb-3 sm-2">
                            <input type="file" class="form-control-file" required @error('image') is-invalid @enderror
                                id="image" name="image" onchange="previewProfile()">
                                @error('image')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                        </div>
                        <div class="mb-3">
                            <label for="detail_distr" class="form-label">Detail Distribut</label>
                            <input type="hidden" class="form-control @error('detail_distr') is-invalid @enderror"
                                id="detail_distr" name="detail_distr" required value="{{ old('detail_distr') }}">
                                @error('detail_distr')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            <trix-editor input="detail_distr"></trix-editor>
                        </div>

                        <div class="mb-3 text-center">
                            <button type="submit" class="btn btn-primary">Create</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        const title = document.querySelector('#nama-author');
            const slug = document.querySelector('#slug');

            title.addEventListener('change', function(){
                fetch('/admin/dashboard/author/checkSlug?title=' + title.value)
                .then(response => response.json())
                .then(data => slug.value = data.slug)
            });

            document.addEventListener('trix-file-accept', function(e) {
                e.preventDefault();
            });

            function previewProfile() {
                const image = document.querySelector('#image');
                const imagePreview = document.querySelector('.img-preview');
                imagePreview.style.display = 'block';

                const oFReader = new FileReader();
                oFReader.readAsDataURL(image.files[0]);

                oFReader.onload = function(oFREvent) {
                    imagePreview.src = oFREvent.target.result;
                }
            }
    </script>
@endsection