<?php

/**
*Petición Ajax para mostrar un inventario
*/

$KsvmPeticionAjax = true;
require_once "../Raiz/KsvmConfiguracion.php";

    require_once "../Archivos/KsvmMostrarRegistrosInventario.php";
    $KsvmIniInv = new KsvmMostrarRegistrosInventario();

    echo $KsvmIniInv->__KsvmMostrarRegistros();