<?php

namespace Controllers;

class Artists_Controller extends Master_Controller {
	
	public function __construct() {
		parent::__construct( get_class(),
				 'artist', '/views/artists/' );
	}
	
	public function index() {
		$artists = $this->model->find();
		
		$template_name = DX_ROOT_DIR . $this->views_dir . 'index.php';
		
		include_once $this->layout;
	}
	
	public function view( $id ) {
		$artists = $this->model->get( $id );
		
		var_dump($artists); die();
		
		$template_name = DX_ROOT_DIR . $this->views_dir . 'index.php';
		
		include_once $this->layout;
	}
	
	public function dve() {
		
		$template_name = DX_ROOT_DIR . $this->views_dir . 'dve.php';
		
		include_once $this->layout;
	}
	
	public function tri() {
		$template_name =  DX_ROOT_DIR . $this->views_dir . 'tri.php';
		
		include_once $this->layout;
	}
}