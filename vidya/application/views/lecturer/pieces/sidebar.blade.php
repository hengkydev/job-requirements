 <!-- Main sidebar -->
<div class="sidebar sidebar-main bg-primary-800">
    <div class="sidebar-content">
        <div class="sidebar-user-material">
                <div class="category-content">
                    <div class="sidebar-user-material-content">
                        <a href="{{base_url('lecturer/dashboard')}}">
                            <img src="{{$__LECTURER->img_src->sm}}" class="img-circle img-responsive" alt="">
                        </a>
                        <h6>
                            {{$__LECTURER->name}}
                        </h6>
                        <span class="text-size-small">
                            {{$__LECTURER->position}}
                        </span>
                    </div>
                                                
                    <div class="sidebar-user-material-menu">
                        <a href="#user-nav" data-toggle="collapse"><span>Akun Saya</span> <i class="caret"></i></a>
                    </div>
                </div>
            
            <div class="navigation-wrapper collapse" id="user-nav">
                <ul class="navigation">
                    <li>
                        <a href="{{base_url('superuser/signout')}}">
                            <i class="icon-switch2"></i> <span>Keluar Sistem</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <!-- Main navigation -->
        <div class="sidebar-category sidebar-category-visible">
            <div class="category-content no-padding">
                <ul class="navigation navigation-main navigation-accordion">

                    <!-- Main -->
                    <li class="navigation-header"><span>Menu Utama</span> <i class="icon-menu" title="Main pages"></i></li>
                    <li class="{{match($__MENU,'home','active')}}" >
                            <a href="{{base_url('lecturer/dashboard')}}"><i class="icon-home4"></i> <span>Beranda</span></a>
                        </li>
                    <li>
                        <a href="{{base_url('lecturer/materi')}}">
                            <i class=" icon-books"></i> <span>Materi Pembelajaran</span>
                        </a>
                        <ul>
                            <li  class="{{match($__MENU,"materi_create","active")}}">
                                <a href="{{base_url("lecturer/materi/create")}}">Buat Baru</a>
                            </li>
                            <li  class="{{match($__MENU,"materi","active")}}">
                                <a href="{{base_url("lecturer/materi")}}">Lihat Daftar</a>
                            </li>
                        </ul>
                    </li>
                    <li  class="{{match($__MENU,'config','active')}}">
                        <a href="{{base_url('lecturer/config')}}">
                            <i class=" icon-cog"></i> <span>Atur Profil</span>
                        </a>
                    </li>
                     <li>
                        <a href="{{base_url('lecturer/signout')}}">
                            <i class=" icon-switch"></i> <span>Keluar Sistem</span>
                        </a>
                    </li>
                    <!-- /page kits -->

                </ul>
            </div>
        </div>
        <!-- /main navigation -->

    </div>
</div>
<!-- /main sidebar -->