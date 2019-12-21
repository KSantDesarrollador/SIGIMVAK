<?php

  /**
   *Condicion para peticion Ajax
   */
   if ($KsvmPeticionAjax) {
       require_once "../Modelos/KsvmParametrosModelo.php";
   } else {
       require_once "./Modelos/KsvmParametrosModelo.php";
   }

   class KsvmParametrosControlador extends KsvmParametrosModelo
   {
     /**
      *Función que permite ingresar una Parametros
      */
     public function __KsvmAgregarParametrosControlador()
     {
         $KsvmExtId = KsvmEstMaestra :: __KsvmFiltrarCadena($_POST['KsvmExtId']);
         $KsvmAltId = KsvmEstMaestra :: __KsvmFiltrarCadena($_POST['KsvmAltId']);
         $KsvmMinPar = KsvmEstMaestra :: __KsvmFiltrarCadena($_POST['KsvmMinPar']);
         $KsvmMaxPar = KsvmEstMaestra :: __KsvmFiltrarCadena($_POST['KsvmMaxPar']);

              $KsvmNuevoParametro = [
                "KsvmExtId" => $KsvmExtId,
                "KsvmAltId" => $KsvmAltId,
                "KsvmMinPar" => $KsvmMinPar,
                "KsvmMaxPar" => $KsvmMaxPar
                ];

                $KsvmGuardarPar = KsvmParametrosModelo :: __KsvmAgregarParametrosModelo($KsvmNuevoParametro);
                if ($KsvmGuardarPar->rowCount() >= 1) {
                    $KsvmAlerta = [
                    "Parametros" => "Limpia",
                    "Titulo" => "Grandioso",
                    "Cuerpo" => "El Parametro se registró satisfactoriamente",
                    "Tipo" => "success"
                    ];
                } else {
                    $KsvmAlerta = [
                    "Parametros" => "simple",
                    "Titulo" => "Error inesperado",
                    "Cuerpo" => "No se a podido registrar el Parametro",
                    "Tipo" => "info"
                    ];
                }
                
            return KsvmEstMaestra :: __KsvmMostrarParametross($KsvmAlerta);
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
            $KsvmDataAle = "SELECT SQL_CALC_FOUND_ROWS * FROM ksvmvistaparametros WHERE (MdcDescMen LIKE '%$KsvmBuscar%' 
                          OR ExtLoteEx LIKE '%$KsvmBuscar%') OR AltNomAle LIKE '%$KsvmBuscar%') ORDER BY ExtId LIMIT $KsvmDesde, $KsvmNRegistros";
        } else {
            $KsvmDataAle = "SELECT SQL_CALC_FOUND_ROWS * FROM ksvmvistaparametros ORDER BY ExtId LIMIT $KsvmDesde, $KsvmNRegistros" ;
        }
        

        $KsvmConsulta = KsvmEstMaestra :: __KsvmConexion();
    
        $KsvmQuery = $KsvmConsulta->query($KsvmDataAle);
        $KsvmQuery = $KsvmQuery->fetchAll();
        
        $KsvmDataTot = "SELECT FOUND_ROWS()";
        $KsvmTotalReg = $KsvmConsulta->query($KsvmDataTot);
        $KsvmTotalReg = (int) $KsvmTotalReg->fetchColumn();
        $KsvmNPaginas = ceil($KsvmTotalReg/$KsvmNRegistros);

        $KsvmTabla .= '<table class="mdl-data-table mdl-js-data-table mdl-shadow--6dp full-width table-responsive">
                        <thead>
                            <tr>
                                <th class="mdl-data-table__cell--non-numeric">#</th>
                                <th class="mdl-data-table__cell--non-numeric">Existencia</th>
                                <th class="mdl-data-table__cell--non-numeric">Alerta</th>
                                <th class="mdl-data-table__cell--non-numeric">Valor Máximo</th>
                                <th class="mdl-data-table__cell--non-numeric">Valor Mínimo</th>
                                <th style="text-align:center; witdh:30px;">Acción</th>
                            </tr>
                        </thead>
                        <tbody>';

        if ($KsvmTotalReg >= 1 && $KsvmPagina <= $KsvmNPaginas) {
            $KsvmContReg = $KsvmDesde +1;
            foreach ($KsvmQuery as $rows) {
                $KsvmTabla .= '<tr>
                                <td class="mdl-data-table__cell--non-numeric">'.$KsvmContReg.'</td>
                                <td class="mdl-data-table__cell--non-numeric">'.$rows['MdcDescMed'].' '.$rows['MdcConcenMed'].' '.$rows['ExtLoteEx'].'</td>
                                <td class="mdl-data-table__cell--non-numeric">'.$rows['AltNomAle'].'</td>
                                <td class="mdl-data-table__cell--non-numeric">'.$rows['PmtMinPar'].'</td>
                                <td class="mdl-data-table__cell--non-numeric">'.$rows['PmtMaxPar'].'</td>
                                <td style="text-align:right; witdh:30px;">';
                                if ($KsvmRol == 1) {
                                    if ($KsvmCodigo == 0) {

                                    $KsvmTabla .=  '<form action="'.KsvmServUrl.'Ajax/KsvmParametrosAjax.php" method="POST" class="FormularioAjax" data-form="eliminar" enctype="multipart/form-data"> 
                                                    <a id="btn-detail" class="btn btn-sm btn-info" href="'.KsvmServUrl.'KsvmParametrosCrud/Detail/'.KsvmEstMaestra::__KsvmEncriptacion($rows['PmtId']).'/"><i class="zmdi zmdi-card"></i></a>
                                                    <div class="mdl-tooltip" for="btn-detail">Detalles</div>
                                                    <a id="btn-edit" class="btn btn-sm btn-primary" href="'.KsvmServUrl.'KsvmParametrosEditar/'.KsvmEstMaestra::__KsvmEncriptacion($rows['PmtId']).'/0/"><i class="zmdi zmdi-edit"></i></a>
                                                    <div class="mdl-tooltip" for="btn-edit">Editar</div>
                                                    <input type="hidden" name="KsvmCodDelete" value="'.KsvmEstMaestra::__KsvmEncriptacion($rows['PmtId']).'">              
                                                    <button id="btn-delete" type="submit" class="btn btn-sm btn-danger"><i class="zmdi zmdi-delete"></i></button>
                                                    <div class="RespuestaAjax"></div>
                                                    </form>';
                                    } else {
                                    $KsvmTabla .= '<form action="'.KsvmServUrl.'Ajax/KsvmParametrosAjax.php" method="POST" class="FormularioAjax" data-form="eliminar" enctype="multipart/form-data"> 
                                                    <a id="btn-detail" class="btn btn-sm btn-info" href="'.KsvmServUrl.'KsvmParametros/Detail/'.KsvmEstMaestra::__KsvmEncriptacion($rows['PmtId']).'"><i class="zmdi zmdi-card"></i></a>
                                                    <div class="mdl-tooltip" for="btn-detail">Detalles</div>
                                                    <a id="btn-edit" class="btn btn-sm btn-primary" href="'.KsvmServUrl.'KsvmParametrosEditar/'.KsvmEstMaestra::__KsvmEncriptacion($rows['PmtId']).'/1/"><i class="zmdi zmdi-edit"></i></a>
                                                    <div class="mdl-tooltip" for="btn-edit">Editar</div>
                                                    <input type="hidden" name="KsvmCodDelete" value="'.KsvmEstMaestra::__KsvmEncriptacion($rows['PmtId']).'">              
                                                    <button id="btn-delete" type="submit" class="btn btn-sm btn-danger"><i class="zmdi zmdi-delete"></i></button>
                                                    <div class="mdl-tooltip" for="btn-delete">Inhabilitar</div>
                                                    <div class="RespuestaAjax"></div>
                                                    </form>'; 
                                    }
                                }elseif ($KsvmRol == 2 || $KsvmRol == 3){
                                    $KsvmTabla .= '<a id="btn-detail" class="btn btn-sm btn-info" href="'.KsvmServUrl.'KsvmParametros/Detail/'.KsvmEstMaestra::__KsvmEncriptacion($rows['PmtId']).'/"><i class="zmdi zmdi-card"></i></a>
                                                    <div class="mdl-tooltip" for="btn-detail">Detalles</div>
                                                    <a id="btn-edit" class="btn btn-sm btn-primary" href="'.KsvmServUrl.'KsvmParametrosEditar/'.KsvmEstMaestra::__KsvmEncriptacion($rows['PmtId']).'/1/"><i class="zmdi zmdi-edit"></i></a>
                                                    <div class="mdl-tooltip" for="btn-edit">Editar</div>';
                                }else{
                                    $KsvmTabla .= '<a id="btn-detail" class="btn btn-sm btn-info" href="'.KsvmServUrl.'KsvmParametros/Detail/'.KsvmEstMaestra::__KsvmEncriptacion($rows['PmtId']).'/"><i class="zmdi zmdi-card"></i></a>
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
            if ($KsvmTotalReg >= 1 && $KsvmCodigo == 0) {
                echo '<script> window.location.href=" '.KsvmServUrl.'KsvmParametrosCrud/1/"</script>';
            }elseif ($KsvmTotalReg >= 1 && $KsvmCodigo == 1){
                echo '<script> window.location.href=" '.KsvmServUrl.'KsvmParametros/1/"</script>';
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
                    $KsvmTabla .= '<a class = "btn btn-xs btn-success mdl-shadow--8dp " href="'.KsvmServUrl.'KsvmParametrosCrud/1/">Primero</a>
                                   <span></span>
                                   <a class = "btn btn-xs btn-default mdl-shadow--8dp " href="'.KsvmServUrl.'KsvmParametrosCrud/'.($KsvmPagina-1).'/"><i class="zmdi zmdi-fast-rewind"></i></a>';
                }

                if ($KsvmPagina == $KsvmNPaginas) {
                    $KsvmTabla .= '<button class = "btn btn-xs btn-default mdl-shadow--8dp disabled"><i class="zmdi zmdi-fast-forward"></i></button>
                                   <span></span>
                                   <button class = "btn btn-xs btn-success mdl-shadow--8dp disabled">Último</button>';
                } else {
                    $KsvmTabla .= '<a class="btn btn-xs btn-default mdl-shadow--8dp" href="'.KsvmServUrl.'KsvmParametrosCrud/'.($KsvmPagina+1).'/"><i class="zmdi zmdi-fast-forward"></i></a>
                                   <span></span>
                                   <a class="btn btn-xs btn-success mdl-shadow--8dp" href="'.KsvmServUrl.'KsvmParametrosCrud/'.($KsvmNPaginas).'/">Último</a>';
                                               
                }
                
             
                $KsvmTabla .= '</nav></div>';   

            } elseif($KsvmTotalReg >= 1 && $KsvmPagina <= $KsvmNPaginas && $KsvmCodigo == 1) {
                $KsvmTabla .= '<nav class="navbar-form navbar-right form-group">';
                
                if ($KsvmPagina == 1) {
                    $KsvmTabla .= '<button class = "btn btn-xs btn-success mdl-shadow--8dp disabled">Primero</button>
                                   <span></span>
                                   <button class = "btn btn-xs btn-default mdl-shadow--8dp disabled"><i class="zmdi zmdi-fast-rewind"></i></button>';
                } else {
                    $KsvmTabla .= '<a class = "btn btn-xs btn-success mdl-shadow--8dp " href="'.KsvmServUrl.'KsvmParametros/1/">Primero</a>
                                   <span></span>
                                   <a class = "btn btn-xs btn-default mdl-shadow--8dp " href="'.KsvmServUrl.'KsvmParametros/'.($KsvmPagina-1).'/"><i class="zmdi zmdi-fast-rewind"></i></a>';
                }

                if ($KsvmPagina == $KsvmNPaginas) {
                    $KsvmTabla .= '<button class = "btn btn-xs btn-default mdl-shadow--8dp disabled"><i class="zmdi zmdi-fast-forward"></i></button>
                                   <span></span>
                                   <button class = "btn btn-xs btn-success mdl-shadow--8dp disabled">Último</button>';
                } else {
                    $KsvmTabla .= '<a class="btn btn-xs btn-default mdl-shadow--8dp" href="'.KsvmServUrl.'KsvmParametros/'.($KsvmPagina+1).'/"><i class="zmdi zmdi-fast-forward"></i></a>
                                   <span></span>
                                   <a class="btn btn-xs btn-success mdl-shadow--8dp" href="'.KsvmServUrl.'KsvmParametros/'.($KsvmNPaginas).'/">Último</a>';
                                   
                                   
                }
                
                $KsvmTabla .= '</nav></div>'; 
            }
            
        
                                   
        return $KsvmTabla;
      }
     
      /**
       * Función que permite inhabilitar una Parametros
       */
      public function __KsvmEliminarParametrosControlador()
      {
         $KsvmCode = KsvmEstMaestra :: __KsvmDesencriptacion($_POST['KsvmCodDelete']);
         $KsvmCodePar = KsvmEstMaestra :: __KsvmFiltrarCadena($KsvmCode);

         $KsvmDelPar = KsvmParametrosModelo :: __KsvmEliminarParametrosModelo($KsvmCodePar);
         if ($KsvmDelPar->rowCount() == 1) {
            $KsvmAlerta = [
                "Alerta" => "Actualiza",
                "Titulo" => "Parametros Inhabilitada",
                "Cuerpo" => "El Parametro seleccionado ha sido inhabilitado con éxito",
                "Tipo" => "success"
                ];
         } else {
            $KsvmAlerta = [
                "Alerta" => "simple",
                "Titulo" => "Error inesperado",
                "Cuerpo" => "No es posible eliminar el Parametro seleccionada",
                "Tipo" => "info"
                ];
         }

         return KsvmEstMaestra :: __KsvmMostrarParametross($KsvmAlerta);
      }
    
      /**
       * Función que permite editar una Parametros 
       */
      public function __KsvmEditarParametrosControlador($KsvmCodEditar)
      {
          $KsvmCodPar = KsvmEstMaestra :: __KsvmDesencriptacion($KsvmCodEditar);

          return KsvmParametrosModelo :: __KsvmEditarParametrosModelo($KsvmCodPar);
      }
      
      /**
       * Función que permite contar una Parametros 
       */
      public function __KsvmContarParametrosControlador()
      {
          return KsvmParametrosModelo :: __KsvmContarParametrosModelo(0);
      }

      /**
       * Función que permite imprimir un Parametro 
       */
      public function __KsvmImprimirParametrosControlador()
      {
        return KsvmParametrosModelo :: __KsvmImprimirParametrosModelo();
      }

      /**
       * Función que permite actualizar una Parametros 
       */
      public function __KsvmActualizarParametrosControlador()
      {
        $KsvmCodPar = KsvmEstMaestra :: __KsvmDesencriptacion($_POST['KsvmCodEdit']);
        $KsvmExtId = KsvmEstMaestra :: __KsvmFiltrarCadena($_POST['KsvmExtId']);
        $KsvmAltId = KsvmEstMaestra :: __KsvmFiltrarCadena($_POST['KsvmAltId']);
        $KsvmMinPar = KsvmEstMaestra :: __KsvmFiltrarCadena($_POST['KsvmMinPar']);
        $KsvmMaxPar = KsvmEstMaestra :: __KsvmFiltrarCadena($_POST['KsvmMaxPar']);

        $KsvmConsulta = "SELECT * FROM ksvmvistaparametros WHERE PmtId = '$KsvmCodPar'";
        $KsvmQuery = KsvmEstMaestra :: __KsvmEjecutaConsulta($KsvmConsulta);
        $KsvmDataParametros = $KsvmQuery->fetch();

        $KsvmActualPar = [
            "KsvmExtId" => $KsvmExtId,
            "KsvmAltId" => $KsvmAltId,
            "KsvmMinPar" => $KsvmMinPar,
            "KsvmMaxPar" => $KsvmMaxPar,
            "KsvmCodParametros" => $KsvmCodPar
            ];

            $KsvmGuardarPar = KsvmParametrosModelo :: __KsvmActualizarParametrosModelo($KsvmActualPar);
                if ($KsvmGuardarPar->rowCount() >= 1) {
                    $KsvmAlerta = [
                    "Alerta" => "Actualiza",
                    "Titulo" => "Grandioso",
                    "Cuerpo" => "El Parametro se actualizó satisfactoriamente",
                    "Tipo" => "success"
                    ];
                } else {
                    $KsvmAlerta = [
                    "Alerta" => "simple",
                    "Titulo" => "Error inesperado",
                    "Cuerpo" => "No se a podido actualizar la información del Parametro",
                    "Tipo" => "info"
                    ];
                }
                return KsvmEstMaestra :: __KsvmMostrarParametross($KsvmAlerta);
         
        }
    
}
   
 