<?php

/**
*Petición Ajax para registrar editar o eliminar una Bitacora
*/
$KsvmPeticionAjax = true;
require_once "../Raiz/KsvmConfiguracion.php";

if (isset($_POST['KsvmCodDelete'])) {
    require_once "../Controladores/KsvmBitacoraControlador.php";
    $KsvmIniBitacora = new KsvmBitacoraControlador();

    echo $KsvmIniBitacora->__KsvmEliminarBitacoraControlador();
    
} else {
    session_start(['name' => 'SIGIM']);
    session_destroy();
    echo '<script> window.location.href=" '.KsvmServUrl.'Login"</script>';
}