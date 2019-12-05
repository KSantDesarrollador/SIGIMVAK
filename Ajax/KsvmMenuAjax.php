<?php

/**
*Petición Ajax para registrar editar o eliminar un menú
*/
$KsvmPeticionAjax = true;
require_once "../Raiz/KsvmConfiguracion.php";

if (isset($_POST['KsvmNomMen']) || isset($_POST['KsvmCodDelete']) || isset($_POST['KsvmCodEdit'])) {
    require_once "../Controladores/KsvmMenuControlador.php";
    $KsvmIniMenu = new KsvmMenuControlador();

    if (!isset($_POST['KsvmCodDelete']) && !isset($_POST['KsvmCodEdit']) && isset($_POST['KsvmNomMen']) && isset($_POST['KsvmNivelMen']) &&
          isset($_POST['KsvmIconMen']) && isset($_POST['KsvmUrlMen'])) {

          echo $KsvmIniMenu->__KsvmAgregarMenuControlador();
    }

    if (isset($_POST['KsvmCodDelete'])) {
        echo $KsvmIniMenu->__KsvmEliminarMenuControlador();
    }

    if (isset($_POST['KsvmCodEdit']) && isset($_POST['KsvmNomMen'])) {
        echo $KsvmIniMenu->__KsvmActualizarMenuControlador();
    }
    
} else {
    session_start(['name' => 'SIGIM']);
    session_destroy();
    echo '<script> window.location.href=" '.KsvmServUrl.'Login"</script>';
}
