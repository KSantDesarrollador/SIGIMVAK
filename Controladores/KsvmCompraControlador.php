<?php

  /**
   *Condicion para peticion Ajax
   */
   if ($KsvmPeticionAjax) {
       require_once "../Modelos/KsvmCompraModelo.php";
   } else {
       require_once "./Modelos/KsvmCompraModelo.php";
   }

   class KsvmCompraControlador extends KsvmCompraModelo
   {
     /**
      *Función que permite ingresar una Compra
      */
     public function __KsvmAgregarCompraControlador()
     {
        $KsvmPvdId = KsvmEstMaestra :: __KsvmFiltrarCadena($_POST['KsvmPvdId']);

        session_start(['name' => 'SIGIM']);
        $KsvmRol = $_SESSION['KsvmRolId-SIGIM'];
        $KsvmSelectUdMedica = "SELECT * FROM ksvmseleccionaunidadmedica WHERE RrlId = '$KsvmRol'";

        $KsvmConsulta = KsvmEstMaestra :: __KsvmConexion();
        $KsvmQuery = $KsvmConsulta->query($KsvmSelectUdMedica);
        $KsvmUniMed = $KsvmQuery->fetch();
        $KsvmUmdId = $KsvmUniMed['UmdId'];

        $KsvmCompras = "SELECT  CmpId FROM ksvmvistacompras";
        $KsvmQuery = KsvmEstMaestra :: __KsvmEjecutaConsulta($KsvmCompras);
        $KsvmNum = ($KsvmQuery->rowCount())+1;

        $KsvmNumOcp = KsvmEstMaestra :: __KsvmGeneraCodigoAleatorio("00", 4, $KsvmNum);
        echo $KsvmNumOcp;

        $KsvmUser = $_SESSION['KsvmUsuId-SIGIM'];
        $KsvmElabora = "SELECT concat(EpoPriApeEmp,' ',EpoSegApeEmp,' ',EpoPriNomEmp,' ',EpoSegNomEmp) as PerElab FROM ksvmvistaempleado WHERE UsrId = '$KsvmUser'";
        $KsvmQuery = KsvmEstMaestra :: __KsvmConexion()->query($KsvmElabora);
         
         if ($KsvmQuery->rowCount() == 1) {
            $KsvmPerElab = $KsvmQuery->fetch();

            $KsvmFchElabOcp = date("Y-m-d");
            $KsvmFchPagoOcp = "no registrado";
            $KsvmNumFactOcp = "no registrado";
            $KsvmPerElabOcp = $KsvmPerElab['PerElab'];
            $KsvmPerAprbOcp = "no registrado"; 
         } else {
            $KsvmAlerta = [
                "Alerta" => "simple",
                "Titulo" => "Error inesperado",
                "Cuerpo" => "No se a podido verifiacr el usuario",
                "Tipo" => "info"
                ];
         }

              $KsvmNuevaCompra = [
                "KsvmUmdId" => $KsvmUmdId,
                "KsvmPvdId" => $KsvmPvdId,
                "KsvmNumOcp" => $KsvmNumOcp,
                "KsvmFchElabOcp" => $KsvmFchElabOcp,
                "KsvmFchPagoOcp" => $KsvmFchPagoOcp,
                "KsvmNumFactOcp" => $KsvmNumFactOcp,
                "KsvmPerElabOcp" => $KsvmPerElabOcp,
                "KsvmPerAprbOcp" => $KsvmPerAprbOcp

                ];

                $KsvmGuardarCompra = KsvmCompraModelo :: __KsvmAgregarCompraModelo($KsvmNuevaCompra);
                if ($KsvmGuardarCompra->rowCount() >= 1) {

                    $KsvmAlerta = [
                    "Alerta" => "Limpia",
                    "Titulo" => "Grandioso",
                    "Cuerpo" => "La Compra se registró satisfactoriamente",
                    "Tipo" => "success"
                    ];
                } else {
                    $KsvmAlerta = [
                    "Alerta" => "simple",
                    "Titulo" => "Error inesperado",
                    "Cuerpo" => "No se a podido registrar la Compra",
                    "Tipo" => "info"
                    ];
                }
                
            
            return KsvmEstMaestra :: __KsvmMostrarAlertas($KsvmAlerta);
    }

    /**
      *Función que permite ingresar una Detalle de Compra
      */
    public function __KsvmAgregarDetalleCompraControlador()
    {
        $KsvmMdcId = KsvmEstMaestra :: __KsvmFiltrarCadena($_POST['KsvmMdcId']);
        $KsvmCantOcp = KsvmEstMaestra :: __KsvmFiltrarCadena($_POST['KsvmCantOcp']);
        $KsvmValorUntOcp = KsvmEstMaestra :: __KsvmFiltrarCadena($_POST['KsvmValorUntOcp']);
        $KsvmObservOcp = KsvmEstMaestra :: __KsvmFiltrarCadena($_POST['KsvmObservOcp']);

        $KsvmValorTotOcp = $KsvmCantOcp*$KsvmValorUntOcp;

        $KsvmNuevoDetalleCompra = [
            "KsvmMdcId" => $KsvmMdcId,
            "KsvmCantOcp" => $KsvmCantOcp,
            "KsvmValorUntOcp" => $KsvmValorUntOcp,
            "KsvmValorTotOcp" => $KsvmValorTotOcp,
            "KsvmObservOcp" => $KsvmObservOcp

           ];

           $KsvmGuardarDetCompra = KsvmCompraModelo :: __KsvmAgregarDetalleCompraModelo($KsvmNuevoDetalleCompra);
                if ($KsvmGuardarDetCompra->rowCount() >= 1) {
                    $KsvmResult = "true";
                } else {
                    $KsvmAlerta = [
                    "Alerta" => "simple",
                    "Titulo" => "Error inesperado",
                    "Cuerpo" => "No se a podido registrar la Compra",
                    "Tipo" => "info"
                    ];
                    $KsvmResult = "false";
                }
                return $KsvmResult;

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
        $KsvmUsuario = $_SESSION['KsvmUsuId-SIGIM'];
        $KsvmTabla = "";
        
        $KsvmPagina = (isset($KsvmPagina) && $KsvmPagina > 0 ) ? (int)$KsvmPagina : 1;
        $KsvmDesde = ($KsvmPagina > 0) ? (($KsvmPagina*$KsvmNRegistros) - $KsvmNRegistros) : 0;

        if (isset($KsvmBuscarIni) && $KsvmBuscarIni != "" && !isset($KsvmBuscarFin)) {
            $KsvmDataCompra = "SELECT SQL_CALC_FOUND_ROWS * FROM ksvmvistacompras WHERE ((CmpEstOcp != 'I') AND (CmpNumOcp LIKE '%$KsvmBuscarIni%' 
                          OR PvdRazSocProv LIKE '%$KsvmBuscarIni%' OR MdcDescMed LIKE '%$KsvmBuscarIni%' OR CmpFchElabOcp LIKE '%$KsvmBuscarIni%')) 
                          LIMIT $KsvmDesde, $KsvmNRegistros";
        } elseif (isset($KsvmBuscarIni) && isset($KsvmBuscarFin) && $KsvmBuscarFin != "") {
            $KsvmDataCompra = "SELECT SQL_CALC_FOUND_ROWS * FROM ksvmvistacompras WHERE CmpFchElabOcp BETWEEN '$KsvmBuscarIni' AND '$KsvmBuscarFin'
            LIMIT $KsvmDesde, $KsvmNRegistros";
        } else {
            if ($KsvmRol == 1 || $KsvmRol == 2) {
                $KsvmDataCompra = "SELECT SQL_CALC_FOUND_ROWS * FROM ksvmvistacompras WHERE CmpEstOcp != 'I' LIMIT $KsvmDesde, $KsvmNRegistros" ;
            } else {
                $KsvmDataCompra = "SELECT SQL_CALC_FOUND_ROWS * FROM ksvmvistacompras WHERE UsrId = '$KsvmUsuario' AND CmpEstOcp != 'I' LIMIT $KsvmDesde, $KsvmNRegistros" ;
            }
            
        }
        

        $KsvmConsulta = KsvmEstMaestra :: __KsvmConexion();
    
        $KsvmQuery = $KsvmConsulta->query($KsvmDataCompra);
        $KsvmQuery = $KsvmQuery->fetchAll();
        
        $KsvmDataTot = "SELECT FOUND_ROWS()";
        $KsvmTotalReg = $KsvmConsulta->query($KsvmDataTot);
        $KsvmTotalReg = (int) $KsvmTotalReg->fetchColumn();
        $KsvmNPaginas = ceil($KsvmTotalReg/$KsvmNRegistros);

        $KsvmTabla .= '<table class="mdl-data-table mdl-js-data-table mdl-shadow--6dp full-width table-responsive">
                        <thead>
                            <tr>
                                <th class="mdl-data-table__cell--non-numeric">#</th>
                                <th class="mdl-data-table__cell--non-numeric">#Comp</th>
                                <th class="mdl-data-table__cell--non-numeric">Fecha</th>
                                <th class="mdl-data-table__cell--non-numeric">#Factura</th>
                                <th class="mdl-data-table__cell--non-numeric">Resp</th>
                                <th class="mdl-data-table__cell--non-numeric hide-on-tablet">Und Médica</th>
                                <th class="mdl-data-table__cell--non-numeric">Prov</th>
                                <th style="text-align:center; witdh:30px;">Acción</th>
                            </tr>
                        </thead>
                        <tbody>';

        if ($KsvmTotalReg >= 1 && $KsvmPagina <= $KsvmNPaginas) {
            $KsvmContReg = $KsvmDesde +1;
            foreach ($KsvmQuery as $rows) {
                $KsvmTabla .= '<tr>
                                <td class="mdl-data-table__cell--non-numeric">'.$KsvmContReg.'</td>
                                <td class="mdl-data-table__cell--non-numeric">'.$rows['CmpNumOcp'].'</td>
                                <td class="mdl-data-table__cell--non-numeric">'.$rows['CmpFchElabOcp'].'</td>
                                <td class="mdl-data-table__cell--non-numeric">'.$rows['CmpNumFactOcp'].'</td>
                                <td class="mdl-data-table__cell--non-numeric">'.$rows['CmpPerElabOcp'].'</td>
                                <td class="mdl-data-table__cell--non-numeric hide-on-tablet">'.$rows['UmdNomUdm'].'</td>
                                <td class="mdl-data-table__cell--non-numeric">'.$rows['PvdRazSocProv'].'</td>
                                <td style="text-align:right; witdh:30px;">';
                                if ($KsvmRol == 1 || $KsvmRol == 2) {
                                    if ($KsvmCodigo == 0) {

                                    $KsvmTabla .=  '<form action="'.KsvmServUrl.'Ajax/KsvmComprasAjax.php" method="POST" class="FormularioAjax" data-form="eliminar" enctype="multipart/form-data"> 
                                                    <a id="btn-detail" class="btn btn-sm btn-info" href="'.KsvmServUrl.'KsvmComprasCrud/Detail/'.KsvmEstMaestra::__KsvmEncriptacion($rows['CmpId']).'/"><i class="zmdi zmdi-card"></i></a>
                                                    <div class="mdl-tooltip" for="btn-detail">Detalles</div>
                                                    <a id="btn-edit" class="btn btn-sm btn-primary" href="'.KsvmServUrl.'KsvmComprasEditar/'.KsvmEstMaestra::__KsvmEncriptacion($rows['CmpId']).'/0/"><i class="zmdi zmdi-edit"></i></a>
                                                    <div class="mdl-tooltip" for="btn-edit">Editar</div>
                                                    <input type="hidden" name="KsvmCodDelete" value="'.KsvmEstMaestra::__KsvmEncriptacion($rows['CmpId']).'">              
                                                    <button id="btn-delete" type="submit" class="btn btn-sm btn-danger"><i class="zmdi zmdi-delete"></i></button>
                                                    <div class="RespuestaAjax"></div>
                                                    </form>';
                                    } elseif ($KsvmCodigo == 1) {
                                    $KsvmTabla .= '<form action="'.KsvmServUrl.'Ajax/KsvmComprasAjax.php" method="POST" class="FormularioAjax" data-form="eliminar" enctype="multipart/form-data"> 
                                                    <a id="btn-detail" class="btn btn-sm btn-info" href="'.KsvmServUrl.'KsvmCompras/Detail/'.KsvmEstMaestra::__KsvmEncriptacion($rows['CmpId']).'"><i class="zmdi zmdi-card"></i></a>
                                                    <div class="mdl-tooltip" for="btn-detail">Detalles</div>
                                                    <a id="btn-edit" class="btn btn-sm btn-primary" href="'.KsvmServUrl.'KsvmComprasEditar/'.KsvmEstMaestra::__KsvmEncriptacion($rows['CmpId']).'/1/"><i class="zmdi zmdi-edit"></i></a>
                                                    <div class="mdl-tooltip" for="btn-edit">Editar</div>
                                                    <input type="hidden" name="KsvmCodDelete" value="'.KsvmEstMaestra::__KsvmEncriptacion($rows['CmpId']).'">              
                                                    <button id="btn-delete" type="submit" class="btn btn-sm btn-danger"><i class="zmdi zmdi-delete"></i></button>
                                                    <div class="mdl-tooltip" for="btn-delete">Inhabilitar</div>
                                                    <div class="RespuestaAjax"></div>
                                                    </form>';
                                    } else {
                                    $KsvmTabla .= ' <a id="btn-detail" class="btn btn-sm btn-info" href="'.KsvmServUrl.'KsvmReporteCompras/Detail/'.KsvmEstMaestra::__KsvmEncriptacion($rows['CmpId']).'"><i class="zmdi zmdi-card"></i></a>
                                                    <div class="mdl-tooltip" for="btn-detail">Detalles</div>
                                                    <a id="btn-print" class="btn btn-sm btn-success" href="'.KsvmServUrl.'Reportes/KsvmComprasPdf.php?Cod='.KsvmEstMaestra::__KsvmEncriptacion($rows['CmpId']).'" target="_blank"><i class="zmdi zmdi-print"></i></a>
                                                    <div class="mdl-tooltip" for="btn-print">Imprimir</div>';
                                    }
                                }elseif ($KsvmRol == 3){
                                    $KsvmTabla .= '<a id="btn-detail" class="btn btn-sm btn-info" href="'.KsvmServUrl.'KsvmCompras/Detail/'.KsvmEstMaestra::__KsvmEncriptacion($rows['CmpId']).'/"><i class="zmdi zmdi-card"></i></a>
                                                    <div class="mdl-tooltip" for="btn-detail">Detalles</div>
                                                    <a id="btn-edit" class="btn btn-sm btn-primary" href="'.KsvmServUrl.'KsvmComprasEditar/'.KsvmEstMaestra::__KsvmEncriptacion($rows['CmpId']).'/1/"><i class="zmdi zmdi-edit"></i></a>
                                                    <div class="mdl-tooltip" for="btn-edit">Editar</div>';
                                }else{
                                    $KsvmTabla .= '<a id="btn-detail" class="btn btn-sm btn-info" href="'.KsvmServUrl.'KsvmCompras/Detail/'.KsvmEstMaestra::__KsvmEncriptacion($rows['CmpId']).'/"><i class="zmdi zmdi-card"></i></a>
                                                    <div class="mdl-tooltip" for="btn-detail">Detalles</div>';
                                }

                                    

                $KsvmTabla .= '</td>
                               </tr>
                             </tbody>';
                             $KsvmContReg ++;
                             }

                            
                $KsvmTabla .= '</table>

                           <br>
				           <div class="mdl-shadow--8dp full-width">
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
                echo '<script> window.location.href=" '.KsvmServUrl.'KsvmComprasCrud"</script>';
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
                    $KsvmTabla .= '<a class = "btn btn-xs btn-success mdl-shadow--8dp " href="'.KsvmServUrl.'KsvmComprasCrud/">Primero</a>
                                   <span></span>
                                   <a class = "btn btn-xs btn-default mdl-shadow--8dp " href="'.KsvmServUrl.'KsvmComprasCrud/'.($KsvmPagina-1).'/"><i class="zmdi zmdi-fast-rewind"></i></a>';
                }

                if ($KsvmPagina == $KsvmNPaginas) {
                    $KsvmTabla .= '<button class = "btn btn-xs btn-default mdl-shadow--8dp disabled"><i class="zmdi zmdi-fast-forward"></i></button>
                                   <span></span>
                                   <button class = "btn btn-xs btn-success mdl-shadow--8dp disabled">Último</button>';
                } else {
                    $KsvmTabla .= '<a class="btn btn-xs btn-default mdl-shadow--8dp" href="'.KsvmServUrl.'KsvmComprasCrud/'.($KsvmPagina+1).'/"><i class="zmdi zmdi-fast-forward"></i></a>
                                   <span></span>
                                   <a class="btn btn-xs btn-success mdl-shadow--8dp" href="'.KsvmServUrl.'KsvmComprasCrud/'.($KsvmNPaginas).'/">Último</a>';
                                   
                                   
                }
                
             
                $KsvmTabla .= '</nav></div>';  

            } elseif ($KsvmTotalReg >= 1 && $KsvmPagina <= $KsvmNPaginas && $KsvmCodigo == 1) {
                $KsvmTabla .= '<nav class="navbar-form navbar-right form-group">';
                
                if ($KsvmPagina == 1) {
                    $KsvmTabla .= '<button class = "btn btn-xs btn-success mdl-shadow--8dp disabled">Primero</button>
                                   <span></span>
                                   <button class = "btn btn-xs btn-default mdl-shadow--8dp disabled"><i class="zmdi zmdi-fast-rewind"></i></button>';
                } else {
                    $KsvmTabla .= '<a class = "btn btn-xs btn-success mdl-shadow--8dp " href="'.KsvmServUrl.'KsvmCompras/1/">Primero</a>
                                   <span></span>
                                   <a class = "btn btn-xs btn-default mdl-shadow--8dp " href="'.KsvmServUrl.'KsvmCompras/'.($KsvmPagina-1).'/"><i class="zmdi zmdi-fast-rewind"></i></a>';
                }

                if ($KsvmPagina == $KsvmNPaginas) {
                    $KsvmTabla .= '<button class = "btn btn-xs btn-default mdl-shadow--8dp disabled"><i class="zmdi zmdi-fast-forward"></i></button>
                                   <span></span>
                                   <button class = "btn btn-xs btn-success mdl-shadow--8dp disabled">Último</button>';
                } else {
                    $KsvmTabla .= '<a class="btn btn-xs btn-default mdl-shadow--8dp" href="'.KsvmServUrl.'KsvmCompras/'.($KsvmPagina+1).'/"><i class="zmdi zmdi-fast-forward"></i></a>
                                   <span></span>
                                   <a class="btn btn-xs btn-success mdl-shadow--8dp" href="'.KsvmServUrl.'KsvmCompras/'.($KsvmNPaginas).'/">Último</a>';
                                   
                                   
                }
                
                $KsvmTabla .= '</nav></div>'; 
            } elseif ($KsvmTotalReg >= 1 && $KsvmPagina <= $KsvmNPaginas && $KsvmCodigo == 3) {
                $KsvmTabla .= '<nav class="navbar-form navbar-right form-group">';
                
                if ($KsvmPagina == 1) {
                    $KsvmTabla .= '<button class = "btn btn-xs btn-success mdl-shadow--8dp disabled">Primero</button>
                                   <span></span>
                                   <button class = "btn btn-xs btn-default mdl-shadow--8dp disabled"><i class="zmdi zmdi-fast-rewind"></i></button>';
                } else {
                    $KsvmTabla .= '<a class = "btn btn-xs btn-success mdl-shadow--8dp " href="'.KsvmServUrl.'KsvmReporteCompras/1/">Primero</a>
                                   <span></span>
                                   <a class = "btn btn-xs btn-default mdl-shadow--8dp " href="'.KsvmServUrl.'KsvmReporteCompras/'.($KsvmPagina-1).'/"><i class="zmdi zmdi-fast-rewind"></i></a>';
                }

                if ($KsvmPagina == $KsvmNPaginas) {
                    $KsvmTabla .= '<button class = "btn btn-xs btn-default mdl-shadow--8dp disabled"><i class="zmdi zmdi-fast-forward"></i></button>
                                   <span></span>
                                   <button class = "btn btn-xs btn-success mdl-shadow--8dp disabled">Último</button>';
                } else {
                    $KsvmTabla .= '<a class="btn btn-xs btn-default mdl-shadow--8dp" href="'.KsvmServUrl.'KsvmReporteCompras/'.($KsvmPagina+1).'/"><i class="zmdi zmdi-fast-forward"></i></a>
                                   <span></span>
                                   <a class="btn btn-xs btn-success mdl-shadow--8dp" href="'.KsvmServUrl.'KsvmReporteCompras/'.($KsvmNPaginas).'/">Último</a>';
                                   
                                   
                }
                
                $KsvmTabla .= '</nav></div>'; 
            }

            
                                   
        return $KsvmTabla;

      } 
     
      /**
       * Función que permite listar una Compra 
       */
     public function __KsvmListarSuperCompras()
     {
      $KsvmDataCompra = "SELECT SQL_CALC_FOUND_ROWS * FROM ksvmvistacompras WHERE CmpEstOcp = 'P'" ;
      $KsvmConsulta = KsvmEstMaestra :: __KsvmConexion();
  
      $KsvmQuery = $KsvmConsulta->query($KsvmDataCompra);
      return $KsvmQuery;
     }

      /**
       * Función que permite inhabilitar una Compra 
       */
      public function __KsvmEliminarCompraControlador()
      {
         $KsvmCode = KsvmEstMaestra :: __KsvmDesencriptacion($_POST['KsvmCodDelete']);
         $KsvmCodCompra = KsvmEstMaestra :: __KsvmFiltrarCadena($KsvmCode);

         $KsvmDelCompra = KsvmCompraModelo :: __KsvmEliminarCompraModelo($KsvmCodCompra);
         if ($KsvmDelCompra->rowCount() == 1) {
            $KsvmAlerta = [
                "Alerta" => "Actualiza",
                "Titulo" => "Compra Inhabilitado",
                "Cuerpo" => "La Compra seleccionada ha sido inhabilitada con éxito",
                "Tipo" => "success"
                ];
             
         } else {
            $KsvmAlerta = [ 
                "Alerta" => "simple",
                "Titulo" => "Error inesperado",
                "Cuerpo" => "No es posible eliminar la compra del sistema",
                "Tipo" => "info"
                ];
         }

         return KsvmEstMaestra :: __KsvmMostrarAlertas($KsvmAlerta);
      }

      /**
       * Función que permite eliminar un registro 
       */
      public function __KsvmEliminarRegistroCompra()
      {
         $KsvmCode = KsvmEstMaestra :: __KsvmDesencriptacion($_POST['KsvmCodX']);
         $KsvmCodCompra = KsvmEstMaestra :: __KsvmFiltrarCadena($KsvmCode);

         $KsvmDelComp = KsvmCompraModelo :: __KsvmEliminarCompra($KsvmCodCompra);
         if ($KsvmDelComp->rowCount() == 1) {
             $KsvmResult = "true";
             
         } else {
            $KsvmAlerta = [
                "Alerta" => "simple",
                "Titulo" => "Error inesperado",
                "Cuerpo" => "No es posible eliminar el Compra del sistema",
                "Tipo" => "info"
                ];
                return KsvmEstMaestra :: __KsvmMostrarAlertas($KsvmAlerta);
                $KsvmResult = "false";
         }

         return $KsvmResult;
      }
    
      /**
       * Función que permite editar una Compra 
       */
      public function __KsvmEditarCompraControlador($KsvmCodCompra)
      {
          $KsvmCodigo = KsvmEstMaestra :: __KsvmDesencriptacion($KsvmCodCompra);

          return KsvmCompraModelo :: __KsvmEditarCompraModelo($KsvmCodigo);
      }

      /**
       * Función que permite editar una Detalle de Compra 
       */
      public function  __KsvmEditarDetalleCompraControlador($KsvmCodCompra)
      {
          $KsvmCodigo = KsvmEstMaestra :: __KsvmDesencriptacion($KsvmCodCompra);

          return KsvmCompraModelo :: __KsvmEditarDetalleCompraModelo($KsvmCodigo);
      }

      /**
       * Función que permite editar una Detalle de Compra 
       */
      public function  __KsvmEditarDataCompraControlador($KsvmCodCompra)
      {
          $KsvmCodigo = KsvmEstMaestra :: __KsvmDesencriptacion($KsvmCodCompra);

          return KsvmCompraModelo :: __KsvmCargarDataModelo($KsvmCodigo);
      }
      
      /**
       * Función que permite contar una Compra 
       */
      public function __KsvmContarCompraControlador($KsvmTokken)
      {
          if ($KsvmTokken == 0) {
            $KsvmContaCompra = KsvmCompraModelo :: __KsvmContarCompraSuperModelo();
          } elseif ($KsvmTokken == 1) {
            $KsvmContaCompra = KsvmCompraModelo :: __KsvmContarCompraTecniModelo();
          } else{
            $KsvmContaCompra = KsvmCompraModelo :: __KsvmContarCompraModelo();
          }
          return $KsvmContaCompra; 
      }

      /**
       * Función que permite imprimir una Compra 
       */
      public function __KsvmImprimirCompraControlador()
      {
        return KsvmCompraModelo :: __KsvmImprimirCompraModelo();
      }

      /**
       * Función que permite imprimir un detalle de Compra 
       */
      public function __KsvmImprimirDetalleCompraControlador($KsvmCodCompra)
      {
        $KsvmCodigo = KsvmEstMaestra :: __KsvmDesencriptacion($KsvmCodCompra);
        return KsvmCompraModelo :: __KsvmEditarDetalleCompraModelo($KsvmCodigo);
      }

      /**
       * Función que permite revisar una Compra 
       */
      public function __KsvmRevisarCompra()
      {
        $KsvmTokken = KsvmEstMaestra :: __KsvmDesencriptacion($_POST['KsvmTokken']);
        $KsvmCodRevision = KsvmEstMaestra :: __KsvmDesencriptacion($_POST['KsvmCodRevision']);
        if ($KsvmTokken == "APB") {
            $KsvmRevCompra =[
                "KsvmCodCompra" => $KsvmCodRevision
            ];

            $KsvmApbrCompra = KsvmCompraModelo :: __KsvmApruebaCompraModelo($KsvmRevCompra);
            if ($KsvmApbrCompra->rowCount() >= 1) {
                $KsvmAlerta = [
                "Alerta" => "Actualiza",
                "Titulo" => "Grandioso",
                "Cuerpo" => "La Compra a sido aprobada satisfactoriamente",
                "Tipo" => "success"
                ];
            } else {
                $KsvmAlerta = [
                "Alerta" => "simple",
                "Titulo" => "Error inesperado",
                "Cuerpo" => "No se a podido actualizar la información de la Compra",
                "Tipo" => "info"
                ];
            }
            return KsvmEstMaestra :: __KsvmMostrarAlertas($KsvmAlerta);

        } else {

            $KsvmRevCompra =[
                "KsvmCodCompra" => $KsvmCodRevision
            ];

            $KsvmNiegaCompra = KsvmCompraModelo :: __KsvmNiegaCompraModelo($KsvmRevCompra);
            if ($KsvmNiegaCompra->rowCount() >= 1) {
                $KsvmAlerta = [
                "Alerta" => "Actualiza",
                "Titulo" => "Grandioso",
                "Cuerpo" => "La Compra a sido negada satisfactoriamente",
                "Tipo" => "success"
                ];
            } else {
                $KsvmAlerta = [
                "Alerta" => "simple",
                "Titulo" => "Error inesperado",
                "Cuerpo" => "No se a podido actualizar la información de la Compra",
                "Tipo" => "info"
                ];
            }
            return KsvmEstMaestra :: __KsvmMostrarAlertas($KsvmAlerta);
        }
        

      }

      /**
       * Función que permite actualizar una Compra 
       */
      public function __KsvmActualizarCompraControlador()
      {
        $KsvmCodCompra = KsvmEstMaestra :: __KsvmDesencriptacion($_POST['KsvmCodEdit']);
        $KsvmPvdId = KsvmEstMaestra :: __KsvmFiltrarCadena($_POST['KsvmPvdId']);
        $KsvmFchPagoOcp = KsvmEstMaestra :: __KsvmFiltrarCadena($_POST['KsvmFchPagoOcp']);
        $KsvmNumFactOcp = KsvmEstMaestra :: __KsvmFiltrarCadena($_POST['KsvmNumFactOcp']);
        $KsvmPerAprbOcp = KsvmEstMaestra :: __KsvmFiltrarCadena($_POST['KsvmPerAprbOcp']);
        $KsvmEstOcp = KsvmEstMaestra :: __KsvmFiltrarCadena($_POST['KsvmEstOcp']);

        session_start(['name' => 'SIGIM']);
        $KsvmRol = $_SESSION['KsvmRolId-SIGIM'];
        $KsvmSelectUdMedica = "SELECT * FROM ksvmseleccionaunidadmedica WHERE RrlId = '$KsvmRol'";

        $KsvmConsulta = KsvmEstMaestra :: __KsvmConexion();
        $KsvmQuery = $KsvmConsulta->query($KsvmSelectUdMedica);
        $KsvmUniMed = $KsvmQuery->fetch();
        $KsvmUmdId = $KsvmUniMed['UmdId'];

        $KsvmActualCompra = [                       
            "KsvmUmdId" => $KsvmUmdId,
            "KsvmPvdId" => $KsvmPvdId,
            "KsvmFchPagoOcp" => $KsvmFchPagoOcp,
            "KsvmNumFactOcp" => $KsvmNumFactOcp,
            "KsvmPerAprbOcp" => $KsvmPerAprbOcp,
            "KsvmEstOcp" => $KsvmEstOcp,
            "KsvmCodCompra" => $KsvmCodCompra
            ];

            $KsvmGuardarCompra = KsvmCompraModelo :: __KsvmActualizarCompraModelo($KsvmActualCompra);
                if ($KsvmGuardarCompra->rowCount() >= 1) {
                    $KsvmAlerta = [
                    "Alerta" => "Actualiza",
                    "Titulo" => "Grandioso",
                    "Cuerpo" => "La Compra se actualizó satisfactoriamente",
                    "Tipo" => "success"
                    ];
                } else {
                    $KsvmAlerta = [
                    "Alerta" => "simple",
                    "Titulo" => "Error inesperado",
                    "Cuerpo" => "No se a podido actualizar la información de la Compra",
                    "Tipo" => "info"
                    ];
                }
                return KsvmEstMaestra :: __KsvmMostrarAlertas($KsvmAlerta);
         
        }

              /**
       * Función que permite actualizar un detalle de Compra 
       */
      public function __KsvmActualizarDetalleCompraControlador()
      {
        $KsvmCodCompra = KsvmEstMaestra :: __KsvmDesencriptacion($_POST['KsvmCodEdit']);
        $KsvmMdcId = KsvmEstMaestra :: __KsvmFiltrarCadena($_POST['KsvmMdcId']);
        $KsvmCantOcp = KsvmEstMaestra :: __KsvmFiltrarCadena($_POST['KsvmCantOcp']);
        $KsvmValorUntOcp = KsvmEstMaestra :: __KsvmFiltrarCadena($_POST['KsvmValorUntOcp']);
        $KsvmObservOcp = KsvmEstMaestra :: __KsvmFiltrarCadena($_POST['KsvmObservOcp']);

        $KsvmValorTotOcp = $KsvmCantOcp*$KsvmValorUntOcp;

        $KsvmActualDetCompra = [                       
            "KsvmMdcId" => $KsvmMdcId,
            "KsvmCantOcp" => $KsvmCantOcp,
            "KsvmValorUntOcp" => $KsvmValorUntOcp,
            "KsvmValorTotOcp" => $KsvmValorTotOcp,
            "KsvmObservOcp" => $KsvmObservOcp,
            "KsvmCodCompra" => $KsvmCodCompra
            ];

            $KsvmGuardarDetCompra = KsvmCompraModelo :: __KsvmActualizarDetalleCompraModelo($KsvmActualDetCompra);
                if ($KsvmGuardarDetCompra->rowCount() >= 1) {
                    $KsvmAlerta = [
                    "Alerta" => "Actualiza",
                    "Titulo" => "Grandioso",
                    "Cuerpo" => "El detalle de Compra se actualizó satisfactoriamente",
                    "Tipo" => "success"
                    ];
                } else {
                    $KsvmAlerta = [
                    "Alerta" => "simple",
                    "Titulo" => "Error inesperado",
                    "Cuerpo" => "No se a podido actualizar la información de la Compra",
                    "Tipo" => "info"
                    ];
                }
                return KsvmEstMaestra :: __KsvmMostrarAlertas($KsvmAlerta);
         
        }

      /**
       * Función que permite seleccionar una Compra 
       */
        public function __KsvmSeleccionarCompra()
        {
            $KsvmSelectCat = "SELECT * FROM ksvmvistacompras";

            $KsvmConsulta = KsvmEstMaestra :: __KsvmConexion();
            $KsvmQuery = $KsvmConsulta->query($KsvmSelectCat);
            $KsvmQuery = $KsvmQuery->fetchAll();
            
            foreach ($KsvmQuery as $row) {
                $KsvmListar .= '<option value="'.$row['CmpId'].'">Num: '.$row['CmpNumOcp'].'  Fecha-Compra: '.$row['CmpFchElabOcp'].'</option>';
            }
            return $KsvmListar;
        }

      /**
       * Función que permite cargar un medicamento 
       */
        public function __KsvmCargarMedicamento()
        {

            $KsvmDoc = $_POST['KsvmCmpCod'];
            $KsvmSelectMed = "SELECT * FROM ksvmvistadetallecompras WHERE CmpId = '$KsvmDoc'";
    
            $KsvmConsulta = KsvmEstMaestra :: __KsvmConexion();
            $KsvmQuery = $KsvmConsulta->query($KsvmSelectMed);
            $KsvmQuery = $KsvmQuery->fetchAll();
            $KsvmListar = '<option value="" selected="" disabled>Seleccione Medicamento</option>';
    
            foreach ($KsvmQuery as $row) {
                $KsvmListar .= '<option value="'.$row['DocId'].'">'.$row['MdcDescMed'].' '.$row['MdcConcenMed'].'</option>';
            }
            return $KsvmListar;
        }

        /**
         * Función que permite cargar el stock 
         */
        public function __KsvmCargarStock()
        {

            $KsvmStock = $_POST['KsvmDocCod'];
            $KsvmDataStock = KsvmCompraModelo :: __KsvmCargarDataModelo($KsvmStock);
            if ($KsvmDataStock->rowCount() == 1) {
                $KsvmLlenarStock = $KsvmDataStock->fetch();
                $KsvmListar = '<input class="mdl-textfield__input" type="text" name="KsvmStockEx"
                               value="'.$KsvmLlenarStock['DocCantOcp'].'">';

            }

            return $KsvmListar;
        }
    
}
   
 