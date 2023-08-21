<?php

/** Copyright 2019 Klever Santiago Vaca Muela*/

  setlocale(LC_ALL, 'es_EC.UTF-8');
  $KsvmFecha = date('y:m:d',time());
  $KsvmCalendar = strftime("%A, %d de %B del %Y", strtotime($KsvmFecha));
  
  ?>
<!-- Menu -->
<div class="full-width navBar">
  <div class="full-width navBar-options">
    <i class="zmdi zmdi-more-vert btn-menu" id="btn-menu"></i>
    <div class="mdl-tooltip" for="btn-menu">Menu</div>
    <nav class="navBar-options-list">
      <ul class="list-unstyle">
        <li class="noLink tittles" style=":white;">
          <span class="hide-on-tablet"><?php echo $KsvmCalendar;?></span>
          &nbsp; <a href="#"><i class="zmdi zmdi-calendar-note"
              id="calendar"></i></a>
          <div class="mdl-tooltip" for="calendar">Calendario</div>
        </li>
        <?php if ($_SESSION['KsvmRolNom-SIGIM'] == 'Supervisor' || $_SESSION['KsvmRolNom-SIGIM'] == 'Tecnico' || $_SESSION['KsvmRolNom-SIGIM'] == 'Usuario') {?>
        <li class="btn-Notification" id="notifications">
          <i class="zmdi zmdi-notifications"></i>
          <!-- <i class="zmdi zmdi-notifications-active btn-Notification" id="notifications"></i> -->
          <div class="mdl-tooltip" for="notifications">Notificaciones</div>
        </li>
        <?php }?>
        <li>
          <a href="<?php echo $KsvmLogueo -> __KsvmEncriptacion($_SESSION['KsvmToken-SIGIM']); ?>" class="btn-exit"
            id="exit"><i class="zmdi zmdi-power"></i></a>
          <div class="mdl-tooltip" for="exit">Cerrar Sesion</div>
        </li>
        <!-- <li class="text-condensedLight noLink"><small><?php echo $_SESSION['KsvmUsuNom-SIGIM']; ?></small></li> -->
        <li class="noLink">
          <figure>
          <img width="80%" src="data:image/jpg;base64,<?php echo base64_encode($_SESSION['KsvmImg-SIGIM']); ?>" alt="Avatar"
          class="img-responsive">
          </figure>
        </li>
      </ul>
    </nav>
  </div>
</div>