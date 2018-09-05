<?php
class Materi extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->student 	= $this->middleware->student();
		$this->webdata->basicLoad();
	}


	public function index()
	{
		$data['__MENU']			= "materi";
		$data['head_text']		= 'Materi';
		$data['body_text']		= "Daftar Materi";
		$data['table'] 			= MateriModel::desc()->get();
		echo $this->blade->draw('student.materi.index',$data);
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
			"url_action"		=> base_url("student/materi/commentsubmit"),
			"table"				=> $table
		];

		echo $this->blade->draw('student.materi.content',$data);
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
		$table->student_id 		= $this->student->id;
		$table->comment 		= $this->input->post("comment");
		$table->role 			= "student";

		if(!$table->save()){

			$this->restapi->error("Maaf ada kesalahan silahkan coba nanti");
		}

		$this->validation->setSuccess("Komentar anda telah tersampaikan");
		$this->restapi->response("/student/materi/detail/".$materi->id);

	}
}