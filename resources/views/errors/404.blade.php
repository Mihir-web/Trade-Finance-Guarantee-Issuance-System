@extends('layouts.app')

@section('content')
<!-- Header Banner -->
    <section class="banner-header section-padding bg-img" data-overlay-dark="8" data-background="{{asset('assets/img/slider/3.jpg')}}">
        <div class="v-middle">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 text-center">
                        <h6>404 Page</h6>
                        <h1>Page not found</h1>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- divider line -->
    <div class="line-vr-section"></div>
    <!-- Not found 404 -->
    <section class="not-found section-padding">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6 col-md-12 text-center">
                    <h1>404</h1>
                    <h3>Sorry, We Can't Find That Page!</h3>
                    <p>The page you are looking for was moved, removed, renamed or never existed.</p>
                </div>
            </div>
        </div>
    </section>
    <div class="line-vr-section"></div>
    <br>
@endsection