<?php

/**
*Petición Ajax para mostrar una Compra
*/

$KsvmPeticionAjax = true;
require_once "../Raiz/KsvmConfiguracion.php";

    require_once "../Archivos/KsvmMostrarRegistrosCompra.php";
    $KsvmIniCompra = new KsvmMostrarRegistrosCompra();

    echo $KsvmIniCompra->__KsvmMostrarRegistros();