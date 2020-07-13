<?php

/**
 * Impuestos Model.
 */
class Impuestos_model extends CI_Model {

	# save $data on 'impuestos'
	function save($data) {
		
		$this->db->set('concepto', $data['concepto']);
		$this->db->set('sp', $data['sp']);
		$this->db->set('otro_municipio', $data['otro_municipio']);
		$this->db->set('otra_provincia', $data['otra_provincia']);
		$this->db->set('tipo', $data['tipo']);

		if($data['id'] == NULL) {
			$this->db->set('created_at', date('Y-m-d h:i:s',time()));
			$this->db->insert('impuestos');
		} else {
			$this->db->where('id', $data['id']);
			$this->db->set('updated_at', date('Y-m-d h:i:s',time()));
			$this->db->update('impuestos');
		}

		return $this->db->affected_rows();
	}

	# retrives $data from 'impuestos'
	function find($id = NULL) {
		if($id != NULL) {
			$this->db->where('id', $id);
			return $this->db->get('impuestos')->row();
		} else {
			return $this->db->get('impuestos')->result();
		}
	}

	# destroy $data from  'impuestos'
	function destroy($id) {
		$this->db->where('id', $id);
		$this->db->delete('impuestos');

		return $this->db->affected_rows();
	}

}
