@extends('layouts.app')

@section('content')
    <div class="px-5">
        <h1 class="mt-3 text-center">Welcome To OffTopic</h1>
        <p class="mt-4">Welcome to my forum and blog site. I created this app for fun and afcourse to learn new things. Here you can read my blogs, ask your questions in the forum and to discuss topics with other users.Feel free to contact me for bussines offers or if you have any other questions.
        </p>
        <div class="slider-container mx-auto container my-5">
            <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                <ol class="carousel-indicators">
                    <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                    <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                    <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
                </ol>
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <img class="d-block w-100 slider-img" src="{{ asset('imgs/wordpress-forum.jpg') }}" alt="First slide">
                        <div class="carousel-caption d-none d-md-block">
                            <h5>Welcome To OffTopic</h5>
                            <p class="font-weight-bold">Read my Blog posts, discuss every topic with other users in our Forum and learn new things!</p>
                            <button class="btn btn-primary">Register</button>
                            <button class="btn btn-primary">Login</button>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <img class="d-block w-100 slider-img" src="{{ asset('imgs/Laravel.jpg') }}" alt="Second slide">
                        <div class="carousel-caption d-none d-md-block">
                            <h5>About The Project</h5>
                            <p>Used technologies: Laravel, PHP, JS, jQuery, Bootstrap, HTML, CSS, MySQL</p>
                            <button class="btn btn-primary">Check Project Repo</button>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <img class="d-block w-40 mx-auto slider-img d-block" src="{{ asset('imgs/107105611_293531668430688_3610848492411984211_n.jpg') }}" alt="Third slide">
                        <div class="carousel-caption d-none d-md-block">
                            <h5>Work with me:</h5>
                            <p>For personal, custom projects and work</p>
                            <button class="btn btn-primary">Contact Me</button>
                        </div>
                    </div>
                </div>
                <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                </a>
            </div>
        </div>
    </div>
@endsection