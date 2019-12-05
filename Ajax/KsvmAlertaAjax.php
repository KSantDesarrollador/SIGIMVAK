<?php

/**
*Petición Ajax para registrar editar o eliminar una alerta
*/
$KsvmPeticionAjax = true;
require_once "../Raiz/KsvmConfiguracion.php";

if (isset($_POST['KsvmNomAle']) || isset($_POST['KsvmCodDelete']) || isset($_POST['KsvmCodEdit'])) {
    require_once "../Controladores/KsvmAlertaControlador.php";
    $KsvmIniAlerta = new KsvmAlertaControlador();

    if (!isset($_POST['KsvmCodDelete']) && !isset($_POST['KsvmCodEdit']) && isset($_POST['KsvmNomAle']) && isset($_POST['KsvmColorAle']) &&
          isset($_POST['KsvmDescAle'])) {

          echo $KsvmIniAlerta->__KsvmAgregarAlertaControlador();
    }

    if (isset($_POST['KsvmCodDelete'])) {
        echo $KsvmIniAlerta->__KsvmEliminarAlertaControlador();
    }

    if (isset($_POST['KsvmCodEdit']) && isset($_POST['KsvmNomAle'])) {
        echo $KsvmIniAlerta->__KsvmActualizarAlertaControlador();
    }
    
} else {
    session_start(['name' => 'SIGIM']);
    session_destroy();
    echo '<script> window.location.href=" '.KsvmServUrl.'Login"</script>';
}
