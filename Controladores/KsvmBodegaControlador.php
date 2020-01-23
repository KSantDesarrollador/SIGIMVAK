<?php

  /**
   *Condicion para peticion Ajax
   */
   if ($KsvmPeticionAjax) {
       require_once "../Modelos/KsvmBodegaModelo.php";
   } else {
       require_once "./Modelos/KsvmBodegaModelo.php";
   }

   class KsvmBodegaControlador extends KsvmBodegaModelo
   {
     /**
      *Función que permite ingresar una bodega
      */
     public function __KsvmAgregarBodegaControlador()
     {
         $KsvmUmdId = KsvmEstMaestra :: __KsvmFiltrarCadena($_POST['KsvmUmdId']);
         $KsvmDescBod = KsvmEstMaestra :: __KsvmFiltrarCadena($_POST['KsvmDescBod']);
         $KsvmTelfBod = KsvmEstMaestra :: __KsvmFiltrarCadena($_POST['KsvmTelfBod']);
         $KsvmDirBod = KsvmEstMaestra :: __KsvmFiltrarCadena($_POST['KsvmDirBod']);

         $KsvmNomBod = "SELECT BdgDescBod FROM ksvmvistabodegas WHERE BdgDescBod ='$KsvmDescBod'";
         $KsvmQuery = KsvmEstMaestra :: __KsvmEjecutaConsulta($KsvmNomBod);
         if ($KsvmQuery->rowCount() == 1) {
            $KsvmAlerta = [
              "Alerta" => "simple",
              "Titulo" => "Error inesperado",
              "Cuerpo" => "El nombre de bodega ingresado ya se encuentra registrado, Por favor ingrese un nombre válido",
              "Tipo" => "info"
             ];

            }else{
                $KsvmBodega = "SELECT BdgId FROM ksvmbodega05";
                $KsvmQuery = KsvmEstMaestra :: __KsvmEjecutaConsulta($KsvmBodega);
                $KsvmNum = ($KsvmQuery->rowCount())+1;
       
                $KsvmCodigo = KsvmEstMaestra :: __KsvmGeneraCodigoAleatorio("BD", 4, $KsvmNum);

                $KsvmNuevaBod = [
                "KsvmUmdId" => $KsvmUmdId,
                "KsvmDescBod" => $KsvmDescBod,
                "KsvmTelfBod" => $KsvmTelfBod,
                "KsvmDirBod" => $KsvmDirBod,
                "KsvmCodBod" => $KsvmCodigo
                ];

                $KsvmGuardarBod = KsvmBodegaModelo :: __KsvmAgregarBodegaModelo($KsvmNuevaBod);
                if ($KsvmGuardarBod->rowCount() >= 1) {
                    $KsvmAlerta = [
                    "Alerta" => "Actualiza",
                    "Titulo" => "Grandioso",
                    "Cuerpo" => "La bodega se registró satisfactoriamente",
                    "Tipo" => "success"
                    ];
                } else {
                    $KsvmAlerta = [
                    "Alerta" => "simple",
                    "Titulo" => "Error inesperado",
                    "Cuerpo" => "No se a podido registrar la bodega",
                    "Tipo" => "info"
                    ];
                }
                
            }
            return KsvmEstMaestra :: __KsvmMostrarAlertas($KsvmAlerta);
        }
            
    /**
     * Función que permite paginar 
     */
      public function __KsvmPaginador($KsvmPagina, $KsvmNRegistros, $KsvmRol, $KsvmCodigo, $KsvmBuscar)
      {
        $KsvmPagina = KsvmEstMaestra :: __KsvmFiltrarCadena($KsvmPagina);
        $KsvmNRegistros = KsvmEstMaestra :: __KsvmFiltrarCadena($KsvmNRegistros);
        $KsvmRol = KsvmEstMaestra :: __KsvmFiltrarCadena($KsvmRol);
        $KsvmCodigo = KsvmEstMaestra :: __KsvmFiltrarCadena($KsvmCodigo);
        $KsvmBuscar = KsvmEstMaestra :: __KsvmFiltrarCadena($KsvmBuscar);
        $KsvmTabla = "";
        
        $KsvmPagina = (isset($KsvmPagina) && $KsvmPagina > 0 ) ? (int)$KsvmPagina : 1;
        $KsvmDesde = ($KsvmPagina > 0) ? (($KsvmPagina*$KsvmNRegistros) - $KsvmNRegistros) : 0;

        if (isset($KsvmBuscar) && $KsvmBuscar != "") {
            $KsvmDataBod = "SELECT SQL_CALC_FOUND_ROWS * FROM ksvmvistabodegas WHERE ((BdgEstBod = 'A') AND (BdgCodBod LIKE '%$KsvmBuscar%' 
                            OR BdgDescBod LIKE '%$KsvmBuscar%')) LIMIT $KsvmDesde, $KsvmNRegistros";
        } else {
            $KsvmDataBod = "SELECT SQL_CALC_FOUND_ROWS * FROM ksvmvistabodegas WHERE BdgEstBod = 'A' LIMIT $KsvmDesde, $KsvmNRegistros" ;
        }
        

        $KsvmConsulta = KsvmEstMaestra :: __KsvmConexion();
    
        $KsvmQuery = $KsvmConsulta->query($KsvmDataBod);
        $KsvmQuery = $KsvmQuery->fetchAll();
        
        $KsvmDataTot = "SELECT FOUND_ROWS()";
        $KsvmTotalReg = $KsvmConsulta->query($KsvmDataTot);
        $KsvmTotalReg = (int) $KsvmTotalReg->fetchColumn();
        $KsvmNPaginas = ceil($KsvmTotalReg/$KsvmNRegistros);

        $KsvmTabla .= '<table class="mdl-data-table mdl-js-data-table mdl-shadow--6dp full-width table-responsive">
                        <thead>
                            <tr>
                                <th class="mdl-data-table__cell--non-numeric">#</th>
                                <th class="mdl-data-table__cell--non-numeric">Codigo</th>
                                <th class="mdl-data-table__cell--non-numeric">Nombre</th>
                                <th class="mdl-data-table__cell--non-numeric">Telf</th>
                                <th class="mdl-data-table__cell--non-numeric">Dirección</th>
                                <th class="mdl-data-table__cell--non-numeric">Ud Médica</th>
                                <th style="text-align:center; witdh:30px;">Acción</th>
                            </tr>
                        </thead>
                        <tbody>';

        if ($KsvmTotalReg >= 1 && $KsvmPagina <= $KsvmNPaginas) {
            $KsvmContReg = $KsvmDesde +1;
            foreach ($KsvmQuery as $rows) {
                $KsvmTabla .= '<tr>
                                <td class="mdl-data-table__cell--non-numeric">'.$KsvmContReg.'</td>
                                <td class="mdl-data-table__cell--non-numeric">'.$rows['BdgCodBod'].'</td>
                                <td class="mdl-data-table__cell--non-numeric">'.$rows['BdgDescBod'].'</td>
                                <td class="mdl-data-table__cell--non-numeric">'.$rows['BdgTelfBod'].'</td>
                                <td class="mdl-data-table__cell--non-numeric">'.$rows['BdgDirBod'].'</td>
                                <td class="mdl-data-table__cell--non-numeric">'.$rows['UmdNomUdm'].'</td>
                                <td style="text-align:right; witdh:30px;">';
                                if ($KsvmRol == 1) {
                                    if ($KsvmCodigo == 0) {

                                    $KsvmTabla .=  '<form action="'.KsvmServUrl.'Ajax/KsvmRequisicionAjax.php" method="POST" class="FormularioAjax" data-form="eliminar" enctype="multipart/form-data"> 
                                                    <a id="btn-detail" class="btn btn-sm btn-info" href="'.KsvmServUrl.'KsvmBodegasCrud/Detail/'.KsvmEstMaestra::__KsvmEncriptacion($rows['BdgId']).'/"><i class="zmdi zmdi-card"></i></a>
                                                    <div class="mdl-tooltip" for="btn-detail">Detalles</div>
                                                    <a id="btn-edit" class="btn btn-sm btn-primary" href="'.KsvmServUrl.'KsvmBodegasEditar/'.KsvmEstMaestra::__KsvmEncriptacion($rows['BdgId']).'/0/"><i class="zmdi zmdi-edit"></i></a>
                                                    <div class="mdl-tooltip" for="btn-edit">Editar</div>
                                                    <input type="hidden" name="KsvmCodDelete" value="'.KsvmEstMaestra::__KsvmEncriptacion($rows['BdgId']).'">              
                                                    <button id="btn-delete" type="submit" class="btn btn-sm btn-danger"><i class="zmdi zmdi-delete"></i></button>
                                                    <div class="RespuestaAjax"></div>
                                                    </form>';
                                    } else {
                                    $KsvmTabla .= '<form action="'.KsvmServUrl.'Ajax/KsvmRequisicionAjax.php" method="POST" class="FormularioAjax" data-form="eliminar" enctype="multipart/form-data"> 
                                                    <a id="btn-detail" class="btn btn-sm btn-info" href="'.KsvmServUrl.'KsvmBodegas/Detail/'.KsvmEstMaestra::__KsvmEncriptacion($rows['BdgId']).'"><i class="zmdi zmdi-card"></i></a>
                                                    <div class="mdl-tooltip" for="btn-detail">Detalles</div>
                                                    <a id="btn-edit" class="btn btn-sm btn-primary" href="'.KsvmServUrl.'KsvmBodegasEditar/'.KsvmEstMaestra::__KsvmEncriptacion($rows['BdgId']).'/1/"><i class="zmdi zmdi-edit"></i></a>
                                                    <div class="mdl-tooltip" for="btn-edit">Editar</div>
                                                    <input type="hidden" name="KsvmCodDelete" value="'.KsvmEstMaestra::__KsvmEncriptacion($rows['BdgId']).'">              
                                                    <button id="btn-delete" type="submit" class="btn btn-sm btn-danger"><i class="zmdi zmdi-delete"></i></button>
                                                    <div class="mdl-tooltip" for="btn-delete">Inhabilitar</div>
                                                    <div class="RespuestaAjax"></div>
                                                    </form>';
                                    }
                                }elseif ($KsvmRol == 2 || $KsvmRol == 3){
                                    $KsvmTabla .= '<a id="btn-detail" class="btn btn-sm btn-info" href="'.KsvmServUrl.'KsvmBodegas/Detail/'.KsvmEstMaestra::__KsvmEncriptacion($rows['BdgId']).'/"><i class="zmdi zmdi-card"></i></a>
                                                    <div class="mdl-tooltip" for="btn-detail">Detalles</div>
                                                    <a id="btn-edit" class="btn btn-sm btn-primary" href="'.KsvmServUrl.'KsvmBodegasEditar/'.KsvmEstMaestra::__KsvmEncriptacion($rows['BdgId']).'/1/"><i class="zmdi zmdi-edit"></i></a>
                                                    <div class="mdl-tooltip" for="btn-edit">Editar</div>';
                                }else{
                                    $KsvmTabla .= '<a id="btn-detail" class="btn btn-sm btn-info" href="'.KsvmServUrl.'KsvmBodegas/Detail/'.KsvmEstMaestra::__KsvmEncriptacion($rows['BdgId']).'/"><i class="zmdi zmdi-card"></i></a>
                                                    <div class="mdl-tooltip" for="btn-detail">Detalles</div>';
                                }

                                    

                $KsvmTabla .= '</td>
                               </tr>
                             </tbody>';
                             $KsvmContReg ++;
                             }

                            
                $KsvmTabla .= '</table>

                           <br>
				           <div class=" mdl-shadow--8dp full-width">
                            <nav class="navbar-form navbar-left form-group">
				            <span class="">
				             <strong>Total de '.$KsvmTotalReg.' </strong> registros encontrados
				            </span>
				            <span>&nbsp;|&nbsp;</span>
				            <span>
							 Página<strong>'.$KsvmPagina.'</strong> de <strong>'.$KsvmNPaginas.'</strong>
				            </span>
                            <span>&nbsp;|&nbsp;</span>
                            </nav>';
                            
        } else {
            if ($KsvmTotalReg >= 1) {
                echo '<script> window.location.href=" '.KsvmServUrl.'KsvmBodegasCrud"</script>';
            } else {
                $KsvmTabla .= '<tr> 
                            <td class="mdl-data-table__cell--non-numeric" colspan="7"><strong>No se encontraron registros...</strong></td>
                           </tr>
                          </tbody>
                          </table>';

            }
        }
            if ($KsvmTotalReg >= 1 && $KsvmPagina <= $KsvmNPaginas && $KsvmCodigo == 0) {

                $KsvmTabla .= '<nav class="navbar-form navbar-right form-group">';
                
                if ($KsvmPagina == 1) {
                    $KsvmTabla .= '<button class = "btn btn-xs btn-success mdl-shadow--8dp disabled">Primero</button>
                                   <span></span>
                                   <button class = "btn btn-xs btn-default mdl-shadow--8dp disabled"><i class="zmdi zmdi-fast-rewind"></i></button>';
                } else {
                    $KsvmTabla .= '<a class = "btn btn-xs btn-success mdl-shadow--8dp " href="'.KsvmServUrl.'KsvmBodegasCrud/1/">Primero</a>
                                   <span></span>
                                   <a class = "btn btn-xs btn-default mdl-shadow--8dp " href="'.KsvmServUrl.'KsvmBodegasCrud/'.($KsvmPagina-1).'/"><i class="zmdi zmdi-fast-rewind"></i></a>';
                }

                if ($KsvmPagina == $KsvmNPaginas) {
                    $KsvmTabla .= '<button class = "btn btn-xs btn-default mdl-shadow--8dp disabled"><i class="zmdi zmdi-fast-forward"></i></button>
                                   <span></span>
                                   <button class = "btn btn-xs btn-success mdl-shadow--8dp disabled">Último</button>';
                } else {
                    $KsvmTabla .= '<a class="btn btn-xs btn-default mdl-shadow--8dp" href="'.KsvmServUrl.'KsvmBodegasCrud/'.($KsvmPagina+1).'/"><i class="zmdi zmdi-fast-forward"></i></a>
                                   <span></span>
                                   <a class="btn btn-xs btn-success mdl-shadow--8dp" href="'.KsvmServUrl.'KsvmBodegasCrud/'.($KsvmNPaginas).'/">Último</a>';
                                   
                                   
                }
                
             
                $KsvmTabla .= '</nav></div>';      

            } else {
                $KsvmTabla .= '<nav class="navbar-form navbar-right form-group">';
                
                if ($KsvmPagina == 1) {
                    $KsvmTabla .= '<button class = "btn btn-xs btn-success mdl-shadow--8dp disabled">Primero</button>
                                   <span></span>
                                   <button class = "btn btn-xs btn-default mdl-shadow--8dp disabled"><i class="zmdi zmdi-fast-rewind"></i></button>';
                } else {
                    $KsvmTabla .= '<a class = "btn btn-xs btn-success mdl-shadow--8dp " href="'.KsvmServUrl.'KsvmBodegas/1/">Primero</a>
                                   <span></span>
                                   <a class = "btn btn-xs btn-default mdl-shadow--8dp " href="'.KsvmServUrl.'KsvmBodegas/'.($KsvmPagina-1).'/"><i class="zmdi zmdi-fast-rewind"></i></a>';
                }

                if ($KsvmPagina == $KsvmNPaginas) {
                    $KsvmTabla .= '<button class = "btn btn-xs btn-default mdl-shadow--8dp disabled"><i class="zmdi zmdi-fast-forward"></i></button>
                                   <span></span>
                                   <button class = "btn btn-xs btn-success mdl-shadow--8dp disabled">Último</button>';
                } else {
                    $KsvmTabla .= '<a class="btn btn-xs btn-default mdl-shadow--8dp" href="'.KsvmServUrl.'KsvmBodegas/'.($KsvmPagina+1).'/"><i class="zmdi zmdi-fast-forward"></i></a>
                                   <span></span>
                                   <a class="btn btn-xs btn-success mdl-shadow--8dp" href="'.KsvmServUrl.'KsvmBodegas/'.($KsvmNPaginas).'/">Último</a>';
                                   
                                   
                }
                
                $KsvmTabla .= '</nav></div>'; 
            }
            
        
                                   
        return $KsvmTabla;
      }
     
      /**
       * Función que permite inhabilitar una bodega
       */
      public function __KsvmEliminarBodegaControlador()
      {
         $KsvmCode = KsvmEstMaestra :: __KsvmDesencriptacion($_POST['KsvmCodDelete']);
         $KsvmCodBod = KsvmEstMaestra :: __KsvmFiltrarCadena($KsvmCode);

             $KsvmDelBod = KsvmBodegaModelo :: __KsvmEliminarBodegaModelo($KsvmCodBod);
             if ($KsvmDelBod->rowCount() == 1) {
                $KsvmAlerta = [
                    "Alerta" => "Actualiza",
                    "Titulo" => "Bodega Inhabilitada",
                    "Cuerpo" => "El empleado seleccionado ha sido inhabilitado con éxito",
                    "Tipo" => "success"
                    ];
             
                } else {
                    $KsvmAlerta = [
                        "Alerta" => "simple",
                        "Titulo" => "Error inesperado",
                        "Cuerpo" => "No es posible inhabilitar la bodega del sistema",
                        "Tipo" => "info"
                        ];
                }

         return KsvmEstMaestra :: __KsvmMostrarAlertas($KsvmAlerta);
      }
    
      /**
       * Función que permite editar una bodega
       */
      public function __KsvmEditarBodegaControlador($KsvmCodBodega)
      {
          $KsvmCodigo = KsvmEstMaestra :: __KsvmDesencriptacion($KsvmCodBodega);

          return KsvmBodegaModelo :: __KsvmEditarBodegaModelo($KsvmCodigo);
      }
      
      /**
       * Función que permite contar una bodega
       */
      public function __KsvmContarBodegaControlador()
      {
          return KsvmBodegaModelo :: __KsvmContarBodegaModelo(0);
      }

      /**
       * Función que permite imprimir una bodega 
       */
      public function __KsvmImprimirBodegaControlador()
      {
        return KsvmBodegaModelo :: __KsvmImprimirBodegaModelo();
      }

      /**
       * Función que permite actualizar una bodega
       */
      public function __KsvmActualizarBodegaControlador()
      {
        $KsvmCodBod = KsvmEstMaestra :: __KsvmDesencriptacion($_POST['KsvmCodEdit']);
        $KsvmUmdId = KsvmEstMaestra :: __KsvmFiltrarCadena($_POST['KsvmUmdId']);
        $KsvmDescBod = KsvmEstMaestra :: __KsvmFiltrarCadena($_POST['KsvmDescBod']);
        $KsvmTelfBod = KsvmEstMaestra :: __KsvmFiltrarCadena($_POST['KsvmTelfBod']);
        $KsvmDirBod = KsvmEstMaestra :: __KsvmFiltrarCadena($_POST['KsvmDirBod']);

        $KsvmConsulta = "SELECT * FROM ksvmvistabodegas WHERE BdgId = '$KsvmCodBod'";
        $KsvmQuery = KsvmEstMaestra :: __KsvmEjecutaConsulta($KsvmConsulta);
        $KsvmDataBodega = $KsvmQuery->fetch();

        if ($KsvmDescBod != $KsvmDataBodega['BdgDescBod']) {
            $KsvmConsulta = "SELECT BdgDescBod FROM ksvmvistabodegas WHERE BdgDescBod = '$KsvmDescBod'";
            $KsvmQuery = KsvmEstMaestra :: __KsvmEjecutaConsulta($KsvmConsulta);
            if ($KsvmQuery->rowCount() >= 1) {
                $KsvmAlerta = [
                    "Alerta" => "Actualiza",
                    "Titulo" => "Error Inesperado",
                    "Cuerpo" => "El nombre de bodega ingresado ya se encuentra registrado, Por favor ingrese un número válido",
                    "Tipo" => "info"
                    ];
                    return KsvmEstMaestra :: __KsvmMostrarAlertas($KsvmAlerta);
                    exit();
            }
        }

        $KsvmActualBod = [
            "KsvmUmdId" => $KsvmUmdId,
            "KsvmDescBod" => $KsvmDescBod,
            "KsvmTelfBod" => $KsvmTelfBod,
            "KsvmDirBod" => $KsvmDirBod,
            "KsvmCodBodega" => $KsvmCodBod
            ];

            $KsvmGuardarBod = KsvmBodegaModelo :: __KsvmActualizarBodegaModelo($KsvmActualBod);
                if ($KsvmGuardarBod->rowCount() >= 1) {
                    $KsvmAlerta = [
                    "Alerta" => "Actualiza",
                    "Titulo" => "Grandioso",
                    "Cuerpo" => "La bodega se actualizó satisfactoriamente",
                    "Tipo" => "success"
                    ];
                } else {
                    $KsvmAlerta = [
                    "Alerta" => "simple",
                    "Titulo" => "Error inesperado",
                    "Cuerpo" => "No se a podido actualizar la información de la bodega",
                    "Tipo" => "info"
                    ];
                }
                return KsvmEstMaestra :: __KsvmMostrarAlertas($KsvmAlerta);
         
        }

      /**
       * Función que permite seleccionar una bodega
       */
      public function __KsvmCargaBodega(){
        $KsvmSelectBodega = "SELECT * FROM ksvmvistabodegas";

        $KsvmConsulta = KsvmEstMaestra :: __KsvmConexion();
        $KsvmQuery = $KsvmConsulta->query($KsvmSelectBodega);
        $KsvmQuery = $KsvmQuery->fetchAll();
        return $KsvmQuery;
    }

      /**
       * Función que permite seleccionar una bodega
       */
        public function __KsvmSeleccionarBodega(){
            $KsvmUsuario = $_SESSION['KsvmUsuId-SIGIM'];
            $KsvmSelectBodega = "SELECT * FROM ksvmseleccionabodega WHERE UsrId = '$KsvmUsuario'";

            $KsvmConsulta = KsvmEstMaestra :: __KsvmConexion();
            $KsvmQuery = $KsvmConsulta->query($KsvmSelectBodega);
            $KsvmQuery = $KsvmQuery->fetchAll();

            foreach ($KsvmQuery as $row) {
                $KsvmListar .= '<option value="'.$row['BdgId'].'">'.$row['BdgDescBod'].'</option>';
            }
            return $KsvmListar;
        }

      /**
       * Función que permite seleccionar una bodega
       */
        public function __KsvmSeleccionarBodegaExt(){
            $KsvmUsuario = $_SESSION['KsvmUsuId-SIGIM'];
            $KsvmSelectBodega = "SELECT DISTINCT b.* FROM ksvmbodega05 b JOIN ksvmexistenciaxbodega23 e ON b.BdgId = e.BdgId JOIN 
            ksvmbodegaxusuario12 u ON b.BdgId = u.BdgId WHERE u.UsrId = '$KsvmUsuario'";

            $KsvmConsulta = KsvmEstMaestra :: __KsvmConexion();
            $KsvmQuery = $KsvmConsulta->query($KsvmSelectBodega);
            $KsvmQuery = $KsvmQuery->fetchAll();

            foreach ($KsvmQuery as $row) {
                $KsvmListar .= '<option value="'.$row['BdgId'].'">'.$row['BdgDescBod'].'</option>';
            }
            return $KsvmListar;
        }
    
}
   
 