<?php
class User extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->superuser 	= $this->middleware->superuser();
		$this->webdata->superuserLoad();
	}


	public function index()
	{
		$data['__MENU']			= "user";
		$data['head_text']		= 'Pengguna';
		$data['body_text']		= "Daftar Pengguna";
		$data['table'] 			= UsersModel::desc()->get();
		echo $this->blade->draw('superuser.user.index',$data);
	}

	public function create(){

		$data 		= [
			"__MENU"			=> "user_create",
			"type"				=> "create",
			"url_action"		=> base_url("superuser/user/created"),
			'head_text'			=> 'Buat Pengguna',
			"body_text"			=> "Membuat Pengguna Baru"
		];

		echo $this->blade->draw('superuser.user.content',$data);
	}

	public function update($id=null){

		if(!$id){
			show_404();
		}

		$table 		= UsersModel::find($id);

		if(!$table){
			show_404();
		}

		$data 		= [
			"__MENU"			=> "user_update",
			"type"				=> "update",
			"url_action"		=> base_url("superuser/user/updated"),
			'head_text'			=> 'Ubah Pengguna',
			"body_text"			=> "Mengubah Pengguna {$table->nama}",
			"table"				=> $table
		];

		echo $this->blade->draw('superuser.user.content',$data);
	}

	public function created(){

		$rules = [
				    'required' 	=>	[
    					['name'],['username'],['email'],
    					['password'],['password_confirmation']
    				],
    				'lengthBetween' => [
    					['username',5,20]
    				],
    				'alphaNum'		=> [
    					['username']
    				],
    				'lengthMin'		=> [
    					['password',8],['password_confirmation',8]
    				],
    				'equals'	=> [
    					['password_confirmation','password']
    				]
				 ];
		
		$validate 	= $this->validation->check($rules,'post');

		if(!$validate->correct){
			$this->restapi->error($validate->data);
		}

		$username 				= strtolower($this->input->post("username"));
		$check 					= UsersModel::where("username",$this->input->post("username"))->first();
		if(isset($check->id)){
			$this->restapi->error("maaf '{$username}' telah di gunakan!");
		}

		$email 					= $this->input->post("email");
		$check 					= UsersModel::where("email",$this->input->post("email"))->first();
		if(isset($check->id)){
			$this->restapi->error("maaf '{$email}' telah di gunakan!");
		}

		$password 				= DefuseLib::encrypt($this->input->post("password"));

		$table 					= new UsersModel;
		$table->username 		= $username;
		$table->email 			= $email;
		$table->password 		= $password;
		$table->name 			= $this->input->post("name");
		$table->phone 			= $this->input->post("phone");
		$table->status 			= ($this->input->post("status")) ? "active" : "suspend";

		if($this->validation->checkFiles("image")){

			$filename 				= 'USER '.limit_string($this->input->post('name')).' ('.date('Ymdhis').')';
			$upload 				= $this->upfiles->allSizeImageUpload("users","image",$filename);

			if(!$upload->status){
				$this->restapi->error($upload->result);
			}

			$table->image 			= $upload->result;
		}


		if(!$table->save()){

			if($table->image){
				$this->upfiles->remove("users",$table->image);	
			}

			$this->restapi->error("Maaf ada kesalahan silahkan coba nanti");
		}

		$this->validation->setSuccess("Pengguna baru telah ditambahkan");
		$this->restapi->response("/superuser/user");

	}

	public function updated(){

		$rules = [
				    'required' 	=>	[
    					['id'],['name'],['username'],['email']
    				],
    				'lengthBetween' => [
    					['username',5,20]
    				],
    				'alphaNum'		=> [
    					['username']
    				]
				 ];
		
		$validate 	= $this->validation->check($rules,'post');

		if(!$validate->correct){
			$this->restapi->error($validate->data);
		}

		$table 					= UsersModel::find($this->input->post("id"));
		if(!$table){
			$this->restapi->error("Maaf pengguna tidak di temukan!");
		}

		$username 				= strtolower($this->input->post("username"));
		$check 					= UsersModel::where("username",$this->input->post("username"))
									->where("username","!=",$table->username)
									->first();
		if(isset($check->id)){
			$this->restapi->error("maaf '{$username}' telah di gunakan!");
		}

		$email 					= $this->input->post("email");
		$check 					= UsersModel::where("email",$this->input->post("email"))
									->where("email","!=",$table->email)
									->first();
		if(isset($check->id)){
			$this->restapi->error("maaf '{$email}' telah di gunakan!");
		}

		if($this->input->post("password")){

			$rules = [
				    'required' 	=>	[
    					['password'],['password_confirmation']
    				],
    				'lengthMin'		=> [
    					['password',8],['password_confirmation',8]
    				],
    				'equals'	=> [
    					['password_confirmation','password']
    				]
				 ];
		
			$validate 	= $this->validation->check($rules,'post');

			if(!$validate->correct){
				$this->restapi->error($validate->data);
			}
			$password 				= DefuseLib::encrypt($this->input->post("password"));
			$table->password 		= $password;	
		}
		

		$table->username 		= $username;
		$table->email 			= $email;
		$table->name 			= $this->input->post("name");
		$table->phone 			= $this->input->post("phone");
		$table->status 			= ($this->input->post("status")) ? "active" : "suspend";

		if($this->validation->checkFiles("image")){

			$filename 				= 'USER '.limit_string($this->input->post('name')).' ('.date('Ymdhis').')';
			$upload 				= $this->upfiles->allSizeImageUpload("users","image",$filename);

			if(!$upload->status){
				$this->restapi->error($upload->result);
			}
		}


		if(!$table->save()){

			if($table->image){
				$this->upfiles->remove("users",$table->image);	
			}

			$this->restapi->error("Maaf ada kesalahan silahkan coba nanti");
		}

		if($table->image && isset($upload->status)){
			$this->upfiles->remove("users",$table->image);	
			$table->image 			= $upload->result;
		}

		$table->save();

		$this->validation->setSuccess("Pengguna '{$table->name}' telah di perbarui");
		$this->restapi->response("/superuser/user");

	}


	public function bulkaction(){
		$rules = [
					'required' 	=> [
				        ['action'],['data']
				    ]
				  ];

		$validate 	= $this->validation->check($rules,'post');

		if(!$validate->correct){
			$this->validation->setError($validate->data);
		}

		$action 	= $this->input->post('action');
		$table 		= UsersModel::whereIn('id',$this->input->post('data'))->get();

		if(count($table)<=0){
			$this->validation->setError("Tidak ada data yang di pilih!");
			redirect('superuser/post');
		}

		switch ($action) {
			case 'active':
				UsersModel::whereIn('id',$this->input->post('data'))->update(['status'=>'active']);
				$this->validation->setSuccess("Data di 'Aktifkan'");
				break;
			case 'suspend':
				UsersModel::whereIn('id',$this->input->post('data'))->update(['status'=>'suspend']);
				$this->validation->setSuccess("Data di 'Blokir'");
				break;
			case 'delete':
				$table 	= UsersModel::whereIn('id',$this->input->post('data'))->get();
				foreach ($table as $result) {
					if($result->image){
						$this->upfiles->remove("users",$result->image);	
					}
				}

				UsersModel::whereIn('id',$this->input->post('data'))->delete();
				$this->validation->setSuccess("Data telah terhapus");
				break;
			default:
				show_404();
				break;
		}

		redirect('superuser/user');
		return;
	}

	public function remove($id=null){
		if(!$id){
			show_404();
		}

		$table 		= UsersModel::find($id);
		if(!$table){
			show_404();
		}

		if($table->image){
			$this->upfiles->remove("users",$table->image);	
		}

		$table->delete();
		$this->validation->setSuccess("Pengguna '{$table->name}' telah di hapus");
		redirect("superuser/user");
	}


	public function import(){
		if(!$this->validation->checkFiles("excel")){
			$this->validation->setError("File excel tidak terupload !");
			redirect("superuser/user");
		}

		$rules = [
				    'required' 	=>	[
    					['option']
    				],
    				'in'		=> [
    					['option',['1','2','3']]
    				]
				 ];
		
		$validate 	= $this->validation->check($rules,'post');

		if(!$validate->correct){
			$this->validation->setError("pilihan import tidak tersedia !");
			redirect("superuser/user");
		}
		$reader 		= new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
		$reader->setReadDataOnly(true);
		$spreadsheet 	= $reader->load($_FILES['excel']['tmp_name']);

		/**
		Begin config arrow for import user
		*/
		$beginRow 		= 9;
		$lastRow 		= $spreadsheet->getActiveSheet()->getHighestRow();
		$error 			= [];
		$log 			= [];
		$rowSuccess 	= 0;

		for ($i=9; $i <= $lastRow ; $i++) { 
			$data 		= [
				"name" 		=> (string) $spreadsheet->getActiveSheet()->getCell("D{$i}"),
				"email" 	=> (string) $spreadsheet->getActiveSheet()->getCell("E{$i}"),
				"phone" 	=> (string) $spreadsheet->getActiveSheet()->getCell("F{$i}"),
				"status" 	=> (string) $spreadsheet->getActiveSheet()->getCell("C{$i}"),
				"username" 	=> (string) strtolower($spreadsheet->getActiveSheet()->getCell("A{$i}")),
				"password" 	=> (string) $spreadsheet->getActiveSheet()->getCell("B{$i}"),
			];
			$import 	= $this->insertImport($i,$data,$this->input->post("option"));

			if(!$import->status){
				$error[] 	= $import->message;
			}else{
				$rowSuccess++;
			}
			$log[] 			= $import->message;

		}
		$this->restapi->error($log);
		exit();

		foreach ($spreadsheet->getActiveSheet()->toArray() as $result) {
			print_r($result);
			exit();
		}

		//print_r();
	}


	private function insertImport($row,$data,$option){

		$data 				= toObject($data);

		$response['status']		= false;
		$response['message']	= 'Tidak ada';

		if($data->name=="" || $data->email==""){
			$response['message']	= "baris ({$row}) : data nama dan email kosong";
			return toObject($response);
		}

		if(!$data->username || $data->username==""){

			$notFound				= true;
			while ($notFound) {
				$data->username 	= goExplode($data->name,' ',0).rand(1,999);
				$usernameCheck 		= UsersModel::where("username",$data->username)->first();
				if(!$usernameCheck){
					$notFound 		= false;
				}
			}
		}

		if ( !preg_match('/^[A-Za-z][A-Za-z0-9]{5,31}$/', $data->username) ){
			$response['message']	= "baris ({$row}) : isi data username salah (tanpa spasi, hanya angka dan huruf)";
			return toObject($response);
		}

		if(!$data->password || $data->password==""){
			$data->password 	= 'password_'.$data->username;
		}

		$ava_status 		= ['active','suspend'];
		if(!in_array($data->status, $ava_status)){
			$response['message']	= "baris ({$row}) : pilihan status tidak sesuai (active,suspend)";
			return toObject($response);
		}

		switch ($option) {
			case '1':
				//UsersModel::truncate();
				$table 		= new UsersModel;
				break;
			case '2':
				
				$exist 		= UsersModel::where("email",$data->email)
								->orWhere("username",$data->username)->first();
				if(isset($exist->id)){
					$response['message']	= "baris ({$row}) : Username / email telah di gunakan";
					return toObject($response);
				}

				$table 		= new UsersModel;

				break;
			case '3':
				
				$table 		= UsersModel::where("email",$data->email)
								->orWhere("username",$data->username)->first();
				if(!$table){
					$table	= new UsersModel;
				}

				break;
			default:
				$response['message']	= "Invalid OPtion";
				return toObject($response);
				break;
		}

		$table->name 			= $data->name;
		$table->email 			= $data->email;
		$table->username 		= $data->username;
		$table->password 		= DefuseLib::encrypt($data->password);
		$table->status 			= $data->status;
		$table->phone 			= $data->phone;
		if(!$table->save()){
			$response['message']	= "baris ({$row}) : gagal menyimpan ke database ";
			return toObject($response);
		}

		$response['status'] 	= true;
		$response['message']	= "baris ({$row}) : berhasil di import ! ";
		return toObject($response);
		//$table 				= 

	}
}