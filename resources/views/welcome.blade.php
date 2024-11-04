{{--<!DOCTYPE html>--}}
{{--<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">--}}
{{--<head>--}}
{{--    <meta charset="utf-8">--}}
{{--    <meta name="viewport" content="width=device-width, initial-scale=1">--}}
{{--    <title>ًApplication</title>--}}
{{--    @vite('resources/css/app.css')--}}
{{--</head>--}}
{{--<body>--}}
{{--<div id="app"></div>--}}
{{--@vite('resources/js/app.js')--}}
{{--</body>--}}
{{--</html>--}}

    <!DOCTYPE html>
<html lang="en">


<!-- Mirrored from qerza.dexignzone.com/xhtml/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Fri, 26 Apr 2024 19:24:06 GMT -->
<head>
    <!-- Title -->
    <title>Comment system</title>

    <!-- Meta -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="author" content="Devblinks">
    <meta name="robots" content="">
    <meta name="keywords" content="Nutrichdiet">
    <meta name="description" content="Nutrichdiet">
    <meta property="og:title" content="Nutrichdiet">
    <meta property="og:description" content="Nutrichdiet">
    <meta property="og:image" content="social-image.png">
    <meta name="format-detection" content="telephone=no">

    <!-- Mobile Specific -->
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Favicon icon -->
{{--    <link rel="icon" type="image/x-icon" href="/images/nd-01.ico">--}}
    <link href="{{asset('/vendor/jqvmap/css/jqvmap.min.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('/vendor/chartist/css/chartist.min.css')}}">
    <link href="{{asset('/vendor/bootstrap-select/dist/css/bootstrap-select.min.css')}}" rel="stylesheet">
    <link href="{{asset('/vendor/owl-carousel/owl.carousel.css')}}" rel="stylesheet">
    <link href="{{asset('/css/style.css')}}" rel="stylesheet">
    <link href="{{asset('/vendor/datatables/css/jquery.dataTables.min.css')}}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&amp;family=Roboto:wght@100;300;400;500;700;900&amp;display=swap" rel="stylesheet">
    @vite('resources/css/app.css')
</head>
<body>
<div id="app"></div>

<!--**********************************
    Scripts
***********************************-->
<!-- Required vendors -->
@vite('resources/js/app.js')
<script src="{{asset('/vendor/datatables/js/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('/js/plugins-init/datatables.init.js')}}'"></script>

<script src="{{asset('/vendor/global/global.min.js')}}"></script>
<script src="{{asset('/vendor/bootstrap-select/dist/js/bootstrap-select.min.js')}}"></script>
<script src="{{asset('/vendor/chart-js/chart.bundle.min.js')}}"></script>
<script src="{{asset('/vendor/owl-carousel/owl.carousel.js')}}"></script>

<!-- Chart piety plugin files -->
<script src="{{asset('/vendor/peity/jquery.peity.min.js')}}"></script>

<!-- Apex Chart -->
<script src="{{asset('/vendor/apexchart/apexchart.js')}}"></script>

<!-- Dashboard 1 -->
<script src="{{asset('/js/dashboard/dashboard-1.js')}}"></script>
<script src="{{asset('/js/custom.min.js')}}"></script>
<script src="{{asset('/js/deznav-init.js')}}"></script>
<script src="{{asset('/js/demo.js')}}"></script>
<script src="{{asset('/js/styleSwitcher.js')}}"></script>
<script>
    function carouselReview(){
        /*  testimonial one function by = owl.carousel.js */
        function checkDirection() {
            var htmlClassName = document.getElementsByTagName('html')[0].getAttribute('class');
            if(htmlClassName == 'rtl') {
                return true;
            } else {
                return false;

            }
        }

        jQuery('.testimonial-one').owlCarousel({
            loop:true,
            autoplay:true,
            margin:30,
            nav:false,
            dots: false,
            rtl: checkDirection(),
            left:true,
            navText: ['', ''],
            responsive:{
                0:{
                    items:1
                },
                1200:{
                    items:2
                },
                1600:{
                    items:3
                }
            }
        })
    }
    jQuery(window).on('load',function(){
        setTimeout(function(){
            carouselReview();
        }, 1000);
    });
</script>
</body>

<!-- Mirrored from qerza.dexignzone.com/xhtml/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Fri, 26 Apr 2024 19:24:35 GMT -->
</html>
