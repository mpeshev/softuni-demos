<?php

namespace Models;

class Album_Model extends Master_Model {

	public function __construct( $args = array() ) {
		parent::__construct( array( 'table' => 'albums' ) );
	}
}