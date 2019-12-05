<?php

/**
*Petición Ajax para mostrar un Egreso
*/

$KsvmPeticionAjax = true;
require_once "../Raiz/KsvmConfiguracion.php";

    require_once "../Archivos/KsvmMostrarRegistrosEgreso.php";
    $KsvmIniEgr = new KsvmMostrarRegistrosEgreso();

    echo $KsvmIniEgr->__KsvmMostrarRegistros();