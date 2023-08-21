<?php

/**
*Petición Ajax para registrar editar o eliminar un parametro
*/
$KsvmPeticionAjax = true;
require_once "../Raiz/KsvmConfiguracion.php";

if (isset($_POST['KsvmMdcId']) || isset($_POST['KsvmCodDelete']) || isset($_POST['KsvmCodEdit'])) {
    require_once "../Controladores/KsvmPreciosXProveedorControlador.php";
    $KsvmPreciosXProveedor = new KsvmPreciosXProveedorControlador();

    if (!isset($_POST['KsvmCodDelete']) && !isset($_POST['KsvmCodEdit']) && isset($_POST['KsvmMdcId']) && isset($_POST['KsvmPvdId'])){

          echo $KsvmPreciosXProveedor->__KsvmAgregarPreciosXProveedorControlador();
    }

    if (isset($_POST['KsvmCodDelete'])) {
        echo $KsvmPreciosXProveedor->__KsvmEliminarPreciosXProveedorControlador();
    }

    if (isset($_POST['KsvmCodEdit']) && isset($_POST['KsvmMdcId'])) {
        echo $KsvmPreciosXProveedor->__KsvmActualizarPreciosXProveedorControlador();
    }
    
} else {
    session_start(['name' => 'SIGIM']);
    session_destroy();
    echo '<script> window.location.href=" '.KsvmServUrl.'Login"</script>';
}
