<?php

/**
*Petición Ajax para registrar editar o eliminar una compra
*/
$KsvmPeticionAjax = true;
require_once "../Raiz/KsvmConfiguracion.php";

if (isset($_POST['KsvmPvdId']) || isset($_POST['KsvmCodDelete']) || isset($_POST['KsvmCodEdit']) || isset($_POST['KsvmTokken']) || isset($_POST['KsvmCodX'])
    || isset($_POST['KsvmCmpCod']) || isset($_POST['KsvmDocCod'])) {
    require_once "../Controladores/KsvmCompraControlador.php";
    $KsvmIniCompra = new KsvmCompraControlador();

    if (!isset($_POST['KsvmCodDelete']) && !isset($_POST['KsvmCodEdit']) && isset($_POST['KsvmPvdId'])) {

          echo $KsvmIniCompra->__KsvmAgregarCompraControlador();
    }

    if (isset($_POST['KsvmCodDelete'])) {
        echo $KsvmIniCompra->__KsvmEliminarCompraControlador();
    }

    if (isset($_POST['KsvmTokken']) && isset($_POST['KsvmCodRevision'])) {
        echo $KsvmIniCompra->__KsvmRevisarCompra();
    }

    if (isset($_POST['KsvmCodX'])) {
        echo $KsvmIniCompra->__KsvmEliminarRegistroCompra();
    }

    if (isset($_POST['KsvmCodEdit']) && isset($_POST['KsvmPvdId'])) {
        echo $KsvmIniCompra->__KsvmActualizarCompraControlador();
    }

    if (isset($_POST['KsvmCmpCod'])) {
        echo $KsvmIniCompra->__KsvmCargarMedicamento();
    }

    if (isset($_POST['KsvmDocCod'])) {
        echo $KsvmIniCompra->__KsvmCargarStock();
    }
    
} else {
    session_start(['name' => 'SIGIM']);
    session_destroy();
    echo '<script> window.location.href=" '.KsvmServUrl.'Login"</script>';
}
