<?php

/**
*Petición Ajax para registrar editar o eliminar una bodega
*/
$KsvmPeticionAjax = true;
require_once "../Raiz/KsvmConfiguracion.php";

if (isset($_POST['KsvmDescBod']) || isset($_POST['KsvmCodDelete']) || isset($_POST['KsvmCodEdit'])) {
    require_once "../Controladores/KsvmBodegaControlador.php";
    $KsvmIniBodega = new KsvmBodegaControlador();

    if (!isset($_POST['KsvmCodDelete']) && !isset($_POST['KsvmCodEdit']) && isset($_POST['KsvmDescBod']) && isset($_POST['KsvmTelfBod']) &&
          isset($_POST['KsvmDirBod'])) {

          echo $KsvmIniBodega->__KsvmAgregarBodegaControlador();
    }

    if (isset($_POST['KsvmCodDelete'])) {
        echo $KsvmIniBodega->__KsvmEliminarBodegaControlador();
    }

    if (isset($_POST['KsvmCodEdit']) && isset($_POST['KsvmDescBod'])) {
        echo $KsvmIniBodega->__KsvmActualizarBodegaControlador();
    }
    
} else {
    session_start(['name' => 'SIGIM']);
    session_destroy();
    echo '<script> window.location.href=" '.KsvmServUrl.'Login"</script>';
}
