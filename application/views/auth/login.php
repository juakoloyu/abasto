<!DOCTYPE html>
<html>

<body class="login-page">
	<div class="wrapper wrapper-full-page ">
		<div class="full-page login-page" style="background: radial-gradient(#BA0021,#241e1e) !important;">
			<!--   you can change the color of the filter page using: data-color="blue | purple | green | orange | red | rose " -->
			<div class="content" style="padding-top: 70px;">
				<div class="container">
					<div class="col-lg-4 col-md-6 ml-auto mr-auto">
						<?php echo form_open(); ?>
							<div class="card card-login card-white">
								<div class="card-header">
									<img src="<?php echo base_url('assets/img/card-primary.png') ?>" alt="">
									<h1 class="card-title" style="font-size: 4.5em;text-align: center;margin: 25px 0 0;">Ingresar</h1>
								</div>
								<div class="card-body">
									<div class="input-group">
										<div class="input-group-prepend">
											<div class="input-group-text">
												<i class="tim-icons icon-email-85"></i>
											</div>
										</div>
										<?php echo form_input(array(
											'name' => 'dni', 
											'class' => 'form-control', 
											'placeholder' => 'DNI',
											'value' => set_value('dni'))) .'<br />'?>
									</div>
									<div class="input-group" style="margin-bottom: 0px;">
										<div class="input-group-prepend">
											<div class="input-group-text">
												<i class="tim-icons icon-lock-circle"></i>
											</div>
										</div>

										<?php echo form_password(array(
											'name' => 'password', 
											'class' => 'form-control', 
											'placeholder' => 'Contraseña', 
											'value' => set_value('password'))) .'<br />'; ?>
									</div>
								</div>

								<?php if($error) echo '<div class="alert alert-danger ml-2 mr-2">'. $error .'</div>'; ?>

								<div class="card-footer">
									<input type="submit" name="" value="Ingresar" class="btn btn-danger animation-on-hover btn-lg btn-block mb-3">
									<div class="pull-left">
										<h6>
											<a href="javascript:void(0)" class="link footer-link"></a>
										</h6>
									</div>
									<div class="pull-right">
										<h6>
											<a href="javascript:void(0)" class="link footer-link">Recuperar contraseña</a>
										</h6>
									</div>
								</div>
							</div>
						<?php echo form_close() ?>
					</div>
				</div>
			</div>
			<footer class="footer">
				<div class="container-fluid">
					<div class="copyright">
						© 2020 |
						Desarrollado por <a href="javascript:void(0)"><span class="text-white">Ss. de Modernización</span></a>
					</div>
				</div>
			</footer>
		</div>
	</div>

</body>
