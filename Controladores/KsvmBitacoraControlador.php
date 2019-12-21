<?php

  /**
   *Condicion para peticion Ajax
   */
   if ($KsvmPeticionAjax) {
       require_once "../Raiz/KsvmEstMaestra.php";
   } else {
       require_once "./Raiz/KsvmEstMaestra.php";
   }

   class KsvmBitacoraControlador extends KsvmEstMaestra
   { 
    /**
     * Función que permite paginar 
     */
      public function __KsvmPaginador($KsvmPagina, $KsvmNRegistros, $KsvmBuscarIni, $KsvmBuscarFin, $KsvmFiltro, $KsvmCriterio)
      {
        $KsvmPagina = KsvmEstMaestra :: __KsvmFiltrarCadena($KsvmPagina);
        $KsvmNRegistros = KsvmEstMaestra :: __KsvmFiltrarCadena($KsvmNRegistros);
        $KsvmBuscarIni = KsvmEstMaestra :: __KsvmFiltrarCadena($KsvmBuscarIni);
        $KsvmBuscarFin = KsvmEstMaestra :: __KsvmFiltrarCadena($KsvmBuscarFin);
        $KsvmCriterio = KsvmEstMaestra :: __KsvmFiltrarCadena($KsvmCriterio);
        $KsvmTabla = "";
        
        $KsvmPagina = (isset($KsvmPagina) && $KsvmPagina > 0 ) ? (int)$KsvmPagina : 1;
        $KsvmDesde = ($KsvmPagina > 0) ? (($KsvmPagina*$KsvmNRegistros) - $KsvmNRegistros) : 0;

        if (isset($KsvmBuscarIni) && isset($KsvmBuscarFin) && $KsvmBuscarFin != "" && isset($KsvmFiltro)) {
            switch ($KsvmFiltro) {
                case 'R':
                    $KsvmDataBit = "SELECT SQL_CALC_FOUND_ROWS * FROM ksvmvistabitacora WHERE BtcFchBit BETWEEN '$KsvmBuscarIni' AND '$KsvmBuscarFin'
                    AND BtcTipoBit LIKE '%$KsvmCriterio%' LIMIT $KsvmDesde, $KsvmNRegistros";
                    break;
                case 'U':
                    $KsvmDataBit = "SELECT SQL_CALC_FOUND_ROWS * FROM ksvmvistabitacora WHERE BtcFchBit BETWEEN '$KsvmBuscarIni' AND '$KsvmBuscarFin'
                    AND UsrNomUsu LIKE '%$KsvmCriterio%' LIMIT $KsvmDesde, $KsvmNRegistros";
                    break;
                default:
                    break;
            }
        } else {
            $KsvmDataBit = "SELECT SQL_CALC_FOUND_ROWS * FROM ksvmvistabitacora LIMIT $KsvmDesde, $KsvmNRegistros" ;
            
        }
        

        $KsvmConsulta = KsvmEstMaestra :: __KsvmConexion();
    
        $KsvmQuery = $KsvmConsulta->query($KsvmDataBit);
        $KsvmQuery = $KsvmQuery->fetchAll();
        
        $KsvmDataTot = "SELECT FOUND_ROWS()";
        $KsvmTotalReg = $KsvmConsulta->query($KsvmDataTot);
        $KsvmTotalReg = (int) $KsvmTotalReg->fetchColumn();
        $KsvmNPaginas = ceil($KsvmTotalReg/$KsvmNRegistros);

        $KsvmTabla .= '<table class="mdl-data-table mdl-js-data-table mdl-shadow--6dp full-width table-responsive">
                        <thead>
                            <tr>
                                <th class="mdl-data-table__cell--non-numeric hide-on-tablet">#</th>
                                <th class="mdl-data-table__cell--non-numeric hide-on-tablet">Código</th>
                                <th class="mdl-data-table__cell--non-numeric">Rol</th>
                                <th class="mdl-data-table__cell--non-numeric">Usuario</th>
                                <th class="mdl-data-table__cell--non-numeric">Fecha</th>
                                <th class="mdl-data-table__cell--non-numeric">H.Inicio</th>
                                <th class="mdl-data-table__cell--non-numeric">H.Fin</th>
                                <th class="mdl-data-table__cell--non-numeric hide-on-tablet">Año</th>
                                <th style="text-align:center; witdh:30px;">Acción</th>
                            </tr>
                        </thead>
                        <tbody>';

        if ($KsvmTotalReg >= 1 && $KsvmPagina <= $KsvmNPaginas) {
            $KsvmContReg = $KsvmDesde +1;
            foreach ($KsvmQuery as $rows) {
                $KsvmTabla .= '<tr>
                                <td class="mdl-data-table__cell--non-numeric hide-on-tablet">'.$KsvmContReg.'</td>
                                <td class="mdl-data-table__cell--non-numeric hide-on-tablet">'.$rows['BtcCodBit'].'</td>
                                <td class="mdl-data-table__cell--non-numeric">'.$rows['BtcTipoBit'].'</td>
                                <td class="mdl-data-table__cell--non-numeric">'.$rows['UsrNomUsu'].'</td>
                                <td class="mdl-data-table__cell--non-numeric">'.$rows['BtcFchBit'].'</td>
                                <td class="mdl-data-table__cell--non-numeric">'.$rows['BtcHoraInBit'].'</td>
                                <td class="mdl-data-table__cell--non-numeric">'.$rows['BtcHoraFinBit'].'</td>
                                <td class="mdl-data-table__cell--non-numeric hide-on-tablet">'.$rows['BtcAnioBit'].'</td>
                                <td style="text-align:right; witdh:30px;">';

                $KsvmTabla .=  '<form action="'.KsvmServUrl.'Ajax/KsvmBitacoraAjax.php" method="POST" class="FormularioAjax" data-form="eliminar" enctype="multipart/form-data"> 
                                <a id="btn-print" class="btn btn-sm btn-success" href="'.KsvmServUrl.'Reportes/KsvmBitacoraPdf.php?Cod='.KsvmEstMaestra::__KsvmEncriptacion($rows['BtcId']).'" target="_blank"><i class="zmdi zmdi-print"></i></a>
                                <div class="mdl-tooltip" for="btn-print">Imprimir</div>
                                <input type="hidden" name="KsvmCodDelete" value="'.KsvmEstMaestra::__KsvmEncriptacion($rows['BtcId']).'">              
                                <button id="btn-delete" type="submit" class="btn btn-sm btn-danger"><i class="zmdi zmdi-delete"></i></button>
                                <div class="mdl-tooltip" for="btn-delete">Eliminar</div>
                                <div class="RespuestaAjax"></div>
                                </form>';

                                    

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
                echo '<script> window.location.href=" '.KsvmServUrl.'KsvmBitacora"</script>';
            } else {
                $KsvmTabla .= '<tr> 
                            <td class="mdl-data-table__cell--non-numeric" colspan="7"><strong>No se encontraron registros...</strong></td>
                           </tr>
                          </tbody>
                          </table>';

            }
        }
            if ($KsvmTotalReg >= 1 && $KsvmPagina <= $KsvmNPaginas) {

                $KsvmTabla .= '<nav class="navbar-form navbar-right form-group">';
                
                if ($KsvmPagina == 1) {
                    $KsvmTabla .= '<button class = "btn btn-xs btn-success mdl-shadow--8dp disabled">Primero</button>
                                   <span></span>
                                   <button class = "btn btn-xs btn-default mdl-shadow--8dp disabled"><i class="zmdi zmdi-fast-rewind"></i></button>';
                } else {
                    $KsvmTabla .= '<a class = "btn btn-xs btn-success mdl-shadow--8dp " href="'.KsvmServUrl.'KsvmBitacora/1/">Primero</a>
                                   <span></span>
                                   <a class = "btn btn-xs btn-default mdl-shadow--8dp " href="'.KsvmServUrl.'KsvmBitacora/'.($KsvmPagina-1).'/"><i class="zmdi zmdi-fast-rewind"></i></a>';
                }

                if ($KsvmPagina == $KsvmNPaginas) {
                    $KsvmTabla .= '<button class = "btn btn-xs btn-default mdl-shadow--8dp disabled"><i class="zmdi zmdi-fast-forward"></i></button>
                                   <span></span>
                                   <button class = "btn btn-xs btn-success mdl-shadow--8dp disabled">Último</button>';
                } else {
                    $KsvmTabla .= '<a class="btn btn-xs btn-default mdl-shadow--8dp" href="'.KsvmServUrl.'KsvmBitacora/'.($KsvmPagina+1).'/"><i class="zmdi zmdi-fast-forward"></i></a>
                                   <span></span>
                                   <a class="btn btn-xs btn-success mdl-shadow--8dp" href="'.KsvmServUrl.'KsvmBitacora/'.($KsvmNPaginas).'/">Último</a>';
                                               
                }
                
                
                $KsvmTabla .= '</nav></div>'; 
            }
            
        
                                   
        return $KsvmTabla;
      }

      /**
       * Función que permite eliminar una Bitacora
       */
      public function __KsvmEliminarBitacoraControlador()
      {
         $KsvmCode = KsvmEstMaestra :: __KsvmDesencriptacion($_POST['KsvmCodDelete']);
         $KsvmCodBit = KsvmEstMaestra :: __KsvmFiltrarCadena($KsvmCode);

             $KsvmDelBit = KsvmEstMaestra :: __KsvmEliminaBitacoraModelo($KsvmCodBit);
             if ($KsvmDelBit->rowCount() == 1) {
                $KsvmAlerta = [
                    "Alerta" => "Actualiza",
                    "Titulo" => "Bitacora Inhabilitada",
                    "Cuerpo" => "La sesión seleccionado ha sido eliminada con éxito",
                    "Tipo" => "success"
                    ];
             
                } else {
                    $KsvmAlerta = [
                        "Alerta" => "simple",
                        "Titulo" => "Error inesperado",
                        "Cuerpo" => "No es posible eliminar la sesión del sistema",
                        "Tipo" => "info"
                        ];
                }

         return KsvmEstMaestra :: __KsvmMostrarAlertas($KsvmAlerta);
      }

      /**
       * Función que permite imprimir una sesión 
       */
      public function __KsvmImprimirBitacoraControlador()
      {
        return KsvmEstMaestra :: __KsvmImprimirBitacoraModelo();
      }

      /**
       * Función que permite imprimir un detalle de sesión 
       */
      public function __KsvmImprimirDetalleBitacoraControlador($KsvmCodBitacora)
      {
        $KsvmCodigo = KsvmEstMaestra :: __KsvmDesencriptacion($KsvmCodBitacora);
        return KsvmEstMaestra :: __KsvmImprimirDetalleBitacoraModelo($KsvmCodigo);
      }
    
     
    }
   
 