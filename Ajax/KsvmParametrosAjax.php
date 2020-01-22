<?php

/**
*Petición Ajax para registrar editar o eliminar un parametro
*/
$KsvmPeticionAjax = true;
require_once "../Raiz/KsvmConfiguracion.php";

if (isset($_POST['KsvmMdcId']) || isset($_POST['KsvmCodDelete']) || isset($_POST['KsvmCodEdit'])) {
    require_once "../Controladores/KsvmParametrosControlador.php";
    $KsvmIniParametros = new KsvmParametrosControlador();

    if (!isset($_POST['KsvmCodDelete']) && !isset($_POST['KsvmCodEdit']) && isset($_POST['KsvmMdcId']) && isset($_POST['KsvmAltId'])){

          echo $KsvmIniParametros->__KsvmAgregarParametrosControlador();
    }

    if (isset($_POST['KsvmCodDelete'])) {
        echo $KsvmIniParametros->__KsvmEliminarParametrosControlador();
    }

    if (isset($_POST['KsvmCodEdit']) && isset($_POST['KsvmMdcId'])) {
        echo $KsvmIniParametros->__KsvmActualizarParametrosControlador();
    }
    
} else {
    session_start(['name' => 'SIGIM']);
    session_destroy();
    echo '<script> window.location.href=" '.KsvmServUrl.'Login"</script>';
}
