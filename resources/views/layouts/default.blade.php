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
    <div class="container-fluid indexpage py-3">
        <div class="row">
            <div class="header-logos col-sm-12">
                <div class="logos">
                    <div class="european-union float-left">
                        <a href="{{ url('/') }}"><img alt="EU4Georgia" title="EU4Georgia" src="{{ asset('public/images/eu4georgia.jpg') }}" /> </a>
                    </div>
                    <div class="nala float-right">
                        <a href="{{ url('/') }}"><img alt="Nala" title="Nala" src="{{ asset('public/images/nala.png') }}" /> </a>
                    </div>
                </div>
            </div>
            <div class="header-search col-sm-12">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-12">
                            <form class="form-inline my-2 my-lg-0 float-none float-md-right" action="{{ route('search') }}">
                                <input name="q" class="form-control mr-sm-2 search-input" type="search" placeholder="ძიება" aria-label="Search">
                                <button class="btn btn-nala my-2 my-sm-0" type="submit">
                                    <i class="fa fa-search"></i>
                                </button>
                            </form>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="navbar-container bg-nala">
        <div class="container">
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
                        <li  class="nav-item {!! (Request::is('news') ? 'active' : '') !!}">
                            <a href="{{ URL::to('news') }}" class="nav-link"> სიახლეები</a>
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
                                @if(Sentinel::getUser()->roles()->where('slug', 'admin')->count() > 0)
                                    <a href="{{ URL::to('admin') }}" class="nav-link">ჩემი გვერდი</a>
                                    @else
                                    <a href="{{ URL::to('my-account') }}" class="nav-link">ჩემი გვერდი</a>
                                @endif
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
    <div class=" container">
        <div class="footer-text">
            <!-- About Us Section Start -->
            <div class="row">
                <div class="col-sm-4 col-lg-4 col-md-4 col-12">
                    <p class="text-left">
                        ეს ვებსაიტი შექმნილია ევროკავშირის მხარდაჭერით. მის შინაარსზე სრულად პასუხისმგებელია საქართველოს ადგილობრივ თვითმმართველობათა ეროვნული ასოციაცია და შესაძლოა, რომ იგი არ გამოხატავდეს ევროკავშირის შეხედულებებს
                    </p>
                    <p class="text-left">
                        This website has been produced with the assistance of the European Union. Its contents are the sole responsibility of National Association of Local Authorities of Georgia and do not necessarily reflect the views of the European Union.                    </p>
                </div>
                <!-- //About us Section End -->
                <!-- Contact Section Start -->
                <div class="col-sm-4 col-lg-4 col-md-4 col-12">
                    <h4>საკონტაქტო ინფრომაცია</h4>
                    <ul class="list-unstyled">
                        <li><i class="livicon icon4 icon3" data-name="cellphone" data-size="18" data-loop="true"
                               data-c="#ccc" data-hc="#ccc"></i>ტელეფონი: 0322726734
                        </li>
                        <li><i class="livicon icon3" data-name="mail-alt" data-size="20" data-loop="true" data-c="#ccc"
                               data-hc="#ccc"></i> ელ. ფოსტა:<span class="color-nala" style="cursor: pointer;">
                        bp@nala.ge</span>
                        </li>
                    </ul>
                </div>
                <!-- //Contact Section End -->
                <!-- Recent post Section Start -->
                <div class="col-sm-4 col-lg-4 col-md-4 col-12">
                    <h4>სასარგებლო ბმულები</h4>
                    <ul class="list-unstyled">
                        <li><a href="{{ url('/') }}">მთავარი</a></li>
                        <li><a href="{{ url('/contact') }}">კონტაქტი</a></li>
                        <li><a href="{{ url('/aboutus') }}">პროექტის შესახებ</a></li>
                        <li><a target="_blank" href="https://eeas.europa.eu/delegations/georgia_en">ევროკავშირის წარმომადგენლობა საქართველოში</a></li>
                        <li><a target="_blank" href="https://www.facebook.com/EuropeanUnioninGeorgia">European Union in Georgia</a></li>
                        <li><a target="_blank" href="https://twitter.com/EUinGeorgia">EUDelegation Georgia</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
<!-- //Footer Section End -->
<div class=" col-12 copyright bg-nala">
    <div class="container">
        <p>შექმნილია <a href="http://egov.com.ge"> egov.com.ge</a>-ს მიერ</p>
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
