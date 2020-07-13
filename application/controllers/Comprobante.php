<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Comprobante extends CI_Controller {

	function __construct() {
		parent::__construct();
		$this->load->model('Ingresos_model');
		$this->load->model('Comprobantes_model');
	}
	
	function comprobanteAlimentos() 
	{
		$data['titulo'] = 'Comprobante';
		$data['content'] = '/comprobante/comprobante_alimentos';
		$data['cabecera'] = $this->Comprobantes_model->imprimirCabecera($this->uri->segment(3));
		$data['datos_liquidacion'] = $this->Comprobantes_model->imprimirRecibo($this->uri->segment(3),1);
		$data['suma'] = array_sum(array_column($data['datos_liquidacion'],'importe'));
		$this->load->view('/includes/template', $data);
	}

	function comprobanteDerechoPiso() 
	{
		$data['titulo'] = 'Comprobante';
		$data['content'] = '/comprobante/comprobante_derecho';
		$data['cabecera'] = $this->Comprobantes_model->imprimirCabecera($this->uri->segment(3));
		$data['datos_liquidacion'] = $this->Comprobantes_model->imprimirRecibo($this->uri->segment(3),2);
		$data['suma'] = array_sum(array_column($data['datos_liquidacion'],'importe'));
		$this->load->view('/includes/template', $data);
	}

	function autorizacionDerechoPiso() 
	{
		$data['titulo'] = 'Comprobante';
		$data['content'] = '/comprobante/autorizacion_derechopiso';
		$data['derecho_piso'] = $this->Comprobantes_model->imprimirDP($this->uri->segment(3));
		$this->load->view('/includes/template', $data);
	}

	function autorizacionAlimentos() 
	{
		$data['titulo'] = 'Comprobante';
		$data['content'] = '/comprobante/autorizacion_alimentos';
		$data['meses'] = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
		$data['alimentos'] = $this->Comprobantes_model->imprimirAlimentos($this->uri->segment(3));
		$this->load->view('/includes/template', $data);
	}

	function generarIngresoDerechoP() 
	{
		$datos = $this->Comprobantes_model->getDerechoPiso($this->input->post("id",TRUE));
		$recibo = $this->Comprobantes_model->getDatosDP();
		$existe = $this->Comprobantes_model->exist($this->input->post("id",TRUE));
		if(empty($existe))
		{
			if (empty($recibo)) {
				$numero_recibo = date('y').'0000';
			}
			else{
				$numero_recibo = date('y').substr($recibo->numero_ingreso,2)+1;
			}
			$ingreso = array(
				'id_ingreso' => $this->input->post("id",TRUE),
				'numero_ingreso' => $numero_recibo,
				'fecha' => $datos[0]->fecha,
				'titular' => $datos[0]->titular,
				'tipo_documento' => $datos[0]->tipo_documento,
				'documento' => $datos[0]->nro_documento,
				'dominio' => $datos[0]->dominio,
				'marca' => $datos[0]->marca,
				'modelo' => $datos[0]->modelo,
				'tipo_vehiculo' => $datos[0]->tipo,
				'domicilio' => $datos[0]->domicilio,
				'localidad' => $datos[0]->localidad,
				'provincia' => $datos[0]->nombre,
				'apellido_nombre_conductor' => $datos[0]->nombre_transportista,
				'tipo_documento_conductor' => $datos[0]->tipo_doc,
				'documento_conductor' => $datos[0]->documento,
				'cat_licencia' => $datos[0]->cat_licencia,
				'licencia_conductor' => $datos[0]->licencia,
				'destino' => $datos[0]->destino_consignado,
				'objetos_transportados' => $datos[0]->objetos_transportados,
				'dias' => $datos[0]->dias_permanencia,
			);
			$this->db->trans_start();

					$this->db->insert('derecho_piso',$ingreso);
					$ingreso_id = $this->db->insert_id();

					$this->db->update('ingresos',array('completo' => '1'), array('id' => $ingreso["id_ingreso"]));
					$this->db->update('ingresos_liquidaciones',array('completa' => '1'), array('id' => $datos[0]->ingresos_liquidaciones_id));
					
					echo json_encode(array("result"=>"ok","id"=>$ingreso_id));
			$this->db->trans_complete();
		}
		else
		{
			//redirect('comprobante/autorizacionDerechoPiso/'.$existe->id);
		}
	}

	function generarIngresoAlimentos() 
	{
		$datos = $this->Comprobantes_model->getAlimentos($this->input->post("id",TRUE));
		$recibo = $this->Comprobantes_model->getDatosA();
		$existe = $this->Comprobantes_model->exist_alimentos($this->input->post("id",TRUE));
		if(empty($existe))
		{
			if (empty($recibo)) {
				$numero_recibo = date('y').'0000';
			}
			else{
				$numero_recibo = date('y').substr($recibo->numero_ingreso,2)+1;
			}
			$insertar = array();
			$ingreso = array(
				'id_ingreso' => $this->input->post("id",TRUE),
				'numero_ingreso' => $numero_recibo,
				'fecha' => $datos[0]->fecha,
				'empresa_proveedora' => $datos[0]->proveedora,
				'propietario' => $datos[0]->propietario,
				'direccion' => $datos[0]->domicilio,
				'observaciones' => $datos[0]->objetos_transportados,
				'senasa' => $datos[0]->senasa,
				'proc_estancia' => $datos[0]->proc_estanc,
				'patente' => $datos[0]->dominio,
				'matricula' => $datos[0]->dominio,
				'equipo_frio' => $datos[0]->frio,
				'mat_n' => $datos[0]->mat_n,
				'prec_n' => $datos[0]->prec_n,
			);
			$this->db->trans_start();

			$this->db->insert('alimentos',$ingreso);
			$ingreso_id = $this->db->insert_id();

			foreach ($datos as $i => $d) 
			{
				$detalles = array(
					'id_alimentos' => $ingreso_id,
					'empresa_destino' => $d->receptora,
					'nro_factura' => $d->nro_factura,
				);
				array_push($insertar, $detalles);
			}
			$this->db->update('ingresos',array('completo' => '1'), array('id' => $ingreso["id_ingreso"]));
			if($this->db->insert_batch('alimentos_detalles', $insertar))
			{
				echo json_encode(array("result"=>"ok","id"=>$ingreso_id));
			}
			$this->db->trans_complete();
		}
		else
		{
			//redirect('comprobante/autorizacionAlimentos/'.$existe->id);
		}
	}


}