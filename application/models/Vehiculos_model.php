<?php

/**
 * Vehiculos Model.
 */
class Vehiculos_model extends CI_Model {

	# save $data on 'vehiculos'
	function save($data) {
		
		$this->db->set('dominio', $data['dominio']);
		$this->db->set('titular', $data['titular']);
		$this->db->set('marca', $data['marca']);
		$this->db->set('tipo', $data['tipo']);
		$this->db->set('modelo', $data['modelo']);
		$this->db->set('tipo_documento', $data['tipo_documento']);
		$this->db->set('nro_documento', $data['nro_documento']);
		$this->db->set('domicilio', $data['domicilio']);
		$this->db->set('localidad', $data['localidad']);
		$this->db->set('provincia', $data['provincia']);
		$this->db->set('tipo_vehiculo', $data['tipo_vehiculo']);
		$this->db->set('eje_simple', $data['eje_simple']);
		$this->db->set('eje_doble', $data['eje_doble']);
		$this->db->set('frio', $data['frio']);
		if($data['id'] == NULL) {
			$this->db->set('created_at', date('Y-m-d h:i:s',time()));
			$this->db->insert('vehiculos');
		} else {
			$this->db->where('id', $data['id']);
			$this->db->set('updated_at', date('Y-m-d h:i:s',time()));
			$this->db->update('vehiculos');
		}

		return $this->db->affected_rows();
	}

	# retrives $data from 'vehiculos'
	function find($id = NULL) {
		if($id != NULL) {
			$this->db->where('id', $id);
			return $this->db->get('vehiculos')->row();
		} else {
			return $this->db->get('vehiculos')->result();
		}
	}

	# destroy $data from  'vehiculos'
	function destroy($id) {
		$this->db->where('id', $id);
		$this->db->delete('vehiculos');

		return $this->db->affected_rows();
	}

	public function getTipoVehiculo()
    {
      $query = $this->db
      ->select("*")
      ->from("tipo_vehiculo")
      ->get();
      //die($this->db->last_query());
      return $query->result();
    }

    public function getProvincia()
    {
      $query = $this->db
      ->select("*")
      ->from("provincias")
      ->get();
      //die($this->db->last_query());
      return $query->result();
    }

}
