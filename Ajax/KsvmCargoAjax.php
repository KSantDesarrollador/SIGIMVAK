<?php

/**
*Petición Ajax para registrar editar o eliminar un cargo
*/
$KsvmPeticionAjax = true;
require_once "../Raiz/KsvmConfiguracion.php";

if (isset($_POST['KsvmNomCar']) || isset($_POST['KsvmCodDelete']) || isset($_POST['KsvmCodEdit'])) {
    require_once "../Controladores/KsvmCargoControlador.php";
    $KsvmIniCargo = new KsvmCargoControlador();

    if (!isset($_POST['KsvmCodDelete']) && !isset($_POST['KsvmCodEdit']) && isset($_POST['KsvmNomCar']) && isset($_POST['KsvmUmdId'])) {

          echo $KsvmIniCargo->__KsvmAgregarCargoControlador();
    }

    if (isset($_POST['KsvmCodDelete'])) {
        echo $KsvmIniCargo->__KsvmEliminarCargoControlador();
    }

    if (isset($_POST['KsvmCodEdit']) && isset($_POST['KsvmNomCar'])) {
        echo $KsvmIniCargo->__KsvmActualizarCargoControlador();
    }
    
} else {
    session_start(['name' => 'SIGIM']);
    session_destroy();
    echo '<script> window.location.href=" '.KsvmServUrl.'Login"</script>';
}
