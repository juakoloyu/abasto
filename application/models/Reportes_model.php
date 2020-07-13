<?php

class Reportes_model extends CI_Model {

    public function getDeudas()
    {
      $query = $this->db->query("SELECT SUM(importe)*0.08+SUM(importe)+20 as importe,e.razon_social,e.cuit
        FROM ingresos
        JOIN ingresos_liquidaciones il on ingresos.id = il.ingreso_id
        JOIN ingresos_liquidaciones_detalle ild on il.id = ild.ingreso_liquidacion_id
        JOIN empresas e on il.responsable_id = e.id
        WHERE il.estado_pago = 'debe' AND no_liquidable = 0
        GROUP BY responsable_id");
      //die($this->db->last_query());
      return $query->result();
    }

    public function getPagos($desde,$hasta)
    {
      $query = $this->db
      ->select("*")
      ->from("recibos")
      ->where("fecha_generacion >=",$desde)
      ->where("fecha_generacion <=",$hasta)
      ->get();
      //die($this->db->last_query());
      return $query->result();
    }

    public function getDeudasEmpresa($id)
    {
      $query = $this->db->query("SELECT alimentos.numero_ingreso, alimentos.fecha,e.razon_social as consignado,nro_factura,i.concepto as producto,ild.monto_impuesto,er.razon_social as responsable, er.cuit as cuit_responsable,
       ild.cantidad,ild.importe
        FROM ingresos
        JOIN ingresos_liquidaciones il on ingresos.id = il.ingreso_id
        JOIN ingresos_liquidaciones_detalle ild on il.id = ild.ingreso_liquidacion_id
        JOIN impuestos i on ild.impuesto_id = i.id
        JOIN alimentos on ingresos.id = alimentos.id_ingreso
        JOIN empresas e on il.empresa_id = e.id
        JOIN empresas er on il.responsable_id = er.id
        WHERE il.estado_pago = 'debe' AND il.responsable_id = '$id' AND no_liquidable = 0");
      //die($this->db->last_query());
      return $query->result();
    }

    public function getDeudasFechas($empresa,$desde,$hasta)
    {
      $query = $this->db->query("SELECT i.concepto,SUM(ild.cantidad) as cantidad,ild.monto_impuesto,SUM(ild.importe) as importe
        FROM ingresos
        JOIN ingresos_liquidaciones il on ingresos.id = il.ingreso_id
        JOIN ingresos_liquidaciones_detalle ild on il.id = ild.ingreso_liquidacion_id
        JOIN impuestos i on ild.impuesto_id = i.id
        WHERE il.estado_pago = 'debe' AND il.completa = 1 AND date(ingresos.fecha) >= '$desde' AND date(ingresos.fecha) <= '$hasta' AND no_liquidable = 0 AND il.responsable_id = '$empresa'
        GROUP BY impuesto_id");
      //die($this->db->last_query());
      return $query->result();
    }

}