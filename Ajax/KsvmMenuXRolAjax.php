<?php

/**
*Petición Ajax para registrar editar o eliminar un Privilegio
*/
$KsvmPeticionAjax = true;
require_once "../Raiz/KsvmConfiguracion.php";

if (isset($_POST['KsvmRrlId']) || isset($_POST['KsvmCodDelete']) || isset($_POST['KsvmCodEdit'])) {
    require_once "../Controladores/KsvmMenuxRolControlador.php";
    $KsvmIniMenRol = new KsvmMenuxRolControlador();

    if (!isset($_POST['KsvmCodDelete']) && !isset($_POST['KsvmCodEdit']) && isset($_POST['KsvmRrlId']) && isset($_POST['KsvmMnuId'])) {

          echo $KsvmIniMenRol->__KsvmAgregarMenuxRolControlador();
    }

    if (isset($_POST['KsvmCodDelete'])) {
        echo $KsvmIniMenRol->__KsvmEliminarMenuxRolControlador();
    }

    if (isset($_POST['KsvmCodEdit']) && isset($_POST['KsvmRrlId'])) {
        echo $KsvmIniMenRol->__KsvmActualizarMenuxRolControlador();
    }
    
} else {
    session_start(['name' => 'SIGIM']);
    session_destroy();
    echo '<script> window.location.href=" '.KsvmServUrl.'Login"</script>';
}
