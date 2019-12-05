<?php

/**
*Petición Ajax para registrar editar o eliminar un proveedor
*/
$KsvmPeticionAjax = true;
require_once "../Raiz/KsvmConfiguracion.php";

if (isset($_POST['KsvmIdentProv']) || isset($_POST['KsvmCodDelete']) || isset($_POST['KsvmCodEdit'])) {
    require_once "../Controladores/KsvmProveedorControlador.php";
    $KsvmIniProveedor = new KsvmProveedorControlador();

    if (!isset($_POST['KsvmCodDelete']) && !isset($_POST['KsvmCodEdit']) && isset($_POST['KsvmIdentProv']) && isset($_POST['KsvmRazSocProv']) &&
          isset($_POST['KsvmTelfProv']) && isset($_POST['KsvmDirProv']) && isset($_POST['KsvmEmailProv'])) {

          echo $KsvmIniProveedor->__KsvmAgregarProveedorControlador();
    }

    if (isset($_POST['KsvmCodDelete'])) {
        echo $KsvmIniProveedor->__KsvmEliminarProveedorControlador();
    }

    if (isset($_POST['KsvmCodEdit']) && isset($_POST['KsvmIdentProv'])) {
        echo $KsvmIniProveedor->__KsvmActualizarProveedorControlador();
    }
    
} else {
    session_start(['name' => 'SIGIM']);
    session_destroy();
    echo '<script> window.location.href=" '.KsvmServUrl.'Login"</script>';
}
