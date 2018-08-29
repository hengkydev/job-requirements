<?php
use \Curl\Curl;

class Authentication extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->blade->share('ctrl', $this);
		$this->webdata->load();
	}

	public function index()
	{
		$this->webdata->show_404();
	}

	public function superuser(){
		if($this->middleware->superuser()){
			redirect('superuser');
		}
		
		echo $this->blade->draw('aut.superuser.signin');
		return;
	}

	public function superuser(){
		if($this->middleware->superuser()){
			redirect('superuser');
		}
		
		echo $this->blade->draw('aut.superuser.signin');
		return;
	}

	public function user(){

		$this->validation->ajaxRequest();

		$rules = [
					    'required' 	=>	[
					    					['username'],
					    					['password'],
					    				]
					];
				
		$validate 	= $this->validation->check($rules,'post');

		if(!$validate->correct){
			$this->restapi->error($validate->data);
		}

		$username 	= $this->input->post('username');

        $user		= UserModel::where('username',$username)->first();

        if(!$user){
			$this->restapi->error("Maaf Username '{$username}' tidak di temukan!");
		}

		if($user->status == "register"){
			$this->restapi->error("Selesaikan pendaftaran anda terlebih dahulu");
		}

		if($user->status == "blocked"){
			$this->restapi->error("Maaf akun anda telah kami non aktifkan untuk berberapa alasan, silahkan hubungi kami");
		}

		$password 				= DefuseLib::decrypt($user->password);

		if($password!==$this->input->post('password')){

			if($user->password_old!=""){
				$password_old 			= DefuseLib::decrypt($user->password_old);

				if($password_old===$this->input->post('password')){
					$this->restapi->error("itu merupakan password lama anda pada ".tgl_indo($user->password_old_date));
				}
			}
			
			$this->restapi->error("maaf password yang anda masukkan tidak sesuai");
		}

		$user->ipaddress 		= $this->input->ip_address();
		$user->save();

		if(!$user->save()){
			$this->restapi->error("ada sesuatu yang salah silahkan coba kembali");
		}

		$newdata = array('auth_user'	=>  DefuseLib::encrypt($user->token));
		if($this->input->post('remember')){
			$cookie = array(
			    'name'   => '__REMEMBER_USER',
			    'value'  => DefuseLib::encrypt($user->token),
			    'expire' => '604800',  // Two weeks
			    'domain' => '.'.getenv('MAIN_DOMAIN'),
			    'path'   => '/'
			);
			set_cookie($cookie);
		}

		$this->session->set_userdata($newdata);

		$url 			= $this->session->userdata('catched_location_user');
		if($url==""){
			$url 		= '/user';
		}
		$this->restapi->response($url);

		return;
	}

	public function userregister(){

		if($this->session->userdata('auth_user')){
			redirect('user');
			return;
		}
		
		$data['__MENU']		= 'register';
		echo $this->blade->draw('user.auth.register',$data);
		return;
	}

	public function userconfirmation(){
		if($this->session->userdata('auth_user')){
			redirect('user');
			return;
		}

		if(!$this->input->get('token')){
			$this->webdata->show_404();
		}
		
		$token 				= $this->input->get('token');
		$user 				= UserModel::status('register')->token($token)->first();

		if(!$user){
			$this->webdata->show_404();	
		}

		$province 			= RajaOngkir::getProvince();

		if(!$province->status){
			echo $this->blade->draw('website.checkout.failedongkir');		
			exit();			
		}


		$data['__MENU']		= 'register';
		$data['user'] 		= $user;
		$data['province'] 	= $province->results;
		echo $this->blade->draw('user.auth.confirmation',$data);
		return;
	}

	public function usercompleteconfirmation(){

		if($this->session->userdata('auth_user')){
			$this->restapi->error("maaf anda sudah masuk silahkan reload halaman kembali");
		}

		$rules 		= [
					    'required' 	=> [
					        ['token'],['name'],
					        ['password'],['password_confirmation'],
					        ['province'],['city'],['district'],
					        ['address'],['zipcode'],['agreement']
					    ],
					    'equals'	=> [
					    	['password_confirmation','password']
					    ],
					    'lengthMin' => [
					    	['password',8],['password_confirmation',8]
					    ]
					  ];

		$validate 	= $this->validation->check($rules,'post');

		if(!$validate->correct){
			$this->restapi->error($validate->data);
		}

		$token 		= strtoupper($this->input->post('token'));

		$user 		= UserModel::status('register')->token($token)->first();

		if(!$user){
			$this->restapi->error("maaf pengguna yang baru terdaftar tidak di temukan");
		}

		$province 		= $this->input->post('province');
		$city 			= $this->input->post('city');
		$district 		= $this->input->post('district');

		// Check destination
		$destination 		= RajaOngkir::findDistrict(goExplode($district,'//',0),goExplode($city,'//',0),goExplode($province,'//',0));

		if(!$destination->status){
			$this->restapi->error($destination->results);
		}

		if($_FILES['image']['name']!=""){

			$filename 				= 'USER '.limit_string($user->name).'  ('.date('Ymdhis').')';

			$upload 				= $this->upfiles->uploadImage(content_dir('images/lg/users'),'image',$filename);

			if(!$upload->status){
				$error_upload 		= $upload->result;
				$this->restapi->error($upload->result);
			}

			$filename 				= $upload->result->file_name;

			$option['origin']		= content_dir('images/lg/users/'.$filename);
			$option['filename']		= $filename;

			// RESIZE TO MEDIUM
			$option['size']			= 350;
			$option['path']			= content_dir('images/md/users/');
			$this->upfiles->resize($option);

			// RESIZE TO SMALL
			$option['size']			= 150;
			$option['path']			= content_dir('images/sm/users/');
			$this->upfiles->resize($option);

			// RESIZE TO SMALL
			$option['size']			= 80;
			$option['path']			= content_dir('images/xs/users/');
			$this->upfiles->resize($option);

			if($user->image!=""){
				remFile(content_dir('images/lg/users/'.$user->image));
				remFile(content_dir('images/md/users/'.$user->image));
				remFile(content_dir('images/sm/users/'.$user->image));
				remFile(content_dir('images/xs/users/'.$user->image));
			}

			$user->image 			= $filename;
		}
		
		$user->token 	= getToken(20).date('Ymdhis');
		$user->password = DefuseLib::encrypt($this->input->post('password'));
		$user->name 	= $this->input->post('name');
		$user->address 	= $this->input->post('address');
		$user->zipcode 	= $this->input->post('zipcode');
		$user->province = $province;
		$user->city 	= $city;
		$user->district = $district;
		$user->status 	= 'active';

		if(!$user->save()){
			$this->restapi->error("maaf ada yang salah , silahkan ulang kembali");
		}

		$newdata = array('auth_user'	=>  DefuseLib::encrypt($user->token));
		$this->session->set_userdata($newdata);

		$url 			= $this->session->userdata('catched_location_user');
		if($url==""){
			$url 		= '/user';
		}
		$this->validation->setSuccess("Pendaftaran Berhasil di selesaikan, terimakasih telah menjadi pengguna kami");
		$this->restapi->success($url);
	}



	public function userforgot(){
		if($this->session->userdata('auth_user')){
			redirect('user');
			return;
		}
		
		$data['__MENU']		= 'forgot';
		$data['csrf_name'] 	= $this->security->get_csrf_token_name();
		$data['csrf_hash'] 	= $this->security->get_csrf_hash();
		echo $this->blade->draw('user.auth.forgot',$data);
		return;
	}

	public function action($type="user"){
		switch ($type) {
			case 'user':
				$this->actionUser();
				return;
				break;
			case 'vendor':
				$this->actionVendor();
				break;
			case 'root':
				$this->actionRoot();
				break;
			default:
				$this->webdata->show_404();
				break;
		}		
	}

	private function actionUser(){

		$this->validation->ajaxRequest();

		$rules = [
					    'required' 	=>	[
					    					['username'],
					    					['password'],
					    				]
					];
				
		$validate 	= $this->validation->check($rules,'post');

		if(!$validate->correct){
			$this->restapi->error($validate->data);
		}

		$username 	= $this->input->post('username');

		 if(filter_var($username, FILTER_VALIDATE_EMAIL)) {
	        $user	= UserModel::where('email',$username)->first();
	        if(!$user){
				$this->restapi->error("Maaf Email belum terdaftar");
			}
	    }
	    else {
	        $user	= UserModel::where('phone',$username)->where('phone','!=',null)->first();
	        if(!$user){
				$this->restapi->error("Maaf No Telepon belum terdaftar");
			}
	    }

		if($user->status == "register"){
			$this->restapi->error("Selesaikan pendaftaran anda terlebih dahulu");
		}

		if($user->status == "blocked"){
			$this->restapi->error("Maaf akun anda telah kami non aktifkan untuk berberapa alasan, silahkan hubungi kami");
		}

		$password 				= DefuseLib::decrypt($user->password);

		if($password!==$this->input->post('password')){

			if($user->password_old!=""){
				$password_old 			= DefuseLib::decrypt($user->password_old);

				if($password_old===$this->input->post('password')){
					$this->restapi->error("itu merupakan password lama anda pada ".tgl_indo($user->password_old_date));
				}
			}
			
			$this->restapi->error("maaf password yang anda masukkan tidak sesuai");
		}

		$user->ipaddress 		= $this->input->ip_address();
		$user->save();

		if(!$user->save()){
			$this->restapi->error("ada sesuatu yang salah silahkan coba kembali");
		}

		$newdata = array('auth_user'	=>  DefuseLib::encrypt($user->token));
		if($this->input->post('remember')){
			$cookie = array(
			    'name'   => '__REMEMBER_USER',
			    'value'  => DefuseLib::encrypt($user->token),
			    'expire' => '604800',  // Two weeks
			    'domain' => '.'.getenv('MAIN_DOMAIN'),
			    'path'   => '/'
			);
			set_cookie($cookie);
		}

		$this->session->set_userdata($newdata);

		$url 			= $this->session->userdata('catched_location_user');
		if($url==""){
			$url 		= '/user';
		}
		$this->restapi->response($url);
	}

	private function actionVendor(){

		$this->validation->ajaxRequest();

		if(!$this->validation->gRecaptcha()->status){
			$this->restapi->error($this->validation->gRecaptcha()->message);
		}

		$rules = [
					    'required' 	=>	[
					    	['email'],['password']
					    ],
					    'email'		=> [
					    	['email']
					    ]

					];
				
		$validate 	= $this->validation->check($rules,'post');

		if(!$validate->correct){
			$this->restapi->error($validate->data);
		}

		$where 	= array(
					'email' 	=> $this->input->post('email'),
				  );


		$vendor	= VendorModel::where('email',$this->input->post('email'))->first();

		if(!isset($vendor->id)){
			$this->restapi->error("Maaf Email yang anda masukkan tidak terdaftar");
		}


		if($vendor->status == "register"){
			$this->restapi->error("Konfirmasikan Email anda terlebih dahulu");
		}

		if($vendor->status == "blocked"){
			$this->restapi->error("Maaf akun anda telah kami blokir");
		}

		$password 				= DefuseLib::decrypt($vendor->password);

		if($password!==$this->input->post('password')){

			if($vendor->password_old!=""){
				$password_old 			= DefuseLib::decrypt($vendor->password_old);

				if($password_old===$this->input->post('password')){
					$this->restapi->error("itu merupakan password lama anda pada ".tgl_indo($vendor->password_old_date));
				}
			}
			
			$this->restapi->error("maaf password yang anda masukkan tidak sesuai");
		}

		$vendor->ipaddress 		= $this->input->ip_address();
		$vendor->save();

		if(!$vendor->save()){
			$this->restapi->error("maaf ada sesuatu kesalahan silahkan ulangi kembali");
		}

		$newdata = array('auth_vendor'	=>  $vendor->token);
		$this->session->set_userdata($newdata);

		$url 			= $this->session->userdata('catched_location_vendor');
		$this->restapi->response($url);
	}

	private function actionRoot(){

		$this->validation->ajaxRequest('root');

		if($this->validation->suspendRoot()){
			$suspend 	= toObject($this->session->userdata('suspend_root'));
			echo goResult(false,diffDateString($suspend->time).' Remaining to login again');
			return;
		}


		if(!$this->validation->gRecaptcha()->status){
			echo goResult(false,$this->validation->gRecaptcha()->message);
			return;
		}

		$rules = [
					    'required' 	=>	[
					    					['username'],
					    					['password'],
					    				]

					];
				
		$validate 	= $this->validation->check($rules,'post');

		if(!$validate->correct){
			echo goResult(false,$validate->data);
			return;
		}

		$root		= SuperuserModel::where('username',$this->input->post('username'))->first();

		if(!isset($root->id)){
			$this->validation->setSuspendRoot();
			echo goResult(false,'username tiak di temukan');
			return;
		}

		if($root->status == "blocked"){
			$this->validation->setSuspendRoot();
			echo goResult(false,'Maaf akun anda telah kami blokir');
			return;
		}

		$password 				= DefuseLib::decrypt($root->password);

		if($password!==$this->input->post('password')){
			$this->validation->setSuspendRoot();
			echo goResult(false,'maaf password yang anda masukkan tidak sesuai');
			return;
		}

		$root->ipaddress 		= $this->input->ip_address();
		$root->save();

		if(!$root->save()){
			echo goResult(false,'maaf ada sesuatu kesalahan silahkan ulangi kembali');
			return;
		}

		$newdata = array('auth_root'	=>  $root->id);

		$this->session->set_userdata($newdata);

		$url 			= $this->session->userdata('catched_location_root');
		echo goResult(true,$url);
		return;
	}


	public function oauthuser($type){
		switch ($type) {
			case 'google':
				$this->validation->ajaxRequest();

				$rules 		= [
							    'required' 	=> [
							        ['token']
							    ]
							  ];

				$validate 	= $this->validation->check($rules,'post');

				if(!$validate->correct){
					$this->restapi->error($validate->data);
				}


				$CLIENT_ID 		= getenv('GOOGLE_CLIENT_ID');
				$token 			= $this->input->post('token');

				$config 		= [
										'client_id' 	=> $CLIENT_ID,
										'token_id' 		=> $token
								  ];

				$google 		= AksaAuthentication::googleAuth($config);

				if(!$google->auth){
					$this->restapi->error($google->msg);
				}

				$google 		= $google->msg;

				// check if user ever use this google acount to register then throw response to login
				$user 		= UserModel::where('email',$google->email)->first();

				if(isset($user->id)){

					if($user->status=="blocked" || $user->status=="active"){
						$this->restapi->error("Maaf Email ini telah di gunakan sebelumnya");
					}

					if($user->image!=""){
						remFile(content_dir('images/lg/users/'.$user->image));
						remFile(content_dir('images/md/users/'.$user->image));
						remFile(content_dir('images/sm/users/'.$user->image));
						remFile(content_dir('images/xs/users/'.$user->image));
					}
					$user->delete();
				}

				$filename 		= 'USER '.limit_string($google->name).' '.date('Ymdhis').'.jpg';
				$curl 			= new Curl();
				$curl->setOpt(CURLOPT_ENCODING , 'gzip');
				$getfile 		= $curl->download($google->picture, content_dir('images/lg/users/'.$filename));

				$user 			= new UserModel;

				if($getfile){

					$option['origin']		= content_dir('images/lg/users/'.$filename);
					$option['filename']		= $filename;

					// RESIZE TO MEDIUM
					$option['size']			= 250;
					$option['path']			= content_dir('images/md/users/');
					$this->upfiles->resize($option);

					// RESIZE TO SMALL
					$option['size']			= 150;
					$option['path']			= content_dir('images/sm/users/');
					$this->upfiles->resize($option);

					// RESIZE TO SMALL
					$option['size']			= 80;
					$option['path']			= content_dir('images/xs/users/');
					$this->upfiles->resize($option);

					$user->image 		= $filename;
				}

				$user->token 		= getToken(20).'-'.date('Ymdhis');
				$user->name 		= $google->name;
				$user->email 		= $google->email;
				$user->status 		= 'register';
				$user->ipaddress 	= $this->input->ip_address();

				if(!$user->save()){
					$this->restapi->error("Maaf ada sesuatu yang salah silahkan coba kembali");
				}


				$this->restapi->response($user->urlconfirmation);

				break;
			case 'facebook':

				$this->validation->ajaxRequest();

				$rules 		= [
							    'required' 	=> [
							        ['token']
							    ]
							  ];

				$validate 	= $this->validation->check($rules,'post');

				
				if(!$validate->correct){
					$this->restapi->error($validate->data);
				}

				$app_id 		= getenv('FB_APP_ID');
				$app_secret 	= getenv('FB_APP_SECRET');
				$token 			= $this->input->post('token');

				$config 		= [
										'app_id' 		=> $app_id,
										'app_secret' 	=> $app_secret,
										'token'			=> $token
								  ];

				$facebook 		= AksaAuthentication::facebookAuth($config);

				if(!$facebook->auth){
					$this->restapi->error($facebook->msg);
				}
				
				$facebook 		= $facebook->msg;

				if($facebook->email==""){
					$this->restapi->error("Maaf email facebook anda belum terkonfirmasi");
				}

				$user 		= UserModel::where('email',$facebook->email)->first();
				if(isset($user->id)){
					if($user->status=="blocked" || $user->status=="active"){
						$this->restapi->error("Maaf Email ini telah di gunakan sebelumnya");
					}

					if($user->image!=""){
						remFile(content_dir('images/lg/users/'.$user->image));
						remFile(content_dir('images/md/users/'.$user->image));
						remFile(content_dir('images/sm/users/'.$user->image));
						remFile(content_dir('images/xs/users/'.$user->image));
					}
					$user->delete();
				}


				$filename 		= 'USER '.limit_string($facebook->name).' '.date('Ymdhis').'.jpg';
				$img 			= file_get_contents('https://graph.facebook.com/'.$facebook->id.'/picture?type=large');
				$file 			= content_dir('images/lg/users/'.$filename);
				$put 			= file_put_contents($file, $img);
				
				$user 			= new UserModel;

				if($put){

					$option['origin']		= content_dir('images/lg/users/'.$filename);
					$option['filename']		= $filename;

					// RESIZE TO MEDIUM
					$option['size']			= 250;
					$option['path']			= content_dir('images/md/users/');
					$this->upfiles->resize($option);

					// RESIZE TO SMALL
					$option['size']			= 150;
					$option['path']			= content_dir('images/sm/users/');
					$this->upfiles->resize($option);

					// RESIZE TO SMALL
					$option['size']			= 80;
					$option['path']			= content_dir('images/xs/users/');
					$this->upfiles->resize($option);

					$user->image 		= $filename;
				}				
				

				$user->token 		= getToken(20).'-'.date('Ymdhis');
				$user->name 		= $facebook->name;
				$user->email 		= $facebook->email;
				$user->ipaddress 	= $this->input->ip_address();

				if(!$user->save()){
					$this->restapi->error("maaf ada sesuatu kesalahan silahkan ulangi kembali");
				}

				$this->restapi->response($user->urlconfirmation);
				return;

				break;
		}		
	}

	public function oauthvendor($type){
		switch ($type) {
			case 'google':
				$this->validation->ajaxRequest();

				$rules 		= [
							    'required' 	=> [
							        ['token']
							    ]
							  ];

				$validate 	= $this->validation->check($rules,'post');

				if(!$validate->correct){
					echo goResult(false,"no token submited");
					return;
				}


				$CLIENT_ID 		= getenv('GOOGLE_CLIENT_ID');
				$token 			= $this->input->post('token');

				$config 		= [
										'client_id' 	=> $CLIENT_ID,
										'token_id' 		=> $token
								  ];

				$google 		= AksaAuthentication::googleAuth($config);

				if(!$google->auth){
					$this->restapi->error($google->msg);
				}

				$google 		= $google->msg;

				// check if user ever use this google acount to register then throw response to login
				$vendor 		= VendorModel::where('email',$google->email)->first();

				if(isset($vendor->id)){

					if($vendor->status=="blocked"){
						$this->restapi->error("maaf akun anda telah kami blokir");
					}

					if($vendor->status=="active" || $vendor->status=="incomplete"){

						$vendor->ipaddress 		= $this->input->ip_address();
						$vendor->save();

						$url 			= $this->session->userdata('catched_location_vendor');
						$newdata 		= array('auth_vendor'	=>  $vendor->token);
						$this->session->set_userdata($newdata);	

						$this->restapi->response($url);
					}

					$vendor->delete();
				}

				$filename 		= 'VENDOR '.limit_string($google->name).' '.date('Ymdhis').'.jpg';
				$curl 			= new Curl();
				$curl->setOpt(CURLOPT_ENCODING , 'gzip');
				$getfile 		= $curl->download($google->picture, content_dir('images/lg/vendors/'.$filename));

				$vendor 		= new VendorModel;

				if($getfile){

					$option['origin']		= content_dir('images/lg/vendors/'.$filename);
					$option['filename']		= $filename;

					// RESIZE TO MEDIUM
					$option['size']			= 250;
					$option['path']			= content_dir('images/md/vendors/');
					$this->upfiles->resize($option);

					// RESIZE TO SMALL
					$option['size']			= 150;
					$option['path']			= content_dir('images/sm/vendors/');
					$this->upfiles->resize($option);

					// RESIZE TO SMALL
					$option['size']			= 80;
					$option['path']			= content_dir('images/xs/vendors/');
					$this->upfiles->resize($option);

					$vendor->image 			= $filename;
				}


				$vendor->token 		= strtoupper(getToken(20)).'-'.date('Ymdhis');
				$vendor->name 		= $google->name;
				$vendor->email 		= $google->email;
				$vendor->status 	= 'incomplete';
				$vendor->ipaddress 	= $this->input->ip_address();

				if(!$vendor->save()){
					$this->restapi->error("maaf ada sesuatu kesalahan silahkan ulangi kembali");
				}

				$url 		= $this->session->userdata('catched_location_vendor');
				$newdata	= array('auth_vendor'	=>  $vendor->token);
				$this->session->set_userdata($newdata);	
				$this->restapi->response($url);

				break;
			case 'facebook':

				$this->validation->ajaxRequest();

				$rules 		= [
							    'required' 	=> [
							        ['token']
							    ]
							  ];

				$validate 	= $this->validation->check($rules,'post');

				if(!$validate->correct){
					$this->restapi->error("no token submited");
				}

				$app_id 		= getenv('FB_APP_ID');
				$app_secret 	= getenv('FB_APP_SECRET');
				$token 			= $this->input->post('token');

				$config 		= [
										'app_id' 		=> $app_id,
										'app_secret' 	=> $app_secret,
										'token'			=> $token
								  ];

				$facebook 		= AksaAuthentication::facebookAuth($config);

				if(!$facebook->auth){
					$this->restapi->error($facebook->msg);
				}
				
				$facebook 		= $facebook->msg;

				$vendor 		= VendorModel::where('email',$facebook->email)->first();
				if(isset($vendor->id)){
					if($vendor->status=="blocked"){
						$this->restapi->error("Maaf akun anda telah kami blokir");
					}

					if($vendor->status=="active" || $vendor->status=="incomplete"){
						$vendor->ipaddress 		= $this->input->ip_address();
						$vendor->save();

						$url 		= $this->session->userdata('catched_location_vendor');
						$newdata 	= array('auth_vendor'	=>  $vendor->token);
						$this->session->set_userdata($newdata);
						$this->restapi->response($url);
					}

					$vendor->delete();
				}


				$filename 		= 'faebook '.limit_string($facebook->name).' '.date('Ymdhis').'.jpg';

				$img = file_get_contents('https://graph.facebook.com/'.$facebook->id.'/picture?type=large');
				if($img){
					$file = content_dir('images/lg/vendors/'.$filename);
					$facebook_photo = file_put_contents($file, $img);	
				}

				$vendor 		= new VendorModel;

				if($facebook_photo){

					$option['origin']		= content_dir('images/lg/vendors/'.$filename);
					$option['filename']		= $filename;

					// RESIZE TO MEDIUM
					$option['size']			= 250;
					$option['path']			= content_dir('images/md/vendors/');
					$this->upfiles->resize($option);

					// RESIZE TO SMALL
					$option['size']			= 150;
					$option['path']			= content_dir('images/sm/vendors/');
					$this->upfiles->resize($option);

					// RESIZE TO SMALL
					$option['size']			= 80;
					$option['path']			= content_dir('images/xs/vendors/');
					$this->upfiles->resize($option);

					$vendor->image 		= $filename;
				}				
				

				$vendor->token 		= strtoupper(getToken(20)).'-'.date('Ymdhis');
				$vendor->name 		= $facebook->name;
				$vendor->email 		= $facebook->email;
				$vendor->status 	= 'incomplete';
				$vendor->ipaddress 	= $this->input->ip_address();

				if(!$vendor->save()){
					$this->restapi->error("maaf ada sesuatu kesalahan silahkan ulangi kembali");
				}

				$url 		= $this->session->userdata('catched_location_vendor');
				$newdata	= array('auth_vendor'	=>  $vendor->token);
				$this->session->set_userdata($newdata);	
				$this->restapi->response($url);
				break;
		}		
	}

	public function register($page="user"){
		$data['__MENU']	= 'register';

		switch ($page) {
			case 'user':
				echo $this->blade->draw('user.auth.register',$data);
				return;
				break;
			case 'vendor':
				echo $this->blade->draw('vendor.auth.register');
				return;
				break;
			case 'actionuser':
				$this->registerUser(1);
				break;
			case 'activateduser':
				$this->registerUser(2);
				break;
			case 'actionvendor':
				$this->registerVendor();
				break;
			default:
				$this->webdata->show_404();
				break;
		}
	}

	public function registersuccess($page="user"){

		$rules 		= [
					    'required' 	=> [
					        ['email']
					    ]
					  ];

		$validate 	= $this->validation->check($rules,'get');

		if(!$validate->correct){
			$this->webdata->show_404();
		}

		$token 	= $this->input->get('token');
		$email 	= $this->input->get('email');

		switch ($page) {
			case 'user':
				$user 			= UserModel::status('register')
											->where('email',$email)->first();

				if(!$user){
					$this->webdata->show_404();
				}

				if($this->input->get('resend')){

					$user->token 	= getToken(20).date('Ymdhis');
					$user->save();

					$tmp['user'] 	= $user;
					// Sending As Email
					$mail 			= new Magicmailer;
				    $mail->addAddress($user->email, $user->name);
				    $mail->Body    	= $this->blade->draw('email.user.register',$tmp);	
				    $mail->Subject 	= 'Konfirmasi Email Pendaftaran anda';
			    	$mail->AltBody 	= 'silahkan aktivasi email pendaftaran anda';
					$mail->send();

					// Sending As SMS
					$text 					= string_newline($this->blade->draw('sms.registeruser',$tmp));
					$this->zenzivasms->send($user->phone,$text);
				}

				$data['__MENU']		= 'register_success';
				$data['user'] 		= $user;
				echo $this->blade->draw('user.auth.registercomplete',$data);
				return;
				break;

			case 'vendor':
				$vendor 		= VendorModel::where('status','register')->token($token)->first();

				if(!$vendor){
					$this->webdata->show_404();
				}

				$data['vendor'] = $vendor;
				echo $this->blade->draw('vendor.auth.registercomplete',$data);
				return;

				break;
			case 'resendvendor':
				$vendor 		= VendorModel::where('status','register')->token($token)->first();

				if(!$vendor){
					$this->webdata->show_404();
				}

				$vendor->token 	= strtoupper(getToken(20)).'-'.date('Ymdhis');

				$mail 			= new Magicmailer;
				$email['vendor']= $vendor;
			    $mail->addAddress($vendor->email, $vendor->name);
			    $mail->Body    	= $this->blade->draw('email.vendor.register',$email);	
			    $mail->Subject 	= 'Konfirmasi Email Pendaftaran anda';
		    	$mail->AltBody 	= 'silahkan aktivasi email pendaftaran anda';

				if($mail->send()){
					$vendor->save();
				}

				$this->validation->setSuccess('Email aktifasi telah di kirim ulang');
				redirect('authentication/registersuccess/vendor?token='.$vendor->token);
				return;

				break;
			
			default:
				$this->webdata->show_404();
				break;
		}
	}

	private function registerUser($step){

		switch ($step) {
			case '1':
				$this->validation->ajaxRequest();

				$rules 		= [
							    'required' 	=> [
							        ['name'],['email'],['phone'],['g-recaptcha-response'],['agreement']
							    ],
							    'email'		=> [
							    	['email']
							    ]
							  ];

				if(!$this->validation->gRecaptcha()->status){
					$this->restapi->error($this->validation->gRecaptcha()->message);
				}

				$validate 	= $this->validation->check($rules,'post');

				if(!$validate->correct){
					$this->restapi->error($validate->data);
				}


				$user 	= UserModel::where('email',$this->input->post('email'))->first();
				
				if(isset($user->id)){
					if($user->status=="active" || $user->status=="blocked"){
						$this->restapi->error("maaf email telah terpakai");
					}

					if($user->image!=""){
						remFile(content_dir('images/lg/users/'.$user->image));
						remFile(content_dir('images/md/users/'.$user->image));
						remFile(content_dir('images/sm/users/'.$user->image));
						remFile(content_dir('images/xs/users/'.$user->image));	
					}

					$user->delete();
				}

				$user_phone 		= UserModel::where('phone',$this->input->post('phone'))->first();
				
				if(isset($user_phone->id)){
					if($user_phone->status=="active" || $user_phone->status=="blocked"){
						$this->restapi->error("maaf no telepon telah terpakai");
					}

					if($user_phone->image!=""){
						remFile(content_dir('images/lg/users/'.$user->image));
						remFile(content_dir('images/md/users/'.$user->image));
						remFile(content_dir('images/sm/users/'.$user->image));
						remFile(content_dir('images/xs/users/'.$user->image));	
					}

					$user_phone->delete();
				}



				$user 				= new UserModel;

				$notFound 				= true;
				while ($notFound) {
					$token 			= strtoupper(getToken(4));
					$check 			= UserModel::where('token',$token)->first();

					if(!$check){
						break;
					}
				}

				$user->token 		= $token;
				$user->name 		= remove_symbols($this->input->post('name'));
				$user->email 		= $this->input->post('email');
				$user->phone 		= $this->input->post('phone');
				$user->status 		= 'register';
				$user->ipaddress 	= $this->input->ip_address();

				if(!$user->save()){
					$this->restapi->error("maaf ada kesalahan silahkan ulangi kembali");
				}

				$tmp['user'] 			= $user;
				// Sending As Email
				$mail 					= new Magicmailer;
			    $mail->addAddress($user->email, $user->name);
			    $mail->Body    			= $this->blade->draw('email.user.register',$tmp);	
			    $mail->Subject 			= 'Konfirmasi Email Pendaftaran anda';
		    	$mail->AltBody 			= 'silahkan aktivasi email pendaftaran anda';
				$mail->send();

				// Sending As SMS
				$text 					= string_newline($this->blade->draw('sms.registeruser',$tmp));
				$this->zenzivasms->send($user->phone,$text);

				$this->restapi->success("/authentication/registersuccess/user?email=".$user->email);
				break;
			case '2':
				$this->validation->ajaxRequest();

				$rules 		= [
							    'required' 	=> [
							    	['token'],['password'],['confirmation_password']
							    ],
							    'email'		=> [
							    	['email']
							    ],
							    'lengthMin' => [
							    	['password',8],
							    	['confirmation_password',8]
							    ],
							    'equals' 	=> [
							    	['confirmation_password','password']
							    ]
							  ];

				if(!$this->validation->gRecaptcha()->status){
					$this->restapi->error($this->validation->gRecaptcha()->message);
				}

				$validate 	= $this->validation->check($rules,'post');

				if(!$validate->correct){
					$this->restapi->error($validate->data);
				}

				$token 	= $this->input->post('token');

				$user 	= UserModel::status('register')->token($token)->first();

				if(!$user){
					$this->restapi->error("maaf pengguna tidak di temukan ");
				}

				$user->token 		= getToken(20).date('Ymdhis');
				$user->password 	= DefuseLib::encrypt($this->input->post('password'));
				$user->status 		= 'active';
				$user->ipaddress 	= $this->input->ip_address();

				if(!$user->save()){
					$this->restapi->error("maaf ada kesalahan silahkan ulangi kembali");
				}

				$this->restapi->success("oke");
				break;
			default:
				$this->restapi->error("invalid request!");
				break;
		}

		
	}

	private function registerVendor(){

		$this->validation->ajaxRequest();

		$rules 		= [
					    'required' 	=> [
					        ['name'],['email'],['password']
					    ],
					    'email'		=> [
					    	['email']
					    ],
					    'lengthMin'	=> [
					    	['password','8']
					    ]
					  ];

		if(!$this->validation->gRecaptcha()->status){
			$this->restapi->error($this->validation->gRecaptcha()->message);
		}

		$validate 	= $this->validation->check($rules,'post');

		if(!$validate->correct){
			$this->restapi->error($validate->data);			
		}

		$vendor 	= VendorModel::where('email',$this->input->post('email'))->first();
		
		if(isset($vendor->id)){
			if($vendor->status=="active" || $vendor->status=="blocked" || $vendor->status=="incomplete"){
				$this->restapi->error("Email telah terpakai !");
				return;
			}

			if($vendor->image!=""){
				remFile(content_dir('images/lg/vendors/'.$vendor->image));
				remFile(content_dir('images/md/vendors/'.$vendor->image));
				remFile(content_dir('images/sm/vendors/'.$vendor->image));
				remFile(content_dir('images/xs/vendors/'.$vendor->image));	
			}

			$vendor->delete();
		}

		$vendor 			= new VendorModel;
		$vendor->token 		= strtoupper(getToken(20)).'-'.date('Ymdhis');
		$vendor->name 		= remove_symbols($this->input->post('name'));
		$vendor->email 		= $this->input->post('email');
		$vendor->password 	= DefuseLib::encrypt($this->input->post('password'));
		$vendor->status 	= 'register';
		$vendor->ipaddress 	= $this->input->ip_address();

		if(!$vendor->save()){
			$this->restapi->error("maaf ada kesalahan silahkan ulangi kembali");
		}

		$mail 					= new Magicmailer;
		$email['vendor'] 		= $vendor;
	    $mail->addAddress($vendor->email, $vendor->name);
	    $mail->Body    			= $this->blade->draw('email.vendor.register',$email);	
	    $mail->Subject 			= 'Konfirmasi Email Pendaftaran anda';
    	$mail->AltBody 			= 'silahkan aktivasi email pendaftaran anda';
		$mail->send();

		$url 	= '/authentication/registersuccess/vendor?token='.$vendor->token;
		$this->restapi->response($url);
		return;
	}

	public function sendrestore($page){
		$this->validation->ajaxRequest();

		switch ($page) {
			case 'user':
				$rules 		= [
							    'required' 	=> [
							        ['email']
							    ],
							    'email'		=> [
							    	['email']
							    ]
							  ];

				// Recaptcha
				if(!$this->input->post('g-recaptcha-response')){
					echo goResult(false,"google reCaptcha di butuhkan");
					return;
				}

				if(!gRecaptcha()){
					echo goResult(false,"google reCaptcha tidak sesuai");
					return;
				}

				$validate 	= $this->validation->check($rules,'post');

				if(!$validate->correct){
					echo goResult(false,$validate->data);
					return;
				}

				$user 	= UserModel::where('email',$this->input->post('email'))->whereIn('status',['active','blocked'])->first();
				
				if(!$user){
					echo goResult(false,"maaf akun dengan email tersebut tidak tersedia");
					return;
				}


				$user->token 			= getToken(20).'-'.date('Ymdhis');
				$user->restore_status 	= 1;
				$user->restore_date 	= date('Y-m-d h:i:s');

				if(!$user->save()){
					echo goResult(false,"maaf ada yang sesuatu yang salah silahkan coba kembali(1)");
					return;	
				}	

				$mail 					= new Magicmailer;
				$email['user'] 			= $user;
			    $mail->addAddress($user->email, $user->name);
			    $mail->Body    			= $this->blade->draw('email.user.restore',$email);	
			    $mail->Subject 			= 'Pemulihan akun pengguna';
		    	$mail->AltBody 			= 'Konfirmasi email berikut untuk memulihkan akun anda';
				$mail->send();
				echo goResult(true,$user->token);
				return;

				break;
			case 'vendor':
				$rules 		= [
							    'required' 	=> [
							        ['email']
							    ],
							    'email'		=> [
							    	['email']
							    ]
							  ];

				// Recaptcha
				if(!$this->input->post('g-recaptcha-response')){
					echo goResult(false,"google reCaptcha di butuhkan");
					return;
				}

				if(!gRecaptcha()){
					echo goResult(false,"google reCaptcha tidak sesuai");
					return;
				}

				$validate 	= $this->validation->check($rules,'post');

				if(!$validate->correct){
					echo goResult(false,$validate->data);
					return;
				}

				$vendor 	= VendorModel::where('email',$this->input->post('email'))->whereIn('status',['active','blocked'])->first();
				
				if(!$vendor){
					echo goResult(false,"maaf akun dengan email tersebut tidak tersedia");
					return;
				}

				$vendor->token 			= getToken(20).'-'.date('Ymdhis');
				$vendor->restore_status = 1;
				$vendor->restore_date 	= date('Y-m-d h:i:s');

				if(!$vendor->save()){
					echo goResult(false,"maaf ada yang sesuatu yang salah silahkan coba kembali(1)");
					return;	
				}	

				$mail 					= new Magicmailer;
				$email['vendor'] 			= $vendor;
			    $mail->addAddress($vendor->email, $vendor->name);
			    $mail->Body    			= $this->blade->draw('email.vendor.restore',$email);	
			    $mail->Subject 			= 'Pemulihan akun Toko';
		    	$mail->AltBody 			= 'Konfirmasi email berikut untuk memulihkan akun anda';
				$mail->send();
				echo goResult(true,$vendor->token);
				return;
				
				break;
			
			default:
				$this->webdata->show_404();
				break;
		}
	}

	public function completesendrestore($page,$token){

		switch ($page) {
			case 'user':
				$user 			= UserModel::where('status','!=','register')
									->where('restore_status',1)
									->token($token)->first();

				if(!$user){
					$this->webdata->show_404();
				}

				if (strtotime('-1 day') < strtotime($user->restore_date)) {

					$user->restore_status 	= 0;
					$user->restore_date 	= null;
					$user->save();

				 	$this->webdata->show_404();	   
				}

				$data['user'] 	= $user;
				echo $this->blade->draw('user.auth.restorecomplete',$data);
				return;

				break;
			case 'resenduser':

				$user 			= UserModel::where('status','!=','register')
									->where('restore_status',1)
									->token($token)->first();

				if(!$user){
					$this->webdata->show_404();
				}

				if (strtotime('-1 day') < strtotime($user->restore_date)) {

					$user->restore_status 	= 0;
					$user->restore_date 	= null;
					$user->save();

				 	$this->webdata->show_404();	   
				}

				$mail 			= new Magicmailer;
				$email['user'] 	= $user;
			    $mail->addAddress($user->email, $user->name);
			    $mail->Body    	= $this->blade->draw('email.user.restore',$email);	
			    $mail->Subject 	= 'Pemulihan akun pengguna';
		    	$mail->AltBody 	= 'Konfirmasi email berikut untuk memulihkan akun anda';
				$mail->send();

				redirect('authentication/completesendrestore/user/'.$user->token.'?resend=true');
				return;

				break;
			case 'vendor':
				$vendor 		= VendorModel::where('status','!=','register')
									->where('restore_status',1)
									->token($token)->first();

				if(!$vendor){
					$this->webdata->show_404();
				}

				if (strtotime('-1 day') < strtotime($vendor->restore_date)) {

					$vendor->restore_status 	= 0;
					$vendor->restore_date 	= null;
					$vendor->save();

				 	$this->webdata->show_404();	   
				}

				$data['vendor'] 	= $vendor;
				echo $this->blade->draw('user.vendor.restorecomplete',$data);
				return;

				break;
			case 'resendvendor':

				$vendor 		= VendorModel::where('status','!=','register')
									->where('restore_status',1)
									->token($token)->first();

				if(!$vendor){
					$this->webdata->show_404();
				}

				if (strtotime('-1 day') < strtotime($vendor->restore_date)) {

					$vendor->restore_status 	= 0;
					$vendor->restore_date 	= null;
					$vendor->save();

				 	$this->webdata->show_404();	   
				}

				$mail 			= new Magicmailer;
				$email['vendor']= $vendor;
			    $mail->addAddress($vendor->email, $vendor->name);
			    $mail->Body    	= $this->blade->draw('email.vendor.restore',$email);	
			    $mail->Subject 	= 'Pemulihan akun Toko';
		    	$mail->AltBody 	= 'Konfirmasi email berikut untuk memulihkan akun anda';
				$mail->send();

				redirect('authentication/completesendrestore/vendor/'.$user->token.'?resend=true');
				return;

				break;
			default:
				$this->webdata->show_404();
				break;
		}
	}

	public function restore($page,$token){
		switch ($page) {
			case 'user':
				$user 			= UserModel::where('status','!=','register')
									->where('restore_status',1)
									->token($token)->first();

				if(!$user){
					$this->webdata->show_404();
				}

				if (strtotime('-1 day') < strtotime($user->restore_date)) {

					$user->restore_status 	= 0;
					$user->restore_date 	= null;
					$user->save();

				 	$this->webdata->show_404();	   
				}

				$data['user'] 	= $user;
				echo $this->blade->draw('user.auth.registeraction',$data);
				return;

				break;
			case 'vendor':
				$vendor 		= VendorModel::where('status','!=','register')
									->where('restore_status',1)
									->token($token)->first();

				if(!$vendor){
					$this->webdata->show_404();
				}

				if (strtotime('-1 day') < strtotime($vendor->restore_date)) {

					$vendor->restore_status 	= 0;
					$vendor->restore_date 	= null;
					$vendor->save();

				 	$this->webdata->show_404();	   
				}

				$data['vendor'] 	= $vendor;
				echo $this->blade->draw('user.vendor.registeraction',$data);
				return;

				break;
			
			default:
				$this->webdata->show_404();
				break;
		}
	}

	public function actionrestore($page){

		switch ($page) {
			case 'user':
				$this->validation->ajaxRequest();

				$rules 		= [
							    'required' 	=> [
							        ['token'],['password'],['confirmation_password']
							    ],
							    'lengthMin'	=> [
							    	['password',8],
							    	['confirmation_password',8],
							    ],
							    'equals' 	=> [
							    	['confirmation_password','password']
							    ]
							  ];

				// Recaptcha
				if(!$this->input->post('g-recaptcha-response')){
					echo goResult(false,"google reCaptcha di butuhkan");
					return;
				}

				if(!gRecaptcha()){
					echo goResult(false,"google reCaptcha tidak sesuai");
					return;
				}

				$validate 	= $this->validation->check($rules,'post');

				if(!$validate->correct){
					echo goResult(false,$validate->data);
					return;
				}

				$token 			= $this->input->post('token');

				$user 			= UserModel::where('status','!=','register')
									->where('restore_status',1)
									->token($token)->first();

				if(!$user){
					echo goResult(false,"user not found! , please do restore again");
					return;
				}

				if (strtotime('-1 day') < strtotime($user->restore_date)) {

					$user->restore_status 	= 0;
					$user->restore_date 	= null;
					$user->save();

				 	echo goResult(false,"waktu pemulihan telah berakhir , silahkan pulihkan kembali");
					return;
				}

				$user->password_old 		= $user->password;
				$user->password_old_date 	= date('Y-m-d');
				$user->password 			= DefuseLib::encrypt($this->input->post('password'));
				$user->token 				= getToken('20').'-'.date('Ymdhis');
				$user->restore_status 		= 0;
				$user->restore_date 		= null;

				if(!$user->save()){
					echo goResult(false,"ada sesuatu yang salah silahkan coba kembali");
					return;
				}

				echo goResult(true,"success");
				return;
				break;
			case 'vendor':
				$this->validation->ajaxRequest();

				$rules 		= [
							    'required' 	=> [
							        ['token'],['password'],['confirmation_password']
							    ],
							    'lengthMin'	=> [
							    	['password',8],
							    	['confirmation_password',8],
							    ],
							    'equals' 	=> [
							    	['confirmation_password','password']
							    ]
							  ];

				// Recaptcha
				if(!$this->input->post('g-recaptcha-response')){
					echo goResult(false,"google reCaptcha di butuhkan");
					return;
				}

				if(!gRecaptcha()){
					echo goResult(false,"google reCaptcha tidak sesuai");
					return;
				}

				$validate 	= $this->validation->check($rules,'post');

				if(!$validate->correct){
					echo goResult(false,$validate->data);
					return;
				}

				$token 			= $this->input->post('token');

				$vendor 		= VendorModel::where('status','!=','register')
									->where('restore_status',1)
									->token($token)->first();

				if(!$vendor){
					echo goResult(false,"user not found! , please do restore again");
					return;
				}

				if (strtotime('-1 day') < strtotime($vendor->restore_date)) {

					$vendor->restore_status 	= 0;
					$vendor->restore_date 	= null;
					$vendor->save();

				 	echo goResult(false,"waktu pemulihan telah berakhir , silahkan pulihkan kembali");
					return;
				}

				$vendor->password_old 		= $vendor->password;
				$vendor->password_old_date 	= date('Y-m-d');
				$vendor->password 			= DefuseLib::encrypt($this->input->post('password'));
				$vendor->token 				= getToken('20').'-'.date('Ymdhis');
				$vendor->restore_status 		= 0;
				$vendor->restore_date 		= null;

				if(!$vendor->save()){
					echo goResult(false,"ada sesuatu yang salah silahkan coba kembali");
					return;
				}

				echo goResult(true,"success");
				return;
				break;
			
			default:
				$this->webdata->show_404();
				break;
		}
		
	}

	public function confirmation($page){

		$rules 		= [
						    'required' 	=> [
						        ['token']
						    ]
						  ];

		$validate 	= $this->validation->check($rules,'get');

		if(!$validate->correct){
			$this->webdata->show_404();
		}

		$token 	= $this->input->get('token');

		switch ($page) {
			case 'user':
				$user 		= UserModel::where('status','register')->token($token)->first();

				if(!$user){
					$this->webdata->show_404();
				}

				$user->token 		= getToken(20).'-'.date('Ymdhis');
				$user->ipaddress 	= $this->input->ip_address();
				$user->status 		= 'active';
				$user->save();

				$url 			= $this->session->userdata('catched_location_user');
				$newdata 		= array('auth_user'	=>  $user->token);
				$this->session->set_userdata($newdata);	
				redirect($url,true);
				return;


				break;
			case 'vendor':

				$vendor 		= VendorModel::where('status','register')->token($token)->first();

				if(!$vendor){
					$this->webdata->show_404();
				}

				$vendor->token 		= strtoupper(getToken(20)).'-'.date('Ymdhis');
				$vendor->ipaddress 	= $this->input->ip_address();
				$vendor->status 	= 'incomplete';
				$vendor->save();

				$url 			= $this->session->userdata('catched_location_vendor');
				$newdata 		= array('auth_vendor'	=>  $vendor->token);
				$this->session->set_userdata($newdata);	
				redirect($url,true);
				return;
				break;
			default:
				$this->webdata->show_404();
				break;
		}
	
	}

}