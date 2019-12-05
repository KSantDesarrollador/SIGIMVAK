<?php

/**
*Petición Ajax para registrar editar o eliminar un empleado
*/
$KsvmPeticionAjax = true;
require_once "../Raiz/KsvmConfiguracion.php";

if (isset($_POST['KsvmIdent']) || isset($_POST['KsvmCodDelete']) || isset($_POST['KsvmCodEdit'])) {
    require_once "../Controladores/KsvmEmpleadoControlador.php";
    $KsvmIniEmpleado = new KsvmEmpleadoControlador();

    if (!isset($_POST['KsvmCodDelete']) && !isset($_POST['KsvmCodEdit']) && isset($_POST['KsvmTipoIdent']) && isset($_POST['KsvmIdent']) &&
          isset($_POST['KsvmPrimApel']) && isset($_POST['KsvmPrimNom']) && isset($_POST['KsvmFchNac']) && isset($_POST['KsvmDirc']) && isset($_POST['KsvmTelf']) &&
          isset($_POST['KsvmEstCiv']) && isset($_POST['KsvmSexo'])) {

          echo $KsvmIniEmpleado->__KsvmAgregarEmpleadoControlador();
    }

    if (isset($_POST['KsvmCodDelete'])) {
        echo $KsvmIniEmpleado->__KsvmEliminarEmpleadoControlador();
    }

    if (isset($_POST['KsvmCodEdit']) && isset($_POST['KsvmIdent'])) {
        echo $KsvmIniEmpleado->__KsvmActualizarEmpleadoControlador();
    }
    
} else {
    session_start(['name' => 'SIGIM']);
    session_destroy();
    echo '<script> window.location.href=" '.KsvmServUrl.'Login"</script>';
}
