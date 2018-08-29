<?php
class Superuser extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->superuser 	= $this->middleware->superuser();
		$this->webdata->load();
		
	}

	public function index()
	{

		echo "HELLO";
		/*$data['category'] 	= ProductCategoryModel::asc('name')->take(10)->get();
		$data['product'] 	= ProductModel::asc('name')->take(10)->get();
		$data['vendor'] 	= VendorModel::asc('name')->take(10)->get();

		echo $this->blade->draw('admin.dashboard.index',$data);*/
	}

// ------------------------------------------------------ POST START
	public function post($page="index",$id=null){
		$this->middleware->rootAccess('post',true);

		$data['__MENU'] 	= 'post';

		if($page=="index"){
			$data['post'] 	= PostModel::desc()->get();
			echo $this->blade->draw('admin.post.index',$data);
			return;

		}
		else if($page=="create"){
			$data['__MENU'] 		= 'post_content';
			$data['type'] 			= 'create';
			$data['urlaction']		= '/superuser/post/created';
			$data['text_content'] 	= 'Create New Post';
			$data['posttags'] 		= [];
			$data['category'] 		= PostCategoryModel::asc('name')->get();
			$data['tags'] 			= PostTagsModel::asc('name')->get();

			echo $this->blade->draw('admin.post.content',$data);
			return;

		}
		else if($page=="created"){
			$this->validation->ajaxRequest('root');

			$rules = [
					    'required' 	=> [
					        ['name'],['category']
					    ]
					  ];

			$validate 	= $this->validation->check($rules,'post');

			if(!$validate->correct){
				$this->restapi->error($validate->data);
			}

			$category 					= PostCategoryModel::find($this->input->post('category'));

			if(!$category){
				$this->restapi->error("Category product not found!");
			}

			if($this->input->post('tags')){
				$tags 					= PostTagsModel::whereIn('id',$this->input->post('tags'))->get();
			}else{
				$tags 					= [];	
			}

			$post 						= new PostModel;
			$post->id_category 			= 1;
			$post->name 				= $this->input->post('name');
			$post->description 			= $this->input->post('description');
			$post->status 				= ($this->input->post('status')) ? '1' : '0';
			
			if(!empty($_FILES['image']['name'])){

				$filename 				= 'POST '.limit_string($this->input->post('name')).' ('.date('Ymdhis').')';
				$upload 				= $this->upfiles->uploadImage(content_dir('images/lg/posts'),'image',$filename);

				if(!$upload->status){
					$this->restapi->error($upload->result);
				}

				$filename 				= $upload->result->file_name;

				$option['origin']		= content_dir('images/lg/posts/'.$filename);
				$option['filename']		= $filename;

				// RESIZE TO MEDIUM
				$option['size']			= 500;
				$option['path']			= content_dir('images/md/posts/');
				$this->upfiles->resize($option);

				// RESIZE TO SMALL
				$option['size']			= 250;
				$option['path']			= content_dir('images/sm/posts/');
				$this->upfiles->resize($option);

				// RESIZE TO MINI
				$option['size']			= 100;
				$option['path']			= content_dir('images/xs/posts/');
				$this->upfiles->resize($option);
				
				$post->image 			= $filename;
			}
			
			if(!$post->save()){
				$this->restapi->error("sorry something wrong please try again");
			}

			foreach ($tags as $result) {
				$data_tag 				= new PostDataTagsModel;
				$data_tag->id_post 		= $post->id;
				$data_tag->id_tag 		= $result->id;
				$data_tag->save();
			}

			$this->validation->setSuccess("new data has been created");
			$this->restapi->success("/superuser/post");
		}
		else if($page=="update" && $id!=null){

			$post 					= PostModel::find($id);

			if(!$post){
				$this->rootdata->show_404();
			}

			$data['__MENU'] 		= 'post_content';
			$data['type'] 			= 'update';
			$data['urlaction']		= '/superuser/post/updated';
			$data['text_content'] 	= 'Update Your Post';
			$data['posttags'] 		= [];
			$data['post'] 			= $post;

			foreach ($post->tags as $result) {
				$data['posttags'][] = $result->id_tag;
			}

			$data['category'] 		= PostCategoryModel::asc('name')->get();
			$data['tags'] 			= PostTagsModel::asc('name')->get();

			echo $this->blade->draw('admin.post.content',$data);
			return;
		}
		else if($page=="updated"){

			$this->validation->ajaxRequest();

			$rules = [
					    'required' 	=> [
					        ['id'],['name'],['category']
					    ]
					  ];

			$validate 	= $this->validation->check($rules,'post');

			if(!$validate->correct){
				$this->restapi->error($validate->data);
			}

			$post 						= PostModel::find($this->input->post('id'));

			if(!$post){
				$this->restapi->error("post not found!");
			}

			$category 					= PostCategoryModel::find($this->input->post('category'));

			if(!$category){
				$this->restapi->error("category post not found!");
			}

			if($this->input->post('tags')){
				$tags 					= PostTagsModel::whereIn('id',$this->input->post('tags'))->get();
			}else{
				$tags 					= [];	
			}

			$post->id_category 			= $category->id;
			$post->name 				= $this->input->post('name');
			$post->description 			= $this->input->post('description');
			$post->status 				= ($this->input->post('status')) ? '0' : '1';
			
			if(!empty($_FILES['image']['name'])){

				$filename 				= 'POST '.limit_string($this->input->post('name')).' ('.date('Ymdhis').')';
				$upload 				= $this->upfiles->uploadImage(content_dir('images/lg/posts'),'image',$filename);

				if(!$upload->status){
					$this->restapi->error($upload->result);
				}

				$filename 				= $upload->result->file_name;

				$option['origin']		= content_dir('images/lg/posts/'.$filename);
				$option['filename']		= $filename;

				// RESIZE TO MEDIUM
				$option['size']			= 500;
				$option['path']			= content_dir('images/md/posts/');
				$this->upfiles->resize($option);

				// RESIZE TO SMALL
				$option['size']			= 250;
				$option['path']			= content_dir('images/sm/posts/');
				$this->upfiles->resize($option);

				// RESIZE TO MINI
				$option['size']			= 100;
				$option['path']			= content_dir('images/xs/posts/');
				$this->upfiles->resize($option);
				
				if($post->image!=""){
					remFile(content_dir('images/lg/posts/'.$post->image));
					remFile(content_dir('images/md/posts/'.$post->image));
					remFile(content_dir('images/sm/posts/'.$post->image));
					remFile(content_dir('images/xs/posts/'.$post->image));
				}

				$post->image 			= $filename;
			}
			
			if(!$post->save()){
				$this->restapi->error("sorry something wrong please try again");
			}

			PostDataTagsModel::where('id_post',$post->id)->delete();

			foreach ($tags as $result) {
				$data_tag 				= new PostDataTagsModel;
				$data_tag->id_post 		= $post->id;
				$data_tag->id_tag 		= $result->id;
				$data_tag->save();
			}

			$this->validation->setSuccess("data has been updated");
			$this->restapi->success("/superuser/post");
		}
		else if($page=="bulkaction"){

			$rules = [
					    'required' 	=> [
					        ['action'],['data']
					    ]
					  ];

			$validate 	= $this->validation->check($rules,'post');

			if(!$validate->correct){
				if($this->input->is_ajax_request()){
					$this->restapi->error($validate->data);
				}else{
					$this->rootdata->show_404();
				}
			}

			$action 	= $this->input->post('action');
			$post 		= PostModel::whereIn('id',$this->input->post('data'))->get();

			if(count($post)<=0){
				if($this->input->is_ajax_request()){
					$this->restapi->error("no data selected");
					return;
				}else{
					$this->rootdata->show_404();
				}
			}

			switch ($action) {
				case 'publish':
					PostModel::whereIn('id',$this->input->post('data'))->update(['status'=>0]);
					if(!$this->input->is_ajax_request()){

						$this->validation->setSuccess('changed to publish');	
						redirect('superuser/post');

					}else{

						$this->restapi->success("Changed to publish");
						return;

					}
					break;
				case 'draft':
					PostModel::whereIn('id',$this->input->post('data'))->update(['status'=>1]);
					if(!$this->input->is_ajax_request()){

						$this->validation->setSuccess('changed to draft');	
						redirect('superuser/post');

					}else{

						$this->restapi->success("Changed to draft");
						return;
						
					}
					break;
				case 'delete':
					$post 	= PostModel::whereIn('id',$this->input->post('data'))->get();
					foreach ($post as $result) {
						if($result->image!=""){
							remFile(content_dir('images/lg/posts/'.$result->image));
							remFile(content_dir('images/md/posts/'.$result->image));
							remFile(content_dir('images/sm/posts/'.$result->image));
							remFile(content_dir('images/xs/posts/'.$result->image));
						}
					}

					PostModel::whereIn('id',$this->input->post('data'))->delete();
					$this->validation->setSuccess('data deleted');	

					if(!$this->input->is_ajax_request()){
						redirect('superuser/post');
					}else{
						$this->restapi->success("data deleted");
					}

					break;
				default:
					$this->rootdata->show_404();
					break;
			}
		}
		else if($page=="delete" && $id!=null){

			$post 					= PostModel::find($id);

			if(!$post){
				$this->rootdata->show_404();
			}

			if($post->image!=""){
				remFile(content_dir('images/lg/posts/'.$post->image));
				remFile(content_dir('images/md/posts/'.$post->image));
				remFile(content_dir('images/sm/posts/'.$post->image));
				remFile(content_dir('images/xs/posts/'.$post->image));
			}

			$post->delete();

			$this->validation->setSuccess('data has been deleted');
			redirect('superuser/post');

		}
		else{
			$this->rootdata->show_404();
		}

	}

	public function postcategory($page="index",$id=null){
		$this->middleware->rootAccess('post',true);

		$data['__MENU'] 	= 'post_category';

		if($page=="index"){
			$data['category'] 	= PostCategoryModel::desc()->get();
			echo $this->blade->draw('admin.postcategory.index',$data);
			return;

		}
		else if($page=="create"){
			$data['__MENU'] 		= 'post_category_content';
			$data['type'] 			= 'create';
			$data['urlaction']		= '/superuser/postcategory/created';
			$data['text_content'] 	= 'Create New Post Category';

			echo $this->blade->draw('admin.postcategory.content',$data);
			return;

		}
		else if($page=="created"){
			$this->validation->ajaxRequest('root');

			$rules = [
					    'required' 	=> [
					        ['name']
					    ]
					  ];

			$validate 	= $this->validation->check($rules,'post');

			if(!$validate->correct){
				$this->restapi->error($validate->data);
			}

			$category 					= new PostCategoryModel;
			$category->name 			= $this->input->post('name');
			$category->description 		= $this->input->post('description');
			
			if(!$category->save()){
				$this->restapi->error("sorry something wrong please try again");
			}

			$this->validation->setSuccess("new data has been created");
			$this->restapi->success("/superuser/postcategory");
		}
		else if($page=="update" && $id!=null){

			$category 				= PostCategoryModel::find($id);

			if(!$category){
				$this->rootdata->show_404();
			}

			$data['__MENU'] 		= 'post_category_content';
			$data['type'] 			= 'update';
			$data['urlaction']		= '/superuser/postcategory/updated';
			$data['text_content'] 	= 'Update Your Post Category';
			$data['category'] 		= $category;

			echo $this->blade->draw('admin.postcategory.content',$data);
			return;
		}
		else if($page=="updated"){

			$this->validation->ajaxRequest('root');

			$rules = [
					    'required' 	=> [
					        ['id'],['name']
					    ]
					  ];

			$validate 	= $this->validation->check($rules,'post');

			if(!$validate->correct){
				$this->restapi->error($validate->data);
				return;
			}

			$category 						= PostCategoryModel::find($this->input->post('id'));

			if(!$category){
				$this->restapi->error("post category not found!");
			}

			$category->name 				= $this->input->post('name');
			$category->description 			= $this->input->post('description');
			
			if(!$category->save()){
				$this->restapi->error("sorry something wrong please try again");
			}

			$this->validation->setSuccess("data has been updated");
			$this->restapi->success("/superuser/postcategory");
		}
		else if($page=="bulkaction"){

			$rules = [
					    'required' 	=> [
					        ['action'],['data']
					    ]
					  ];

			$validate 	= $this->validation->check($rules,'post');

			if(!$validate->correct){
				if($this->input->is_ajax_request()){
					$this->restapi->error($validate->data);
				}else{
					$this->rootdata->show_404();
				}
				return;
			}

			$action 	= $this->input->post('action');
			$category 	= PostCategoryModel::whereIn('id',$this->input->post('data'))->get();

			if(count($category)<=0){
				if($this->input->is_ajax_request()){
					$this->restapi->error("no data selected");
				}else{
					$this->rootdata->show_404();
				}
			}

			switch ($action) {
				case 'delete':
					$category 	= PostCategoryModel::whereIn('id',$this->input->post('data'))->get();

					foreach ($category as $value) {
						foreach ($value->posts as $result) {
							if($result->image!=""){
								remFile(content_dir('images/lg/posts/'.$result->image));
								remFile(content_dir('images/md/posts/'.$result->image));
								remFile(content_dir('images/sm/posts/'.$result->image));
								remFile(content_dir('images/xs/posts/'.$result->image));
							}
						}
					}

					PostCategoryModel::whereIn('id',$this->input->post('data'))->delete();

					$this->validation->setSuccess("data has been deleted");

					if(!$this->input->is_ajax_request()){
						redirect('superuser/postcategory');

					}else{
						$this->restapi->success("data deleted");
					}
					break;
				default:
					$this->rootdata->show_404();
					break;
			}
		}
		else if($page=="delete" && $id!=null){

			$category 					= PostCategoryModel::find($id);

			if(!$category){
				$this->rootdata->show_404();	
			}

			foreach ($category->posts as $result) {
				if($result->image!=""){
					remFile(content_dir('images/lg/posts/'.$result->image));
					remFile(content_dir('images/md/posts/'.$result->image));
					remFile(content_dir('images/sm/posts/'.$result->image));
					remFile(content_dir('images/xs/posts/'.$result->image));
				}
			}

			$category->delete();
			$this->validation->setSuccess('data has been deleted');
			redirect('superuser/postcategory');

		}
		else{
			$this->rootdata->show_404();
		}

	}

	public function posttags($page="index",$id=null){
		$this->middleware->rootAccess('post',true);

		$data['__MENU'] 	= 'post_tag';

		if($page=="index"){
			$data['tag'] 	= PostTagsModel::desc()->get();
			echo $this->blade->draw('admin.posttags.index',$data);
			return;

		}
		else if($page=="create"){
			$data['__MENU'] 		= 'post_tag_content';
			$data['type'] 			= 'create';
			$data['urlaction']		= '/superuser/posttags/created';
			$data['text_content'] 	= 'Create New Post Tag';

			echo $this->blade->draw('admin.posttags.content',$data);
			return;

		}
		else if($page=="created"){
			$this->validation->ajaxRequest('root');

			$rules = [
					    'required' 	=> [
					        ['name']
					    ]
					  ];

			$validate 	= $this->validation->check($rules,'post');

			if(!$validate->correct){
				$this->restapi->error($validate->data);
			}

			$tag 				= new PostTagsModel;
			$tag->name 			= $this->input->post('name');
			
			if(!$tag->save()){
				$this->restapi->error("sorry something wrong please try again");
			}

			$this->validation->setSuccess("new data has been created");
			$this->restapi->success("/superuser/posttags");
		}
		else if($page=="update" && $id!=null){

			$tag 				= PostTagsModel::find($id);

			if(!$tag){
				$this->rootdata->show_404();
			}

			$data['__MENU'] 		= 'post_tag_content';
			$data['type'] 			= 'update';
			$data['urlaction']		= '/superuser/posttags/updated';
			$data['text_content'] 	= 'Update Your Post Category';
			$data['tag'] 			= $tag;

			echo $this->blade->draw('admin.posttags.content',$data);
			return;
		}
		else if($page=="updated"){

			$this->validation->ajaxRequest('root');

			$rules = [
					    'required' 	=> [
					        ['id'],['name']
					    ]
					  ];

			$validate 	= $this->validation->check($rules,'post');

			if(!$validate->correct){
				$this->restapi->error($validate->data);
				return;
			}

			$tag 						= PostTagsModel::find($this->input->post('id'));

			if(!$tag){
				$this->restapi->error("tag not found!");
			}

			$tag->name 				= $this->input->post('name');
			
			if(!$tag->save()){
				$this->restapi->error("sorry something wrong please try again");
			}

			$this->validation->setSuccess("new data has been created");
			$this->restapi->success("/superuser/posttags");
		}
		else if($page=="bulkaction"){

			$rules = [
					    'required' 	=> [
					        ['action'],['data']
					    ]
					  ];

			$validate 	= $this->validation->check($rules,'post');

			if(!$validate->correct){
				if($this->input->is_ajax_request()){
					$this->restapi->error($validate->data);
				}else{
					$this->rootdata->show_404();
				}
			}

			$action 	= $this->input->post('action');
			$tag 		= PostTagsModel::whereIn('id',$this->input->post('data'))->get();

			if(count($tag)<=0){
				if($this->input->is_ajax_request()){
					$this->restapi->error("no data selected");
				}else{
					$this->rootdata->show_404();
				}
			}

			switch ($action) {
				case 'delete':
					$tag 	= PostTagsModel::whereIn('id',$this->input->post('data'))->get();

					foreach ($tag as $value) {
						foreach ($value->data as $result) {
							if($result->post->image!=""){
								remFile(content_dir('images/lg/posts/'.$result->post->image));
								remFile(content_dir('images/md/posts/'.$result->post->image));
								remFile(content_dir('images/sm/posts/'.$result->post->image));
								remFile(content_dir('images/xs/posts/'.$result->post->image));
							}
						}
					}

					PostTagsModel::whereIn('id',$this->input->post('data'))->delete();
					$this->validation->setSuccess("data has been deleted!");
					if(!$this->input->is_ajax_request()){
						redirect('superuser/posttags');
					}else{
						$this->restapi->success("data deleted");
					}
					break;
				default:
					$this->rootdata->show_404();
					break;
			}
		}
		else if($page=="delete" && $id!=null){

			$tag 					= PostTagsModel::find($id);

			if(!$tag){
				$this->rootdata->show_404();	
			}

			foreach ($tag->data as $result) {
				if($result->post->image!=""){
					remFile(content_dir('images/lg/posts/'.$result->post->image));
					remFile(content_dir('images/md/posts/'.$result->post->image));
					remFile(content_dir('images/sm/posts/'.$result->post->image));
					remFile(content_dir('images/xs/posts/'.$result->post->image));
				}
			}
			
			$tag->delete();

			$this->validation->setSuccess('data has been deleted');
			redirect('superuser/posttags');
		}
		else{
			$this->rootdata->show_404();
		}

	}
// ------------------------------------------------------ POST END

// ------------------------------------------------------ LOGO ICON START
	public function logoicon($page="index",$id=null){
		$this->middleware->rootAccess('logoicon',true);

		$data['__MENU'] 	= 'logoicon';

		if($page=="index"){
			$config 		= ConfigModel::first();
			$data['image'] 	= json_image_limitless([$config->logo_dir]);
			$data['image_2'] 	= json_image_limitless([$config->logowhite_dir]);
			echo $this->blade->draw('admin.logoicon.index',$data);
			return;
		}
		else if($page=="save"){
			$this->validation->ajaxRequest('root');

			$config 					= ConfigModel::first();

			if(!empty($_FILES['icon']['name'])){

				$filename 				= 'ICON '.limit_string($config->name).' ('.date('Ymdhis').')';
				$upload 				= $this->upfiles->uploadImage(content_dir('images/lg/icon'),'icon',$filename);

				if(!$upload->status){
					$this->restapi->error($upload->result);
				}

				$filename 				= $upload->result->file_name;

				$option['origin']		= content_dir('images/lg/icon/'.$filename);
				$option['filename']		= $filename;

				// RESIZE TO MEDIUM
				$option['size']			= 150;
				$option['path']			= content_dir('images/md/icon/');
				$this->upfiles->resize($option);

				// RESIZE TO SMALL
				$option['size']			= 32;
				$option['path']			= content_dir('images/sm/icon/');
				$this->upfiles->resize($option);

				// RESIZE TO MINI
				$option['size']			= 16;
				$option['path']			= content_dir('images/xs/icon/');
				$this->upfiles->resize($option);

				if($config->icon!=""){
					remFile(content_dir('images/lg/icon/'.$config->icon));
					remFile(content_dir('images/md/icon/'.$config->icon));
					remFile(content_dir('images/sm/icon/'.$config->icon));
					remFile(content_dir('images/xs/icon/'.$config->icon));
				}
				
				$config->icon 	= $filename;
			}

			if(!empty($_FILES['logo']['name'])){

				$filename 				= 'LOGO '.limit_string($config->name).' ('.date('Ymdhis').')';
				$upload 				= $this->upfiles->uploadImage(content_dir('images/lg/logo/'),'logo',$filename);

				if(!$upload->status){
					$this->restapi->error($upload->result);
				}

				$filename 				= $upload->result->file_name;

				$option['origin']		= content_dir('images/lg/logo/'.$filename);
				$option['filename']		= $filename;

				// RESIZE TO MEDIUM
				$option['size']			= 250;
				$option['path']			= content_dir('images/md/logo/');
				$this->upfiles->resize($option);

				// RESIZE TO SMALL
				$option['size']			= 120;
				$option['path']			= content_dir('images/sm/logo/');
				$this->upfiles->resize($option);

				// RESIZE TO MINI
				$option['size']			= 80;
				$option['path']			= content_dir('images/xs/logo/');
				$this->upfiles->resize($option);

				if($config->logo!=""){
					remFile(content_dir('images/lg/logo/'.$config->logo));
					remFile(content_dir('images/md/logo/'.$config->logo));
					remFile(content_dir('images/sm/logo/'.$config->logo));
					remFile(content_dir('images/xs/logo/'.$config->logo));
				}
				
				$config->logo 		= $filename;
			}

			if(!empty($_FILES['logo_white']['name'])){

				$filename 				= 'LOGO WHITE '.limit_string($config->name).' ('.date('Ymdhis').')';
				$upload 				= $this->upfiles->uploadImage(content_dir('images/lg/logo/'),'logo_white',$filename);

				if(!$upload->status){
					$this->restapi->error($upload->result);
				}

				$filename 				= $upload->result->file_name;

				$option['origin']		= content_dir('images/lg/logo/'.$filename);
				$option['filename']		= $filename;

				// RESIZE TO MEDIUM
				$option['size']			= 250;
				$option['path']			= content_dir('images/md/logo/');
				$this->upfiles->resize($option);

				// RESIZE TO SMALL
				$option['size']			= 120;
				$option['path']			= content_dir('images/sm/logo/');
				$this->upfiles->resize($option);

				// RESIZE TO MINI
				$option['size']			= 80;
				$option['path']			= content_dir('images/xs/logo/');
				$this->upfiles->resize($option);

				if($config->logo_white!=""){
					remFile(content_dir('images/lg/logo/'.$config->logo_white));
					remFile(content_dir('images/md/logo/'.$config->logo_white));
					remFile(content_dir('images/sm/logo/'.$config->logo_white));
					remFile(content_dir('images/xs/logo/'.$config->logo_white));
				}
				
				$config->logo_white 		= $filename;
			}

			$config->save();

			$this->validation->setSuccess("Logo dan ikon telah di perbarui");
			$this->restapi->success("/superuser/logoicon");
		}
		else{
			$this->rootdata->show_404();
		}

	}
// ------------------------------------------------------ LOGO ICON END

// ------------------------------------------------------ GALLERY START
	public function gallery($page="index",$id=null){
		$this->middleware->rootAccess('gallery',true);		

		if($page=="index"){
			$data['__MENU'] 	= 'gallery';
			$data['gallery'] 	= GalleryModel::desc()->get();
			echo $this->blade->draw('admin.gallery.index',$data);
			return;
		}
		else if($page=="create"){
			$data['__MENU'] 		= 'gallery_content';
			$data['type'] 			= 'create';
			$data['urlaction']		= '/superuser/gallery/created';
			$data['text_content'] 	= 'Create New Gallery';

			echo $this->blade->draw('admin.gallery.content',$data);
			return;

		}
		else if($page=="created"){
			$this->validation->ajaxRequest('root');

			$rules = [
					    'required' 	=> [
					        ['name'],['type']
					    ]
					  ];

			$validate 	= $this->validation->check($rules,'post');

			if(!$validate->correct){
				$this->restapi->error($validate->data);
			}

			$type 		= ['image','video'];

			if(!in_array($this->input->post('type'), $type)){
				$this->restapi->error("uknown type");
			}

			$type 		= $this->input->post('type');
			

			$gallery 					= new GalleryModel;
			$gallery->name 				= $this->input->post('name');
			$gallery->status 			= ($this->input->post('status')) ? '1' : '0';
			$gallery->type 				= $type;

			switch ($type) {
				case 'image':

					if(empty($_FILES['image']['name'])){
						$this->restapi->error("image file required");
					}

					$filename 				= 'GALLERY '.limit_string($this->input->post('name')).' ('.date('Ymdhis').')';
					$upload 				= $this->upfiles->uploadImage(content_dir('images/lg/gallery'),'image',$filename);

					if(!$upload->status){
						$this->restapi->error($upload->result);
					}

					$filename 				= $upload->result->file_name;

					$option['origin']		= content_dir('images/lg/gallery/'.$filename);
					$option['filename']		= $filename;

					// RESIZE TO MEDIUM
					$option['size']			= 500;
					$option['path']			= content_dir('images/md/gallery/');
					$this->upfiles->resize($option);

					// RESIZE TO SMALL
					$option['size']			= 250;
					$option['path']			= content_dir('images/sm/gallery/');
					$this->upfiles->resize($option);

					// RESIZE TO MINI
					$option['size']			= 100;
					$option['path']			= content_dir('images/xs/gallery/');
					$this->upfiles->resize($option);
					
					$gallery->image 			= $filename;

					break;
				case 'video':
					$rules = [
							    'required' 	=> [
							        ['video']
							    ]
							  ];

					$validate 	= $this->validation->check($rules,'post');

					if(!$validate->correct){
						$this->restapi->error($validate->data);
						return;
					}

					$gallery->video 	= $this->input->post('video');
					break;
			}
			
			if(!$gallery->save()){
				$this->restapi->error("sorry something wrong please try again");
			}

			$this->validation->setSuccess("new data has been created");
			$this->restapi->success("/superuser/gallery");

		}else if($page=="update" && $id!=null){

			$gallery 					= GalleryModel::find($id);

			if(!$gallery){
				$this->rootdata->show_404();
			}

			$data['__MENU'] 		= 'gallery_content';
			$data['type'] 			= 'update';
			$data['urlaction']		= '/superuser/gallery/updated';
			$data['text_content'] 	= 'Update Your Gallery';
			$data['gallery'] 			= $gallery;

			echo $this->blade->draw('admin.gallery.content',$data);
			return;
		}
		else if($page=="updated"){

			$this->validation->ajaxRequest('root');

			$rules = [
					    'required' 	=> [
					        ['id'],['name']
					    ]
					  ];

			$validate 	= $this->validation->check($rules,'post');

			if(!$validate->correct){
				$this->restapi->error($validate->data);
				return;
			}

			$gallery 						= GalleryModel::find($this->input->post('id'));

			if(!$gallery){
				$this->restapi->error("gallery not found!");
			}

			
			$type 		= ['image','video'];

			if(!in_array($this->input->post('type'), $type)){
				$this->restapi->error("uknown type");
			}

			$type 		= $this->input->post('type');
			
			$gallery->name 				= $this->input->post('name');
			$gallery->status 			= ($this->input->post('status')) ? '1' : '0';
			$gallery->type 				= $type;

			switch ($type) {
				case 'image':

					if($gallery->image==""){

						if(empty($_FILES['image']['name'])){
							$this->restapi->error("image file required");
						}	

					}else{
						if(!empty($_FILES['image']['name'])){
							$filename 				= 'GALLERY '.limit_string($this->input->post('name')).' ('.date('Ymdhis').')';
							$upload 				= $this->upfiles->uploadImage(content_dir('images/lg/gallery'),'image',$filename);

							if(!$upload->status){
								$this->restapi->error($upload->result);
							}

							$filename 				= $upload->result->file_name;

							$option['origin']		= content_dir('images/lg/gallery/'.$filename);
							$option['filename']		= $filename;

							// RESIZE TO MEDIUM
							$option['size']			= 500;
							$option['path']			= content_dir('images/md/gallery/');
							$this->upfiles->resize($option);

							// RESIZE TO SMALL
							$option['size']			= 250;
							$option['path']			= content_dir('images/sm/gallery/');
							$this->upfiles->resize($option);

							// RESIZE TO MINI
							$option['size']			= 100;
							$option['path']			= content_dir('images/xs/gallery/');
							$this->upfiles->resize($option);

							if($gallery->image!=""){
								remFile(content_dir('images/lg/gallery/'.$gallery->image));
								remFile(content_dir('images/md/gallery/'.$gallery->image));
								remFile(content_dir('images/sm/gallery/'.$gallery->image));
								remFile(content_dir('images/xs/gallery/'.$gallery->image));
							}
							
							$gallery->image 			= $filename;
						}

					}
					
					$gallery->video 	= null;
					
					break;
				case 'video':
					$rules = [
							    'required' 	=> [
							        ['video']
							    ]
							  ];

					$validate 	= $this->validation->check($rules,'post');

					if(!$validate->correct){
						$this->restapi->error($validate->data);
					}

					if($gallery->image!=""){
						remFile(content_dir('images/lg/gallery/'.$gallery->image));
						remFile(content_dir('images/md/gallery/'.$gallery->image));
						remFile(content_dir('images/sm/gallery/'.$gallery->image));
						remFile(content_dir('images/xs/gallery/'.$gallery->image));
					}

					$gallery->image 	= null;

					$gallery->video 	= $this->input->post('video');
					break;
			}
			
			if(!$gallery->save()){
				$this->restapi->error("sorry something wrong please try again");
			}

			$this->validation->setSuccess("data has been updated");
			$this->restapi->success("/superuser/gallery");
		}
		else if($page=="bulkaction"){

			$rules = [
					    'required' 	=> [
					        ['action'],['data']
					    ]
					  ];

			$validate 	= $this->validation->check($rules,'post');

			if(!$validate->correct){
				if($this->input->is_ajax_request()){
					$this->restapi->error($validate->data);
				}else{
					$this->rootdata->show_404();
				}
			}

			$action 	= $this->input->post('action');
			$gallery 	= GalleryModel::whereIn('id',$this->input->post('data'))->get();

			if(count($gallery)<=0){
				if($this->input->is_ajax_request()){
					$this->restapi->error("no data selected");
				}else{
					$this->rootdata->show_404();
				}
			}

			switch ($action) {
				case 'publish':

					GalleryModel::whereIn('id',$this->input->post('data'))->update(['status'=>0]);
					if(!$this->input->is_ajax_request()){
						$this->validation->setSuccess('changed to publish');	
						redirect('superuser/gallery');
					}else{
						$this->restapi->success("Changed to publish");
						return;

					}

					break;
				case 'draft':

					GalleryModel::whereIn('id',$this->input->post('data'))->update(['status'=>1]);
					$this->validation->setSuccess('changed to draft');
					if(!$this->input->is_ajax_request()){
						redirect('superuser/gallery');
					}else{
						$this->restapi->success("Changed to draft");
						return;
					}

					break;
				case 'delete':

					$gallery 	= GalleryModel::whereIn('id',$this->input->post('data'))->get();
					foreach ($gallery as $result) {
						if($result->image!=""){
							remFile(content_dir('images/lg/gallery/'.$result->image));
							remFile(content_dir('images/md/gallery/'.$result->image));
							remFile(content_dir('images/sm/gallery/'.$result->image));
							remFile(content_dir('images/xs/gallery/'.$result->image));
						}
					}

					GalleryModel::whereIn('id',$this->input->post('data'))->delete();
					$this->validation->setSuccess('data deleted');	
					if(!$this->input->is_ajax_request()){
						redirect('superuser/gallery');
					}else{
						$this->restapi->success("data deleted");
					}

					break;
				default:
					$this->rootdata->show_404();
					break;
			}
		}
		else if($page=="delete" && $id!=null){

			$gallery 					= GalleryModel::find($id);

			if(!$gallery){
				$this->rootdata->show_404();
			}

			if($gallery->image!=""){
				remFile(content_dir('images/lg/gallery/'.$gallery->image));
				remFile(content_dir('images/md/gallery/'.$gallery->image));
				remFile(content_dir('images/sm/gallery/'.$gallery->image));
				remFile(content_dir('images/xs/gallery/'.$gallery->image));
			}

			$gallery->delete();

			$this->validation->setSuccess('data has been deleted');
			redirect('superuser/gallery');

		}
		else{
			$this->rootdata->show_404();
		}

	}
// ------------------------------------------------------ GALLERY END

	public function about($page="index"){

		$this->middleware->rootAccess('about',true);

		if($page=="index"){

			$data['__MENU'] 	= 'about';
			$data['urlaction'] 	= '/superuser/about/save';
			echo $this->blade->draw('admin.about.index',$data);
			return;

		}else if($page=="save"){

			$this->validation->ajaxRequest('root');

			$rules = [
					    'required' 	=> [
					        ['name']
					    ]
					  ];

			$validate 	= $this->validation->check($rules,'post');

			if(!$validate->correct){
				$this->restapi->error($validate->data);
			}

			$config 			= ConfigModel::first();
			$config->name 		= $this->input->post('name');
			$config->description= $this->input->post('description');
			$config->save();
			
			$this->validation->setSuccess('data has been saved!');	
			$this->restapi->success("/superuser/about");

		}else{
			$this->rootdata->show_404();
		}
	}

	public function testimoni($page="index",$id=null){
		$this->middleware->rootAccess('testimoni',true);

		$data['__MENU'] 	= 'testimoni';

		if($page=="index"){
			$data['testimoni'] 	= TestimoniModel::desc()->get();
			echo $this->blade->draw('admin.testimoni.index',$data);
			return;

		}
		else if($page=="create"){
			$data['__MENU'] 		= 'testimoni_content';
			$data['type'] 			= 'create';
			$data['urlaction']		= '/superuser/testimoni/created';
			$data['text_content'] 	= 'Create New Testimoni';

			echo $this->blade->draw('admin.testimoni.content',$data);
			return;

		}
		else if($page=="created"){
			$this->validation->ajaxRequest('root');

			$rules = [
					    'required' 	=> [
					        ['name'],['job']
					    ]
					  ];

			$validate 	= $this->validation->check($rules,'post');

			if(!$validate->correct){
				$this->restapi->error($validate->data);
				return;
			}

			$testimoni 						= new TestimoniModel;
			$testimoni->name 				= $this->input->post('name');
			$testimoni->job 				= $this->input->post('job');
			$testimoni->description 		= $this->input->post('description');
			$testimoni->status 				= ($this->input->post('status')) ? '0' : '1';
			
			if(!empty($_FILES['image']['name'])){

				$filename 				= 'TESTIMONI '.limit_string($this->input->post('name')).' ('.date('Ymdhis').')';
				$upload 				= $this->upfiles->uploadImage(content_dir('images/lg/testimoni'),'image',$filename);

				if(!$upload->status){
					$this->restapi->error($upload->result);
				}

				$filename 				= $upload->result->file_name;

				$option['origin']		= content_dir('images/lg/testimoni/'.$filename);
				$option['filename']		= $filename;

				// RESIZE TO MEDIUM
				$option['size']			= 300;
				$option['path']			= content_dir('images/md/testimoni/');
				$this->upfiles->resize($option);

				// RESIZE TO SMALL
				$option['size']			= 150;
				$option['path']			= content_dir('images/sm/testimoni/');
				$this->upfiles->resize($option);

				// RESIZE TO MINI
				$option['size']			= 80;
				$option['path']			= content_dir('images/xs/testimoni/');
				$this->upfiles->resize($option);
				
				$testimoni->image 		= $filename;
			}
			
			if(!$testimoni->save()){
				$this->restapi->error("sorry something wrong please try again");
			}

			$this->validation->setSuccess('new data has been created');	
			$this->restapi->success("/superuser/testimoni");
			
		}
		else if($page=="update" && $id!=null){

			$testimoni 					= TestimoniModel::find($id);

			if(!$testimoni){
				$this->rootdata->show_404();
			}

			$data['__MENU'] 		= 'testimoni_content';
			$data['type'] 			= 'update';
			$data['urlaction']		= '/superuser/testimoni/updated';
			$data['text_content'] 	= 'Update Your Testimoni';
			$data['testimoni'] 		= $testimoni;

			echo $this->blade->draw('admin.testimoni.content',$data);
			return;
		}
		else if($page=="updated"){

			$this->validation->ajaxRequest('root');

			$rules = [
					    'required' 	=> [
					        ['id'],['name'],['job']
					    ]
					  ];

			$validate 	= $this->validation->check($rules,'post');

			if(!$validate->correct){
				$this->restapi->error($validate->data);
				return;
			}

			$testimoni 						= TestimoniModel::find($this->input->post('id'));

			if(!$testimoni){
				$this->restapi->error("testimoni not found!");
				return;
			}

			$testimoni->name 				= $this->input->post('name');
			$testimoni->job 				= $this->input->post('job');
			$testimoni->description 		= $this->input->post('description');
			$testimoni->status 				= ($this->input->post('status')) ? '1' : '0';
			
			if(!empty($_FILES['image']['name'])){

				$filename 				= 'TESTIMONI '.limit_string($this->input->post('name')).' ('.date('Ymdhis').')';
				$upload 				= $this->upfiles->uploadImage(content_dir('images/lg/testimoni'),'image',$filename);

				if(!$upload->status){
					$this->restapi->error($upload->result);
					return;
				}

				$filename 				= $upload->result->file_name;

				$option['origin']		= content_dir('images/lg/testimoni/'.$filename);
				$option['filename']		= $filename;

				// RESIZE TO MEDIUM
				$option['size']			= 300;
				$option['path']			= content_dir('images/md/testimoni/');
				$this->upfiles->resize($option);

				// RESIZE TO SMALL
				$option['size']			= 150;
				$option['path']			= content_dir('images/sm/testimoni/');
				$this->upfiles->resize($option);

				// RESIZE TO MINI
				$option['size']			= 80;
				$option['path']			= content_dir('images/xs/testimoni/');
				$this->upfiles->resize($option);

				if($testimoni->image!=""){
					remFile(content_dir('images/lg/testimoni/'.$testimoni->image));
					remFile(content_dir('images/md/testimoni/'.$testimoni->image));
					remFile(content_dir('images/sm/testimoni/'.$testimoni->image));
					remFile(content_dir('images/xs/testimoni/'.$testimoni->image));
				}

				$testimoni->image 			= $filename;
			}
				
			$testimoni->save();
			$this->restapi->success("data has been updated");
			return;
		}
		else if($page=="bulkaction"){

			$rules = [
					    'required' 	=> [
					        ['action'],['data']
					    ]
					  ];

			$validate 	= $this->validation->check($rules,'post');

			if(!$validate->correct){
				if($this->input->is_ajax_request()){
					$this->restapi->error($validate->data);
				}else{
					$this->rootdata->show_404();
				}
				return;
			}

			$action 	= $this->input->post('action');
			$testimoni 	= TestimoniModel::whereIn('id',$this->input->post('data'))->get();

			if(count($testimoni)<=0){
				if($this->input->is_ajax_request()){
					$this->restapi->error("no data selected");
					return;
				}else{
					$this->rootdata->show_404();
				}
			}

			switch ($action) {
				case 'publish':
					TestimoniModel::whereIn('id',$this->input->post('data'))->update(['status'=>0]);
					if(!$this->input->is_ajax_request()){

						$this->validation->setSuccess('changed to publish');	
						redirect('superuser/testimoni');

					}else{

						$this->restapi->success("Changed to publish");
						return;

					}
					break;
				case 'draft':
					TestimoniModel::whereIn('id',$this->input->post('data'))->update(['status'=>1]);
					if(!$this->input->is_ajax_request()){

						$this->validation->setSuccess('changed to draft');	
						redirect('superuser/testimoni');

					}else{

						$this->restapi->success("Changed to draft");
						return;
						
					}
					break;
				case 'delete':
					$testimoni 	= TestimoniModel::whereIn('id',$this->input->post('data'))->get();
					foreach ($testimoni as $result) {
						if($result->image!=""){
							remFile(content_dir('images/lg/testimoni/'.$result->image));
							remFile(content_dir('images/md/testimoni/'.$result->image));
							remFile(content_dir('images/sm/testimoni/'.$result->image));
							remFile(content_dir('images/xs/testimoni/'.$result->image));
						}
					}

					TestimoniModel::whereIn('id',$this->input->post('data'))->delete();
					if(!$this->input->is_ajax_request()){
						$this->validation->setSuccess('data deleted');	
						redirect('superuser/testimoni');

					}else{

						$this->restapi->success("data deleted");
						return;
						
					}
					break;
				default:
					$this->rootdata->show_404();
					break;
			}
		}
		else if($page=="delete" && $id!=null){

			$testimoni 					= TestimoniModel::find($id);

			if(!$testimoni){
				$this->rootdata->show_404();
			}

			if($testimoni->image!=""){
				remFile(content_dir('images/lg/testimoni/'.$testimoni->image));
				remFile(content_dir('images/md/testimoni/'.$testimoni->image));
				remFile(content_dir('images/sm/testimoni/'.$testimoni->image));
				remFile(content_dir('images/xs/testimoni/'.$testimoni->image));
			}

			$testimoni->delete();

			$this->validation->setSuccess('data has been deleted');
			redirect('superuser/testimoni');

		}
		else{
			$this->rootdata->show_404();
		}

	}

	public function partnership($page="index",$id=null){
		$this->middleware->rootAccess('partnership',true);

		$data['__MENU'] 	= 'partnership';

		if($page=="index"){
			$data['partnership'] 	= PartnershipModel::desc()->get();
			echo $this->blade->draw('admin.partnership.index',$data);
			return;

		}
		else if($page=="create"){

			$data['__MENU'] 		= 'partnership_content';
			$data['type'] 			= 'create';
			$data['urlaction']		= '/superuser/partnership/created';
			$data['text_content'] 	= 'Create New Partnership';

			echo $this->blade->draw('admin.partnership.content',$data);
			return;

		}
		else if($page=="created"){
			$this->validation->ajaxRequest('root');

			$rules = [
					    'required' 	=> [
					        ['name'],['url']
					    ]
					  ];

			$validate 	= $this->validation->check($rules,'post');

			if(!$validate->correct){
				$this->restapi->error($validate->data);
				return;
			}

			if(empty($_FILES['image']['name'])){
				$this->restapi->error('No Image Selected');
				return;
			}

			$partnership 					= new PartnershipModel;
			$partnership->url 				= $this->input->post('url');
			$partnership->name 				= $this->input->post('name');
			$partnership->status 			= ($this->input->post('status')) ? '1' : '0';

			$filename 				= 'PARTNERSHIP '.limit_string($this->input->post('name')).' ('.date('Ymdhis').')';
			$upload 				= $this->upfiles->uploadImage(content_dir('images/lg/partnerships'),'image',$filename);

			if(!$upload->status){
				$this->restapi->error($upload->result);
				return;
			}

			$filename 				= $upload->result->file_name;

			$option['origin']		= content_dir('images/lg/partnerships/'.$filename);
			$option['filename']		= $filename;

			// RESIZE TO MEDIUM
			$option['size']			= 300;
			$option['path']			= content_dir('images/md/partnerships/');
			$this->upfiles->resize($option);

			// RESIZE TO SMALL
			$option['size']			= 150;
			$option['path']			= content_dir('images/sm/partnerships/');
			$this->upfiles->resize($option);

			// RESIZE TO MINI
			$option['size']			= 80;
			$option['path']			= content_dir('images/xs/partnerships/');
			$this->upfiles->resize($option);
			
			$partnership->image 			= $filename;
			
			if(!$partnership->save()){
				$this->restapi->error("sorry something wrong please try again");
				return;
			}

			$this->restapi->success("new data has been created");
			return;
		}
		else if($page=="update" && $id!=null){

			$partnership 					= PartnershipModel::find($id);

			if(!$partnership){
				$this->rootdata->show_404();
			}

			$data['__MENU'] 		= 'partnership_content';
			$data['type'] 			= 'update';
			$data['urlaction']		= '/superuser/partnership/updated';
			$data['text_content'] 	= 'Update Your Partnership';
			$data['partnership'] 	= $partnership;

			echo $this->blade->draw('admin.partnership.content',$data);
			return;
		}
		else if($page=="updated"){

			$this->validation->ajaxRequest('root');

			$rules = [
					    'required' 	=> [
					        ['id'],['name']
					    ]
					  ];

			$validate 	= $this->validation->check($rules,'post');

			if(!$validate->correct){
				$this->restapi->error($validate->data);
				return;
			}

			$partnership 					= PartnershipModel::find($this->input->post('id'));

			if(!$partnership){
				$this->restapi->error("partnership not found!");
				return;
			}

			$partnership->url 				= $this->input->post('url');
			$partnership->name 				= $this->input->post('name');
			$partnership->status 			= ($this->input->post('status')) ? '1' : '0';
			
			if(!empty($_FILES['image']['name'])){

				$filename 				= 'PARTNERSHIP '.limit_string($this->input->post('name')).' ('.date('Ymdhis').')';
				$upload 				= $this->upfiles->uploadImage(content_dir('images/lg/partnerships'),'image',$filename);

				if(!$upload->status){
					$this->restapi->error($upload->result);
					return;
				}

				$filename 				= $upload->result->file_name;

				$option['origin']		= content_dir('images/lg/partnerships/'.$filename);
				$option['filename']		= $filename;

				// RESIZE TO MEDIUM
				$option['size']			= 300;
				$option['path']			= content_dir('images/md/partnerships/');
				$this->upfiles->resize($option);

				// RESIZE TO SMALL
				$option['size']			= 150;
				$option['path']			= content_dir('images/sm/partnerships/');
				$this->upfiles->resize($option);

				// RESIZE TO MINI
				$option['size']			= 80;
				$option['path']			= content_dir('images/xs/partnerships/');
				$this->upfiles->resize($option);

				if($partnership->image!=""){
					remFile(content_dir('images/lg/partnerships/'.$partnership->image));
					remFile(content_dir('images/md/partnerships/'.$partnership->image));
					remFile(content_dir('images/sm/partnerships/'.$partnership->image));
					remFile(content_dir('images/xs/partnerships/'.$partnership->image));
				}

				$partnership->image 			= $filename;
			}
				
			$partnership->save();
			$this->restapi->success("data has been updated");
			return;
		}
		else if($page=="bulkaction"){

			$rules = [
					    'required' 	=> [
					        ['action'],['data']
					    ]
					  ];

			$validate 	= $this->validation->check($rules,'post');

			if(!$validate->correct){
				if($this->input->is_ajax_request()){
					$this->restapi->error($validate->data);
				}else{
					$this->rootdata->show_404();
				}
				return;
			}

			$action 		= $this->input->post('action');
			$partnership 	= PartnershipModel::whereIn('id',$this->input->post('data'))->get();

			if(count($partnership)<=0){
				if($this->input->is_ajax_request()){
					$this->restapi->error("no data selected");
					return;
				}else{
					$this->rootdata->show_404();
				}
			}

			switch ($action) {
				case 'publish':
					PartnershipModel::whereIn('id',$this->input->post('data'))->update(['status'=>0]);


					if(!$this->input->is_ajax_request()){

						$this->validation->setSuccess('changed to publish');	
						redirect('superuser/partnership');

					}else{

						$this->restapi->success("Changed to publish");
						return;

					}
					break;
				case 'draft':
					PartnershipModel::whereIn('id',$this->input->post('data'))->update(['status'=>1]);
					if(!$this->input->is_ajax_request()){

						$this->validation->setSuccess('changed to draft');	
						redirect('superuser/partnership');

					}else{

						$this->restapi->success("Changed to draft");
						return;
						
					}
					break;
				case 'delete':
					$partnership 	= PartnershipModel::whereIn('id',$this->input->post('data'))->get();

					foreach ($partnership as $result) {
						if($result->image!=""){
							remFile(content_dir('images/lg/partnerships/'.$result->image));
							remFile(content_dir('images/md/partnerships/'.$result->image));
							remFile(content_dir('images/sm/partnerships/'.$result->image));
							remFile(content_dir('images/xs/partnerships/'.$result->image));
						}
					}

					PartnershipModel::whereIn('id',$this->input->post('data'))->delete();

					if(!$this->input->is_ajax_request()){
						$this->validation->setSuccess('data deleted');	
						redirect('superuser/partnership');

					}else{

						$this->restapi->success("data deleted");
						return;
						
					}
					break;
				default:
					$this->rootdata->show_404();
					break;
			}
		}
		else if($page=="delete" && $id!=null){

			$partnership 					= PartnershipModel::find($id);

			if(!$partnership){
				$this->rootdata->show_404();
			}

			if($partnership->image!=""){
				remFile(content_dir('images/lg/partnerships/'.$partnership->image));
				remFile(content_dir('images/md/partnerships/'.$partnership->image));
				remFile(content_dir('images/sm/partnerships/'.$partnership->image));
				remFile(content_dir('images/xs/partnerships/'.$partnership->image));
			}

			$partnership->delete();

			$this->validation->setSuccess('data has been deleted');
			redirect('superuser/partnership');

		}
		else{
			$this->rootdata->show_404();
		}

	}

	public function slider($page="index",$id=null){
		$this->middleware->rootAccess('slider',true);

		$data['__MENU'] 	= 'slider';

		if($page=="index"){
			$data['slider'] 	= SliderModel::desc()->get();
			echo $this->blade->draw('admin.slider.index',$data);
			return;

		}
		else if($page=="create"){

			$data['__MENU'] 		= 'slider_content';
			$data['type'] 			= 'create';
			$data['urlaction']		= '/superuser/slider/created';
			$data['text_content'] 	= 'Create New Slider';
			$data['image'] 			= '[]';

			echo $this->blade->draw('admin.slider.content',$data);
			return;

		}
		else if($page=="created"){
			$this->validation->ajaxRequest('root');

			$rules = [
					    'required' 	=> [
					        ['name'],['url']
					    ]
					  ];

			$validate 	= $this->validation->check($rules,'post');

			if(!$validate->correct){
				$this->restapi->error($validate->data);
				return;
			}

			if(empty($_FILES['image']['name'])){
				$this->restapi->error('No Image Selected');
				return;
			}

			$slider 					= new SliderModel;
			$slider->url 				= $this->input->post('url');
			$slider->name 				= $this->input->post('name');
			$slider->status 			= ($this->input->post('status')) ? '1' : '0';

			$filename 				= 'SLIDER '.limit_string($this->input->post('name')).' ('.date('Ymdhis').')';
			$upload 				= $this->upfiles->uploadImage(content_dir('images/lg/sliders'),'image',$filename);

			if(!$upload->status){
				$this->restapi->error($upload->result);
				return;
			}

			$filename 				= $upload->result->file_name;

			$option['origin']		= content_dir('images/lg/sliders/'.$filename);
			$option['filename']		= $filename;

			// RESIZE TO MEDIUM
			$option['size']			= 300;
			$option['path']			= content_dir('images/md/sliders/');
			$this->upfiles->resize($option);

			// RESIZE TO SMALL
			$option['size']			= 150;
			$option['path']			= content_dir('images/sm/sliders/');
			$this->upfiles->resize($option);

			// RESIZE TO MINI
			$option['size']			= 80;
			$option['path']			= content_dir('images/xs/sliders/');
			$this->upfiles->resize($option);
			
			$slider->image 			= $filename;
			
			if(!$slider->save()){
				$this->restapi->error("sorry something wrong please try again");
				return;
			}

			$this->validation->setSuccess("data slider telah di tambahkan");
			$this->restapi->success("/superuser/slider");
			return;
		}
		else if($page=="update" && $id!=null){

			$slider 					= SliderModel::find($id);

			if(!$slider){
				$this->rootdata->show_404();
			}

			$data['__MENU'] 		= 'slider_content';
			$data['type'] 			= 'update';
			$data['urlaction']		= '/superuser/slider/updated';
			$data['text_content'] 	= 'Update Your Slider';
			$data['slider'] 		= $slider;
			$data['image'] 			= json_image_limitless([$slider->image_sm_dir]);

			echo $this->blade->draw('admin.slider.content',$data);
			return;
		}
		else if($page=="updated"){

			$this->validation->ajaxRequest('root');

			$rules = [
					    'required' 	=> [
					        ['id'],['name']
					    ]
					  ];

			$validate 	= $this->validation->check($rules,'post');

			if(!$validate->correct){
				$this->restapi->error($validate->data);
				return;
			}

			$slider 					= SliderModel::find($this->input->post('id'));

			if(!$slider){
				$this->restapi->error("slider not found!");
			}

			$slider->url 				= $this->input->post('url');
			$slider->name 				= $this->input->post('name');
			$slider->status 			= ($this->input->post('status')) ? '1' : '0';
			
			if(!empty($_FILES['image']['name'])){

				$filename 				= 'SLIDER '.limit_string($this->input->post('name')).' ('.date('Ymdhis').')';
				$upload 				= $this->upfiles->uploadImage(content_dir('images/lg/sliders'),'image',$filename);

				if(!$upload->status){
					$this->restapi->error($upload->result);
				}

				$filename 				= $upload->result->file_name;

				$option['origin']		= content_dir('images/lg/sliders/'.$filename);
				$option['filename']		= $filename;

				// RESIZE TO MEDIUM
				$option['size']			= 300;
				$option['path']			= content_dir('images/md/sliders/');
				$this->upfiles->resize($option);

				// RESIZE TO SMALL
				$option['size']			= 150;
				$option['path']			= content_dir('images/sm/sliders/');
				$this->upfiles->resize($option);

				// RESIZE TO MINI
				$option['size']			= 80;
				$option['path']			= content_dir('images/xs/sliders/');
				$this->upfiles->resize($option);

				if($slider->image!=""){
					remFile(content_dir('images/lg/sliders/'.$slider->image));
					remFile(content_dir('images/md/sliders/'.$slider->image));
					remFile(content_dir('images/sm/sliders/'.$slider->image));
					remFile(content_dir('images/xs/sliders/'.$slider->image));
				}

				$slider->image 			= $filename;
			}
				
			$slider->save();
			$this->validation->setSuccess("data slider telah di perbarui");
			$this->restapi->success("/superuser/slider");
		}
		else if($page=="bulkaction"){

			$rules = [
					    'required' 	=> [
					        ['action'],['data']
					    ]
					  ];

			$validate 	= $this->validation->check($rules,'post');

			if(!$validate->correct){
				if($this->input->is_ajax_request()){
					$this->restapi->error($validate->data);
				}else{
					$this->rootdata->show_404();
				}
				return;
			}

			$action 		= $this->input->post('action');
			$slider 	= SliderModel::whereIn('id',$this->input->post('data'))->get();

			if(count($slider)<=0){
				if($this->input->is_ajax_request()){
					$this->restapi->error("no data selected");
				}else{
					$this->rootdata->show_404();
				}
			}

			switch ($action) {
				case 'publish':
					SliderModel::whereIn('id',$this->input->post('data'))->update(['status'=>0]);
					if(!$this->input->is_ajax_request()){
						$this->validation->setSuccess('changed to publish');	
						redirect('superuser/slider');

					}else{
						$this->restapi->success("Changed to publish");
					}
					break;
				case 'draft':
					SliderModel::whereIn('id',$this->input->post('data'))->update(['status'=>1]);
					if(!$this->input->is_ajax_request()){

						$this->validation->setSuccess('changed to draft');	
						redirect('superuser/slider');

					}else{

						$this->restapi->success("Changed to draft");
						return;
						
					}
					break;
				case 'delete':
					$slider 	= SliderModel::whereIn('id',$this->input->post('data'))->get();

					foreach ($slider as $result) {
						if($result->image!=""){
							remFile(content_dir('images/lg/sliders/'.$result->image));
							remFile(content_dir('images/md/sliders/'.$result->image));
							remFile(content_dir('images/sm/sliders/'.$result->image));
							remFile(content_dir('images/xs/sliders/'.$result->image));
						}
					}

					SliderModel::whereIn('id',$this->input->post('data'))->delete();

					if(!$this->input->is_ajax_request()){
						$this->validation->setSuccess('data deleted');	
						redirect('superuser/slider');

					}else{
						$this->restapi->success("data deleted");
						
					}
					break;
				default:
					$this->rootdata->show_404();
					break;
			}
		}
		else if($page=="delete" && $id!=null){

			$slider 					= SliderModel::find($id);

			if(!$slider){
				$this->rootdata->show_404();
			}

			if($slider->image!=""){
				remFile(content_dir('images/lg/sliders/'.$slider->image));
				remFile(content_dir('images/md/sliders/'.$slider->image));
				remFile(content_dir('images/sm/sliders/'.$slider->image));
				remFile(content_dir('images/xs/sliders/'.$slider->image));
			}

			$slider->delete();

			$this->validation->setSuccess('data has been deleted');
			redirect('superuser/slider');

		}
		else{
			$this->rootdata->show_404();
		}

	}

	public function account($page="index",$id=null){
		$this->middleware->rootAccess('account',true);

		$data['__MENU']			= 'account';

		if($page=="index"){

			$data['account'] 	= AccountModel::desc()->get();
			echo $this->blade->draw('admin.account.index',$data);
			return;

		}
		else if($page=="create"){

			$data['type']		= 'create';
			$data['note'] 		= 'Buat akun rekening baru';
			$data['url'] 		= '/superuser/account/created';

			echo $this->blade->draw('admin.account.content',$data);
			return;

		}
		else if($page=="update" && $id!=null){

			$account 			= AccountModel::find($id);

			if(!$account){
				$this->rootdata->show_404();	
			}

			$data['type']		= 'update';
			$data['note'] 		= 'Ubah data akun rekening';
			$data['url'] 		= '/superuser/account/updated';
			$data['account'] 	= $account;

			echo $this->blade->draw('admin.account.content',$data);
			return;

		}else if($page=="bulkaction"){

			$rules = [
				    'required' 	=> [
				        ['action'],['data']
				    ]
				  ];

			$validate 	= $this->validation->check($rules,'post');

			if(!$validate->correct){
				if($this->input->is_ajax_request()){
					$this->restapi->error($validate->data);
				}else{
					$this->rootdata->show_404();
				}
			}

			$action 		= $this->input->post('action');
			$account 		= AccountModel::whereIn('id',$this->input->post('data'))->get();

			if(count($account)<=0){
				if($this->input->is_ajax_request()){
					$this->restapi->error("no data selected");
				}else{
					$this->rootdata->show_404();
				}
			}

			switch ($action) {
				case 'publish':
					AccountModel::whereIn('id',$this->input->post('data'))->update(['status'=>1]);

					if(!$this->input->is_ajax_request()){

						$this->validation->setSuccess('changed to publish');	
						redirect('superuser/account');

					}else{

						$this->restapi->success("Changed to publish");

					}
					break;
				case 'draft':
					AccountModel::whereIn('id',$this->input->post('data'))->update(['status'=>0]);

					if(!$this->input->is_ajax_request()){
						$this->validation->setSuccess('changed to draft');	
						redirect('superuser/account');
					}else{
						$this->restapi->success("Changed to draft");
						return;
					}

					break;
				case 'delete':

					AccountModel::whereIn('id',$this->input->post('data'))->delete();

					if(!$this->input->is_ajax_request()){
						$this->validation->setSuccess('data deleted');	
						redirect('superuser/account');
					}else{
						$this->restapi->success("data deleted");
					}

					break;
				default:
					$this->rootdata->show_404();
					break;
			}

		}
		elseif ($page=="delete" && $id!=null) {

			$account 			= AccountModel::find($id);

			if(!$account){
				$this->rootdata->show_404();	
			}

			$account->delete();
			$this->validation->setSuccess('Data telah terhapus!');
			redirect('superuser/account');

		}
		else if($page=="created"){

			$this->validation->ajaxRequest('root');

			$rules = [
					    'required' 	=> [
					        ['name'],['bank'],['number']
					    ]
					  ];

			$validate 	= $this->validation->check($rules,'post');

			if(!$validate->correct){
				$this->restapi->error($validate->data);
				return;
			}

			$account 			= new AccountModel;
			$account->name 		= $this->input->post('name');
			$account->bank 		= $this->input->post('bank');
			$account->number 	= $this->input->post('number');
			$account->status 	= ($this->input->post('status')) ? 1 : 0;

			if(!$account->save()){
				$this->restapi->error("maaf ada kesalahan silahkan coba kembali");
			}

			$this->validation->setSuccess("no akun rekening telah di tambahkan");
			$this->restapi->success("/superuser/account");

		}
		else if($page=="updated"){

			$this->validation->ajaxRequest('root');

			$rules = [
					    'required' 	=> [
					        ['id'],['name'],['bank'],['number']
					    ]
					  ];

			$validate 	= $this->validation->check($rules,'post');

			if(!$validate->correct){
				$this->restapi->error($validate->data);
				return;
			}

			$account 			= AccountModel::find($this->input->post('id'));
			if(!$account){
				$this->rootdata->show_404();
			}

			$account->name 		= $this->input->post('name');
			$account->bank 		= $this->input->post('bank');
			$account->number 	= $this->input->post('number');
			$account->status 	= ($this->input->post('status')) ? 1 : 0;
			$account->save();

			$this->validation->setSuccess("no akun rekening telah di perbarui");
			$this->restapi->success("/superuser/account");
		}
		else{
			$this->rootdata->show_404();
		}

	}

	public function config($page="index"){
		$this->middleware->rootAccess('config',true);

		$data['__MENU'] 	= 'config';

		if($page=="index"){
			echo $this->blade->draw('admin.config.index');
			return;

		}else if ($page=="save"){

			$this->validation->ajaxRequest('root');

			$rules = [
					    'required' 	=> [
					        ['name'],['email']
					    ],
					    'email'		=> [
					    	['email']
					    ]
					  ];

			$validate 	= $this->validation->check($rules,'post');

			if(!$validate->correct){
				$this->restapi->error($validate->data);
				return;
			}

			$config 					= ConfigModel::first();
			$config->name 				= $this->input->post('name');
			$config->email 				= $this->input->post('email');
			$config->phone 				= $this->input->post('phone');
			$config->other_contact 		= $this->input->post('other_contact');
			$config->postalcode 		= $this->input->post('postalcode');
			$config->address 			= $this->input->post('address');
			$config->gmap_query 		= $this->input->post('gmap_query');
			$config->gmap_latlong 		= $this->input->post('gmap_latlong');
			$config->about 		 		= $this->input->post('about');

			if(!empty($_FILES['logo']['name'])){

				$filename 				= 'LOGO '.$config->name.' ('.date('Ymdhis').')';
				$upload 				= $this->upfiles->uploadImage(content_dir('images/lg/logo'),'logo',$filename);

				if(!$upload->status){
					$this->restapi->error($upload->result);
					return;
				}

				$filename 				= $upload->result->file_name;

				$option['origin']		= content_dir('images/lg/logo/'.$filename);
				$option['filename']		= $filename;

				// RESIZE TO MEDIUM
				$option['size']			= 250;
				$option['path']			= content_dir('images/md/logo/');
				$this->upfiles->resize($option);

				// RESIZE TO SMALL
				$option['size']			= 120;
				$option['path']			= content_dir('images/sm/logo/');
				$this->upfiles->resize($option);

				// RESIZE TO MINI
				$option['size']			= 80;
				$option['path']			= content_dir('images/xs/logo/');
				$this->upfiles->resize($option);

				if($config->logo!=""){
					remFile(content_dir('images/lg/logo/'.$config->logo));
					remFile(content_dir('images/md/logo/'.$config->logo));
					remFile(content_dir('images/sm/logo/'.$config->logo));
					remFile(content_dir('images/xs/logo/'.$config->logo));
				}

				$config->logo 		= $filename;
				$config->save();
			}

			if(!empty($_FILES['logo_white']['name'])){

				$filename 				= 'LOGO WHITE '.$config->name.' ('.date('Ymdhis').')';
				$upload 				= $this->upfiles->uploadImage(content_dir('images/lg/logo'),'logo_white',$filename);

				if(!$upload->status){
					$this->restapi->error($upload->result);
					return;
				}

				$filename 				= $upload->result->file_name;

				$option['origin']		= content_dir('images/lg/logo/'.$filename);
				$option['filename']		= $filename;

				// RESIZE TO MEDIUM
				$option['size']			= 250;
				$option['path']			= content_dir('images/md/logo/');
				$this->upfiles->resize($option);

				// RESIZE TO SMALL
				$option['size']			= 120;
				$option['path']			= content_dir('images/sm/logo/');
				$this->upfiles->resize($option);

				// RESIZE TO MINI
				$option['size']			= 80;
				$option['path']			= content_dir('images/xs/logo/');
				$this->upfiles->resize($option);

				if($config->logo!=""){
					remFile(content_dir('images/lg/logo/'.$config->logo_white));
					remFile(content_dir('images/md/logo/'.$config->logo_white));
					remFile(content_dir('images/sm/logo/'.$config->logo_white));
					remFile(content_dir('images/xs/logo/'.$config->logo_white));
				}

				$config->logo_white 	= $filename;
				$config->save();
			}

			if(!empty($_FILES['icon']['name'])){

				$filename 				= 'ICON  '.$config->name.' ('.date('Ymdhis').')';
				$upload 				= $this->upfiles->uploadImage(content_dir('images/lg/icon'),'icon',$filename);

				if(!$upload->status){
					$this->restapi->error($upload->result);
					return;
				}

				$filename 				= $upload->result->file_name;

				$option['origin']		= content_dir('images/lg/icon/'.$filename);
				$option['filename']		= $filename;

				// RESIZE TO MEDIUM
				$option['size']			= 100;
				$option['path']			= content_dir('images/md/icon/');
				$this->upfiles->resize($option);

				// RESIZE TO SMALL
				$option['size']			= 32;
				$option['path']			= content_dir('images/sm/icon/');
				$this->upfiles->resize($option);

				// RESIZE TO MINI
				$option['size']			= 16;
				$option['path']			= content_dir('images/xs/icon/');
				$this->upfiles->resize($option);

				if($config->icon!=""){
					remFile(content_dir('images/lg/icon/'.$config->icon));
					remFile(content_dir('images/md/icon/'.$config->icon));
					remFile(content_dir('images/sm/icon/'.$config->icon));
					remFile(content_dir('images/xs/icon/'.$config->icon));
				}

				$config->icon 			= $filename;
				$config->save();
			}

		
			$config->save();
			$this->restapi->success("pengaturan telah di perbarui");
			return;
		}else{
			$this->rootdata->show_404();
		}
	}

	public function configstore($page="index"){

		$this->middleware->rootAccess('configstore',true);

		$data['__MENU'] 	= 'configstore';
		$store 				= ConfigStoreModel::find(1);

		if($page=="index"){

			$province 			= RajaOngkir::getProvince();
			$city 				= RajaOngkir::getCity(goExplode($store->province,'-',0));
			$district 			= RajaOngkir::getDistrict(goExplode($store->city,'-',0));

			if(!$city->auth || !$province->auth || !$district->auth){
				exit("RajaOngkir Loaded Failed! , please try again");
			}

			$data['province']	= $province->msg;	
			$data['city']		= $city->msg;	
			$data['district']	= $district->msg;
			$data['courier']	= explode(',', $store->courier);
			$data['available'] 	= ['JNE','POS','TIKI','PCP','ESL','RPX',
								   'PANDU','WAHANA','SICEPAT','J&T','PAHALA',
								   'CAHAYA','SAP','JET','INDAH','DSE','NCS','STAR'];
			$data['store'] 		= $store;

			echo $this->blade->draw('admin.configstore.index',$data);
			return;

		}else if ($page=="save"){

			$this->validation->ajaxRequest();

			$rules		 		= [
									    'required' 	=> [
									        ['province'],['city'],['district'],['courier'],
									        ['tax'],['day'],['hour'],['min']
									    ],
									    'integer'	=> [
									    	['day'],['hour'],['min']
									    ]
									  ];

			$validate 	= $this->validation->check($rules,'post');

			if(!$validate->correct){
				$this->restapi->error($validate->data);
				return;
			}

			$available 			= ['JNE','POS','TIKI','PCP','ESL','RPX',
								   'PANDU','WAHANA','SICEPAT','J&T','PAHALA',
								   'CAHAYA','SAP','JET','INDAH','DSE','NCS','STAR'];

			$courier			= $this->input->post('courier');
			$courier_txt 		= "";
			foreach ($courier as $result) {
				$result 		= strtoupper($result);

				if(!in_array($result, $available)){
					$this->restapi->error("Maaf Jasa Kurir ".$result." Tidak Tersedia");
					return;
				}

				$courier_txt 	.= $result.',';
			}


			$store->courier 	= $courier_txt;
			$store->province 	= $this->input->post('province');
			$store->city 		= $this->input->post('city');
			$store->district 	= $this->input->post('district');
			$store->day 		= $this->input->post('day');
			$store->hour 		= $this->input->post('hour');
			$store->min 		= $this->input->post('min');
			$store->payment_tax = $this->input->post('tax');
			$store->save();

			$this->restapi->success("pengaturan toko telah di perbarui");
			return;
		}else{
			$this->rootdata->show_404();
		}
	}

	public function confirmation($page="index",$id=null,$nodirect=false){
		$this->middleware->rootAccess('confirmation',true);

		$data['__MENU'] 		= 'confirmation';

		if($page=="index"){

			$data['confirmation'] 	= ConfirmationModel::desc()->get();
			echo $this->blade->draw('admin.confirmation.index',$data);
			return;

		}else if($page=="detail" && $id!=null){

			$confirmation 		= ConfirmationModel::find($id);

			if(!$confirmation){
				$this->rootdata->show_404();
			}

			$confirmation->readed 	= 1;
			$confirmation->save();

			$data['confirmation']	= $confirmation;
			echo $this->blade->draw('admin.confirmation.content',$data);
			return;			

		}
		else if($page=="bulkaction"){

			if($this->input->server('REQUEST_METHOD') != 'POST'){
				$this->rootdata->show_404();
			}

			$rules = [
					    'required' 	=> [
					        ['action'],['data']
					    ]
					  ];

			$validate 	= $this->validation->check($rules,'post');

			if(!$validate->correct){
				$this->restapi->error($validate->data);
				return;
			}

			$data 			= $this->input->post('data');
			$confirmation 	= ConfirmationModel::whereIn('id',$data)->get();

			switch ($page) {
				case 'delete':

					foreach ($confirmation as $result) {
						$this->confirmation('delete',$result->id,true);
					}
					$this->validation->setSuccess('Data telah berhasil di hapus');
					redirect('superuser/confirmation');					

					break;

				default:
					$this->rootdata->show_404();
					break;
			}
		}
		else if ($page=="delete" && $id!=null){

			$confirmation 		= ConfirmationModel::find($id);

			if(!$confirmation){
				$this->rootdata->show_404();
			}

			if($confirmation->image!=""){
				remFile(content_dir('images/lg/confirmation/'.$confirmation->image));
			}

			$confirmation->delete();

			if($nodirect){
				return;
			}

			$this->validation->setSuccess('Data telah di hapus');
			redirect('superuser/confirmation');
		}
	}

	public function faq($page="index",$id=null,$nodirect=false){

		$this->middleware->rootAccess('faq',true);
		$data['__MENU'] 	= 'faq';

		if($page=="index"){

			$data['faq'] 	= FaqModel::desc()->get();
			echo $this->blade->draw('admin.faq.index',$data);
			return;

		}else if($page=="create"){
			$data['type']	= 'create';
			echo $this->blade->draw('admin.faq.content',$data);
			return;
		}
		else if($page=="created"){

			$this->validation->ajaxRequest('root');

			$rules = [
					    'required' 	=> [
					        ['name'],['category'],['subcategory'],['description']
					    ]
					  ];

			$validate 	= $this->validation->check($rules,'post');

			if(!$validate->correct){
				$this->restapi->error($validate->data);
				return;
			}

			$category 			= FaqCategoryModel::find($this->input->post('category'));

			if(!$category){
				$this->restapi->error("maaf kategori faq tidak di temukan");
				return;
			}

			$subcategory 		= FaqSubCategoryModel::where('id_category',$category->id)
									->find($this->input->post('subcategory'));

			if(!$subcategory){
				$this->restapi->error("Maaf sub kategori faq tidak di temukan");
				return;
			}

			$faq 				= new FaqModel;
			$faq->name 			= $this->input->post('name');
			$faq->id_sub 		= $subcategory->id;
			$faq->description 	= $this->input->post('description');
			$faq->status 		= $this->input->post('status');

			if(!$faq->save()){
				$this->restapi->error("maaf ada kesalahan silahkan coba kembali");
				return;
			}

			$this->restapi->success("data baru di tambahkan");
			return;
		}
		else if($page=="update" && $id!=null){

			$faq 		= FaqModel::find($id);

			if(!$faq){
				$this->rootdata->show_404();
			}

			$data['faq'] 	= $faq;
			$data['type']	= 'update';
			echo $this->blade->draw('admin.faq.content',$data);
			return;
		}
		else if($page=="updated"){
			$this->validation->ajaxRequest('root');

			$rules = [
					    'required' 	=> [
					       ['faq'],['name'],['category'],['subcategory'],['description']
					    ]
					  ];

			$validate 	= $this->validation->check($rules,'post');

			if(!$validate->correct){
				$this->restapi->error($validate->data);
				return;
			}

			$faq 				= FaqModel::find($this->input->post('faq'));

			if(!$faq){
				$this->restapi->error("maaf faq tidak di temukan");
				return;
			}

			$category 			= FaqCategoryModel::find($this->input->post('category'));

			if(!$category){
				$this->restapi->error("maaf kategori faq tidak di temukan");
				return;
			}

			$subcategory 		= FaqSubCategoryModel::where('id_category',$category->id)
									->find($this->input->post('subcategory'));

			if(!$subcategory){
				$this->restapi->error("Maaf sub kategori faq tidak di temukan");
				return;
			}

			$faq->name 			= $this->input->post('name');
			$faq->id_sub 		= $subcategory->id;
			$faq->description 	= $this->input->post('description');
			$faq->status 		= $this->input->post('status');

			if(!$faq->save()){
				$this->restapi->error("maaf ada kesalahan silahkan coba kembali");
				return;
			}

			$this->restapi->success("data telah di perbarui");
			return;
		}
		else if($page=="bulkaction"){

			if($this->input->server('REQUEST_METHOD') != 'POST'){
				$this->rootdata->show_404();
			}

			$rules = [
					    'required' 	=> [
					        ['action'],['data']
					    ]
					  ];

			$validate 	= $this->validation->check($rules,'post');

			if(!$validate->correct){
				$this->restapi->error($validate->data);
				return;
			}

			$data 			= $this->input->post('data');

			switch ($page) {
				case 'delete':

					$faq 	= FaqModel::whereIn('id',$data)->delete();
					$this->validation->setSuccess('Data telah berhasil di hapus');
					redirect('superuser/faq');					

					break;

				default:
					$this->rootdata->show_404();
					break;
			}
		}
		else if($page=="delete" && $id!=null){
			$faq 		= FaqModel::find($id);

			if(!$faq){
				$this->rootdata->show_404();
			}

			$faq->delete();
			$this->validation->setSuccess('Data telah berhasil di hapus');
			redirect('superuser/faq');
			return;
		}
	}

	public function faqcategory($page="index",$id=null,$nodirect=false){

		$this->middleware->rootAccess('faq',true);
		$data['__MENU'] 	= 'faq';

		if($page=="index"){

			$data['category'] 	= FaqCategoryModel::desc()->get();
			echo $this->blade->draw('admin.faqcateogry.index',$data);
			return;

		}else if($page=="create"){
			$data['type']	= 'create';
			echo $this->blade->draw('admin.faqcategory.content',$data);
			return;
		}
		else if($page=="created"){

			$this->validation->ajaxRequest('root');

			$rules = [
					    'required' 	=> [
					        ['name']
					    ]
					  ];

			$validate 	= $this->validation->check($rules,'post');

			if(!$validate->correct){
				$this->restapi->error($validate->data);
				return;
			}

			$category 		= new FaqCategoryModel;
			$category->name = $this->input->post('name');

			if(!$category->save()){
				$this->restapi->error("maaf ada kesalahan silahkan coba kembali");
				return;
			}

			$this->restapi->success("data baru di tambahkan");
			return;
		}
		else if($page=="update" && $id!=null){

			$category 		= FaqCategoryModel::find($id);

			if(!$category){
				$this->rootdata->show_404();
			}

			$data['category'] 	= $category;
			$data['type']		= 'update';
			echo $this->blade->draw('admin.faqcategory.content',$data);
			return;
		}
		else if($page=="updated"){
			$this->validation->ajaxRequest('root');

			$rules = [
					    'required' 	=> [
					       ['category'],['name']
					    ]
					  ];

			$validate 	= $this->validation->check($rules,'post');

			if(!$validate->correct){
				$this->restapi->error($validate->data);
				return;
			}

			$category 			= FaqCategoryModel::find($this->input->post('category'));

			if(!$category){
				$this->restapi->error("maaf faq kategori tidak di temukan");
				return;
			}

			$category->name 	= $this->input->post('name');

			if(!$category->save()){
				$this->restapi->error("maaf ada kesalahan silahkan coba kembali");
				return;
			}

			$this->restapi->success("data telah di perbarui");
			return;
		}
		else if($page=="bulkaction"){

			if($this->input->server('REQUEST_METHOD') != 'POST'){
				$this->rootdata->show_404();
			}

			$rules = [
					    'required' 	=> [
					        ['action'],['data']
					    ]
					  ];

			$validate 	= $this->validation->check($rules,'post');

			if(!$validate->correct){
				$this->restapi->error($validate->data);
				return;
			}

			$data 			= $this->input->post('data');

			switch ($page) {
				case 'delete':

					FaqCategoryModel::whereIn('id',$data)->delete();

					$this->validation->setSuccess('Data telah berhasil di hapus');
					redirect('superuser/faqcategory');		

					break;

				default:
					$this->rootdata->show_404();
					break;
			}
		}
		else if($page=="delete" && $id!=null){
			$category 		= FaqCategoryModel::find($id);

			if(!$category){
				$this->rootdata->show_404();
			}

			$category->delete();
			$this->validation->setSuccess('Data telah berhasil di hapus');
			redirect('superuser/faqcategory');
			return;
		}
	}

	public function faqsubcategory($page="index",$id=null,$nodirect=false){

		$this->middleware->rootAccess('faq',true);
		$data['__MENU'] 	= 'faq';

		if($page=="index"){

			$data['subcategory'] 	= FaqSubCategoryModel::desc()->get();
			echo $this->blade->draw('admin.faqsubcateogry.index',$data);
			return;

		}else if($page=="create"){
			$data['type']	= 'create';
			echo $this->blade->draw('admin.faqsubcategory.content',$data);
			return;
		}
		else if($page=="created"){

			$this->validation->ajaxRequest('root');

			$rules = [
					    'required' 	=> [
					        ['category'],['name']
					    ]
					  ];

			$validate 	= $this->validation->check($rules,'post');

			if(!$validate->correct){
				$this->restapi->error($validate->data);
				return;
			}

			$category 			= FaqCategoryModel::find($this->input->post('category'));

			if(!$category){
				$this->restapi->error("maaf kategori faq tidak di temukan");
				return;
			}

			$subcategory 		= new FaqSubCategoryModel;
			$subcategory->name 	= $this->input->post('name');

			if(!$subcategory->save()){
				$this->restapi->error("maaf ada kesalahan silahkan coba kembali");
				return;
			}

			$this->restapi->success("data baru di tambahkan");
			return;
		}
		else if($page=="update" && $id!=null){

			$subcategory 		= FaqSubCategoryModel::find($id);

			if(!$subcategory){
				$this->rootdata->show_404();
			}

			$data['subcategory'] 	= $subcategory;
			$data['type']			= 'update';
			echo $this->blade->draw('admin.faqsubcategory.content',$data);
			return;
		}
		else if($page=="updated"){
			$this->validation->ajaxRequest('root');

			$rules = [
					    'required' 	=> [
					       ['subcategory'],['category'],['name']
					    ]
					  ];

			$validate 	= $this->validation->check($rules,'post');

			if(!$validate->correct){
				$this->restapi->error($validate->data);
				return;
			}

			$subcategory 		= FaqSubCategoryModel::find($this->input->post('subcategory'));

			if(!$subcategory){
				$this->restapi->error("maaf faq subkategori tidak ditemukan");
				return;
			}

			$category 			= FaqCategoryModel::find($this->input->post('category'));
			if(!$category){
				$this->restapi->error("maaf faq kategori tidak di temukan");
				return;
			}

			$subcategory->id_category 	= $category->id;
			$subcategory->name 			= $this->input->post('name');

			if(!$subcategory->save()){
				$this->restapi->error("maaf ada kesalahan silahkan coba kembali");
				return;
			}

			$this->restapi->success("data telah di perbarui");
			return;
		}
		else if($page=="bulkaction"){

			if($this->input->server('REQUEST_METHOD') != 'POST'){
				$this->rootdata->show_404();
			}

			$rules = [
					    'required' 	=> [
					        ['action'],['data']
					    ]
					  ];

			$validate 	= $this->validation->check($rules,'post');

			if(!$validate->correct){
				$this->restapi->error($validate->data);
				return;
			}

			$data 			= $this->input->post('data');

			switch ($page) {
				case 'delete':

					FaqSubCategoryModel::whereIn('id',$data)->delete();

					$this->validation->setSuccess('Data telah berhasil di hapus');
					redirect('superuser/faqsubcategory');		

					break;

				default:
					$this->rootdata->show_404();
					break;
			}
		}
		else if($page=="delete" && $id!=null){
			$subcategory 		= FaqSubCategoryModel::find($id);

			if(!$subcategory){
				$this->rootdata->show_404();
			}

			$subcategory->delete();
			$this->validation->setSuccess('Data telah berhasil di hapus');
			redirect('superuser/faqsubcategory');
			return;
		}
	}

	public function inbox($page="index",$id=null){
		$this->middleware->rootAccess('inbox',true);

		$data['__MENU'] 		= 'inbox';

		if($page=="index"){

			$data['inbox'] 		= InboxModel::desc()->get();
			echo $this->blade->draw('admin.inbox.index',$data);
			return;

		}else if($page=="detail" && $id!=null){

			$inbox 				= InboxModel::find($id);

			if(!$inbox){
				$this->rootdata->show_404();
			}

			$inbox->readed 	= 1;
			$inbox->save();

			$data['inbox']	= $inbox;
			echo $this->blade->draw('admin.inbox.content',$data);
			return;			

		}
		else if($page=="bulkaction"){

			if($this->input->server('REQUEST_METHOD') != 'POST'){
				$this->rootdata->show_404();
			}

			$rules = [
					    'required' 	=> [
					        ['action'],['data']
					    ]
					  ];

			$validate 	= $this->validation->check($rules,'post');

			if(!$validate->correct){
				$this->restapi->error($validate->data);
				return;
			}

			$data 			= $this->input->post('data');

			switch ($page) {
				case 'delete':

					InboxModel::whereIn('id',$data)->delete();

					$this->validation->setSuccess('Data telah berhasil di hapus');
					redirect('superuser/inbox');					

					break;
			 	case 'responded':
			 		InboxModel::whereIn('id',$data)->update(['status'=>'responded']);
			 		$this->validation->setSuccess('Data telah berhasil di respon');
					redirect('superuser/inbox');					
			 		break;
			 	case 'unresponded':
			 		InboxModel::whereIn('id',$data)->update(['status'=>'unresponded']);
			 		$this->validation->setSuccess('Data telah berhasil di unrespon');
					redirect('superuser/inbox');					
			 		break;
				default:
					$this->rootdata->show_404();
					break;
			}
		}
		else if ($page=="delete" && $id!=null){

			$inbox 		= InboxModel::find($id);

			if(!$inbox){
				$this->rootdata->show_404();
			}

			$inbox->delete();

			$this->validation->setSuccess('Data telah di hapus');
			redirect('superuser/inbox');
		}
	}


	public function product($page="index",$id=null,$nodirect=false){
		$this->middleware->rootAccess('product',true);

		$data['__MENU'] 		= 'product';

		if($page=="index"){

			$data['product'] 	= ProductModel::admin()->desc()->get();
			echo $this->blade->draw('admin.product.index',$data);
			return;

		}else if($page=="create"){

			$data['__MENU'] 	= 'product_content';
			$data['category'] 	= ProductCategoryModel::asc('name')->get();
			$data['unit'] 		= ProductUnitModel::asc('name')->get();
			$data['type']		= 'create';
			$data['note'] 		= 'Create new product';
			$data['url'] 		= '/superuser/product/created';
			$data['image']		= '[]';
			echo $this->blade->draw('admin.product.content',$data);

			return;
		}
		else if ($page=="created"){
			$this->validation->ajaxRequest();

			$rules = [
					    'required' 	=> [
					        ['subcategory'],['category'],['name'],['weight'],['price'],['unit']
					    ],
					    'integer'	=> [
					    	['weight'],['min'],['max'],['stock'],['height'],['width'],['diameter'],
					    	['length']
					    ],
					    'min'		=> [
					    	['min',1],['max',0],['weight',0],['stock',1],['height',0],['width',0],['diameter',0]
					    ],
					  ];

			$validate 	= $this->validation->check($rules,'post');

			if(!$validate->correct){
				$this->restapi->error($validate->data);
			}

			$category 		= ProductCategoryModel::find($this->input->post('category'));

			if(!$category){
				$this->response->error("Maaf kategori produk tidak di temukan");
			}


			$subcategory 	= ProductSubCategoryModel::where('id_category',$category->id)
									->find($this->input->post('subcategory'));

			if(!$subcategory){
				$this->response->error("Maaf sub kategori produk tidak ditemukan");
			}

			$unit 			= ProductUnitModel::find($this->input->post('unit'));

			if(!$unit){
				$this->response->error("Maaf produk unit tidak di temukan");
			}

			$description 	= $this->security->xss_clean($this->input->post('description'));

			$product 				= new ProductModel;
			$product->id_unit 		= $unit->id;
			$product->id_subcategory= $subcategory->id;
			$product->name 			= $this->input->post('name');
			$product->weight 		= $this->input->post('weight');
			$product->height 		= $this->input->post('height');
			$product->width 		= $this->input->post('width');
			$product->diameter 		= $this->input->post('diameter');
			$product->length 		= $this->input->post('length');
			$product->description 	= $description;
			$product->max 			= $this->input->post('max');
			$product->min 			= $this->input->post('min');
			$product->price 		= (int) str_replace(".","",$this->input->post('price'));
			$product->price_false 	= (int) str_replace(".","",$this->input->post('price_false'));
			$product->stock 		= $this->input->post('stock');
			$product->courier_service= ($this->input->post('courier_service')) ? 1 : 0;
			$product->status 		= ($this->input->post('status')) ? 'publish' : 'draft';
			$product->made 			= 'admin';

			if(!$product->save()){
				$this->restapi->error("maaf ada kesalahan silahkan coba kembali");
			}

			$error_upload 						= '';
			$uploaded 							= 0;
			$name 								= $this->input->post('name');

			foreach ($_FILES['image']['name'] as $key => $files) {

				if($key>3){
					break;
				}


				$product_image 					= new ProductImagesModel;
				$product_image->id_product 		= $product->id;

				$_FILES['product']['name']		= $_FILES['image']['name'][$key];
	            $_FILES['product']['type']		= $_FILES['image']['type'][$key];
	            $_FILES['product']['tmp_name']	= $_FILES['image']['tmp_name'][$key];
	            $_FILES['product']['error']		= $_FILES['image']['error'][$key];
	            $_FILES['product']['size']		= $_FILES['image']['size'][$key];

	            $filename 				= 'PRODUK '.limit_string($name).'  ('.date('Ymdhis').')';

				$upload 				= $this->upfiles->uploadImage(content_dir('images/lg/products'),'product',$filename);

				if(!$upload->status){
					$error_upload 		= $upload->result;
					continue;
					return;
				}

				$uploaded++;

				$filename 				= $upload->result->file_name;

				$option['origin']		= content_dir('images/lg/products/'.$filename);
				$option['filename']		= $filename;


				// RESIZE TO MEDIUM
				$option['size']			= 500;
				$option['path']			= content_dir('images/md/products/');
				$this->upfiles->resize($option);

				// RESIZE TO SMALL
				$option['size']			= 250;
				$option['path']			= content_dir('images/sm/products/');
				$this->upfiles->resize($option);

				// RESIZE TO SMALL
				$option['size']			= 100;
				$option['path']			= content_dir('images/xs/products/');
				$this->upfiles->resize($option);

				$product_image->image 	= $filename;
				$product_image->save();

			}

			if($uploaded<=0){
				$product->delete();
				$this->restapi->error(strip_tags($error_upload));
			}

			$images 				= ProductImagesModel::where('id_product',$product->id)->asc()->first();

			if(!$images){
				$product->delete();
				$this->restapi->error("Gambar tidak terupload silahkan coba kembali");				
			}

			$product->image 		= $images->image;
			$product->save();

			$this->validation->setSuccess('Produk baru telah di tambahkan');
			$this->restapi->response("/superuser/product");
		}
		else if ($page=="update" && $id!=null){

			$product 			= ProductModel::admin()->find($id);

			if(!$product){
				$this->webdata->show_404();
			}

			$data['product'] 	= $product;
			$data['__MENU'] 	= 'product_content';
			$data['category'] 	= ProductCategoryModel::asc('name')->get();
			$data['subcategory']= $product->sub->category->subs;
			$data['unit'] 		= ProductUnitModel::asc('name')->get();
			$data['type']		= 'update';
			$data['note'] 		= 'Update product';
			$data['url'] 		= '/superuser/product/updated';
			$data['image']		= json_image_limitless($product->images->pluck('image_dir'));
			echo $this->blade->draw('admin.product.content',$data);

			return;
		}
		else if($page=="updated"){

			$this->validation->ajaxRequest();

			$rules = [
					    'required' 	=> [
					        ['product'],['subcategory'],['category'],['name'],['weight'],['price'],['unit']
					    ],
					    'integer'	=> [
					    	['weight'],['min'],['max'],['stock'],['height'],['width'],['diameter'],
					    	['length']
					    ],
					    'min'		=> [
					    	['min',1],['max',0],['weight',0],['stock',1],['height',0],['width',0],['diameter',0]
					    ],
					  ];

			$validate 	= $this->validation->check($rules,'post');

			if(!$validate->correct){
				$this->restapi->error($validate->data);
			}

			$product 		= ProductModel::admin()->find($this->input->post('product'));

			if(!$product){
				$this->response->error("Maaf produk tidak di temukan");
			}

			$category 		= ProductCategoryModel::find($this->input->post('category'));

			if(!$category){
				$this->response->error("Maaf kategori produk tidak di temukan");
			}


			$subcategory 	= ProductSubCategoryModel::where('id_category',$category->id)
									->find($this->input->post('subcategory'));

			if(!$subcategory){
				$this->response->error("Maaf sub kategori produk tidak ditemukan");
			}

			$unit 			= ProductUnitModel::find($this->input->post('unit'));

			if(!$unit){
				$this->response->error("Maaf produk unit tidak di temukan");
			}

			$description 	= $this->security->xss_clean($this->input->post('description'));

			$product->id_subcategory= $subcategory->id;
			$product->id_unit 		= $unit->id;
			$product->name 			= $this->input->post('name');
			$product->weight 		= $this->input->post('weight');
			$product->height 		= $this->input->post('height');
			$product->width 		= $this->input->post('width');
			$product->diameter 		= $this->input->post('diameter');
			$product->length 		= $this->input->post('length');
			$product->description 	= $description;
			$product->max 			= $this->input->post('max');
			$product->min 			= $this->input->post('min');
			$product->price 		= (int) str_replace(".","",$this->input->post('price'));
			$product->price_false 	= (int) str_replace(".","",$this->input->post('price_false'));
			$product->stock 		= $this->input->post('stock');
			$product->courier_service= ($this->input->post('courier_service')) ? 1 : 0;
			$product->status 		= ($this->input->post('status')) ? 'publish' : 'draft';
			$product->made 			= 'admin';

			if(!$product->save()){
				$this->restapi->error("maaf ada kesalahan silahkan coba kembali");
			}

			$error_upload 						= '';
			$uploaded 							= 0;
			$name 								= $this->input->post('name');


			if($_FILES['image']['name'][0]!=""){
				foreach ($product->images as $image) {
					if($image->image!=""){
						remFile(content_dir('images/lg/products/'.$image->image));
						remFile(content_dir('images/md/products/'.$image->image));
						remFile(content_dir('images/sm/products/'.$image->image));
						remFile(content_dir('images/xs/products/'.$image->image));
					}
				}

				ProductImagesModel::where('id_product',$product->id)->delete();

				foreach ($_FILES['image']['name'] as $key => $files) {

					if($key>3){
						break;
					}


					$product_image 					= new ProductImagesModel;
					$product_image->id_product 		= $product->id;

					$_FILES['product']['name']		= $_FILES['image']['name'][$key];
		            $_FILES['product']['type']		= $_FILES['image']['type'][$key];
		            $_FILES['product']['tmp_name']	= $_FILES['image']['tmp_name'][$key];
		            $_FILES['product']['error']		= $_FILES['image']['error'][$key];
		            $_FILES['product']['size']		= $_FILES['image']['size'][$key];

		            $filename 				= 'PRODUK '.limit_string($name).'  ('.date('Ymdhis').')';

					$upload 				= $this->upfiles->uploadImage(content_dir('images/lg/products'),'product',$filename);

					if(!$upload->status){
						$error_upload 		= $upload->result;
						continue;
						return;
					}

					$uploaded++;

					$filename 				= $upload->result->file_name;

					$option['origin']		= content_dir('images/lg/products/'.$filename);
					$option['filename']		= $filename;


					// RESIZE TO MEDIUM
					$option['size']			= 500;
					$option['path']			= content_dir('images/md/products/');
					$this->upfiles->resize($option);

					// RESIZE TO SMALL
					$option['size']			= 250;
					$option['path']			= content_dir('images/sm/products/');
					$this->upfiles->resize($option);

					// RESIZE TO SMALL
					$option['size']			= 100;
					$option['path']			= content_dir('images/xs/products/');
					$this->upfiles->resize($option);

					$product_image->image 	= $filename;
					$product_image->save();

				}

				if($uploaded<=0){
					$this->restapi->error(strip_tags($error_upload));
				}
			}


			

			$images 				= ProductImagesModel::where('id_product',$product->id)->asc()->first();

			if(!$images){
				$this->restapi->error("Gambar tidak terupload silahkan coba kembali");				
			}

			$product->image 		= $images->image;
			$product->save();

			$this->validation->setSuccess('Produk telah di perbarui');
			$this->restapi->response("/superuser/product");

		}
		else if($page=="detail" && $id!=null){

			$product 			= ProductModel::find($id);

			if(!$product){
				$this->rootdata->show_404();
			}

			$product->readed 	= 1;
			$product->save();

			$data['product']	= $product;
			echo $this->blade->draw('admin.product.content',$data);
			return;			

		}
		else if($page=="bulkaction"){

			if($this->input->server('REQUEST_METHOD') != 'POST'){
				$this->rootdata->show_404();
			}

			$rules = [
					    'required' 	=> [
					        ['action'],['data']
					    ]
					  ];

			$validate 	= $this->validation->check($rules,'post');

			if(!$validate->correct){
				$this->restapi->error($validate->data);
			}

			$data 		= $this->input->post('data');
			$product 	= ProductModel::whereIn('id',$data)->get();

			switch ($this->input->post('action')) {
				case 'delete':

					foreach ($product as $result) {

						foreach ($result->images as $key => $image) {
							if($image->image!=""){
								remFile(content_dir('images/lg/products'.$image->image));
								remFile(content_dir('images/md/products/'.$image->image));
								remFile(content_dir('images/sm/products/'.$image->image));
								remFile(content_dir('images/xs/products/'.$image->image));
							}
						}

					}

					ProductModel::whereIn('id',$data)->delete();
					$this->validation->setSuccess('Data telah berhasil di hapus');

					if(!$this->input->is_ajax_request()){
						redirect('superuser/product');					
					}else{
						$this->restapi->response("Produk telah di hapus");
						
					}
					break;
				case 'block':
					ProductModel::whereIn('id',$data)->update(['status'=>'block']);
					$this->validation->setSuccess('Data telah berhasil di block');

					if(!$this->input->is_ajax_request()){
						redirect('superuser/product');					
					}else{
						$this->restapi->response("Produk telah di block");
						
					}			
					break;
				case 'publish':
					ProductModel::whereIn('id',$data)->update(['status'=>'publish']);
					$this->validation->setSuccess('Data telah berhasil di publish');

					if(!$this->input->is_ajax_request()){
						redirect('superuser/product');					
					}else{
						$this->restapi->response("Produk telah di publish");
						
					}
					break;
				case 'draft':
					ProductModel::whereIn('id',$data)->update(['status'=>'draft']);
					$this->validation->setSuccess('Data telah berhasil di pindah ke draft');

					if(!$this->input->is_ajax_request()){
						redirect('superuser/product');					
					}else{
						$this->restapi->response("Produk telah di pindah ke draft");
						
					}
					break;
				case 'read':
					ProductModel::whereIn('id',$data)->update(['readed'=>1]);

					$this->validation->setSuccess('Data telah berhasil di tandai sebagai di baca');

					if(!$this->input->is_ajax_request()){
						redirect('superuser/product');					
					}else{
						$this->restapi->response("Produk telah di tandai di baca");
						
					}
					break;
				default:
					$this->rootdata->show_404();
					break;
			}
		}
		else if ($page=="delete" && $id!=null){

			$product 		= ProductModel::find($id);

			if(!$product){
				$this->rootdata->show_404();
			}

			foreach ($product->images as $key => $image) {
				if($image->image!=""){
					remFile(content_dir('images/lg/products/'.$image->image));
					remFile(content_dir('images/md/products/'.$image->image));
					remFile(content_dir('images/sm/products/'.$image->image));
					remFile(content_dir('images/xs/products/'.$image->image));
				}
			}

			$product->delete();

			if($nodirect){
				return;
			}

			$this->validation->setSuccess('Data telah di hapus');
			redirect('superuser/product');
		}
		else{
			$this->webdata->show_404();
		}
	}

	public function productcategory($page="index",$id=null,$nodirect=false){

		$this->middleware->rootAccess('product',true);
		$data['__MENU'] 	= 'product_category';

		if($page=="index"){
			$data['category'] 	= ProductCategoryModel::desc()->get();
			echo $this->blade->draw('admin.productcategory.index',$data);
			return;

		}else if($page=="create"){
			$data['type']	= 'create';
			$data['note'] 	= 'Create new category product';
			$data['url'] 	= '/superuser/productcategory/created';
			$data['image']	= '[]';
			echo $this->blade->draw('admin.productcategory.content',$data);
			return;
		}
		else if($page=="created"){

			$this->validation->ajaxRequest('root');

			$rules = [
					    'required' 	=> [
					        ['name']
					    ]
					  ];

			$validate 	= $this->validation->check($rules,'post');

			if(!$validate->correct){
				$this->restapi->error($validate->data);
			}

			$category 					= new ProductCategoryModel;

			if(!empty($_FILES['image']['name'])){

				$filename 				= 'PRODUK KATEGORI '.limit_string($this->input->post('name')).' ('.date('Ymdhis').')';
				$upload 				= $this->upfiles->uploadImage(content_dir('images/lg/categories'),'image',$filename);

				if(!$upload->status){
					$this->restapi->error($upload->result);
				}

				$filename 				= $upload->result->file_name;

				$option['origin']		= content_dir('images/lg/categories/'.$filename);
				$option['filename']		= $filename;

				// RESIZE TO MEDIUM
				$option['size']			= 250;
				$option['path']			= content_dir('images/md/categories/');
				$this->upfiles->resize($option);

				// RESIZE TO SMALL
				$option['size']			= 120;
				$option['path']			= content_dir('images/sm/categories/');
				$this->upfiles->resize($option);

				// RESIZE TO MINI
				$option['size']			= 80;
				$option['path']			= content_dir('images/xs/categories/');
				$this->upfiles->resize($option);
				
				$category->image 	= $filename;
			}

			if(!empty($_FILES['icon']['name'])){

				$filename 				= 'IKON KATEGORI '.limit_string($this->input->post('name')).' ('.date('Ymdhis').')';
				$upload 				= $this->upfiles->uploadImage(content_dir('images/lg/iconcategories/'),'icon',$filename);

				if(!$upload->status){
					$this->restapi->error($upload->result);
				}

				$filename 				= $upload->result->file_name;

				$option['origin']		= content_dir('images/lg/iconcategories/'.$filename);
				$option['filename']		= $filename;

				// RESIZE TO MEDIUM
				$option['size']			= 250;
				$option['path']			= content_dir('images/md/iconcategories/');
				$this->upfiles->resize($option);

				// RESIZE TO SMALL
				$option['size']			= 120;
				$option['path']			= content_dir('images/sm/iconcategories/');
				$this->upfiles->resize($option);

				// RESIZE TO MINI
				$option['size']			= 80;
				$option['path']			= content_dir('images/xs/iconcategories/');
				$this->upfiles->resize($option);
				
				$category->icon 		= $filename;
			}

			$category->name 			= $this->input->post('name');
			$category->description 	 	= $this->input->post('description');
			
			if(!$category->save()){
				$this->restapi->error("maaf ada kesalahan silahkan coba kembali");
			}

			$this->validation->setSuccess("data baru di tambahkan");
			$this->restapi->success("/superuser/productcategory");
		}
		else if($page=="update" && $id!=null){

			$category 		= ProductCategoryModel::find($id);

			if(!$category){
				$this->rootdata->show_404();
			}

			$data['category'] 	= $category;
			$data['type']		= 'update';
			$data['note'] 		= 'Updated category product';
			$data['url'] 		= '/superuser/productcategory/updated';
			$data['image']		= json_image_limitless([$category->image_sm_dir]);

			echo $this->blade->draw('admin.productcategory.content',$data);
			return;
		}
		else if($page=="updated"){
			$this->validation->ajaxRequest('root');

			$rules = [
					    'required' 	=> [
					       ['id'],['name']
					    ]
					  ];

			$validate 	= $this->validation->check($rules,'post');

			if(!$validate->correct){
				$this->restapi->error($validate->data);
			}

			$category 			= ProductCategoryModel::find($this->input->post('id'));

			if(!$category){
				$this->restapi->error("maaf kategori produk tidak di temukan");
			}

			if(!empty($_FILES['image']['name'])){

				$filename 				= 'PRODUK KATEGORI '.limit_string($this->input->post('name')).' ('.date('Ymdhis').')';
				$upload 				= $this->upfiles->uploadImage(content_dir('images/lg/categories'),'image',$filename);

				if(!$upload->status){
					$this->restapi->error($upload->result);
				}

				$filename 				= $upload->result->file_name;

				$option['origin']		= content_dir('images/lg/categories/'.$filename);
				$option['filename']		= $filename;

				// RESIZE TO MEDIUM
				$option['size']			= 250;
				$option['path']			= content_dir('images/md/categories/');
				$this->upfiles->resize($option);

				// RESIZE TO SMALL
				$option['size']			= 120;
				$option['path']			= content_dir('images/sm/categories/');
				$this->upfiles->resize($option);

				// RESIZE TO MINI
				$option['size']			= 80;
				$option['path']			= content_dir('images/xs/categories/');
				$this->upfiles->resize($option);

				if($category->image!=""){
					remFile(content_dir('images/lg/categories/'.$category->image));
					remFile(content_dir('images/md/categories/'.$category->image));
					remFile(content_dir('images/sm/categories/'.$category->image));
					remFile(content_dir('images/xs/categories/'.$category->image));
				}
				
				$category->image 	= $filename;
				$category->save();
			}

			if(!empty($_FILES['icon']['name'])){

				$filename 				= 'IKON KATEGORI '.limit_string($this->input->post('name')).' ('.date('Ymdhis').')';
				$upload 				= $this->upfiles->uploadImage(content_dir('images/lg/iconcategories/'),'icon',$filename);

				if(!$upload->status){
					if($category->image!=""){
						remFile(content_dir('images/lg/categories/'.$category->image));
						remFile(content_dir('images/md/categories/'.$category->image));
						remFile(content_dir('images/sm/categories/'.$category->image));
						remFile(content_dir('images/xs/categories/'.$category->image));
					}
					$this->restapi->error($upload->result);
				}

				$filename 				= $upload->result->file_name;

				$option['origin']		= content_dir('images/lg/iconcategories/'.$filename);
				$option['filename']		= $filename;

				// RESIZE TO MEDIUM
				$option['size']			= 250;
				$option['path']			= content_dir('images/md/iconcategories/');
				$this->upfiles->resize($option);

				// RESIZE TO SMALL
				$option['size']			= 120;
				$option['path']			= content_dir('images/sm/iconcategories/');
				$this->upfiles->resize($option);

				// RESIZE TO MINI
				$option['size']			= 80;
				$option['path']			= content_dir('images/xs/iconcategories/');
				$this->upfiles->resize($option);

				if($category->icon!=""){
					remFile(content_dir('images/lg/iconcategories/'.$category->icon));
					remFile(content_dir('images/md/iconcategories/'.$category->icon));
					remFile(content_dir('images/sm/iconcategories/'.$category->icon));
					remFile(content_dir('images/xs/iconcategories/'.$category->icon));
				}
				
				$category->icon 		= $filename;
			}

			$category->name 		= $this->input->post('name');
			$category->description 	= $this->input->post('description');

			if(!$category->save()){
				$this->restapi->error("maaf ada kesalahan silahkan coba kembali");
			}

			$this->validation->setSuccess("data telah di perbarui");
			$this->restapi->success("/superuser/productcategory");
		}
		else if($page=="bulkaction"){

			if($this->input->server('REQUEST_METHOD') != 'POST'){
				$this->rootdata->show_404();
			}

			$rules = [
					    'required' 	=> [
					        ['action'],['data']
					    ]
					  ];

			$validate 	= $this->validation->check($rules,'post');

			if(!$validate->correct){
				$this->restapi->error($validate->data);
			}

			$data 			= $this->input->post('data');
			$action 		= $this->input->post('action');

			switch ($action) {
				case 'delete':

					$category 	= ProductCategoryModel::whereIn('id',$data)->get();

					foreach ($category as $result) {

						if($result->image!=""){
							remFile(content_dir('images/lg/categories/'.$result->image));
							remFile(content_dir('images/md/categories/'.$result->image));
							remFile(content_dir('images/sm/categories/'.$result->image));
							remFile(content_dir('images/xs/categories/'.$result->image));
						}

						if($result->icon!=""){
							remFile(content_dir('images/lg/iconcategories/'.$result->icon));
							remFile(content_dir('images/md/iconcategories/'.$result->icon));
							remFile(content_dir('images/sm/iconcategories/'.$result->icon));
							remFile(content_dir('images/xs/iconcategories/'.$result->icon));
						}

						foreach ($result->subs as $sub) {
							$this->productsubcategory('delete',$sub->id,true);
						}
					}
					

					ProductCategoryModel::whereIn('id',$data)->delete();

					$this->validation->setSuccess('Data telah berhasil di hapus');
					redirect('superuser/productcategory');		

					break;

				default:
					$this->rootdata->show_404();
					break;
			}
		}
		else if($page=="delete" && $id!=null){
			$category 		= ProductCategoryModel::find($id);

			if(!$category){
				$this->rootdata->show_404();
			}

			if($category->image!=""){
				remFile(content_dir('images/lg/categories/'.$category->image));
				remFile(content_dir('images/md/categories/'.$category->image));
				remFile(content_dir('images/sm/categories/'.$category->image));
				remFile(content_dir('images/xs/categories/'.$category->image));
			}

			if($category->icon!=""){
				remFile(content_dir('images/lg/iconcategories/'.$category->icon));
				remFile(content_dir('images/md/iconcategories/'.$category->icon));
				remFile(content_dir('images/sm/iconcategories/'.$category->icon));
				remFile(content_dir('images/xs/iconcategories/'.$category->icon));
			}

			$category->delete();
			$this->validation->setSuccess('Data telah berhasil di hapus');
			redirect('superuser/productcategory');
			return;
		}
	}

	public function productsubcategory($page="index",$id=null,$nodirect=false){

		$this->middleware->rootAccess('product',true);
		$data['__MENU'] 	= 'product_subcategory';

		if($page=="index"){

			$data['subcategory'] 	= ProductSubCategoryModel::desc()->get();
			echo $this->blade->draw('admin.productsubcategory.index',$data);
			return;

		}else if($page=="create"){

			$data['type']		= 'create';
			$data['note'] 		= 'Create sub category product';
			$data['url'] 		= '/superuser/productsubcategory/created';
			$data['category']	= ProductCategoryModel::asc('name')->get();

			echo $this->blade->draw('admin.productsubcategory.content',$data);
			return;

		}
		else if($page=="created"){

			$this->validation->ajaxRequest('root');

			$rules = [
					    'required' 	=> [
					        ['category'],['name']
					    ]
					  ];

			$validate 	= $this->validation->check($rules,'post');

			if(!$validate->correct){
				$this->restapi->error($validate->data);
				return;
			}

			$category 			= ProductCategoryModel::find($this->input->post('category'));

			if(!$category){
				$this->restapi->error("maaf kategori produk tidak di temukan");
				return;
			}

			$subcategory 				= new ProductSubCategoryModel;

			$subcategory->id_category	= $category->id;
			$subcategory->name 			= $this->input->post('name');
			$subcategory->description 	= $this->input->post('description');
			
			if(!$subcategory->save()){
				$this->restapi->error("maaf ada kesalahan silahkan coba kembali");
				return;
			}

			$this->validation->setSuccess("data baru di tambahkan");
			$this->restapi->success("/superuser/productsubcategory");
		}
		else if($page=="update" && $id!=null){

			$subcategory 		= ProductSubCategoryModel::find($id);

			if(!$subcategory){
				$this->rootdata->show_404();
			}

			$data['category']		= ProductCategoryModel::asc('name')->get();
			$data['subcategory'] 	= $subcategory;
			$data['type']			= 'update';
			$data['note'] 			= 'Update sub category product';
			$data['url'] 			= '/superuser/productsubcategory/updated';
			echo $this->blade->draw('admin.productsubcategory.content',$data);
			return;
		}
		else if($page=="updated"){
			$this->validation->ajaxRequest('root');

			$rules = [
					    'required' 	=> [
					       ['id'],['category'],['name']
					    ]
					  ];

			$validate 	= $this->validation->check($rules,'post');

			if(!$validate->correct){
				$this->restapi->error($validate->data);
			}

			$subcategory 			= ProductSubCategoryModel::find($this->input->post('id'));

			if(!$subcategory){
				$this->restapi->error("maaf sub kategori produk tidak di temukan");
				return;
			}

			$category 			= ProductCategoryModel::find($this->input->post('category'));

			if(!$category){
				$this->restapi->error("maaf kategori produk tidak di temukan");
				return;
			}

			$subcategory->id_category 	= $category->id;
			$subcategory->name 			= $this->input->post('name');
			$subcategory->description 	= $this->input->post('description');

			if(!$subcategory->save()){
				$this->restapi->error("maaf ada kesalahan silahkan coba kembali");
			}

			$this->validation->setSuccess("data telah di perbarui");
			$this->restapi->success("/superuser/productsubcategory");
		}
		else if($page=="bulkaction"){

			if($this->input->server('REQUEST_METHOD') != 'POST'){
				$this->rootdata->show_404();
			}

			$rules = [
					    'required' 	=> [
					        ['action'],['data']
					    ]
					  ];

			$validate 	= $this->validation->check($rules,'post');

			if(!$validate->correct){
				$this->restapi->error($validate->data);
				return;
			}

			$data 			= $this->input->post('data');

			switch ($page) {
				case 'delete':

					$subcategory 	= ProductSubCategoryModel::whereIn('id',$data)->get();

					foreach ($subcategory as $result) {

						foreach ($result->products as $product) {
							$this->product('delete',$product->id,true);
						}
					}
					
					ProductSubCategoryModel::whereIn('id',$data)->delete();

					$this->validation->setSuccess('Data telah berhasil di hapus');
					redirect('superuser/productsubcategory');		

					break;

				default:
					$this->rootdata->show_404();
					break;
			}
		}
		else if($page=="delete" && $id!=null){
			$subcategory 		= ProductSubCategoryModel::find($id);

			if(!$subcategory){
				$this->rootdata->show_404();
			}

			foreach ($subcategory->products as $product) {
				$this->product('delete',$product->id,true);
			}

			$subcategory->delete();

			$this->validation->setSuccess('Data telah berhasil di hapus');
			redirect('superuser/productsubcategory');
			return;
		}
	}

	public function productunit($page="index",$id=null,$nodirect=false){

		$this->middleware->rootAccess('product',true);
		$data['__MENU'] 	= 'product_unit';

		if($page=="index"){

			$data['unit'] 	= ProductUnitModel::desc()->get();
			echo $this->blade->draw('admin.productunit.index',$data);
			return;

		}else if($page=="create"){

			$data['__MENU'] 	= 'product_unit_content';
			$data['type']		= 'create';
			$data['note'] 		= 'Create new product unit';
			$data['url'] 		= '/superuser/productunit/created';
			$data['category']	= ProductCategoryModel::asc('name')->get();

			echo $this->blade->draw('admin.productunit.content',$data);
			return;

		}
		else if($page=="created"){

			$this->validation->ajaxRequest('root');

			$rules = [
					    'required' 	=> [
					        ['name']
					    ]
					  ];

			$validate 	= $this->validation->check($rules,'post');

			if(!$validate->correct){
				$this->restapi->error($validate->data);
			}


			$unit 				= new ProductUnitModel;

			$unit->name 		= $this->input->post('name');
			$unit->description 	= $this->input->post('description');
			
			if(!$unit->save()){
				$this->restapi->error("maaf ada kesalahan silahkan coba kembali");
			}

			$this->validation->setSuccess("data baru di tambahkan");
			$this->restapi->success("/superuser/productunit");
		}
		else if($page=="update" && $id!=null){

			$unit 		= ProductUnitModel::find($id);

			if(!$unit){
				$this->rootdata->show_404();
			}

			$data['__MENU'] 		= 'product_unit_content';
			$data['unit'] 			= $unit;
			$data['type']			= 'update';
			$data['note'] 			= 'Update unit product';
			$data['url'] 			= '/superuser/productunit/updated';
			echo $this->blade->draw('admin.productunit.content',$data);
			return;
		}
		else if($page=="updated"){
			$this->validation->ajaxRequest('root');

			$rules = [
					    'required' 	=> [
					       ['id'],['name']
					    ]
					  ];

			$validate 	= $this->validation->check($rules,'post');

			if(!$validate->correct){
				$this->restapi->error($validate->data);
			}

			$unit 			= ProductUnitModel::find($this->input->post('id'));

			if(!$unit){
				$this->restapi->error("maaf sub kategori produk tidak di temukan");
			}

			$unit->name 		= $this->input->post('name');
			$unit->description 	= $this->input->post('description');

			if(!$unit->save()){
				$this->restapi->error("maaf ada kesalahan silahkan coba kembali");
			}

			$this->validation->setSuccess("data telah di perbarui");
			$this->restapi->success("/superuser/productunit");
		}
		else if($page=="bulkaction"){

			if($this->input->server('REQUEST_METHOD') != 'POST'){
				$this->rootdata->show_404();
			}

			$rules = [
					    'required' 	=> [
					        ['action'],['data']
					    ]
					  ];

			$validate 	= $this->validation->check($rules,'post');

			if(!$validate->correct){
				$this->restapi->error($validate->data);
			}

			$data 			= $this->input->post('data');

			switch ($page) {
				case 'delete':

					$unit 	= ProductUnitModel::whereIn('id',$data)->get();

					foreach ($unit as $result) {

						foreach ($result->products as $product) {
							$this->product('delete',$product->id,true);
						}
					}
					
					ProductUnitModel::whereIn('id',$data)->delete();

					$this->validation->setSuccess('Data telah berhasil di hapus');
					redirect('superuser/productunit');		

					break;

				default:
					$this->rootdata->show_404();
					break;
			}
		}
		else if($page=="delete" && $id!=null){

			$unit 		= ProductUnitModel::find($id);

			if(!$unit){
				$this->rootdata->show_404();
			}

			foreach ($unit->products as $product) {
				$this->product('delete',$product->id,true);
			}

			$unit->delete();

			$this->validation->setSuccess('Data telah berhasil di hapus');
			redirect('superuser/productunit');
			return;
		}
	}

	public function storeproduct($page="index",$id=null,$nodirect=false){

		$this->middleware->rootAccess('storeproduct',true);

		$data['__MENU'] 		= 'store_product';

		if($page=="index"){

			$data['product'] 	= ProductModel::store()->desc()->get();
			echo $this->blade->draw('admin.storeproduct.index',$data);
			return;

		}
		else if ($page=="active"){
			
			$data['product'] 	= ProductModel::store()->active()->desc()->get();
			echo $this->blade->draw('admin.storeproduct.index',$data);
			return;

		}else if ($page=="block"){
			
			$data['product'] 	= ProductModel::store()->status('block')->desc()->get();
			echo $this->blade->draw('admin.storeproduct.index',$data);
			return;

		}else if ($page=="detail" && $id!=null){
			$product 			= ProductModel::store()->find($id);

			if(!$product){
				$this->webdata->show_404();
			}

			$data['product'] 	= $product;
			echo $this->blade->draw('admin.storeproduct.content',$data);
			return;
		}
		else if($page=="bulkaction"){

			if($this->input->server('REQUEST_METHOD') != 'POST'){
				$this->rootdata->show_404();
			}

			$rules = [
					    'required' 	=> [
					        ['action'],['data']
					    ]
					  ];

			$validate 	= $this->validation->check($rules,'post');

			if(!$validate->correct){
				$this->restapi->error($validate->data);
			}

			$data 		= $this->input->post('data');
			$product 	= ProductModel::whereIn('id',$data)->get();

			switch ($this->input->post('action')) {
				case 'delete':

					foreach ($product as $result) {

						foreach ($result->images as $key => $image) {
							if($image->image!=""){
								remFile(content_dir('images/lg/products'.$image->image));
								remFile(content_dir('images/md/products/'.$image->image));
								remFile(content_dir('images/sm/products/'.$image->image));
								remFile(content_dir('images/xs/products/'.$image->image));
							}
						}

					}

					ProductModel::whereIn('id',$data)->delete();
					$this->validation->setSuccess('Data telah berhasil di hapus');

					if(!$this->input->is_ajax_request()){
						redirect('superuser/storeproduct');					
					}else{
						$this->restapi->response("Produk telah di hapus");
						
					}
					break;
				case 'publish':
					ProductModel::whereIn('id',$data)->update(['status'=>'draft']);
					$this->validation->setSuccess('Data telah berhasil di aktifkan');

					if(!$this->input->is_ajax_request()){
						redirect('superuser/storeproduct');					
					}else{
						$this->restapi->response("Produk telah di aktifkan");
						
					}
					break;
				case 'draft':
					ProductModel::whereIn('id',$data)->update(['status'=>'block']);
					$this->validation->setSuccess('Data telah berhasil di block');

					if(!$this->input->is_ajax_request()){
						redirect('superuser/storeproduct');					
					}else{
						$this->restapi->response("Produk telah di block");
						
					}			
					break;
				case 'read':
					ProductModel::whereIn('id',$data)->update(['readed'=>1]);

					$this->validation->setSuccess('Data telah berhasil di tandai sebagai di baca');

					if(!$this->input->is_ajax_request()){
						redirect('superuser/storeproduct');					
					}else{
						$this->restapi->response("Produk telah di tandai di baca");
						
					}
					break;
				default:
					$this->rootdata->show_404();
					break;
			}
		}
		else if ($page=="delete" && $id!=null){

			$product 		= ProductModel::find($id);

			if(!$product){
				$this->rootdata->show_404();
			}

			foreach ($product->images as $key => $image) {
				if($image->image!=""){
					remFile(content_dir('images/lg/products/'.$image->image));
					remFile(content_dir('images/md/products/'.$image->image));
					remFile(content_dir('images/sm/products/'.$image->image));
					remFile(content_dir('images/xs/products/'.$image->image));
				}
			}

			$product->delete();

			if($nodirect){
				return;
			}

			$this->validation->setSuccess('Data telah di hapus');
			redirect('superuser/storeproduct');
		}
		else{

			$this->webdata->show_404();

		}

	}

	public function seo($page="index"){
		$this->middleware->rootAccess('seo',true);

		$data['__MENU'] 	= 'seo';

		if($page=="index"){
			echo $this->blade->draw('admin.seo.index');
			return;

		}else if ($page=="save"){

			$this->validation->ajaxRequest('seo');

			$rules = [
					    'required' 	=> [
					        ['keyword'],['name']
					    ]
					  ];

			$validate 	= $this->validation->check($rules,'post');

			if(!$validate->correct){
				$this->restapi->error($validate->data);
				return;
			}

			$seo 					= SeoModel::first();
			$seo->name 				= $this->input->post('name');
			$seo->keyword 			= $this->input->post('keyword');
			$seo->description 		= $this->input->post('description');
			$seo->facebook_pixel 	= $this->input->post('facebook_pixel');

			if(!empty($_FILES['logo']['name'])){

				$filename 				= 'LOGO '.$config->name.' ('.date('Ymdhis').')';
				$upload 				= $this->upfiles->uploadImage(content_dir('images/lg/logo'),'logo',$filename);

				if(!$upload->status){
					$this->restapi->error($upload->result);
					return;
				}

				$filename 				= $upload->result->file_name;

				$option['origin']		= content_dir('images/lg/logo/'.$filename);
				$option['filename']		= $filename;

				// RESIZE TO MEDIUM
				$option['size']			= 250;
				$option['path']			= content_dir('images/md/logo/');
				$this->upfiles->resize($option);

				// RESIZE TO SMALL
				$option['size']			= 120;
				$option['path']			= content_dir('images/sm/logo/');
				$this->upfiles->resize($option);

				// RESIZE TO MINI
				$option['size']			= 80;
				$option['path']			= content_dir('images/xs/logo/');
				$this->upfiles->resize($option);

				if($config->logo!=""){
					remFile(content_dir('images/lg/logo/'.$config->logo));
					remFile(content_dir('images/md/logo/'.$config->logo));
					remFile(content_dir('images/sm/logo/'.$config->logo));
					remFile(content_dir('images/xs/logo/'.$config->logo));
				}

				$config->logo 		= $filename;
				$config->save();
			}

			if(!empty($_FILES['image']['name'])){

				$filename 				= 'META IMAGE ('.date('Ymdhis').')';
				$upload 				= $this->upfiles->uploadImage(content_dir('images/lg/meta'),'image',$filename);

				if(!$upload->status){
					$this->restapi->error($upload->result);
					return;
				}

				$filename 				= $upload->result->file_name;

				$option['origin']		= content_dir('images/lg/meta/'.$filename);
				$option['filename']		= $filename;

				// RESIZE TO MEDIUM
				$option['size']			= 600;
				$option['path']			= content_dir('images/md/meta/');
				$this->upfiles->resize($option);

				// RESIZE TO SMALL
				$option['size']			= 200;
				$option['path']			= content_dir('images/sm/meta/');

				$this->upfiles->resize($option);


				if($seo->image!=""){
					remFile(content_dir('images/lg/meta/'.$seo->image));
					remFile(content_dir('images/md/meta/'.$seo->image));
					remFile(content_dir('images/sm/meta/'.$seo->image));
				}

				$seog->image 	= $filename;
			}

			$seo->save();

			$this->restapi->success("pengaturan telah di perbarui");
			return;
		}else{
			$this->rootdata->show_404();
		}
	}

	public function subscribes($page="index",$id=null){
		$this->middleware->rootAccess('subscribes',true);

		$data['__MENU'] 		= 'subscribes';

		if($page=="index"){

			$data['subscribes'] 	= SubscribesModel::desc()->get();
			echo $this->blade->draw('admin.subscribes.index',$data);
			return;

		}
		else if($page=="bulkaction"){

			if($this->input->server('REQUEST_METHOD') != 'POST'){
				$this->rootdata->show_404();
			}

			$rules = [
					    'required' 	=> [
					        ['action'],['data']
					    ]
					  ];

			$validate 	= $this->validation->check($rules,'post');

			if(!$validate->correct){
				$this->restapi->error($validate->data);
				return;
			}

			$data 			= $this->input->post('data');

			switch ($page) {
				case 'delete':

					SubscrbesModel::whereIn('id',$data)->get();
					$this->validation->setSuccess('Data telah berhasil di hapus');
					redirect('superuser/subscribes');					

					break;

				default:
					$this->rootdata->show_404();
					break;
			}
		}
		else if ($page=="delete" && $id!=null){

			$subscribes 		= SubscribesModel::find($id);

			if(!$subscribes){
				$this->rootdata->show_404();
			}

			$subscribes->delete();

			$this->validation->setSuccess('Data telah di hapus');
			redirect('superuser/subscribes');
		}
	}

	public function root($url="index",$id=null){

		$this->middleware->rootaccess('root');

		$data['__MENU']				= "root";
		$data['auth']				= AuthModel::desc()->get();

		if($url=="index"){

			$data['root'] 			= SuperuserModel::desc()->get();
			echo $this->blade->draw('admin.root.index',$data);	
			return;

		}
		else if($url=="create"){
			$data['type']			= "create";
			$data['authrule'] 		= [];
			echo $this->blade->draw('admin.root.content',$data);	
			return;
		}
		else if($url=="checkusername" && $this->input->is_ajax_request()){
			$rules 		= [
						    'required' 	=> [
						        ['username']
						    ],
						    'alphaNum'	=> [
						    	['username']
						    ],
						    'lengthMin'	=>	[
				    			['username',5]
				    		]
						  ];

			$validate 	= Validation::check($rules,'post');

			if(!$validate->auth){
				$this->restapi->error($validate->msg);
				return;
			}

			$check 				= AuthModel::where('username',$this->input->post('username'))->first();

			if($check){

				if($this->input->post('id')==$check->id){
					$this->restapi->success("username bisa di pakai");
					return;
				}

				$this->restapi->error("Opps! Userame Telah Terpakai");
				return;
			}

			$this->restapi->success("username bisa di pakai");

			return;
		}
		else if($url=="changestatus" && $this->input->is_ajax_request()){
			$rules 		= [
						    'required' 	=> [
						        ['status'],['id']
						    ]
						  ];

			$validate 	= Validation::check($rules,'post');

			if(!$validate->auth){
				$this->restapi->error($validate->msg);
				return;
			}

			$auth 				= AuthModel::find($this->input->post('id'));
			if(!$auth){
				$this->restapi->error("uknown id");
				return;
			}
			$auth->status 		= $this->input->post('status');
			$auth->save();
			$this->restapi->success("changed");

			return;
		}
		else if ($url == "created"){

			$this->validation->ajaxRequest();

			$rules 		= [
						    'required' 	=> [
						        ['name'],['username'],['password'],['conf_password']
						    ],
						    'alphaNum'	=> [
						    	['username']
						    ],
						    'equals'	=> [
						    	['conf_password','password']
						    ],
						    'lengthMin'	=>	[
				    			['password',8],['conf_password',8],['username',5]
				    		]
						  ];

			if(!$this->input->post('access_all')){
				$rules['required'][] 	= ['access'];
			}

			$validate 	= $this->validation->check($rules,'post');

			if(!$validate->correct){
				$this->restapi->error($validate->data);
				return;
			}

			$check 				= SuperuserModel::where('username',$this->input->post('username'))->first();

			if($check){
				$this->restapi->error("Opps! Userame Telah Terpakai");
				return;
			}

			$root 				= new SuperuserModel;

			if (!empty($_FILES['image']['name'])) {

				$filename 	= 'ADMIN__'.seo($this->input->post('name')).'__'.date('Ymdhis');

				$upload 	= $this->upload('images/admin','image',$filename);
				if($upload['auth']	== false){
					$this->restapi->error($upload['msg']);
					return;
				}	

				$auth->image= $upload['msg']['file_name'];
			}
			

			$auth->name				= $this->input->post('name');
			$auth->username			= $this->input->post('username');
			$auth->password 		= DefuseLib::encrypt($this->input->post('password'));
			$auth->ipaddress 		= $this->input->ip_address();
			$auth->lastlog 			= date('Y-m-d H:i:s ');
			$auth->status 			= (null !==$this->input->post('status') ? 'active' : 'blocked');
			if($auth->save()){

				if($this->input->post('access_all')){
					$access 				= new AuthRuleModel;
					$access->id_superuser	= $auth->id;
					$access->menu 			= 'all';
					$access->save();
				}
				else {
					foreach ($this->input->post('access') as $result) {
						$access 				= new AuthRuleModel;
						$access->id_superuser	= $auth->id;
						$access->menu 			= $result;
						$access->save();
					}	
				}

				$this->restapi->success("Akun Administrator Di Tambahkan");
				return;
			}
		}
		else if ($url=="update" && $id!=null){

			$data['auth'] 			= AuthModel::find($id);

			$data['authrule'] 		= [];

			foreach ($data['auth']->rule as $result) {
				array_push($data['authrule'], $result->menu);
			}

			$data['type']			= "update";

			if(!isset($data['auth']->id)){
				redirect('superuser/auth');
				return;
			}

			echo $this->blade->draw('admin.auth.content',$data);	
			return;
		}
		else if ($url=="updated" && $id!=null && $this->input->is_ajax_request() == true){

			$auth 		= AuthModel::find($id);

			if(!$auth){
				$this->restapi->error("Akun Administrator Tidak Di Temukan");
				return;
			}

			$rules 		= [
						    'required' 	=> [
						        ['name'],['username'],['password'],['conf_password']
						    ],
						    'alphaNum'	=> [
						    	['username']
						    ],
						    'lengthMin'	=>	[
				    			['password',8],['conf_password',8],['username',5]
				    		]
						  ];

			if(!$this->input->post('access_all')){
				$rules['required'][] 	= ['access'];
			}

			$validate 	= Validation::check($rules,'post');

			if(!$validate->auth){
				$this->restapi->error($validate->msg);
				return;
			}


			if($this->input->post('password')!==$this->input->post('conf_password')){
				$this->restapi->error("Password dan konfirmasi password tidak cocok");
				return;
			}

			$check 				= AuthModel::where('username',$this->input->post('username'))->first();

			if($check){
				if($check->id!==$auth->id){
					$this->restapi->error("Opps! Userame Telah Terpakai");
					return;	
				}
			}

			if (!empty($_FILES['image']['name']) && $this->isImage('image')==true) {

				$filename 	= 'ADMIN__'.seo($this->input->post('name')).'__'.date('Ymdhis');

				$upload 	= $this->upload('images/admin','image',$filename);
				if($upload['auth']	== false){
					$this->restapi->error($upload['msg']);
					return;
				}	

				if($auth->image!==""){
					remFile(__DIR__.'/../../public/images/admin/'.$auth->image);
				}

				$auth->image= $upload['msg']['file_name'];
			}
			

			$auth->name				= $this->input->post('name');
			$auth->username			= $this->input->post('username');
			$auth->password 		= DefuseLib::encrypt($this->input->post('password'));
			$auth->ipaddress 		= $this->input->ip_address();
			$auth->lastlog 			= date('Y-m-d H:i:s ');
			$auth->status 			= (null !==$this->input->post('status') ? 'active' : 'blocked');
			if($auth->save()){

				AuthRuleModel::where('id_superuser',$auth->id)->delete();

				if($this->input->post('access_all')){
					$access 				= new AuthRuleModel;
					$access->id_superuser	= $auth->id;
					$access->menu 			= 'all';
					$access->save();
				}
				else {
					foreach ($this->input->post('access') as $result) {
						$access 				= new AuthRuleModel;
						$access->id_superuser	= $auth->id;
						$access->menu 			= $result;
						$access->save();
					}	
				}

				$this->restapi->success("Akun Administrator Di Perbarui");
				return;
			}
		}
		else if ($url=="delete" && $id != null){


			$auth 			= AuthModel::find($id);

			if(!$auth){
				redirect('superuser/auth');
				return;
			}

			AuthRuleModel::where('id_superuser',$auth->id)->delete();

			if($auth->image!=""){
				remFile(__DIR__.'/../../public/images/admin/'.$auth->image);
			}
			
			$auth->delete();

			redirect('superuser/auth');
		}
		else {
			echo $this->blade->draw('admin.auth.index',$data);	
			return;
		}
	}

	public function tos($page="index",$id=null,$nodirect=false){

		$this->middleware->rootAccess('tos',true);
		$data['__MENU'] 	= 'tos';

		if($page=="index"){

			$data['tos'] 	= TosModel::desc()->get();
			echo $this->blade->draw('admin.tos.index',$data);
			return;

		}else if($page=="create"){
			$data['type']	= 'create';
			echo $this->blade->draw('admin.tos.content',$data);
			return;
		}
		else if($page=="created"){

			$this->validation->ajaxRequest('root');

			$rules = [
					    'required' 	=> [
					        ['name'],['description']
					    ]
					  ];

			$validate 	= $this->validation->check($rules,'post');

			if(!$validate->correct){
				$this->restapi->error($validate->data);
				return;
			}

			$tos 				= new TosModel;
			$tos->name 			= $this->input->post('name');
			$tos->description 	= $this->input->post('description');

			if(!$tos->save()){
				$this->restapi->error("maaf ada kesalahan silahkan coba kembali");
				return;
			}

			$this->restapi->success("data baru di tambahkan");
			return;
		}
		else if($page=="update" && $id!=null){

			$tos 		= TosModel::find($id);

			if(!$tos){
				$this->rootdata->show_404();
			}

			$data['tos'] 	= $tos;
			$data['type']	= 'update';
			echo $this->blade->draw('admin.tos.content',$data);
			return;
		}
		else if($page=="updated"){
			$this->validation->ajaxRequest('root');

			$rules = [
					    'required' 	=> [
					       ['tos'],['name'],['description']
					    ]
					  ];

			$validate 	= $this->validation->check($rules,'post');

			if(!$validate->correct){
				$this->restapi->error($validate->data);
				return;
			}

			$tos 				= TosModel::find($this->input->post('tos'));

			if(!$tos){
				$this->restapi->error("maaf TOS tidak di temukan");
				return;
			}


			$tos->name 			= $this->input->post('name');
			$tos->description 	= $this->input->post('description');

			if(!$tos->save()){
				$this->restapi->error("maaf ada kesalahan silahkan coba kembali");
				return;
			}

			$this->restapi->success("data telah di perbarui");
			return;
		}
		else if($page=="bulkaction"){

			if($this->input->server('REQUEST_METHOD') != 'POST'){
				$this->rootdata->show_404();
			}

			$rules = [
					    'required' 	=> [
					        ['action'],['data']
					    ]
					  ];

			$validate 	= $this->validation->check($rules,'post');

			if(!$validate->correct){
				$this->restapi->error($validate->data);
				return;
			}

			$data 			= $this->input->post('data');

			switch ($page) {
				case 'delete':

					$tos 	= TosModel::whereIn('id',$data)->delete();
					$this->validation->setSuccess('Data telah berhasil di hapus');
					redirect('superuser/tos');					

					break;

				default:
					$this->rootdata->show_404();
					break;
			}
		}
		else if($page=="delete" && $id!=null){
			$tos 		= TosModel::find($id);

			if(!$tos){
				$this->rootdata->show_404();
			}

			$tos->delete();
			$this->validation->setSuccess('Data telah berhasil di hapus');
			redirect('superuser/tos');
			return;
		}
	}

	private function transactionfilter(){

		$keyword 				= $this->input->get('q');

		$ava_take 				= ['10','20','40','60','100','all'];
		$take 					= (!in_array($this->input->get('take'),$ava_take)) ? 10 : $this->input->get('take');

		$page 					= (int) ($this->input->get('per_page')) ? $this->input->get('per_page') : 0;

		$ava_by 				= ['created_at','grand_total','status','method'];
		$by 					= (!in_array( $this->input->get('by'),$ava_by)) ? 'created_at' : $this->input->get('by');

		$ava_order 				= ['asc','desc'];
		if($by=="created_at"){
			$order 					= (!in_array($this->input->get('order'),$ava_order)) ? 'desc' : $this->input->get('order');
		}else{
			$order 					= (!in_array($this->input->get('order'),$ava_order)) ? 'asc' : $this->input->get('order');
		}

		$status 				= ['order','cancel','done','approve','confirmation','expired','process'];
		$ava_status 			= $status;

		

		if($this->input->get('status')){
			$status 				= [];
			foreach ($this->input->get('status') as $result) {
				if(in_array($result,$ava_status)){
					$status[] 	= $result;
				}
			}
		}


		$date_start 			= null;
		$date_end 				= null;

		if($this->input->get('daterange')){
			$date_start 		= goExplode($this->input->get('daterange'),'&&',0);
			$date_end 			= goExplode($this->input->get('daterange'),'&&',1);
		}

		$transaction 			= TransactionModel::where('name','LIKE','%'.$keyword.'%')
									->whereIn('status',$status);

		if($date_start!=null && $date_end!=null){
			$transaction 		= $transaction->whereBetween('created_at', array($date_start, $date_end));
		}

		$total  				= $transaction->get()->count();

		$transaction 			= $transaction->orderBy($by,$order)->take($take)->skip($page*$take)->get();

		$link 					= preg_replace('~(\?|&)per_page=[^&]*~','',$_SERVER['REQUEST_URI']);
		$paginate				= new Aksa_pagination;
		$pagination 			= $paginate->paginate($link,5,$take,$total,$page);

		$text_query 			= '';

		if($keyword){
			$text_query 		= 'Kata kunci "'.$keyword.'" ,';
		}

		$data					= [
									'keyword' 	=> $keyword,
									'take' 		=> $take,
									'page' 		=> $page,
									'by'		=> $by,
									'status'	=> $status,
									'order' 	=> $order,
									'daterange'	=> [$date_start,$date_end]
								  ];

		$data['transaction'] 	= null;
		$data['total'] 			= $total;
		$data['text_query'] 	= $text_query;
		$data['pagination'] 	= $pagination;

		$data 					= toObject($data);
		$data->transaction 		= $transaction;

		return $data;

	}

	public function transaction($page="index",$id=null,$nodirect=false){
		$this->middleware->rootAccess('transaction',true);

		$data['__MENU'] 		= 'transaction';

		if($page=="index"){
			$data['search'] 	= $this->transactionfilter();
			echo $this->blade->draw('admin.transaction.index',$data);
			return;

		}else if($page=="detail" && $id!=null){

			$transaction 		= TransactionModel::find($id);

			if(!$transaction){
				$this->rootdata->show_404();
			}

			$transaction->readed 	= 1;
			$transaction->save();

			$data['transaction']	= $transaction;
			echo $this->blade->draw('admin.transaction.content',$data);
			return;			

		}
		else if($page=="bulkaction"){

			if($this->input->server('REQUEST_METHOD') != 'POST'){
				$this->rootdata->show_404();
			}

			$rules = [
					    'required' 	=> [
					        ['action'],['data']
					    ]
					  ];

			$validate 	= $this->validation->check($rules,'post');

			if(!$validate->correct){
				$this->restapi->error($validate->data);
				return;
			}

			$data 			= $this->input->post('data');
			$transaction 	= TransactionModel::whereIn('id',$data)->get();

			switch ($page) {
				case 'delete':

					foreach ($transaction as $result) {
						foreach ($transaction->confirmations as $key => $value) {
							$this->confirmation('delete',$value->id,true);
						}
					}

					TransactionModel::whereIn('id',$data)->delete();
					$this->validation->setSuccess('Data telah berhasil di hapus');
					redirect('superuser/transaction');					

					break;
				case 'status_order':
					TransactionModel::whereIn('id',$data)->update(['status'=>'order']);
					$this->validation->setSuccess('Data telah berhasil di perbarui');
					redirect('superuser/transaction');										
					break;
				case 'status_approve':
					foreach ($transaction as $result) {
						$mail 					= new Magicmailer;
						$email['transaction'] 	= $result;
						$mail->addAddress($result->email,$result->name);
					    $mail->Body    			= $this->blade->draw('email.transaction.approve',$email);	
					    $mail->Subject 			= 'Transaksi Terkonfirmasi';
				    	$mail->AltBody 			= 'Pembayaran transaksi telah terkonfirmasi';
						if($mail->send()){
							TransactionModel::where('id',$result->id)->update(['status'=>'approve']);
						}
					}

					$this->validation->setSuccess('Transaksi telah di kornfirmasi');
					redirect('superuser/transaction');										
					break;
				case 'status_process':
					TransactionModel::whereIn('id',$data)->update(['status'=>'process']);
					$this->validation->setSuccess('Status transaksi telah di ubah ke proses');
					redirect('superuser/transaction');										
					break;
				case 'status_cancel':

					$rules = [
					    'required' 	=> [
					        ['reason']
					    ]
					  ];

					$validate 	= $this->validation->check($rules,'post');

					if(!$validate->correct){
						$this->validation->setError('alasan','Alasan pembatalan transaksi');
						redirect('superuser/transaction');		
					}

					$reason 		= $this->input->post('reason');

					foreach ($transaction as $result) {
						$mail 					= new Magicmailer;
						$email['transaction'] 	= $result;
						$email['reason'] 		= $reason;
						$mail->addAddress($result->email,$result->name);
					    $mail->Body    			= $this->blade->draw('email.transaction.cancel',$email);	
					    $mail->Subject 			= 'Transaksi Di Batalkan';
				    	$mail->AltBody 			= 'Mohon maaf transaksi anda telah kami batalkan';

						if($mail->send()){
							TransactionModel::where('id',$result->id)->update(['status'=>'cancel','cancel_reason'=>$reason]);
						}
					}

					$this->validation->setSuccess('Transaksi berhasil di batalkan ');
					redirect('superuser/transaction');		
					break;
				default:
					$this->rootdata->show_404();
					break;
			}
		}
		else if ($page=="delete" && $id!=null){

			$transaction 		= TransactionModel::find($id);

			if(!$transaction){
				$this->rootdata->show_404();
			}

			foreach ($transaction->confirmations as $key => $value) {
				$this->confirmation('delete',$value->id,true);
			}

			$transaction->delete();

			if($nodirect){
				return;
			}

			$this->validation->setSuccess('Data telah di hapus');
			redirect('superuser/transaction');
		}
	}

	public function user($page="index",$id=null,$nodirect=false){
		$this->middleware->rootAccess('user',true);

		$data['__MENU'] 		= 'user';

		if($page=="index"){

			$data['user'] 		= UserModel::desc()->get();
			echo $this->blade->draw('admin.user.index',$data);
			return;

		}else if($page=="detail" && $id!=null){

			$user 			= UserModel::find($id);

			if(!$user){
				$this->rootdata->show_404();
			}

			$user->readed 	= 1;
			$user->save();

			$data['user']	= $user;
			echo $this->blade->draw('admin.user.content',$data);
			return;			

		}
		else if($page=="bulkaction"){

			if($this->input->server('REQUEST_METHOD') != 'POST'){
				$this->rootdata->show_404();
			}

			$rules = [
					    'required' 	=> [
					        ['action'],['data']
					    ]
					  ];

			$validate 	= $this->validation->check($rules,'post');

			if(!$validate->correct){
				$this->restapi->error($validate->data);
				return;
			}

			$data 			= $this->input->post('data');
			$user 			= UserModel::whereIn('id',$data)->get();

			switch ($page) {
				case 'delete':

					foreach ($user as $result) {

						if($result->image!=""){
							remFile(content_dir('images/lg/users/'.$result->image));
							remFile(content_dir('images/md/users/'.$result->image));
							remFile(content_dir('images/sm/users/'.$result->image));
							remFile(content_dir('images/xs/users/'.$result->image));
						}
					}

					UserModel::whereIn('id',$data)->delete();
					$this->validation->setSuccess('Data telah berhasil di hapus');
					redirect('superuser/user');					

					break;
				case 'status_active':
					UserModel::whereIn('id',$data)->update(['status'=>'active']);
					$this->validation->setSuccess('Data User telah berhasil di aktifkan');
					redirect('superuser/user');										
					break;
				case 'status_blocked':
					UserModel::whereIn('id',$data)->update(['status'=>'blocked']);
					$this->validation->setSuccess('Data User telah berhasil di blokir');
					redirect('superuser/user');										
					break;
				default:
					$this->rootdata->show_404();
					break;
			}
		}
		else if ($page=="delete" && $id!=null){

			$user 		= UserModel::find($id);

			if(!$user){
				$this->rootdata->show_404();
			}

			if($user->image!=""){
				remFile(content_dir('images/lg/users/'.$user->image));
				remFile(content_dir('images/md/users/'.$user->image));
				remFile(content_dir('images/sm/users/'.$user->image));
				remFile(content_dir('images/xs/users/'.$user->image));
			}

			$user->delete();

			if($nodirect){
				return;
			}

			$this->validation->setSuccess('Data telah di hapus');
			redirect('superuser/user');
		}
	}

	public function vendor($page="index",$id=null,$nodirect=false){
		$this->middleware->rootAccess('vendor',true);

		$data['__MENU'] 		= 'vendor';

		if($page=="index"){

			$data['vendor'] 	= VendorModel::desc()->get();
			echo $this->blade->draw('admin.vendor.index',$data);
			return;

		}else if($page=="detail" && $id!=null){

			$vendor 			= VendorModel::find($id);

			if(!$vendor){
				$this->rootdata->show_404();
			}

			$vendor->readed 	= 1;
			$vendor->save();

			$data['vendor']		= $vendor;
			echo $this->blade->draw('admin.vendor.content',$data);
			return;			

		}
		else if($page=="bulkaction"){

			if($this->input->server('REQUEST_METHOD') != 'POST'){
				$this->rootdata->show_404();
			}

			$rules = [
					    'required' 	=> [
					        ['action'],['data']
					    ]
					  ];

			$validate 	= $this->validation->check($rules,'post');

			if(!$validate->correct){
				$this->restapi->error($validate->data);
				return;
			}

			$data 			= $this->input->post('data');
			$vendor 			= VendorModel::whereIn('id',$data)->get();

			switch ($page) {
				case 'delete':

					foreach ($vendor as $result) {

						if($result->image!=""){
							remFile(content_dir('images/lg/vendors/'.$result->image));
							remFile(content_dir('images/md/vendors/'.$result->image));
							remFile(content_dir('images/sm/vendors/'.$result->image));
							remFile(content_dir('images/xs/vendors/'.$result->image));
						}

						foreach ($this->products as $value) {
							$this->product('delete',$value->id,true);
						}
					}

					VendorModel::whereIn('id',$data)->delete();
					$this->validation->setSuccess('Data Toko telah berhasil di hapus');
					redirect('superuser/vendor');					

					break;
				case 'status_active':

					VendorModel::whereIn('id',$data)->update(['status'=>'active']);
					$this->validation->setSuccess('Data Toko telah berhasil di aktifkan');
					redirect('superuser/vendor');										
					break;

				case 'status_blocked':

					VendorModel::whereIn('id',$data)->update(['status'=>'blocked']);
					$this->validation->setSuccess('Data Toko telah berhasil di blokir');
					redirect('superuser/vendor');										
					break;

				default:
					$this->rootdata->show_404();
					break;
			}
		}
		else if ($page=="delete" && $id!=null){

			$vendor 		= VendorModel::find($id);

			if(!$vendor){
				$this->rootdata->show_404();
			}

			if($vendor->image!=""){
				remFile(content_dir('images/lg/vendors/'.$vendor->image));
				remFile(content_dir('images/md/vendors/'.$vendor->image));
				remFile(content_dir('images/sm/vendors/'.$vendor->image));
				remFile(content_dir('images/xs/vendors/'.$vendor->image));
			}

			$vendor->delete();

			if($nodirect){
				return;
			}

			$this->validation->setSuccess('Data telah di hapus');
			redirect('superuser/vendor');
		}
	}


	public function apicategory($page="index",$id=null){
		$this->middleware->rootAccess('apiservice',true);

		$data['__MENU']			= 'apicategory';

		if($page=="index"){
			$data['category'] 	= ApiCategoryModel::desc()->get();
			echo $this->blade->draw('admin.apicategory.index',$data);
			return;

		}
		else if($page=="create"){
			
			$data['__MENU']		= 'apicategory_content';			
			$data['type']		= 'create';
			$data['note'] 		= 'Buat Kategori API baru';
			$data['url'] 		= '/superuser/apicategory/created';

			echo $this->blade->draw('admin.apicategory.content',$data);
			return;

		}
		else if($page=="update" && $id!=null){

			$category 			= ApiCategoryModel::find($id);

			if(!$category){
				$this->rootdata->show_404();	
			}

			$data['__MENU']		= 'apicategory_content';			
			$data['type']		= 'update';
			$data['note'] 		= 'Ubah data kategori API';
			$data['url'] 		= '/superuser/apicategory/updated';
			$data['category'] 	= $category;

			echo $this->blade->draw('admin.apicategory.content',$data);
			return;

		}else if($page=="bulkaction"){

			$rules = [
				    'required' 	=> [
				        ['action'],['data']
				    ]
				  ];

			$validate 	= $this->validation->check($rules,'post');

			if(!$validate->correct){
				if($this->input->is_ajax_request()){
					$this->restapi->error($validate->data);
				}else{
					$this->rootdata->show_404();
				}
			}

			$action 		= $this->input->post('action');
			$category 		= ApiCategoryModel::whereIn('id',$this->input->post('data'))->get();

			if(count($category)<=0){
				if($this->input->is_ajax_request()){
					$this->restapi->error("no data selected");
				}else{
					$this->rootdata->show_404();
				}
			}

			switch ($action) {
				case 'delete':

					ApiCategoryModel::whereIn('id',$this->input->post('data'))->delete();

					if(!$this->input->is_ajax_request()){
						$this->validation->setSuccess('data deleted');	
						redirect('superuser/apicategory');
					}else{
						$this->restapi->success("data deleted");
					}

					break;
				default:
					$this->rootdata->show_404();
					break;
			}

		}
		elseif ($page=="delete" && $id!=null) {

			$category 			= ApiCategoryModel::find($id);

			if(!$category){
				$this->rootdata->show_404();	
			}

			$category->delete();
			$this->validation->setSuccess('Data telah terhapus!');
			redirect('superuser/apicategory');

		}
		else if($page=="created"){

			$this->validation->ajaxRequest('root');

			$rules = [
					    'required' 	=> [
					        ['name']
					    ]
					  ];

			$validate 	= $this->validation->check($rules,'post');

			if(!$validate->correct){
				$this->restapi->error($validate->data);
				return;
			}

			$category 				= new ApiCategoryModel;
			$category->name 		= $this->input->post('name');
			$category->description 	= $this->input->post('description');

			if(!$category->save()){
				$this->restapi->error("maaf ada kesalahan silahkan coba kembali");
			}

			$this->validation->setSuccess("kategori API telah di tambahkan");
			$this->restapi->success("/superuser/apicategory");

		}
		else if($page=="updated"){

			$this->validation->ajaxRequest('root');

			$rules = [
					    'required' 	=> [
					        ['id'],['name']
					    ]
					  ];

			$validate 	= $this->validation->check($rules,'post');

			if(!$validate->correct){
				$this->restapi->error($validate->data);
				return;
			}

			$category 			= ApiCategoryModel::find($this->input->post('id'));

			if(!$category){
				$this->rootdata->show_404();
			}

			$category->name 		= $this->input->post('name');
			$category->description 	= $this->input->post('description');
			$category->save();

			$this->validation->setSuccess("API category telah di perbarui");
			$this->restapi->success("/superuser/apicategory");
		}
		else{
			$this->rootdata->show_404();
		}

	}

	public function api($page="index",$id=null){
		$this->middleware->rootAccess('apiservice',true);

		$data['__MENU']			= 'api';

		if($page=="index"){
			$data['category'] 		= ApiCategoryModel::asc('name')->get();
			echo $this->blade->draw('admin.api.index',$data);
			return;

		}
		else if($page=="create"){

			$data['__MENU']		= 'api_content';
			$data['type']		= 'create';
			$data['note'] 		= 'Buat API baru';
			$data['url'] 		= '/superuser/api/created';
			$data['category'] 	= ApiCategoryModel::asc('name')->get();

			echo $this->blade->draw('admin.api.content',$data);
			return;

		}
		else if($page=="update" && $id!=null){

			$api 			= ApiModel::find($id);

			if(!$api){
				$this->rootdata->show_404();	
			}

			$data['type']		= 'update';
			$data['note'] 		= 'Ubah data kategori API';
			$data['url'] 		= '/superuser/api/updated';
			$data['api'] 		= $api;
			$data['category'] 	= ApiCategoryModel::asc('name')->get();

			echo $this->blade->draw('admin.api.content',$data);
			return;

		}else if($page=="bulkaction"){

			$rules = [
					    'required' 	=> [
					        ['action'],['data']
					    ]
					  ];

			$validate 	= $this->validation->check($rules,'post');

			if(!$validate->correct){
				if($this->input->is_ajax_request()){
					$this->restapi->error($validate->data);
				}else{
					$this->rootdata->show_404();
				}
			}

			$action 	= $this->input->post('action');
			$api 		= ApiModel::whereIn('id',$this->input->post('data'))->get();

			if(count($api)<=0){
				if($this->input->is_ajax_request()){
					$this->restapi->error("no data selected");
				}else{
					$this->rootdata->show_404();
				}
			}

			switch ($action) {
				case 'ready':

					ApiModel::whereIn('id',$this->input->post('data'))->update(['status'=>'ready']);

					if(!$this->input->is_ajax_request()){
						$this->validation->setSuccess("di rubah ke 'ready'");	
						redirect('superuser/api');
					}else{
						$this->restapi->success("di ubah ke 'ready'");
					}
					break;

				case 'pending':

					ApiModel::whereIn('id',$this->input->post('data'))->update(['status'=>'pending']);

					if(!$this->input->is_ajax_request()){
						$this->validation->setSuccess("di rubah ke 'pending'");	
						redirect('superuser/api');
					}else{
						$this->restapi->success("di ubah ke 'pending'");

					}
					
					break;
				case 'error':

					ApiModel::whereIn('id',$this->input->post('data'))->update(['status'=>'pending']);

					if(!$this->input->is_ajax_request()){
						$this->validation->setSuccess("di rubah ke 'pending'");	
						redirect('superuser/api');
					}else{
						$this->restapi->success("di ubah ke 'pending'");

					}
					
					break;
				case 'delete':

					ApiModel::whereIn('id',$this->input->post('data'))->delete();

					if(!$this->input->is_ajax_request()){
						$this->validation->setSuccess('data deleted');	
						redirect('superuser/api');
					}else{
						$this->restapi->success("data deleted");
					}

					break;
				default:
					$this->rootdata->show_404();
					break;
			}

		}
		elseif ($page=="delete" && $id!=null) {

			$api 			= ApiModel::find($id);

			if(!$api){
				$this->rootdata->show_404();	
			}

			$api->delete();
			$this->validation->setSuccess('Data telah terhapus!');
			redirect('superuser/api');

		}
		else if($page=="created"){

			$this->validation->ajaxRequest('root');

			$rules = [
					    'required' 	=> [
					        ['name'],['description'],['category'],['status'],['method'],['url']
					    ]
					  ];

			$validate 	= $this->validation->check($rules,'post');

			if(!$validate->correct){
				$this->restapi->error($validate->data);
			}

			$category 			= ApiCategoryModel::find($this->input->post('category'));

			if(!$category){
				$this->restapi->error("maaf kategori API tidak ditemukan");	
			}

			$ava_method 		= ['post','get','put','delete'];
			$ava_status 		= ['ready','pending','error'];

			$api 				= new ApiModel;
			$api->id_category 	= $category->id;
			$api->name 			= $this->input->post('name');
			$api->description 	= $this->input->post('description');

			if(!in_array($this->input->post('method'), $ava_method)){
				$this->restapi->error("Maaf method tidak di temukan");
			}

			if(!in_array($this->input->post('status'), $ava_status)){
				$this->restapi->error("Maaf status tidak di temukan");
			}

			$api->key_required 	= ($this->input->post('api_required')) ? 1 : 0;
			$api->auth_required 	= ($this->input->post('auth_required')) ? 1 : 0;
			$api->url 			= $this->input->post('url');
			$api->method 		= $this->input->post('method');
			$api->status 		= $this->input->post('status');

			if(!$api->save()){
				$this->restapi->error("maaf ada kesalahan silahkan coba kembali");
			}

			$data_name 				= $this->input->post('data_name');
			$data_method 			= $this->input->post('data_method');
			$data_description 		= $this->input->post('data_description');
			$data_required 			= $this->input->post('data_required');


			if($this->input->post('data_name')){
				foreach ($data_name as $key => $result) {

					if(!isset($data_method[$key]) || !isset($data_description[$key])){
						continue;
					}

					$data_api 					= new ApiDataModel;
					$data_api->id_apiservice 	= $api->id;
					$data_api->name 			= $result;
					$data_api->method 			= $data_method[$key];
					$data_api->description 		= $data_description[$key];
					$data_api->required 		= (isset($data_required[$key])) ? 1 : 0;
					$data_api->save();
					
				}
			}

			

			$this->validation->setSuccess("Data API baru telah di tambahkan");
			$this->restapi->success("/superuser/api");

		}
		else if($page=="updated"){

			$this->validation->ajaxRequest('root');

			$rules = [
					    'required' 	=> [
					        ['id'],['name'],['description'],['category'],['status'],['method'],['url']
					    ]
					  ];

			$validate 	= $this->validation->check($rules,'post');

			if(!$validate->correct){
				$this->restapi->error($validate->data);
				return;
			}

			$api 				= ApiModel::find($this->input->post('id'));

			if(!$api){
				$this->restapi->error("Maaf data API tidak di temukan");
			}

			$category 			= ApiCategoryModel::find($this->input->post('category'));

			if(!$category){
				$this->restapi->error("maaf kategori API tidak ditemukan");	
			}

			$ava_method 		= ['post','get','put','delete'];
			$ava_status 		= ['ready','pending','error'];

			$api->id_category 	= $category->id;
			$api->name 			= $this->input->post('name');
			$api->description 	= $this->input->post('description');

			if(!in_array($this->input->post('method'), $ava_method)){
				$this->restapi->error("Maaf method tidak di temukan");
			}

			if(!in_array($this->input->post('status'), $ava_status)){
				$this->restapi->error("Maaf status tidak di temukan");
			}

			$api->status 		= $this->input->post('status');
			$api->key_required 	= ($this->input->post('api_required')) ? 1 : 0;
			$api->auth_required 	= ($this->input->post('auth_required')) ? 1 : 0;
			$api->url 			= $this->input->post('url');
			$api->save();

			ApiDataModel::where('id_apiservice',$api->id)->delete();

			$data_name 				= $this->input->post('data_name');
			$data_method 			= $this->input->post('data_method');
			$data_description 		= $this->input->post('data_description');
			$data_required 			= $this->input->post('data_required');


			if($this->input->post('data_name')){
				foreach ($data_name as $key => $result) {

					if(!isset($data_method[$key]) || !isset($data_description[$key])){
						continue;
					}

					$data_api 					= new ApiDataModel;
					$data_api->id_apiservice 	= $api->id;
					$data_api->name 			= $result;
					$data_api->method 			= $data_method[$key];
					$data_api->description 		= $data_description[$key];
					$data_api->required 		= (isset($data_required[$key])) ? 1 : 0;
					$data_api->save();
					
				}
			}

			$this->validation->setSuccess("API api telah di perbarui");
			$this->restapi->success("/superuser/api");
		}
		else{
			$this->rootdata->show_404();
		}

	}


}
