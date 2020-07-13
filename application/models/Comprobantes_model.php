<?php

class Comprobantes_model extends CI_Model {

	public function imprimirRecibo($id,$tipo)
    {
      $query = $this->db->query("
        SELECT propietario,razon_social,cuit,fecha_generacion,unidades,importe,impuestos.id,ifnull(nombre,impuestos.concepto) as concepto,
       unidades,coeficiente,importe,tipo,domicilio,impuestos_multiejes.concepto as im_concep,recibos_detalles.id_multieje
        FROM recibos
        JOIN recibos_detalles ON recibos.id = recibos_detalles.id_recibo AND recibos.id = '$id'
        RIGHT JOIN impuestos ON impuestos.id = recibos_detalles.id_impuesto
        LEFT JOIN impuestos_multiejes ON impuestos_multiejes.id = recibos_detalles.id_multieje
        WHERE impuestos.tipo = '$tipo'
        ");
      //die($this->db->last_query());
      return $query->result();
    }

    public function imprimirCabecera($id)
    {
      $query = $this->db->query("
        SELECT *
        FROM recibos
        WHERE recibos.id = '$id'
        ");
      //die($this->db->last_query());
      return $query->row();
    }
    public function getAutorizacion($id)
    {
      $query = $this->db->query("
        SELECT provincias.nombre,fecha,titular,tipo_documento,nro_documento,dominio, marca,domicilio,localidad,modelo,v.tipo,objetos_transportados,dias_permanencia,cat_licencia,licencia,documento,transportistas.nombre as nombre_transportista,transportistas.tipo_doc
        FROM ingresos
        JOIN ingresos_liquidaciones il on ingresos.id = il.ingreso_id
        JOIN ingresos_liquidaciones_detalle ild on il.id = ild.ingreso_liquidacion_id
        JOIN vehiculos v on ingresos.vehiculo_id = v.id
        JOIN provincias on provincias.id = v.provincia
        JOIN transportistas on transportistas.id = ingresos.transportista_id
        WHERE ingresos.id = '$id'
        ");
      //die($this->db->last_query());
      return $query->result();
    }

    public function getDerechoPiso($id)
    {
      $query = $this->db->query("
        SELECT provincias.nombre,fecha,titular,tipo_documento,nro_documento,dominio, marca,domicilio,localidad,modelo,v.tipo,objetos_transportados,dias_permanencia,cat_licencia,licencia,documento,transportistas.nombre as nombre_transportista,transportistas.tipo_doc,il.id as ingresos_liquidaciones_id,destino_consignado
    		FROM ingresos
    		JOIN ingresos_liquidaciones il on ingresos.id = il.ingreso_id
    		#JOIN ingresos_liquidaciones_detalle ild on il.id = ild.ingreso_liquidacion_id
    		JOIN vehiculos v on ingresos.vehiculo_id = v.id
    		JOIN provincias on provincias.id = v.provincia
        JOIN transportistas on transportistas.id = ingresos.transportista_id
    		WHERE ingresos.id = '$id'
        ");
      //die($this->db->last_query());
      return $query->result();
    }

    public function getAlimentos($id)
    {
      $query = $this->db->query("
        SELECT empresas.razon_social as proveedora,e.razon_social as receptora,il.nro_factura,provincias.nombre as provincia,fecha,titular,
          tipo_documento,nro_documento,dominio, marca, empresas.domicilio, localidad,modelo,
          v.tipo,objetos_transportados,dias_permanencia,cat_licencia,licencia,documento,transportistas.nombre as nombre_transportista,transportistas.tipo_doc,
          empresas.nombre as empresa, empresas.propietario as propietario, proc_estanc, v.dominio,transportistas.licencia,senasa,v.frio,mat_n,prec_n
        FROM ingresos
        JOIN ingresos_liquidaciones il on ingresos.id = il.ingreso_id
        JOIN empresas ON empresas.id = ingresos.empresa_proveedora
        JOIN empresas e ON e.id = il.empresa_id
        JOIN vehiculos v on ingresos.vehiculo_id = v.id
        JOIN provincias on provincias.id = v.provincia
        JOIN transportistas on transportistas.id = ingresos.transportista_id
        WHERE ingresos.id = '$id'
        GROUP BY nro_factura
        ");
      //die($this->db->last_query());
      return $query->result();
    }

    public function getDatosDP()
    {
      $query = $this->db->query("SELECT * FROM derecho_piso ORDER BY id DESC LIMIT 1");
      //die($this->db->last_query());
      return $query->row();
    }

    public function getDatosA()
    {
      $query = $this->db->query("SELECT * FROM alimentos ORDER BY id DESC LIMIT 1");
      //die($this->db->last_query());
      return $query->row();
    }

    public function imprimirDP($id)
    {
      $query = $this->db->query("SELECT * FROM derecho_piso WHERE id = '$id'");
      //die($this->db->last_query());
      return $query->result();
    }

    public function imprimirAlimentos($id)
    {
      $query = $this->db->query("SELECT * 
        FROM alimentos
        JOIN alimentos_detalles ON alimentos.id = alimentos_detalles.id_alimentos 
        WHERE alimentos.id = '$id'");
      //die($this->db->last_query());
      return $query->result();
    }

    public function exist($id)
    {
      $query = $this->db->query("SELECT * FROM derecho_piso WHERE id_ingreso = '$id'");
      //die($this->db->last_query());
      return $query->row();
    }

    public function exist_alimentos($id)
    {
      $query = $this->db->query("SELECT * FROM alimentos WHERE id_ingreso = '$id'");
      //die($this->db->last_query());
      return $query->row();
    }

}