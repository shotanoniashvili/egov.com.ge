@extends('layouts/default')

{{-- Page title --}}
@section('title')
    ჩვენ შესახებ
    @parent
@stop

{{-- page level styles --}}
@section('header_styles')
    <!--page level css starts-->
    <link rel="stylesheet" type="text/css" href="{{ asset('css/frontend/aboutus.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('vendors/animate/animate.min.css') }}"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('vendors/owl_carousel/css/owl.carousel.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('vendors/owl_carousel/css/owl.theme.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('vendors/devicon/devicon.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('vendors/devicon/devicon-colors.css') }}">
    <!--end of page level css-->
@stop

{{-- breadcrumb --}}
@section('top')
    <div class="breadcum">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <ol class="breadcrumb">
                        <li>
                            <a href="{{ route('home') }}"> <i class="livicon icon3 icon4" data-name="home"
                                                              data-size="18" data-loop="true" data-c="#3d3d3d"
                                                              data-hc="#3d3d3d"></i>მთავარი
                            </a>
                        </li>
                        <li class="d-none d-sm-block">
                            <i class="livicon icon3" data-name="angle-double-right" data-size="18" data-loop="true"
                               data-c="#01bc8c" data-hc="#01bc8c"></i>
                            <a href="#">ჩვენ შესახებ</a>
                        </li>
                    </ol>
                    <div class="float-right mt-1">
                        <i class="livicon icon3" data-name="users" data-size="20" data-loop="true" data-c="#3d3d3d"
                           data-hc="#3d3d3d"></i> ჩვენ შესახებ
                    </div>
                </div>
            </div>

        </div>
    </div>
@stop


{{-- Page content --}}
@section('content')
    <!-- Container Section Start -->
    <div class="container">
        <!-- Slider Section Start -->
        <div class="row my-3 h-100">

            <div class="text-center">
                <h3><span class="heading_border bg-success">საუკეთესო პრაქტიკის პროგრამის შესახებ</span></h3>
            </div>
            <div class="row">
                <div class="col-md-10 col-xs-10 col-sm-10">
                    <div class="aboutus">
                    <p>საქართველოს მუნიციპალიტეტებში არსებული საუკეთესო პრაქტიკის მაგალითების გამოვლენისა და
                        გამოცდილების სხვა მუნიციპალიტეტებისთვის გაზიარების მიზნით, საქართველოს ადგილობრივ
                        თვითმმართველობათა ეროვნული ასოციაცია (NALAG), პროექტის - „ეფექტიანობის და განვითარების ქსელი“
                        (N4ED) - ფარგლებში, საუკეთესო პრაქტიკის პროგრამას ახორციელებს.</p>
                    <p>

                        საუკეთესო პრაქტიკის პროგრამა გახლავთ ევროპის საბჭოს მიერ აღიარებული და ევროპის საბჭოს წევრ
                        ქვეყნებში ფართოდ გამოყენებული ინსტრუმენტი, რომელიც ემსახურება მუნიციპალიტეტებში ადგილობრივი
                        თვითმმართველობის უფლებამოსილებების განხორციელებასთან დაკავშირებული წარმატების მაგალითების
                        გამოვლენას და მათ გამოყენებას სხვა მუნიციპალიტეტებში.
                    </p>

                    <p>
                        საუკეთესო პრაქტიკის პროგრამა მუნიციპალიტეტებს აძლევს საშუალებას მოახდინონ თავისი ეფექტიანი
                        მუშაობის დემონსტრირება, გაიზიარონ ერთმანეთის გამოცდილება და სწორედ ამ გამოცდილებაზე დაყრდნობით
                        დანერგონ მათ წინაშე არსებულ გამოწვევევებთან გამკლავების უკვე აპრობირებული, ხოლო რიგ შემთხვევებში
                        ინოვაციური გზები.

                    </p>

                    <p>

                        საუკეთესო პრაქტიკის პროგრამის ფარგლებში, საქართველოს ადგილობრივ თვითმმართველობათა ეროვნული
                        ასოციაცია (NALAG), ყოველწლიურად ატარებს საუკეთესო პრაქტიკის კონკურსს.
                    </p>


                    <p>
                        მუნიციპალიტეტებს შორის კონკურსის გამოცხადებისა და მისი ჩატარების ორგანიზაციული უზრუნველყოფის
                        მიზნით, პროგრამის ფარგლებში იქმნება დროებითი ორგანოები - კონკურსის მმართველი კომიტეტი და
                        შეფასების კომისია.
                    </p>

                    <p>
                        იმისთვის რომ საქართველოს მუნიციპალიტეტების მიერ წარმოდგენილი ქეისი აღიარებული იქნას როგორც
                        საუკეთესო პრაქტიკა, იგი უნდა აკმაყოფილებდეს რამდენიმე ძირითად კრიტერიუმს; უნდა იყოს წარმატებული,
                        გამჭვირვალე, ადეკვატური, გაზიარებადი და მდგრადი.
                    </p>

                    </div>
                </div>


            </div>
            <!-- left Section Start -->

            <!-- Our Team Section Start -->


        </div>
    </div>
    @stop

    {{-- page level scripts --}}
    @section('footer_scripts')
        <!-- page level js starts-->
            <script type="text/javascript" src="{{ asset('vendors/owl_carousel/js/owl.carousel.min.js') }}"></script>
            <script type="text/javascript" src="{{ asset('vendors/wow/js/wow.min.js') }}"></script>
            <script type="text/javascript" src="{{ asset('js/frontend/carousel.js') }}"></script>
            <script type="text/javascript" src="{{ asset('js/frontend/aboutus.js') }}"></script>
            <!--page level js ends-->
@stop
