<?php 
class Aksa_pagination {
	
	function __construct(){
		$this->ci =&get_instance();
		$this->ci->load->library('pagination');
	}

	function paginate($url, $numlinks, $per_page, $number_row,$page=0){

		# iki nggolek onok pirang page
		# misal onok 
		$total_rows = ceil($number_row/$per_page);

		$config = [
			'base_url' => $url,
			'total_rows' => $total_rows,
			'per_page' => 1,
			//'uri_segment' => $uri_segment,
			'first_link' => false,
			'last_link' => false,
			'next_link' => '›',
			'prev_link' => '‹',
			// 'next_link' => '<span class="glyphicon glyphicon-chevron-right"></span>',
			// 'prev_link' => '<span class="glyphicon glyphicon-chevron-left"></span>',
			'cur_page'	=> $page,
			'cur_tag_open' => '<li class="active"><a href="#">',
			'cur_tag_close' => '</a></li>',
			'num_tag_open' => '<li>',
			'num_tag_close' => '</li>',
			'first_tag_open' => '<li>',
			'first_tag_close' => '</li>',
			'last_tag_open' => '<li>',
			'last_tag_close' => '</li>',

			'prev_tag_open' => '<li  class="c-prev">',
			'prev_tag_close' => '</li>',
			'num_links'		=> $numlinks,

			'next_tag_open' => '<li class="c-next">',
			'next_tag_close' => '</li>',
			'page_query_string'=> true,
		];

		/*if (count($_GET) > 0) $config['suffix'] = '?' . http_build_query($_GET, '', "&");
		$config['first_url'] = $config['base_url'].'?'.http_build_query($_GET);*/

		$this->ci->pagination->initialize($config);
		return $this->ci->pagination->create_links();

	}
}