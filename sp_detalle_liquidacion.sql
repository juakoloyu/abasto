create
    definer = u283508441_rooter@`%` procedure sp_detalle_liquidacion_alimenticios(IN ingresoLiquidacion_id int, IN proviene int)
BEGIN
    INSERT INTO ingresos_liquidaciones_detalle (ingreso_liquidacion_id,impuesto_id,monto_impuesto)
    SELECT ingresoLiquidacion_id,id,if(proviene=1,I.sp,if(proviene=2,I.otro_municipio,I.otra_provincia))
    FROM impuestos I
    WHERE tipo=1;
end;
