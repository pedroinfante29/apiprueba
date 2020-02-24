<?php

use Restserver\Libraries\REST_Controller;

defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . '/libraries/REST_Controller.php';
require_once APPPATH . '/libraries/Format.php';

class Restserver extends REST_Controller {
	public function index_get(){
		$array = array("Hola", "Mundo", "CodeIgniter");
		$this->response($array);
	}
}
