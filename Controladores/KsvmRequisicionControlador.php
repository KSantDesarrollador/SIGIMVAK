<?php

  /**
   *Condicion para peticion Ajax
   */
   if ($KsvmPeticionAjax) {
       require_once "../Modelos/KsvmRequisicionModelo.php";
   } else {
       require_once "./Modelos/KsvmRequisicionModelo.php";
   }

   class KsvmRequisicionControlador extends KsvmRequisicionModelo
   {
     /**
      *Función que permite ingresar un Pedido
      */
     public function __KsvmAgregarRequisicionControlador()
     {
         $KsvmIvtId = KsvmEstMaestra :: __KsvmFiltrarCadena($_POST['KsvmIvtId']);
         $KsvmOrigenReq = KsvmEstMaestra :: __KsvmFiltrarCadena($_POST['KsvmOrigenReq']);

         $KsvmPedidos = "SELECT RqcId FROM ksvmvistapedidos";
        $KsvmQuery = KsvmEstMaestra :: __KsvmEjecutaConsulta($KsvmPedidos);
        $KsvmNum = ($KsvmQuery->rowCount())+1;

        $KsvmNumReq = KsvmEstMaestra :: __KsvmGeneraCodigoAleatorio("00", 4, $KsvmNum);

        session_start(['name' => 'SIGIM']);
        $KsvmUser = $_SESSION['KsvmUsuId-SIGIM'];
        $KsvmElabora = "SELECT concat(EpoPriApeEmp,' ',EpoSegApeEmp,' ',EpoPriNomEmp,' ',EpoSegNomEmp) as PerElab FROM ksvmvistaempleado WHERE UsrId = '$KsvmUser'";
        $KsvmQuery = KsvmEstMaestra :: __KsvmConexion()->query($KsvmElabora);
         
         if ($KsvmQuery->rowCount() == 1) {
            $KsvmPerElab = $KsvmQuery->fetch();

            $KsvmFchElabReq = date("Y-m-d");
            $KsvmFchRevReq = "no registrado";
            $KsvmPerElabReq = $KsvmPerElab['PerElab'];
            $KsvmPerAprbReq = "no registrado"; 
         } else {
            $KsvmAlerta = [
                "Alerta" => "simple",
                "Titulo" => "Error inesperado",
                "Cuerpo" => "No se a podido verificar el usuario",
                "Tipo" => "info"
                ];
         }

              $KsvmNuevaReq = [
                "KsvmIvtId" => $KsvmIvtId,
                "KsvmNumReq" => $KsvmNumReq,
                "KsvmFchElabReq" => $KsvmFchElabReq,
                "KsvmOrigenReq" => $KsvmOrigenReq,
                "KsvmFchRevReq" => $KsvmFchRevReq,
                "KsvmPerElabReq" => $KsvmPerElabReq,
                "KsvmPerAprbReq" => $KsvmPerAprbReq
                ];

                $KsvmGuardaReq = KsvmRequisicionModelo :: __KsvmAgregarRequisicionModelo($KsvmNuevaReq);
                if ($KsvmGuardaReq->rowCount() >= 1) {
                    $KsvmAlerta = [
                    "Alerta" => "Actualiza",
                    "Titulo" => "Grandioso",
                    "Cuerpo" => "El Pedido se registró satisfactoriamente",
                    "Tipo" => "success"
                    ];
                } else {
                    $KsvmAlerta = [
                    "Alerta" => "simple",
                    "Titulo" => "Error inesperado",
                    "Cuerpo" => "No se a podido registrar el Pedido",
                    "Tipo" => "info"
                    ];
                }
                
            return KsvmEstMaestra :: __KsvmMostrarAlertas($KsvmAlerta);
        }

     /**
      *Función que permite ingresar una Detalle de Requisicion
      */
    public function __KsvmAgregarDetalleRequisicionControlador()
    {
        $KsvmExtId = KsvmEstMaestra :: __KsvmFiltrarCadena($_POST['KsvmExtId']);
        $KsvmCantReq = KsvmEstMaestra :: __KsvmFiltrarCadena($_POST['KsvmCantReq']);
        $KsvmStockReq = KsvmEstMaestra :: __KsvmFiltrarCadena($_POST['KsvmStockReq']);
        $KsvmObservReq = KsvmEstMaestra :: __KsvmFiltrarCadena($_POST['KsvmObservReq']);

        $KsvmNuevoDetalleReq = [
            "KsvmExtId" => $KsvmExtId,
            "KsvmCantReq" => $KsvmCantReq,
            "KsvmStockReq" => $KsvmStockReq,
            "KsvmObservReq" => $KsvmObservReq

           ];

           $KsvmGuardarDetReq = KsvmRequisicionModelo :: __KsvmAgregarDetalleRequisicionModelo($KsvmNuevoDetalleReq);
                if ($KsvmGuardarDetReq->rowCount() >= 1) {
                    $KsvmResult = "true";
                } else {
                    $KsvmAlerta = [
                    "Alerta" => "simple",
                    "Titulo" => "Error inesperado",
                    "Cuerpo" => "No se a podido registrar el Pedido",
                    "Tipo" => "info"
                    ];
                    $KsvmResult = "false";
                    return KsvmEstMaestra :: __KsvmMostrarAlertas($KsvmAlerta);
                }
                return $KsvmResult;
    }
            
    /**
     * Función que permite paginar 
     */
      public function __KsvmPaginador($KsvmPagina, $KsvmNRegistros, $KsvmRol, $KsvmCodigo, $KsvmBuscarIni, $KsvmBuscarFin)
      {
        $KsvmPagina = KsvmEstMaestra :: __KsvmFiltrarCadena($KsvmPagina);
        $KsvmNRegistros = KsvmEstMaestra :: __KsvmFiltrarCadena($KsvmNRegistros);
        $KsvmRol = KsvmEstMaestra :: __KsvmFiltrarCadena($KsvmRol);
        $KsvmCodigo = KsvmEstMaestra :: __KsvmFiltrarCadena($KsvmCodigo);
        $KsvmBuscarIni = KsvmEstMaestra :: __KsvmFiltrarCadena($KsvmBuscarIni);
        $KsvmTabla = "";
        
        $KsvmPagina = (isset($KsvmPagina) && $KsvmPagina > 0 ) ? (int)$KsvmPagina : 1;
        $KsvmDesde = ($KsvmPagina > 0) ? (($KsvmPagina*$KsvmNRegistros) - $KsvmNRegistros) : 0;
        
        if (isset($KsvmBuscarIni) && $KsvmBuscarIni != "" && !isset($KsvmBuscarFin)) {
            $KsvmDataReq = "SELECT SQL_CALC_FOUND_ROWS * FROM ksvmvistapedidos WHERE ((RqcEstReq != 'I') AND (RqcNumReq LIKE '%$KsvmBuscarIni%' 
                          OR RqcOrigenReq LIKE '%$KsvmBuscarIni%' OR RqcPerElabReq LIKE '%$KsvmBuscarIni%' OR RqcFchElabReq LIKE '%$KsvmBuscarIni%')) 
                          LIMIT $KsvmDesde, $KsvmNRegistros";
        } elseif (isset($KsvmBuscarIni) && isset($KsvmBuscarFin) && $KsvmBuscarFin != "") {
            $KsvmDataReq = "SELECT SQL_CALC_FOUND_ROWS * FROM ksvmvistapedidos WHERE RqcFchElabReq BETWEEN '$KsvmBuscarIni' AND '$KsvmBuscarFin'
            LIMIT $KsvmDesde, $KsvmNRegistros";
        } else {
            if ($KsvmRol == 1 || $KsvmRol == 2) {
                $KsvmDataReq = "SELECT SQL_CALC_FOUND_ROWS * FROM ksvmvistapedidos WHERE RqcEstReq != 'I' LIMIT $KsvmDesde, $KsvmNRegistros" ;
            } else {
                $KsvmDataReq = "SELECT SQL_CALC_FOUND_ROWS * FROM ksvmvistapedidos WHERE UsrId = '$KsvmUsuario' AND RqcEstReq != 'I' LIMIT $KsvmDesde, $KsvmNRegistros" ;
            }
            
        }

        $KsvmConsulta = KsvmEstMaestra :: __KsvmConexion();
    
        $KsvmQuery = $KsvmConsulta->query($KsvmDataReq);
        $KsvmQuery = $KsvmQuery->fetchAll();
        
        $KsvmDataTot = "SELECT FOUND_ROWS()";
        $KsvmTotalReg = $KsvmConsulta->query($KsvmDataTot);
        $KsvmTotalReg = (int) $KsvmTotalReg->fetchColumn();
        $KsvmNPaginas = ceil($KsvmTotalReg/$KsvmNRegistros);

        $KsvmTabla .= '<table class="mdl-data-table mdl-js-data-table mdl-shadow--6dp full-width table-responsive">
                        <thead>
                            <tr>
                                <th class="mdl-data-table__cell--non-numeric">#</th>
                                <th class="mdl-data-table__cell--non-numeric">#Pedido</th>
                                <th class="mdl-data-table__cell--non-numeric">Fecha</th>
                                <th class="mdl-data-table__cell--non-numeric">Resp</th>
                                <th class="mdl-data-table__cell--non-numeric">Origen</th>
                                <th style="text-align:center; witdh:30px;">Acción</th>
                            </tr>
                        </thead>
                        <tbody>';

        if ($KsvmTotalReg >= 1 && $KsvmPagina <= $KsvmNPaginas) {
            $KsvmContReg = $KsvmDesde +1;
            foreach ($KsvmQuery as $rows) {
                $KsvmBodega = $rows['RqcOrigenReq'];
                $KsvmSelectBodega = "SELECT * FROM ksvmseleccionabodega WHERE BdgId = '$KsvmBodega'";
                $KsvmConsulta = KsvmEstMaestra :: __KsvmConexion();
                $KsvmQuery = $KsvmConsulta->query($KsvmSelectBodega);
                $KsvmQuery = $KsvmQuery->fetch();
                $KsvmBodDest = $KsvmQuery['BdgDescBod'];
                $KsvmTabla .= '<tr>
                                <td class="mdl-data-table__cell--non-numeric">'.$KsvmContReg.'</td>
                                <td class="mdl-data-table__cell--non-numeric">'.$rows['RqcNumReq'].'</td>
                                <td class="mdl-data-table__cell--non-numeric">'.$rows['RqcFchElabReq'].'</td>
                                <td class="mdl-data-table__cell--non-numeric">'.$rows['RqcPerElabReq'].'</td>
                                <td class="mdl-data-table__cell--non-numeric">'.$KsvmBodDest.'</td>
                                <td style="text-align:right; witdh:30px;">';
                                if ($KsvmRol == 1 || $KsvmRol == 2) {
                                    if ($KsvmCodigo == 0) {

                                    $KsvmTabla .=  '<form action="'.KsvmServUrl.'Ajax/KsvmRequisicionAjax.php" method="POST" class="FormularioAjax" data-form="eliminar" enctype="multipart/form-data"> 
                                                    <a id="btn-detail" class="btn btn-sm btn-info" href="'.KsvmServUrl.'KsvmRequisicionesCrud/Detail/'.KsvmEstMaestra::__KsvmEncriptacion($rows['RqcId']).'/"><i class="zmdi zmdi-card"></i></a>
                                                    <div class="mdl-tooltip" for="btn-detail">Detalles</div>
                                                    <a id="btn-edit" class="btn btn-sm btn-primary" href="'.KsvmServUrl.'KsvmRequisicionesEditar/'.KsvmEstMaestra::__KsvmEncriptacion($rows['RqcId']).'/0/"><i class="zmdi zmdi-edit"></i></a>
                                                    <div class="mdl-tooltip" for="btn-edit">Editar</div>
                                                    <input type="hidden" name="KsvmCodDelete" value="'.KsvmEstMaestra::__KsvmEncriptacion($rows['RqcId']).'">              
                                                    <button id="btn-delete" type="submit" class="btn btn-sm btn-danger"><i class="zmdi zmdi-delete"></i></button>
                                                    <div class="RespuestaAjax"></div>
                                                    </form>';
                                    } elseif ($KsvmCodigo == 1) {
                                    $KsvmTabla .= '<form action="'.KsvmServUrl.'Ajax/KsvmRequisicionAjax.php" method="POST" class="FormularioAjax" data-form="eliminar" enctype="multipart/form-data"> 
                                                    <a id="btn-detail" class="btn btn-sm btn-info" href="'.KsvmServUrl.'KsvmRequisiciones/Detail/'.KsvmEstMaestra::__KsvmEncriptacion($rows['RqcId']).'"><i class="zmdi zmdi-card"></i></a>
                                                    <div class="mdl-tooltip" for="btn-detail">Detalles</div>
                                                    <a id="btn-edit" class="btn btn-sm btn-primary" href="'.KsvmServUrl.'KsvmRequisicionesEditar/'.KsvmEstMaestra::__KsvmEncriptacion($rows['RqcId']).'/1/"><i class="zmdi zmdi-edit"></i></a>
                                                    <div class="mdl-tooltip" for="btn-edit">Editar</div>
                                                    <input type="hidden" name="KsvmCodDelete" value="'.KsvmEstMaestra::__KsvmEncriptacion($rows['RqcId']).'">              
                                                    <button id="btn-delete" type="submit" class="btn btn-sm btn-danger"><i class="zmdi zmdi-delete"></i></button>
                                                    <div class="mdl-tooltip" for="btn-delete">Inhabilitar</div>
                                                    <div class="RespuestaAjax"></div>
                                                    </form>';
                                    } else {
                                    $KsvmTabla .= ' <a id="btn-detail" class="btn btn-sm btn-info" href="'.KsvmServUrl.'KsvmReportePedidos/Detail/'.KsvmEstMaestra::__KsvmEncriptacion($rows['RqcId']).'"><i class="zmdi zmdi-card"></i></a>
                                                    <div class="mdl-tooltip" for="btn-detail">Detalles</div>
                                                    <a id="btn-print" class="btn btn-sm btn-success" href="'.KsvmServUrl.'Reportes/KsvmRequisicionesPdf.php?Cod='.KsvmEstMaestra::__KsvmEncriptacion($rows['RqcId']).'" target="_blank"><i class="zmdi zmdi-print"></i></a>
                                                    <div class="mdl-tooltip" for="btn-print">Imprimir</div>';
                                    }
                                }elseif ($KsvmRol == 3){
                                    $KsvmTabla .= '<a id="btn-detail" class="btn btn-sm btn-info" href="'.KsvmServUrl.'KsvmRequisiciones/Detail/'.KsvmEstMaestra::__KsvmEncriptacion($rows['RqcId']).'/"><i class="zmdi zmdi-card"></i></a>
                                                    <div class="mdl-tooltip" for="btn-detail">Detalles</div>
                                                    <a id="btn-edit" class="btn btn-sm btn-primary" href="'.KsvmServUrl.'KsvmRequisicionesEditar/'.KsvmEstMaestra::__KsvmEncriptacion($rows['RqcId']).'/1/"><i class="zmdi zmdi-edit"></i></a>
                                                    <div class="mdl-tooltip" for="btn-edit">Editar</div>';
                                }else{
                                    $KsvmTabla .= '<a id="btn-detail" class="btn btn-sm btn-info" href="'.KsvmServUrl.'KsvmRequisiciones/Detail/'.KsvmEstMaestra::__KsvmEncriptacion($rows['RqcId']).'/"><i class="zmdi zmdi-card"></i></a>
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
                echo '<script> window.location.href=" '.KsvmServUrl.'KsvmRequisicionesCrud"</script>';
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
                    $KsvmTabla .= '<a class = "btn btn-xs btn-success mdl-shadow--8dp " href="'.KsvmServUrl.'KsvmRequisicionesCrud/1/">Primero</a>
                                   <span></span>
                                   <a class = "btn btn-xs btn-default mdl-shadow--8dp " href="'.KsvmServUrl.'KsvmRequisicionesCrud/'.($KsvmPagina-1).'/"><i class="zmdi zmdi-fast-rewind"></i></a>';
                }

                if ($KsvmPagina == $KsvmNPaginas) {
                    $KsvmTabla .= '<button class = "btn btn-xs btn-default mdl-shadow--8dp disabled"><i class="zmdi zmdi-fast-forward"></i></button>
                                   <span></span>
                                   <button class = "btn btn-xs btn-success mdl-shadow--8dp disabled">Último</button>';
                } else {
                    $KsvmTabla .= '<a class="btn btn-xs btn-default mdl-shadow--8dp" href="'.KsvmServUrl.'KsvmRequisicionesCrud/'.($KsvmPagina+1).'/"><i class="zmdi zmdi-fast-forward"></i></a>
                                   <span></span>
                                   <a class="btn btn-xs btn-success mdl-shadow--8dp" href="'.KsvmServUrl.'KsvmRequisicionesCrud/'.($KsvmNPaginas).'/">Último</a>';
                                   
                                   
                }
                
             
                $KsvmTabla .= '</nav></div>';     
                           
            } elseif ($KsvmTotalReg >= 1 && $KsvmPagina <= $KsvmNPaginas && $KsvmCodigo == 1) {
                $KsvmTabla .= '<nav class="navbar-form navbar-right form-group">';
                
                if ($KsvmPagina == 1) {
                    $KsvmTabla .= '<button class = "btn btn-xs btn-success mdl-shadow--8dp disabled">Primero</button>
                                   <span></span>
                                   <button class = "btn btn-xs btn-default mdl-shadow--8dp disabled"><i class="zmdi zmdi-fast-rewind"></i></button>';
                } else {
                    $KsvmTabla .= '<a class = "btn btn-xs btn-success mdl-shadow--8dp " href="'.KsvmServUrl.'KsvmRequisiciones/1/">Primero</a>
                                   <span></span>
                                   <a class = "btn btn-xs btn-default mdl-shadow--8dp " href="'.KsvmServUrl.'KsvmRequisiciones/'.($KsvmPagina-1).'/"><i class="zmdi zmdi-fast-rewind"></i></a>';
                }

                if ($KsvmPagina == $KsvmNPaginas) {
                    $KsvmTabla .= '<button class = "btn btn-xs btn-default mdl-shadow--8dp disabled"><i class="zmdi zmdi-fast-forward"></i></button>
                                   <span></span>
                                   <button class = "btn btn-xs btn-success mdl-shadow--8dp disabled">Último</button>';
                } else {
                    $KsvmTabla .= '<a class="btn btn-xs btn-default mdl-shadow--8dp" href="'.KsvmServUrl.'KsvmRequisiciones/'.($KsvmPagina+1).'/"><i class="zmdi zmdi-fast-forward"></i></a>
                                   <span></span>
                                   <a class="btn btn-xs btn-success mdl-shadow--8dp" href="'.KsvmServUrl.'KsvmRequisiciones/'.($KsvmNPaginas).'/">Último</a>';
                                   
                                   
                }
                
                $KsvmTabla .= '</nav></div>'; 
            } elseif ($KsvmTotalReg >= 1 && $KsvmPagina <= $KsvmNPaginas && $KsvmCodigo == 3) {
                $KsvmTabla .= '<nav class="navbar-form navbar-right form-group">';
                
                if ($KsvmPagina == 1) {
                    $KsvmTabla .= '<button class = "btn btn-xs btn-success mdl-shadow--8dp disabled">Primero</button>
                                   <span></span>
                                   <button class = "btn btn-xs btn-default mdl-shadow--8dp disabled"><i class="zmdi zmdi-fast-rewind"></i></button>';
                } else {
                    $KsvmTabla .= '<a class = "btn btn-xs btn-success mdl-shadow--8dp " href="'.KsvmServUrl.'KsvmReportePedidos/1/">Primero</a>
                                   <span></span>
                                   <a class = "btn btn-xs btn-default mdl-shadow--8dp " href="'.KsvmServUrl.'KsvmReportePedidos/'.($KsvmPagina-1).'/"><i class="zmdi zmdi-fast-rewind"></i></a>';
                }

                if ($KsvmPagina == $KsvmNPaginas) {
                    $KsvmTabla .= '<button class = "btn btn-xs btn-default mdl-shadow--8dp disabled"><i class="zmdi zmdi-fast-forward"></i></button>
                                   <span></span>
                                   <button class = "btn btn-xs btn-success mdl-shadow--8dp disabled">Último</button>';
                } else {
                    $KsvmTabla .= '<a class="btn btn-xs btn-default mdl-shadow--8dp" href="'.KsvmServUrl.'KsvmReportePedidos/'.($KsvmPagina+1).'/"><i class="zmdi zmdi-fast-forward"></i></a>
                                   <span></span>
                                   <a class="btn btn-xs btn-success mdl-shadow--8dp" href="'.KsvmServUrl.'KsvmReportePedidos/'.($KsvmNPaginas).'/">Último</a>';
                                   
                                   
                }
                
                $KsvmTabla .= '</nav></div>'; 
            }
                                   
        return $KsvmTabla;
      }

    /**
     * Función que permite listar un Requisicion 
     */
     public function __KsvmListarSuperRequisiciones()
     {
      $KsvmDataReq = "SELECT SQL_CALC_FOUND_ROWS * FROM ksvmvistapedidos WHERE RqcEstReq = 'P'" ;
      $KsvmConsulta = KsvmEstMaestra :: __KsvmConexion();
  
      $KsvmQuery = $KsvmConsulta->query($KsvmDataReq);
      return $KsvmQuery;
     }
     
      /**
       * Función que permite inhabilitar un Pedido 
       */
      public function __KsvmEliminarRequisicionControlador()
      {
         $KsvmCode = KsvmEstMaestra :: __KsvmDesencriptacion($_POST['KsvmCodDelete']);
         $KsvmCodRequisicion = KsvmEstMaestra :: __KsvmFiltrarCadena($KsvmCode);

         $KsvmDelEmp = KsvmRequisicionModelo :: __KsvmEliminarRequisicionModelo($KsvmCodRequisicion);
         if ($KsvmDelEmp->rowCount() == 1) {
            $KsvmAlerta = [
                "Alerta" => "Actualiza",
                "Titulo" => "Pedido Inhabilitado",
                "Cuerpo" => "El Pedido seleccionada ha sido inhabilitado con éxito",
                "Tipo" => "success"
                ];
             
         } else {
            $KsvmAlerta = [
                "Alerta" => "simple",
                "Titulo" => "Error inesperado",
                "Cuerpo" => "No es posible eliminar el Pedido del sistema",
                "Tipo" => "info"
                ];
         }

         return KsvmEstMaestra :: __KsvmMostrarAlertas($KsvmAlerta);
      }

      /**
       * Función que permite eliminar un registro 
       */
      public function __KsvmEliminarRegistroRequisicion()
      {
         $KsvmCode = KsvmEstMaestra :: __KsvmDesencriptacion($_POST['KsvmCodX']);
         $KsvmCodRequisicion = KsvmEstMaestra :: __KsvmFiltrarCadena($KsvmCode);

         $KsvmDelComp = KsvmRequisicionModelo :: __KsvmEliminarRequisicion($KsvmCodRequisicion);
         if ($KsvmDelComp->rowCount() == 1) {
                $KsvmResult = "true";
             
         } else {
            $KsvmAlerta = [
                "Alerta" => "simple",
                "Titulo" => "Error inesperado",
                "Cuerpo" => "No es posible eliminar la Requisicion del sistema",
                "Tipo" => "info"
                ];
                return KsvmEstMaestra :: __KsvmMostrarAlertas($KsvmAlerta);
                $KsvmResult = "false";
         }
         return $KsvmResult;

      }
    
      /**
       * Función que permite editar un Pedido 
       */
      public function __KsvmEditarRequisicionControlador($KsvmCodRequisicion)
      {
          $KsvmCodigo = KsvmEstMaestra :: __KsvmDesencriptacion($KsvmCodRequisicion);

          return KsvmRequisicionModelo :: __KsvmEditarRequisicionModelo($KsvmCodigo);
      }

            /**
       * Función que permite editar un Detalle de Requisicion 
       */
      public function  __KsvmEditarDetalleRequisicionControlador($KsvmCodRequisicion)
      {
          $KsvmCodigo = KsvmEstMaestra :: __KsvmDesencriptacion($KsvmCodRequisicion);

          return KsvmRequisicionModelo :: __KsvmEditarDetalleRequisicionModelo($KsvmCodigo);
      }

      /**
       * Función que permite editar un Detalle de Requisicion 
       */
      public function  __KsvmEditarDataRequisicionControlador($KsvmCodRequisicion)
      {
          $KsvmCodigo = KsvmEstMaestra :: __KsvmDesencriptacion($KsvmCodRequisicion);

          return KsvmRequisicionModelo :: __KsvmCargarDataModelo($KsvmCodigo);
      }
      
      /**
       * Función que permite contar un Pedido 
       */
      public function __KsvmContarRequisicionControlador($KsvmTokken)
      {
          if ($KsvmTokken == 0) {
            $KsvmContaRequisicion = KsvmRequisicionModelo :: __KsvmContarRequisicionSuperModelo();
          } elseif($KsvmTokken == 1) {
            $KsvmContaRequisicion = KsvmRequisicionModelo :: __KsvmContarRequisicionTecniModelo();
          } else{
            $KsvmContaRequisicion = KsvmRequisicionModelo :: __KsvmContarRequisicionModelo();
          }
          return $KsvmContaRequisicion;
      }

      /**
       * Función que permite imprimir una Requisicion 
       */
      public function __KsvmImprimirRequisicionControlador()
      {
        return KsvmRequisicionModelo :: __KsvmImprimirRequisicionModelo();
      }

      /**
       * Función que permite imprimir un detalle de Requisicion 
       */
      public function __KsvmImprimirDetalleRequisicionControlador($KsvmCodRequisicion)
      {
        $KsvmCodigo = KsvmEstMaestra :: __KsvmDesencriptacion($KsvmCodRequisicion);
        return KsvmRequisicionModelo :: __KsvmEditarDetalleRequisicionModelo($KsvmCodigo);
      }

      /**
       * Función que permite revisar una Requisicion 
       */
      public function __KsvmRevisarRequisicion()
      {
        $KsvmTokken = KsvmEstMaestra :: __KsvmDesencriptacion($_POST['KsvmTokken']);
        $KsvmCodRevision = KsvmEstMaestra :: __KsvmDesencriptacion($_POST['KsvmCodRevision']);
        if ($KsvmTokken == "APB") {
            $KsvmRevRequisicion =[
                "KsvmCodRequisicion" => $KsvmCodRevision
            ];

            $KsvmApbrRequisicion = KsvmRequisicionModelo :: __KsvmApruebaRequisicionModelo($KsvmRevRequisicion);
            if ($KsvmApbrRequisicion->rowCount() >= 1) {
                $KsvmAlerta = [
                "Alerta" => "Actualiza",
                "Titulo" => "Grandioso",
                "Cuerpo" => "La Requisicion a sido aprobada satisfactoriamente",
                "Tipo" => "success"
                ];
            } else {
                $KsvmAlerta = [
                "Alerta" => "simple",
                "Titulo" => "Error inesperado",
                "Cuerpo" => "No se a podido actualizar la información de la Requisicion",
                "Tipo" => "info"
                ];
            }
            return KsvmEstMaestra :: __KsvmMostrarAlertas($KsvmAlerta);

        } else {

            $KsvmRevRequisicion =[
                "KsvmCodRequisicion" => $KsvmCodRevision
            ];

            $KsvmNiegaRequisicion = KsvmRequisicionModelo :: __KsvmNiegaRequisicionModelo($KsvmRevRequisicion);
            if ($KsvmNiegaRequisicion->rowCount() >= 1) {
                $KsvmAlerta = [
                "Alerta" => "Actualiza",
                "Titulo" => "Grandioso",
                "Cuerpo" => "La Requisicion a sido negada satisfactoriamente",
                "Tipo" => "success"
                ];
            } else {
                $KsvmAlerta = [
                "Alerta" => "simple",
                "Titulo" => "Error inesperado",
                "Cuerpo" => "No se a podido actualizar la información de la Requisicion",
                "Tipo" => "info"
                ];
            }
            return KsvmEstMaestra :: __KsvmMostrarAlertas($KsvmAlerta);
        }
        

      }

      /**
       * Función que permite actualizar un Pedido 
       */
      public function __KsvmActualizarRequisicionControlador()
      {
        $KsvmCodRequisicion = KsvmEstMaestra :: __KsvmDesencriptacion($_POST['KsvmCodEdit']);
        $KsvmOrigenReq = KsvmEstMaestra :: __KsvmFiltrarCadena($_POST['KsvmOrigenReq']);
        $KsvmFchRevReq = KsvmEstMaestra :: __KsvmFiltrarCadena($_POST['KsvmFchRevReq']);
        $KsvmPerAprbReq = KsvmEstMaestra :: __KsvmFiltrarCadena($_POST['KsvmPerAprbReq']);
        $KsvmEstReq = KsvmEstMaestra :: __KsvmFiltrarCadena($_POST['KsvmEstReq']);

        $KsvmActualReq = [
            "KsvmOrigenReq" => $KsvmOrigenReq,
            "KsvmFchRevReq" => $KsvmFchRevReq,
            "KsvmPerAprbReq" => $KsvmPerAprbReq,
            "KsvmEstReq" => $KsvmEstReq,
            "KsvmCodRequisicion" => $KsvmCodRequisicion
            ];

            $KsvmGuardarReq = KsvmRequisicionModelo :: __KsvmActualizarRequisicionModelo($KsvmActualReq);
                if ($KsvmGuardarReq->rowCount() >= 1) {
                    $KsvmAlerta = [
                    "Alerta" => "Actualiza",
                    "Titulo" => "Grandioso",
                    "Cuerpo" => "El Pedido se actualizó satisfactoriamente",
                    "Tipo" => "success"
                    ];
                } else {
                    $KsvmAlerta = [
                    "Alerta" => "simple",
                    "Titulo" => "Error inesperado",
                    "Cuerpo" => "No se a podido actualizar la información del Pedido",
                    "Tipo" => "info"
                    ];
                }
                return KsvmEstMaestra :: __KsvmMostrarAlertas($KsvmAlerta);
         
        }

      /**
       * Función que permite actualizar un Pedido 
       */
      public function __KsvmActualizarDetalleRequisicionControlador()
      {
        $KsvmCodRequisicion = KsvmEstMaestra :: __KsvmDesencriptacion($_POST['KsvmCodEdit']);
        $KsvmExtId = KsvmEstMaestra :: __KsvmFiltrarCadena($_POST['KsvmExtId']);
        $KsvmCantReq = KsvmEstMaestra :: __KsvmFiltrarCadena($_POST['KsvmCantReq']);
        $KsvmStockReq = KsvmEstMaestra :: __KsvmFiltrarCadena($_POST['KsvmStockReq']);
        $KsvmObservReq = KsvmEstMaestra :: __KsvmFiltrarCadena($_POST['KsvmObservReq']);

        $KsvmActualDetReq = [
            "KsvmExtId" => $KsvmExtId,
            "KsvmCantReq" => $KsvmCantReq,
            "KsvmStockReq" => $KsvmStockReq,
            "KsvmObservReq" => $KsvmObservReq,
            "KsvmCodRequisicion" => $KsvmCodRequisicion
            ];

            $KsvmGuardarDetReq = KsvmRequisicionModelo :: __KsvmActualizarDetalleRequisicionModelo($KsvmActualDetReq);
                if ($KsvmGuardarDetReq->rowCount() >= 1) {
                    $KsvmAlerta = [
                    "Alerta" => "Actualiza",
                    "Titulo" => "Grandioso",
                    "Cuerpo" => "El Pedido se actualizó satisfactoriamente",
                    "Tipo" => "success"
                    ];
                } else {
                    $KsvmAlerta = [
                    "Alerta" => "simple",
                    "Titulo" => "Error inesperado",
                    "Cuerpo" => "No se a podido actualizar la información del Pedido",
                    "Tipo" => "info"
                    ];
                }
                return KsvmEstMaestra :: __KsvmMostrarAlertas($KsvmAlerta);
         
        }

        /**
       * Función que permite seleccionar una Requisición 
       */
      public function __KsvmSeleccionarRequisicion()
      {

        $KsvmBod = $_POST['KsvmBdgCod'];
        $KsvmSelectReq = "SELECT * FROM ksvmvistapedidos WHERE RqcOrigenReq = '$KsvmBod'";

        $KsvmConsulta = KsvmEstMaestra :: __KsvmConexion();
        $KsvmQuery = $KsvmConsulta->query($KsvmSelectReq);
        $KsvmQuery = $KsvmQuery->fetchAll();
        $KsvmListar = '<option value="" selected="" disabled>Seleccione Requisición</option>';

        foreach ($KsvmQuery as $row) {
            $KsvmListar .= '<option value="'.$row['RqcId'].'">Num: '.$row['RqcNumReq'].' Fecha: '.$row['RqcFchElabReq'].'</option>';
        }
        return $KsvmListar;
    }

    /**
     * Función que permite cargar el medicamento 
     */
    public function __KsvmCargarMedicamento()
    {

        $KsvmMedica = $_POST['KsvmRqcCod'];
        $KsvmSelectMed = "SELECT * FROM ksvmvistadetallepedido WHERE RqcId = '$KsvmMedica'";

        $KsvmConsulta = KsvmEstMaestra :: __KsvmConexion();
        $KsvmQuery = $KsvmConsulta->query($KsvmSelectMed);
        $KsvmQuery = $KsvmQuery->fetchAll();
        $KsvmListar = '<option value="" selected="" disabled>Seleccione Medicamento</option>';

        foreach ($KsvmQuery as $row) {
            $KsvmListar .= '<option value="'.$row['ExtId'].'">'.$row['MdcDescMed'].' '.$row['MdcConcenMed'].'</option>';
        }
        return $KsvmListar;

    }   

        /**
         * Función que permite cargar el stock 
         */
        public function __KsvmCargarCantidad()
        {

            $KsvmCant = $_POST['KsvmRqcCantCod'];
            $KsvmDataCant = KsvmRequisicionModelo :: __KsvmSeleccionarCantidad($KsvmCant);
            if ($KsvmDataCant->rowCount() == 1) {
                $KsvmLlenarCant = $KsvmDataCant->fetch();
                $KsvmListar = '<input class="mdl-textfield__input" type="number" name="KsvmCantTran"
                              id="KsvmDato3" value="'.$KsvmLlenarCant['DrqCantReq'].'">';

            }

            return $KsvmListar;
        }

        public function __KsvmSeleccionBodega($KsvmBodega){
            $KsvmSelectBodega = "SELECT * FROM ksvmseleccionabodega WHERE BdgId = '$KsvmBodega'";

            $KsvmConsulta = KsvmEstMaestra :: __KsvmConexion();
            $KsvmQuery = $KsvmConsulta->query($KsvmSelectBodega);
            $KsvmQuery = $KsvmQuery->fetch();
            return $KsvmQuery;
        }
    
}
   
 