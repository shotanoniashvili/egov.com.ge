<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
    <title>
        @section('title')
        | NALA
        @show
    </title>
    <!--global css starts-->
    <link rel="stylesheet" type="text/css" href="{{ asset('css/lib.css') }}">
    <style>
      .dropdown-item:active{
            background-color: transparent !important;
        }
      .indexpage.navbar-nav >.nav-item .nav-link:hover {
          color: #01bc8c;
      }
    </style>
    <!--end of global css-->
    <!--page level css-->
    @yield('header_styles')
    <!--end of page level css-->
</head>

<body>
<div class="body">
<!-- Header Start -->
<header>
    <div class="container indexpage py-3">
        <div class="header-search mb-3">
            <form class="form-inline my-2 my-lg-0 float-right" action="{{ route('search') }}">
                <input name="q" class="form-control mr-sm-2" type="search" placeholder="ძიება" aria-label="Search">
                <button class="btn btn-outline-success my-2 my-sm-0" type="submit">
                    <i class="fa fa-search"></i>
                </button>
            </form>
            <div class="clearfix"></div>
        </div>
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            {{--<a class="navbar-brand" href="{{ route('home') }}">
                <img src="{{ asset('images/logo.png') }}" alt="logo">
            </a>--}}
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                    aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ml-auto  margin_right">
                    <li  class="nav-item {!! (Request::is('/') ? 'active' : '') !!}">
                        <a href="{{ route('home') }}" class="nav-link"> მთავარი</a>
                    </li>
                    <li  class="nav-item {!! (Request::is('aboutus') ? 'active' : '') !!}">
                        <a href="{{ URL::to('aboutus') }}" class="nav-link"> ჩვენ შესახებ</a>
                    </li>
                    <li  class="nav-item {!! (Request::is('best-practice') ? 'active' : '') !!}">
                        <a href="{{ URL::to('best-practice') }}" class="nav-link"> საუკეთესო პრაქტიკა</a>
                    </li>
                    <li  class="nav-item {!! (Request::is('municipalities') ? 'active' : '') !!}">
                        <a href="{{ URL::to('municipalities') }}" class="nav-link"> მუნიციპალიტეტები</a>
                    </li>
                    <li  class="nav-item {!! (Request::is('news') ? 'active' : '') !!}">
                        <a href="{{ URL::to('news') }}" class="nav-link"> სიახლეები</a>
                    </li>
                    <li  class="nav-item {!! (Request::is('archive') ? 'active' : '') !!}">
                        <a href="{{ URL::to('archive') }}" class="nav-link"> არქივი</a>
                    </li>
                    <li  class="nav-item {!! (Request::is('faq') ? 'active' : '') !!}">
                        <a href="{{ URL::to('faq') }}" class="nav-link"> კითხვა პასუხი</a>
                    </li>
                    <li  class="nav-item {!! (Request::is('contact') ? 'active' : '') !!}">
                        <a href="{{ URL::to('contact') }}" class="nav-link"> კონტაქტი</a>
                    </li>
                    {{--<li class="nav-item {!! (Request::is('contact') ? 'active' : '') !!}">
                        <a href="{{ URL::to('contact') }}" class="nav-link">კონტაქტი</a>
                    </li>--}}

                    {{--based on anyone login or not display menu items--}}
                    @if(!Sentinel::guest())
                        <li class="nav-item {{ (Request::is('my-account') ? 'active' : '') }}">
                            <a href="{{ URL::to('my-account') }}" class="nav-link">ჩემი გვერდი</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ URL::to('logout') }}" class="nav-link" title="სისტემიდან გასვლა">
                                <i class="livicon" data-name="sign-out" data-s="18"></i>
                            </a>
                        </li>
                    @endif
                </ul>
            </div>
        </nav>
        <!-- Nav bar End -->
    </div>
</header>

<!-- //Header End -->

<!-- slider / breadcrumbs section -->
@yield('top')

<!-- Content -->
    @yield('content')
<!-- Footer Section Start -->
</div>
<footer>
{{--    <div class=" container">--}}
{{--        <div class="footer-text">--}}
{{--            <!-- About Us Section Start -->--}}
{{--            <div class="row">--}}
{{--                <div class="col-sm-4 col-lg-4 col-md-4 col-12">--}}
{{--                    <h4>პროექტის შესახებ</h4>--}}
{{--                    <p>--}}
{{--                        Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been--}}
{{--                        the industryzzzz's standard dummy text ever since the 1500s, when an unknown printer took a galley--}}
{{--                        of type and scrambled it to make a type specimen book.It has survived not only five centuries,--}}
{{--                        but also the leap into electronic typesetting, remaining essentially unchanged.--}}
{{--                    </p>--}}
{{--                    <hr id="hr_border2">--}}
{{--                    <h4 class="menu">Follow Us</h4>--}}
{{--                    <ul class="list-inline mb-2">--}}
{{--                        <li>--}}
{{--                            <a href="#"> <i class="livicon" data-name="facebook" data-size="18" data-loop="true"--}}
{{--                                            data-c="#ccc" data-hc="#ccc"></i>--}}
{{--                            </a>--}}
{{--                        </li>--}}
{{--                        <li>--}}
{{--                            <a href="#"> <i class="livicon" data-name="twitter" data-size="18" data-loop="true"--}}
{{--                                            data-c="#ccc" data-hc="#ccc"></i>--}}
{{--                            </a>--}}
{{--                        </li>--}}
{{--                        <li>--}}
{{--                            <a href="#"> <i class="livicon" data-name="google-plus" data-size="18" data-loop="true"--}}
{{--                                            data-c="#ccc" data-hc="#ccc"></i>--}}
{{--                            </a>--}}
{{--                        </li>--}}
{{--                        <li>--}}
{{--                            <a href="#"> <i class="livicon" data-name="linkedin" data-size="18" data-loop="true"--}}
{{--                                            data-c="#ccc" data-hc="#ccc"></i>--}}
{{--                            </a>--}}
{{--                        </li>--}}
{{--                        <li>--}}
{{--                            <a href="#"> <i class="livicon" data-name="rss" data-size="18" data-loop="true"--}}
{{--                                            data-c="#ccc" data-hc="#ccc"></i>--}}
{{--                            </a>--}}
{{--                        </li>--}}
{{--                    </ul>--}}
{{--                </div>--}}
{{--                <!-- //About us Section End -->--}}
{{--                <!-- Contact Section Start -->--}}
{{--                <div class="col-sm-4 col-lg-4 col-md-4 col-12">--}}
{{--                    <h4>Contact Us</h4>--}}
{{--                    <ul class="list-unstyled">--}}
{{--                        <li>35,Lorem Lis Street, Park Ave</li>--}}
{{--                        <li>Lis Street, India.</li>--}}
{{--                        <li><i class="livicon icon4 icon3" data-name="cellphone" data-size="18" data-loop="true"--}}
{{--                               data-c="#ccc" data-hc="#ccc"></i>Phone:9140 123 4588--}}
{{--                        </li>--}}
{{--                        <li><i class="livicon icon4 icon3" data-name="printer" data-size="18" data-loop="true"--}}
{{--                               data-c="#ccc" data-hc="#ccc"></i> Fax:400 423 1456--}}
{{--                        </li>--}}
{{--                        <li><i class="livicon icon3" data-name="mail-alt" data-size="20" data-loop="true" data-c="#ccc"--}}
{{--                               data-hc="#ccc"></i> Email:<span class="text-success" style="cursor: pointer;">--}}
{{--                        info@joshadmin.com</span>--}}
{{--                        </li>--}}
{{--                        <li><i class="livicon icon4 icon3" data-name="skype" data-size="18" data-loop="true"--}}
{{--                               data-c="#ccc" data-hc="#ccc"></i> Skype:--}}
{{--                            <span class="text-success" style="cursor: pointer;">Joshadmin</span>--}}
{{--                        </li>--}}
{{--                    </ul>--}}
{{--                    <hr id="hr_border">--}}
{{--                    <div class="news menu">--}}
{{--                        <h4>News letter</h4>--}}
{{--                        <p>subscribe to our newsletter and stay up to date with the latest news and deals</p>--}}
{{--                        <div class="form-group">--}}
{{--                            <input type="text" class="form-control" placeholder="yourmail@mail.com"--}}
{{--                                   aria-describedby="basic-addon2">--}}
{{--                            <a href="#" class="btn btn-primary text-white" role="button">Subscribe</a>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                <!-- //Contact Section End -->--}}
{{--                <!-- Recent post Section Start -->--}}
{{--                <div class="col-sm-4 col-lg-4 col-md-4 col-12">--}}
{{--                    <h4>Recent Posts</h4>--}}
{{--                    <div class="media">--}}
{{--                        <img class="media-object rounded-circle mr-3" src="{{ asset('images/image_14.jpg') }}"--}}
{{--                             alt="image">--}}
{{--                        <div class="media-body">--}}
{{--                            <p class="media-heading text-justify">Lorem Ipsum is simply dummy text of the printing and type setting--}}
{{--                                industry dummy.</p>--}}
{{--                            <p class="text-right"><i>Sam Bellows</i></p>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                    <div class="media">--}}
{{--                        <img class="media-object rounded-circle mr-3" src="{{ asset('images/image_15.jpg') }}"--}}
{{--                             alt="image">--}}

{{--                        <div class="media-body">--}}
{{--                            <p class="media-heading text-justify">Lorem Ipsum is simply dummy text of the printing and type setting--}}
{{--                                industry dummy.</p>--}}
{{--                            <p class="text-right"><i>Emilly Barbosa Cunha</i></p>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                    <div class="media">--}}
{{--                        <img class="media-object rounded-circle mr-3" src="{{ asset('images/image_13.jpg') }}"--}}
{{--                             alt="image">--}}
{{--                        <div class="media-body">--}}
{{--                            <p class="media-heading text-justify">Lorem Ipsum is simply dummy text of the printing and type setting--}}
{{--                                industry dummy.</p>--}}
{{--                            <p class="text-right"><i>Sinikka Oramo</i></p>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                    <div class="media">--}}
{{--                        <img class="media-object rounded-circle mr-3" src="{{ asset('images/c1.jpg') }}"--}}
{{--                             alt="image">--}}

{{--                        <div class="media-body">--}}
{{--                            <p class="media-heading text-justify">Lorem Ipsum is simply dummy text of the printing and type setting--}}
{{--                                industry dummy.</p>--}}
{{--                            <p class="text-right"><i>Samsa Parras</i></p>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                    <!-- //Recent Post Section End -->--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
<!-- //Footer Section End -->
<div class=" col-12 copyright">
    <div class="container">
        <p>Copyright &copy; EGOV.com.ge 2019</p>
    </div>
</div>
</footer>


<!--global js starts-->
<script type="text/javascript" src="{{ asset('js/frontend/lib.js') }}"></script>
<!--global js end-->
<!-- begin page level js -->
@yield('footer_scripts')
<!-- end page level js -->
<script>
    $(".navbar-toggler-icon").click(function () {
        $(this).closest('.navbar').find('.collapse').toggleClass('collapse1')
    })

    $(function () {
        $('[data-toggle="tooltip"]').tooltip().css('font-size', '14px');
    })
</script>

</body>

</html>
