<?php

/**
 * Productos Model.
 */
class Productos_model extends CI_Model {

	# save $data on 'productos'
	function save($data) {
		
		$this->db->set('codigo', $data['codigo']);
		$this->db->set('peso', $data['peso']);
		$this->db->set('descripcion', $data['descripcion']);
		$this->db->set('tipo_impuesto_id', $data['tipo_impuesto_id']);
		$this->db->set('empresa', $data['empresa']);
		if($data['id'] == NULL) {
			$this->db->set('created_at', date('Y-m-d h:i:s',time()));
			$this->db->insert('productos');
		} else {
			$this->db->where('id', $data['id']);
			$this->db->set('updated_at', date('Y-m-d h:i:s',time()));
			$this->db->update('productos');
		}

		return $this->db->affected_rows();
	}

	# retrives $data from 'productos'
	function find($id = NULL) {
		if($id != NULL) {
			$this->db->where('id', $id);
			return $this->db->get('productos')->row();
		} else {
			return $this->db->get('productos')->result();
		}
	}

	# destroy $data from  'productos'
	function destroy($id) {
		$this->db->where('id', $id);
		$this->db->delete('productos');

		return $this->db->affected_rows();
	}

}
