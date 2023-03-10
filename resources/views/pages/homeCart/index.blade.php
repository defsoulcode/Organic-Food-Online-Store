@extends('layouts.main')
@section('main-content')
    <div class="row mt-4 my-5">
        <h2 class="text-center font-semibold mt-5">Cart Foods</h2>
        <div class="col-md-4 mt-4">
            <a class="btn btn-dark" href="{{ url('/best-seller') }}">
                <i class="fas fa-fw fa-arrow-left"></i>
                Continue Shop
            </a>
        </div>
    </div>

    <div class="col-md-6 mt-3">
        @if (session()->has('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                {{ session('success') }}
            </div>
        @endif
        
        @if (session()->has('delete'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                {{ session('delete') }}
            </div>
        @endif
    </div>

    <div class="row justify-content-center my-5 mt-3">
        <div class="col-md-12 mt-4">
            <table class="table table-striped text-center table-bordered" id="table-data">
                <thead class="bg-dark text-light">
                    <tr>
                        <th scope="col">No</th>
                        <th scope="col">Name</th>
                        <th scope="col">Code</th>
                        <th scope="col">Total</th>
                        <th scope="col">Price</th>
                        <th scope="col" colspan="2">Action</th>
                    </tr>
                </thead>
                <tbody class="align-middle">
                    @php $no = 1; @endphp
                    @foreach ($result as $item)
                        <tr class="align-content-center">
                            <td scope="row">{{ $no++ }}</td>
                            <td>
                                <h5>{{ $item->product->name_prod }}</h5>
                            </td>
                            <td>
                                <h5>{{ $item->product->code_prod }}</h5>
                            </td>

                            <!-- Update Cart -->
                            <form action="{{ route('cart.update', $item->id) }}" method="POST" id="submit_form">
                                @csrf
                                <td>
                                    <div class="col-md-6 m-auto">
                                        @if($item->quantity >= $item->product->stock)
                                            <input type="number" value="{{ $item->product->stock }}" name="quantity" min="1" max="{{ $item->product->stock }}"
                                                class="form-control text-center qty" disabled />
                                        @else
                                            <input type="number" value="{{ $item->quantity }}" name="quantity" min="1" max="{{ $item->product->stock }}"
                                                class="form-control text-center qty" />
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    @if($item->quantity >= $item->product->stock)
                                        <h5>@currency($item->product->price * $item->product->stock)</h5>
                                    @else
                                        <h5>@currency($item->product->price * $item->quantity)</h5>
                                    @endif
                                </td>
                            </form>
                            <!-- End Update Cart -->
                            <!-- Remove Cart -->
                            <form action="{{ route('cart.remove', $item->id) }}" method="POST">
                                @csrf
                                <td>
                                    <button type="submit" class="btn btn-danger" onclick="return confirm('Yakin ingin di hapus?')">
                                        <i class="fas fa-fw fa-trash-alt"></i> Remove
                                    </button>
                                </td>
                            </form>
                            <!-- End Remove Cart -->
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="row justify-content-end mt-3 my-3">
        <div class="col-md-4 text-end mt-3">
            <a href="{{ route('checkout.create') }}" class="btn btn-warning text-end no-btn" id="checkout">
                <i class="fas fa-fw fa-money-check"></i> Make Order 
            </a>
        </div>
    </div>

    <div class="row justify-content-end mt-3">
        <div class="col-md-6 mt-3">
            <h3 class="text-end">Total Price : @currency($total)</h3>
        </div>
    </div>
@endsection

@section('script')
    <script>
        let btnCheckout = document.querySelector("#checkout");
        let tableData = document.getElementById("table-data").rows.length;

        if(tableData <= 1) {
            btnCheckout.classList.add('disabled');
        } else {
            btnCheckout.classList.remove('disabled');
        }

        let form = document.querySelector('#submit_form');
        let qty = document.getElementsByClassName("qty");
        
        Array.from(qty).forEach(function(q){
            q.addEventListener('change', debounce(() => q.form.submit()));
        });

        function debounce(func, timeout = 50){
            let timer;
            return (...args) => {
                clearTimeout(timer);
                timer = setTimeout(() => { func.apply(this, args) }, timeout);
            };
        }
    </script>
@endsection