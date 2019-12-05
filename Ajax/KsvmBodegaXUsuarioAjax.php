<?php

/**
*Petición Ajax para registrar editar o eliminar una asignación de un abodega a un usuario
*/
$KsvmPeticionAjax = true;
require_once "../Raiz/KsvmConfiguracion.php";

if (isset($_POST['KsvmBdgId']) || isset($_POST['KsvmCodDelete']) || isset($_POST['KsvmCodEdit'])) {
    require_once "../Controladores/KsvmBodxUsuControlador.php";
    $KsvmIniBodUsu = new KsvmBodxUsuControlador();

    if (!isset($_POST['KsvmCodDelete']) && !isset($_POST['KsvmCodEdit']) && isset($_POST['KsvmBdgId']) && isset($_POST['KsvmUsrId'])) {

          echo $KsvmIniBodUsu->__KsvmAgregarBodxUsuControlador();
    }

    if (isset($_POST['KsvmCodDelete'])) {
        echo $KsvmIniBodUsu->__KsvmEliminarBodxUsuControlador();
    }

    if (isset($_POST['KsvmCodEdit']) && isset($_POST['KsvmBdgId'])) {
        echo $KsvmIniBodUsu->__KsvmActualizarBodxUsuControlador();
    }
    
} else {
    session_start(['name' => 'SIGIM']);
    session_destroy();
    echo '<script> window.location.href=" '.KsvmServUrl.'Login"</script>';
}
