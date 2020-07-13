<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$autoload['packages'] = array();

$autoload['libraries'] = array('Authme','email','form_validation','session','pagination');

$autoload['helper'] = array('url','authme','form');

$autoload['config'] = array('authme');

$autoload['language'] = array();

$autoload['model'] = array('Authme_model','Empresas_model','Impuestos_model','Ingresos_model','Productos_model','Transportistas_model','Vehiculos_model');
