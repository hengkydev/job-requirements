<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title')</title>
    <link rel="icon" href="{{$config->iconfile}}">
    <meta name="description" content="Terjadi Kesalahan">
    <meta name="keyword" content="error , not found , unactive">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Global stylesheets -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet" type="text/css">
    <link href="{{base_url()}}admin_assets/css/icons/icomoon/styles.css" rel="stylesheet" type="text/css">
    <link href="{{base_url()}}admin_assets/css/minified/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="{{base_url()}}admin_assets/css/minified/core.min.css" rel="stylesheet" type="text/css">
    <link href="{{base_url()}}admin_assets/css/minified/components.min.css" rel="stylesheet" type="text/css">
    <link href="{{base_url()}}admin_assets/css/minified/colors.min.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css">
    
    <!-- /global stylesheets -->

    <!-- Core JS files -->
    <script type="text/javascript" src="{{base_url()}}admin_assets/js/plugins/loaders/pace.min.js"></script>
    <script type="text/javascript" src="{{base_url()}}admin_assets/js/core/libraries/jquery.min.js"></script>
    <script type="text/javascript" src="{{base_url()}}admin_assets/js/core/libraries/bootstrap.min.js"></script>
    <script type="text/javascript" src="{{base_url()}}admin_assets/js/plugins/loaders/blockui.min.js"></script>
    <script type="text/javascript" src="{{base_url()}}admin_assets/js/plugins/notifications/pnotify.min.js"></script>
    <script type="text/javascript" src="{{base_url()}}admin_assets/js/plugins/notifications/noty.min.js"></script>
    <script type="text/javascript" src="{{base_url()}}admin_assets/js/plugins/notifications/jgrowl.min.js"></script>
    <script type="text/javascript" src="{{base_url()}}admin_assets/js/plugins/ui/prism.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert-dev.min.js"></script>


    <!-- /core JS files -->


    <!-- Theme JS files -->
    <script type="text/javascript" src="{{base_url()}}admin_assets/js/core/app.js"></script>
    <script type="text/javascript" src="{{base_url()}}admin_assets/js/pages/components_notifications_other.js"></script>
    <script type="text/javascript" src="{{base_url()}}admin_assets/js/pages/extension_blockui.js"></script>
    <style type="text/css">
    body {
        background:url("{{base_url('images/website/background-register.jpg')}}") no-repeat  fixed !important;
        background-size: cover;

        background-position: fixed !important;
    }
    .margin-center {
        float: none;
        margin-left: auto;
        margin-right: auto;
    }
    .gap {
        height: 30px;
    }

    .gap-md {
        height: 20px;
    }

    .gap-sm {
        height: 10px;
    }

    .gap-xs {
        height: 5px;
    }

    .error-font {
        font-size: 100px;
    }
    </style>
    <!-- /theme JS files -->

</head>

<body>


    <!-- Page container -->
    <div class="page-container login-container">

        <!-- Page content -->
        <div class="page-content">

            <!-- Main content -->
            <div class="content-wrapper">

                <!-- Content area -->
                <div class="content">

                    <!-- Simple login form -->
                    @yield('content')

                    <!-- Footer -->
                    <div class="footer text-muted">
                        &copy; 2016. <a href="{{base_url()}}" class="text-info">{{ucwords($config->name)}}</a> Dari <a  class="text-info" href="{{base_url()}}" target="_blank"> Pengembang</a>
                    </div>
                    <!-- /footer -->

                </div>
                <!-- /content area -->

            </div>
            <!-- /main content -->

        </div>
        <!-- /page content -->

    </div>
    <!-- /page container -->
    <script type="text/javascript">
        var base_url = '{{base_url()}}';
    </script>
    <script type="text/javascript" src="{{base_url()}}assets/js/aksa-js.js"></script>

</body>
</html>
