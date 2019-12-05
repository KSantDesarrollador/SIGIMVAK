<?php

/**
*Petición Ajax para registrar editar o eliminar una Transacción
*/
$KsvmPeticionAjax = true;
require_once "../Raiz/KsvmConfiguracion.php";

if (isset($_POST['KsvmExtId']) && isset($_POST['KsvmCantTran'])) {
    require_once "../Controladores/KsvmTransaccionControlador.php";
    $KsvmIniTransaccion = new KsvmTransaccionControlador();

    echo $KsvmIniTransaccion->__KsvmAgregarDetalleTransaccionControlador();
    
} else {
    session_start(['name' => 'SIGIM']);
    session_destroy();
    echo '<script> window.location.href=" '.KsvmServUrl.'Login"</script>';
}