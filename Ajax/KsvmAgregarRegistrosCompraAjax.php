<?php

/**
*Petición Ajax para registrar editar o eliminar una Inventario
*/
$KsvmPeticionAjax = true;
require_once "../Raiz/KsvmConfiguracion.php";

if (isset($_POST['KsvmMdcId']) && isset($_POST['KsvmCantOcp']) && isset($_POST['KsvmValorUntOcp'])) {
    require_once "../Controladores/KsvmCompraControlador.php";
    $KsvmIniCompra = new KsvmCompraControlador();

    echo $KsvmIniCompra->__KsvmAgregarDetalleCompraControlador();
    
} else {
    session_start(['name' => 'SIGIM']);
    session_destroy();
    echo '<script> window.location.href=" '.KsvmServUrl.'Login"</script>';
}