<?php

  /**
   *Condicion para peticion Ajax
   */
   if ($KsvmPeticionAjax) {
       require_once "../Modelos/KsvmExistenciaModelo.php";
   } else {
       require_once "./Modelos/KsvmExistenciaModelo.php";
   }

//    require_once './Vistas/Contenidos/barcode.php';

   class KsvmExistenciaControlador extends KsvmExistenciaModelo
   {
     /**
      *Función que permite ingresar una Existencia
      */
     public function __KsvmAgregarExistenciaControlador()
     {
         $KsvmDocId = KsvmEstMaestra :: __KsvmFiltrarCadena($_POST['KsvmDocId']);
         $KsvmLoteEx = KsvmEstMaestra :: __KsvmFiltrarCadena($_POST['KsvmLoteEx']);
         $KsvmFchCad = KsvmEstMaestra :: __KsvmFiltrarCadena($_POST['KsvmFchCadEx']);
         $KsvmStockIniEx = KsvmEstMaestra :: __KsvmFiltrarCadena($_POST['KsvmStockIniEx']);
         $KsvmStockSegEx = KsvmEstMaestra :: __KsvmFiltrarCadena($_POST['KsvmStockSegEx']);
         $KsvmBinLocEx = KsvmEstMaestra :: __KsvmFiltrarCadena($_POST['KsvmBinLocEx']);

         $KsvmFecha = KsvmEstMaestra :: __KsvmValidaFecha($KsvmFchCad, 1);
         if ($KsvmFecha) {
            $KsvmFchCadEx = $KsvmFchCad;
         } else {
            $KsvmAlerta = [
                "Alerta" => "simple",
                "Titulo" => "Error inesperado",
                "Cuerpo" => "La fecha de caducidad no cumple las condiciones, La fecha debe ser mínimo 3 meses superior",
                "Tipo" => "info"
               ];
               return KsvmEstMaestra :: __KsvmMostrarAlertas($KsvmAlerta);
         }
         

         $KsvmDiaCal=date("d",strtotime($KsvmFchCadEx));
         $KsvmMesCal=date("m",strtotime($KsvmFchCadEx));
         $KsvmAnioCal=date("Y",strtotime($KsvmFchCadEx));
         $KsvmFchCaduc = $KsvmAnioCal.$KsvmMesCal.$KsvmDiaCal;
         $KsvmCodBarEx = $KsvmLoteEx.$KsvmFchCaduc;

         $KsvmLote = "SELECT ExtLoteEx FROM ksvmexistencias21 WHERE ExtLoteEx ='$KsvmLoteEx'";
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
                "KsvmStockIniEx" => $KsvmStockIniEx,
                "KsvmStockSegEx" => $KsvmStockSegEx,
                "KsvmCodBarEx" => $KsvmCodBarEx,
                "KsvmBinLocEx" => $KsvmBinLocEx
                ];

                $KsvmGuardarExt = KsvmExistenciaModelo :: __KsvmAgregarExistenciaModelo($KsvmNuevaExt);
                if ($KsvmGuardarExt->rowCount() == 1) {
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
                
             }
             return KsvmEstMaestra :: __KsvmMostrarAlertas($KsvmAlerta);
    }
            
    /**
     * Función que permite paginar 
     */
      public function __KsvmPaginador($KsvmPagina, $KsvmNRegistros, $KsvmRol, $KsvmRolNom, $KsvmCodigo, $KsvmBuscar)
      {
        require_once './Vistas/Contenidos/barcode.php';

        $KsvmPagina = KsvmEstMaestra :: __KsvmFiltrarCadena($KsvmPagina);
        $KsvmNRegistros = KsvmEstMaestra :: __KsvmFiltrarCadena($KsvmNRegistros);
        $KsvmRol = KsvmEstMaestra :: __KsvmFiltrarCadena($KsvmRol);
        $KsvmCodigo = KsvmEstMaestra :: __KsvmFiltrarCadena($KsvmCodigo);
        $KsvmBuscar = KsvmEstMaestra :: __KsvmFiltrarCadena($KsvmBuscar);
        $KsvmUsuario = $_SESSION['KsvmUsuId-SIGIM'];
        $KsvmTabla = "";
        
        $KsvmPagina = (isset($KsvmPagina) && $KsvmPagina > 0 ) ? (int)$KsvmPagina : 1;
        $KsvmDesde = ($KsvmPagina > 0) ? (($KsvmPagina*$KsvmNRegistros) - $KsvmNRegistros) : 0;

        if ($KsvmRolNom == "Administrador" || $KsvmRolNom == "Supervisor"  || $KsvmRolNom == "Tecnico" ) {
            if (isset($KsvmBuscar) && $KsvmBuscar != "") {
                $KsvmDataExt = "SELECT SQL_CALC_FOUND_ROWS * FROM ksvmvistaexistencias WHERE ((ExtEstEx != 'I') AND (MdcCodMed LIKE '%$KsvmBuscar%' 
                              OR BdgDescBod LIKE '%$KsvmBuscar%' OR ExtLoteEx LIKE '%$KsvmBuscar%' OR ExtBinLocEx LIKE '%$KsvmBuscar%' OR ExtFchCadEx 
                              LIKE '%$KsvmBuscar%')) AND UsrId = $KsvmUsuario AND BdgId = 5 LIMIT $KsvmDesde, $KsvmNRegistros";
            } else {
                $KsvmDataExt = "SELECT SQL_CALC_FOUND_ROWS * FROM ksvmvistaexistencias WHERE ExtEstEx != 'I' AND UsrId = '$KsvmUsuario' AND BdgId = 5 LIMIT $KsvmDesde, $KsvmNRegistros" ;
            }
        } else {
            if (isset($KsvmBuscar) && $KsvmBuscar != "") {
                $KsvmDataExt = "SELECT SQL_CALC_FOUND_ROWS * FROM ksvmvistaexistencias WHERE ((ExtEstEx != 'I') AND (MdcCodMed LIKE '%$KsvmBuscar%' 
                              OR BdgDescBod LIKE '%$KsvmBuscar%' OR ExtLoteEx LIKE '%$KsvmBuscar%' OR ExtBinLocEx LIKE '%$KsvmBuscar%' OR ExtFchCadEx 
                              LIKE '%$KsvmBuscar%' OR MdcDescMed LIKE '%$KsvmBuscar%')) AND UsrId = $KsvmUsuario LIMIT $KsvmDesde, $KsvmNRegistros";
            } else {
                $KsvmDataExt = "SELECT SQL_CALC_FOUND_ROWS * FROM ksvmvistaexistencias WHERE ExtEstEx != 'I' AND UsrId = '$KsvmUsuario' LIMIT $KsvmDesde, $KsvmNRegistros" ;
            }
        }
        
        $KsvmConsulta = KsvmEstMaestra :: __KsvmConexion();
    
        $KsvmQuery = $KsvmConsulta->query($KsvmDataExt);
        $KsvmQuery = $KsvmQuery->fetchAll();
        
        $KsvmDataTot = "SELECT FOUND_ROWS()";
        $KsvmTotalReg = $KsvmConsulta->query($KsvmDataTot);
        $KsvmTotalReg = (int) $KsvmTotalReg->fetchColumn();
        $KsvmNPaginas = ceil($KsvmTotalReg/$KsvmNRegistros);

        $KsvmTabla .= '<table class="mdl-data-table mdl-js-data-table mdl-shadow--6dp full-width table-responsive">
                        <thead>
                            <tr>
                                <th class="mdl-data-table__cell--non-numeric">#</th>
                                <th class="mdl-data-table__cell--non-numeric">Bodega</th>
                                <th class="mdl-data-table__cell--non-numeric">Imagen</th>
                                <th class="mdl-data-table__cell--non-numeric">Nombre</th>
                                <th class="mdl-data-table__cell--non-numeric">Lote</th>
                                <th class="mdl-data-table__cell--non-numeric hide-on-tablet">Fch.Cad</th>
                                <th class="mdl-data-table__cell--non-numeric">Stock</th>
                                <th class="mdl-data-table__cell--non-numeric hide-on-tablet">Cod.Barras</th>
                                <th class="mdl-data-table__cell--non-numeric hide-on-tablet">Nivel</th>
                                <th style="text-align:center; witdh:30px;">Acción</th>
                            </tr>
                        </thead>
                        <tbody>';

        if ($KsvmTotalReg >= 1 && $KsvmPagina <= $KsvmNPaginas) {
            $KsvmContReg = $KsvmDesde +1;
            foreach ($KsvmQuery as $rows) {
                barcode('Reportes/Codigos/'.$rows['ExtCodBarEx'].'.png', $rows['ExtCodBarEx'], 20, 'horizontal', 'codabar', false,1);

                $KsvmTabla .= '<tr>
                                <td class="mdl-data-table__cell--non-numeric">'.$KsvmContReg.'</td>
                                <td class="mdl-data-table__cell--non-numeric">'.$rows['BdgDescBod'].'</td>
                                <td class="mdl-data-table__cell--non-numeric"><img height="35px" width="45px" src="data:image/jpg;base64,'. base64_encode($rows['MdcFotoMed']).'"/></td>
                                <td class="mdl-data-table__cell--non-numeric">'.$rows['MdcDescMed'].' '.$rows['MdcConcenMed'].'</td>
                                <td class="mdl-data-table__cell--non-numeric">'.$rows['ExtLoteEx'].'</td>
                                <td class="mdl-data-table__cell--non-numeric hide-on-tablet">'.$rows['ExtFchCadEx'].'</td>
                                <td class="mdl-data-table__cell--non-numeric">'.$rows['ExbStockEbo'].'</td>
                                <td class="mdl-data-table__cell--non-numeric hide-on-tablet"><img src="'.KsvmServUrl.'Reportes/Codigos/'.$rows['ExtCodBarEx'].'.png"/></td>
                                <td class="mdl-data-table__cell--non-numeric hide-on-tablet"><button class="btn btn-md" style="border-color:#000; background-color:'.$rows['AltColorAle'].';"></button></td>
                                <td style="text-align:right; witdh:30px;">';
                                if ($KsvmRol == 1) {
                                    if ($KsvmCodigo == 0) {

                                    $KsvmTabla .=  '<form action="'.KsvmServUrl.'Ajax/KsvmExistenciasAjax.php" method="POST" class="FormularioAjax" data-form="eliminar" enctype="multipart/form-data"> 
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
                                    $KsvmTabla .= '<form action="'.KsvmServUrl.'Ajax/KsvmExistenciasAjax.php" method="POST" class="FormularioAjax" data-form="eliminar" enctype="multipart/form-data"> 
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
                echo '<script> window.location.href=" '.KsvmServUrl.'KsvmExistenciasCrud/1/"</script>';
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

            } elseif ($KsvmTotalReg >= 1 && $KsvmPagina <= $KsvmNPaginas && $KsvmCodigo == 1) {
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
      public function __KsvmEditarDetalleExistenciaControlador($KsvmCodExistencia)
      {
          $KsvmUsuario = $_SESSION['KsvmUsuId-SIGIM'];
          $KsvmRol = $_SESSION['KsvmRolId-SIGIM'];
          $KsvmCodigo = KsvmEstMaestra :: __KsvmDesencriptacion($KsvmCodExistencia);

          return KsvmExistenciaModelo :: __KsvmEditarDetalleExistenciaModelo($KsvmCodigo, $KsvmUsuario, $KsvmRol);
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
       * Función que permite mostrar una alerta 
       */
      public function __KsvmMostrarExistenciaControlador()
      {
            $KsvmUsuario = $_SESSION['KsvmUsuId-SIGIM'];
            return KsvmExistenciaModelo :: __KsvmMostrarExistenciaModelo($KsvmUsuario);
      }

      /**
       * Función que permite imprimir una Existencia 
       */
      public function __KsvmImprimirExistenciaControlador()
      {
        return KsvmExistenciaModelo :: __KsvmImprimirExistenciaModelo();
      }

      /**
       * Función que permite actualizar una Existencia 
       */
      public function __KsvmActualizarExistenciaControlador()
      {
        $KsvmCodExistencia = KsvmEstMaestra :: __KsvmDesencriptacion($_POST['KsvmCodEdit']);
        $KsvmDocId = KsvmEstMaestra :: __KsvmFiltrarCadena($_POST['KsvmDocId']);
        $KsvmLoteEx = KsvmEstMaestra :: __KsvmFiltrarCadena($_POST['KsvmLoteEx']);
        $KsvmFchCadEx = KsvmEstMaestra :: __KsvmFiltrarCadena($_POST['KsvmFchCadEx']);
        $KsvmStockIniEx = KsvmEstMaestra :: __KsvmFiltrarCadena($_POST['KsvmStockIniEx']);
        $KsvmStockSegEx = KsvmEstMaestra :: __KsvmFiltrarCadena($_POST['KsvmStockSegEx']);
        $KsvmCodBarEx = KsvmEstMaestra :: __KsvmFiltrarCadena($_POST['KsvmCodBarEx']);
        $KsvmBinLocEx = KsvmEstMaestra :: __KsvmFiltrarCadena($_POST['KsvmBinLocEx']);

        $KsvmConsulta = "SELECT * FROM ksvmvistaexistencias WHERE ExtId = '$KsvmCodExistencia'";
        $KsvmQuery = KsvmEstMaestra :: __KsvmEjecutaConsulta($KsvmConsulta);
        $KsvmDataExistencia = $KsvmQuery->fetch();

        if ($KsvmLoteEx != $KsvmDataExistencia['ExtLoteEx']) {
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
        }
        if ($KsvmCodBarEx != $KsvmDataExistencia['ExtCodBarEx']) {
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
                "KsvmLoteEx" => $KsvmLoteEx,
                "KsvmFchCadEx" => $KsvmFchCadEx,
                "KsvmStockIniEx" => $KsvmStockIniEx,
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
            $KsvmListar = '<option value="">Seleccione Existencia</option>';

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
            $KsvmSelectStock = "SELECT * FROM ksvmvistaexistencias WHERE ExtId = '$KsvmStock'";

                $KsvmConsulta = KsvmEstMaestra :: __KsvmConexion();
                $KsvmQuery = $KsvmConsulta->query($KsvmSelectStock);
                $KsvmQuery = $KsvmQuery->fetch();
                $KsvmListar = '<label class="mdl-textfield__input">'.$KsvmQuery['ExbStockEbo'].'</label>
                                <input class="mdl-textfield__input" type="text" name="KsvmStockInv"
                               value="'.$KsvmQuery['ExbStockEbo'].'" id="KsvmDato2" hidden>';

                 return $KsvmListar;

            

        }

}
   
 