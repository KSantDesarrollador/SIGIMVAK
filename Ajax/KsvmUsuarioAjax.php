<?php

/**
*Petición Ajax para registrar editar o eliminar un usuario
*/
$KsvmPeticionAjax = true;
require_once "../Raiz/KsvmConfiguracion.php";

if (isset($_POST['KsvmRol']) || isset($_POST['KsvmCodDelete']) || isset($_POST['KsvmCodEdit'])) {
    require_once "../Controladores/KsvmUsuarioControlador.php";
    $KsvmIniUsuario = new KsvmUsuarioControlador();

    if (!isset($_POST['KsvmCodDelete']) && !isset($_POST['KsvmCodEdit']) && isset($_POST['KsvmTelf']) && isset($_POST['KsvmEmail']) &&
          isset($_POST['KsvmNomUsu']) && isset($_POST['KsvmContra']) && isset($_POST['KsvmConContra'])) {

          echo $KsvmIniUsuario->__KsvmAgregarUsuarioControlador();
    }

    if (isset($_POST['KsvmCodDelete'])) {
        echo $KsvmIniUsuario->__KsvmEliminarUsuarioControlador();
    }

    if (isset($_POST['KsvmCodEdit']) && isset($_POST['KsvmNomUsu'])) {
        echo $KsvmIniUsuario->__KsvmActualizarUsuarioControlador();
    }

    if (isset($_POST['KsvmCodEdit']) && isset($_POST['KsvmContra']) && !isset($_POST['KsvmNomUsu'])) {
        echo $KsvmIniUsuario->__KsvmActualizarPerfilControlador();
    }
} else {
    session_start();
    session_destroy();
    echo '<script> window.location.href=" '.KsvmServUrl.'Login"</script>';
}
