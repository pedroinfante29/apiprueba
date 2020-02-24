<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->library('xmlrpc');
		$url = 'http://localhost:8080/pruebaapi/inserttravelXML';
		$this->xmlrpc->server($url, 8080);
		$this->load->model('pruebaapi_model', '', true);
	}

	public function index()
	{
		/** @var pruebaapi_model $pruebaapi_model */

		$pruebaapi_model = $this->pruebaapi_model;
		$listTravel = array(
			'datos' => $pruebaapi_model->getTravel()
		);
		$this->load->view('welcome_message', $listTravel);
		//		header('Location: ../welcome/index/');
	}

	public function deleteclientWeb()
	{
		/** @var pruebaapi_model $pruebaapi_model */

		$pruebaapi_model = $this->pruebaapi_model;
		$fechaActual = date('Y-m-d\Th:m:s');
		$post = $this->input->get();

		$deleteClient = $pruebaapi_model->deleteClientWeb($post['email']);
		if ($deleteClient !== false) {
			header('Location: ../welcome/index/');
		}


	}

	public function publish()
	{
		echo "entro 1";
		$post = $this->input->post();
		$pais = $post['pais'];
		$ciudad = $post['ciudad'];
		$fechaviaje = $post['fechaviaje'];
		$email = $post['email'];

		$this->xmlrpc->method('publishPost');
		$request = [
			[$pais, 'string'],
			[$ciudad, 'string'],
			[$fechaviaje, 'dateTime.iso8601'],
			[$email, 'string']
		];
		$this->xmlrpc->request($request);

		if (!$this->xmlrpc->send_request()) {
			echo "entro 2";
			$response = [
				[
					'message' => 'Error!!!!!!!!!!!!!!'
				], 'struct'
			];
			return $this->xmlrpc->send_response($response);
		} else {
			echo "entro 3";
			$response = [
				[
					'message' => 'Procesado Exitosamente'
				], 'struct'
			];
			return $this->xmlrpc->send_response($response);
		}
	}
}
