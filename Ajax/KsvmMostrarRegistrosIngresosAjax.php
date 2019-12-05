<?php

/**
*Petición Ajax para mostrar un Ingreso
*/

$KsvmPeticionAjax = true;
require_once "../Raiz/KsvmConfiguracion.php";

    require_once "../Archivos/KsvmMostrarRegistrosIngreso.php";
    $KsvmIniIng = new KsvmMostrarRegistrosIngreso();

    echo $KsvmIniIng->__KsvmMostrarRegistros();