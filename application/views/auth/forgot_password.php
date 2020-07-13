<html>
<head>
	<title>Forgot Password</title>
</head>
<body>

	<p><a href="<?php echo site_url('auth/login'); ?>">Login</a></p>

	<?php 
	if($success){
		echo '<p>Gracias. Te hemos enviado un email con las instrucciones para restablecer tu contraseña.</p>';
	} else {
	    echo form_open(); 
	    echo form_label('Dirección de Correo', 'email') .'<br />';
	    echo form_input(array('name' => 'email', 'value' => set_value('email'))) .'<br />';
	    echo form_error('email');
	    echo form_submit(array('type' => 'submit', 'value' => 'Restablecer Contraseña'));
	    echo form_close();
    }
    ?>

</body>
</html>
