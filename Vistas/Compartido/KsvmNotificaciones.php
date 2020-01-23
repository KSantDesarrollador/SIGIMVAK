<!--
* Copyright 2019 Klever Santiago Vaca Muela
-->
<!-- Area de Notificaciones -->
<section class="full-width container-notifications">
  <div class="full-width container-notifications-bg btn-Notification"></div>
  <section class="NotificationArea">
    <!-- Area de notificaciones para el supervisor -->
    <?php 
  if ($_SESSION['KsvmRolNom-SIGIM'] == "Supervisor") { ?>
    <div class="full-width text-center NotificationArea-title tittles">Notificaciones <i
        class="zmdi zmdi-close btn-Notification"></i></div>
     <!-- Area de Pedidos    -->
    <?php
      require_once "./Controladores/KsvmRequisicionControlador.php";
      $KsvmIniReq = new KsvmRequisicionControlador();
      $KsvmListarRequisicion = $KsvmIniReq->__KsvmContarRequisicionControlador(0);
      if ($KsvmListarRequisicion->rowCount() >= 1) {
      ?>
    <a href="<?php echo KsvmServUrl;?>KsvmSuperPedidos/1/" class="Notification" id="notifation-unread-1">
      <div class="Notification-icon"><i class="zmdi zmdi-transform bg-info"></i></div>
      <div class="Notification-text">
        <p>
          <i class="zmdi zmdi-circle"></i>
          <strong>Nuevo pedido generado (<?php echo $KsvmListarRequisicion->rowCount();?>)</strong>
          <br>
        </p>
      </div>
      <div class="mdl-tooltip mdl-tooltip--left" for="notifation-unread-1">Notificación no leída</div>
    </a>
    <?php }else{?>
    <div class="Notification">
      <div class="Notification-icon"><i class="zmdi zmdi-transform bg-info"></i></div>
      <div class="Notification-text">
        <br>
        <i class="zmdi zmdi-circle-o"></i>
        <small>No hay Ordenes de pedido pendientes...</small>
      </div>
    </div>
    <?php }?>
    <!-- Area de Compras -->
    <?php
      require_once "./Controladores/KsvmCompraControlador.php";
      $KsvmIniComp = new KsvmCompraControlador();
      $KsvmListarCompra = $KsvmIniComp->__KsvmContarCompraControlador(0);
      if ($KsvmListarCompra->rowCount() >= 1) {
      ?>
    <a href="<?php echo KsvmServUrl;?>KsvmSuperCompras/1/" class="Notification" id="notifation-read-1">
      <div class="Notification-icon"><i class="zmdi zmdi-shopping-cart bg-primary"></i></div>
      <div class="Notification-text">
        <p>
          <i class="zmdi zmdi-circle"></i>
          <strong>Nueva orden de compra (<?php echo $KsvmListarCompra->rowCount();?>)</strong>
          <br>
        </p>
      </div>
      <div class="mdl-tooltip mdl-tooltip--left" for="notifation-read-1">Notificación leída</div>
    </a>
    <?php }else{?>
    <div class="Notification">
      <div class="Notification-icon"><i class="zmdi zmdi-shopping-cart bg-primary"></i></div>
      <div class="Notification-text">
        <br>
        <i class="zmdi zmdi-circle-o"></i>
        <small>No hay Ordenes de compra pendientes...</small>
      </div>
    </div>
    <?php }?>
    <!-- Area de Inventarios -->
    <?php
      require_once "./Controladores/KsvmInventarioControlador.php";
      $KsvmIniInv = new KsvmInventarioControlador();
      $KsvmListarInventario = $KsvmIniInv->__KsvmContarInventarioControlador(0);
      if ($KsvmListarInventario->rowCount() >= 1) {
      ?>
    <a href="<?php echo KsvmServUrl;?>KsvmSuperInventarios/1/" class="Notification" id="notifation-unread-2">
      <div class="Notification-icon"><i class="zmdi zmdi-check-circle bg-success"></i></div>
      <div class="Notification-text">
        <p>
          <i class="zmdi zmdi-circle"></i>
          <strong>Nuevo Inventario registrado (<?php echo $KsvmListarInventario->rowCount();?>)</strong>
          <br>
        </p>
      </div>
      <div class="mdl-tooltip mdl-tooltip--left" for="notifation-unread-2">Notificación no leída</div>
    </a>
    <?php }else{?>
    <div class="Notification">
      <div class="Notification-icon"><i class="zmdi zmdi-check-circle bg-success"></i></div>
      <div class="Notification-text">
        <br>
        <i class="zmdi zmdi-circle-o"></i>
        <small>No hay Inventarios pendientes...</small>
      </div>
    </div>
    <?php }?>
    <!-- <a href="<?php echo KsvmServUrl;?>KsvmSuperPagos/1/" class="Notification" id="notifation-read-2">
      <div class="Notification-icon"><i class="zmdi zmdi-money bg-danger"></i></div>
      <div class="Notification-text">
        <p>
          <i class="zmdi zmdi-circle-o"></i>
          <strong>Nuevo Pago Realizado</strong>
          <br>
          <small>37 Mins Ago</small>
        </p>
      </div>
      <div class="mdl-tooltip mdl-tooltip--left" for="notifation-read-2">Notificación leída</div>
    </a> -->
     <!-- Area de notificaciones para el técnico -->
    <?php }elseif($_SESSION['KsvmRolNom-SIGIM'] == "Tecnico"){?>
    <div class="full-width text-center NotificationArea-title tittles">Notificaciones <i
        class="zmdi zmdi-close btn-Notification"></i></div>
     <!-- Area de pedidos  -->
    <?php
      require_once "./Controladores/KsvmRequisicionControlador.php";
      $KsvmIniReq = new KsvmRequisicionControlador();
      $KsvmListarRequisicion = $KsvmIniReq->__KsvmContarRequisicionControlador(1);
      if ($KsvmListarRequisicion->rowCount() >= 1) {
      ?>
    <a href="<?php echo KsvmServUrl;?>KsvmRequisiciones/1/" class="Notification" id="notifation-unread-1">
      <div class="Notification-icon"><i class="zmdi zmdi-transform bg-info"></i></div>
      <div class="Notification-text">
        <p>
          <i class="zmdi zmdi-circle"></i>
          <strong>Nuevo Pedido aprobado (<?php echo $KsvmListarRequisicion->rowCount();?>)</strong>
          <br>
        </p>
      </div>
      <div class="mdl-tooltip mdl-tooltip--left" for="notifation-unread-1">Notificación no leída</div>
    </a>
    <?php }else{?>
    <div class="Notification">
      <div class="Notification-icon"><i class="zmdi zmdi-transform bg-info"></i></div>
      <div class="Notification-text">
        <br>
        <i class="zmdi zmdi-circle-o"></i>
        <small>Ordenes de pedido pendientes a revisión...</small>
      </div>
    </div>
    <?php }?>
    <!-- Area de Compras -->
    <?php
      require_once "./Controladores/KsvmCompraControlador.php";
      $KsvmIniComp = new KsvmCompraControlador();
      $KsvmListarCompra = $KsvmIniComp->__KsvmContarCompraControlador(1);
      if ($KsvmListarCompra->rowCount() >= 1) {
      ?>
    <a href="<?php echo KsvmServUrl;?>KsvmCompras/1/" class="Notification" id="notifation-read-1">
      <div class="Notification-icon"><i class="zmdi zmdi-shopping-cart bg-primary"></i></div>
      <div class="Notification-text">
        <p>
          <i class="zmdi zmdi-circle"></i>
          <strong>Orden de compra Aprobada!</strong>
          <br>
        </p>
      </div>
      <div class="mdl-tooltip mdl-tooltip--left" for="notifation-read-1">Notificación leída</div>
    </a>
    <?php }else{?>
    <div class="Notification">
      <div class="Notification-icon"><i class="zmdi zmdi-shopping-cart bg-primary"></i></div>
      <div class="Notification-text">
        <br>
        <i class="zmdi zmdi-circle-o"></i>
        <small>Ordenes de compra pendientes a revisión...</small>
      </div>
    </div>
    <?php }}else{?>

    <div class="full-width text-center NotificationArea-title tittles">Notificaciones <i
        class="zmdi zmdi-close btn-Notification"></i></div>
     <!-- Area de pedidos  -->
     <?php
      require_once "./Controladores/KsvmRequisicionControlador.php";
      $KsvmIniReq = new KsvmRequisicionControlador();
      $KsvmListarRequisicion = $KsvmIniReq->__KsvmContarRequisicionControlador(1);
      if ($KsvmListarRequisicion->rowCount() >= 1) {
      ?>
    <a href="<?php echo KsvmServUrl;?>KsvmRequisiciones/1/" class="Notification" id="notifation-unread-1">
      <div class="Notification-icon"><i class="zmdi zmdi-transform bg-info"></i></div>
      <div class="Notification-text">
        <p>
          <i class="zmdi zmdi-circle"></i>
          <strong>Nuevo Pedido generado (<?php echo $KsvmListarRequisicion->rowCount();?>)</strong>
          <br>
        </p>
      </div>
      <div class="mdl-tooltip mdl-tooltip--left" for="notifation-unread-1">Notificación no leída</div>
    </a>
    <?php }else{?>
    <div class="Notification">
      <div class="Notification-icon"><i class="zmdi zmdi-transform bg-info"></i></div>
      <div class="Notification-text">
        <br>
        <i class="zmdi zmdi-circle-o"></i>
        <small>Ordenes de pedido pendientes a revisión...</small>
      </div>
    </div>
    <?php }?>
    <!-- Area de Inventarios -->
    <?php
      require_once "./Controladores/KsvmInventarioControlador.php";
      $KsvmIniReq = new KsvmInventarioControlador();
      $KsvmListarRequisicion = $KsvmIniReq->__KsvmContarInventarioControlador(1);
      if ($KsvmListarRequisicion->rowCount() >= 1) {
      ?>
    <a href="<?php echo KsvmServUrl;?>KsvmUsuInventarios/1/" class="Notification" id="notifation-unread-1">
      <div class="Notification-icon"><i class="zmdi zmdi-transform bg-info"></i></div>
      <div class="Notification-text">
        <p>
          <i class="zmdi zmdi-circle"></i>
          <strong>Nuevo Inventario Registrado (<?php echo $KsvmListarRequisicion->rowCount();?>)</strong>
          <br>
        </p>
      </div>
      <div class="mdl-tooltip mdl-tooltip--left" for="notifation-unread-1">Notificación no leída</div>
    </a>
    <?php }else{?>
    <div class="Notification">
      <div class="Notification-icon"><i class="zmdi zmdi-shopping-cart bg-primary"></i></div>
      <div class="Notification-text">
        <br>
        <i class="zmdi zmdi-circle-o"></i>
        <small>Inventarios pendientes a revisión...</small>
      </div>
    </div>
    <?php }}?>
  </section>
</section>