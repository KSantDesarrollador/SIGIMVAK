<?php

/**
*Petición Ajax para registrar editar o eliminar una procedencia
*/
$KsvmPeticionAjax = true;
require_once "../Raiz/KsvmConfiguracion.php";

if (isset($_POST['id'])) {
    require_once "../Controladores/KsvmProcedenciaControlador.php";
    $KsvmIniProcedencia = new KsvmProcedenciaControlador();

    echo $KsvmIniProcedencia->__KsvmSeleccionarProvincia();

} else {
    session_start(['name' => 'SIGIM']);
    session_destroy();
    echo '<script> window.location.href=" '.KsvmServUrl.'Login"</script>';
}
