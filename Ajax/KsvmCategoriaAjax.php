<?php

/**
*Petición Ajax para registrar editar o eliminar una categoría
*/
$KsvmPeticionAjax = true;
require_once "../Raiz/KsvmConfiguracion.php";

if (isset($_POST['KsvmNomCat']) || isset($_POST['KsvmCodDelete']) || isset($_POST['KsvmCodEdit'])) {
    require_once "../Controladores/KsvmCategoriaControlador.php";
    $KsvmIniCategoria = new KsvmCategoriaControlador();

    if (!isset($_POST['KsvmCodDelete']) && !isset($_POST['KsvmCodEdit']) && isset($_POST['KsvmNomCat']) && isset($_POST['KsvmColorCat'])){

          echo $KsvmIniCategoria->__KsvmAgregarCategoriaControlador();
    }

    if (isset($_POST['KsvmCodDelete'])) {
        echo $KsvmIniCategoria->__KsvmEliminarCategoriaControlador();
    }

    if (isset($_POST['KsvmCodEdit']) && isset($_POST['KsvmNomCat'])) {
        echo $KsvmIniCategoria->__KsvmActualizarCategoriaControlador();
    }
    
} else {
    session_start(['name' => 'SIGIM']);
    session_destroy();
    echo '<script> window.location.href=" '.KsvmServUrl.'Login"</script>';
}
