<?php

/**
*Petición Ajax para cerrar sesión
*/
$KsvmPeticionAjax = true;
require_once "../Raiz/KsvmConfiguracion.php";

if (isset($_GET['KsvmTok'])) {
     require_once "../Controladores/KsvmLoginControlador.php";
     $KsvmCerSes = new KsvmLoginControlador();
     echo $KsvmCerSes->__KsvmCerrarSesionControlador();
     
} else {
    session_start();
    session_destroy();
    echo '<script> window.location.href="'.KsvmServUrl.'Login"</script>';
}