<!--
* Copyright 2019 Klever Santiago Vaca Muela
-->

<?php
require_once "./Modelos/KsvmMenuModelo.php";
$KsvmMenu = new KsvmMenuModelo();

?>

<!--Reloj-->
<script language="javascript" type="text/javascript">
  //<!-- Begin
  var timerID = null;
  var timerRunning = false;

  function stopclock() {
    if (timerRunning)
      clearTimeout(timerID);
    timerRunning = false;
  }

  function showtime() {
    var now = new Date();
    var hours = now.getHours();
    var minutes = now.getMinutes();
    var seconds = now.getSeconds()
    var timeValue = "" + ((hours > 12) ? hours - 12 : hours)
    if (timeValue == "0") timeValue = 12;
    timeValue += ((minutes < 10) ? ":0" : ":") + minutes
    timeValue += ((seconds < 10) ? ":0" : ":") + seconds
    timeValue += (hours >= 12) ? " P.M." : " A.M."
    document.clock.face.value = timeValue;
    timerID = setTimeout("showtime()", 1000);
    timerRunning = true;
  }

  function startclock() {
    stopclock();
    showtime();
  }
  window.onload = startclock;
  // End -->
</script>

<!-- Menu Lateral -->
<section class="full-width navLateral">
  <div class="full-width navLateral-bg btn-menu"></div>
  <div class="full-width navLateral-body">
    <div class="full-width navLateral-body-logo text-center tittles">
      <img src="<?php echo KsvmServUrl?>Vistas/assets/img/logo.png"
        alt="Sistema de Gastión de Inventario de Medicamentos" height="33px">&nbsp;<span
        class="hide-on-tablet"><?php echo KsvmCompany;?></span>
    </div>
    <figure class="full-width" style="height: 80px;">
      <div class="navLateral-body-cl">
        <img src="data:image/jpg;base64,<?php echo base64_encode($_SESSION['KsvmImg-SIGIM']); ?>" alt="Avatar"
          class="img-responsive">
      </div>
      <figcaption class="navLateral-body-cr hide-on-tablet">
        <span class="">
          <strong><?php echo $_SESSION['KsvmUsuNom-SIGIM']; ?>
            <br>
            <small><?php echo $_SESSION['KsvmRolNom-SIGIM']; ?></small>
          </strong>
          &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;<a href="<?php echo KsvmServUrl?>KsvmPerfil?KsvmCod='<?php echo KsvmEstMaestra :: __KsvmEncriptacion($_SESSION['KsvmUsuId-SIGIM']); ?>'" class="tittle" id="KsvmEditPerfil"><i class="zmdi zmdi-settings"></i></a>
        </span>
        <div class="mdl-tooltip" for="KsvmEditPerfil">Editar Perfil</div>
      </figcaption>
    </figure>
    <div class="full-width hide-on-tablet navLateral-body-tittle-menu">
      <form name="clock">
        <strong style="margin-left:20px;">Tiempo</strong>
        <input style="width:100px;" type="button" class="btn" name="face" disabled />
      </form>
      &nbsp;
    </div>
    <!-- <div class="full-width tittles navLateral-body-tittle-menu">
      <i class="zmdi zmdi-desktop-mac"></i><span class="hide-on-tablet">&nbsp; ESCRITORIO</span>
    </div> -->
    <nav class="full-width">
      <ul class="full-width list-unstyle menu-principal">
        <li class="full-width">
          <?php
              if ($_SESSION['KsvmRolNom-SIGIM'] == "Administrador") {
                      $KsvmRed = "KsvmEscritorioAdmin/";
                    }elseif ($_SESSION['KsvmRolNom-SIGIM'] == "Tecnico") {
                         $KsvmRed = "KsvmEscritorioTec/";
                      }else {
                         $KsvmRed = "KsvmEscritorioUsu/";
                      }
          ?>
          <a href="<?php echo KsvmServUrl . $KsvmRed; ?>" class="full-width">
            <div class="navLateral-body-cl">
              <i class="zmdi zmdi-view-dashboard" id="KsvmEscritorio"></i>
            </div>
            <div class="mdl-tooltip" for="KsvmEscritorio">Escritorio</div>
            <div class="navLateral-body-cr hide-on-tablet">
              ESCRITORIO
            </div>
          </a>
        </li>
        <li class="full-width divider-menu-h"></li>
        <?php
              $Rol = $_SESSION['KsvmRolId-SIGIM'];
              $KsvmObtenerMenu = $KsvmMenu-> __KsvmMostrarMenuModelo($Rol);
              while ($KsvmMen = $KsvmObtenerMenu -> fetch(PDO :: FETCH_ASSOC)) {
                $KsvmId = $KsvmMen['MnuId'];
                $KsvmNombre = $KsvmMen['MnuNomMen'];
                $KsvmIcono = $KsvmMen['MnuIconMen'];
                $KsvmLeyenda = $KsvmMen['MnuLeyendMen'];
         ?>
        <li class="full-width">
          <a href="#" class="full-width btn-subMenu">
            <div class="navLateral-body-cl">
              <i class="<?php echo $KsvmIcono; ?>" id="<?php echo $KsvmId; ?>"></i>
            </div>
            <div class="mdl-tooltip" for="<?php echo $KsvmId; ?>"><?php echo $KsvmLeyenda; ?></div>
            <div class="navLateral-body-cr hide-on-tablet">
              <?php echo $KsvmNombre; ?>
            </div>
            <span class="zmdi zmdi-chevron-left"></span>
          </a>
          <ul class="full-width menu-principal sub-menu-options">
            <?php
                   $KsvmObtenerSubMenu = $KsvmMenu-> __KsvmMostrarSubmenuModelo($KsvmId);
                  while ($KsvmSub = $KsvmObtenerSubMenu -> fetch(PDO :: FETCH_ASSOC)) {
                    $KsvmId = $KsvmSub['MnuId'];
                    $KsvmNombre = $KsvmSub['MnuNomMen'];
                    $KsvmIcono = $KsvmSub['MnuIconMen'];
                    $KsvmDir = $KsvmSub['MnuUrlMen'];
                    $KsvmLeyenda = $KsvmSub['MnuLeyendMen'];
             ?>
            <li class="full-width">
              <a href="<?php echo KsvmServUrl . $KsvmDir .'/1/'; ?>" class="full-width">
                <div class="navLateral-body-cl">
                  <i class="<?php echo $KsvmIcono; ?>" id="<?php echo $KsvmId; ?>"></i>
                </div>
                <div class="mdl-tooltip" for="<?php echo $KsvmId; ?>"><?php echo $KsvmLeyenda; ?></div>
                <div class="navLateral-body-cr hide-on-tablet">
                  <?php echo $KsvmNombre; ?>
                </div>
              </a>
            </li>
            <?php } ?>
          </ul>
        </li>
        <?php } ?>
      </ul>
    </nav>
  </div>
</section>
