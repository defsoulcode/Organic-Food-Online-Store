@extends('layouts.main', ["title" => "Contact Us"])
@section('main-content')

<div class="row justify-content-center mt-5">
<!--Section: Contact v.2-->
<section class="mb-4">
<br><br>
    <!--Section heading-->
    <h2 class="h1-responsive font-weight-bold text-center my-4">Contact us</h2>
    <!--Section description-->

    <div class="row">

        <!--Grid column-->
        <div class="col-md-9 mb-md-0 mb-5">
            <form id="contact-form" name="contact-form" action="mail.php" method="POST">

                <!--Grid row-->
                <div class="row">

                    <!--Grid column-->
                    <div class="col-md-6">
                        <div class="md-form mb-0">
                            <label>Name: </label>
                            <input type="text" id="name" name="name" class="form-control" placeholder="Enter Your Name">
                        </div>
                    </div>
                    <!--Grid column-->

                    <!--Grid column-->
                    <div class="col-md-6">
                        <div class="md-form mb-0">
                            <label>Email: </label>
                            <input type="text" id="email" name="email" class="form-control" placeholder="Enter Your Email">
                        </div>
                    </div>
                    <!--Grid column-->

                </div>
                <!--Grid row-->
                <br>
                <!--Grid row-->
                <div class="row">
                    <div class="col-md-12">
                        <div class="md-form mb-0">
                            <label>Subject: </label>
                            <input type="text" id="subject" name="subject" class="form-control" placeholder="Enter Your Subject">
                        </div>
                    </div>
                </div>
                <!--Grid row-->
                <br>
                <!--Grid row-->
                <div class="row">

                    <!--Grid column-->
                    <div class="col-md-12">
                        <div class="md-form">
                            <label>Message: </label>
                            <textarea type="text" id="message" name="message" rows="2" class="form-control md-textarea" placeholder="Enter Your Message"></textarea>
                        </div>

                    </div>
                </div>
                <!--Grid row-->

            </form>
            <br>
            <div class="text-center text-md-left">
                <a class="btn btn-primary">Send</a>
            </div>
            <div class="status"></div>
        </div>
        <!--Grid column-->

        <!--Grid column-->
        <div class="col-md-3 text-center">
            <ul class="list-unstyled mb-0">
                <li><i class="fas fa-map-marker-alt fa-2x"></i>
                    <p>Jakarta, Indonesia </p>
                </li>

                <li><i class="fas fa-phone mt-4 fa-2x"></i>
                    <p>+62 872 8273 2763</p>
                </li>

                <li><i class="fas fa-envelope mt-4 fa-2x"></i>
                    <p>organicfood@store.com</p>
                </li>
            </ul>
        </div>
        <!--Grid column-->

    </div>

</section>
</div>
<!--Section: Contact v.2-->
@endsection