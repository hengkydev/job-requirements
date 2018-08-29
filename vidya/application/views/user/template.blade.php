<!DOCTYPE html>
<html>
  <head>
    <title>Sistem Pengguna -  @yield("title",$__USER->name)</title>
    <meta charset="utf-8">
    <meta content="ie=edge" http-equiv="x-ua-compatible">
    <meta content="{{$__SEO->keywords}}" name="keywords">
    <meta content="{{$__INFO->name}}" name="author">
    <meta content="{{$__SEO->description}}" name="description">
    <meta content="width=device-width, initial-scale=1" name="viewport">
    <META NAME="ROBOTS" CONTENT="NOINDEX, NOFOLLOW">
    <link rel="icon" href="{{$__INFO->icon_dir->xs}}" type="image/png" sizes="16x16">
    <link rel="icon" href="{{$__INFO->icon_dir->xs}}" type="image/png" sizes="32x32">
    <link rel="icon" href="{{$__INFO->icon_dir->sm}}" type="image/png" sizes="120x120">
    <link rel="icon" href="{{$__INFO->icon_dir->md}}" type="image/png" sizes="240x240">
    <link href="https://fonts.googleapis.com/css?family=Rubik:300,400,500" rel="stylesheet" type="text/css">
    <link href="{{base_url('panelassets/css/icons/icomoon/styles.css')}}" rel="stylesheet" type="text/css">
    <link href="{{base_url('userassets/icon_fonts_assets/weather-icons/css/weather-icons.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{base_url('userassets/bower_components/select2/dist/css/select2.min.css')}}" rel="stylesheet">
    <link href="{{base_url('userassets/bower_components/bootstrap-daterangepicker/daterangepicker.css')}}" rel="stylesheet">
    <link href="{{base_url('userassets/bower_components/dropzone/dist/dropzone.css')}}" rel="stylesheet">
    <link href="{{base_url('userassets/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{base_url('userassets/bower_components/fullcalendar/dist/fullcalendar.min.css')}}" rel="stylesheet">
    <link href="{{base_url('userassets/bower_components/perfect-scrollbar/css/perfect-scrollbar.min.css')}}" rel="stylesheet">
    <link href="{{base_url('userassets/css/main.css')}}?version=3.4" rel="stylesheet">
    
    <link href="{{base_url('panelassets/css/components.css')}}" rel="stylesheet" type="text/css">
    <link href="{{base_url('mainassets/css/infinite.css')}}" rel="stylesheet">
    <link href="{{base_url('mainassets/css/default.css')}}" rel="stylesheet">
    <link href="{{base_url('panelassets/css/colors.min.css')}}" rel="stylesheet" type="text/css">
  </head>
  <body>
    <div class="all-wrapper menu-side with-side-panel">
      <div class="layout-w">
        @include("user.pieces.menu")
        <div class="content-w">
          @yield("breadcrumbs")
          <div class="content-panel-toggler">
            <i class="os-icon os-icon-grid-squares-22"></i><span>Sidebar</span>
          </div>
          <div class="content-i">
            @yield("content")
          </div>
        </div>
      </div>
      <div class="display-type"></div>
    </div>
    @yield("footer")
    @include("pieces.env.scripts")
    <script src="{{base_url('userassets/bower_components/jquery/dist/jquery.min.js')}}"></script>
    <script src="{{base_url('userassets/bower_components/moment/moment.js')}}"></script>
    <script src="{{base_url('userassets/bower_components/chart.js/dist/Chart.min.js')}}"></script>
    <script src="{{base_url('userassets/bower_components/select2/dist/js/select2.full.min.js')}}"></script>
    <script src="{{base_url('userassets/bower_components/ckeditor/ckeditor.js')}}"></script>
    <script src="{{base_url('userassets/bower_components/bootstrap-validator/dist/validator.min.js')}}"></script>
    <script src="{{base_url('userassets/bower_components/bootstrap-daterangepicker/daterangepicker.js')}}"></script>
    <script src="{{base_url('userassets/bower_components/dropzone/dist/dropzone.js')}}"></script>
    <script src="{{base_url('userassets/bower_components/editable-table/mindmup-editabletable.js')}}"></script>
    <script src="{{base_url('userassets/bower_components/datatables.net/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{base_url('userassets/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js')}}"></script>
    <script src="{{base_url('userassets/bower_components/fullcalendar/dist/fullcalendar.min.js')}}"></script>
    <script src="{{base_url('userassets/bower_components/perfect-scrollbar/js/perfect-scrollbar.jquery.min.js')}}"></script>
    <script src="{{base_url('userassets/bower_components/tether/dist/js/tether.min.js')}}"></script>
    <script src="{{base_url('userassets/bower_components/bootstrap/js/dist/util.js')}}"></script>
    <script src="{{base_url('userassets/bower_components/bootstrap/js/dist/alert.js')}}"></script>
    <script src="{{base_url('userassets/bower_components/bootstrap/js/dist/button.js')}}"></script>
    <script src="{{base_url('userassets/bower_components/bootstrap/js/dist/carousel.js')}}"></script>
    <script src="{{base_url('userassets/bower_components/bootstrap/js/dist/collapse.js')}}"></script>
    <script src="{{base_url('userassets/bower_components/bootstrap/js/dist/dropdown.js')}}"></script>
    <script src="{{base_url('userassets/bower_components/bootstrap/js/dist/modal.js')}}"></script>
    <script src="{{base_url('userassets/bower_components/bootstrap/js/dist/tooltip.js')}}"></script>
    <script src="{{base_url('userassets/bower_components/bootstrap/js/dist/popover.js')}}"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.0/js/bootstrap.min.js"></script>
    <script src="{{base_url('userassets/js/main.js?version=3.4')}}"></script>
    <script type="text/javascript" src="{{base_url('panelassets/js/plugins/loaders/blockui.min.js')}}"></script>
    <script type="text/javascript" src="{{base_url('panelassets/js/plugins/forms/styling/uniform.min.js')}}"></script>
    <script type="text/javascript" src="{{base_url('panelassets/js/plugins/notifications/sweet_alert.min.js')}}"></script>
    <script type="text/javascript" src="{{base_url('panelassets/js/plugins/notifications/pnotify.min.js')}}"></script>
    <script type="text/javascript" src="{{base_url('panelassets/js/plugins/notifications/noty.min.js')}}"></script>
    <script type="text/javascript" src="{{base_url('panelassets/js/plugins/notifications/jgrowl.min.js')}}"></script>
    <script type="text/javascript" src="{{base_url('mainassets/js/library.js')}}"></script>
    @yield("scripts")
    
  </body>
</html>
