<!DOCTYPE html>
<html lang="en">

<head>
	<?php $this->load->view('includes/head') ?>
</head>

<?php if (logged_in()) {?>
<?php $user = $this->Authme_model->get_user(user('id')) ?>

<body class="white-content">
  <div class="wrapper">
    <div class="navbar-minimize-fixed">
      <button class="minimize-sidebar btn btn-link btn-just-icon">
        <i class="tim-icons icon-align-center visible-on-sidebar-regular text-muted"></i>
        <i class="tim-icons icon-bullet-list-67 visible-on-sidebar-mini text-muted"></i>
      </button>
    </div>

    <?php $data['user']=$user ?>

    <?php $this->load->view('includes/sidebar_administrador',$data);?>

    <div class="main-panel">
      <?php $this->load->view('includes/navbar') ?>

      <div class="modal modal-search fade" id="searchModal" tabindex="-1" role="dialog" aria-labelledby="searchModal" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <select id="inlineFormInputGroup" name="expediente_id" class="js-data-example-ajax form-control" style="width: 90%">
              </select>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <i class="tim-icons icon-simple-remove"></i>
              </button>
            </div>
          </div>
        </div>
      </div>
      <!-- End Navbar -->
      <div class="content">
        <div class="card">
        	<div class="card-body">
        		<?php $this->load->view($content); ?>
        	</div>
        </div>
      </div>
      <footer class="footer">
        <div class="container-fluid">
          <div class="copyright">
            Abasto © 2020 | Desarrollado por 
            <a id="copy" href="javascript:void(0)">
              <span class="text-danger">Ss. de Modernización</span>
            </a>
          </div>
        </div>
      </footer>
    </div>
  </div>

  <!--   Archivos JS   -->
  <?php $this->load->view('includes/scripts_foot') ?>
  <?php } //Cierro si está logueado?>

  <?php if (!logged_in()){ ?>
    <?php $this->load->view($content) ?>  
  <?php } ?>

</body>
</html>
