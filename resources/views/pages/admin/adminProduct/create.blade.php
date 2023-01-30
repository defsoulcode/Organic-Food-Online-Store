@extends('dashboard.layouts.admin', ['sbMaster' => true, 'sbActive' => 'data.product'])
@section('admin-content')
    <a class="btn btn-dark" href="{{ route('product.index') }}">
        <i class="fas fa-fw fa-arrow-left"></i>
        Back
    </a>
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card border-0 shadow-lg my-5">
                <div class="card-header">
                    <h1 class="h2 text-gray-800 text-center">Add product</h1>
                </div>
                <div class="card-body">
                    <form action="{{ route('product.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="name_prod" class="form-label">Product Name</label>
                            <input type="text" class="form-control @error('name_prod') is-invalid @enderror"
                                id="name_prod" name="name_prod" required value="{{ old('name_prod') }}">
                            @error('name_prod')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="price" class="form-label">Price</label>
                            <input type="number" class="form-control @error('price') is-invalid @enderror" id="price"
                                name="price" value="{{ old('price') }}" required>
                            @error('price')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="stock" class="form-label">Stock</label>
                            <input type="number" class="form-control @error('stock') is-invalid @enderror" id="stock"
                                name="stock" value="{{ old('stock') }}" required>
                            @error('stock')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="weight" class="form-label">Weight</label>
                            <input type="number" class="form-control @error('weight') is-invalid @enderror" id="weight" name="weight"
                                value="{{ old('weight') }}" required>
                            @error('weight')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="category" class="form-label">Categories</label>
                            <select class="form-control" name="category_id" id="category" required>
                                <option value="" disabled selected>Select Category </option>
                                @foreach ($categories as $category)
                                    <option value="{{ old('category_id', $category->id) }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="distribut" class="form-label">Distributs</label>
                            <select class="form-control" name="distribut_id" id="distribut" required>
                                <option value="" disabled selected>Select distribut </option>
                                @foreach ($distributs as $distribut)
                                    <option value="{{ old('distribut_id', $distribut->id) }}">{{ $distribut->name_distr }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="image" class="form-label">Cover product</label>
                            <img class="img-preview img-fluid mb-3 sm-2">
                            <input type="file" class="form-control-file" required @error('image') is-invalid @enderror
                                id="image" name="image" onchange="previewCover()">
                            @error('image')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="detail" class="form-label">detail</label>
                            <input type="hidden" class="form-control @error('detail') is-invalid @enderror" id="detail"
                                name="detail" required value="{{ old('detail') }}">
                            @error('detail')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <trix-editor input="detail"></trix-editor>
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
        function previewCover() {
                const image = document.querySelector('#image');
                const imagePreview = document.querySelector('.img-preview');
                imagePreview.style.display = 'block';
    
                const oFReader = new FileReader();
                oFReader.readAsDataURL(image.files[0]);
    
                oFReader.onload = function(oFREvent) {
                    imagePreview.src = oFREvent.target.result;
                }
            }
    
            document.addEventListener('trix-file-accept', function(e) {
                e.preventDefault();
            });
    </script>
@endsection