<?php

/**
 * Transportistas Model.
 */
class Transportistas_model extends CI_Model {

	# save $data on 'transportistas'
	function save($data) {
		
		$this->db->set('nombre', $data['nombre']);
		$this->db->set('tipo_doc', $data['tipo_doc']);
		$this->db->set('documento', $data['documento']);
		$this->db->set('cat_licencia', $data['cat_licencia']);
		$this->db->set('licencia', $data['licencia']);

		if($data['id'] == NULL) {
			$this->db->set('created_at', date('Y-m-d h:i:s',time()));
			$this->db->insert('transportistas');
		} else {
			$this->db->where('id', $data['id']);
			$this->db->set('updated_at', date('Y-m-d h:i:s',time()));
			$this->db->update('transportistas');
		}

		return $this->db->affected_rows();
	}

	# retrives $data from 'transportistas'
	function find($id = NULL) {
		if($id != NULL) {
			$this->db->where('id', $id);
			return $this->db->get('transportistas')->row();
		} else {
			return $this->db->get('transportistas')->result();
		}
	}

	# destroy $data from  'transportistas'
	function destroy($id) {
		$this->db->where('id', $id);
		$this->db->delete('transportistas');

		return $this->db->affected_rows();
	}

}
