<!--
* Copyright 2019 Klever Santiago Vaca Muela
-->

<!-- Contenido Usuario -->
<section class="full-width pageContent">
  <section class="full-width text-center" style="padding: 25px 0; margin-top: 40px;">
    <div style="height: 90px;" class="tittle">
      <h3><img src="<?php echo KsvmServUrl?>Vistas/assets/img/medicamentos.png" height="60px"><span
          class="text-center tittles hide-on-tablet">&nbsp;Sistema de Gestión de Inventario de Medicamentos </span></h3>
    </div>
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
        $KsvmDataReq = new KsvmRequisicionControlador();
        $KsvmContReq = $KsvmDataReq->__KsvmContarRequisicionControlador(2);
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
  </section>
</section>