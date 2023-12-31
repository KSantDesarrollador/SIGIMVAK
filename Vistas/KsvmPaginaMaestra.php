<?php

/** Copyright 2019 Klever Santiago Vaca Muela*/

$KsvmPeticionAjax = false;

 require_once "./Controladores/KsvmVistaControlador.php";

$KsvmMostrar = new KsvmVistaControlador();
$KsvmUrl = $KsvmMostrar->__KsvmCargarContenidoControlador();

if ($KsvmUrl == "Login" || $KsvmUrl == "404" || $KsvmUrl == "KsvmRecuperaContrasenia") {
  if ($KsvmUrl == "Login") {
    include "Compartido/KsvmCabecera.php";
    include "Contenidos/KsvmLogin.php";
  }elseif ($KsvmUrl == "KsvmRecuperaContrasenia"){
    include "Compartido/KsvmCabecera.php";
    include "Contenidos/KsvmRecuperaContrasenia.php";
  } else {
    include "Compartido/KsvmCabecera.php";
    include "Contenidos/KsvmError404.php";
  }
} else {
  /**Inicio y cierre de sesión*/
  session_start(['name' => 'SIGIM']);
  require_once "./Controladores/KsvmLoginControlador.php";

  $KsvmLogueo = new KsvmLoginControlador();
  if (!isset($_SESSION['KsvmToken-SIGIM']) || !isset($_SESSION['KsvmUsuNom-SIGIM'])) {
     $KsvmLogueo -> __KsvmMatarSesion();
  }

  /**Cabecera*/
  include "Compartido/KsvmCabecera.php";
  /**Script cierre  de sesión*/
  include "Compartido/KsvmCierreSesionSc.php";
  /**Area de Notificaciones*/
  include "Compartido/KsvmNotificaciones.php";
  /**Menu Superior*/
  include "Compartido/KsvmMenu.php";
  /**Menu Lateral*/
  include "Compartido/KsvmMenuLateral.php";
  /**Script Valida Cedula*/
  include "Compartido/KsvmValidaId.php";
  /**Script Carga Select*/
  include "Compartido/KsvmCargaSelect.php";
  /**Contenido*/
  require_once $KsvmUrl;
  /**Pie de Página*/
  include "Compartido/KsvmFooter.php";
}
