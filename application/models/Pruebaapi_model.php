<?php

class Pruebaapi_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

	/**
	 * @param array $data
	 * @return bool
	 */
    public function addCliente(array $data)
    {
		$this->db->trans_start();
		$this->db->trans_strict(false);
		$this->db->insert('client', $data);

		$lastID = $this->db->insert_id();
		if ($this->db->trans_status() === false) {
			$this->db->trans_rollback();
			return false;
		}
		$this->db->trans_commit();

        return $lastID;
    }

	/**
	 * @param array $data
	 * @return bool
	 */
	public function updateClient(array $data): bool
	{
		$this->db->trans_start();
		$this->db->trans_strict(false);
		$data = [
			'dateupdate'	=> $data['dateupdate'],
			'nombre'		=> $data['nombre'],
			'apellidos' 	=> $data['apellidos'],
			'telefono'		=> $data['telefono'],
			'email'			=> $data['email'],
			'direccion'		=> $data['direccion'],
		];
		$this->db->set($data)->where('email', $data['email'])->update('client');
		if ($this->db->trans_status() === false) {
			$this->db->trans_rollback();
			return false;
		}
		$this->db->trans_commit();
		return true;
	}

	/**
	 * @param array $data
	 * @return bool
	 */
	public function validaClient(array $data)
	{
		if (!is_null($data['email'])) {
			$query = $this->db->select('*')->from('client')->where('email', $data['email'])->get();
			if ($query->num_rows() === 1) {
				return true;
			}
		}
		return false;
	}

	/**
	 * @param null $email
	 * @return bool
	 */
	public function getClient($email = null)
	{

		if (!is_null($email)) {
			$query = $this->db->select('*')->from('client')->where('email', $email)->get();
			if ($query->num_rows() === 1) {
				return $query->row_array();
			}
			return false;
		}
		$query = $this->db->select('*')->from('client')->get();
		if ($query->num_rows() > 0) {
			return $query->row_array();
		}
		return false;
	}

	/**
	 * @param $email
	 * @return bool
	 */
	public function deleteClient($email)
	{
		$this->db->trans_start();
		$this->db->trans_strict(false);
		$this->db->where('email', $email)->delete('client');
		if ($this->db->trans_status() === false) {
			$this->db->trans_rollback();
			return false;
		}
		$this->db->trans_commit();
		return true;
	}

	/**
	 * @param array $data
	 * @return bool
	 */
	public function addTravel(array $data)
	{
		$this->db->trans_start();
		$this->db->trans_strict(false);
		$this->db->insert('travel_client', $data);

		$lastID = $this->db->insert_id();
		if ($this->db->trans_status() === false) {
			$this->db->trans_rollback();
			return false;
		}
		$this->db->trans_commit();

		return $lastID;
	}

	/**
	 * @return mixed
	 */
	public function getTravel()
	{
		$query = $this->db->query("
									SELECT cl.nombre, cl.apellidos, cl.telefono, cl.email, tc.pais, tc.ciudad, tc.fechaviaje
									FROM travel_client tc, client cl
									WHERE tc.email = cl.email
									AND cl.estado = 1
								");

		return $query->result_array();
	}

	public function deleteClientWeb($email)
	{
		$this->db->trans_start();
		$this->db->trans_strict(false);
		$this->db->query("CALL delete_Client('$email');");
		if ($this->db->trans_status() === false) {
			$this->db->trans_rollback();
			return false;
		}
		$this->db->trans_commit();
		return true;
	}

	public function getTravelXML($email)
	{
		$query = $this->db->query("
									SELECT cl.nombre, cl.apellidos, cl.telefono, cl.email, tc.pais, tc.ciudad, tc.fechaviaje
									FROM travel_client tc, client cl
									WHERE tc.email = cl.email
									AND cl.estado = 1
									AND tc.email = '$email'
								");
		return $query->result_array();
	}

	public function listaApp(){
		return $this->db
			->select('*')
			->from('client')
			->get()
			->result();
	}
}
