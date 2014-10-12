<?php

namespace Admin\Controllers;

class Albums_Controller extends Admin_Controller {
	
	public function __construct() {
		parent::__construct( get_class(),
				 'album', '/views/admin/albums/' );
	}
	
	public function index() {
		$albums = $this->model->find();
		
		$template_name = DX_ROOT_DIR . $this->views_dir . 'index.php';
		
		include_once $this->layout;
	}
	
	public function edit( $id ) {
		if( ! empty( $_POST['name'] ) 
				&& ! empty( $_POST['year'] )
				&& ! empty( $_POST['id'] ) ) {
			$name = $_POST['name'];
			$year = $_POST['year'];
			$id = $_POST['id'];
			
			$album = array(
					'id' => $id,
					'name' => $name,
					'year' => $year
			);
			
			$this->model->update( $album );
		}
		
		$album = $this->model->get( $id );
		
		if( empty( $album ) ) {
			// die( 'Nothing to edit here.' );
			header( 'Location: ' . DX_URL );
			exit;
		}
		
		$album = $album[0];
		
		$template_name = DX_ROOT_DIR . $this->views_dir . 'edit.php';
		
		include_once $this->layout;
	}
	
	public function add() {
		if( ! empty( $_POST['name'] ) 
				&& ! empty( $_POST['year'] )
				&& ! empty( $_POST['artist_id'] ) ) {
			$name = $_POST['name'];
			$year = $_POST['year'];
			$artist_id = $_POST['artist_id'];
			
			$album = array(
				'name' => $name,
				'year' => $year,
				'artist_id' => $artist_id
			);
			
			$this->model->add( $album );
		}
		
		$template_name = DX_ROOT_DIR . $this->views_dir . 'add.php';
		
		include_once $this->layout;
	}
	
	public function view( $id ) {
		$albums = $this->model->get( $id );
		
		if( empty( $albums ) ) {
// 			die( 'No album to view here.' );
			header( 'Location: ' . DX_URL );
			exit;
		}
		
		$album = $albums[0];
		
		$artist_id = $album['artist_id'];
		include  DX_ROOT_DIR . '/models/artist.php';
		$artist_model = new \Models\Artist_Model();
		
		$artists = $artist_model->get( $artist_id );
		$artist = $artists[0];
		
		$template_name = DX_ROOT_DIR . $this->views_dir . 'view.php';
		
		include_once $this->layout;
	}
}