@extends('layouts.main')
@section('main-content')
<main class="mt-5">
    <div class="py-5 text-center">
        <h3>History Order</h3>
    </div>

    @if (session()->has('success'))
        <div class="alert alert-success col-md-6 alert-dismissible fade show" role="alert">
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            {{ session('success') }}
        </div>
    @endif

    @if (session()->has('errors'))
        <div class="alert alert-danger col-md-6 alert-dismissible fade show" role="alert" id="alert">
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            {{ session('errors') }}
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            <div class="container">
                {{-- <div class="row d-flex align-items-baseline">
                    <div class="col-xl-10">
                        <p style="color: #7e8d9f;font-size: 20px;">Invoice >> <strong>ID : -</strong></p>
                    </div>
                    <div class="col-xl-2 float-end">
                        <a class="btn btn-primary">
                            <i class="fas fa-fw fa-print"></i> Print
                        </a>
                    </div>
                    <hr>
                </div> --}}
    
                <div class="container">
                    <div class="col-md-6 d-flex mb-4">
                        <div class="d-flex align-items-end ">
                            <img src="{{ asset('assets/images/organic-food-icons.png') }}" alt="icon-foods" style="width: 50px;" class="mb-2"/>
                            <h4 class="fw-normal text-success">Organic Food's</h5>
                        </div>
                    </div>
    
                    <div class="row">
                        {{-- <div class="col-xl-8">
                            <ul class="list-unstyled">
                                <li class="text-muted">To : <span class="fw-bolder">{{ Auth::user()->name }}</span></li>
                                <li class="text-muted">Province : -</li>
                                <li class="text-muted">City : </li>
                                <li class="text-muted">Address : </li>
                                <li class="text-muted">Phone Number : <i class="fas fa-phone"></i> </li>
                            </ul>
                        </div> --}}
                        {{-- <div class="col-xl-4">
                            <ul class="list-unstyled">
                                <li class="text-muted"><i class="fas fa-circle" style="color:#84B0CA ;"></i> <span
                                        class="fw-bold">ID : </span>-</li>
                                <li class="text-muted"><i class="fas fa-circle" style="color:#84B0CA ;"></i> <span class="fw-bold">
                                        Tanggal : </span>-</li>
                                <li class="text-muted"><i class="fas fa-circle" style="color:#84B0CA ;"></i> <span
                                        class="me-1 fw-bold">Status : </span>   
                                        <span class="badge bg-success fw-bold">-</span></li>
                            </ul>
                        </div> --}}
                    </div>
    
                    <div class="row my-2 mx-1 text-center">
                        <table class="table table-striped table-bordered">
                            <thead class="text-white bg-secondary">
                                <tr>
                                    <th scope="col">No</th>
                                    <th scope="col">Product</th>
                                    <th scope="col">Count</th>
                                    <th scope="col">Price</th>
                                    <th scope="col">Total</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $no = 1; @endphp
                                @foreach ($resultOrder as $item)
                                    <tr>
                                        <td>{{ $no++ }}</td>
                                        <td>{{ $item->product->name_prod}}</td>
                                        <td>{{ $item->quantity }}</td>
                                        <td>@currency($item->product->price)</td>
                                        <td>@currency($item->product->price * $item->quantity)</td>
                                        <td>
                                            <a href="" class="btn btn-primary"><i class="fas fa-fw fa-info"></i></a>
                                            <form action="" method="POST" class="d-inline">
                                                @method('DELETE')
                                                @csrf
                                                <button class="btn btn-danger" type="submit" onclick="return confirm('Apakah yakin ingin menghapus pesanan ini ?')">
                                                    <i class="fas fa-fw fa-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    {{-- <div class="row">
                        <div class="col-xl-8">
                            <p class="ms-3">Note & Information Payment</p>
                        </div>
                        <div class="col-xl-3">
                            <ul class="list-unstyled">
                                <li class="text-muted ms-3"><span class="text-black me-4">SubTotal</span>Rp. 10.000</li>
                                <li class="text-muted ms-3 mt-2"><span class="text-black me-4">Shipping Cost</span>Rp. 5.000</li>
                            </ul>
                            <p class="text-black float-start"><span class="text-black me-3"> Total Cost</span>
                                <span style="font-size: 25px;">Rp. 15.000</span>
                            </p>
                        </div>
                    </div> --}}
                    <hr>
                    <div class="row">
                        {{-- <div class="col-xl-9">
                            <p>Thank you for your purchase</p>
                        </div> --}}
                        <div class="col-xl-3">
                            <button type="button" class="btn btn-success text-capitalize" id="pay-button">
                                <i class="fas fa-fw fa-print"></i>
                                Print Now
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection