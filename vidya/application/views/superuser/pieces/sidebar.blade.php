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
				<a href="#"><i class="icon-magazine"></i> <span>Artikel / Berita</span></a>
				<ul>
					<li class="{{match($__MENU,"post_create","active")}}"><a href="{{base_url("superuser/post/create")}}">Buat Baru</a></li>
					<li class="{{match($__MENU,"post","active")}}">
						<a href="{{base_url("superuser/post")}}">Lihat Daftar</a>
					</li>
					<li class="navigation-divider"></li>
					<li class="{{match($__MENU,"postcategories_create","active")}}">
						<a href="{{base_url("superuser/postcategories/create")}}">Buat Kategori</a>
					</li>
					<li class="{{match($__MENU,"postcategories","active")}}">
						<a href="{{base_url("superuser/postcategories")}}">Lihat Daftar Kategori</a>
					</li>
					<li class="navigation-divider"></li>
					<li class="{{match($__MENU,"posttags_create","active")}}">
						<a href="{{base_url("superuser/posttags/create")}}">Buat Tag</a>
					</li>
					<li class="{{match($__MENU,"posttags","active")}}">
						<a href="{{base_url("superuser/posttags")}}">Lihat Daftar Tag</a>
					</li>
				</ul>
			</li>
			<li>
				<a href="#"><i class=" icon-play"></i> <span>Video</span></a>
				<ul>
					<li class="{{match($__MENU,"video_create","active")}}">
						<a href="{{base_url("superuser/video/create")}}">Buat Baru</a>
					</li>
					<li class="{{match($__MENU,"video","active")}}">
						<a href="{{base_url("superuser/video")}}">Lihat Daftar</a>
					</li>
				</ul>
			</li>
			<li>
				<a href="#"><i class=" icon-calendar22"></i> <span>Workshop</span></a>
				<ul>
					<li class="{{match($__MENU,"workshop_create","active")}}">
						<a href="{{base_url("superuser/workshop/create")}}">Buat Baru</a>
					</li>
					<li class="{{match($__MENU,"workshop","active")}}">
						<a href="{{base_url("superuser/workshop")}}">Lihat Daftar</a>
					</li>
				</ul>
			</li>
			<li>
				<a href="#"><i class="icon-users"></i> <span> Pengguna</span></a>
				<ul>
					<li class="{{match($__MENU,"user_create","active")}}">
						<a href="{{base_url("superuser/user/create")}}">Buat Baru</a>
					</li>
					<li class="{{match($__MENU,"user","active")}}">
						<a href="{{base_url("superuser/user")}}">Lihat Daftar</a>
					</li>
				</ul>
			</li>
			<li>
				<a href="#"><i class=" icon-brain"></i> <span>Trading Idea</span></a>
				<ul>
					<li class="{{match($__MENU,"tradingidea_create","active")}}">
						<a href="{{base_url("superuser/tradingidea/create")}}">Buat Baru</a>
					</li>
					<li class="{{match($__MENU,"tradingidea","active")}}">
						<a href="{{base_url("superuser/tradingidea")}}">Lihat Daftar</a>
					</li>
				</ul>
			</li>
			<li>
				<a href="#"><i class="  icon-bell2"></i> <span>Trading Alert</span></a>
				<ul>
					<li class="{{match($__MENU,"tradingalert_create","active")}}">
						<a href="{{base_url("superuser/tradingalert/create")}}">Buat Baru</a>
					</li>
					<li class="{{match($__MENU,"tradingalert","active")}}">
						<a href="{{base_url("superuser/tradingalert")}}">Lihat Daftar</a>
					</li>
				</ul>
			</li>
			<!-- /main -->

			<!-- Forms -->
			<li class="navigation-header"><span>Website optimization</span> <i class="icon-menu" title="Forms"></i></li>
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
			</li>
			<!-- /page kits -->

		</ul>
	</div>
</div>
<!-- /main navigation -->