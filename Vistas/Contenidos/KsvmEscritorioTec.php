<!--
* Copyright 2019 Klever Santiago Vaca Muela
-->

  <!-- Contenido Bodega -->
  <section class="full-width pageContent">
    <section class="full-width text-center" style="padding: 25px 0;">
    <div style="height: 70px;" class="tittle">
      <h3><img src="<?php echo KsvmServUrl?>Vistas/assets/img/logo.png" height="60px"><span class="text-center tittles hide-on-tablet">&nbsp;Sistema de Gestión de Inventario de Medicamentos </span></h3>
      </div>
      <!-- Accesos -->
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
        <i class="zmdi zmdi-store tile-icon"></i>
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
        require "./Controladores/KsvmTransaccionControlador.php";
        $KsvmDataTran = new KsvmTransaccionControlador();
        $KsvmContTran = $KsvmDataTran->__KsvmContarIngresosControlador(1);
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
        $KsvmContTran = $KsvmDataTran->__KsvmContarEgresosControlador(1);
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
        $KsvmDataCom = new KsvmCompraControlador();
        $KsvmContCom = $KsvmDataCom->__KsvmContarCompraControlador(1);
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
        $KsvmDataReq = new KsvmRequisicionControlador();
        $KsvmContReq = $KsvmDataReq->__KsvmContarRequisicionControlador(1);
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
        $KsvmContInv = $KsvmDataInv->__KsvmContarInventarioControlador(1);
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
    </section>
</section>
