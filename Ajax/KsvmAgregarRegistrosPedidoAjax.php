<?php

/**
*Petición Ajax para registrar editar o eliminar un pedido
*/
$KsvmPeticionAjax = true;
require_once "../Raiz/KsvmConfiguracion.php";

if (isset($_POST['KsvmExtId']) && isset($_POST['KsvmCantReq'])) {
    require_once "../Controladores/KsvmRequisicionControlador.php";
    $KsvmIniRequisicion = new KsvmRequisicionControlador();

    echo $KsvmIniRequisicion->__KsvmAgregarDetalleRequisicionControlador();
    
} else {
    session_start(['name' => 'SIGIM']);
    session_destroy();
    echo '<script> window.location.href=" '.KsvmServUrl.'Login"</script>';
}