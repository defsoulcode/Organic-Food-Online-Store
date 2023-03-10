@extends('layouts.main')
@section('main-content')
<style>
    .jumbotron-flat {
        background-color: solid #DB8FFF;
        height: 100%;
        border: 1px solid #4DB8FF;
        background: white;
        width: 100%;
        text-align: center;
        overflow: auto;
    }

    .paymentAmt img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
</style>

<div class="row justify-content-center mt-5">
    <div class="col-md-4 mt-5 my-4">
        <h3 class="text-center">Valid Orders</h3>
    </div>
</div>

{{-- @endforeach --}}
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
        <div class="container mb-5 mt-3">
        <div class="mb3">
           
    </div>
            </div>
</div>
</div>
<br>
<div class="card">
    <div class="card-body">
        <div class="container mb-5 mt-3">
            <div class="row d-flex align-items-baseline">
                <div class="col-xl-9">
                    <p style="color: #7e8d9f;font-size: 20px;">Invoice >> <strong>ID: #123-123</strong></p>
                </div>
                <div class="col-xl-3 float-end">
                    <a class="btn btn-light text-capitalize border-0" data-mdb-ripple-color="dark"><i
                            class="fas fa-print text-primary"></i> Print</a>
                    <a class="btn btn-light text-capitalize" data-mdb-ripple-color="dark"><i
                            class="far fa-file-pdf text-danger"></i> Export</a>
                </div>
                <hr>
            </div>

            <div class="container">
                <div class="col-md">
                    <div class="text-center">
                        <img src="{{ asset('assets/images/icon-books.png') }}" alt="icon-books" class="mb-2"/>
                        <h5 class="fw-normal text-success">Z-book's</h5>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xl-8">
                        <ul class="list-unstyled">
                            <li class="text-muted">To: <span style="color:#5d9fc5 ;">John Lorem</span></li>
                            <li class="text-muted">Street, City</li>
                            <li class="text-muted">State, Country</li>
                            <li class="text-muted"><i class="fas fa-phone"></i> 123-456-789</li>
                        </ul>
                    </div>
                    <div class="col-xl-4">
                        <p class="text-muted">Invoice</p>
                        <ul class="list-unstyled">
                            <li class="text-muted"><i class="fas fa-circle" style="color:#84B0CA ;"></i> <span
                                    class="fw-bold">ID:</span>#123-456</li>
                            <li class="text-muted"><i class="fas fa-circle" style="color:#84B0CA ;"></i> <span
                                    class="fw-bold">Creation Date: </span>Jun 23,2021</li>
                            <li class="text-muted"><i class="fas fa-circle" style="color:#84B0CA ;"></i> <span
                                    class="me-1 fw-bold">Status:</span><span
                                    class="badge bg-warning text-black fw-bold">
                                    Unpaid</span></li>
                        </ul>
                    </div>
                </div>

                <div class="row my-2 mx-1 justify-content-center">
                    <table class="table table-striped table-borderless">
                        <thead style="background-color:#84B0CA ;" class="text-white">
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Description</th>
                                <th scope="col">Qty</th>
                                <th scope="col">Unit Price</th>
                                <th scope="col">Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th scope="row">1</th>
                                <td>Pro Package</td>
                                <td>4</td>
                                <td>$200</td>
                                <td>$800</td>
                            </tr>
                            <tr>
                                <th scope="row">2</th>
                                <td>Web hosting</td>
                                <td>1</td>
                                <td>$10</td>
                                <td>$10</td>
                            </tr>
                            <tr>
                                <th scope="row">3</th>
                                <td>Consulting</td>
                                <td>1 year</td>
                                <td>$300</td>
                                <td>$300</td>
                            </tr>
                        </tbody>

                    </table>
                </div>
                <div class="row">
                    <div class="col-xl-8">
                        <p class="ms-3">Add additional notes and payment information</p>

                    </div>
                    <div class="col-xl-3">
                        <ul class="list-unstyled">
                            <li class="text-muted ms-3"><span class="text-black me-4">SubTotal</span>$1110</li>
                            <li class="text-muted ms-3 mt-2"><span class="text-black me-4">Tax(15%)</span>$111</li>
                        </ul>
                        <p class="text-black float-start"><span class="text-black me-3"> Total Amount</span><span
                                style="font-size: 25px;">$1221</span></p>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-xl-10">
                        <p>Thank you for your purchase</p>
                    </div>
                    <div class="col-xl-2">
                        <!-- <button type="button" class="btn btn-primary text-capitalize"
                            style="background-color:#60bdf3 ;">Pay Now</button> -->
                            <button type="button" class="btn btn-success" id="pay-button">
                Pay Now
            </button>
        </div>

        {{-- <form action="{{ route('valid.data') }}" id="submit_form" method="POST">
            @csrf
            <input type="hidden" name="json" id="json_callback">
        </form> --}}
        <form action="" id="submit_form" method="POST">
            @csrf
            <input type="hidden" name="json" id="json_callback">
        </form>

        {{-- @foreach ($dataValid as $order)
            @if ($order->payment_status == 1) --}}
                {{-- <button class="btn btn-primary" id="pay-button">Pay Now</button> --}}
            {{-- @else
                Payment Successfully
            @endif
        @endforeach --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


@section('script')
{{-- <script>
    $(document).ready(function() {
            // $('.search-select').select2();
            // ketika provinsi tujuan di klik maka auto excecute kota & kabupate sesuai id provinsi
            $('select[name="province_id"]').on('change', function() {
                // tampung nilai id provinsi yg dikirim
                let provinces = $(this).val();
            
                if(provinces) {
                    $.ajax({
                        type: "GET",
                        url: "/city/" + provinces,
                        dataType: "json",
                        success: function (response) {
                            $('select[name="city_id"], select[name="destination_id"]').empty();
                            $.each(response, function(key, value) {
                                $('select[name="city_id"], select[name="destination_id"]').append(
                                    '<option value="'+ value.id +'">' + value.nama_kab_kota + '</option>'
                                );
                            });
                        }
                    });
                } else {
                    $('select[name="city_id"], select[name="destination_id"]').empty();
                }
            });

            $('select[name="courier"]').on('change', function() {
                let costLayanan = 2000;
                let origin = $("select[name=city_id]").val();
                let destination = $("select[name=destination_id]").val();
                let courier = $("select[name=courier]").val();
                let weight = $("input[name=weight]").val();
                let totalBelanja = $('input[name="total_belanja"]').val();

                if(courier) {
                    jQuery.ajax ({
                        url:"/origin="+origin+"&destination="+destination+"&weight="+weight+"&courier="+courier,
                        type:'GET',
                        dataType:'json',
                        success:function(response) {
                            console.log(response);
                            $('select[name="cost_services"]').empty();
                            // ini untuk looping data result nya
                            response = response[0];
                                $.each(response.costs, function(key, value) {
                                    let cost = value.cost[0];
                                    $('select[name="cost_services"]').append('<option value="'+ cost.value + '">' + value.service + '-' + value.description + ' Rp. ' + cost.value + ' : ' + cost.etd + ' (days) ' + '</option>');
                                });

                            let costKurir = response.costs[0].cost[0].value;
                            // $('input[name="total_harga"]').val(parseInt(response.costs[0].cost[0].value) + parseInt(totalBelanja));
                            $('.cost-ongkir').html(`Rp. ${costKurir}`);
                            $('.cost-layanan').html(`Rp. ${costLayanan}`);
                            $('.harga').html(`Rp. ${parseInt(costKurir) + parseInt(totalBelanja) + costLayanan}`);
                        }
                    });
                }else {
                    $('select[name="cost_services"]').empty();
                }
            });

            $('select[name="cost_services"]').on('change', function(){
                let costLayanan = 2000;
                let services = $(this).val();
                let totalBelanja = $('input[name="total_belanja"]').val();
                let tampung = parseInt(totalBelanja) + parseInt(services);
                console.log(tampung);

                if(services) {
                    $('.harga').html(`Rp. ${tampung + costLayanan}`);
                    $('.cost-ongkir').html(`Rp. ${services}`);
                } 
            });
        });
</script> --}}
<!-- midtrans -->
<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>
<script type="text/javascript">
    // For example trigger on button clicked, or any time you need
    var payButton = document.getElementById('pay-button');
    // let failedPay = document.querySelector('#alert');
    payButton.addEventListener('click', function () {
        // Trigger snap popup. @TODO: Replace TRANSACTION_TOKEN_HERE with your transaction token
            window.snap.pay('<?=$snapToken?>', {
                onSuccess: function(result){
                /* You may add your own implementation here */
                // alert("payment success!"); 
                console.log(result);
                send_response_to_form(result);
            },
                onPending: function(result){
                /* You may add your own implementation here */
                // alert("wating your payment!"); 
                console.log(result);
                send_response_to_form(result);
            },
                onError: function(result){
                // alert("payment failed!");
                // failedPay;
                console.log(result);
                send_response_to_form(result);
            },
                onClose: function(){
                alert('you closed the popup without finishing the payment');
            }
        });
    });

    function send_response_to_form(result){
        document.getElementById('json_callback').value = JSON.stringify(result);
        $('#submit_form').submit();
    }
</script>
@endsection