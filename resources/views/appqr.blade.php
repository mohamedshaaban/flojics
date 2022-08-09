<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- FontFace CSS -->
    <link href="/fonts/stylesheet.css" rel="stylesheet">

    <!-- Slick SLider CSS -->
    <link rel="stylesheet" href="/css/slick.css" />
    <link href="/css/select2.css" rel="stylesheet">
@if (app()->getLocale() == 'en')
    <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="/css/bootstrap.min.css" >
        <link rel="stylesheet" href="https://unpkg.com/vue-multiselect@2.1.0/dist/vue-multiselect.min.css">
        <!-- Custom CSS -->
        <link href="/css/style.css" rel="stylesheet">
@else
    <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="/css/bootstrap.min_AR.css" >

        <!-- Custom CSS -->
        <link href="/css/style_AR.css" rel="stylesheet">
    @endif
    <link href="/css/custom-dev-style.css" rel="stylesheet">

    <!-- Q-tip Plugin -->
    <link href="/css/qtip.css" rel="stylesheet">

    <!-- FontAwesome CSS -->
    <script src="https://kit.fontawesome.com/667634235d.js" crossorigin="anonymous"></script>
    <link href="https://unpkg.com/gijgo@1.9.13/css/gijgo.min.css" rel="stylesheet" type="text/css" />

    {!! $settings['google_code'] !!}

    <link id="" rel="shortcut icon" href="/favicon.ico?" />
    {{-- <title id="title"></title> --}}

</head>
<body>
<div id="app">
    <app></app>


</div>

<script src="{{ mix('js/app.js') }}" type="text/javascript"></script>
<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="/js/jquery.js" ></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

<script src="/js/slick.js"></script>
<script src="/js/select2.js"></script>
<script src="/js/custom.js"></script>
<script src="https://unpkg.com/gijgo@1.9.13/js/gijgo.min.js" type="text/javascript"></script>
<script type="text/javascript" src="/js/jquery.maphilight.js"></script>
<script src="/js/qtip.js"></script>
<script src="/js/responsive_image_map.js"></script>
<script src="https://www.youtube.com/iframe_api"></script>

<script type="text/javascript">
    //Load More Listing Brand Page//
    $(document).ready(function(){
        var ua = window.navigator.userAgent;
        var msie = ua.indexOf('MSIE ');
        if (msie > 0) {
            // IE 10 ou plus ancien, renvoie le nombre de version
            // alert ('IE ' + parseInt(ua.substring(msie + 5, ua.indexOf('.', msie)), 10));
            window.location.href="/internet_explorer";
        }
        var trident = ua.indexOf('Trident/');
        if (trident > 0) {
            // IE 11, renvoie le nombre de version
            // var rv = ua.indexOf('rv:');
            // alert ('IE ' + parseInt(ua.substring(rv + 3, ua.indexOf('.', rv)), 10));
            window.location.href="/internet_explorer";
        }
    });
</script>

{!! $settings['chat_code'] !!}
<script type="text/javascript">
    $(function () {
        $('#datepicker').datepicker({
            uiLibrary: 'bootstrap4'
        });
    });
</script>
<script>
    $('#input').datetimepicker({minDate:0, footer: true, modal: true});
</script>

<script type="text/javascript">
    //Load More Listing Brand Page//
    $(document).ready(function(){
        var list = $(".list .gal-box");
        var numToShow = 9;
        var button = $("#next");
        var numInList = list.length;
        list.hide();
        if (numInList > numToShow) {
            button.show();
        }else{
            button.hide();
        }
        list.slice(0, numToShow).show();

        button.click(function(){
            var showing = list.filter(':visible').length;
            list.slice(showing - 1, showing + numToShow).fadeIn();
            var nowShowing = list.filter(':visible').length;
            if (nowShowing >= numInList) {
                button.hide();
            }
        });
    });

    $(document).ready(function(){
        var list = $(".list li");
        var numToShow = 12;
        var button = $("#next");
        var numInList = list.length;
        list.hide();
        if (numInList > numToShow) {
            button.show();
        }else{
            button.hide();
        }
        list.slice(0, numToShow).show();

        button.click(function(){
            var showing = list.filter(':visible').length;
            list.slice(showing - 1, showing + numToShow).fadeIn();
            var nowShowing = list.filter(':visible').length;
            if (nowShowing >= numInList) {
                button.hide();
            }
        });
    });
</script>

<script type="text/javascript">
    function showVideoOnHover(obj) {
        //$("#image").css("display","none");
        $("#video_1" + obj).css("display", "block");
        $('.video_plr' + obj).get(0).play()
        $('.video_plr' + obj).play();
    }
    function hideVideo(obj) {
        $("#video_1" + obj).css("display", "none");
        $("#image_2").css("display", "block");
        $('.video_plr' + obj).get(0).pause();
        $('.video_plr' + obj).pause();
    }

</script>


<!--Pcr form script starts-->
<script type="text/javascript">
    $(function () {
        $('#datepicker').datepicker({
            uiLibrary: 'bootstrap4'
        });

        $('#datepicker-dob').datepicker({
            uiLibrary: 'bootstrap4',
        });

        $('#datepicker-pass-iss').datepicker({
            uiLibrary: 'bootstrap4'
        });

        $('#datepicker-pass-exp').datepicker({
            uiLibrary: 'bootstrap4'
        });

        $('#datepicker-book-date').datepicker({
            uiLibrary: 'bootstrap4'
        });

        $('#datepicker-arrival').datepicker({
            uiLibrary: 'bootstrap4',
        });
    });
</script>
<script>
    $(document).ready(function () {
        $(".question-chk").click(function() {
            if( $(this).is(':checked') && $(this).attr("value") =="1" )  {
                //appQR
                $(this).closest('.question-hold').children('.extra-options').show(500);
            } else {
                $(this).closest('.question-hold').children('.extra-options').hide(500);
            }
        });
    });
</script>
<!--<script>
    $(document).ready(function () {
        $(".multi-choose").select2({
            tags: true,
            width: 'resolve',
            tokenSeparators: [',', ' ']
        })
    });
</script> -->

<!--Pcr form script ends -->

</body>
</html>
