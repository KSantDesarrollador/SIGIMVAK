<?php

/**
*Petición Ajax para registrar editar o eliminar una existencia
*/
$KsvmPeticionAjax = true;
require_once "../Raiz/KsvmConfiguracion.php";

if (isset($_POST['KsvmLoteEx']) || isset($_POST['KsvmCodDelete']) || isset($_POST['KsvmCodEdit']) || isset($_POST['KsvmBdgCod']) 
    || isset($_POST['KsvmExtCod'])) {
    require_once "../Controladores/KsvmExistenciaControlador.php";
    $KsvmIniExistencia = new KsvmExistenciaControlador();

    if (!isset($_POST['KsvmCodDelete']) && !isset($_POST['KsvmCodEdit']) && isset($_POST['KsvmLoteEx']) && isset($_POST['KsvmFchCadEx']) &&
          isset($_POST['KsvmStockSegEx']) && isset($_POST['KsvmDocId'])) {

          echo $KsvmIniExistencia->__KsvmAgregarExistenciaControlador();
    }

    if (isset($_POST['KsvmCodDelete'])) {
        echo $KsvmIniExistencia->__KsvmEliminarExistenciaControlador();
    }

    if (isset($_POST['KsvmCodEdit']) && isset($_POST['KsvmLoteEx'])) {
        echo $KsvmIniExistencia->__KsvmActualizarExistenciaControlador();
    }

    if (isset($_POST['KsvmBdgCod'])) {
        echo $KsvmIniExistencia->__KsvmSeleccionarExistencia();
    }

    if (isset($_POST['KsvmExtCod'])) {
        echo $KsvmIniExistencia->__KsvmCargarStock();
    }
    
} else {
    session_start(['name' => 'SIGIM']);
    session_destroy();
    echo '<script> window.location.href=" '.KsvmServUrl.'Login"</script>';
}