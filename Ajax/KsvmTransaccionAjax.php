<?php

/**
*Petición Ajax para registrar editar o eliminar una transacción
*/
$KsvmPeticionAjax = true;
require_once "../Raiz/KsvmConfiguracion.php";

if (isset($_POST['KsvmDestinoTran']) || isset($_POST['KsvmCodDelete']) || isset($_POST['KsvmCodEdit']) || isset($_POST['KsvmCodX'])
   || isset($_POST['KsvmTipoTranCod']) || isset($_POST['KsvmBodCod'])) {
    require_once "../Controladores/KsvmTransaccionControlador.php";
    $KsvmIniTransaccion = new KsvmTransaccionControlador();

    if (!isset($_POST['KsvmCodDelete']) && !isset($_POST['KsvmCodEdit']) && isset($_POST['KsvmDestinoTran']) && isset($_POST['KsvmTipoTran'])
           && isset($_POST['KsvmRqcId'])) {

          echo $KsvmIniTransaccion->__KsvmAgregarTransaccionControlador();
    }

    if (isset($_POST['KsvmCodDelete'])) {
        echo $KsvmIniTransaccion->__KsvmEliminarTransaccionControlador();
    }

    if (isset($_POST['KsvmCodX'])) {
        echo $KsvmIniTransaccion->__KsvmEliminarRegistroTransaccion();
    }

    if (isset($_POST['KsvmCodEdit']) && isset($_POST['KsvmDestinoTran'])) {
        echo $KsvmIniTransaccion->__KsvmActualizarTransaccionControlador();
    }

    if (isset($_POST['KsvmTipoTranCod'])) {
        echo $KsvmIniTransaccion->__KsvmCargarTipo();
    }

    if (isset($_POST['KsvmBodCod'])) {
        echo $KsvmIniTransaccion->__KsvmCargarBodega();
    }
    
} else {
    session_start(['name' => 'SIGIM']);
    session_destroy();
    echo '<script> window.location.href=" '.KsvmServUrl.'Login"</script>';
}
