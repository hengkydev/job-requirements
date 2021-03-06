<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{$__INFO->name}} | Masuk ke Sistem Management Website</title>
    
    <!-- ICON -->
    <link rel="icon" href="{{$__INFO->icon_dir->xs}}" type="image/png" sizes="16x16">
    <link rel="icon" href="{{$__INFO->icon_dir->xs}}" type="image/png" sizes="32x32">
    <link rel="icon" href="{{$__INFO->icon_dir->sm}}" type="image/png" sizes="120x120">
    <link rel="icon" href="{{$__INFO->icon_dir->md}}" type="image/png" sizes="240x240">
    <META NAME="ROBOTS" CONTENT="NOINDEX, NOFOLLOW">
    
    @yield("meta")

    <!-- Global stylesheets -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet" type="text/css">
    <link href="{{base_url('panelassets/css/icons/icomoon/styles.css')}}" rel="stylesheet" type="text/css">
    <link href="{{base_url('panelassets/css/bootstrap.css')}}" rel="stylesheet" type="text/css">
    <link href="{{base_url('panelassets/css/core.css')}}" rel="stylesheet" type="text/css">
    <link href="{{base_url('panelassets/css/components.css')}}" rel="stylesheet" type="text/css">
    <link href="{{base_url('panelassets/css/colors.css')}}" rel="stylesheet" type="text/css">
    <link href="{{base_url('mainassets/css/default.css')}}" rel="stylesheet" type="text/css">
    <link href="{{base_url('mainassets/css/panel.css')}}" rel="stylesheet" type="text/css">
    @yield("styles")
    <!-- /global stylesheets -->
</head>

<body class="login-container">
    <div class="bg-wallpaper-student">
        <div class="time-frame">
            <div id="time-part"></div>
            <div id="date-part"></div>
        </div>
    <!-- Page container -->
        @yield("content")
    </div>
    <!-- /page container -->
    <!-- Core JS files -->
    @include("pieces.env.scripts")

    <script type="text/javascript" src="{{base_url('panelassets/js/plugins/loaders/pace.min.js')}}"></script>
    <script type="text/javascript" src="{{base_url('panelassets/js/core/libraries/jquery.min.js')}}"></script>
    <script type="text/javascript" src="{{base_url('panelassets/js/core/libraries/bootstrap.min.js')}}"></script>
    <script type="text/javascript" src="{{base_url('panelassets/js/plugins/loaders/blockui.min.js')}}"></script>
    <script type="text/javascript" src="{{base_url('panelassets/js/plugins/ui/nicescroll.min.js')}}"></script>
    <script type="text/javascript" src="{{base_url('panelassets/js/plugins/ui/drilldown.js')}}"></script>
    <script type="text/javascript" src="{{base_url('panelassets/js/plugins/media/fancybox.min.js')}}"></script>

    <!-- /core JS files -->

    <!-- Theme JS files -->
    <script type="text/javascript" src="{{base_url('panelassets/js/plugins/forms/styling/switchery.min.js')}}"></script>
    <script type="text/javascript" src="{{base_url('panelassets/js/plugins/forms/styling/uniform.min.js')}}"></script>
    <script type="text/javascript" src="{{base_url('panelassets/js/plugins/ui/moment/moment.min.js')}}"></script>
    <script type="text/javascript" src="{{base_url('panelassets/js/plugins/notifications/sweet_alert.min.js')}}"></script>
    <script type="text/javascript" src="{{base_url('panelassets/js/plugins/notifications/pnotify.min.js')}}"></script>
    <script type="text/javascript" src="{{base_url('panelassets/js/plugins/notifications/noty.min.js')}}"></script>
    <script type="text/javascript" src="{{base_url('panelassets/js/plugins/notifications/jgrowl.min.js')}}"></script>

    <script type="text/javascript" src="{{base_url('panelassets/js/core/app.js')}}"></script>
    <script type="text/javascript" src="{{base_url('panelassets/js/pages/login.js')}}"></script>

    <script type="text/javascript" src="{{base_url('panelassets/js/plugins/ui/ripple.min.js')}}"></script>
    @yield("scripts")
    <script type="text/javascript" src="{{base_url('mainassets/js/library.js')}}"></script>
    <!-- /theme JS files -->
</body>
</html>
