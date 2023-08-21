<?php
  /**
   *Condicion para peticion Ajax
   */
   if ($KsvmPeticionAjax) {
       require_once "../Modelos/KsvmCompraModelo.php";
   } else {
       require_once "./Modelos/KsvmCompraModelo.php";
   }

//    use PHPMailer\PHPMailer\PHPMailer;
//    use PHPMailer\PHPMailer\Exception;

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

        $KsvmUser = $_SESSION['KsvmUsuId-SIGIM'];
        $KsvmElabora = "SELECT concat(EpoPriApeEmp,' ',EpoSegApeEmp,' ',EpoPriNomEmp,' ',EpoSegNomEmp) as PerElab FROM ksvmvistaempleado WHERE UsrId = '$KsvmUser'";
        $KsvmQuery = KsvmEstMaestra :: __KsvmConexion()->query($KsvmElabora);
         
         if ($KsvmQuery->rowCount() == 1) {
            $KsvmPerElab = $KsvmQuery->fetch();

            $KsvmFchElabOcp = date("Y-m-d");
            $KsvmFchRevOcp = "no registrado";
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
                "KsvmFchRevOcp" => $KsvmFchRevOcp,
                "KsvmNumFactOcp" => $KsvmNumFactOcp,
                "KsvmPerElabOcp" => $KsvmPerElabOcp,
                "KsvmPerAprbOcp" => $KsvmPerAprbOcp,
                "KsvmUsrId" => $KsvmUser

                ];

                $KsvmGuardarCompra = KsvmCompraModelo :: __KsvmAgregarCompraModelo($KsvmNuevaCompra);
                if ($KsvmGuardarCompra->rowCount() >= 1) {

                    $KsvmAlerta = [
                    "Alerta" => "Actualiza",
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

        $KsvmMedicamento = "SELECT MdcId FROM ksvmdetallecompras14 WHERE MdcId ='$KsvmMdcId' AND DocEstOcp = 'N'";
        $KsvmQuery = KsvmEstMaestra :: __KsvmEjecutaConsulta($KsvmMedicamento);
        if ($KsvmQuery->rowCount() >= 1) {
           $KsvmAlerta = [
             "Alerta" => "simple",
             "Titulo" => "Error inesperado",
             "Cuerpo" => "El medicamento ingresado ya se encuentra registrado!, Por favor intentelo de nuevo",
             "Tipo" => "info"
            ];

        } else{

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
        $KsvmBuscarFin = KsvmEstMaestra :: __KsvmFiltrarCadena($KsvmBuscarFin);
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
                                <th class="mdl-data-table__cell--non-numeric hide-on-tablet">Resp</th>
                                <th class="mdl-data-table__cell--non-numeric hide-on-tablet">Und Médica</th>
                                <th class="mdl-data-table__cell--non-numeric">Prov</th>
                                <th class="mdl-data-table__cell--non-numeric">Total</th>
                                <th style="text-align:center; witdh:30px;">Acción</th>
                            </tr>
                        </thead>
                        <tbody>';

        if ($KsvmTotalReg >= 1 && $KsvmPagina <= $KsvmNPaginas) {
            $KsvmContReg = $KsvmDesde +1;
            foreach ($KsvmQuery as $rows) {
                $KsvmValTot = $rows['CmpId'];
                $KsvmTotal = "SELECT SUM(DocValorTotOcp) AS ValorTotal FROM ksvmdetallecompras14 WHERE CmpId = '$KsvmValTot'";
                $KsvmConVal = $KsvmConsulta->query($KsvmTotal);
                $KsvmValTotal = $KsvmConVal->fetch();
                $KsvmTabla .= '<tr>
                                <td class="mdl-data-table__cell--non-numeric">'.$KsvmContReg.'</td>
                                <td class="mdl-data-table__cell--non-numeric">'.$rows['CmpNumOcp'].'</td>
                                <td class="mdl-data-table__cell--non-numeric">'.$rows['CmpFchElabOcp'].'</td>
                                <td class="mdl-data-table__cell--non-numeric">'.$rows['CmpNumFactOcp'].'</td>
                                <td class="mdl-data-table__cell--non-numeric hide-on-tablet">'.$rows['CmpPerElabOcp'].'</td>
                                <td class="mdl-data-table__cell--non-numeric hide-on-tablet">'.$rows['UmdNomUdm'].'</td>
                                <td class="mdl-data-table__cell--non-numeric">'.$rows['PvdRazSocProv'].'</td>
                                <td class="mdl-data-table__cell--non-numeric">'.$KsvmValTotal['ValorTotal'].'</td>
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
                                    $KsvmTabla .= ' <a id="btn-detail" class="btn btn-sm btn-info" href="'.KsvmServUrl.'KsvmReporteComprasGen/Detail/'.KsvmEstMaestra::__KsvmEncriptacion($rows['CmpId']).'"><i class="zmdi zmdi-card"></i></a>
                                                    <div class="mdl-tooltip" for="btn-detail">Detalles</div>
                                                    <a id="btn-print" class="btn btn-sm btn-success" href="'.KsvmServUrl.'Reportes/KsvmComprasPdf.php?Cod='.KsvmEstMaestra::__KsvmEncriptacion($rows['CmpId']).'" target="_blank"><i class="zmdi zmdi-print"></i></a>
                                                    <div class="mdl-tooltip" for="btn-print">Imprimir</div>';
                                    }

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
                    $KsvmTabla .= '<a class = "btn btn-xs btn-success mdl-shadow--8dp " href="'.KsvmServUrl.'KsvmReporteComprasGen/1/">Primero</a>
                                   <span></span>
                                   <a class = "btn btn-xs btn-default mdl-shadow--8dp " href="'.KsvmServUrl.'KsvmReporteComprasGen/'.($KsvmPagina-1).'/"><i class="zmdi zmdi-fast-rewind"></i></a>';
                }

                if ($KsvmPagina == $KsvmNPaginas) {
                    $KsvmTabla .= '<button class = "btn btn-xs btn-default mdl-shadow--8dp disabled"><i class="zmdi zmdi-fast-forward"></i></button>
                                   <span></span>
                                   <button class = "btn btn-xs btn-success mdl-shadow--8dp disabled">Último</button>';
                } else {
                    $KsvmTabla .= '<a class="btn btn-xs btn-default mdl-shadow--8dp" href="'.KsvmServUrl.'KsvmReporteComprasGen/'.($KsvmPagina+1).'/"><i class="zmdi zmdi-fast-forward"></i></a>
                                   <span></span>
                                   <a class="btn btn-xs btn-success mdl-shadow--8dp" href="'.KsvmServUrl.'KsvmReporteComprasGen/'.($KsvmNPaginas).'/">Último</a>';
                                   
                                   
                }
                
                $KsvmTabla .= '</nav></div>'; 
            }

            
                                   
        return $KsvmTabla;

      } 

      public function __KsvmBuscaHistorial($KsvmCategoria, $KsvmMedicamento)
      {

        $KsvmCategoria = KsvmEstMaestra :: __KsvmFiltrarCadena($KsvmCategoria);
        $KsvmMedicamento = KsvmEstMaestra :: __KsvmFiltrarCadena($KsvmMedicamento);

        if ((isset($KsvmCategoria) && $KsvmCategoria != "") || (isset($KsvmMedicamento) && $KsvmMedicamento != "")) {
            $KsvmDataCompra = "SELECT * FROM ksvmvistadetallecompras WHERE (DocEstOcp != 'I') AND (MdcId = '$KsvmMedicamento' 
                          OR CtgId = '$KsvmCategoria')";
        } else {
                $KsvmDataCompra = "SELECT * FROM ksvmvistadetallecompras WHERE DocEstOcp != 'I'" ;
            
        }

        $KsvmTabla = '<figure class="highcharts-figure">
                        <div id="containerCant" class="full-width">
                        <table class="mdl-data-table mdl-js-data-table mdl-shadow--2dp full-width table-responsive">
                        <thead>
                            <tr>
                                <th class="mdl-data-table__cell--non-numeric hide-on-tablet">Foto</th>
                                <th class="mdl-data-table__cell--non-numeric">Medicamento</th>
                                <th class="mdl-data-table__cell--non-numeric">#Comp</th>
                                <th class="mdl-data-table__cell--non-numeric">Fecha</th>
                                <th class="mdl-data-table__cell--non-numeric">Prov</th>
                                <th class="mdl-data-table__cell--non-numeric">Total</th>
                            </tr>
                        </thead>
                        <tbody>';

        $KsvmConsulta = KsvmEstMaestra :: __KsvmConexion();
        $KsvmQuery = $KsvmConsulta->query($KsvmDataCompra);        

        if ($KsvmQuery-> rowCount() >= 1) {     

        $KsvmQuery = $KsvmQuery->fetchAll();
        foreach ($KsvmQuery as $rows) {
            $KsvmValTot = $rows['CmpId'];
            $KsvmProv = $rows['PvdId'];
            $KsvmCat = $rows['CtgId'];

            $KsvmTotal = "SELECT SUM(DocValorTotOcp) AS ValorTotal FROM ksvmdetallecompras14 WHERE CmpId = '$KsvmValTot'";
            $KsvmConVal = $KsvmConsulta->query($KsvmTotal);
            $KsvmValTotal = $KsvmConVal->fetch();

            $KsvmProveedor = "SELECT PvdRazSocProv FROM ksvmproveedor04 WHERE PvdId = '$KsvmProv'";
            $KsvmConVal = $KsvmConsulta->query($KsvmProveedor);
            $KsvmProveeSel = $KsvmConVal->fetch();

            $KsvmCategoria = "SELECT CtgColorCat FROM ksvmcategoria10 WHERE CtgId = '$KsvmCat'";
            $KsvmConVal = $KsvmConsulta->query($KsvmCategoria);
            $KsvmCatColor = $KsvmConVal->fetch();
            $KsvmTabla .= ' 
                            <tr>
                            <td class="mdl-data-table__cell--non-numeric hide-on-tablet" style="background-color:'.$KsvmCatColor['CtgColorCat'].';">
                            <img style="border-radius:50px;" height="75px" width="75px" src="data:image/jpg;base64,'. base64_encode($rows['MdcFotoMed']).'"/></td>
                            <td class="mdl-data-table__cell--non-numeric">'.$rows['MdcDescMed'].' '.$rows['MdcConcenMed'].'</td>
                            <td class="mdl-data-table__cell--non-numeric">'.$rows['CmpNumOcp'].'</td>
                            <td class="mdl-data-table__cell--non-numeric">'.$rows['CmpFchRevOcp'].'</td>
                            <td class="mdl-data-table__cell--non-numeric">'.$KsvmProveeSel['PvdRazSocProv'].'</td>
                            <td class="mdl-data-table__cell--non-numeric">'.$KsvmValTotal['ValorTotal'].'</td>
                            </tr>';
            }

            $KsvmTabla .= ' </tbody>
                            </table>
                            </div>
                            </figure>';
                        

            } else{
                $KsvmTabla .= '<tr> 
                            <td class="mdl-data-table__cell--non-numeric" colspan="7"><strong>No se encontraron registros...</strong></td>
                            </tr>
                            </tbody>
                            </table>
                            </div>
                            </figure>';
            }

                return $KsvmTabla;
      }


      /**
       * Función que permite exportar a excel
       */
      public function __KsvmNuevoExcel()
      {
        $KsvmBuscarIni = KsvmEstMaestra :: __KsvmFiltrarCadena($KsvmBuscarIni);
        $KsvmBuscarFin = KsvmEstMaestra :: __KsvmFiltrarCadena($KsvmBuscarFin);

        if(isset($_POST['generar_reporte']))
        {
            // NOMBRE DEL ARCHIVO Y CHARSET
            header('Content-Type:text/csv; charset=latin1');
            header('Content-Disposition: attachment; filename="Reporte_Fechas_Ingreso.csv"');

            // SALIDA DEL ARCHIVO
            $salida=fopen('php://output', 'w');
            // ENCABEZADOS
            fputcsv($salida, array('#OrdCompra', 'Medicamento', 'Num.Fact', 'Fecha', 'Proveedor', 'Total'));
            // QUERY PARA CREAR EL REPORTE
            $reporteCsv=$conexion->query("SELECT *  FROM ksvmvistadetallecompras WHERE CmpFchRevOcp BETWEEN '$KsvmBuscarIni' AND '$KsvmBuscarFin' ORDER BY id_alumno");
            while($filaR= $reporteCsv->fetch_assoc())
                fputcsv($salida, array($filaR['id_alumno'], 
                                        $filaR['nombre'],
                                        $filaR['carrera'],
                                        $filaR['grupo'],
                                        $filaR['fecha_ingreso']));

        }
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
            $KsvmContaCompra = KsvmCompraModelo :: __KsvmContarCompraSupervisor();
          } elseif ($KsvmTokken == 1) {
            $KsvmContaCompra = KsvmCompraModelo :: __KsvmContarCompraTecnico();
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
        session_start(['name' => 'SIGIM']);
        // haciendo referencia a la clase phpmailer

        $KsvmTokken = KsvmEstMaestra :: __KsvmDesencriptacion($_POST['KsvmTokken']);
        $KsvmCodRevision = KsvmEstMaestra :: __KsvmDesencriptacion($_POST['KsvmCodRevision']);

        $KsvmCompras = "SELECT  CmpId FROM ksvmvistacompras";
        $KsvmQuery = KsvmEstMaestra :: __KsvmEjecutaConsulta($KsvmCompras);
        $KsvmNum = ($KsvmQuery->rowCount())+1;

        $KsvmNumFact = KsvmEstMaestra :: __KsvmGeneraCodigoAleatorio("000", 3, $KsvmNum);

        $KsvmUser = $_SESSION['KsvmUsuId-SIGIM'];
        echo $KsvmUser;
        $KsvmElabora = "SELECT concat(EpoPriApeEmp,' ',EpoSegApeEmp,' ',EpoPriNomEmp,' ',EpoSegNomEmp) as PerRev FROM ksvmvistaempleado WHERE UsrId = '$KsvmUser'";
        $KsvmQuery = KsvmEstMaestra :: __KsvmConexion()->query($KsvmElabora);
         
         if ($KsvmQuery->rowCount() == 1) {
            $KsvmPerRev = $KsvmQuery->fetch();

            $KsvmFchRevOcp = date("Y-m-d");
            $KsvmPerRevOcp = $KsvmPerRev['PerRev'];
         }

        if ($KsvmTokken == "APB") {

            $KsvmRevCompra =[
                "KsvmNumFactOcp" => $KsvmNumFact,
                "KsvmFchRevOcp" => $KsvmFchRevOcp,
                "KsvmPerRevOcp" => $KsvmPerRevOcp,
                "KsvmCodCompra" => $KsvmCodRevision
            ];

            $KsvmApbrCompra = KsvmCompraModelo :: __KsvmApruebaCompraModelo($KsvmRevCompra);
            if ($KsvmApbrCompra->rowCount() >= 1) {

                include '../Reportes/ModeloPdf.php'; //este archivo contiene el encabezado y pie de pagina del pdf

                $KsvmCompraAprb = "SELECT * FROM ksvmvistacompras WHERE CmpId = '$KsvmCodRevision'";
                $KsvmQuery = KsvmEstMaestra :: __KsvmConexion()->query($KsvmCompraAprb);
                $KsvmDataCompra = $KsvmQuery->fetch();
    
                $pdf = new PDF();
    
                $pdf->AddPage();
    
                $pdf->Ln(10);
                $pdf->Cell(110);
                $pdf->SetFont('Arial','B',10);
                $pdf->Cell(40,6,'Numero de Orden:',1,0,'C');
                $pdf->SetFont('Arial','',8);
                $pdf->Cell(40,6,$KsvmDataCompra['CmpNumOcp'],1,0,'C');
                $pdf->Ln(10);
                $pdf->SetFont('Arial','B',10);
                $pdf->Cell(190,7,utf8_decode('Datos del Proveedor'),1,1,'C');
                $pdf->Cell(130,7,utf8_decode('Razón Social'),1,0,'C');
                $pdf->Cell(30,7,utf8_decode('Fecha'),1,0,'C');
                $pdf->Cell(30,7,utf8_decode('Teléfono'),1,1,'C');
                $pdf->SetFont('Arial','',8);
                $pdf->Cell(130,7,utf8_decode($KsvmDataCompra['PvdRazSocProv']),1,0,'C');
                $pdf->Cell(30,7,utf8_decode($KsvmDataCompra['CmpFchRevOcp']),1,0,'C');
                $pdf->Cell(30,7,utf8_decode($KsvmDataCompra['PvdTelfProv']),1,1,'C');
                $pdf->SetFont('Arial','B',10);
                $pdf->Cell(120,7,utf8_decode('Dirección'),1,0,'C');
                $pdf->Cell(70,7,utf8_decode('Solicitado por:'),1,1,'C');
                $pdf->SetFont('Arial','',8);
                $pdf->Cell(120,7,utf8_decode($KsvmDataCompra['PvdDirProv']),1,0,'C');
                $pdf->Cell(70,7,utf8_decode($KsvmDataCompra['UmdNomUdm']),1,1,'C');
                $pdf->Ln(5);
                $pdf->SetFont('Arial','B',10);
                $pdf->Cell(190,7,utf8_decode('Descripción de la compra'),1,1,'C');
                $pdf->Cell(30,7,utf8_decode('Código'),1,0,'C');
                $pdf->Cell(70,7,utf8_decode('Descripción'),1,0,'C');
                $pdf->Cell(30,7,utf8_decode('Cantidad'),1,0,'C');
                $pdf->Cell(30,7,utf8_decode('Valor Und'),1,0,'C');
                $pdf->Cell(30,7,utf8_decode('Valor Total'),1,1,'C');
    
                $KsvmDetalleCompra = "SELECT * FROM ksvmvistadetallecompras WHERE CmpId = '".$KsvmDataCompra['CmpId']."'";
                $KsvmQuery = KsvmEstMaestra :: __KsvmConexion()->query($KsvmDetalleCompra);
                $KsvmDataCompra = $KsvmQuery->fetchAll();
    
                foreach ($KsvmDataCompra as $row) {
                    $pdf->SetFont('Arial','',8);
                    $pdf->Cell(30,7,utf8_decode($row['MdcCodMed']),1,0,'C');
                    $pdf->Cell(70,7,utf8_decode($row['MdcDescMed'].' '.$row['MdcConcenMed']),1,0,'C');
                    $pdf->Cell(30,7,utf8_decode($row['DocCantOcp']),1,0,'C');
                    $pdf->Cell(30,7,utf8_decode($row['DocValorUntOcp']),1,0,'C');
                    $pdf->Cell(30,7,utf8_decode($row['DocValorTotOcp']),1,1,'C');
                }
    
                $KsvmValTot = $row['CmpId'];
                $KsvmTotal = "SELECT SUM(DocValorTotOcp) AS ValorTotal FROM ksvmdetallecompras14 WHERE CmpId = '$KsvmValTot'";
                $KsvmConVal = KsvmEstMaestra :: __KsvmConexion()->query($KsvmTotal);
                $KsvmValTotal = $KsvmConVal->fetch();
    
                $pdf->Cell(100);
                $pdf->SetFont('Arial','B',10);
                $pdf->Cell(60,7,utf8_decode('Total Generado'),1,0,'C');
                $pdf->SetFont('Arial','',8);
                $pdf->Cell(30,7,utf8_decode($KsvmValTotal['ValorTotal']),1,1,'C');
                $pdf->Cell(100);
                $pdf->SetFont('Arial','B',10);
                $pdf->Cell(60,7,utf8_decode('Total Mas Iva'),1,0,'C');
                $pdf->SetFont('Arial','',8);
                $pdf->Cell(30,7,utf8_decode(($KsvmValTotal['ValorTotal']*0.12)+$KsvmValTotal['ValorTotal']),1,1,'C');
    
                $KsvmCompraAprb = "SELECT * FROM ksvmvistacompras WHERE CmpId = '$KsvmCodRevision'";
                $KsvmQuery = KsvmEstMaestra :: __KsvmConexion()->query($KsvmCompraAprb);
                $KsvmDataCompra = $KsvmQuery->fetch();
    
                $pdf->Ln(15);
                $pdf->SetFont('Arial','',8);
                $pdf->Cell(95,10,utf8_decode($KsvmDataCompra['CmpPerElabOcp']),0,0,'C');
                $pdf->Cell(95,10,utf8_decode($KsvmDataCompra['CmpPerAprbOcp']),0,1,'C');
                $pdf->SetFont('Arial','B',10);
                $pdf->Cell(95,12,utf8_decode('Elaborado por'),0,0,'C');
                $pdf->Cell(95,12,utf8_decode('aprobado por'),0,1,'C');
    
                $doc = $pdf->Output('', 'S');
    
                require_once 'Mail/PHPMailerAutoload.php';
                require_once 'Mail/class.smtp.php';
                require_once 'Mail/class.phpmailer.php';
    
    
                $mail = new PHPMailer();
    
                    //Server settings
                    $mail->SMTPDebug = 0;                     
                    $mail->isSMTP();                                    
                    $mail->Host       = 'smtp.gmail.com';                  
                    $mail->SMTPAuth   = true;                                 
                    $mail->Username   = 'santy.vak69@gmail.com';                     
                    $mail->Password   = 'santy1330dark';                            
                    $mail->SMTPSecure = 'tls';        
                    $mail->Port       = 587;                              
                
                    //Recipients
                    $mail->setFrom('santy.vak69@gmail.com', $KsvmDataCompra['UmdNomUdm']);
                    $mail->addAddress('santy.vak69@gmail.com', $KsvmDataCompra['PvdPerContProv']);   
                    $mail->addAddress('krsantig13@hotmail.com', $KsvmDataCompra['CmpPerElabOcp']);   
                
                    // Attachments
                    $mail->addAttachment('/var/tmp/file.tar.gz');        
                    $mail->AddStringAttachment($doc, 'OdCompras.pdf', 'base64', 'application/pdf');    
                
                    // Content
                    $mail->isHTML(true);                                 
                    $mail->Subject = 'Orden de Compra';
                    $mail->Body    = 'Sirvase en revisar el archivo adjunto';

                
                   if (!$mail->send()) {
                    echo "El Email no pudo ser enviado: {$mail->ErrorInfo}";
                   } else {
                    echo "El Email fue enviado correctamente";
                   }

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
                "KsvmFchRevOcp" => $KsvmFchRevOcp,
                "KsvmPerRevOcp" => $KsvmPerRevOcp,
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
        $KsvmFchRevOcp = KsvmEstMaestra :: __KsvmFiltrarCadena($_POST['KsvmFchRevOcp']);
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

        $KsvmFecha = KsvmEstMaestra :: __KsvmValidaFecha($KsvmFchRevOcp, 2);
        if ($KsvmFecha) {
            $KsvmFecha = $KsvmFchRevOcp;
        } else {
            $KsvmAlerta = [
                "Alerta" => "simple",
                "Titulo" => "Error inesperado",
                "Cuerpo" => "La frcha ingresada no puede ser mayor a la actual",
                "Tipo" => "info"
                ];
                return KsvmEstMaestra :: __KsvmMostrarAlertas($KsvmAlerta);

        }

        $KsvmUser = $_SESSION['KsvmUsuId-SIGIM'];

        $KsvmActualCompra = [                       
            "KsvmUmdId" => $KsvmUmdId,
            "KsvmPvdId" => $KsvmPvdId,
            "KsvmFchRevOcp" => $KsvmFecha,
            "KsvmNumFactOcp" => $KsvmNumFactOcp,
            "KsvmPerAprbOcp" => $KsvmPerAprbOcp,
            "KsvmUsrId" => $KsvmUser,
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
         * Función que permite cargar reportes
         */
        public function __KsvmCargarReporteCompras($KsvmMedicamento, $KsvmAnio, $KsvmTotReg, $KsvmMes, $KsvmTokken)
        {
            $KsvmMedicamento = KsvmEstMaestra :: __KsvmFiltrarCadena($KsvmMedicamento);
            $KsvmAnio = KsvmEstMaestra :: __KsvmFiltrarCadena($KsvmAnio);
            $KsvmUsuario = $_SESSION['KsvmUsuId-SIGIM'];

            $KsvmConsulta = KsvmEstMaestra :: __KsvmConexion();

            if ($KsvmMedicamento != "" && $KsvmAnio != "" && $KsvmTotReg != 0) {

                switch ($KsvmMes) {
                    case 'January':
                        if ($KsvmTokken == 1) {
                            $KsvmTotalMes = "SELECT SUM(DocValorTotOcp) AS ValorTotal FROM ksvmvistadetallecompras WHERE DocEstOcp != 'I' AND CmpMesOcp = 'January' AND 
                            MdcId = '$KsvmMedicamento' AND CmpAnioOcp = '$KsvmAnio'";
                            $KsvmConVal = $KsvmConsulta->query($KsvmTotalMes);
                                $KsvmValRep = $KsvmConVal->fetch();
                                $KsvmTotal =  $KsvmValRep['ValorTotal'];
                                $KsvmDataRep = round(($KsvmTotal*100/$KsvmTotReg));
                        } elseif ($KsvmTokken == 2) {
                            $KsvmTotalMes = "SELECT SUM(DocCantOcp) AS ValorTotal FROM ksvmvistadetallecompras WHERE DocEstOcp != 'I' AND CmpMesOcp = 'January' AND 
                            MdcId = '$KsvmMedicamento' AND CmpAnioOcp = '$KsvmAnio'";
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
                            $KsvmTotalMes = "SELECT SUM(DocValorTotOcp) AS ValorTotal FROM ksvmvistadetallecompras WHERE DocEstOcp != 'I' AND CmpMesOcp = 'February' AND 
                            MdcId = '$KsvmMedicamento' AND CmpAnioOcp = '$KsvmAnio'";
                            $KsvmConVal = $KsvmConsulta->query($KsvmTotalMes);
                                $KsvmValRep = $KsvmConVal->fetch();
                                $KsvmTotal =  $KsvmValRep['ValorTotal'];
                                $KsvmDataRep = round(($KsvmTotal*100/$KsvmTotReg));
                        } elseif ($KsvmTokken == 2) {
                            $KsvmTotalMes = "SELECT SUM(DocCantOcp) AS ValorTotal FROM ksvmvistadetallecompras WHERE DocEstOcp != 'I' AND CmpMesOcp = 'February' AND 
                            MdcId = '$KsvmMedicamento' AND CmpAnioOcp = '$KsvmAnio'";
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
                            $KsvmTotalMes = "SELECT SUM(DocValorTotOcp) AS ValorTotal FROM ksvmvistadetallecompras WHERE DocEstOcp != 'I' AND CmpMesOcp = 'March' AND 
                            MdcId = '$KsvmMedicamento' AND CmpAnioOcp = '$KsvmAnio'";
                            $KsvmConVal = $KsvmConsulta->query($KsvmTotalMes);
                                $KsvmValRep = $KsvmConVal->fetch();
                                $KsvmTotal =  $KsvmValRep['ValorTotal'];
                                $KsvmDataRep = round(($KsvmTotal*100/$KsvmTotReg));
                        } elseif ($KsvmTokken == 2) {
                            $KsvmTotalMes = "SELECT SUM(DocCantOcp) AS ValorTotal FROM ksvmvistadetallecompras WHERE DocEstOcp != 'I' AND CmpMesOcp = 'March' AND 
                            MdcId = '$KsvmMedicamento' AND CmpAnioOcp = '$KsvmAnio'";
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
                            $KsvmTotalMes = "SELECT SUM(DocValorTotOcp) AS ValorTotal FROM ksvmvistadetallecompras WHERE DocEstOcp != 'I' AND CmpMesOcp = 'April' AND 
                            MdcId = '$KsvmMedicamento' AND CmpAnioOcp = '$KsvmAnio'";
                            $KsvmConVal = $KsvmConsulta->query($KsvmTotalMes);
                            $KsvmValRep = $KsvmConVal->fetch();
                            $KsvmTotal =  $KsvmValRep['ValorTotal'];
                            $KsvmDataRep = round(($KsvmTotal*100/$KsvmTotReg));
                        } elseif ($KsvmTokken == 2) {
                            $KsvmTotalMes = "SELECT SUM(DocCantOcp) AS ValorTotal FROM ksvmvistadetallecompras WHERE DocEstOcp != 'I' AND CmpMesOcp = 'April' AND 
                            MdcId = '$KsvmMedicamento' AND CmpAnioOcp = '$KsvmAnio'";
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
                            $KsvmTotalMes = "SELECT SUM(DocValorTotOcp) AS ValorTotal FROM ksvmvistadetallecompras WHERE DocEstOcp != 'I' AND CmpMesOcp = 'May' AND 
                            MdcId = '$KsvmMedicamento' AND CmpAnioOcp = '$KsvmAnio'";
                            $KsvmConVal = $KsvmConsulta->query($KsvmTotalMes);
                            $KsvmValRep = $KsvmConVal->fetch();
                            $KsvmTotal =  $KsvmValRep['ValorTotal'];
                            $KsvmDataRep = round(($KsvmTotal*100/$KsvmTotReg));
                        } elseif ($KsvmTokken == 2) {
                            $KsvmTotalMes = "SELECT SUM(DocCantOcp) AS ValorTotal FROM ksvmvistadetallecompras WHERE DocEstOcp != 'I' AND CmpMesOcp = 'May' AND 
                            MdcId = '$KsvmMedicamento' AND CmpAnioOcp = '$KsvmAnio'";
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
                            $KsvmTotalMes = "SELECT SUM(DocValorTotOcp) AS ValorTotal FROM ksvmvistadetallecompras WHERE DocEstOcp != 'I' AND CmpMesOcp = 'June' AND 
                            MdcId = '$KsvmMedicamento' AND CmpAnioOcp = '$KsvmAnio'";
                            $KsvmConVal = $KsvmConsulta->query($KsvmTotalMes);
                            $KsvmValRep = $KsvmConVal->fetch();
                            $KsvmTotal =  $KsvmValRep['ValorTotal'];
                            $KsvmDataRep = round(($KsvmTotal*100/$KsvmTotReg));
                        } elseif ($KsvmTokken == 2) {
                            $KsvmTotalMes = "SELECT SUM(DocCantOcp) AS ValorTotal FROM ksvmvistadetallecompras WHERE DocEstOcp != 'I' AND CmpMesOcp = 'June' AND 
                            MdcId = '$KsvmMedicamento' AND CmpAnioOcp = '$KsvmAnio'";
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
                            $KsvmTotalMes = "SELECT SUM(DocValorTotOcp) AS ValorTotal FROM ksvmvistadetallecompras WHERE DocEstOcp != 'I' AND CmpMesOcp = 'July' AND 
                            MdcId = '$KsvmMedicamento' AND CmpAnioOcp = '$KsvmAnio'";
                            $KsvmConVal = $KsvmConsulta->query($KsvmTotalMes);
                            $KsvmValRep = $KsvmConVal->fetch();
                            $KsvmTotal =  $KsvmValRep['ValorTotal'];
                            $KsvmDataRep = round(($KsvmTotal*100/$KsvmTotReg));
                        } elseif ($KsvmTokken == 2) {
                            $KsvmTotalMes = "SELECT SUM(DocCantOcp) AS ValorTotal FROM ksvmvistadetallecompras WHERE DocEstOcp != 'I' AND CmpMesOcp = 'July' AND 
                            MdcId = '$KsvmMedicamento' AND CmpAnioOcp = '$KsvmAnio'";
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
                            $KsvmTotalMes = "SELECT SUM(DocValorTotOcp) AS ValorTotal FROM ksvmvistadetallecompras WHERE DocEstOcp != 'I' AND CmpMesOcp = 'August' AND 
                            MdcId = '$KsvmMedicamento' AND CmpAnioOcp = '$KsvmAnio'";
                            $KsvmConVal = $KsvmConsulta->query($KsvmTotalMes);
                            $KsvmValRep = $KsvmConVal->fetch();
                            $KsvmTotal =  $KsvmValRep['ValorTotal'];
                            $KsvmDataRep = round(($KsvmTotal*100/$KsvmTotReg));
                        } elseif ($KsvmTokken == 2) {
                            $KsvmTotalMes = "SELECT SUM(DocCantOcp) AS ValorTotal FROM ksvmvistadetallecompras WHERE DocEstOcp != 'I' AND CmpMesOcp = 'August' AND 
                            MdcId = '$KsvmMedicamento' AND CmpAnioOcp = '$KsvmAnio'";
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
                            $KsvmTotalMes = "SELECT SUM(DocValorTotOcp) AS ValorTotal FROM ksvmvistadetallecompras WHERE DocEstOcp != 'I' AND CmpMesOcp = 'September' AND 
                            MdcId = '$KsvmMedicamento' AND CmpAnioOcp = '$KsvmAnio'";
                            $KsvmConVal = $KsvmConsulta->query($KsvmTotalMes);
                            $KsvmValRep = $KsvmConVal->fetch();
                            $KsvmTotal =  $KsvmValRep['ValorTotal'];
                            $KsvmDataRep = round(($KsvmTotal*100/$KsvmTotReg));
                        } elseif ($KsvmTokken == 2) {
                            $KsvmTotalMes = "SELECT SUM(DocCantOcp) AS ValorTotal FROM ksvmvistadetallecompras WHERE DocEstOcp != 'I' AND CmpMesOcp = 'September' AND 
                            MdcId = '$KsvmMedicamento' AND CmpAnioOcp = '$KsvmAnio'";
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
                            $KsvmTotalMes = "SELECT SUM(DocValorTotOcp) AS ValorTotal FROM ksvmvistadetallecompras WHERE DocEstOcp != 'I' AND CmpMesOcp = 'October' AND 
                            MdcId = '$KsvmMedicamento' AND CmpAnioOcp = '$KsvmAnio'";
                            $KsvmConVal = $KsvmConsulta->query($KsvmTotalMes);
                            $KsvmValRep = $KsvmConVal->fetch();
                            $KsvmTotal =  $KsvmValRep['ValorTotal'];
                            $KsvmDataRep = round(($KsvmTotal*100/$KsvmTotReg));
                        } elseif ($KsvmTokken == 2) {
                            $KsvmTotalMes = "SELECT SUM(DocCantOcp) AS ValorTotal FROM ksvmvistadetallecompras WHERE DocEstOcp != 'I' AND CmpMesOcp = 'October' AND 
                            MdcId = '$KsvmMedicamento' AND CmpAnioOcp = '$KsvmAnio'";
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
                            $KsvmTotalMes = "SELECT SUM(DocValorTotOcp) AS ValorTotal FROM ksvmvistadetallecompras WHERE DocEstOcp != 'I' AND CmpMesOcp = 'November' AND 
                            MdcId = '$KsvmMedicamento' AND CmpAnioOcp = '$KsvmAnio'";
                            $KsvmConVal = $KsvmConsulta->query($KsvmTotalMes);
                            $KsvmValRep = $KsvmConVal->fetch();
                            $KsvmTotal =  $KsvmValRep['ValorTotal'];
                            $KsvmDataRep = round(($KsvmTotal*100/$KsvmTotReg));
                        } elseif ($KsvmTokken == 2) {
                            $KsvmTotalMes = "SELECT SUM(DocCantOcp) AS ValorTotal FROM ksvmvistadetallecompras WHERE DocEstOcp != 'I' AND CmpMesOcp = 'November' AND 
                            MdcId = '$KsvmMedicamento' AND CmpAnioOcp = '$KsvmAnio'";
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
                            $KsvmTotalMes = "SELECT SUM(DocValorTotOcp) AS ValorTotal FROM ksvmvistadetallecompras WHERE DocEstOcp != 'I' AND CmpMesOcp = 'December' AND 
                            MdcId = '$KsvmMedicamento' AND CmpAnioOcp = '$KsvmAnio'";
                            $KsvmConVal = $KsvmConsulta->query($KsvmTotalMes);
                            $KsvmValRep = $KsvmConVal->fetch();
                            $KsvmTotal =  $KsvmValRep['ValorTotal'];
                            $KsvmDataRep = round(($KsvmTotal*100/$KsvmTotReg));
                        } elseif ($KsvmTokken == 2) {
                            $KsvmTotalMes = "SELECT SUM(DocCantOcp) AS ValorTotal FROM ksvmvistadetallecompras WHERE DocEstOcp != 'I' AND CmpMesOcp = 'December' AND 
                            MdcId = '$KsvmMedicamento' AND CmpAnioOcp = '$KsvmAnio'";
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
                    $KsvmTotalMes = "SELECT SUM(DocValorTotOcp) AS ValorTotal FROM ksvmvistadetallecompras WHERE DocEstOcp != 'I' AND 
                    CmpAnioOcp = '$KsvmAnio'";
                    $KsvmConVal = $KsvmConsulta->query($KsvmTotalMes);
                        $KsvmValRep = $KsvmConVal->fetch();
                        $KsvmTotal =  $KsvmValRep['ValorTotal'];

                } elseif ($KsvmTokken == 2) {
                    $KsvmTotalMes = "SELECT SUM(DocCantOcp) AS ValorTotal FROM ksvmvistadetallecompras WHERE DocEstOcp != 'I' AND 
                    CmpAnioOcp = '$KsvmAnio'";
                    $KsvmConVal = $KsvmConsulta->query($KsvmTotalMes);
                    $KsvmValRep = $KsvmConVal->fetch();
                    $KsvmTotal =  $KsvmValRep['ValorTotal'];
                } else {
                    $KsvmTotal = 0;
                }

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
                $KsvmTotalAnio = "SELECT SUM(DocValorTotOcp) AS ValorTotal FROM ksvmvistadetallecompras WHERE DocEstOcp != 'I' AND 
                MdcId = '$KsvmMedicamento' AND CmpAnioOcp = '$KsvmAnio'";
                $KsvmQuery = $KsvmConsulta->query($KsvmTotalAnio);
                $KsvmValTotal = $KsvmQuery->fetch();
                $KsvmTotReg =  $KsvmValTotal['ValorTotal'];
            } else {
                $KsvmTotalAnio = "SELECT SUM(DocCantOcp) AS ValorTotal FROM ksvmvistadetallecompras WHERE DocEstOcp != 'I' AND 
                MdcId = '$KsvmMedicamento' AND CmpAnioOcp = '$KsvmAnio'";
                $KsvmQuery = $KsvmConsulta->query($KsvmTotalAnio);
                $KsvmValTotal = $KsvmQuery->fetch();
                $KsvmTotReg =  $KsvmValTotal['ValorTotal'];
            }

        return $KsvmTotReg;
        
      }

      /**
       * Función que permite seleccionar una Compra  
       */
        public function __KsvmSeleccionarCompra()
        {
            $KsvmSelectCat = "SELECT * FROM ksvmvistacompras WHERE CmpEstOcp = 'A'";

            $KsvmConsulta = KsvmEstMaestra :: __KsvmConexion();
            $KsvmQuery = $KsvmConsulta->query($KsvmSelectCat);
            $KsvmQuery = $KsvmQuery->fetchAll();
            
            foreach ($KsvmQuery as $row) {
                $KsvmListar .= '<option value="'.$row['CmpId'].'">Num: '.$row['CmpNumOcp'].'  Fecha-Compra: '.$row['CmpFchElabOcp'].'</option>';
            }
            return $KsvmListar;
        }

      /**
       * Función que permite seleccionar un detalle de Compra 
       */
      public function __KsvmSeleccionarDetalleCompra()
      {
          $KsvmSelectCat = "SELECT * FROM ksvmvistadetallecompras";

          $KsvmConsulta = KsvmEstMaestra :: __KsvmConexion();
          $KsvmQuery = $KsvmConsulta->query($KsvmSelectCat);
          $KsvmQuery = $KsvmQuery->fetchAll();
          
          foreach ($KsvmQuery as $row) {
              $KsvmListar .= '<option value="'.$row['DocId'].'">'.$row['MdcDescMed'].' '.$row['MdcConcenMed'].'</option>';
          }
          return $KsvmListar;
      }

      /**
       * Función que permite cargar un medicamento 
       */
        public function __KsvmCargarMedicamento()
        {

            $KsvmDoc = $_POST['KsvmCmpCod'];
            $KsvmSelectMed = "SELECT * FROM ksvmvistadetallecompras WHERE CmpId = '$KsvmDoc' AND DocEstOcp = 'P'";
    
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
   
 