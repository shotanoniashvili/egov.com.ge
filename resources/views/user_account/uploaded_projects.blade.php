@extends('user_account/layout')

@section('title')
    ატვირთული პროექტები
@stop

@section('user_account_content')

    <div class="col-md-9 col-12">
        <!--main content-->
        <div class="position-center">
            <!-- Notifications -->
            <div id="notific">
                @include('notifications')
            </div>

            <div>
                <h3 class="text-primary" id="title">ატვირთული პროექტები</h3>
                <hr />
            </div>

            <div class="row">
                <div class="col-md-6 col-lg-4 col-12 my-2">
                    <!-- BEGIN FEATURED POST -->
                    <div class="featured-post-wide thumbnail">
                        <img src="https://cdn0.iconfinder.com/data/icons/mixer-2019/128/mixer-83-512.png" class="img-fluid" alt="Image">
                        <div class="featured-text relative-left">
                            <h4 class="primary">
                                <a href="#">პროექტის დასახელება</a>
                            </h4>
                            <p>მოკლე აღწერა, მოკლე აღწერა, მოკლე აღწერა მოკლე აღწერა, მოკლე აღწერა</p>

                            <p class="additional-post-wrap">
                                <span class="d-block">თემატიკა: გენდერული თანასწორობა</span>
                                <span class="d-block">სტატუსი: შეფასების პროცესში</span>
                            </p>
                            <hr>
                            <p class="text-right">
                                <a href="#" class="btn btn-primary text-white">მეტის ნახვა</a>
                            </p>
                        </div>
                        <!-- /.featured-text -->
                    </div>
                </div>
                <div class="col-md-6 col-lg-4 col-12 my-2">
                    <!-- BEGIN FEATURED POST -->
                    <div class="featured-post-wide thumbnail">
                        <img src="https://cdn0.iconfinder.com/data/icons/mixer-2019/128/mixer-83-512.png" class="img-fluid" alt="Image">
                        <div class="featured-text relative-left">
                            <h4 class="primary">
                                <a href="#">პროექტის დასახელება</a>
                            </h4>
                            <p>მოკლე აღწერა, მოკლე აღწერა, მოკლე აღწერა მოკლე აღწერა, მოკლე აღწერა</p>

                            <p class="additional-post-wrap">
                                <span class="d-block">თემატიკა: გენდერული თანასწორობა</span>
                                <span class="d-block">სტატუსი: შეფასების პროცესში</span>
                            </p>
                            <hr>
                            <p class="text-right">
                                <a href="#" class="btn btn-primary text-white">მეტის ნახვა</a>
                            </p>
                        </div>
                        <!-- /.featured-text -->
                    </div>
                </div>
                <div class="col-md-6 col-lg-4 col-12 my-2">
                    <!-- BEGIN FEATURED POST -->
                    <div class="featured-post-wide thumbnail">
                        <img src="https://cdn0.iconfinder.com/data/icons/mixer-2019/128/mixer-83-512.png" class="img-fluid" alt="Image">
                        <div class="featured-text relative-left">
                            <h4 class="primary">
                                <a href="#">პროექტის დასახელება</a>
                            </h4>
                            <p>მოკლე აღწერა, მოკლე აღწერა, მოკლე აღწერა მოკლე აღწერა, მოკლე აღწერა</p>

                            <p class="additional-post-wrap">
                                <span class="d-block">თემატიკა: გენდერული თანასწორობა</span>
                                <span class="d-block">სტატუსი: შეფასების პროცესში</span>
                            </p>
                            <hr>
                            <p class="text-right">
                                <a href="#" class="btn btn-primary text-white">მეტის ნახვა</a>
                            </p>
                        </div>
                        <!-- /.featured-text -->
                    </div>
                </div>
                <div class="col-md-6 col-lg-4 col-12 my-2">
                    <!-- BEGIN FEATURED POST -->
                    <div class="featured-post-wide thumbnail">
                        <img src="https://cdn0.iconfinder.com/data/icons/mixer-2019/128/mixer-83-512.png" class="img-fluid" alt="Image">
                        <div class="featured-text relative-left">
                            <h4 class="primary">
                                <a href="#">პროექტის დასახელება</a>
                            </h4>
                            <p>მოკლე აღწერა, მოკლე აღწერა, მოკლე აღწერა მოკლე აღწერა, მოკლე აღწერა</p>

                            <p class="additional-post-wrap">
                                <span class="d-block">თემატიკა: გენდერული თანასწორობა</span>
                                <span class="d-block">სტატუსი: შეფასების პროცესში</span>
                            </p>
                            <hr>
                            <p class="text-right">
                                <a href="#" class="btn btn-primary text-white">მეტის ნახვა</a>
                            </p>
                        </div>
                        <!-- /.featured-text -->
                    </div>
                </div>
            </div>
        </div>
    </div>

@stop