<?php

  /**
   *Condicion para peticion Ajax
   */
   if ($KsvmPeticionAjax) {
       require_once "../Modelos/KsvmRolModelo.php";
   } else {
       require_once "./Modelos/KsvmRolModelo.php";
   }

   class KsvmRolControlador extends KsvmRolModelo
   {
     /**
      *Función que permite ingresar un Rol
      */
     public function __KsvmAgregarRolControlador()
     {
         $KsvmNomRol = KsvmEstMaestra :: __KsvmFiltrarCadena($_POST['KsvmNomRol']);

         $KsvmRol = "SELECT RrlNomRol FROM ksvmrol02 WHERE RrlNomRol ='$KsvmNomRol'";
         $KsvmQuery = KsvmEstMaestra :: __KsvmEjecutaConsulta($KsvmRol);
         if ($KsvmQuery->rowCount() == 1) {
            $KsvmAlerta = [
              "Alerta" => "simple",
              "Titulo" => "Error inesperado",
              "Cuerpo" => "El Rol ingresado ya se encuentra registrado, Por favor ingrese un Rol válido",
              "Tipo" => "info"
             ];

         }else{
              $KsvmNuevoRol = [
                "KsvmNomRol" => $KsvmNomRol
                ];

                $KsvmGuardarRol = KsvmRolModelo :: __KsvmAgregarRolModelo($KsvmNuevoRol);
                if ($KsvmGuardarRol->rowCount() >= 1) {
                    $KsvmAlerta = [
                    "Alerta" => "Limpia",
                    "Titulo" => "Grandioso",
                    "Cuerpo" => "El Rol se registró satisfactoriamente",
                    "Tipo" => "success"
                    ];
                } else {
                    $KsvmAlerta = [
                    "Alerta" => "simple",
                    "Titulo" => "Error inesperado",
                    "Cuerpo" => "No se a podido registrar el Rol",
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
            $KsvmDataRol = "SELECT SQL_CALC_FOUND_ROWS * FROM ksvmrol02 WHERE ((RrlId != 1 AND RrlEstRol = 'A') AND (RrlNomRol LIKE '%$KsvmBuscar%')) 
                            LIMIT $KsvmDesde, $KsvmNRegistros";
        } else {
            $KsvmDataRol = "SELECT SQL_CALC_FOUND_ROWS * FROM ksvmrol02 WHERE RrlId != 1 AND RrlEstRol = 'A' LIMIT $KsvmDesde, $KsvmNRegistros" ;
        }
        

        $KsvmConsulta = KsvmEstMaestra :: __KsvmConexion();
    
        $KsvmQuery = $KsvmConsulta->query($KsvmDataRol);
        $KsvmQuery = $KsvmQuery->fetchAll();
        
        $KsvmDataTot = "SELECT FOUND_ROWS()";
        $KsvmTotalReg = $KsvmConsulta->query($KsvmDataTot);
        $KsvmTotalReg = (int) $KsvmTotalReg->fetchColumn();
        $KsvmNPaginas = ceil($KsvmTotalReg/$KsvmNRegistros);

        $KsvmTabla .= '<table class="mdl-data-table mdl-js-data-table mdl-shadow--6dp full-width table-responsive">
                        <thead>
                            <tr>
                                <th class="mdl-data-table__cell--non-numeric">#</th>
                                <th class="mdl-data-table__cell--non-numeric">Nombre</th>
                                <th class="mdl-data-table__cell--non-numeric">Estado</th>
                                <th style="text-align:center; witdh:30px;">Acción</th>
                            </tr>
                        </thead>
                        <tbody>';

        if ($KsvmTotalReg >= 1 && $KsvmPagina <= $KsvmNPaginas) {
            $KsvmContReg = $KsvmDesde +1;
            foreach ($KsvmQuery as $rows) {

                $KsvmEstado = "";
                if ($rows['RrlEstRol'] == 'A') {
                    $KsvmEstado = "Activo";
                } else {
                    $KsvmEstado = "Inactivo";
                }

                $KsvmTabla .= '<tr>
                                <td class="mdl-data-table__cell--non-numeric">'.$KsvmContReg.'</td>
                                <td class="mdl-data-table__cell--non-numeric">'.$rows['RrlNomRol'].'</td>
                                <td class="mdl-data-table__cell--non-numeric">'.$KsvmEstado.'</td>
                                <td style="text-align:right; witdh:30px;">';
                                if ($KsvmRol == 1) {
                                    $KsvmTabla .= '<form action="'.KsvmServUrl.'Ajax/KsvmRolAjax.php" method="POST" class="FormularioAjax" data-form="eliminar" enctype="multipart/form-data"> 
                                                   <a id="btn-detail" class="btn btn-sm btn-info" href="'.KsvmServUrl.'KsvmRolesCrud/Detail/'.KsvmEstMaestra::__KsvmEncriptacion($rows['RrlId']).'/"><i class="zmdi zmdi-card"></i></a>
                                                   <div class="mdl-tooltip" for="btn-detail">Detalles</div>
                                                   <a id="btn-edit" class="btn btn-sm btn-primary" href="'.KsvmServUrl.'KsvmRolesEditar/'.KsvmEstMaestra::__KsvmEncriptacion($rows['RrlId']).'/0/"><i class="zmdi zmdi-edit"></i></a>
                                                   <div class="mdl-tooltip" for="btn-edit">Editar</div>   
                                                   <input type="hidden" name="KsvmCodDelete" value="'.KsvmEstMaestra::__KsvmEncriptacion($rows['RrlId']).'">              
                                                   <button id="btn-delete" type="submit" class="btn btn-sm btn-danger"><i class="zmdi zmdi-delete"></i></button>
                                                   <div class="mdl-tooltip" for="btn-delete">Inhabilitar</div>
                                                   <div class="RespuestaAjax"></div>
                                                   </form>';
                                }elseif ($KsvmRol == 2){
                                    $KsvmTabla .= '<a id="btn-detail" class="btn btn-sm btn-info" href="'.KsvmServUrl.'KsvmRolesCrud/Detail/'.KsvmEstMaestra::__KsvmEncriptacion($rows['RrlId']).'/"><i class="zmdi zmdi-card"></i></a>
                                                    <div class="mdl-tooltip" for="btn-detail">Detalles</div>
                                                    <a id="btn-edit" class="btn btn-sm btn-primary" href="'.KsvmServUrl.'KsvmRolesEditar/'.KsvmEstMaestra::__KsvmEncriptacion($rows['RrlId']).'/1/"><i class="zmdi zmdi-edit"></i></a>
                                                    <div class="mdl-tooltip" for="btn-edit">Editar</div>';
                                }else{
                                    $KsvmTabla .= '<a id="btn-detail" class="btn btn-sm btn-info" href="'.KsvmServUrl.'KsvmRolesCrud/Detail/'.KsvmEstMaestra::__KsvmEncriptacion($rows['RrlId']).'/"><i class="zmdi zmdi-card"></i></a>
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
                echo '<script> window.location.href=" '.KsvmServUrl.'KsvmRolesCrud"</script>';
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
                    $KsvmTabla .= '<a class = "btn btn-xs btn-success mdl-shadow--8dp " href="'.KsvmServUrl.'KsvmRolesCrud/1/">Primero</a>
                                   <span></span>
                                   <a class = "btn btn-xs btn-default mdl-shadow--8dp " href="'.KsvmServUrl.'KsvmRolesCrud/'.($KsvmPagina-1).'/"><i class="zmdi zmdi-fast-rewind"></i></a>';
                }

                if ($KsvmPagina == $KsvmNPaginas) {
                    $KsvmTabla .= '<button class = "btn btn-xs btn-default mdl-shadow--8dp disabled"><i class="zmdi zmdi-fast-forward"></i></button>
                                   <span></span>
                                   <button class = "btn btn-xs btn-success mdl-shadow--8dp disabled">Último</button>';
                } else {
                    $KsvmTabla .= '<a class="btn btn-xs btn-default mdl-shadow--8dp" href="'.KsvmServUrl.'KsvmRolesCrud/'.($KsvmPagina+1).'/"><i class="zmdi zmdi-fast-forward"></i></a>
                                   <span></span>
                                   <a class="btn btn-xs btn-success mdl-shadow--8dp" href="'.KsvmServUrl.'KsvmRolesCrud/'.($KsvmNPaginas).'/">Último</a>';
                                   
                                   
                }
                
             
                $KsvmTabla .= '</nav></div>';                
            }
            
        
                                   
        return $KsvmTabla;
      }
     
      /**
       * Función que permite inhabilitar un Rol 
       */
      public function __KsvmEliminarRolControlador()
      {
         $KsvmCode = KsvmEstMaestra :: __KsvmDesencriptacion($_POST['KsvmCodDelete']);
         $KsvmCodRol = KsvmEstMaestra :: __KsvmFiltrarCadena($KsvmCode);

         $KsvmConsulta = "SELECT RrlId FROM ksvmrol02 WHERE RrlId = '$KsvmCodRol'";
         $KsvmQuery = KsvmEstMaestra :: __KsvmEjecutaConsulta($KsvmConsulta);
         $KsvmDataRol = $KsvmQuery->fetch();
         if ($KsvmDataRol['RrlId'] != 1) {
             $KsvmDelRol = KsvmRolModelo :: __KsvmEliminarRolModelo($KsvmCodRol);
             if ($KsvmDelRol->rowCount() == 1) {
                $KsvmAlerta = [
                    "Alerta" => "Actualiza",
                    "Titulo" => "Rol Inhabilitado",
                    "Cuerpo" => "El Rol seleccionado ha sido inhabilitado con éxito",
                    "Tipo" => "success"
                    ];
             }
         } else {
            $KsvmAlerta = [
                "Alerta" => "simple",
                "Titulo" => "Error inesperado",
                "Cuerpo" => "No es posible eliminar el Administrador del sistema",
                "Tipo" => "info"
                ];
         }

         return KsvmEstMaestra :: __KsvmMostrarAlertas($KsvmAlerta);
      }
    
      /**
       * Función que permite editar un Rol 
       */
      public function __KsvmEditarRolControlador($KsvmCodRol)
      {
          $KsvmCodigo = KsvmEstMaestra :: __KsvmDesencriptacion($KsvmCodRol);

          return KsvmRolModelo :: __KsvmEditarRolModelo($KsvmCodigo);
      }
      
      /**
       * Función que permite contar un Rol 
       */
      public function __KsvmContarRolControlador()
      {
          return KsvmRolModelo :: __KsvmContarRolModelo(0);
      }

      /**
       * Función que permite imprimir una Rol 
       */
      public function __KsvmImprimirRolControlador()
      {
        return KsvmRolModelo :: __KsvmImprimirRolModelo();
      }

      /**
       * Función que permite actualizar un Rol 
       */
      public function __KsvmActualizarRolControlador()
      {
        $KsvmCodRol = KsvmEstMaestra :: __KsvmDesencriptacion($_POST['KsvmCodEdit']);
        $KsvmNomRol = KsvmEstMaestra :: __KsvmFiltrarCadena($_POST['KsvmNomRol']);

        $KsvmConsulta = "SELECT * FROM ksvmrol02 WHERE RrlId = '$KsvmCodRol'";
        $KsvmQuery = KsvmEstMaestra :: __KsvmEjecutaConsulta($KsvmConsulta);
        $KsvmDataRol = $KsvmQuery->fetch();

        if ($KsvmNomRol != $KsvmDataRol['RrlNomRol']) {
            $KsvmConsulta = "SELECT RrlNomRol FROM ksvmrol02 WHERE RrlNomRol = '$KsvmNomRol'";
            $KsvmQuery = KsvmEstMaestra :: __KsvmEjecutaConsulta($KsvmConsulta);
            if ($KsvmQuery->rowCount() >= 1) {
                $KsvmAlerta = [
                    "Alerta" => "Actualiza",
                    "Titulo" => "Error Inesperado",
                    "Cuerpo" => "El Rol ingresado ya se encuentra registrado, Por favor ingrese un Rol válido",
                    "Tipo" => "info"
                    ];
                    return KsvmEstMaestra :: __KsvmMostrarAlertas($KsvmAlerta);
                    exit();
            }
        }

        $KsvmActualRol = [
            "KsvmNomRol" => $KsvmNomRol,
            "KsvmCodRol" => $KsvmCodRol
            ];

            $KsvmGuardarRol = KsvmRolModelo :: __KsvmActualizarRolModelo($KsvmActualRol);
                if ($KsvmGuardarRol->rowCount() >= 1) {
                    $KsvmAlerta = [
                    "Alerta" => "Actualiza",
                    "Titulo" => "Grandioso",
                    "Cuerpo" => "El Rol se actualizó satisfactoriamente",
                    "Tipo" => "success"
                    ];
                } else {
                    $KsvmAlerta = [
                    "Alerta" => "simple",
                    "Titulo" => "Error inesperado",
                    "Cuerpo" => "No se a podido actualizar la información del Rol",
                    "Tipo" => "info"
                    ];
                }
                return KsvmEstMaestra :: __KsvmMostrarAlertas($KsvmAlerta);
         
        }

        public function __KsvmSeleccionarRol(){
            $KsvmSelectRol = "SELECT * FROM ksvmseleccionarol WHERE RrlId != 1";

            $KsvmConsulta = KsvmEstMaestra :: __KsvmConexion();
            $KsvmQuery = $KsvmConsulta->query($KsvmSelectRol);
            $KsvmQuery = $KsvmQuery->fetchAll();
            
            foreach ($KsvmQuery as $row) {
                $KsvmListar .= '<option value="'.$row['RrlId'].'">'.$row['RrlNomRol'].'</option>';
            }
            return $KsvmListar;
        }
    
}
   
 