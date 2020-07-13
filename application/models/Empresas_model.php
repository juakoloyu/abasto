<?php

/**
 * empresas Model.
 */
class Empresas_model extends CI_Model {

	# save $data on 'empresas'
	function save($data) {
		
		$this->db->set('nombre', $data['nombre']);
		$this->db->set('domicilio', $data['domicilio']);
    $this->db->set('cuit', $data['cuit']);
    $this->db->set('razon_social', $data['razon_social']);
    $this->db->set('propietario', $data['propietario']);
    $this->db->set('ciudad', $data['ciudad']);
    $this->db->set('provincia', $data['provincia']);
    $this->db->set('telefono', $data['telefono']);
    $this->db->set('email', $data['email']);
    $this->db->set('pagina_web', $data['pagina_web']);
    $this->db->set('gerente', $data['gerente']);
    $this->db->set('encargado', $data['encargado']);
    $this->db->set('sector_impuestos', $data['sector_impuestos']);

		if($data['id'] == NULL) {
			$this->db->set('created_at', date('Y-m-d h:i:s',time()));
			$this->db->insert('empresas');
		} else {
			$this->db->where('id', $data['id']);
			$this->db->set('updated_at', date('Y-m-d h:i:s',time()));
			$this->db->update('empresas');
		}

		return $this->db->affected_rows();
	}

	# retrives $data from 'empresas'
	function find($id = NULL) {
		if($id != NULL) {
			$this->db->where('id', $id);
			return $this->db->get('empresas')->row();
		} else {
			return $this->db->get('empresas')->result();
		}
	}

	# destroy $data from  'empresas'
	function destroy($id) {
		$this->db->where('id', $id);
		$this->db->delete('empresas');

		return $this->db->affected_rows();
	}

	public function alimentos($id)
    {
      $query = $this->db
      ->select("SUM(importe) as importe,ingresos_liquidaciones.id,nro_factura,estado_pago,tipo_impuesto,completa, ingresos.id as id_ingreso,fecha,contribuyentes,no_liquidable")
      ->from("ingresos_liquidaciones")
      ->join("ingresos","ingresos_liquidaciones.ingreso_id = ingresos.id")
      ->join("ingresos_liquidaciones_detalle","ingresos_liquidaciones_detalle.ingreso_liquidacion_id = ingresos_liquidaciones.id")
      ->where("responsable_id",$id)
      ->where("tipo_impuesto",1)
      ->group_by("ingresos.id")
      ->get();
      //die($this->db->last_query());
      return $query->result();
    }

    public function derecho_piso($id)
    {
      $query = $this->db
      ->select("SUM(importe) as importe,ingresos_liquidaciones.id,nro_factura,estado_pago,tipo_impuesto,completa, ingresos.id as id_ingreso,fecha,contribuyentes")
      ->from("ingresos_liquidaciones")
      ->join("ingresos","ingresos_liquidaciones.ingreso_id = ingresos.id")
      ->join("ingresos_liquidaciones_detalle","ingresos_liquidaciones_detalle.ingreso_liquidacion_id = ingresos_liquidaciones.id")
      ->where("responsable_id",$id)
      ->where("tipo_impuesto",2)
      ->group_by("ingresos.id")
      ->get();
      //die($this->db->last_query());
      return $query->result();
    }

    /*
    public function getDatosLiquidacion($array)
    {
      $query = $this->db
      ->select("empresas.nombre as empresa,empresas.id as empresa_id, ingresos_liquidaciones_detalle.id,impuestos.id as id_impuesto,nombre,tipo_impuesto,domicilio,impuestos.concepto,SUM(cantidad) as cantidad,responsable_id,completa,monto_impuesto,SUM(importe) as importe,NIT,razon_social,primer_apellido,segundo_apellido,primer_nombre, otros_nombres")
      ->from("ingresos")
      ->join("ingresos_liquidaciones","ingresos_liquidaciones.ingreso_id = ingresos.id")
      ->join("ingresos_liquidaciones_detalle","ingresos_liquidaciones_detalle.ingreso_liquidacion_id = ingresos_liquidaciones.id")
      ->join("empresas","empresas.id = ingresos_liquidaciones.responsable_id")
      ->join("impuestos","impuestos.id = ingresos_liquidaciones_detalle.impuesto_id")
      ->where_in("ingresos_liquidaciones.id",$array)
      ->group_by("impuestos.id")
      ->get();
      die($this->db->last_query());
      return $query->result();
    }
    */

    public function getDatosAlimentos($array,$responsable_id)
    {
      $query = $this->db
      ->select("empresas.nombre as empresa,empresas.id as empresa_id, ingresos_liquidaciones_detalle.id,impuestos.id as id_impuesto,nombre,tipo_impuesto,domicilio,impuestos.concepto,SUM(cantidad) as cantidad,responsable_id,completa,monto_impuesto,SUM(importe) as importe,cuit,razon_social,propietario,ingresos.id as id_ingreso,empresas.email,empresas.telefono")
      ->from("ingresos")
      ->join("ingresos_liquidaciones","ingresos_liquidaciones.ingreso_id = ingresos.id")
      ->join("ingresos_liquidaciones_detalle","ingresos_liquidaciones_detalle.ingreso_liquidacion_id = ingresos_liquidaciones.id")
      ->join("empresas","empresas.id = ingresos_liquidaciones.responsable_id")
      ->join("impuestos","impuestos.id = ingresos_liquidaciones_detalle.impuesto_id")
      ->where_in("ingresos.id",$array)
      ->where("ingresos_liquidaciones.responsable_id",$responsable_id)
      ->group_by("impuestos.id")
      ->get();
      //die($this->db->last_query());
      return $query->result();
    }

    public function getDatosDerecho($array)
    {
      $query = $this->db
      ->select("ifnull(impuestos_multiejes.concepto,impuestos.concepto) as concepto,empresas.nombre as empresa,empresas.id as empresa_id, ingresos_liquidaciones_detalle.id,impuestos.id as id_impuesto,nombre,tipo_impuesto,domicilio,cantidad,responsable_id,completa,monto_impuesto, importe,cuit,razon_social,propietario,ifnull(impuestos_multiejes.id,NULL) as id_multiejes,empresas.email,empresas.telefono")
      ->from("ingresos")
      ->join("ingresos_liquidaciones","ingresos_liquidaciones.ingreso_id = ingresos.id")
      ->join("ingresos_liquidaciones_detalle","ingresos_liquidaciones_detalle.ingreso_liquidacion_id = ingresos_liquidaciones.id")
      ->join("empresas","empresas.id = ingresos_liquidaciones.responsable_id")
      ->join("impuestos","impuestos.id = ingresos_liquidaciones_detalle.impuesto_id")
      ->join("impuestos_multiejes","impuestos.id = impuestos_multiejes.impuesto_id AND impuestos_multiejes.id = ingresos_liquidaciones_detalle.id_multiejes","left")
      ->where_in("ingresos.id",$array)
      ->get();
      //die($this->db->last_query());
      return $query->result();
    }

    public function addCabecera($cabecera)
    {
      $this->db->insert('recibos',$cabecera);
      $insert_id=$this->db->insert_id();
      //die($this->db->last_query());
      return $insert_id;
    }

    public function getRecibos($id)
    {
      $query = $this->db
      ->select("*")
      ->from("recibos")
      ->where("id_empresa",$id)
      ->get();
      //die($this->db->last_query());
      return $query->result();
    }

    public function getDatosRecibo($tipo)
    {
      $query = $this->db->query("SELECT * FROM recibos WHERE tipo_impuesto = '$tipo' ORDER BY id DESC LIMIT 1");
      //die($this->db->last_query());
      return $query->row();
    }


	
}
