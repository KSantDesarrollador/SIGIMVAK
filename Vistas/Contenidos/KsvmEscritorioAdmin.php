<!--
* Copyright 2019 Klever Santiago Vaca Muela
-->
<?php
  session_start(['name' => 'SIGIM']);
   if ($_SESSION['KsvmRolNom-SIGIM'] != "Administrador") {
      echo $CerrarSesion->__KsvmMatarSesion();
   }

   require_once "Vistas/Contenidos/KsvmAlertasPush.php";
  ?>
<!-- Contenido Administrador -->
<section class="full-width pageContent">
  <section class="full-width text-center" style="padding: 25px 0;">
    <div style="height: 70px;" class="tittle">
      <h3><img src="<?php echo KsvmServUrl?>Vistas/assets/img/medicamentos.png" height="60px"><span
          class="text-center tittles hide-on-tablet">&nbsp;Sistema de Gestión de Inventario de Medicamentos </span></h3>
    </div>
    <?php 
        require "./Controladores/KsvmAuditoriaControlador.php";
        $KsvmDataAudi = new KsvmAuditoriaControlador();
        $KsvmContAudi = $KsvmDataAudi->__KsvmContarAudiroriaControlador();
      ?>
    <article class="full-width tile">
      <a href="<?php echo KsvmServUrl;?>KsvmAuditoria/1/">
        <div class="tile-text">
          <span class="text-condensedLight">
            <strong><?php echo $KsvmContAudi->rowCount(); ?></strong>
            <br><br>
            <small>Auditoria</small>
          </span>
        </div>
        <i class="zmdi zmdi-check tile-icon"></i>
      </a>
    </article>
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
        require "./Controladores/KsvmTransaccionControlador.php";
        $KsvmDataTran = new KsvmTransaccionControlador();
        $KsvmContTran = $KsvmDataTran->__KsvmContarIngresosControlador("A");
      ?>
    <article class="full-width tile">
      <a href="<?php echo KsvmServUrl;?>KsvmIngresos/1/">
        <div class="tile-text">
          <span class="text-condensedLight">
            <strong><?php echo $KsvmContTran->rowCount(); ?></strong>
            <br><br>
            <small>Ingresos</small>
          </span>
        </div>
        <i class="zmdi zmdi-transform tile-icon"></i>
      </a>
    </article>
    <?php 
        $KsvmContTran = $KsvmDataTran->__KsvmContarEgresosControlador("A");
      ?>
    <article class="full-width tile">
      <a href="<?php echo KsvmServUrl;?>KsvmEgresos/1/">
        <div class="tile-text">
          <span class="text-condensedLight">
            <strong><?php echo $KsvmContTran->rowCount(); ?></strong>
            <br><br>
            <small>Egresos</small>
          </span>
        </div>
        <i class="zmdi zmdi-transform tile-icon"></i>
      </a>
    </article>
    <?php 
        require "./Controladores/KsvmCompraControlador.php";
        $KsvmDataCom = new KsvmCompraControlador();
        $KsvmContCom = $KsvmDataCom->__KsvmContarCompraControlador("A");
      ?>
    <article class="full-width tile">
      <a href="<?php echo KsvmServUrl;?>KsvmCompras/1/">
        <div class="tile-text">
          <span class="text-condensedLight">
            <strong><?php echo $KsvmContCom->rowCount(); ?></strong>
            <br><br>
            <small>Compras</small>
          </span>
        </div>
        <i class="zmdi zmdi-shopping-cart tile-icon"></i>
      </a>
    </article>
    <?php 
        require "./Controladores/KsvmRequisicionControlador.php";
        $KsvmDataReq = new KsvmRequisicionControlador();
        $KsvmContReq = $KsvmDataReq->__KsvmContarRequisicionControlador("A");
      ?>
    <article class="full-width tile">
      <a href="<?php echo KsvmServUrl;?>KsvmRequisiciones/1/">
        <div class="tile-text">
          <span class="text-condensedLight">
            <strong><?php echo $KsvmContReq->rowCount(); ?></strong>
            <br><br>
            <small>Pedidos</small>
          </span>
        </div>
        <i class="zmdi zmdi-upload tile-icon"></i>
      </a>
    </article>
    <?php 
        require "./Controladores/KsvmInventarioControlador.php";
        $KsvmDataInv = new KsvmInventarioControlador();
        $KsvmContInv = $KsvmDataInv->__KsvmContarInventarioControlador("A");
      ?>
    <article class="full-width tile">
      <a href="<?php echo KsvmServUrl;?>KsvmInventarios/1/">
        <div class="tile-text">
          <span class="text-condensedLight">
            <strong><?php echo $KsvmContInv->rowCount(); ?></strong>
            <br><br>
            <small>Inventarios</small>
          </span>
        </div>
        <i class="zmdi zmdi-check-circle tile-icon"></i>
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
  </section>
</section>