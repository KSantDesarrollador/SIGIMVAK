<!--
* Copyright 2019 Klever Santiago Vaca Muela
-->

  <!-- Contenido Supervisor -->
  <section class="full-width pageContent">
    <section class="full-width text-center" style="padding: 25px 0;">
      <div style="height: 70px;" class="tittle">
      <h3><img src="<?php echo KsvmServUrl?>Vistas/assets/img/medicamentos.png" height="60px"><span class="text-center tittles hide-on-tablet">&nbsp;Sistema de Gestión de Inventario de Medicamentos </span></h3>
      </div>
      <?php 
        require "./Controladores/KsvmEmpleadoControlador.php";
        $KsvmDataEmp = new KsvmEmpleadoControlador();
        $KsvmContEmp = $KsvmDataEmp->__KsvmContarEmpleadoControlador();
      ?>
      <!-- Accesos -->
      <article class="full-width tile">
      <a href="<?php echo KsvmServUrl;?>KsvmEmpleados/1/">
        <div class="tile-text">
          <span class="text-condensedLight">
          <strong><?php echo $KsvmContEmp->rowCount(); ?></strong>
            <br><br>
            <small>Empleados</small>
          </span>
        </div>
        <i class="zmdi zmdi-accounts tile-icon"></i>
        </a>
      </article>
      <?php 
        require "./Controladores/KsvmUsuarioControlador.php";
        $KsvmDataUsu = new KsvmUsuarioControlador();
        $KsvmContUsu = $KsvmDataUsu->__KsvmContarUsuarioControlador();
      ?>
      <article class="full-width tile">
      <a href="<?php echo KsvmServUrl;?>KsvmUsuarios/1/">
        <div class="tile-text">
          <span class="text-condensedLight">
          <strong><?php echo $KsvmContUsu->rowCount(); ?></strong>
            <br><br>
            <small>Usuarios</small>
          </span>
        </div>
        <i class="zmdi zmdi-account tile-icon"></i>
        </a>
      </article>
      <?php 
        require "./Controladores/KsvmProveedorControlador.php";
        $KsvmDataProv = new KsvmProveedorControlador();
        $KsvmContProv = $KsvmDataProv->__KsvmContarProveedorControlador();
      ?>
      <article class="full-width tile">
      <a href="<?php echo KsvmServUrl;?>KsvmProveedores/1/">
        <div class="tile-text">
          <span class="text-condensedLight">
          <strong><?php echo $KsvmContProv->rowCount(); ?></strong>
            <br><br>
            <small>Proveedores</small>
          </span>
        </div>
        <i class="zmdi zmdi-truck tile-icon"></i>
        </a>
      </article>
      <?php 
        require "./Controladores/KsvmBodegaControlador.php";
        $KsvmDataCom = new KsvmBodegaControlador();
        $KsvmContCom = $KsvmDataCom->__KsvmContarBodegaControlador();
      ?>
      <article class="full-width tile">
      <a href="<?php echo KsvmServUrl;?>KsvmBodegas/1/">
        <div class="tile-text">
          <span class="text-condensedLight">
          <strong><?php echo $KsvmContCom->rowCount(); ?></strong>
            <br><br>
            <small>Bodegas</small>
          </span>
        </div>
        <i class="zmdi zmdi-shopping-cart tile-icon"></i>
        </a>
      </article>
      <?php 
        require "./Controladores/KsvmMedicamentoControlador.php";
        $KsvmDataMed = new KsvmMedicamentoControlador();
        $KsvmContMed = $KsvmDataMed->__KsvmContarMedicamentoControlador();
      ?>
      <article class="full-width tile">
      <a href="<?php echo KsvmServUrl;?>KsvmCatalogoMedicamentos/1/">
        <div class="tile-text">
          <span class="text-condensedLight">
          <strong><?php echo $KsvmContMed->rowCount(); ?></strong>
            <br><br>
            <small>Medicamentos</small>
          </span>
        </div>
        <i class="zmdi zmdi-book tile-icon"></i>
        </a>
      </article>
      <?php 
        require "./Controladores/KsvmAlertaControlador.php";
        $KsvmDataReq = new KsvmAlertaControlador();
        $KsvmContReq = $KsvmDataReq->__KsvmContarAlertaControlador();
      ?>
      <article class="full-width tile">
      <a href="<?php echo KsvmServUrl;?>KsvmAlertas/1/">
        <div class="tile-text">
          <span class="text-condensedLight">
          <strong><?php echo $KsvmContReq->rowCount(); ?></strong>
            <br><br>
            <small>Alertas</small>
          </span>
        </div>
        <i class="zmdi zmdi-store tile-icon"></i>
        </a>
      </article>
      <?php 
        require "./Controladores/KsvmParametrosControlador.php";
        $KsvmDataReq = new KsvmParametrosControlador();
        $KsvmContReq = $KsvmDataReq->__KsvmContarParametrosControlador();
      ?>
      <article class="full-width tile">
      <a href="<?php echo KsvmServUrl;?>KsvmParametros/1/">
        <div class="tile-text">
          <span class="text-condensedLight">
          <strong><?php echo $KsvmContReq->rowCount(); ?></strong>
            <br><br>
            <small>Parametros</small>
          </span>
        </div>
        <i class="zmdi zmdi-store tile-icon"></i>
        </a>
      </article>
      <article class="full-width tile">
      <a href="<?php echo KsvmServUrl;?>KsvmReporteGeneral/">
        <div class="tile-text"> 
          <span class="text-condensedLight">
            <br>
            <small>Reportes</small>
          </span>
        </div>
        <i class="zmdi zmdi-chart tile-icon"></i>
        </a>
      </article>
    <section class="full-width" style="margin: 30px 0;">
      <h3 class="text-center tittles">LINEA DE TIEMPO</h3>
      <!-- Linea del tiempo -->
      <div id="timeline-c" class="timeline-c">
        <div class="timeline-c-box">
          <div class="timeline-c-box-icon bg-info">
            <i class="zmdi zmdi-twitter"></i>
          </div>
          <div class="timeline-c-box-content">
            <h4 class="text-center text-condensedLight">Linea del Tiempo</h4>
            <p class="text-center">
            </p>
            <span class="timeline-date"><i class="zmdi zmdi-calendar-note zmdi-hc-fw"></i>05-04-2016</span>
          </div>
        </div>
        <div class="timeline-c-box">
          <div class="timeline-c-box-icon bg-success">
            <i class="zmdi zmdi-whatsapp"></i>
          </div>
          <div class="timeline-c-box-content">
            <h4 class="text-center text-condensedLight">Linea del Tiempo</h4>
            <p class="text-center">
            </p>
            <span class="timeline-date"><i class="zmdi zmdi-calendar-note zmdi-hc-fw"></i>06-04-2016</span>
          </div>
        </div>
        <div class="timeline-c-box">
          <div class="timeline-c-box-icon bg-primary">
            <i class="zmdi zmdi-facebook"></i>
          </div>
          <div class="timeline-c-box-content">
            <h4 class="text-center text-condensedLight">Linea del Tiempo</h4>
            <p class="text-center">
            </p>
            <span class="timeline-date"><i class="zmdi zmdi-calendar-note zmdi-hc-fw"></i>07-04-2016</span>
          </div>
        </div>
        <div class="timeline-c-box">
          <div class="timeline-c-box-icon bg-danger">
            <i class="zmdi zmdi-youtube"></i>
          </div>
          <div class="timeline-c-box-content">
            <h4 class="text-center text-condensedLight">Linea del Tiempo</h4>
            <p class="text-center">
            </p>
            <span class="timeline-date"><i class="zmdi zmdi-calendar-note zmdi-hc-fw"></i>08-04-2016</span>
          </div>
        </div>
      </div>
    </section>
    </section>
