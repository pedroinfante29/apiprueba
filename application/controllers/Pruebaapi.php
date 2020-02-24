<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Pruebaapi extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->library('xmlrpc');
		$this->load->library('xmlrpcs');
		$this->load->model('pruebaapi_model', '', true);
	}

	/**
	 * @return mixed
	 */
	public function insertclient()
	{
		/** @var pruebaapi_model $pruebaapi_model */

		$pruebaapi_model	= $this->pruebaapi_model;
		$fechaActual 		= date('Y-m-d\Th:m:s');
		$post				= $this->input->post();

		$data = array(
			'datereg'	=> $fechaActual,
			'nombre'	=> $post['nombre'],
			'apellidos' => $post['apellidos'],
			'telefono'	=> $post['telefono'],
			'email'		=> $post['email'],
			'direccion'	=> $post['direccion'],
		);
		$selectclient = $pruebaapi_model->validaClient($data);

		if ($selectclient === false) {
			$addCliente = $pruebaapi_model->addCliente($data);
			if ($addCliente !== false) {
				return $this->output
					->set_content_type('application/json')
					->set_output(
						json_encode(
							[
								'status' => array(
									'code'	=> '200',
									'ok'	=> 'true',
									'id'	=> $addCliente
								),
								'message'	=> "Cliente Creado"
							]
						)
					);

			}
			return $this->output
				->set_content_type('application/json')
				->set_output(
					json_encode(
						[
							'status' => array(
								'code'	=> '412',
								'ok'	=> 'false',
							),
							'error' => 'Error, algo salio mal al crear el cliente'
						]
					)
				);
		}
		return $this->output
			->set_content_type('application/json')
			->set_output(
				json_encode(
					[
						'status' => array(
							'code'	=> '203',
							'ok'	=> 'false',
						),
						'error' => 'Error, Email y/o telefono ya estan registrados.'
					]
				)
			);
	}

	/**
	 * @return mixed
	 */
	public function updateclient()
	{
		/** @var pruebaapi_model $pruebaapi_model */

		$pruebaapi_model	= $this->pruebaapi_model;
		$fechaActual 		= date('Y-m-d\Th:m:s');
		$post				= $this->input->post();

		$data = array(
			'dateupdate'	=> $fechaActual,
			'nombre'		=> $post['nombre'],
			'apellidos' 	=> $post['apellidos'],
			'telefono'		=> $post['telefono'],
			'email'			=> $post['email'],
			'direccion'		=> $post['direccion'],
		);

		$selectclient = $pruebaapi_model->validaClient($data);

		if ($selectclient === true) {
			$addCliente = $pruebaapi_model->updateClient($data);
			if ($addCliente !== false) {
				return $this->output
					->set_content_type('application/json')
					->set_output(
						json_encode(
							[
								'status' => array(
									'code'	=> '200',
									'ok'	=> $addCliente,
								),
								'message'	=> "Cliente Actualizado"
							]
						)
					);

			}
			return $this->output
				->set_content_type('application/json')
				->set_output(
					json_encode(
						[
							'status' => array(
								'code'	=> '412',
								'ok'	=> $addCliente,
							),
							'error' => 'Error, algo salio mal al actualizar el cliente'
						]
					)
				);
		}
		return $this->output
			->set_content_type('application/json')
			->set_output(
				json_encode(
					[
						'status' => array(
							'code'	=>	'203',
							'ok'	=>	$selectclient
						),
						'error' => 'Error, Cliente no esta registrado.'
					]
				)
			);
	}

	/**
	 * @return mixed
	 */
	public function listclient()
	{
		/** @var pruebaapi_model $pruebaapi_model */

		$pruebaapi_model	= $this->pruebaapi_model;
		$fechaActual 		= date('Y-m-d\Th:m:s');
		$post				= $this->input->post();

		$selectclient = $pruebaapi_model->getClient($post['email']);

			if ($selectclient !== false) {
				return $this->output
					->set_content_type('application/json')
					->set_output(
						json_encode($selectclient)
					);

			}
			return $this->output
				->set_content_type('application/json')
				->set_output(
					json_encode(
						[
							'status' => array(
								'code'	=> '412',
								'ok'	=> $selectclient,
							),
							'error' => 'Error, cliente no existe'
						]
					)
				);

	}

	/**
	 * @return mixed
	 */
	public function deleteclient()
	{
		/** @var pruebaapi_model $pruebaapi_model */

		$pruebaapi_model	= $this->pruebaapi_model;
		$fechaActual 		= date('Y-m-d\Th:m:s');
		$post				= $this->input->post();

		$data = array(
			'email'		=> $post['email'],
		);

		if ((!is_null($data['email']) || ($data['email'] === ''))) {

		$selectclient = $pruebaapi_model->validaClient($data);

		if ($selectclient !== false) {

			$deleteClient = $pruebaapi_model->deleteClient($post['email']);

			if ($deleteClient !== false) {
				return $this->output
					->set_content_type('application/json')
					->set_output(
						json_encode(
							[
								'status' => array(
									'code'	=> '200',
									'ok'	=> $deleteClient,
								),
								'message'	=> "Cliente Eliminado"
							]
						)
					);
			}
			return $this->output
				->set_content_type('application/json')
				->set_output(
					json_encode(
						[
							'status' => array(
								'code'	=> '412',
								'ok'	=> $deleteClient,
							),
							'error' => 'Error, Algo salio mal'
						]
					)
				);
		}
		return $this->output
			->set_content_type('application/json')
			->set_output(
				json_encode(
					[
						'status' => array(
							'code'	=> '203',
							'ok'	=> $selectclient,
						),
						'error' => 'Error, cliente no existe'
					]
				)
			);
		}
		return $this->output
			->set_content_type('application/json')
			->set_output(
				json_encode(
					[
						'status' => array(
							'code'	=> '203',
						),
						'error' => 'Error, No hay dato que buscar'
					]
				)
			);
	}

	/**
	 * @return mixed
	 */
	public function inserttravel()

	{
		/** @var pruebaapi_model $pruebaapi_model */

		$pruebaapi_model	= $this->pruebaapi_model;
		$fechaActual 		= date('Y-m-d\Th:m:s');
		$post				= $this->input->post();

		$data = array(
			'pais'			=> $post['pais'],
			'ciudad' 		=> $post['ciudad'],
			'fechaviaje'	=> $post['fechaviaje'],
			'email'			=> $post['email'],
			'fecharegis'	=> $fechaActual,
		);
		$selectclient = $pruebaapi_model->validaClient($data);

		if ($selectclient !== false) {
			$addCliente = $pruebaapi_model->addTravel($data);
			if ($addCliente !== false) {
//				$getTravelXML = $pruebaapi_model->getTravelXML($data['email']);
//				$xml = '<root>';
//				foreach($getTravelXML as $row){
//					$xml .= '<item>
//							 <nombre>'.$row['nombre'].'</nombre>
//							 <apellidos>'.$row['apellidos'].'</apellidos>
//							 <telefono>'.$row['telefono'].'</telefono>
//							 <email>'.$row['email'].'</email>
//							 <pais>'.$row['pais'].'</pais>
//							 <ciudad>'.$row['ciudad'].'</ciudad>
//							 <fechaviaje>'.$row['fechaviaje'].'</fechaviaje>
//						   </item>';
//					}
//				$xml .= '</root>';
//				$this->output->set_content_type('text/xml');
//				$this->output->set_output($xml);

				return $this->output
					->set_content_type('application/json')
					->set_output(
						json_encode(
							[
								'status' => array(
									'code'	=> '200',
									'ok'	=> 'true',
									'id'	=> $addCliente
								),
								'message'	=> "Viaje Creado"
							]
						)
					);

			}
			return $this->output
				->set_content_type('application/json')
				->set_output(
					json_encode(
						[
							'status' => array(
								'code'	=> '412',
								'ok'	=> $addCliente,
							),
							'error' => 'Error, algo salio mal al crear el cliente'
						]
					)
				);
		}
		return $this->output
			->set_content_type('application/json')
			->set_output(
				json_encode(
					[
						'status' => array(
							'code'	=> '203',
							'ok'	=> $selectclient,
						),
						'error' => 'Error, Email no esta registrado.'
					]
				)
			);
	}

	/**
	 * @return mixed
	 */
	public function listtravel()
	{
		/** @var pruebaapi_model $pruebaapi_model */

		$pruebaapi_model	= $this->pruebaapi_model;
		$selectclient = $pruebaapi_model->getTravel();

			return $this->output
				->set_content_type('application/json')
				->set_output(
					json_encode($selectclient)
				);


	}

	public function inserttravelXML()
	{
		$config['functions']['publishPost'] = ['function' => 'Server.publishPost'];
		$this->xmlrpcs->initialize($config);
		$this->xmlrpcs->serve();
	}

	/**
	 * @param $request
	 * @return mixed
	 */
	public function publishPost($request)
	{
		/** @var pruebaapi_model $pruebaapi_model */

		$pruebaapi_model	= $this->pruebaapi_model;
		$data 				= $request->output_parameters();
		$addCliente 		= $pruebaapi_model->addTravel($data);

		if ($addCliente !== false) {
			$response = [
				[
					'message' => 'Procesado Exitosamente'
				],'struct'
			];
			return $this->xmlrpc->send_response($response);
		}
	}

	public function listaApp(){
		$list_clientes = $this->pruebaapi_model->listaApp();
		if(!is_null($list_clientes)){
			echo json_encode($list_clientes);
		} else {
			echo $mensaje = 'Ha ocurrido un Error!';
		}
	}
}
