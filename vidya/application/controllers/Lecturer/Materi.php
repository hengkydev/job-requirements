<?php
class Materi extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
	$this->lecturer 	= $this->middleware->lecturer();
		$this->webdata->basicLoad();
	}


	public function index()
	{
		$data['__MENU']			= "materi";
		$data['head_text']		= 'Materi';
		$data['body_text']		= "Daftar Materi";
		$data['table'] 			= MateriModel::desc()->get();
		echo $this->blade->draw('lecturer.materi.index',$data);
	}

	public function create(){

		$data 		= [
			"__MENU"			=> "materi_create",
			"type"				=> "create",
			"url_action"		=> base_url("lecturer/materi/created"),
			'head_text'			=> 'Buat Materi',
			"body_text"			=> "Membuat Materi Baru"
		];

		echo $this->blade->draw('lecturer.materi.content',$data);
	}

	public function detail($id=null){

		if(!$id){
			show_404();
		}

		$table 		= MateriModel::with("lecturer")->find($id);

		if(!$table){
			show_404();
		}

		$data 		= [
			"__MENU"			=> "materi",
			'head_text'			=> 'Detail Materi',
			"body_text"			=> "{$table->name}",
			"url_action"		=> base_url("lecturer/materi/commentsubmit"),
			"table"				=> $table
		];

		echo $this->blade->draw('lecturer.materi.detail',$data);
	}

	public function commentsubmit(){

		$rules = [
				    'required' 	=>	[
    					['comment'],['materi_id']
    				]
				 ];
		
		$validate 	= $this->validation->check($rules,'post');

		if(!$validate->correct){
			$this->restapi->error($validate->data);
		}

		$materi 				= MateriModel::find($this->input->post("materi_id"));
		if(!$materi){
			$this->restapi->error("Materi tidak ditemukan!");
		}

		$table 					= new MateriCommentsModel;
		$table->materi_id		= $materi->id;
		$table->lecturer_id 		= $this->lecturer->id;
		$table->comment 		= $this->input->post("comment");
		$table->role 			= "lecturer";

		if(!$table->save()){

			$this->restapi->error("Maaf ada kesalahan silahkan coba nanti");
		}

		$this->validation->setSuccess("Komentar anda telah tersampaikan");
		$this->restapi->response("/lecturer/materi/detail/".$materi->id);

	}

	public function update($id=null){

		if(!$id){
			show_404();
		}

		$table 		= MateriModel::find($id);

		if(!$table){
			show_404();
		}

		$data 		= [
			"__MENU"			=> "materi_update",
			"type"				=> "update",
			"url_action"		=> base_url("lecturer/materi/updated"),
			'head_text'			=> 'Ubah Materi',
			"body_text"			=> "Mengubah Materi {$table->name}",
			"table"				=> $table
		];

		echo $this->blade->draw('lecturer.materi.content',$data);
	}

	public function created(){

		$rules = [
				    'required' 	=>	[
    					['name']
    				]
				 ];
		
		$validate 	= $this->validation->check($rules,'post');

		if(!$validate->correct){
			$this->restapi->error($validate->data);
		}

		if(!$this->validation->checkFiles("attachment")){
			$this->restapi->error("Maaf tidak ada file yang di sisipkan");
		}

		$table 					= new MateriModel;
		$table->lecturer_id		= $this->lecturer->id;

		$table->name 			= $this->input->post("name");
		$table->description 	= $this->input->post("description");
		$table->status 			= ($this->input->post("status")) ? "publish" : "draft";

		if($this->validation->checkFiles("image")){
			$filename 				= 'MATERI '.limit_string($table->name).' ('.date('Ymdhis').')';
			$upload 				= $this->upfiles->allSizeImageUpload("materi","image",$filename);

			if(!$upload->status){
				$this->restapi->error($upload->result);
			}

			$table->image 			= $upload->result;
		}

		if(!$table->save()){

			if($table->image){
				$this->upfiles->remove("materi",$table->image);	
			}

			$this->restapi->error("Maaf ada kesalahan silahkan coba nanti");
		}

		foreach ($_FILES['attachment']['name'] as $key => $value) {

			if( $_FILES['attachment']['size'][$key] == 0 && $_FILES['attachment']['name'][$key] == false ){
				$this->materiAttachmentRemove($table->id);
				$this->restapi->error("Nama file yang di sisipkan kosong !");
			}

			$name 								= $_FILES['attachment']['name'][$key];
			$_FILES['system_file']['name']		= $_FILES['attachment']['name'][$key];
	        $_FILES['system_file']['type']		= $_FILES['attachment']['type'][$key];
	        $_FILES['system_file']['tmp_name']	= $_FILES['attachment']['tmp_name'][$key];
	        $_FILES['system_file']['error']		= $_FILES['attachment']['error'][$key];
	        $_FILES['system_file']['size']		= $_FILES['attachment']['size'][$key];

	        $upload_attachment 			= $this->upfiles->upload([
												"path"			=> content_dir("materi"),
												"name"			=> "system_file",
												"max_size"		=> 50000,
												"allowed"		=> "*",
												"file_name"		=> 'ATTACHMENT__['.strtoupper(getToken(5)).']__('.date('Ymdhis').')',
										]);

	        if(!$upload_attachment->status){
	        	$this->materiAttachmentRemove($table->id);
	        	$this->restapi->error($key." ".$upload_attachment->result);
	        }

	        $attachment 				= new MateriAttachmentsModel;
	        $attachment->materi_id 		= $table->id;
	        $attachment->file_name 		= $upload_attachment->result->file_name;
	        $attachment->extension 		= $upload_attachment->result->file_ext;
	        $attachment->file_type 		= $upload_attachment->result->file_type;
	        $attachment->size 			= $upload_attachment->result->file_size;

	        $attachment->save();

		}

		$this->validation->setSuccess("Materi baru telah ditambahkan");
		$this->restapi->response("/lecturer/materi");

	}

	private function materiAttachmentRemove($id){

		$table 			= MateriModel::find($id);
		if(!$table){
			return false;
		}

		if($table->image){
			$this->upfiles->remove("materi",$table->image);	
		}
		foreach ($table->attachments as $value) {
			$this->upfiles->removeSingle("materi",$value->file_name);	
		}

		MateriAttachmentsModel::where("materi_id",$id)->delete();
		$table->delete();

		return true;

	}

	public function updated(){

			$rules = [
				    'required' 	=>	[
    					['name'],['id']
    				]
				 ];
		
		$validate 	= $this->validation->check($rules,'post');

		if(!$validate->correct){
			$this->restapi->error($validate->data);
		}

		

		$table 					= MateriModel::find($this->input->post('id'));
		if(!$table){
			$this->restapi->error("Maaf materi tidak di temukan");
		}

		$table->lecturer_id		= $this->lecturer->id;
		$table->name 			= $this->input->post("name");
		$table->description 	= $this->input->post("description");
		$table->status 			= ($this->input->post("status")) ? "publish" : "draft";

		if($this->validation->checkFiles("image")){
			$filename 				= 'MATERI '.limit_string($table->name).' ('.date('Ymdhis').')';
			$upload 				= $this->upfiles->allSizeImageUpload("materi","image",$filename);

			if(!$upload->status){
				$this->restapi->error($upload->result);
			}
		}

		if(!$table->save()){

			if(isset($upload->result)){
				if($table->image){
					$this->upfiles->remove("materi",$table->image);		
				}
			}

			$this->restapi->error("Maaf ada kesalahan silahkan coba nanti");
		}

		foreach ($table->attachments as $result) {
			if(!$this->input->post("attachment_valid_".$result->id)){
				$this->upfiles->removeSingle("materi",$result->file_name);
				MateriAttachmentsModel::find($result->id)->delete();
				continue;
			}
			else if($this->validation->checkFiles("attachment_".$result->id)){

				$attachment 				= MateriAttachmentsModel::find($result->id);
				if(!$attachment){
					continue;
				}
				$name 								= $_FILES['attachment_'.$result->id]['name'];
		        $upload_attachment 			= $this->upfiles->upload([
													"path"			=> content_dir("materi"),
													"name"			=> "attachment_".$result->id,
													"max_size"		=> 50000,
													"allowed"		=> "*",
													"file_name"		=> 'ATTACHMENT__['.strtoupper(getToken(5)).']__('.date('Ymdhis').')',
											]);

		        if(!$upload_attachment->status){
		        	$this->restapi->error($key." ".$upload_attachment->result);
		        }

		        $attachment->materi_id 		= $table->id;
		        $attachment->file_name 		= $upload_attachment->result->file_name;
		        $attachment->extension 		= $upload_attachment->result->file_ext;
		        $attachment->file_type 		= $upload_attachment->result->file_type;
		        $attachment->size 			= $upload_attachment->result->file_size;
		        $attachment->save();
			}
		}

		if(isset($_FILES['attachment']['name'])){
			foreach ($_FILES['attachment']['name'] as $key => $value) {

				if( $_FILES['attachment']['size'][$key] == 0 && $_FILES['attachment']['name'][$key] == false ){
					$this->materiAttachmentRemove($table->id);
					$this->restapi->error("Nama file yang di sisipkan kosong !");
				}

				$name 								= $_FILES['attachment']['name'][$key];
				$_FILES['system_file']['name']		= $_FILES['attachment']['name'][$key];
		        $_FILES['system_file']['type']		= $_FILES['attachment']['type'][$key];
		        $_FILES['system_file']['tmp_name']	= $_FILES['attachment']['tmp_name'][$key];
		        $_FILES['system_file']['error']		= $_FILES['attachment']['error'][$key];
		        $_FILES['system_file']['size']		= $_FILES['attachment']['size'][$key];

		        $upload_attachment 			= $this->upfiles->upload([
													"path"			=> content_dir("materi"),
													"name"			=> "system_file",
													"max_size"		=> 50000,
													"allowed"		=> "*",
													"file_name"		=> 'ATTACHMENT__['.strtoupper(getToken(5)).']__('.date('Ymdhis').')',
											]);

		        if(!$upload_attachment->status){
		        	$this->materiAttachmentRemove($table->id);
		        	$this->restapi->error($key." ".$upload_attachment->result);
		        }

		        $attachment 				= new MateriAttachmentsModel;
		        $attachment->materi_id 		= $table->id;
		        $attachment->file_name 		= $upload_attachment->result->file_name;
		        $attachment->extension 		= $upload_attachment->result->file_ext;
		        $attachment->file_type 		= $upload_attachment->result->file_type;
		        $attachment->size 			= $upload_attachment->result->file_size;

		        $attachment->save();

			}
		}

	

		if(isset($upload->result)){
			if($table->image){
				$this->upfiles->remove("materi",$table->image);		
			}
			$table->image 			= $upload->result;
		}

		$table->save();

		$this->validation->setSuccess("Materi telah di perbarui");
		$this->restapi->response("/lecturer/materi");

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
		$table 		= MateriModel::whereIn('id',$this->input->post('data'))->get();

		if(count($table)<=0){
			$this->validation->setError("Tidak ada data yang di pilih!");
			redirect('lecturer/post');
		}

		switch ($action) {
			case 'publish':
				MateriModel::whereIn('id',$this->input->post('data'))->update(['status'=>'publish']);
				$this->validation->setSuccess("Data menjadi 'publish'");
				break;
			case 'draft':
				MateriModel::whereIn('id',$this->input->post('data'))->update(['status'=>'draft']);
				$this->validation->setSuccess("Data Menjadi 'Draft'");
				break;
			case 'delete':
				$table 	= MateriModel::whereIn('id',$this->input->post('data'))->get();
				foreach ($table as $result) {
					if($result->image){
						$this->upfiles->remove("materi",$result->image);	
					}
				}

				MateriModel::whereIn('id',$this->input->post('data'))->delete();
				$this->validation->setSuccess("Data telah terhapus");
				break;
			default:
				show_404();
				break;
		}

		redirect('lecturer/post');
		return;
	}

	public function remove($id=null){
		if(!$id){
			show_404();
		}

		$table 		= MateriModel::find($id);
		if(!$table){
			show_404();
		}

		if($table->image){
			$this->upfiles->remove("materi",$table->image);	
		}

		$table->delete();
		$this->validation->setSuccess("Materi '{$table->name}' telah di hapus");
		redirect("lecturer/post");
	}
}