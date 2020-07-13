<div class="sidebar" data="red">
      <div class="sidebar-wrapper">
        <div class="logo">
          <a href="javascript:void(0)" class="simple-text logo-mini">
            CT
          </a>
          <a href="javascript:void(0)" class="simple-text logo-normal">
            <?php echo user('nombre') ?>
          </a>
        </div>
        <ul class="nav">
          <li>
            <a data-toggle="collapse" href="#ingresos">
              <i class="fas fa-truck"></i>
              <p>
                Ingresos
                <b class="caret"></b>
              </p>
            </a>
            <div class="collapse" id="ingresos">
              <ul class="nav">
                <li>
                  <a href="<?php echo base_url('ingresos/nuevoIngreso') ?>">
                    <span class="sidebar-mini-icon">N</span>
                    <span class="sidebar-normal"> Nuevo </span>
                  </a>
                </li>
                <li>
                  <a href="<?php echo base_url('ingresos/index') ?>">
                    <span class="sidebar-mini-icon">L</span>
                    <span class="sidebar-normal"> Listar </span>
                  </a>
                </li>
              </ul>
            </div>
          </li>
          <li>
            <a data-toggle="collapse" href="#reportes">
              <i class="fas fa-dollar-sign"></i>
              <p>
                Reportes
                <b class="caret"></b>
              </p>
            </a>
            <div class="collapse" id="reportes">
              <ul class="nav">
                <li>
                  <a href="<?php echo base_url('reportes/porFechas') ?>">
                    <span class="sidebar-mini-icon">PF</span>
                    <span class="sidebar-normal"> Ingresos por Fechas </span>
                  </a>
                </li>
                <li>
                  <a href="<?php echo base_url('reportes/deudas') ?>">
                    <span class="sidebar-mini-icon">DA</span>
                    <span class="sidebar-normal"> Deudas de Abasto </span>
                  </a>
                </li>
                <li>
                  <a href="<?php echo base_url('reportes/deudasEmpresa') ?>">
                    <span class="sidebar-mini-icon">DE</span>
                    <span class="sidebar-normal"> Deudas por Empresas </span>
                  </a>
                </li>
                <li>
                  <a href="<?php echo base_url('reportes/deudasFechas') ?>">
                    <span class="sidebar-mini-icon">DF</span>
                    <span class="sidebar-normal"> Deudas por Fechas </span>
                  </a>
                </li>
              </ul>
            </div>
          </li>
          <li>
            <a data-toggle="collapse" href="#tierras">
              <i class="fas fa-truck"></i>
              <p>
                Vehiculos
                <b class="caret"></b>
              </p>
            </a>
            <div class="collapse" id="tierras">
              <ul class="nav">
                <li>
                  <a href="<?php echo base_url('vehiculos/create') ?>">
                    <span class="sidebar-mini-icon">N</span>
                    <span class="sidebar-normal"> Nuevo </span>
                  </a>
                </li>
                <li>
                  <a href="<?php echo base_url('vehiculos/index') ?>">
                    <span class="sidebar-mini-icon">L</span>
                    <span class="sidebar-normal"> Listar </span>
                  </a>
                </li>
              </ul>
            </div>
          </li>
          <li>
            <a data-toggle="collapse" href="#productos">
              <i class="fas fa-apple-alt"></i>
              <p>
                Productos
                <b class="caret"></b>
              </p>
            </a>
            <div class="collapse" id="productos">
              <ul class="nav">
                <li>
                  <a href="<?php echo base_url('productos/create') ?>">
                    <span class="sidebar-mini-icon">N</span>
                    <span class="sidebar-normal"> Nuevo </span>
                  </a>
                </li>
                <li>
                  <a href="<?php echo base_url('productos/') ?>">
                    <span class="sidebar-mini-icon">L</span>
                    <span class="sidebar-normal"> Listar </span>
                  </a>
                </li>
              </ul>
            </div>
          </li>
          <li>
            <a data-toggle="collapse" href="#transportistas">
              <i class="fas fa-people-carry"></i>
              <p>
                Transportistas
                <b class="caret"></b>
              </p>
            </a>
            <div class="collapse" id="transportistas">
              <ul class="nav">
                <li>
                  <a href="<?php echo base_url('transportistas/create') ?>">
                    <span class="sidebar-mini-icon">N</span>
                    <span class="sidebar-normal"> Nuevo </span>
                  </a>
                </li>
                <li>
                  <a href="<?php echo base_url('transportistas/index') ?>">
                    <span class="sidebar-mini-icon">L</span>
                    <span class="sidebar-normal"> Listar </span>
                  </a>
                </li>
              </ul>
            </div>
          </li>
          <!--
          <li>
            <a data-toggle="collapse" href="#usuarios">
              <i class="fas fa-user-secret"></i>
              <p>
                Usuarios
                <b class="caret"></b>
              </p>
            </a>
            <div class="collapse" id="usuarios">
              <ul class="nav">
                <li>
                  <a href="<?php echo base_url('auth/signup') ?>">
                    <span class="sidebar-mini-icon">N</span>
                    <span class="sidebar-normal"> Nuevo </span>
                  </a>
                </li>
                <li>
                  <a href="<?php echo base_url('auth/index') ?>">
                    <span class="sidebar-mini-icon">L</span>
                    <span class="sidebar-normal"> Listar </span>
                  </a>
                </li>
              </ul>
            </div>
          </li>
        -->
          <li>
            <a data-toggle="collapse" href="#empresas">
              <i class="far fa-building"></i>
              <p>
                Empresas
                <b class="caret"></b>
              </p>
            </a>
            <div class="collapse" id="empresas">
              <ul class="nav">
                <li>
                  <a href="<?php echo base_url('empresas/create') ?>">
                    <span class="sidebar-mini-icon">N</span>
                    <span class="sidebar-normal"> Nuevo </span>
                  </a>
                </li>
                <li>
                  <a href="<?php echo base_url('empresas') ?>">
                    <span class="sidebar-mini-icon">L</span>
                    <span class="sidebar-normal"> Listar </span>
                  </a>
                </li>
              </ul>
            </div>
          </li>
          <li>
            <a href="<?php echo base_url('impuestos/') ?>">
              <i class="fas fa-dollar-sign"></i>
              <p>
                Impuestos
              </p>
            </a>
            <!--
            <div class="collapse" id="impuestos">
              <ul class="nav">
                <li>
                  <a href="<?php echo base_url('impuestos/') ?>">
                    <span class="sidebar-mini-icon">L</span>
                    <span class="sidebar-normal"> Listar </span>
                  </a>
                </li>
              </ul>
            </div>
            -->
          </li>
        </ul>
      </div>
    </div>