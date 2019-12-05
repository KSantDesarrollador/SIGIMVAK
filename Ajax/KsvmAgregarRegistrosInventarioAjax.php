<?php

/**
*Petición Ajax para registrar editar o eliminar una Inventario
*/
$KsvmPeticionAjax = true;
require_once "../Raiz/KsvmConfiguracion.php";

if (isset($_POST['KsvmExtId']) && isset($_POST['KsvmStockInv']) && isset($_POST['KsvmContFisInv'])) {
    require_once "../Controladores/KsvmInventarioControlador.php";
    $KsvmIniInventario = new KsvmInventarioControlador();

    echo $KsvmIniInventario->__KsvmAgregarDetalleInventarioControlador();
    
} else {
    session_start(['name' => 'SIGIM']);
    session_destroy();
    echo '<script> window.location.href=" '.KsvmServUrl.'Login"</script>';
}
