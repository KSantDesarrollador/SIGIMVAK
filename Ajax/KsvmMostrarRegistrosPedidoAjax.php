<?php

/**
*Petición Ajax para mostrar un pedido
*/

$KsvmPeticionAjax = true;
require_once "../Raiz/KsvmConfiguracion.php";

    require_once "../Archivos/KsvmMostrarRegistrosPedido.php";
    $KsvmIniReq = new KsvmMostrarRegistrosPedido();

    echo $KsvmIniReq->__KsvmMostrarRegistros();