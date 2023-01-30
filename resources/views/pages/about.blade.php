@extends('layouts.main', ["title" => "About Us"])
@section('main-content')

<div class="row justify-content-center mt-5">
    <h2 class="text-center font-semibold mt-5">About Us</h2>
    <div class="col-md-10 mt-3">
        <div class="mt-3">
            <div class="row justify-content-between align-items-center">
                <div class="col-md-8 m-auto p-auto">
                <h5 class="font-semibold card-title mb-3"> Food to Live: Your Supplier of Healthful Foods</h5>    
                <p>
                    A well-balanced diet is one of the most important factors contributing to our health, and we at Food to Live strive to help everyone who wants to be healthy and strong. We do this by providing you with a great selection of delicious and healthful foods that range from grains and nuts to spices. Our biggest wish is to help both the people and the planet, so all our products are grown using advanced farming practices. We also offer a range of USDA-certified organic products of the highest quality. At Food to Live, we strive to better ourselves every day, expand our product range, and improve our services to ensure every customer receives the highest level of care.
                    
                    </p>
                    <h5 class="font-semibold card-title mb-3">Our Mission</h5>
                    Food to Live was created to give people easy access to delicious and healthy foods. We offer a wide range of natural, organic, and raw foods that would be a great addition to any diet. We choose products that can positively impact the body, such as dried fruits, nuts, seeds, spices, and legumes.
                </div>
                <div class="col-md-4">
                    <img src="{{ asset('assets/images/organic-about.jpg') }}" alt="about owner"
                        class="img-fluid shadow-lg rounded" style="width: 100%; height: 100%; object-fit: cover;">
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-10 mt-3">
        <div class="mt-4">
            <div class="row justify-content-between align-items-center">
                <div class="col-md-4">
                    <img src="{{ asset('assets/images/organic-about-us.jpg') }}" alt="about owner"
                        class="img-fluid shadow-lg rounded" style="width: 100%; height: 100%; object-fit: cover;">
                </div>
                <div class="col-md-8 m-auto p-auto">
                    <div class="card-body">
                    <h5 class="font-semibold card-title mb-3"> Our Team and Our Family</h5>
                        <p class="card-text">
                        At Food to Live, we greet every customer as a friend and treat them accordingly. Our business is our family in every way, as it has started from the kitchen of our home. Three generations of our family are working together to bring you top-quality foods from different corners of the world.We pride ourselves on the quality of our customer service and welcome you to contact us anytime if you have any questions or would like some advice regarding healthy foods.
                        </p>
                    </div>
                </div>
            </div>
        </div>

    
    </div>
</div>
@endsection