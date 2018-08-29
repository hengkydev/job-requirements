<!DOCTYPE html>
<html>
  <head>
    <title>Admin Dashboard HTML Template</title>
    <meta charset="utf-8">
    <meta content="ie=edge" http-equiv="x-ua-compatible">
    <meta content="template language" name="keywords">
    <meta content="Tamerlan Soziev" name="author">
    <meta content="Admin dashboard html template" name="description">
    <meta content="width=device-width, initial-scale=1" name="viewport">
    <link href="favicon.png" rel="shortcut icon">
    <link href="apple-touch-icon.png" rel="apple-touch-icon">
    <link href="https://fonts.googleapis.com/css?family=Rubik:300,400,500" rel="stylesheet" type="text/css">
    <link href="{{base_url('panelassets/css/icons/icomoon/styles.css')}}" rel="stylesheet" type="text/css">
    <link href="{{base_url('userassets/bower_components/select2/dist/css/select2.min.css')}}" rel="stylesheet">
    <link href="{{base_url('userassets/bower_components/bootstrap-daterangepicker/daterangepicker.css')}}" rel="stylesheet">
    <link href="{{base_url('userassets/bower_components/dropzone/dist/dropzone.css')}}" rel="stylesheet">
    <link href="{{base_url('userassets/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{base_url('userassets/bower_components/fullcalendar/dist/fullcalendar.min.css')}}" rel="stylesheet">
    <link href="{{base_url('userassets/bower_components/perfect-scrollbar/css/perfect-scrollbar.min.css')}}" rel="stylesheet">
    <link href="{{base_url('userassets/css/main.css?version=3.4')}}" rel="stylesheet">
    <link href="{{base_url('panelassets/css/components.css')}}" rel="stylesheet" type="text/css">
    <link href="{{base_url('mainassets/css/default.css')}}" rel="stylesheet" type="text/css">
  </head>
  <body class="auth-wrapper">
    <div class="all-wrapper menu-side with-pattern">
      @yield("content")
    </div>
    <script type="text/javascript" src="{{base_url('panelassets/js/core/libraries/jquery.min.js')}}"></script>
    <script type="text/javascript" src="{{base_url('panelassets/js/plugins/loaders/blockui.min.js')}}"></script>
    <script type="text/javascript" src="{{base_url('panelassets/js/plugins/forms/styling/uniform.min.js')}}"></script>
    <script type="text/javascript" src="{{base_url('panelassets/js/plugins/notifications/sweet_alert.min.js')}}"></script>
    <script type="text/javascript" src="{{base_url('panelassets/js/plugins/notifications/pnotify.min.js')}}"></script>
    <script type="text/javascript" src="{{base_url('panelassets/js/plugins/notifications/noty.min.js')}}"></script>
    <script type="text/javascript" src="{{base_url('panelassets/js/plugins/notifications/jgrowl.min.js')}}"></script>
    @yield("scripts")
    <script type="text/javascript" src="{{base_url('mainassets/js/library.js')}}"></script>
  </body>
</html>
