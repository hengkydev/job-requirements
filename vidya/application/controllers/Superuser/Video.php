<?php
class Video extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->superuser 	= $this->middleware->superuser();
		$this->webdata->superuserLoad();
	}

	public function index()
	{
		$data['__MENU']			= "video";
		$data['text_content']	= "Video - Daftar Video";
		$data['video'] 			= VideoModel::desc()->get();
		echo $this->blade->draw('superuser.video.index',$data);
	}

	public function create(){

		$data 		= [
			"__MENU"			=> "video_create",
			"type"				=> "create",
			"url_action"		=> base_url("superuser/video/created"),
			"text_content"		=> "Membuat Video Baru"
		];

		echo $this->blade->draw('superuser.video.content',$data);
	}

	public function created(){

		$rules = [
				    'required' 	=>	[
    					['name'],['type']
    				],
    				'in'		=> [
    					['type',  ['file','youtube'] ]
    				]
				 ];
		
		$validate 	= $this->validation->check($rules,'post');

		if(!$validate->correct){
			$this->restapi->error($validate->data);
		}

		$table 				= new VideoModel;
		$table->name 		= $this->input->post("name");
		$table->type 		= $this->input->post("type");
		$table->description = $this->input->post("description");
		$table->status 		= ($this->input->post('status')) ? 'publish' : 'draft';

		if($this->input->post("type")=="file"){

			if(!$this->validation->checkFiles("value")){
				$this->restapi->error("File Video Required !");
			}

			$filename 				= 'VIDEO '.limit_string($this->input->post('name')).' ('.date('Ymdhis').')';
			$upload 				= $this->upfiles->submit([
											"name"		=> $filename,
											"filename"	=> "value",
											"path"		=> "video",
											"ext"		=> "*",
											"max"		=> 100000
									  ]);

			if(!$upload->status){
				$this->restapi->error($upload->result);
			}

			$snapshot = VideoEdit::snapshot([
				"file"		=> content_dir('video/'.$upload->result),
				"output" 	=> content_dir('images/lg/video/'.seo($filename).'.jpg')
			]);

			if($snapshot){
				$upload_ss 				= $this->upfiles->allSizeImage(seo($filename).'.jpg',"video");

				if($upload_ss->status){
					$table->image = seo($filename).'.jpg';
				}
			}

			$table->value 			= $upload->result;

		}else{
			$table->value 			= $this->input->post('value');
		}

		if(!$table->save()){

			if($table->value){
				if($table->image){
					$this->upfiles->remove("video",$table->image);	
				}
				$this->upfiles->removeSingle("video",$table->value);	
			}

			$this->restapi->error("Maaf ada kesalahan silahkan coba nanti");
		}

		$this->validation->setSuccess("Video baru telah ditambahkan");
		$this->restapi->response("/superuser/video");

	}

	public function update($id=null){

		if(!$id){
			show_404();
		}

		$table 		= VideoModel::find($id);
		if(!$table){
			show_404();
		}


		$data 		= [
			"__MENU"			=> "video_update",
			"type"				=> "update",
			"url_action"		=> base_url("superuser/video/updated"),
			"text_content"		=> "Ubah Video - {$table->name}",
			"table"				=> $table,
		];

		echo $this->blade->draw('superuser.video.content',$data);
	}

	public function updated(){

		$rules = [
				    'required' 	=>	[
    					['id'],['name'],['type']
    				],
    				'in'		=> [
    					['type',  ['file','youtube'] ]
    				]
				 ];
		
		$validate 	= $this->validation->check($rules,'post');

		if(!$validate->correct){
			$this->restapi->error($validate->data);
		}

		$reupload 			= false;
		$reupload_snapshot 	= false;

		$table 				= VideoModel::find($this->input->post('id'));
		if(!$table){
			$this->restapi->error("Video not found!");
		}

		$table->name 		= $this->input->post("name");
		$table->type 		= $this->input->post("type");
		$table->description = $this->input->post("description");
		$table->status 		= ($this->input->post('status')) ? 'publish' : 'draft';

		if($this->input->post("type")=="file"){

			if($this->validation->checkFiles("value")){
					

				$filename 				= 'VIDEO '.limit_string($this->input->post('name')).' ('.date('Ymdhis').')';
				$upload				= $this->upfiles->submit([
												"name"		=> $filename,
												"filename"	=> "value",
												"path"		=> "video",
												"ext"		=> "*",
												"max"		=> 100000
										  ]);

				if(!$upload->status){
					$this->restapi->error($upload->result);
				}

				if($table->type=="file" & $table->value){
					$this->upfiles->removeSingle("video",$table->value);		
					$reupload 				= true;
				}

				$snapshot = VideoEdit::snapshot([
					"file"		=> content_dir('video/'.$upload->result),
					"output" 	=> content_dir('images/lg/video/'.seo($filename).'.jpg')
				]);

				if($snapshot){
					$upload_ss 				= $this->upfiles->allSizeImage(seo($filename).'.jpg',"video");
					if($upload_ss->status){
						$this->upfiles->remove("video",$table->image);		
						$table->image = seo($filename.'.jpg');
						$reupload_snapshot = true;
					}
				}
				
				$table->value 			= $upload->result;
			}
		

		}else{

			if($table->type=="file"){

				if($table->image){
					$this->upfiles->remove("video",$table->image);	
				}

				$this->upfiles->removeSingle("video",$table->value);
			}

			$table->value 			= $this->input->post('value');
		}

		if(!$table->save()){

			if($table->value && $reupload){
				if($table->image && $reupload_snapshot){
					$this->upfiles->remove("video",$table->image);	
				}
				$this->upfiles->removeSingle("video",$table->value);	
			}

			$this->restapi->error("Maaf ada kesalahan silahkan coba nanti");
		}

		$this->validation->setSuccess("Video '{$table->name}' telah di perbarui");
		$this->restapi->response("/superuser/video");

	}

	public function bulkaction(){

		$rules = [
				    'required' 	=> [
				        ['action'],['data']
				    ]
				  ];

		$validate 	= $this->validation->check($rules,'post');

		if(!$validate->correct){
			$this->restapi->error($validate->data);
		}

		$action 		= $this->input->post('action');
		$selectedData 	= $this->input->post('data');
		$table 			= VideoModel::whereIn('id',$selectedData)->get();

		if(!$table){
			$this->restapi->error("no data selected");
		}

		switch ($action) {
			case 'publish':

				VideoModel::whereIn('id',$selectedData)->update(['status'=>0]);
				$this->validation->setSuccess("Changed to publish");	
				$this->restapi->success("Changed to publish");

				break;
			case 'draft':

				VideoModel::whereIn('id',$selectedData)->update(['status'=>1]);
				$this->validation->setSuccess("Changed to draft");	
				$this->restapi->success("Changed to draft");

				break;
			case 'delete':
				$table 	= VideoModel::whereIn('id',$selectedData)->get();
				foreach ($table as $result) {
					if($result->image!=""){
						$this->upfiles->remove("video",$result->image);	
					}
				}

				VideoModel::whereIn('id',$selectedData)->delete();
				$this->validation->setSuccess('data deleted');	
				$this->restapi->success("data deleted");

				break;
			default:
				show_404();
				break;
		}

	}

	public function remove($id=null){
		if(!$id){
			show_404();
		}

		$table 		= VideoModel::find($id);
		if(!$table){
			show_404();
		}

		if($table->type=="file"){

			if($table->image){
				$this->upfiles->remove("video",$table->image);	
			}

			$this->upfiles->removeSingle("video",$table->value);	
		}

		$table->delete();
		$this->validation->setSuccess("Video '{$table->name}' telah di hapus");
		redirect("superuser/video");
	}
}