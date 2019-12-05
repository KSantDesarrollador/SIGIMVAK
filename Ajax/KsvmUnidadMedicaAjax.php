<?php

/**
*Petición Ajax para registrar editar o eliminar una unidad médica
*/
$KsvmPeticionAjax = true;
require_once "../Raiz/KsvmConfiguracion.php";

if (isset($_POST['KsvmIdent']) || isset($_POST['KsvmCodDelete']) || isset($_POST['KsvmCodEdit'])) {
    require_once "../Controladores/KsvmUnidadMedicaControlador.php";
    $KsvmIniUnidadMed = new KsvmUnidadMedicaControlador();

    if (!isset($_POST['KsvmCodDelete']) && !isset($_POST['KsvmCodEdit']) && isset($_POST['KsvmIdentUdm']) && isset($_POST['KsvmNomUdm']) &&
          isset($_POST['KsvmTelfUdm']) && isset($_POST['KsvmDirUdm']) && isset($_POST['KsvmEmailUdm'])) {

          echo $KsvmIniUnidadMed->__KsvmAgregarUnidadMedicaControlador();
    }

    if (isset($_POST['KsvmCodDelete'])) {
        echo $KsvmIniUnidadMed->__KsvmEliminarUnidadMedicaControlador();
    }

    if (isset($_POST['KsvmCodEdit']) && isset($_POST['KsvmIdent'])) {
        echo $KsvmIniUnidadMed->__KsvmActualizarUnidadMedicaControlador();
    }
    
} else {
    session_start(['name' => 'SIGIM']);
    session_destroy();
    echo '<script> window.location.href=" '.KsvmServUrl.'Login"</script>';
}
