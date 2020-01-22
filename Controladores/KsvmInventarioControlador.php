<?php

  /**
   *Condicion para peticion Ajax
   */
   if ($KsvmPeticionAjax) {
       require_once "../Modelos/KsvmInventarioModelo.php";
   } else {
       require_once "./Modelos/KsvmInventarioModelo.php";
   }

   class KsvmInventarioControlador extends KsvmInventarioModelo
   {
     /**
      *Función que permite ingresar un Inventario
      */
     public function __KsvmAgregarInventarioControlador()
     {
         $KsvmBdgId = KsvmEstMaestra :: __KsvmFiltrarCadena($_POST['KsvmBdgId']);
         $KsvmDuracionInv = KsvmEstMaestra :: __KsvmFiltrarCadena($_POST['KsvmDuracionInv']);

         $KsvmInventario = "SELECT  IvtId FROM ksvmvistainventarios";
         $KsvmQuery = KsvmEstMaestra :: __KsvmEjecutaConsulta($KsvmInventario);
         $KsvmNum = ($KsvmQuery->rowCount())+1;

         $KsvmCodInv = KsvmEstMaestra :: __KsvmGeneraCodigoAleatorio("INV", 4, $KsvmNum);
        
         $KsvmFchElabInv = date("Y-m-d");
         $KsvmHoraInv = date("h:i:s a");

            session_start(['name' => 'SIGIM']);
            $KsvmUser = $_SESSION['KsvmUsuId-SIGIM'];
            $KsvmElabora = "SELECT concat(EpoPriApeEmp,' ',EpoSegApeEmp,' ',EpoPriNomEmp,' ',EpoSegNomEmp) as PerElab FROM ksvmvistaempleado WHERE UsrId = '$KsvmUser'";
            $KsvmQuery = KsvmEstMaestra :: __KsvmConexion()->query($KsvmElabora);
         
         if ($KsvmQuery->rowCount() == 1) {
            $KsvmPerElab = $KsvmQuery->fetch();
            $KsvmPerElabInv = $KsvmPerElab['PerElab'];
         } else {
            $KsvmAlerta = [
                "Alerta" => "simple",
                "Titulo" => "Error inesperado",
                "Cuerpo" => "No se a podido verificar el usuario",
                "Tipo" => "info"
                ];
         }

              $KsvmNuevoInv = [
                "KsvmBdgId" => $KsvmBdgId,
                "KsvmCodInv" => $KsvmCodInv,
                "KsvmPerElabInv" => $KsvmPerElabInv,
                "KsvmFchElabInv" => $KsvmFchElabInv,
                "KsvmHoraInv" => $KsvmHoraInv, 
                "KsvmDuracionInv" => $KsvmDuracionInv,
                "KsvmUsrId" => $KsvmUser
                ];

                $KsvmGuardarInv = KsvmInventarioModelo :: __KsvmAgregarInventarioModelo($KsvmNuevoInv);
                if ($KsvmGuardarInv->rowCount() == 1) {
                    $KsvmAlerta = [
                    "Alerta" => "Actualiza",
                    "Titulo" => "Grandioso",
                    "Cuerpo" => "El Inventario se registró satisfactoriamente",
                    "Tipo" => "success"
                    ];
                } else {
                    $KsvmAlerta = [
                    "Alerta" => "simple",
                    "Titulo" => "Error inesperado",
                    "Cuerpo" => "No se a podido registrar el Inventario",
                    "Tipo" => "info"
                    ];
                }
                
            return KsvmEstMaestra :: __KsvmMostrarAlertas($KsvmAlerta);
        }

     /**
      *Función que permite ingresar una Detalle de Inventario
      */
    public function __KsvmAgregarDetalleInventarioControlador()
    {
        $KsvmExtId = KsvmEstMaestra :: __KsvmFiltrarCadena($_POST['KsvmExtId']);
        $KsvmStockInv = KsvmEstMaestra :: __KsvmFiltrarCadena($_POST['KsvmStockInv']);
        $KsvmContFisInv = KsvmEstMaestra :: __KsvmFiltrarCadena($_POST['KsvmContFisInv']);
        $KsvmObservInv = KsvmEstMaestra :: __KsvmFiltrarCadena($_POST['KsvmObservInv']);
        $KsvmNuevoStockInv = KsvmEstMaestra :: __KsvmFiltrarCadena($_POST['KsvmNvoStock']);

        $KsvmMedicamento = "SELECT ExtId FROM ksvmdetalleinventario11 WHERE ExtId ='$KsvmExtId' AND DivEstInv = 'N'";
        $KsvmQuery = KsvmEstMaestra :: __KsvmEjecutaConsulta($KsvmMedicamento);
        if ($KsvmQuery->rowCount() >= 1) {
           $KsvmAlerta = [
             "Alerta" => "simple",
             "Titulo" => "Error inesperado",
             "Cuerpo" => "El medicamento ingresado ya se encuentra registrado!, Por favor intentelo de nuevo",
             "Tipo" => "info"
            ];

        } else{

        $KsvmDifInv = $KsvmContFisInv-$KsvmStockInv;

        $KsvmNuevoDetalleInv = [
            "KsvmExtId" => $KsvmExtId,
            "KsvmNuevoStockInv" => $KsvmNuevoStockInv,
            "KsvmStockInv" => $KsvmStockInv,
            "KsvmContFisInv" => $KsvmContFisInv,
            "KsvmDifInv" => $KsvmDifInv,
            "KsvmObservInv" => $KsvmObservInv

           ];

           $KsvmGuardarDetInv = KsvmInventarioModelo :: __KsvmAgregarDetalleInventarioModelo($KsvmNuevoDetalleInv);
                if ($KsvmGuardarDetInv->rowCount() >= 1) {
                    $KsvmResult = "true";
                } else {
                    $KsvmAlerta = [
                    "Alerta" => "simple",
                    "Titulo" => "Error inesperado",
                    "Cuerpo" => "No se a podido registrar el Pedido",
                    "Tipo" => "info"
                    ];
                    $KsvmResult = "false";
                }
                return $KsvmResult;
            }
                return KsvmEstMaestra :: __KsvmMostrarAlertas($KsvmAlerta);
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
            $KsvmDataInv = "SELECT SQL_CALC_FOUND_ROWS * FROM ksvmvistainventarios WHERE ((IvtEstInv != 'I') AND (IvtCodInv LIKE '%$KsvmBuscarIni%' 
                          OR BdgDescBod LIKE '%$KsvmBuscarIni%' OR IvtPerElabInv LIKE '%$KsvmBuscarIni%' OR IvtFchElabInv LIKE '%$KsvmBuscarIni%')) 
                          LIMIT $KsvmDesde, $KsvmNRegistros";
        } elseif (isset($KsvmBuscarIni) && isset($KsvmBuscarFin) && $KsvmBuscarFin != "") {
            $KsvmDataInv = "SELECT SQL_CALC_FOUND_ROWS * FROM ksvmvistainventarios WHERE IvtFchElabInv BETWEEN '$KsvmBuscarIni' AND '$KsvmBuscarFin'
            LIMIT $KsvmDesde, $KsvmNRegistros";
        } else {
            if ($KsvmRol == 1 || $KsvmRol == 2) {
                $KsvmDataInv = "SELECT SQL_CALC_FOUND_ROWS * FROM ksvmvistainventarios WHERE IvtEstInv != 'I' LIMIT $KsvmDesde, $KsvmNRegistros" ;
            } else {
                $KsvmDataInv = "SELECT SQL_CALC_FOUND_ROWS * FROM ksvmvistainventarios WHERE UsrId = '$KsvmUsuario' AND IvtEstInv != 'I' LIMIT $KsvmDesde, $KsvmNRegistros" ;
            }
            
        }
        

        $KsvmConsulta = KsvmEstMaestra :: __KsvmConexion();
    
        $KsvmQuery = $KsvmConsulta->query($KsvmDataInv);
        $KsvmQuery = $KsvmQuery->fetchAll();
        
        $KsvmDataTot = "SELECT FOUND_ROWS()";
        $KsvmTotalReg = $KsvmConsulta->query($KsvmDataTot);
        $KsvmTotalReg = (int) $KsvmTotalReg->fetchColumn();
        $KsvmNPaginas = ceil($KsvmTotalReg/$KsvmNRegistros);

        $KsvmTabla .= '<table class="mdl-data-table mdl-js-data-table mdl-shadow--6dp full-width table-responsive">
                        <thead>
                            <tr>
                                <th class="mdl-data-table__cell--non-numeric">#</th>
                                <th class="mdl-data-table__cell--non-numeric">Cod.Inv</th>
                                <th class="mdl-data-table__cell--non-numeric">Fecha</th>
                                <th class="mdl-data-table__cell--non-numeric">Bodega</th>
                                <th class="mdl-data-table__cell--non-numeric">Resp</th>
                                <th class="mdl-data-table__cell--non-numeric">Hora</th>
                                <th class="mdl-data-table__cell--non-numeric hide-on-tablet">Dura</th>
                                <th style="text-align:center; witdh:30px;">Acción</th>
                            </tr>
                        </thead>
                        <tbody>';

        if ($KsvmTotalReg >= 1 && $KsvmPagina <= $KsvmNPaginas) {
            $KsvmContReg = $KsvmDesde +1;
            foreach ($KsvmQuery as $rows) {
                $KsvmTabla .= '<tr>
                                <td class="mdl-data-table__cell--non-numeric">'.$KsvmContReg.'</td>
                                <td class="mdl-data-table__cell--non-numeric">'.$rows['IvtCodInv'].'</td>
                                <td class="mdl-data-table__cell--non-numeric">'.$rows['IvtFchElabInv'].'</td>
                                <td class="mdl-data-table__cell--non-numeric">'.$rows['BdgDescBod'].'</td>
                                <td class="mdl-data-table__cell--non-numeric">'.$rows['IvtPerElabInv'].'</td>
                                <td class="mdl-data-table__cell--non-numeric">'.$rows['IvtHoraInv'].'</td>
                                <td class="mdl-data-table__cell--non-numeric hide-on-tablet">'.$rows['IvtDuracionInv'].'</td>
                                <td style="text-align:right; witdh:30px;">';
                                if ($KsvmRol == 1 || $KsvmRol == 2) {
                                    if ($KsvmCodigo == 0) {

                                    $KsvmTabla .=  '<form action="'.KsvmServUrl.'Ajax/KsvmInventarioAjax.php" method="POST" class="FormularioAjax" data-form="eliminar" enctype="multipart/form-data"> 
                                                    <a id="btn-detail" class="btn btn-sm btn-info" href="'.KsvmServUrl.'KsvmInventariosCrud/Detail/'.KsvmEstMaestra::__KsvmEncriptacion($rows['IvtId']).'/"><i class="zmdi zmdi-card"></i></a>
                                                    <div class="mdl-tooltip" for="btn-detail">Detalles</div>
                                                    <a id="btn-edit" class="btn btn-sm btn-primary" href="'.KsvmServUrl.'KsvmInventariosEditar/'.KsvmEstMaestra::__KsvmEncriptacion($rows['IvtId']).'/0/"><i class="zmdi zmdi-edit"></i></a>
                                                    <div class="mdl-tooltip" for="btn-edit">Editar</div>
                                                    <input type="hidden" name="KsvmCodDelete" value="'.KsvmEstMaestra::__KsvmEncriptacion($rows['IvtId']).'">              
                                                    <button id="btn-delete" type="submit" class="btn btn-sm btn-danger"><i class="zmdi zmdi-delete"></i></button>
                                                    <div class="RespuestaAjax"></div>
                                                    </form>';
                                    } elseif ($KsvmCodigo == 1) {
                                    $KsvmTabla .= '<form action="'.KsvmServUrl.'Ajax/KsvmInventarioAjax.php" method="POST" class="FormularioAjax" data-form="eliminar" enctype="multipart/form-data"> 
                                                    <a id="btn-detail" class="btn btn-sm btn-info" href="'.KsvmServUrl.'KsvmInventarios/Detail/'.KsvmEstMaestra::__KsvmEncriptacion($rows['IvtId']).'"><i class="zmdi zmdi-card"></i></a>
                                                    <div class="mdl-tooltip" for="btn-detail">Detalles</div>
                                                    <a id="btn-edit" class="btn btn-sm btn-primary" href="'.KsvmServUrl.'KsvmInventariosEditar/'.KsvmEstMaestra::__KsvmEncriptacion($rows['IvtId']).'/1/"><i class="zmdi zmdi-edit"></i></a>
                                                    <div class="mdl-tooltip" for="btn-edit">Editar</div>
                                                    <input type="hidden" name="KsvmCodDelete" value="'.KsvmEstMaestra::__KsvmEncriptacion($rows['IvtId']).'">              
                                                    <button id="btn-delete" type="submit" class="btn btn-sm btn-danger"><i class="zmdi zmdi-delete"></i></button>
                                                    <div class="mdl-tooltip" for="btn-delete">Inhabilitar</div>
                                                    <div class="RespuestaAjax"></div>
                                                    </form>';
                                    } else {
                                    $KsvmTabla .= ' <a id="btn-detail" class="btn btn-sm btn-info" href="'.KsvmServUrl.'KsvmReporteInventariosGen/Detail/'.KsvmEstMaestra::__KsvmEncriptacion($rows['IvtId']).'"><i class="zmdi zmdi-card"></i></a>
                                                    <div class="mdl-tooltip" for="btn-detail">Detalles</div>
                                                    <a id="btn-print" class="btn btn-sm btn-success" href="'.KsvmServUrl.'Reportes/KsvmInventariosPdf.php?Cod='.KsvmEstMaestra::__KsvmEncriptacion($rows['IvtId']).'" target="_blank"><i class="zmdi zmdi-print"></i></a>
                                                    <div class="mdl-tooltip" for="btn-print">Imprimir</div>';
                                    }
                                }elseif ($KsvmRol == 3){
                                    $KsvmTabla .= '<a id="btn-detail" class="btn btn-sm btn-info" href="'.KsvmServUrl.'KsvmInventarios/Detail/'.KsvmEstMaestra::__KsvmEncriptacion($rows['IvtId']).'/"><i class="zmdi zmdi-card"></i></a>
                                                    <div class="mdl-tooltip" for="btn-detail">Detalles</div>
                                                    <a id="btn-edit" class="btn btn-sm btn-primary" href="'.KsvmServUrl.'KsvmInventariosEditar/'.KsvmEstMaestra::__KsvmEncriptacion($rows['IvtId']).'/1/"><i class="zmdi zmdi-edit"></i></a>
                                                    <div class="mdl-tooltip" for="btn-edit">Editar</div>';
                                }else{
                                    $KsvmTabla .= '<a id="btn-detail" class="btn btn-sm btn-info" href="'.KsvmServUrl.'KsvmInventarios/Detail/'.KsvmEstMaestra::__KsvmEncriptacion($rows['IvtId']).'/"><i class="zmdi zmdi-card"></i></a>
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
                echo '<script> window.location.href=" '.KsvmServUrl.'KsvmInventariosCrud"</script>';
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
                    $KsvmTabla .= '<a class = "btn btn-xs btn-success mdl-shadow--8dp " href="'.KsvmServUrl.'KsvmInventariosCrud/1/">Primero</a>
                                   <span></span>
                                   <a class = "btn btn-xs btn-default mdl-shadow--8dp " href="'.KsvmServUrl.'KsvmInventariosCrud/'.($KsvmPagina-1).'/"><i class="zmdi zmdi-fast-rewind"></i></a>';
                }

                if ($KsvmPagina == $KsvmNPaginas) {
                    $KsvmTabla .= '<button class = "btn btn-xs btn-default mdl-shadow--8dp disabled"><i class="zmdi zmdi-fast-forward"></i></button>
                                   <span></span>
                                   <button class = "btn btn-xs btn-success mdl-shadow--8dp disabled">Último</button>';
                } else {
                    $KsvmTabla .= '<a class="btn btn-xs btn-default mdl-shadow--8dp" href="'.KsvmServUrl.'KsvmInventariosCrud/'.($KsvmPagina+1).'/"><i class="zmdi zmdi-fast-forward"></i></a>
                                   <span></span>
                                   <a class="btn btn-xs btn-success mdl-shadow--8dp" href="'.KsvmServUrl.'KsvmInventariosCrud/'.($KsvmNPaginas).'/">Último</a>';
                                   
                                   
                }
                
             
                $KsvmTabla .= '</nav></div>';        

            } elseif ($KsvmTotalReg >= 1 && $KsvmPagina <= $KsvmNPaginas && $KsvmCodigo == 1) {
                $KsvmTabla .= '<nav class="navbar-form navbar-right form-group">';
                
                if ($KsvmPagina == 1) {
                    $KsvmTabla .= '<button class = "btn btn-xs btn-success mdl-shadow--8dp disabled">Primero</button>
                                   <span></span>
                                   <button class = "btn btn-xs btn-default mdl-shadow--8dp disabled"><i class="zmdi zmdi-fast-rewind"></i></button>';
                } else {
                    $KsvmTabla .= '<a class = "btn btn-xs btn-success mdl-shadow--8dp " href="'.KsvmServUrl.'KsvmInventarios/1/">Primero</a>
                                   <span></span>
                                   <a class = "btn btn-xs btn-default mdl-shadow--8dp " href="'.KsvmServUrl.'KsvmInventarios/'.($KsvmPagina-1).'/"><i class="zmdi zmdi-fast-rewind"></i></a>';
                }

                if ($KsvmPagina == $KsvmNPaginas) {
                    $KsvmTabla .= '<button class = "btn btn-xs btn-default mdl-shadow--8dp disabled"><i class="zmdi zmdi-fast-forward"></i></button>
                                   <span></span>
                                   <button class = "btn btn-xs btn-success mdl-shadow--8dp disabled">Último</button>';
                } else {
                    $KsvmTabla .= '<a class="btn btn-xs btn-default mdl-shadow--8dp" href="'.KsvmServUrl.'KsvmInventarios/'.($KsvmPagina+1).'/"><i class="zmdi zmdi-fast-forward"></i></a>
                                   <span></span>
                                   <a class="btn btn-xs btn-success mdl-shadow--8dp" href="'.KsvmServUrl.'KsvmInventarios/'.($KsvmNPaginas).'/">Último</a>';
                                   
                                   
                }
                
                $KsvmTabla .= '</nav></div>'; 
            } elseif ($KsvmTotalReg >= 1 && $KsvmPagina <= $KsvmNPaginas && $KsvmCodigo == 3) {
                $KsvmTabla .= '<nav class="navbar-form navbar-right form-group">';
                
                if ($KsvmPagina == 1) {
                    $KsvmTabla .= '<button class = "btn btn-xs btn-success mdl-shadow--8dp disabled">Primero</button>
                                   <span></span>
                                   <button class = "btn btn-xs btn-default mdl-shadow--8dp disabled"><i class="zmdi zmdi-fast-rewind"></i></button>';
                } else {
                    $KsvmTabla .= '<a class = "btn btn-xs btn-success mdl-shadow--8dp " href="'.KsvmServUrl.'KsvmReporteInventariosGen/1/">Primero</a>
                                   <span></span>
                                   <a class = "btn btn-xs btn-default mdl-shadow--8dp " href="'.KsvmServUrl.'KsvmReporteInventariosGen/'.($KsvmPagina-1).'/"><i class="zmdi zmdi-fast-rewind"></i></a>';
                }

                if ($KsvmPagina == $KsvmNPaginas) {
                    $KsvmTabla .= '<button class = "btn btn-xs btn-default mdl-shadow--8dp disabled"><i class="zmdi zmdi-fast-forward"></i></button>
                                   <span></span>
                                   <button class = "btn btn-xs btn-success mdl-shadow--8dp disabled">Último</button>';
                } else {
                    $KsvmTabla .= '<a class="btn btn-xs btn-default mdl-shadow--8dp" href="'.KsvmServUrl.'KsvmReporteInventariosGen/'.($KsvmPagina+1).'/"><i class="zmdi zmdi-fast-forward"></i></a>
                                   <span></span>
                                   <a class="btn btn-xs btn-success mdl-shadow--8dp" href="'.KsvmServUrl.'KsvmReporteInventariosGen/'.($KsvmNPaginas).'/">Último</a>';
                                   
                                   
                }
                
                $KsvmTabla .= '</nav></div>'; 
            }

            
        
                                   
        return $KsvmTabla;
      }

    /**
     * Función que permite listar un Inventario 
     */
     public function __KsvmListarSuperInventarios()
     {
      $KsvmDataInv = "SELECT SQL_CALC_FOUND_ROWS * FROM ksvmvistainventarios WHERE IvtEstInv = 'P'" ;
      $KsvmConsulta = KsvmEstMaestra :: __KsvmConexion();
  
      $KsvmQuery = $KsvmConsulta->query($KsvmDataInv);
      return $KsvmQuery;
     }
     
      /**
       * Función que permite inhabilitar un Inventario 
       */
      public function __KsvmEliminarInventarioControlador()
      {
         $KsvmCode = KsvmEstMaestra :: __KsvmDesencriptacion($_POST['KsvmCodDelete']);
         $KsvmCodInventario = KsvmEstMaestra :: __KsvmFiltrarCadena($KsvmCode);

         $KsvmDelInv = KsvmInventarioModelo :: __KsvmEliminarInventarioModelo($KsvmCodInventario);
         if ($KsvmDelInv->rowCount() == 1) {
            $KsvmAlerta = [
                "Alerta" => "Actualiza",
                "Titulo" => "Inventario Inhabilitado",
                "Cuerpo" => "El Inventario seleccionado ha sido inhabilitado con éxito",
                "Tipo" => "success"
                ];
             
         } else {
            $KsvmAlerta = [
                "Alerta" => "simple",
                "Titulo" => "Error inesperado",
                "Cuerpo" => "No es posible eliminar el Inventario del sistema",
                "Tipo" => "info"
                ];
         }

         return KsvmEstMaestra :: __KsvmMostrarAlertas($KsvmAlerta);
      }

       /**
       * Función que permite eliminar un registro 
       */
      public function __KsvmEliminarRegistroInventario()
      {
         $KsvmCode = KsvmEstMaestra :: __KsvmDesencriptacion($_POST['KsvmCodX']);
         $KsvmCodInventario = KsvmEstMaestra :: __KsvmFiltrarCadena($KsvmCode);

         $KsvmDelInv = KsvmInventarioModelo :: __KsvmEliminarInventario($KsvmCodInventario);
         if ($KsvmDelInv->rowCount() == 1) {
             $KsvmResult = "true";
         } else {
            $KsvmAlerta = [
                "Alerta" => "simple",
                "Titulo" => "Error inesperado",
                "Cuerpo" => "No es posible eliminar el Inventario del sistema",
                "Tipo" => "info"
                ];
                return KsvmEstMaestra :: __KsvmMostrarAlertas($KsvmAlerta);
                $KsvmResult = "false";
         }
         return $KsvmResult;
      }
    
      /**
       * Función que permite editar un Inventario 
       */
      public function __KsvmEditarInventarioControlador($KsvmCodInventario)
      {
          $KsvmCodigo = KsvmEstMaestra :: __KsvmDesencriptacion($KsvmCodInventario);

          return KsvmInventarioModelo :: __KsvmEditarInventarioModelo($KsvmCodigo);
      }

            /**
       * Función que permite editar una Detalle de Inventario 
       */
      public function  __KsvmEditarDetalleInventarioControlador($KsvmCodInventario)
      {
          $KsvmCodigo = KsvmEstMaestra :: __KsvmDesencriptacion($KsvmCodInventario);

          return KsvmInventarioModelo :: __KsvmEditarDetalleInventarioModelo($KsvmCodigo);
      }

      /**
       * Función que permite editar una Detalle de Inventario 
       */
      public function  __KsvmEditarDataInventarioControlador($KsvmCodInventario)
      {
          $KsvmCodigo = KsvmEstMaestra :: __KsvmDesencriptacion($KsvmCodInventario);

          return KsvmInventarioModelo :: __KsvmCargarDataModelo($KsvmCodigo);
      }
      
      /**
       * Función que permite contar un Inventario 
       */
      public function __KsvmContarInventarioControlador($KsvmTokken)
      {
          if ($KsvmTokken == 0) {
            $KsvmContaInventario = KsvmInventarioModelo :: __KsvmContarInventarioSuperModelo();
          } elseif($KsvmTokken == 1) {
            $KsvmContaInventario = KsvmInventarioModelo :: __KsvmContarInventarioTecniModelo();
          } else{
            $KsvmContaInventario = KsvmInventarioModelo :: __KsvmContarInventarioModelo();
          }
          return $KsvmContaInventario; 
      }

      /**
       * Función que permite imprimir una Inventario 
       */
      public function __KsvmImprimirInventarioControlador()
      {
        return KsvmInventarioModelo :: __KsvmImprimirInventarioModelo();
      }

      /**
       * Función que permite imprimir un detalle de Inventario 
       */
      public function __KsvmImprimirDetalleInventarioControlador($KsvmCodInventario)
      {
        $KsvmCodigo = KsvmEstMaestra :: __KsvmDesencriptacion($KsvmCodInventario);
        return KsvmInventarioModelo :: __KsvmEditarDetalleInventarioModelo($KsvmCodigo);
      }

      /**
       * Función que permite revisar una Inventario 
       */
      public function __KsvmRevisarInventario()
      {
        $KsvmTokken = KsvmEstMaestra :: __KsvmDesencriptacion($_POST['KsvmTokken']);
        $KsvmCodRevision = KsvmEstMaestra :: __KsvmDesencriptacion($_POST['KsvmCodRevision']);
        if ($KsvmTokken == "APB") {
            $KsvmRevInventario =[
                "KsvmCodInventario" => $KsvmCodRevision
            ];

            $KsvmApbrInventario = KsvmInventarioModelo :: __KsvmApruebaInventarioModelo($KsvmRevInventario);
            if ($KsvmApbrInventario->rowCount() >= 1) {
                $KsvmAlerta = [
                "Alerta" => "Actualiza",
                "Titulo" => "Grandioso",
                "Cuerpo" => "El Inventario a sido confirmado satisfactoriamente",
                "Tipo" => "success"
                ];
            } else {
                $KsvmAlerta = [
                "Alerta" => "simple",
                "Titulo" => "Error inesperado",
                "Cuerpo" => "No se a podido actualizar la información de la Inventario",
                "Tipo" => "info"
                ];
            }
            return KsvmEstMaestra :: __KsvmMostrarAlertas($KsvmAlerta);

        } 
        

      }

      /**
       * Función que permite actualizar un Inventario 
       */
      public function __KsvmActualizarInventarioControlador()
      {
        $KsvmCodInventario = KsvmEstMaestra :: __KsvmDesencriptacion($_POST['KsvmCodEdit']);
        $KsvmHoraInv = KsvmEstMaestra :: __KsvmFiltrarCadena($_POST['KsvmHoraInv']);
        $KsvmDuracionInv = KsvmEstMaestra :: __KsvmFiltrarCadena($_POST['KsvmDuracionInv']);
        $KsvmEstInv = KsvmEstMaestra :: __KsvmFiltrarCadena($_POST['KsvmEstInv']);

        session_start(['name' => 'SIGIM']);
        $KsvmUser = $_SESSION['KsvmUsuId-SIGIM'];

        $KsvmActualInv = [
            "KsvmHoraInv" => $KsvmHoraInv,
            "KsvmDuracionInv" => $KsvmDuracionInv,
            "KsvmUsrId" => $KsvmUser,
            "KsvmEstInv" => $KsvmEstInv,
            "KsvmCodInventario" => $KsvmCodInventario
            ];

            $KsvmGuardarInv = KsvmInventarioModelo :: __KsvmActualizarInventarioModelo($KsvmActualInv);
                if ($KsvmGuardarInv->rowCount() >= 1) {
                    $KsvmAlerta = [
                    "Alerta" => "Actualiza",
                    "Titulo" => "Grandioso",
                    "Cuerpo" => "El Inventario se actualizó satisfactoriamente",
                    "Tipo" => "success"
                    ];
                } else {
                    $KsvmAlerta = [
                    "Alerta" => "simple",
                    "Titulo" => "Error inesperado",
                    "Cuerpo" => "No se a podido actualizar la información del Inventario",
                    "Tipo" => "info"
                    ];
                }
                return KsvmEstMaestra :: __KsvmMostrarAlertas($KsvmAlerta);
         
        }

      /**
       * Función que permite actualizar un detalle de Inventario 
       */
      public function __KsvmActualizarDetalleInventarioControlador()
      {
        $KsvmCodInventario = KsvmEstMaestra :: __KsvmDesencriptacion($_POST['KsvmCodEdit']);
        $KsvmExtId = KsvmEstMaestra :: __KsvmFiltrarCadena($_POST['KsvmExtId']);
        $KsvmStockInv = KsvmEstMaestra :: __KsvmFiltrarCadena($_POST['KsvmStockInv']);
        $KsvmContFisInv = KsvmEstMaestra :: __KsvmFiltrarCadena($_POST['KsvmContFisInv']);
        $KsvmObservInv = KsvmEstMaestra :: __KsvmFiltrarCadena($_POST['KsvmObservInv']);

        $KsvmDifInv = $KsvmContFisInv-$KsvmStockInv;

        $KsvmActualDetInv = [
            "KsvmExtId" => $KsvmExtId,
            "KsvmStockInv" => $KsvmStockInv,
            "KsvmContFisInv" => $KsvmContFisInv,
            "KsvmDifInv" => $KsvmDifInv,
            "KsvmObservInv" => $KsvmObservInv,
            "KsvmCodInventario" => $KsvmCodInventario
            ];

            $KsvmGuardarDetInv = KsvmInventarioModelo :: __KsvmActualizarDetalleInventarioModelo($KsvmActualDetInv);
                if ($KsvmGuardarDetInv->rowCount() >= 1) {
                    $KsvmAlerta = [
                    "Alerta" => "Actualiza",
                    "Titulo" => "Grandioso",
                    "Cuerpo" => "El detalle del Inventario se actualizó satisfactoriamente",
                    "Tipo" => "success"
                    ];
                } else {
                    $KsvmAlerta = [
                    "Alerta" => "simple",
                    "Titulo" => "Error inesperado",
                    "Cuerpo" => "No se a podido actualizar la información del Inventario",
                    "Tipo" => "info"
                    ];
                }
                return KsvmEstMaestra :: __KsvmMostrarAlertas($KsvmAlerta);
         
        }

        /**
         * Función que permite cargar reportes
         */
        public function __KsvmCargarReporteInventarios($KsvmMedicamento, $KsvmAnio, $KsvmTotReg, $KsvmMes, $KsvmTokken)
        {
            $KsvmMedicamento = KsvmEstMaestra :: __KsvmFiltrarCadena($KsvmMedicamento);
            $KsvmAnio = KsvmEstMaestra :: __KsvmFiltrarCadena($KsvmAnio);
            $KsvmUsuario = $_SESSION['KsvmUsuId-SIGIM'];

            $KsvmConsulta = KsvmEstMaestra :: __KsvmConexion();

            if ($KsvmMedicamento != "" && $KsvmAnio != "" && $KsvmTotReg != 0) {        

                switch ($KsvmMes) {
                    case 'January':
                        if ($KsvmTokken == 1) {
                            $KsvmTotalMes = "SELECT SUM(DivDifInv)*(-1) AS ValorTotal FROM ksvmvistadetalleinventario WHERE IvtEstInv != 'I' AND  IvtMesInv = 'January' AND 
                            MdcId = '$KsvmMedicamento' AND IvtAnioInv = '$KsvmAnio' AND (DivContFisInv < DivStockInv)";
                            $KsvmConVal = $KsvmConsulta->query($KsvmTotalMes);
                                $KsvmValRep = $KsvmConVal->fetch();
                                $KsvmTotal =  $KsvmValRep['ValorTotal'];
                                $KsvmDataRep = round(($KsvmTotal*100/$KsvmTotReg));
                        } elseif ($KsvmTokken == 2) {
                            $KsvmTotalMes = "SELECT SUM(DivDifInv) AS ValorTotal FROM ksvmvistadetalleinventario WHERE IvtEstInv != 'I' AND  IvtMesInv = 'January' AND 
                            MdcId = '$KsvmMedicamento' AND IvtAnioInv = '$KsvmAnio' AND (DivContFisInv > DivStockInv)";
                            $KsvmConVal = $KsvmConsulta->query($KsvmTotalMes);
                                $KsvmValRep = $KsvmConVal->fetch();
                                $KsvmTotal =  $KsvmValRep['ValorTotal'];
                                $KsvmDataRep = round(($KsvmTotal*100/$KsvmTotReg));
                        } else {
                            $KsvmDataRep = 0;
                        }
                        return $KsvmDataRep;
                        break;

                    case 'February':
                        if ($KsvmTokken == 1) {
                            $KsvmTotalMes = "SELECT SUM(DivDifInv)*(-1) AS ValorTotal FROM ksvmvistadetalleinventario WHERE IvtEstInv != 'I' AND  IvtMesInv = 'February' AND 
                            MdcId = '$KsvmMedicamento' AND IvtAnioInv = '$KsvmAnio' AND (DivContFisInv < DivStockInv)";
                            $KsvmConVal = $KsvmConsulta->query($KsvmTotalMes);
                            if ($KsvmConVal->rowCount() >= 1) {
                                $KsvmValRep = $KsvmConVal->fetch();
                                $KsvmTotal =  $KsvmValRep['ValorTotal'];
                                $KsvmDataRep = round(($KsvmTotal*100/$KsvmTotReg));
                            }
                        } elseif ($KsvmTokken == 2) {
                            $KsvmTotalMes = "SELECT SUM(DivDifInv) AS ValorTotal FROM ksvmvistadetalleinventario WHERE IvtEstInv != 'I' AND  IvtMesInv = 'February' AND 
                            MdcId = '$KsvmMedicamento' AND IvtAnioInv = '$KsvmAnio' AND (DivContFisInv > DivStockInv)";
                            $KsvmConVal = $KsvmConsulta->query($KsvmTotalMes);
                            if ($KsvmConVal->rowCount() >= 1) {
                                $KsvmValRep = $KsvmConVal->fetch();
                                $KsvmTotal =  $KsvmValRep['ValorTotal'];
                                $KsvmDataRep = round(($KsvmTotal*100/$KsvmTotReg));
                            }
                        } else {
                            $KsvmDataRep = 0;
                        }
                        return $KsvmDataRep;
                        break;

                    case 'March':
                        if ($KsvmTokken == 1) {
                            $KsvmTotalMes = "SELECT SUM(DivDifInv)*(-1) AS ValorTotal FROM ksvmvistadetalleinventario WHERE IvtEstInv != 'I' AND  IvtMesInv = 'March' AND 
                            MdcId = '$KsvmMedicamento' AND IvtAnioInv = '$KsvmAnio' AND (DivContFisInv < DivStockInv)";
                            $KsvmConVal = $KsvmConsulta->query($KsvmTotalMes);
                                $KsvmValRep = $KsvmConVal->fetch();
                                $KsvmTotal =  $KsvmValRep['ValorTotal'];
                                $KsvmDataRep = round(($KsvmTotal*100/$KsvmTotReg));
                        } elseif ($KsvmTokken == 2) {
                            $KsvmTotalMes = "SELECT SUM(DivDifInv) AS ValorTotal FROM ksvmvistadetalleinventario WHERE IvtEstInv != 'I' AND  IvtMesInv = 'March' AND 
                            MdcId = '$KsvmMedicamento' AND IvtAnioInv = '$KsvmAnio' AND (DivContFisInv > DivStockInv)";
                            $KsvmConVal = $KsvmConsulta->query($KsvmTotalMes);
                                $KsvmValRep = $KsvmConVal->fetch();
                                $KsvmTotal =  $KsvmValRep['ValorTotal'];
                                $KsvmDataRep = round(($KsvmTotal*100/$KsvmTotReg));
                        } else {
                            $KsvmDataRep = 0;
                        }
                        return $KsvmDataRep;
                        break;

                    case 'April':
                        if ($KsvmTokken == 1) {
                            $KsvmTotalMes = "SELECT SUM(DivDifInv)*(-1) AS ValorTotal FROM ksvmvistadetalleinventario WHERE IvtEstInv != 'I' AND  IvtMesInv = 'April' AND 
                            MdcId = '$KsvmMedicamento' AND IvtAnioInv = '$KsvmAnio' AND (DivContFisInv < DivStockInv)";
                            $KsvmConVal = $KsvmConsulta->query($KsvmTotalMes);
                            $KsvmValRep = $KsvmConVal->fetch();
                            $KsvmTotal =  $KsvmValRep['ValorTotal'];
                            $KsvmDataRep = round(($KsvmTotal*100/$KsvmTotReg));
                        } elseif ($KsvmTokken == 2) {
                            $KsvmTotalMes = "SELECT SUM(DivDifInv) AS ValorTotal FROM ksvmvistadetalleinventario WHERE IvtEstInv != 'I' AND  IvtMesInv = 'April' AND 
                            MdcId = '$KsvmMedicamento' AND IvtAnioInv = '$KsvmAnio' AND (DivContFisInv > DivStockInv)";
                            $KsvmConVal = $KsvmConsulta->query($KsvmTotalMes);
                            $KsvmValRep = $KsvmConVal->fetch();
                            $KsvmTotal =  $KsvmValRep['ValorTotal'];
                            $KsvmDataRep = round(($KsvmTotal*100/$KsvmTotReg));
                        } else {
                            $KsvmDataRep = 0;
                        }
                        return $KsvmDataRep;
                        break;

                    case 'May':
                        if ($KsvmTokken == 1) {
                            $KsvmTotalMes = "SELECT SUM(DivDifInv)*(-1) AS ValorTotal FROM ksvmvistadetalleinventario WHERE IvtEstInv != 'I' AND  IvtMesInv = 'May' AND 
                            MdcId = '$KsvmMedicamento' AND IvtAnioInv = '$KsvmAnio' AND (DivContFisInv < DivStockInv)";
                            $KsvmConVal = $KsvmConsulta->query($KsvmTotalMes);
                            $KsvmValRep = $KsvmConVal->fetch();
                            $KsvmTotal =  $KsvmValRep['ValorTotal'];
                            $KsvmDataRep = round(($KsvmTotal*100/$KsvmTotReg));
                        } elseif ($KsvmTokken == 2) {
                            $KsvmTotalMes = "SELECT SUM(DivDifInv) AS ValorTotal FROM ksvmvistadetalleinventario WHERE IvtEstInv != 'I' AND  IvtMesInv = 'May' AND 
                            MdcId = '$KsvmMedicamento' AND IvtAnioInv = '$KsvmAnio' AND (DivContFisInv > DivStockInv)";
                            $KsvmConVal = $KsvmConsulta->query($KsvmTotalMes);
                            $KsvmValRep = $KsvmConVal->fetch();
                            $KsvmTotal =  $KsvmValRep['ValorTotal'];
                            $KsvmDataRep = round(($KsvmTotal*100/$KsvmTotReg));
                        } else {
                            $KsvmDataRep = 0;
                        }
                        return $KsvmDataRep;
                        break;

                    case 'June':
                        if ($KsvmTokken == 1) {
                            $KsvmTotalMes = "SELECT SUM(DivDifInv)*(-1) AS ValorTotal FROM ksvmvistadetalleinventario WHERE IvtEstInv != 'I' AND  IvtMesInv = 'June' AND 
                            MdcId = '$KsvmMedicamento' AND IvtAnioInv = '$KsvmAnio' AND (DivContFisInv < DivStockInv)";
                            $KsvmConVal = $KsvmConsulta->query($KsvmTotalMes);
                            $KsvmValRep = $KsvmConVal->fetch();
                            $KsvmTotal =  $KsvmValRep['ValorTotal'];
                            $KsvmDataRep = round(($KsvmTotal*100/$KsvmTotReg));
                        } elseif ($KsvmTokken == 2) {
                            $KsvmTotalMes = "SELECT SUM(DivDifInv) AS ValorTotal FROM ksvmvistadetalleinventario WHERE IvtEstInv != 'I' AND  IvtMesInv = 'June' AND 
                            MdcId = '$KsvmMedicamento' AND IvtAnioInv = '$KsvmAnio' AND (DivContFisInv > DivStockInv)";
                            $KsvmConVal = $KsvmConsulta->query($KsvmTotalMes);
                            $KsvmValRep = $KsvmConVal->fetch();
                            $KsvmTotal =  $KsvmValRep['ValorTotal'];
                            $KsvmDataRep = round(($KsvmTotal*100/$KsvmTotReg));
                        } else {
                            $KsvmDataRep = 0;
                        }
                        return $KsvmDataRep;
                        break;

                    case 'July':
                        if ($KsvmTokken == 1) {
                            $KsvmTotalMes = "SELECT SUM(DivDifInv)*(-1) AS ValorTotal FROM ksvmvistadetalleinventario WHERE IvtEstInv != 'I' AND  IvtMesInv = 'July' AND 
                            MdcId = '$KsvmMedicamento' AND IvtAnioInv = '$KsvmAnio' AND (DivContFisInv < DivStockInv)";
                            $KsvmConVal = $KsvmConsulta->query($KsvmTotalMes);
                            $KsvmValRep = $KsvmConVal->fetch();
                            $KsvmTotal =  $KsvmValRep['ValorTotal'];
                            $KsvmDataRep = round(($KsvmTotal*100/$KsvmTotReg));
                        } elseif ($KsvmTokken == 2) {
                            $KsvmTotalMes = "SELECT SUM(DivDifInv) AS ValorTotal FROM ksvmvistadetalleinventario WHERE IvtEstInv != 'I' AND  IvtMesInv = 'July' AND 
                            MdcId = '$KsvmMedicamento' AND IvtAnioInv = '$KsvmAnio' AND (DivContFisInv > DivStockInv)";
                            $KsvmConVal = $KsvmConsulta->query($KsvmTotalMes);
                            $KsvmValRep = $KsvmConVal->fetch();
                            $KsvmTotal =  $KsvmValRep['ValorTotal'];
                            $KsvmDataRep = round(($KsvmTotal*100/$KsvmTotReg));
                        } else {
                            $KsvmDataRep = 0;
                        }
                        return $KsvmDataRep;
                        break;

                    case 'August':
                        if ($KsvmTokken == 1) {
                            $KsvmTotalMes = "SELECT SUM(DivDifInv)*(-1) AS ValorTotal FROM ksvmvistadetalleinventario WHERE IvtEstInv != 'I' AND  IvtMesInv = 'August' AND 
                            MdcId = '$KsvmMedicamento' AND IvtAnioInv = '$KsvmAnio' AND (DivContFisInv < DivStockInv)";
                            $KsvmConVal = $KsvmConsulta->query($KsvmTotalMes);
                            $KsvmValRep = $KsvmConVal->fetch();
                            $KsvmTotal =  $KsvmValRep['ValorTotal'];
                            $KsvmDataRep = round(($KsvmTotal*100/$KsvmTotReg));
                        } elseif ($KsvmTokken == 2) {
                            $KsvmTotalMes = "SELECT SUM(DivDifInv) AS ValorTotal FROM ksvmvistadetalleinventario WHERE IvtEstInv != 'I' AND  IvtMesInv = 'August' AND 
                            MdcId = '$KsvmMedicamento' AND IvtAnioInv = '$KsvmAnio' AND (DivContFisInv > DivStockInv)";
                            $KsvmConVal = $KsvmConsulta->query($KsvmTotalMes);
                            $KsvmValRep = $KsvmConVal->fetch();
                            $KsvmTotal =  $KsvmValRep['ValorTotal'];
                            $KsvmDataRep = round(($KsvmTotal*100/$KsvmTotReg));
                        } else {
                            $KsvmDataRep = 0;
                        }
                        return $KsvmDataRep;
                        break;

                    case 'September':
                        if ($KsvmTokken == 1) {
                            $KsvmTotalMes = "SELECT SUM(DivDifInv)*(-1) AS ValorTotal FROM ksvmvistadetalleinventario WHERE IvtEstInv != 'I' AND  IvtMesInv = 'September' AND 
                            MdcId = '$KsvmMedicamento' AND IvtAnioInv = '$KsvmAnio' AND (DivContFisInv < DivStockInv)";
                            $KsvmConVal = $KsvmConsulta->query($KsvmTotalMes);
                            $KsvmValRep = $KsvmConVal->fetch();
                            $KsvmTotal =  $KsvmValRep['ValorTotal'];
                            $KsvmDataRep = round(($KsvmTotal*100/$KsvmTotReg));
                        } elseif ($KsvmTokken == 2) {
                            $KsvmTotalMes = "SELECT SUM(DivDifInv) AS ValorTotal FROM ksvmvistadetalleinventario WHERE IvtEstInv != 'I' AND  IvtMesInv = 'September' AND 
                            MdcId = '$KsvmMedicamento' AND IvtAnioInv = '$KsvmAnio' AND (DivContFisInv > DivStockInv)";
                            $KsvmConVal = $KsvmConsulta->query($KsvmTotalMes);
                            $KsvmValRep = $KsvmConVal->fetch();
                            $KsvmTotal =  $KsvmValRep['ValorTotal'];
                            $KsvmDataRep = round(($KsvmTotal*100/$KsvmTotReg));
                        } else {
                            $KsvmDataRep = 0;
                        }
                        return $KsvmDataRep;
                        break;

                    case 'October':
                        if ($KsvmTokken == 1) {
                            $KsvmTotalMes = "SELECT SUM(DivDifInv)*(-1) AS ValorTotal FROM ksvmvistadetalleinventario WHERE IvtEstInv != 'I' AND  IvtMesInv = 'October' AND 
                            MdcId = '$KsvmMedicamento' AND IvtAnioInv = '$KsvmAnio' AND (DivContFisInv < DivStockInv)";
                            $KsvmConVal = $KsvmConsulta->query($KsvmTotalMes);
                            $KsvmValRep = $KsvmConVal->fetch();
                            $KsvmTotal =  $KsvmValRep['ValorTotal'];
                            $KsvmDataRep = round(($KsvmTotal*100/$KsvmTotReg));
                        } elseif ($KsvmTokken == 2) {
                            $KsvmTotalMes = "SELECT SUM(DivDifInv) AS ValorTotal FROM ksvmvistadetalleinventario WHERE IvtEstInv != 'I' AND  IvtMesInv = 'October' AND 
                            MdcId = '$KsvmMedicamento' AND IvtAnioInv = '$KsvmAnio' AND (DivContFisInv > DivStockInv)";
                            $KsvmConVal = $KsvmConsulta->query($KsvmTotalMes);
                            $KsvmValRep = $KsvmConVal->fetch();
                            $KsvmTotal =  $KsvmValRep['ValorTotal'];
                            $KsvmDataRep = round(($KsvmTotal*100/$KsvmTotReg));
                        } else {
                            $KsvmDataRep = 0;
                        }
                        return $KsvmDataRep;
                        break;

                    case 'November':
                        if ($KsvmTokken == 1) {
                            $KsvmTotalMes = "SELECT SUM(DivDifInv)*(-1) AS ValorTotal FROM ksvmvistadetalleinventario WHERE IvtEstInv != 'I' AND  IvtMesInv = 'November' AND 
                            MdcId = '$KsvmMedicamento' AND IvtAnioInv = '$KsvmAnio' AND (DivContFisInv < DivStockInv)";
                            $KsvmConVal = $KsvmConsulta->query($KsvmTotalMes);
                            $KsvmValRep = $KsvmConVal->fetch();
                            $KsvmTotal =  $KsvmValRep['ValorTotal'];
                            $KsvmDataRep = round(($KsvmTotal*100/$KsvmTotReg));
                        } elseif ($KsvmTokken == 2) {
                            $KsvmTotalMes = "SELECT SUM(DivDifInv) AS ValorTotal FROM ksvmvistadetalleinventario WHERE IvtEstInv != 'I' AND  IvtMesInv = 'November' AND 
                            MdcId = '$KsvmMedicamento' AND IvtAnioInv = '$KsvmAnio' AND (DivContFisInv > DivStockInv)";
                            $KsvmConVal = $KsvmConsulta->query($KsvmTotalMes);
                            $KsvmValRep = $KsvmConVal->fetch();
                            $KsvmTotal = $KsvmValRep['ValorTotal'];
                            $KsvmDataRep = round(($KsvmTotal*100/$KsvmTotReg));
                        } else {
                            $KsvmDataRep = 0;
                        }

                        return $KsvmDataRep;
                        break;
    
                    case 'December':
                        if ($KsvmTokken == 1) {
                            $KsvmTotalMes = "SELECT SUM(DivDifInv)*(-1) AS ValorTotal FROM ksvmvistadetalleinventario WHERE IvtEstInv != 'I' AND  IvtMesInv = 'December' AND 
                            MdcId = '$KsvmMedicamento' AND IvtAnioInv = '$KsvmAnio' AND (DivContFisInv < DivStockInv)";
                            $KsvmConVal = $KsvmConsulta->query($KsvmTotalMes);
                            $KsvmValRep = $KsvmConVal->fetch();
                            $KsvmTotal =  $KsvmValRep['ValorTotal'];
                            $KsvmDataRep = round(($KsvmTotal*100/$KsvmTotReg));
                        } elseif ($KsvmTokken == 2) {
                            $KsvmTotalMes = "SELECT SUM(DivDifInv) AS ValorTotal FROM ksvmvistadetalleinventario WHERE IvtEstInv != 'I' AND  IvtMesInv = 'December' AND 
                            MdcId = '$KsvmMedicamento' AND IvtAnioInv = '$KsvmAnio' AND (DivContFisInv > DivStockInv)";
                            $KsvmConVal = $KsvmConsulta->query($KsvmTotalMes);
                            $KsvmValRep = $KsvmConVal->fetch();
                            $KsvmTotal =  $KsvmValRep['ValorTotal'];
                            $KsvmDataRep = round(($KsvmTotal*100/$KsvmTotReg));
                        } else {
                            $KsvmDataRep = 0;
                        }

                        return $KsvmDataRep;
                        break;
                }

                             
            } else {
                if ($KsvmTokken == 1) {
                    $KsvmTotalMes = "SELECT SUM(DivDifInv) AS ValorTotal FROM ksvmvistadetalleinventario WHERE IvtEstInv != 'I' AND IvtAnioInv = '$KsvmAnio' AND 
                    (DivContFisInv < DivStockInv)";
                    $KsvmConVal = $KsvmConsulta->query($KsvmTotalMes);
                        $KsvmValRep = $KsvmConVal->fetch();
                        $KsvmTotal =  $KsvmValRep['ValorTotal'];

                } elseif ($KsvmTokken == 2) {
                    $KsvmTotalMes = "SELECT SUM(DivDifInv) AS ValorTotal FROM ksvmvistadetalleinventario WHERE IvtEstInv != 'I' AND IvtAnioInv = '$KsvmAnio' AND 
                    (DivContFisInv > DivStockInv)";
                    $KsvmConVal = $KsvmConsulta->query($KsvmTotalMes);
                    $KsvmValRep = $KsvmConVal->fetch();
                    $KsvmTotal =  $KsvmValRep['ValorTotal'];
                } else {
                    $KsvmTotal = 0;
                }
                // echo $KsvmTotal;
                return $KsvmTotal;
            }


        }

      /**
       * Función que permite seleccionar un medicamento  
       */
      public function __KsvmMuestraMedicamento($KsvmMdcId)
      {
        $KsvmConsulta = KsvmEstMaestra :: __KsvmConexion();
        $KsvmMedic = "SELECT MdcDescMed, MdcConcenMed FROM ksvmvistamedicamentos WHERE MdcEstMed = 'A' AND MdcId = '$KsvmMdcId'";
        $KsvmConVal = $KsvmConsulta->query($KsvmMedic);
        $KsvmDataMed = $KsvmConVal->fetch();
        return $KsvmDataMed;
      }

      /**
       * Función que permite calcular el total de una Compra  
       */
      public function __KsvmTotalRegistros($KsvmMedicamento, $KsvmAnio, $KsvmTokken)
      {
        $KsvmMedicamento = KsvmEstMaestra :: __KsvmFiltrarCadena($KsvmMedicamento);
        $KsvmAnio = KsvmEstMaestra :: __KsvmFiltrarCadena($KsvmAnio);
        $KsvmUsuario = $_SESSION['KsvmUsuId-SIGIM'];

            $KsvmConsulta = KsvmEstMaestra :: __KsvmConexion();

            if ($KsvmTokken == 1) {
                $KsvmTotalAnio = "SELECT SUM(DivDifInv)*(-1) AS ValorTotal FROM ksvmvistadetalleinventario WHERE IvtEstInv != 'I' AND 
                MdcId = '$KsvmMedicamento' AND IvtAnioInv = '$KsvmAnio' AND (DivContFisInv < DivStockInv)";
                $KsvmQuery = $KsvmConsulta->query($KsvmTotalAnio);
                $KsvmValTotal = $KsvmQuery->fetch();
                $KsvmTotReg =  $KsvmValTotal['ValorTotal'];
                // echo $KsvmTotReg;
            } else {
                $KsvmTotalAnio = "SELECT SUM(DivDifInv) AS ValorTotal FROM ksvmvistadetalleinventario WHERE IvtEstInv != 'I' AND 
                MdcId = '$KsvmMedicamento' AND IvtAnioInv = '$KsvmAnio' AND (DivContFisInv > DivStockInv)";
                $KsvmQuery = $KsvmConsulta->query($KsvmTotalAnio);
                $KsvmValTotal = $KsvmQuery->fetch();
                $KsvmTotReg =  $KsvmValTotal['ValorTotal'];
                // echo $KsvmTotReg;
            }

        return $KsvmTotReg;
        
      }

        /**
       * Función que permite seleccionar un Inventario 
       */
        public function __KsvmSeleccionarInventario()
        {

            $KsvmBod = $_POST['KsvmBdgCod'];
            $KsvmSelectExt = "SELECT * FROM ksvmvistainventarios WHERE BdgId = '$KsvmBod' AND IvtEstInv = 'A'";

            $KsvmConsulta = KsvmEstMaestra :: __KsvmConexion();
            $KsvmQuery = $KsvmConsulta->query($KsvmSelectExt);
            $KsvmQuery = $KsvmQuery->fetchAll();
            $KsvmListar = '<option value="" selected="" disabled>Seleccione Inventario</option>';
            $KsvmListar .= '<option value="0" >Nuevo</option>';

            foreach ($KsvmQuery as $row) {
                $KsvmListar .= '<option value="'.$row['IvtId'].'">Cod: '.$row['IvtCodInv'].' Fecha: '.$row['IvtFchElabInv'].'</option>';
            }
            return $KsvmListar;
        }


        /**
         * Función que permite cargar el medicamento 
         */
        public function __KsvmCargarMedicamento()
        {

            $KsvmMedica = $_POST['KsvmIvtMedCod'];
            if ($KsvmMedica != 0) {
                $KsvmSelectExt = "SELECT * FROM ksvmvistadetalleinventario WHERE IvtId = '$KsvmMedica'";

                $KsvmConsulta = KsvmEstMaestra :: __KsvmConexion();
                $KsvmQuery = $KsvmConsulta->query($KsvmSelectExt);
                $KsvmQuery = $KsvmQuery->fetchAll();
                    $KsvmListar = '<option value="" selected="" disabled>Seleccione Medicamento</option>';
    
                    foreach ($KsvmQuery as $row) {
                        $KsvmListar .= '<option value="'.$row['ExtId'].'">'.$row['MdcDescMed'].' '.$row['MdcConcenMed'].' '.$row['ExtLoteEx'].'</option>';
                    }
                    return $KsvmListar;

            } else {
                $KsvmSelectExt = "SELECT * FROM ksvmseleccionaexistencia";

                $KsvmConsulta = KsvmEstMaestra :: __KsvmConexion();
                $KsvmQuery = $KsvmConsulta->query($KsvmSelectExt);
                $KsvmQuery = $KsvmQuery->fetchAll();
                    $KsvmListar = '<option value="" selected="" disabled>Seleccione Medicamento</option>';
    
                    foreach ($KsvmQuery as $row) {
                        $KsvmListar .= '<option value="'.$row['ExtId'].'">'.$row['MdcDescMed'].' '.$row['MdcConcenMed'].' '.$row['ExtLoteEx'].'</option>';
                    }
                    return $KsvmListar;
            }


        }

         /**
         * Función que permite cargar el stock 
         */
        public function __KsvmCargarStock()
        {
            $KsvmStock = $_POST['KsvmIvtStkCod'];
            $KsvmBodega = $_POST['KsvmBod'];

                $KsvmDataStock = KsvmInventarioModelo :: __KsvmSeleccionarStock($KsvmStock, $KsvmBodega);
                if ($KsvmDataStock->rowCount() == 1) {
                    $KsvmLlenarStock = $KsvmDataStock->fetch();
                    $KsvmListar = '<label class="mdl-textfield__input">'.$KsvmLlenarStock['DivStockInv'].'</label>
                    <input class="mdl-textfield__input" type="text" name="KsvmStockReq"
                                value="'.$KsvmLlenarStock['DivStockInv'].'" hidden>';

                }else{
                    $KsvmListar = '<label class="mdl-textfield__input">0</label>
                    <input class="mdl-textfield__input" type="text" name="KsvmStockReq"
                                value="0" hidden>';
                }

            return $KsvmListar;
        }

        /**
         * Función que permite cargar el tipo de transacción 
         */
        public function __KsvmCargarBodega()
        {
            $KsvmBodega = $_POST['KsvmBodCod'];
            echo $KsvmBodega;
            $KsvmListar = '<input class="mdl-textfield__input" type="text" name="KsvmNvoStock"
            id="KsvmDato3" value="'.$KsvmBodega.'">';
            return $KsvmListar;

        } 

    
}
   
 