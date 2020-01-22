<?php

  /**
   *Condicion para peticion Ajax
   */
   if ($KsvmPeticionAjax) {
       require_once "../Modelos/KsvmAuditoriaModelo.php";
   } else {
       require_once "./Modelos/KsvmAuditoriaModelo.php";
   }

   class KsvmAuditoriaControlador extends KsvmAuditoriaModelo
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
                case 'T':
                    $KsvmDataAudi = "SELECT SQL_CALC_FOUND_ROWS * FROM ksvmauditoria19 WHERE (AdtFchCreaAud BETWEEN '$KsvmBuscarIni' AND '$KsvmBuscarFin'
                    OR AdtFchModAud BETWEEN '$KsvmBuscarIni' AND '$KsvmBuscarFin') AND (AdtNomTabAud LIKE '%$KsvmCriterio%') ORDER BY AdtFchModAud DESC 
                    LIMIT $KsvmDesde, $KsvmNRegistros";
                    break;
                case 'S':
                    $KsvmDataAudi = "SELECT SQL_CALC_FOUND_ROWS * FROM ksvmauditoria19 WHERE (AdtFchCreaAud BETWEEN '$KsvmBuscarIni' AND '$KsvmBuscarFin' 
                    OR AdtFchModAud BETWEEN '$KsvmBuscarIni' AND '$KsvmBuscarFin') AND (AdtSentenciaAud LIKE '%$KsvmCriterio%') ORDER BY AdtFchModAud DESC 
                    LIMIT $KsvmDesde, $KsvmNRegistros";
                    break;
                default:
                    break;
            }

        } else {
            $KsvmDataAudi = "SELECT SQL_CALC_FOUND_ROWS * FROM ksvmauditoria19 ORDER BY AdtFchModAud LIMIT $KsvmDesde, $KsvmNRegistros" ;
            
        }
        

        $KsvmConsulta = KsvmEstMaestra :: __KsvmConexion();
    
        $KsvmQuery = $KsvmConsulta->query($KsvmDataAudi);
        $KsvmQuery = $KsvmQuery->fetchAll();
        
        $KsvmDataTot = "SELECT FOUND_ROWS()";
        $KsvmTotalReg = $KsvmConsulta->query($KsvmDataTot);
        $KsvmTotalReg = (int) $KsvmTotalReg->fetchColumn();
        $KsvmNPaginas = ceil($KsvmTotalReg/$KsvmNRegistros);

        $KsvmTabla .= '<table class="mdl-data-table mdl-js-data-table mdl-shadow--6dp full-width table-responsive">
                        <thead>
                            <tr>
                                <th class="mdl-data-table__cell--non-numeric hide-on-tablet">#</th>
                                <th class="mdl-data-table__cell--non-numeric ">Tabla</th>
                                <th class="mdl-data-table__cell--non-numeric hide-on-tablet">Id.Registro</th>
                                <th class="mdl-data-table__cell--non-numeric">Campo</th>
                                <th class="mdl-data-table__cell--non-numeric">Val Anterior</th>
                                <th class="mdl-data-table__cell--non-numeric">Val Nuevo</th>
                                <th class="mdl-data-table__cell--non-numeric hide-on-tablet">Fecha.Crea</th>
                                <th class="mdl-data-table__cell--non-numeric hide-on-tablet">Fecha.Mod</th>
                                <th class="mdl-data-table__cell--non-numeric hide-on-tablet">Usuario</th>
                                <th class="mdl-data-table__cell--non-numeric ">Sentencia</th>
                                <th style="text-align:center; witdh:30px;">Acción</th>
                            </tr>
                        </thead>
                        <tbody>';

        if ($KsvmTotalReg >= 1 && $KsvmPagina <= $KsvmNPaginas) {
            $KsvmContReg = $KsvmDesde +1;
            foreach ($KsvmQuery as $rows) {
                if ($rows['AdtValorAntAud'] != NULL) {
                    $KsvmValAnt = $rows['AdtValorAntAud'];
                }else{
                    $KsvmValAnt = "Sin datos";
                }
                if ($rows['AdtValorNvoAud'] != NULL) {
                    $KsvmValNvo = $rows['AdtValorNvoAud'];
                }else{
                    $KsvmValNvo = "Sin datos";
                }
                if ($rows['AdtFchCreaAud'] != NULL) {
                    $KsvmFchCrea = $rows['AdtFchCreaAud'];
                }else{
                    $KsvmFchCrea = "Sin datos";
                }
                if ($rows['AdtFchModAud'] != NULL) {
                    $KsvmFchMod = $rows['AdtFchModAud'];
                }else{
                    $KsvmFchMod = "Sin datos";
                }
                $KsvmTabla .= '<tr>
                                <td class="mdl-data-table__cell--non-numeric hide-on-tablet">'.$KsvmContReg.'</td>
                                <td class="mdl-data-table__cell--non-numeric">'.$rows['AdtNomTabAud'].'</td>
                                <td class="mdl-data-table__cell--non-numeric hide-on-tablet">'.$rows['AdtIdRegAud'].'</td>
                                <td class="mdl-data-table__cell--non-numeric">'.$rows['AdtCampTabAud'].'</td>
                                <td class="mdl-data-table__cell--non-numeric">'.$KsvmValAnt.'</td>
                                <td class="mdl-data-table__cell--non-numeric">'.$KsvmValNvo.'</td>
                                <td class="mdl-data-table__cell--non-numeric hide-on-tablet">'.$KsvmFchCrea.'</td>
                                <td class="mdl-data-table__cell--non-numeric hide-on-tablet">'.$KsvmFchMod.'</td>
                                <td class="mdl-data-table__cell--non-numeric hide-on-tablet">'.$rows['AdtUsuModAud'].'</td>
                                <td class="mdl-data-table__cell--non-numeric ">'.$rows['AdtSentenciaAud'].'</td>
                                <td style="text-align:right; witdh:30px;">';

                $KsvmTabla .=  '<a id="btn-print" class="btn btn-sm btn-success" href="'.KsvmServUrl.'Reportes/KsvmAuditoriaPdf.php?Cod=
                                '.KsvmEstMaestra::__KsvmEncriptacion($rows['AdtId']).'" target="_blank"><i class="zmdi zmdi-print"></i></a>
                                <div class="mdl-tooltip" for="btn-print">Imprimir</div>';
                                    

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
                echo '<script> window.location.href=" '.KsvmServUrl.'KsvmAuditoria/1/"</script>';
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
                    $KsvmTabla .= '<a class = "btn btn-xs btn-success mdl-shadow--8dp " href="'.KsvmServUrl.'KsvmAuditoria/1/">Primero</a>
                                   <span></span>
                                   <a class = "btn btn-xs btn-default mdl-shadow--8dp " href="'.KsvmServUrl.'KsvmAuditoria/'.($KsvmPagina-1).'/"><i class="zmdi zmdi-fast-rewind"></i></a>';
                }

                if ($KsvmPagina == $KsvmNPaginas) {
                    $KsvmTabla .= '<button class = "btn btn-xs btn-default mdl-shadow--8dp disabled"><i class="zmdi zmdi-fast-forward"></i></button>
                                   <span></span>
                                   <button class = "btn btn-xs btn-success mdl-shadow--8dp disabled">Último</button>';
                } else {
                    $KsvmTabla .= '<a class="btn btn-xs btn-default mdl-shadow--8dp" href="'.KsvmServUrl.'KsvmAuditoria/'.($KsvmPagina+1).'/"><i class="zmdi zmdi-fast-forward"></i></a>
                                   <span></span>
                                   <a class="btn btn-xs btn-success mdl-shadow--8dp" href="'.KsvmServUrl.'KsvmAuditoria/'.($KsvmNPaginas).'/">Último</a>';
                                               
                }
                
                
                $KsvmTabla .= '</nav></div>'; 
            }
            
        
                                   
        return $KsvmTabla;
      }

      /**
       * Función que permite imprimir una sesión 
       */
      public function __KsvmImprimirAuditoriaControlador()
      {
        return KsvmAuditoriaModelo :: __KsvmImprimirAuditoriaModelo();
      }

      /**
       * Función que permite imprimir un detalle de sesión 
       */
      public function __KsvmImprimirDetalleAuditoriaControlador($KsvmCodAuditoria)
      {
        $KsvmCodigo = KsvmEstMaestra :: __KsvmDesencriptacion($KsvmCodAuditoria);
        return KsvmAuditoriaModelo :: __KsvmImprimirDetalleAuditoriaModelo($KsvmCodigo);
      }

      /**
       * Función que permite contar una auditoría 
       */
      public function __KsvmContarAudiroriaControlador()
      {
          return KsvmAuditoriaModelo :: __KsvmContarAuditoriaModelo(0);
      }
    
     
    }
   
 