<?php

/**
*Petición Ajax para registrar editar o eliminar un medicamento
*/
$KsvmPeticionAjax = true;
require_once "../Raiz/KsvmConfiguracion.php";

if (isset($_POST['KsvmCodMed']) || isset($_POST['KsvmCodDelete']) || isset($_POST['KsvmCodEdit'])) {
    require_once "../Controladores/KsvmMedicamentoControlador.php";
    $KsvmIniMedicamento = new KsvmMedicamentoControlador();

    if (!isset($_POST['KsvmCodDelete']) && !isset($_POST['KsvmCodEdit']) && isset($_POST['KsvmCodMed']) && isset($_POST['KsvmDescMed']) &&
          isset($_POST['KsvmPresenMed']) && isset($_POST['KsvmConcenMed']) && isset($_POST['KsvmNivPrescMed']) && isset($_POST['KsvmNivAtencMed']) && 
          isset($_POST['KsvmViaAdmMed'])) {

          echo $KsvmIniMedicamento->__KsvmAgregarMedicamentoControlador();
    }

    if (isset($_POST['KsvmCodDelete'])) {
        echo $KsvmIniMedicamento->__KsvmEliminarMedicamentoControlador();
    }

    if (isset($_POST['KsvmCodEdit']) && isset($_POST['KsvmCodMed'])) {
        echo $KsvmIniMedicamento->__KsvmActualizarMedicamentoControlador();
    }
    
} else {
    // session_start(['name' => 'SIGIM']);
    // session_destroy();
    // echo '<script> window.location.href=" '.KsvmServUrl.'Login"</script>';
}
