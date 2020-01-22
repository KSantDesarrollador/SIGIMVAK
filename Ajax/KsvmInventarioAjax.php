<?php

/**
*Petición Ajax para registrar editar o eliminar un inventario
*/
$KsvmPeticionAjax = true;
require_once "../Raiz/KsvmConfiguracion.php";

if (isset($_POST['KsvmBdgId']) || isset($_POST['KsvmCodDelete']) || isset($_POST['KsvmCodEdit']) || isset($_POST['KsvmBdgCod'])
    || isset($_POST['KsvmIvtMedCod']) || isset($_POST['KsvmIvtStkCod']) || isset($_POST['KsvmTokken']) || isset($_POST['KsvmCodX'])
    || isset($_POST['KsvmBodCod'])) {
    require_once "../Controladores/KsvmInventarioControlador.php";
    $KsvmIniInventario = new KsvmInventarioControlador();

    if (!isset($_POST['KsvmCodDelete']) && !isset($_POST['KsvmCodEdit']) && isset($_POST['KsvmDuracionInv'])){

          echo $KsvmIniInventario->__KsvmAgregarInventarioControlador();
    }

    if (isset($_POST['KsvmCodDelete'])) {
        echo $KsvmIniInventario->__KsvmEliminarInventarioControlador();
    }

    if (isset($_POST['KsvmTokken']) && isset($_POST['KsvmCodRevision'])) {
        echo $KsvmIniInventario->__KsvmRevisarInventario();
    }

    if (isset($_POST['KsvmCodX'])) {
        echo $KsvmIniInventario->__KsvmEliminarRegistroInventario();
    }

    if (isset($_POST['KsvmCodEdit']) && isset($_POST['KsvmStockInv'])) {
        echo $KsvmIniInventario->__KsvmActualizarInventarioControlador();
    }

    if (isset($_POST['KsvmBdgCod'])) {
        echo $KsvmIniInventario->__KsvmSeleccionarInventario();
    }

    if (isset($_POST['KsvmIvtMedCod'])) {
        echo $KsvmIniInventario->__KsvmCargarMedicamento();
    }

    if (isset($_POST['KsvmIvtStkCod'])) {
        echo $KsvmIniInventario->__KsvmCargarStock();
    }

    if (isset($_POST['KsvmBodCod'])) {
        echo $KsvmIniInventario->__KsvmCargarBodega();
    }
    
} else {
    session_start(['name' => 'SIGIM']);
    session_destroy();
    echo '<script> window.location.href=" '.KsvmServUrl.'Login"</script>';
}
