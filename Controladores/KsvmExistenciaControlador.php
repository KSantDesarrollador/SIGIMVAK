<?php

  /**
   *Condicion para peticion Ajax
   */
   if ($KsvmPeticionAjax) {
       require_once "../Modelos/KsvmExistenciaModelo.php";
   } else {
       require_once "./Modelos/KsvmExistenciaModelo.php";
   }

   class KsvmExistenciaControlador extends KsvmExistenciaModelo
   {
     /**
      *Función que permite ingresar una Existencia
      */
     public function __KsvmAgregarExistenciaControlador()
     {
         $KsvmDocId = KsvmEstMaestra :: __KsvmFiltrarCadena($_POST['KsvmDocId']);
         $KsvmBdgId = KsvmEstMaestra :: __KsvmFiltrarCadena($_POST['KsvmBdgId']);
         $KsvmLoteEx = KsvmEstMaestra :: __KsvmFiltrarCadena($_POST['KsvmLoteEx']);
         $KsvmFchCadEx = KsvmEstMaestra :: __KsvmFiltrarCadena($_POST['KsvmFchCadEx']);
         $KsvmPresentEx = KsvmEstMaestra :: __KsvmFiltrarCadena($_POST['KsvmPresentEx']);
         $KsvmStockIniEx = KsvmEstMaestra :: __KsvmFiltrarCadena($_POST['KsvmStockIniEx']);
         $KsvmStockEx = KsvmEstMaestra :: __KsvmFiltrarCadena($_POST['KsvmStockEx']);
         $KsvmStockSegEx = KsvmEstMaestra :: __KsvmFiltrarCadena($_POST['KsvmStockSegEx']);
         $KsvmBinLocEx = KsvmEstMaestra :: __KsvmFiltrarCadena($_POST['KsvmBinLocEx']);

         $KsvmExistencias = "SELECT ExtId FROM ksvmvistaexistencias";
         $KsvmQuery = KsvmEstMaestra :: __KsvmEjecutaConsulta($KsvmExistencias);
         $KsvmNum = ($KsvmQuery->rowCount())+1;

         $KsvmCodBarEx = $KsvmFchCadEx.'-'.$KsvmNum;

         $KsvmLote = "SELECT ExtLoteEx FROM ksvmvistaexistencias WHERE ExtLoteEx ='$KsvmLoteEx'";
         $KsvmQuery = KsvmEstMaestra :: __KsvmEjecutaConsulta($KsvmLote);
         if ($KsvmQuery->rowCount() >= 1) {
            $KsvmAlerta = [
              "Alerta" => "simple",
              "Titulo" => "Error inesperado",
              "Cuerpo" => "El lote ingresado ya se encuentra registrado, Por favor ingrese un lote válido",
              "Tipo" => "info"
             ];

         }else{

              $KsvmNuevaExt = [
                "KsvmDocId" => $KsvmDocId,
                "KsvmLoteEx" => $KsvmLoteEx,
                "KsvmFchCadEx" => $KsvmFchCadEx,
                "KsvmPresentEx" => $KsvmPresentEx,
                "KsvmStockIniEx" => $KsvmStockIniEx,
                "KsvmCodBarEx" => $KsvmCodBarEx,
                "KsvmBinLocEx" => $KsvmBinLocEx
                ];

                $KsvmGuardarExt = KsvmExistenciaModelo :: __KsvmAgregarExistenciaModelo($KsvmNuevaExt);
                if ($KsvmGuardarExt->rowCount() == 1) {

                    $KsvmConsulta = KsvmEstMaestra :: __KsvmConexion();

                    $KsvmCodExist = "SELECT ExtId FROM ksvmexistencias21 WHERE DocId = '$KsvmDocId'";
                    $KsvmQuery = $KsvmConsulta->query($KsvmCodExist);

                    $KsvmExtId = $KsvmQuery->fetch();

                    $KsvmNuevaExtBod = [
                    "KsvmBdgId" => $KsvmBdgId,
                    "KsvmExtId" => $KsvmExtId['ExtId'],
                    "KsvmStockEx" => $KsvmStockEx,
                    "KsvmStockSegEx" => $KsvmStockSegEx
                    ];

                    $KsvmGuardarExtBod = KsvmExistenciaModelo :: __KsvmAgregarBodegaModelo($KsvmNuevaExtBod);
                    if ($KsvmGuardarExtBod->rowCount() == 1) {
                    $KsvmAlerta = [
                    "Alerta" => "Actualiza",
                    "Titulo" => "Grandioso",
                    "Cuerpo" => "La Existencia se registró satisfactoriamente",
                    "Tipo" => "success"
                    ];
                    }else{
                        $KsvmAlerta = [
                            "Alerta" => "simple",
                            "Titulo" => "Error inesperado",
                            "Cuerpo" => "No se a podido registrar la Existencia",
                            "Tipo" => "info"
                            ];

                    }
                } else {
                    $KsvmAlerta = [
                    "Alerta" => "simple",
                    "Titulo" => "Error inesperado",
                    "Cuerpo" => "No se a podido registrar la Existencia",
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
            $KsvmDataExt = "SELECT SQL_CALC_FOUND_ROWS * FROM ksvmvistaexistencias WHERE ((ExtEstEx != 'X') AND (MdcCodMed LIKE '%$KsvmBuscar%' 
                          OR BdgDescBod LIKE '%$KsvmBuscar%' OR ExtLoteEx LIKE '%$KsvmBuscar%' OR ExtBinLocEx LIKE '%$KsvmBuscar%' OR ExtFchCadEx 
                          LIKE '%$KsvmBuscar%')) LIMIT $KsvmDesde, $KsvmNRegistros";
        } else {
            $KsvmDataExt = "SELECT SQL_CALC_FOUND_ROWS * FROM ksvmvistaexistencias WHERE ExtEstEx != 'X' LIMIT $KsvmDesde, $KsvmNRegistros" ;
        }
        

        $KsvmConsulta = KsvmEstMaestra :: __KsvmConexion();
    
        $KsvmQuery = $KsvmConsulta->query($KsvmDataExt);
        $KsvmQuery = $KsvmQuery->fetchAll();
        $KsvmArrayCode = array();
        
        $KsvmDataTot = "SELECT FOUND_ROWS()";
        $KsvmTotalReg = $KsvmConsulta->query($KsvmDataTot);
        $KsvmTotalReg = (int) $KsvmTotalReg->fetchColumn();
        $KsvmNPaginas = ceil($KsvmTotalReg/$KsvmNRegistros);

        $KsvmTabla .= '<table class="mdl-data-table mdl-js-data-table mdl-shadow--6dp full-width table-responsive">
                        <thead>
                            <tr>
                                <th class="mdl-data-table__cell--non-numeric">#</th>
                                <th class="mdl-data-table__cell--non-numeric">Bodega</th>
                                <th class="mdl-data-table__cell--non-numeric">Nombre</th>
                                <th class="mdl-data-table__cell--non-numeric">Lote</th>
                                <th class="mdl-data-table__cell--non-numeric">Fch.Cad</th>
                                <th class="mdl-data-table__cell--non-numeric">Stock</th>
                                <th class="mdl-data-table__cell--non-numeric">Cod.Barras</th>
                                <th style="text-align:center; witdh:30px;">Acción</th>
                            </tr>
                        </thead>
                        <tbody>';

        if ($KsvmTotalReg >= 1 && $KsvmPagina <= $KsvmNPaginas) {
            $KsvmContReg = $KsvmDesde +1;
            foreach ($KsvmQuery as $rows) {
                $KsvmArrayCode[] = (string)$rows['ExtCodBarEx'];
                $KsvmTabla .= '<tr>
                                <td class="mdl-data-table__cell--non-numeric">'.$KsvmContReg.'</td>
                                <td class="mdl-data-table__cell--non-numeric">'.$rows['BdgDescBod'].'</td>
                                <td class="mdl-data-table__cell--non-numeric">'.$rows['MdcDescMed'].' '.$rows['MdcConcenMed'].'</td>
                                <td class="mdl-data-table__cell--non-numeric">'.$rows['ExtLoteEx'].'</td>
                                <td class="mdl-data-table__cell--non-numeric">'.$rows['ExtFchCadEx'].'</td>
                                <td class="mdl-data-table__cell--non-numeric">'.$rows['ExbStockEbo'].'</td>
                                <td class="mdl-data-table__cell--non-numeric"><svg id="Barcode'.$rows['ExtCodBarEx'].'"></td>
                                <td style="text-align:right; witdh:30px;">';
                                if ($KsvmRol == 1) {
                                    if ($KsvmCodigo == 0) {

                                    $KsvmTabla .=  '<form action="'.KsvmServUrl.'Ajax/KsvmRequisicionAjax.php" method="POST" class="FormularioAjax" data-form="eliminar" enctype="multipart/form-data"> 
                                                    <a id="btn-detail" class="btn btn-sm btn-info" href="'.KsvmServUrl.'KsvmExistenciasCrud/Detail/'.KsvmEstMaestra::__KsvmEncriptacion($rows['ExtId']).'/"><i class="zmdi zmdi-card"></i></a>
                                                    <div class="mdl-tooltip" for="btn-detail">Detalles</div>
                                                    <a id="btn-edit" class="btn btn-sm btn-primary" href="'.KsvmServUrl.'KsvmExistenciasEditar/'.KsvmEstMaestra::__KsvmEncriptacion($rows['ExtId']).'/0/"><i class="zmdi zmdi-edit"></i></a>
                                                    <div class="mdl-tooltip" for="btn-edit">Editar</div>
                                                    <input type="hidden" name="KsvmCodDelete" value="'.KsvmEstMaestra::__KsvmEncriptacion($rows['ExtId']).'">              
                                                    <button id="btn-delete" type="submit" class="btn btn-sm btn-danger"><i class="zmdi zmdi-delete"></i></button>
                                                    <div class="mdl-tooltip" for="btn-delete">Inhabilitar</div>
                                                    <div class="RespuestaAjax"></div>
                                                    </form>';
                                    } else {
                                    $KsvmTabla .= '<form action="'.KsvmServUrl.'Ajax/KsvmRequisicionAjax.php" method="POST" class="FormularioAjax" data-form="eliminar" enctype="multipart/form-data"> 
                                                    <a id="btn-detail" class="btn btn-sm btn-info" href="'.KsvmServUrl.'KsvmExistencias/Detail/'.KsvmEstMaestra::__KsvmEncriptacion($rows['ExtId']).'"><i class="zmdi zmdi-card"></i></a>
                                                    <div class="mdl-tooltip" for="btn-detail">Detalles</div>
                                                    <a id="btn-edit" class="btn btn-sm btn-primary" href="'.KsvmServUrl.'KsvmExistenciasEditar/'.KsvmEstMaestra::__KsvmEncriptacion($rows['ExtId']).'/1/"><i class="zmdi zmdi-edit"></i></a>
                                                    <div class="mdl-tooltip" for="btn-edit">Editar</div>
                                                    <input type="hidden" name="KsvmCodDelete" value="'.KsvmEstMaestra::__KsvmEncriptacion($rows['ExtId']).'">              
                                                    <button id="btn-delete" type="submit" class="btn btn-sm btn-danger"><i class="zmdi zmdi-delete"></i></button>
                                                    <div class="mdl-tooltip" for="btn-delete">Inhabilitar</div>
                                                    <div class="RespuestaAjax"></div>
                                                    </form>';
                                    }
                                }elseif ($KsvmRol == 2 || $KsvmRol == 3){
                                    $KsvmTabla .= '<a id="btn-detail" class="btn btn-sm btn-info" href="'.KsvmServUrl.'KsvmExistencias/Detail/'.KsvmEstMaestra::__KsvmEncriptacion($rows['ExtId']).'/"><i class="zmdi zmdi-card"></i></a>
                                                    <div class="mdl-tooltip" for="btn-detail">Detalles</div>
                                                    <a id="btn-edit" class="btn btn-sm btn-primary" href="'.KsvmServUrl.'KsvmExistenciasEditar/'.KsvmEstMaestra::__KsvmEncriptacion($rows['ExtId']).'/1/"><i class="zmdi zmdi-edit"></i></a>
                                                    <div class="mdl-tooltip" for="btn-edit">Editar</div>';
                                }else{
                                    $KsvmTabla .= '<a id="btn-detail" class="btn btn-sm btn-info" href="'.KsvmServUrl.'KsvmExistencias/Detail/'.KsvmEstMaestra::__KsvmEncriptacion($rows['ExtId']).'/"><i class="zmdi zmdi-card"></i></a>
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
                echo '<script> window.location.href=" '.KsvmServUrl.'KsvmExistenciasCrud"</script>';
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
                    $KsvmTabla .= '<a class = "btn btn-xs btn-success mdl-shadow--8dp " href="'.KsvmServUrl.'KsvmExistenciasCrud/1/">Primero</a>
                                   <span></span>
                                   <a class = "btn btn-xs btn-default mdl-shadow--8dp " href="'.KsvmServUrl.'KsvmExistenciasCrud/'.($KsvmPagina-1).'/"><i class="zmdi zmdi-fast-rewind"></i></a>';
                }

                if ($KsvmPagina == $KsvmNPaginas) {
                    $KsvmTabla .= '<button class = "btn btn-xs btn-default mdl-shadow--8dp disabled"><i class="zmdi zmdi-fast-forward"></i></button>
                                   <span></span>
                                   <button class = "btn btn-xs btn-success mdl-shadow--8dp disabled">Último</button>';
                } else {
                    $KsvmTabla .= '<a class="btn btn-xs btn-default mdl-shadow--8dp" href="'.KsvmServUrl.'KsvmExistenciasCrud/'.($KsvmPagina+1).'/"><i class="zmdi zmdi-fast-forward"></i></a>
                                   <span></span>
                                   <a class="btn btn-xs btn-success mdl-shadow--8dp" href="'.KsvmServUrl.'KsvmExistenciasCrud/'.($KsvmNPaginas).'/">Último</a>';
                                   
                                   
                }
                
             
                $KsvmTabla .= '</nav></div>';      

            } else {
                $KsvmTabla .= '<nav class="navbar-form navbar-right form-group">';
                
                if ($KsvmPagina == 1) {
                    $KsvmTabla .= '<button class = "btn btn-xs btn-success mdl-shadow--8dp disabled">Primero</button>
                                   <span></span>
                                   <button class = "btn btn-xs btn-default mdl-shadow--8dp disabled"><i class="zmdi zmdi-fast-rewind"></i></button>';
                } else {
                    $KsvmTabla .= '<a class = "btn btn-xs btn-success mdl-shadow--8dp " href="'.KsvmServUrl.'KsvmExistencias/1/">Primero</a>
                                   <span></span>
                                   <a class = "btn btn-xs btn-default mdl-shadow--8dp " href="'.KsvmServUrl.'KsvmExistencias/'.($KsvmPagina-1).'/"><i class="zmdi zmdi-fast-rewind"></i></a>';
                }

                if ($KsvmPagina == $KsvmNPaginas) {
                    $KsvmTabla .= '<button class = "btn btn-xs btn-default mdl-shadow--8dp disabled"><i class="zmdi zmdi-fast-forward"></i></button>
                                   <span></span>
                                   <button class = "btn btn-xs btn-success mdl-shadow--8dp disabled">Último</button>';
                } else {
                    $KsvmTabla .= '<a class="btn btn-xs btn-default mdl-shadow--8dp" href="'.KsvmServUrl.'KsvmExistencias/'.($KsvmPagina+1).'/"><i class="zmdi zmdi-fast-forward"></i></a>
                                   <span></span>
                                   <a class="btn btn-xs btn-success mdl-shadow--8dp" href="'.KsvmServUrl.'KsvmExistencias/'.($KsvmNPaginas).'/">Último</a>';
                                   
                                   
                }
                
                $KsvmTabla .= '</nav></div>'; 
            }
            
        
                                   
        return $KsvmTabla;
      }
     
      /**
       * Función que permite inhabilitar una Existencia 
       */
      public function __KsvmEliminarExistenciaControlador()
      {
         $KsvmCode = KsvmEstMaestra :: __KsvmDesencriptacion($_POST['KsvmCodDelete']);
         $KsvmCodExistencia = KsvmEstMaestra :: __KsvmFiltrarCadena($KsvmCode);

         $KsvmDelExt = KsvmExistenciaModelo :: __KsvmEliminarExistenciaModelo($KsvmCodExistencia);
         if ($KsvmDelExt->rowCount() == 1) {
            $KsvmAlerta = [
                "Alerta" => "Actualiza",
                "Titulo" => "Existencia Inhabilitado",
                "Cuerpo" => "La Existencia seleccionada ha sido inhabilitado con éxito",
                "Tipo" => "success"
                ];
             
         } else {
            $KsvmAlerta = [
                "Alerta" => "simple",
                "Titulo" => "Error inesperado",
                "Cuerpo" => "No es posible eliminar la Existencia del sistema",
                "Tipo" => "info"
                ];
         }

         return KsvmEstMaestra :: __KsvmMostrarAlertas($KsvmAlerta);
      }
    
      /**
       * Función que permite editar una Existencia 
       */
      public function __KsvmEditarExistenciaControlador($KsvmCodExistencia)
      {
          $KsvmCodigo = KsvmEstMaestra :: __KsvmDesencriptacion($KsvmCodExistencia);

          return KsvmExistenciaModelo :: __KsvmEditarExistenciaModelo($KsvmCodigo);
      }
      
      /**
       * Función que permite contar una Existencia 
       */
      public function __KsvmContarExistenciaControlador()
      {
          return KsvmExistenciaModelo :: __KsvmContarExistenciaModelo(0);
      }

      /**
       * Función que permite actualizar una Existencia 
       */
      public function __KsvmActualizarExistenciaControlador()
      {
        $KsvmCodExistencia = KsvmEstMaestra :: __KsvmDesencriptacion($_POST['KsvmCodEdit']);
        $KsvmDocId = KsvmEstMaestra :: __KsvmFiltrarCadena($_POST['KsvmDocId']);
        $KsvmBdgId = KsvmEstMaestra :: __KsvmFiltrarCadena($_POST['KsvmBdgId']);
        $KsvmLoteEx = KsvmEstMaestra :: __KsvmFiltrarCadena($_POST['KsvmLoteEx']);
        $KsvmFchCadEx = KsvmEstMaestra :: __KsvmFiltrarCadena($_POST['KsvmFchCadEx']);
        $KsvmPresentEx = KsvmEstMaestra :: __KsvmFiltrarCadena($_POST['KsvmPresentEx']);
        $KsvmStockIniEx = KsvmEstMaestra :: __KsvmFiltrarCadena($_POST['KsvmStockIniEx']);
        $KsvmStockEx = KsvmEstMaestra :: __KsvmFiltrarCadena($_POST['KsvmStockEx']);
        $KsvmStockSegEx = KsvmEstMaestra :: __KsvmFiltrarCadena($_POST['KsvmStockSegEx']);
        $KsvmCodBarEx = KsvmEstMaestra :: __KsvmFiltrarCadena($_POST['KsvmCodBarEx']);
        $KsvmBinLocEx = KsvmEstMaestra :: __KsvmFiltrarCadena($_POST['KsvmBinLocEx']);

        $KsvmConsulta = "SELECT * FROM ksvmvistaexistencias WHERE ExtId = '$KsvmCodExistencia'";
        $KsvmQuery = KsvmEstMaestra :: __KsvmEjecutaConsulta($KsvmConsulta);
        $KsvmDataExistencia = $KsvmQuery->fetch();

        if ($KsvmLoteEx != $KsvmDataExistencia['ExtLoteEx'] || $KsvmCodBarEx != $KsvmDataExistencia['ExtCodBarEx']) {
            $KsvmConsulta = "SELECT ExtLoteEx FROM ksvmvistaexistencias WHERE ExtLoteEx = '$KsvmLoteEx'";
            $KsvmQuery = KsvmEstMaestra :: __KsvmEjecutaConsulta($KsvmConsulta);
            if ($KsvmQuery->rowCount() >= 1) {
                $KsvmAlerta = [
                    "Alerta" => "Actualiza",
                    "Titulo" => "Error Inesperado",
                    "Cuerpo" => "El Lote ingresado ya se encuentra registrado, Por favor ingrese un Lote válido",
                    "Tipo" => "info"
                    ];
                    return KsvmEstMaestra :: __KsvmMostrarAlertas($KsvmAlerta);
                    exit();
            }

            $KsvmConsulta = "SELECT ExtCodBarEx FROM ksvmvistaexistencias WHERE ExtCodBarEx = '$KsvmCodBarEx'";
            $KsvmQuery = KsvmEstMaestra :: __KsvmEjecutaConsulta($KsvmConsulta);
            if ($KsvmQuery->rowCount() >= 1) {
                $KsvmAlerta = [
                    "Alerta" => "Actualiza",
                    "Titulo" => "Error Inesperado",
                    "Cuerpo" => "El Código de barras ingresado ya se encuentra registrado, Por favor ingrese un Código de barras válido",
                    "Tipo" => "info"
                    ];
                    return KsvmEstMaestra :: __KsvmMostrarAlertas($KsvmAlerta);
                    exit();
            }
        }

        $KsvmActualExt = [
            "KsvmDocId" => $KsvmDocId,
            "KsvmBdgId" => $KsvmBdgId,
            "KsvmLoteEx" => $KsvmLoteEx,
            "KsvmFchCadEx" => $KsvmFchCadEx,
            "KsvmPresentEx" => $KsvmPresentEx,
            "KsvmStockIniEx" => $KsvmStockIniEx,
            "KsvmStockEx" => $KsvmStockEx,
            "KsvmStockSegEx" => $KsvmStockSegEx,
            "KsvmCodBarEx" => $KsvmCodBarEx,
            "KsvmBinLocEx" => $KsvmBinLocEx,
            "KsvmCodExistencia" => $KsvmCodExistencia
            ];

            $KsvmGuardarExt = KsvmExistenciaModelo :: __KsvmActualizarExistenciaModelo($KsvmActualExt);
                if ($KsvmGuardarExt->rowCount() >= 1) {
                    $KsvmAlerta = [
                    "Alerta" => "Actualiza",
                    "Titulo" => "Grandioso",
                    "Cuerpo" => "La Existencia se actualizó satisfactoriamente",
                    "Tipo" => "success"
                    ];
                } else {
                    $KsvmAlerta = [
                    "Alerta" => "simple",
                    "Titulo" => "Error inesperado",
                    "Cuerpo" => "No se a podido actualizar la información de la Existencia",
                    "Tipo" => "info"
                    ];
                }
                return KsvmEstMaestra :: __KsvmMostrarAlertas($KsvmAlerta);
         
        }

                /**
       * Función que permite seleccionar una Existemcia 
       */
      public function __KsvmSeleccionExistencia(){

        $KsvmSelectExt = "SELECT * FROM ksvmseleccionaexistencia";

        $KsvmConsulta = KsvmEstMaestra :: __KsvmConexion();
        $KsvmQuery = $KsvmConsulta->query($KsvmSelectExt);
        $KsvmQuery = $KsvmQuery->fetchAll();

        foreach ($KsvmQuery as $row) {
            $KsvmListar = '<option value="'.$row['ExtId'].'">'.$row['MdcDescMed'].' '.$row['MdcConcenMed'].' '.$row['ExtLoteEx'].'</option>';
        }
        return $KsvmListar;
    }

        /**
       * Función que permite seleccionar una Existemcia 
       */
      public function __KsvmSeleccionaExistencia(){

            $KsvmSelectExt = "SELECT * FROM ksvmseleccionaexistencia";

            $KsvmConsulta = KsvmEstMaestra :: __KsvmConexion();
            $KsvmQuery = $KsvmConsulta->query($KsvmSelectExt);
            $KsvmQuery = $KsvmQuery->fetchAll();
            $KsvmListar = '<option value="" selected="" disabled>Seleccione Existencia</option>';

            foreach ($KsvmQuery as $row) {
                $KsvmListar .= '<option value="'.$row['ExtId'].'">'.$row['MdcDescMed'].' '.$row['MdcConcenMed'].' '.$row['ExtLoteEx'].'</option>';
            }
            return $KsvmListar;
        }

       /**
       * Función que permite seleccionar una Existemcia 
       */
        public function __KsvmSeleccionarExistencia(){

            $KsvmBod = $_POST['KsvmBdgCod'];
            if ($KsvmBod != 0) {
                $KsvmSelectExt = "SELECT * FROM ksvmseleccionaexistencia WHERE BdgId = '$KsvmBod'";
            } else {
                $KsvmSelectExt = "SELECT * FROM ksvmseleccionaexistencia";
            }

            $KsvmConsulta = KsvmEstMaestra :: __KsvmConexion();
            $KsvmQuery = $KsvmConsulta->query($KsvmSelectExt);
            $KsvmQuery = $KsvmQuery->fetchAll();
            $KsvmListar = '<option value="" selected="" disabled>Seleccione Existencia</option>';

            foreach ($KsvmQuery as $row) {
                $KsvmListar .= '<option value="'.$row['ExtId'].'">'.$row['MdcDescMed'].' '.$row['MdcConcenMed'].' '.$row['ExtLoteEx'].'</option>';
            }
            return $KsvmListar;
        }

       /**
       * Función que permite cargar el Stock 
       */
        public function __KsvmCargarStock(){

            $KsvmStock = $_POST['KsvmExtCod'];
            $KsvmQuery = KsvmExistenciaModelo :: __KsvmEditarExistenciaModelo($KsvmStock);
            $KsvmDataStock = $KsvmQuery;
            if ($KsvmDataStock->rowCount() == 1) {
                $KsvmLlenarStock = $KsvmDataStock->fetch();
                $KsvmListar = '<input class="mdl-textfield__input" type="text" name="KsvmStockInv"
                               value="'.$KsvmLlenarStock['ExbStockEbo'].'" id="KsvmDato2">';

            }

            return $KsvmListar;
        }

}
   
 ?>
 			<!-- <script type="text/javascript">
					alert('hola');
        function arrayjsonbarcode(j){
			json=JSON.parse(j);
			arr=[];
			for (var x in json) {
				arr.push(json[x]);
			}
			return arr;
		}

		jsonvalor='<?php echo json_encode($KsvmArrayCode) ?>';

		valores=arrayjsonbarcode(jsonvalor);

		for (var i = 0; i < valores.length; i++) {

			JsBarcode("#Barcode" + valores[i], valores[i].toString(), {
				format: "codabar",
				lineColor: "#000",
				width: 2,
				height: 20,
				displayValue: true
			});
		}
		</script> -->