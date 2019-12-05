<?php

/**
*Petición Ajax para registrar editar o eliminar un rol
*/
$KsvmPeticionAjax = true;
require_once "../Raiz/KsvmConfiguracion.php";

if (isset($_POST['KsvmNomRol']) || isset($_POST['KsvmCodDelete']) || isset($_POST['KsvmCodEdit'])) {
    require_once "../Controladores/KsvmRolControlador.php";
    $KsvmIniRol = new KsvmRolControlador();

    if (!isset($_POST['KsvmCodDelete']) && !isset($_POST['KsvmCodEdit']) && isset($_POST['KsvmNomRol'])) {

          echo $KsvmIniRol->__KsvmAgregarRolControlador();
    }

    if (isset($_POST['KsvmCodDelete'])) {
        echo $KsvmIniRol->__KsvmEliminarRolControlador();
    }

    if (isset($_POST['KsvmCodEdit']) && isset($_POST['KsvmNomRol'])) {
        echo $KsvmIniRol->__KsvmActualizarRolControlador();
    }
    
} else {
    session_start(['name' => 'SIGIM']);
    session_destroy();
    echo '<script> window.location.href=" '.KsvmServUrl.'Login"</script>';
}
