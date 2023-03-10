@extends('dashboard.layouts.admin', ['sbMaster' => true, 'sbActive' => 'data.reviews'])
@section('admin-content')
    <div class="card shadow mb-4">
        <div class="card-header py-3 mb-3">
            <h1 class="h2 mb-3 text-gray-800 text-center">Reviews Managements</h1>
        </div>

        @if (session()->has('errors'))
            <div class="alert alert-danger col-md-8 mt-3 ml-3 alert-dismissible fade show" role="alert">
                {{ session('errors') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        <div class="card-body mt-3">
            <div class="table-responsive">
                <table class="table table-bordered text-center" id="dataTable" width="100%" cellspacing="0">
                    <thead class="bg-dark text-light">
                        <input type="hidden" name="id_product" value="">
                        <tr>
                            <th>No</th>
                            <th>Cover Product</th>
                            <th>Detail</th>
                            <th>Rating</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $i = 1; @endphp
                        @foreach ($data as $item)
                            <tr>
                                <td>{{ $i++; }}</td>
                                <td>
                                    @if ($item->image)
                                        <img src="{{ asset('storage/' . $item->image) }}" alt="covers"
                                            class="img-fluid" width="100">
                                        @else
                                        <img src="{{ asset('assets/images/cover-404.jpg') }}" alt="covers"
                                            class="img-fluid" width="100">
                                    @endif
                                </td>
                                <td>{{ $item->excerpt }}</td>
                                <td>{{ $item->star_rating }} <i class="fas fa-fw fa-star text-warning"></i></td>
                                <td>
                                    <a href="{{ route('admin-reviews.show', $item->id) }}" class="btn btn-primary">
                                        <i class="fas fa-fw fa-eye"></i>
                                    </a>
                                    <form action="{{ route('admin-reviews.destroy', $item->id) }}" method="POST"
                                        class="d-inline">
                                        @method('DELETE')
                                        @csrf
                                        <button class="btn btn-danger" type="submit"
                                            onclick="return confirm('Apakah yakin ingin menghapus review product ini ?')">
                                            <i class="fas fa-fw fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection