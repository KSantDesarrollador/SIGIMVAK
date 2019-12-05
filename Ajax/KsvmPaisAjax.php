<?php

/**
*Petición Ajax para registrar editar o eliminar una procedencia
*/

$KsvmPeticionAjax = true;
require_once "../Raiz/KsvmConfiguracion.php";

    require_once "../Controladores/KsvmProcedenciaControlador.php";
    $KsvmIniProcedencia = new KsvmProcedenciaControlador();

    echo $KsvmIniProcedencia->__KsvmSeleccionarPais();

