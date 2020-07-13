<?php

class Ingresos_model extends CI_Model {
	public function __construct() 
	{
		parent::__construct();
 	}

	public function getImpuestos()
    {
      $query = $this->db
      ->select("*")
      ->from("impuestos")
      ->get();
      return $query->result();
    }

    public function getImpuestosWhere($ingreso_id)
    {
      $query = $this->db->query("
        SELECT I.* 
        FROM impuestos I 
        JOIN ingresos I2 ON I2.tipo_impuesto=I.tipo 
        WHERE I2.id=$ingreso_id AND I.id!=37
        ");
      return $query->result();
    }

    public function getImpuestosDerechoPiso()
    {
      $query = $this->db->query("
        SELECT *
        FROM impuestos I 
        WHERE I.tipo=2
        ");
      return $query->result();
    }

    public function getVehiculoIngreso($ingreso_id)
    {
        $query = $this->db->query("
            SELECT Im.id as impuesto_id,eje_simple,eje_doble,ifnull(Ime.monto,Im.sp) as monto,ifnull(Ime.concepto,'') as concepto,ifnull(Ime.id,'') as id_multieje
            FROM vehiculos V
            JOIN tipo_vehiculo TV ON TV.id=V.tipo_vehiculo
            JOIN impuestos Im ON TV.impuesto_id=Im.id
            LEFT JOIN impuestos_multiejes Ime ON Im.id=Ime.impuesto_id
            JOIN ingresos I ON I.vehiculo_id=V.id
            WHERE I.id=$ingreso_id
        ");
      return $query->result();
    }

    public function getProductos($term)
    {
      $query = $this->db->query("
        SELECT * FROM productos
        WHERE descripcion LIKE '%$term%'
        ");
      return $query->result();
    }

    public function buscarImpuestos($term)
    {
      $query = $this->db->query("
        SELECT * FROM impuestos
        WHERE concepto LIKE '%$term%'
        ");
      return $query->result();
    }

    public function buscarVehiculos($term)
    {
      $query = $this->db->query("
        SELECT id,dominio,marca,modelo,titular 
        FROM vehiculos
        WHERE dominio LIKE '%$term%'
        OR titular LIKE '%$term%'
        ");
      return $query->result();
    }

    public function getIngreso($ingreso_id)
    {
      $query = $this->db->query("
        SELECT V.*,TV.*,I.*,L.*,E.nombre 
        FROM ingresos I
        LEFT JOIN ingresos_liquidaciones L ON I.id=L.ingreso_id
        LEFT JOIN empresas E on L.responsable_id = E.id
        JOIN vehiculos V ON I.vehiculo_id=V.id
        JOIN tipo_vehiculo TV ON V.tipo_vehiculo=TV.id
        WHERE I.id = $ingreso_id
        ");
      return $query->row();
    }

    public function getIngresoLiquidacion($ingreso_liquidacion_id)
    {
      $query = $this->db->query("
        SELECT if(I1.tipo_empresa=1,I2.sp,if(I1.tipo_empresa=2,I2.otro_municipio,I2.otra_provincia)) as impuesto,E.nombre,I2.concepto,
        ILD.impuesto_id,ILD.id as detalle_id,IL.completa,ILD.ingreso_liquidacion_id,tipo_impuesto
        FROM ingresos I1 
        JOIN ingresos_liquidaciones IL ON I1.id=IL.ingreso_id 
        JOIN ingresos_liquidaciones_detalle ILD ON IL.id = ILD.ingreso_liquidacion_id
        JOIN empresas E on IL.responsable_id = E.id 
        JOIN impuestos I2 ON I2.id=ILD.impuesto_id
        WHERE IL.id IN ($ingreso_liquidacion_id)
        ");
      return $query->result();
    }

    public function getLiquidaciones($ingreso_id)
    {
        $query = $this->db->query("
        SELECT ingreso_liquidacion_id,E.nombre as responsable,E2.nombre as destino,IL.completa,I1.contribuyentes,I1.tipo_impuesto,ILD.*
        FROM ingresos I1
        JOIN ingresos_liquidaciones IL ON I1.id=IL.ingreso_id
        LEFT JOIN ingresos_liquidaciones_detalle ILD ON IL.id = ILD.ingreso_liquidacion_id
        JOIN empresas E on IL.responsable_id = E.id 
        LEFT JOIN empresas E2 on IL.empresa_id=E2.id
        WHERE I1.id = $ingreso_id
        GROUP BY ingreso_liquidacion_id
        ");
        return $query->result();
    }

    public function getILD_derecho_piso($ingreso_id)
    {
        $query = $this->db->query("
            SELECT ILD.*,ifnull(IM.concepto,I.concepto) as concepto,IL.responsable_id,IL.estado_pago,I1.completo
            FROM ingresos I1
            JOIN ingresos_liquidaciones IL ON I1.id=IL.ingreso_id
            LEFT JOIN ingresos_liquidaciones_detalle ILD ON IL.id = ILD.ingreso_liquidacion_id
            JOIN impuestos I ON ILD.impuesto_id=I.id
            LEFT JOIN impuestos_multiejes IM ON ILD.id_multiejes=IM.id
            WHERE I1.id = $ingreso_id
        ");
        return $query->result();
    }

    public function getImpuestosID($id)
    {
      $query = $this->db
      ->select("*")
      ->from("impuestos")
      ->where("tipo",$id)
      ->get();
      return $query->result();
    }

    public function eliminarLiquidacion($ingreso_id,$empresa_id)
    {
        $this->db->query("
          DELETE FROM ingresos_liquidaciones
          WHERE ingreso_id=$ingreso_id AND empresa_id=$empresa_id
          ");
    }

    public function eliminarFactura($ingreso_liquidacion_id)
    {
        $this->db->query("
        DELETE FROM ingresos_liquidaciones
        WHERE id IN ($ingreso_liquidacion_id)
        ");
        return true;
    }

    public function quitarResponsable($ingreso_id)
    {
        $this->db->query("
            DELETE IL,ILD
            FROM 
            ingresos_liquidaciones IL
            LEFT JOIN ingresos_liquidaciones_detalle ILD on IL.id = ILD.ingreso_liquidacion_id
            WHERE ingreso_id = $ingreso_id
            ");
        return true;
    }

    public function getResponsable($ingreso_id)
    {
        $query = $this->db->query("
        SELECT E.nombre,IL.nro_factura,E.id
        FROM ingresos_liquidaciones IL
        JOIN empresas E on IL.responsable_id = E.id
        WHERE IL.ingreso_id = $ingreso_id
        ");
        return $query->row();
    }

    public function getEmpresasDelIngreso($ingreso_id)
    {
      $query = $this->db->query("
        SELECT group_concat(I.id) as ingreso_liquidacion_id,group_concat(E.nombre) as nombre,nro_factura
        FROM ingresos_liquidaciones I
        JOIN empresas E on I.empresa_id = E.id
        WHERE I.ingreso_id = $ingreso_id
        GROUP BY nro_factura
        ");
      return $query->result();
    }

    function getImpuestosDelIngreso($ingreso_id)
    {
        $impuestos = $this->db->query("
            SELECT group_concat(impuesto_id) as impuestos
            FROM ingresos_liquidaciones IL
            JOIN ingresos_liquidaciones_detalle ild on IL.id = ild.ingreso_liquidacion_id
            WHERE IL.ingreso_id=$ingreso_id
            ");
        return $impuestos->row()->impuestos;
    }
    
    ##### COMIENZO DATATABLE INGRESOS AJAX  #####
    function allingresos_count()
    {   
        $query = $this
                ->db
                ->get('ingresos');
    
        return $query->num_rows();  

    }
    
    function allingresos($limit,$start,$col='id',$dir='desc')
    {   
        /*
        Condicion IF en el SELECT: Si el ingreso es No liquidable le dammos un valor de 2:
            if(no_liquidable=1,2,IL.completa) as completa
        */
        $query = $this->db->query("
            SELECT D.id as derecho_id,A.id as alimento_id,I.id,date_format(I.fecha,'%d/%m/%Y %H:%i') as fecha,ifnull(group_concat(e.nombre),'No cargado') as destinos,v.dominio,I.tipo_impuesto,A.numero_ingreso as a_ingreso,D.numero_ingreso as d_ingreso,if(no_liquidable=1,2,IL.completa) as completa
            FROM ingresos I
            LEFT JOIN ingresos_liquidaciones IL ON I.id = IL.ingreso_id
            LEFT JOIN vehiculos v on v.id = I.vehiculo_id
            LEFT JOIN empresas e on IL.empresa_id = e.id
            LEFT JOIN alimentos A ON A.id_ingreso=I.id
            LEFT JOIN derecho_piso D ON D.id_ingreso=I.id
            GROUP BY I.id,IL.completa
            ORDER BY $col $dir
            LIMIT $limit OFFSET $start
            ");
        if($query->num_rows()>0)
        {
            return $query->result(); 
        }
        else
        {
            return null;
        }
        
    }
   
    function ingresos_search($limit,$start,$search,$col,$dir)
    {
        $query = $this->db->query("
            SELECT D.id as derecho_id,A.id as alimento_id,I.id,date_format(I.fecha,'%d/%m/%Y %H:%i') as fecha,group_concat(e.nombre) as destinos,IL.completa,v.dominio,I.tipo_impuesto,A.numero_ingreso as a_ingreso,D.numero_ingreso as d_ingreso
            FROM ingresos I
            LEFT JOIN ingresos_liquidaciones IL ON I.id = IL.ingreso_id
            LEFT JOIN vehiculos v on v.id = I.vehiculo_id
            LEFT JOIN empresas e on IL.empresa_id = e.id
            LEFT JOIN alimentos A ON A.id_ingreso=I.id
            LEFT JOIN derecho_piso D ON D.id_ingreso=I.id
            WHERE I.fecha LIKE '%$search%'
            GROUP BY I.id,IL.completa
            ORDER BY $col $dir
            LIMIT $limit OFFSET $start
            ");
       
        if($query->num_rows()>0)
        {
            return $query->result();  
        }
        else
        {
            return null;
        }
    }

    function ingresos_search_count($search)
    {
        $query = $this
                ->db
                ->like('fecha',$search)
                ->get('ingresos');
    
        return $query->num_rows();
    } 

}