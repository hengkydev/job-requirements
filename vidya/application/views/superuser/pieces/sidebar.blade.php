<!-- User menu -->
<div class="sidebar-user-material">
	<div class="category-content">
		<div class="sidebar-user-material-content">
			<a href="{{base_url('superuser')}}">
				<img src="{{$__SUPERUSER->img_src->sm}}" class="img-circle img-responsive" alt="">
			</a>
			<h6>
				{{$__SUPERUSER->name}}
			</h6>
			<span class="text-size-small">
				{{$__SUPERUSER->job}}
			</span>
		</div>
									
		<div class="sidebar-user-material-menu">
			<a href="#user-nav" data-toggle="collapse"><span>Akun Saya</span> <i class="caret"></i></a>
		</div>
	</div>
	
	<div class="navigation-wrapper collapse" id="user-nav">
		<ul class="navigation">
			<li><a href="#"><i class="icon-user-plus"></i> <span>Profil Saya</span></a></li>
			<li><a href="#"><i class="icon-comment-discussion"></i> <span><span class="badge bg-teal-400 pull-right">58</span> Pesan</span></a></li>
			<li class="divider"></li>
			<li><a href="#"><i class="icon-cog5"></i> <span>Pengaturan Akun</span></a></li>
			<li>
				<a href="{{base_url('superuser/signout')}}">
					<i class="icon-switch2"></i> <span>Keluar Sistem</span>
				</a>
			</li>
		</ul>
	</div>
</div>
<!-- /user menu -->


<!-- Main navigation -->
<div class="sidebar-category sidebar-category-visible">
	<div class="category-content no-padding">
		<ul class="navigation navigation-main navigation-accordion">

			<!-- Main -->
			<li class="navigation-header"><span>Menu Utama</span> <i class="icon-menu" title="Main pages"></i></li>
			<li class="{{match($__MENU,"home","active")}}">
				<a href="{{base_url('superuser')}}"><i class="icon-home4"></i> <span>Beranda</span></a>
			</li>
			<li>
				<a href="#"><i class="icon-magazine"></i> <span>Materi Pembelajaran</span></a>
				<ul>
					<li class="{{match($__MENU,"post_create","active")}}"><a href="{{base_url("superuser/materi/create")}}">Buat Baru</a></li>
					<li class="{{match($__MENU,"post","active")}}">
						<a href="{{base_url("superuser/materi")}}">Lihat Daftar</a>
					</li>
				</ul>
			</li>
			<li>
				<a href="#"><i class=" icon-user-tie"></i> <span>Pengajar</span></a>
				<ul>
					<li class="{{match($__MENU,"lecturer_create","active")}}">
						<a href="{{base_url("superuser/lecturer/create")}}">Buat Baru</a>
					</li>
					<li class="{{match($__MENU,"lecturer","active")}}">
						<a href="{{base_url("superuser/lecturer")}}">Lihat Daftar</a>
					</li>
				</ul>
			</li>
			<li>
				<a href="#"><i class="  icon-user-tie"></i> <span>Mahasiswa</span></a>
				<ul>
					<li class="{{match($__MENU,"student_create","active")}}">
						<a href="{{base_url("superuser/student/create")}}">Buat Baru</a>
					</li>
					<li class="{{match($__MENU,"student","active")}}">
						<a href="{{base_url("superuser/lecturer")}}">Lihat Daftar</a>
					</li>
				</ul>
			</li>
			<!-- /main -->

			<!-- Forms -->
	<!-- 	<li class="navigation-header"><span>Website optimization</span> <i class="icon-menu" title="Forms"></i></li>
	<li class="{{match($__MENU,"seo","active")}}">
		<a href="{{base_url('superuser/seo')}}" >
			<i class=" icon-sphere"></i> <span> SEO</span>
		</a>
	</li>
	<li class="{{match($__MENU,"socialmedia","active")}}">
		<a href="{{base_url('superuser/socialmedia')}}"><i class=" icon-link"></i> <span> Social Media</span></a>
	</li>
	<li class="{{match($__MENU,"synchronization","active")}}">
		<a href="{{base_url('superuser/synchronization')}}"><i class=" icon-rotate-cw2"></i> <span> Sinkronisasi</span></a>
	</li>
	<li class="{{match($__MENU,"config","active")}}">
		<a href="{{base_url('superuser/configuration')}}"><i class=" icon-cog"></i> <span> Konfigurasi</span></a>
	</li> -->
			<!-- /page kits -->

		</ul>
	</div>
</div>
<!-- /main navigation -->