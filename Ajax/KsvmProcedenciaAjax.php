<?php

/**
*Petición Ajax para registrar editar o eliminar una procedencia
*/
$KsvmPeticionAjax = true;
require_once "../Raiz/KsvmConfiguracion.php";

if (isset($_POST['KsvmCodProc']) || isset($_POST['KsvmCodDelete']) || isset($_POST['KsvmCodEdit'])) {
    require_once "../Controladores/KsvmProcedenciaControlador.php";
    $KsvmIniProcedencia = new KsvmProcedenciaControlador();

    if (!isset($_POST['KsvmCodDelete']) && !isset($_POST['KsvmCodEdit']) && isset($_POST['KsvmCodProc']) && isset($_POST['KsvmNomProc']) &&
          isset($_POST['KsvmNivProc'])) {

          echo $KsvmIniProcedencia->__KsvmAgregarProcedenciaControlador();
    }

    if (isset($_POST['KsvmCodDelete'])) {
        echo $KsvmIniProcedencia->__KsvmEliminarProcedenciaControlador();
    }

    if (isset($_POST['KsvmCodEdit']) && isset($_POST['KsvmCodProc'])) {
        echo $KsvmIniProcedencia->__KsvmActualizarProcedenciaControlador();
    }
    
} else {
    session_start(['name' => 'SIGIM']);
    session_destroy();
    echo '<script> window.location.href=" '.KsvmServUrl.'Login"</script>';
}
