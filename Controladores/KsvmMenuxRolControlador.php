<?php

  /**
   *Condicion para peticion Ajax
   */
   if ($KsvmPeticionAjax) {
       require_once "../Modelos/KsvmMenuxRolModelo.php";
   } else {
       require_once "./Modelos/KsvmMenuxRolModelo.php";
   }

   class KsvmMenuxRolControlador extends KsvmMenuxRolModelo
   {
     /**
      *Función que permite ingresar un MenuxRol
      */
     public function __KsvmAgregarMenuxRolControlador()
     {
         $KsvmRrlId = KsvmEstMaestra :: __KsvmFiltrarCadena($_POST['KsvmRrlId']);
         $KsvmMnuId = KsvmEstMaestra :: __KsvmFiltrarCadena($_POST['KsvmMnuId']);

              $KsvmNuevoPrivilegio = [
                "KsvmRrlId" => $KsvmRrlId,
                "KsvmMnuId" => $KsvmMnuId
                ];

                $KsvmGuardarPrivilegio = KsvmMenuxRolModelo :: __KsvmAgregarMenuxRolModelo($KsvmNuevoPrivilegio);
                if ($KsvmGuardarPrivilegio->rowCount() >= 1) {
                    $KsvmAlerta = [
                    "Alerta" => "Actualiza",
                    "Titulo" => "Grandioso",
                    "Cuerpo" => "El Privilegio se registró satisfactoriamente",
                    "Tipo" => "success"
                    ];
                } else {
                    $KsvmAlerta = [
                    "Alerta" => "simple",
                    "Titulo" => "Error inesperado",
                    "Cuerpo" => "No se a podido registrar el Privilegio",
                    "Tipo" => "info"
                    ];
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
            $KsvmDataEmp = "SELECT SQL_CALC_FOUND_ROWS * FROM ksvmvistaasignaprivilegio WHERE ((RrlId != '$KsvmRol') AND (RrlNomRol LIKE '%$KsvmBuscar%' 
                          OR MnuNomMen LIKE '%$KsvmBuscar%')) 
                          LIMIT $KsvmDesde, $KsvmNRegistros";
        } else {
            $KsvmDataEmp = "SELECT SQL_CALC_FOUND_ROWS * FROM ksvmvistaasignaprivilegio WHERE RrlId != '$KsvmRol' LIMIT $KsvmDesde, $KsvmNRegistros" ;
        }
        

        $KsvmConsulta = KsvmEstMaestra :: __KsvmConexion();
    
        $KsvmQuery = $KsvmConsulta->query($KsvmDataEmp);
        $KsvmQuery = $KsvmQuery->fetchAll();
        
        $KsvmDataTot = "SELECT FOUND_ROWS()";
        $KsvmTotalReg = $KsvmConsulta->query($KsvmDataTot);
        $KsvmTotalReg = (int) $KsvmTotalReg->fetchColumn();
        $KsvmNPaginas = ceil($KsvmTotalReg/$KsvmNRegistros);

        $KsvmTabla .= '<table class="mdl-data-table mdl-js-data-table mdl-shadow--6dp full-width table-responsive">
                        <thead>
                            <tr>
                                <th class="mdl-data-table__cell--non-numeric">#</th>
                                <th class="mdl-data-table__cell--non-numeric">Rol</th>
                                <th class="mdl-data-table__cell--non-numeric">Menú Asignado</th>
                                <th style="text-align:center; witdh:30px;">Acción</th>
                            </tr>
                        </thead>
                        <tbody>';

        if ($KsvmTotalReg >= 1 && $KsvmPagina <= $KsvmNPaginas) {
            $KsvmContReg = $KsvmDesde +1;
            foreach ($KsvmQuery as $rows) {
                $KsvmTabla .= '<tr>
                                <td class="mdl-data-table__cell--non-numeric">'.$KsvmContReg.'</td>
                                <td class="mdl-data-table__cell--non-numeric">'.$rows['RrlNomRol'].'</td>
                                <td class="mdl-data-table__cell--non-numeric">'.$rows['MnuNomMen'].'</td>
                                <td style="text-align:right; witdh:30px;">';
                                if ($KsvmRol == 1) {
                                    $KsvmTabla .= '<form action="'.KsvmServUrl.'Ajax/KsvmMenuxRolAjax.php" method="POST" class="FormularioAjax" data-form="eliminar" enctype="multipart/form-data"> 
                                                   <a id="btn-detail" class="btn btn-sm btn-info" href="'.KsvmServUrl.'KsvmMenuXRolCrud/Detail/'.KsvmEstMaestra::__KsvmEncriptacion($rows['MxRId']).'/"><i class="zmdi zmdi-card"></i></a>
                                                   <div class="mdl-tooltip" for="btn-detail">Detalles</div>
                                                   <a id="btn-edit" class="btn btn-sm btn-primary" href="'.KsvmServUrl.'KsvmMenuXRolEditar/'.KsvmEstMaestra::__KsvmEncriptacion($rows['MxRId']).'/0/"><i class="zmdi zmdi-edit"></i></a>
                                                   <div class="mdl-tooltip" for="btn-edit">Editar</div>   
                                                   <input type="hidden" name="KsvmCodDelete" value="'.KsvmEstMaestra::__KsvmEncriptacion($rows['MxRId']).'">              
                                                   <button id="btn-delete" type="submit" class="btn btn-sm btn-danger"><i class="zmdi zmdi-delete"></i></button>
                                                   <div class="mdl-tooltip" for="btn-delete">Inhabilitar</div>
                                                   <div class="RespuestaAjax"></div>
                                                   </form>';
                                }elseif ($KsvmRol == 2){
                                    $KsvmTabla .= '<a id="btn-detail" class="btn btn-sm btn-info" href="'.KsvmServUrl.'KsvmMenuXRolCrud/Detail/'.KsvmEstMaestra::__KsvmEncriptacion($rows['MxRId']).'/"><i class="zmdi zmdi-card"></i></a>
                                                    <div class="mdl-tooltip" for="btn-detail">Detalles</div>
                                                    <a id="btn-edit" class="btn btn-sm btn-primary" href="'.KsvmServUrl.'KsvmMenuXRolEditar/'.KsvmEstMaestra::__KsvmEncriptacion($rows['MxRId']).'/1/"><i class="zmdi zmdi-edit"></i></a>
                                                    <div class="mdl-tooltip" for="btn-edit">Editar</div>';
                                }else{
                                    $KsvmTabla .= '<a id="btn-detail" class="btn btn-sm btn-info" href="'.KsvmServUrl.'KsvmMenuXRolCrud/Detail/'.KsvmEstMaestra::__KsvmEncriptacion($rows['MxRId']).'/"><i class="zmdi zmdi-card"></i></a>
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
                echo '<script> window.location.href=" '.KsvmServUrl.'KsvmMenuXRolCrud/1/"</script>';
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
                    $KsvmTabla .= '<a class = "btn btn-xs btn-success mdl-shadow--8dp " href="'.KsvmServUrl.'KsvmMenuXRolCrud/1/">Primero</a>
                                   <span></span>
                                   <a class = "btn btn-xs btn-default mdl-shadow--8dp " href="'.KsvmServUrl.'KsvmMenuXRolCrud/'.($KsvmPagina-1).'/"><i class="zmdi zmdi-fast-rewind"></i></a>';
                }

                if ($KsvmPagina == $KsvmNPaginas) {
                    $KsvmTabla .= '<button class = "btn btn-xs btn-default mdl-shadow--8dp disabled"><i class="zmdi zmdi-fast-forward"></i></button>
                                   <span></span>
                                   <button class = "btn btn-xs btn-success mdl-shadow--8dp disabled">Último</button>';
                } else {
                    $KsvmTabla .= '<a class="btn btn-xs btn-default mdl-shadow--8dp" href="'.KsvmServUrl.'KsvmMenuXRolCrud/'.($KsvmPagina+1).'/"><i class="zmdi zmdi-fast-forward"></i></a>
                                   <span></span>
                                   <a class="btn btn-xs btn-success mdl-shadow--8dp" href="'.KsvmServUrl.'KsvmMenuXRolCrud/'.($KsvmNPaginas).'/">Último</a>';
                                   
                                   
                }
                
             
                $KsvmTabla .= '</nav></div>';                
            }
            
        
                                   
        return $KsvmTabla;
      }
     
      /**
       * Función que permite eliminar un MenuxRol 
       */
      public function __KsvmEliminarMenuxRolControlador()
      {
         $KsvmCode = KsvmEstMaestra :: __KsvmDesencriptacion($_POST['KsvmCodDelete']);
         $KsvmCodMenuxRol = KsvmEstMaestra :: __KsvmFiltrarCadena($KsvmCode);

         $KsvmConsulta = "SELECT RrlId FROM ksvmvistaasignaprivilegio WHERE MxRId = '$KsvmCodMenuxRol'";
         $KsvmQuery = KsvmEstMaestra :: __KsvmEjecutaConsulta($KsvmConsulta);
         $KsvmDataMenuxRol = $KsvmQuery->fetch();
         if ($KsvmDataMenuxRol['RrlId'] != 1) {
             $KsvmDelPrivilegio = KsvmMenuxRolModelo :: __KsvmEliminarMenuxRolModelo($KsvmCodMenuxRol);
             if ($KsvmDelPrivilegio->rowCount() == 1) {
                $KsvmAlerta = [
                    "Alerta" => "Actualiza",
                    "Titulo" => "Privilegio Inhabilitado",
                    "Cuerpo" => "El Privilrgio seleccionado ha sido eliminado con éxito",
                    "Tipo" => "success"
                    ];
             }
         } else {
            $KsvmAlerta = [
                "Alerta" => "simple",
                "Titulo" => "Error inesperado",
                "Cuerpo" => "No es posible eliminar privilegios de Administrador",
                "Tipo" => "info"
                ];
         }

         return KsvmEstMaestra :: __KsvmMostrarAlertas($KsvmAlerta);
      }
    
      /**
       * Función que permite editar un MenuxRol 
       */
      public function __KsvmEditarMenuxRolControlador($KsvmCodMenuxRol)
      {
          $KsvmCodigo = KsvmEstMaestra :: __KsvmDesencriptacion($KsvmCodMenuxRol);

          return KsvmMenuxRolModelo :: __KsvmEditarMenuxRolModelo($KsvmCodigo);
      }
      
      /**
       * Función que permite contar un MenuxRol 
       */
      public function __KsvmContarMenuxRolControlador()
      {
          return KsvmMenuxRolModelo :: __KsvmContarMenuxRolModelo(0);
      }

      /**
       * Función que permite imprimir un MenuxRol 
       */
      public function __KsvmImprimirMenuxRolControlador()
      {
        return KsvmMenuxRolModelo :: __KsvmImprimirMenuxRolModelo();
      }

      /**
       * Función que permite actualizar un MenuxRol 
       */
      public function __KsvmActualizarMenuxRolControlador()
      {
        $KsvmCodMenuxRol = KsvmEstMaestra :: __KsvmDesencriptacion($_POST['KsvmCodEdit']);
        $KsvmRrlId = KsvmEstMaestra :: __KsvmFiltrarCadena($_POST['KsvmRrlId']);
        $KsvmMnuId = KsvmEstMaestra :: __KsvmFiltrarCadena($_POST['KsvmMnuId']);

        $KsvmActualPrivilegio = [
            "KsvmRrlId" => $KsvmRrlId,
            "KsvmMnuId" => $KsvmMnuId,
            "KsvmCodMenuxRol" => $KsvmCodMenuxRol
            ];

            $KsvmGuardarPrivilegio = KsvmMenuxRolModelo :: __KsvmActualizarMenuxRolModelo($KsvmActualPrivilegio);
                if ($KsvmGuardarPrivilegio->rowCount() >= 1) {
                    $KsvmAlerta = [
                    "Alerta" => "Actualiza",
                    "Titulo" => "Grandioso",
                    "Cuerpo" => "El Privilegio se actualizó satisfactoriamente",
                    "Tipo" => "success"
                    ];
                } else {
                    $KsvmAlerta = [
                    "Alerta" => "simple",
                    "Titulo" => "Error inesperado",
                    "Cuerpo" => "No se a podido actualizar la información del Privilegio",
                    "Tipo" => "info"
                    ];
                }
                return KsvmEstMaestra :: __KsvmMostrarAlertas($KsvmAlerta);
         
        }
    
}
   
 