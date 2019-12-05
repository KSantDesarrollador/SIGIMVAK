<?php

  /**
   *Condicion para peticion Ajax
   */
   if ($KsvmPeticionAjax) {
       require_once "../Raiz/KsvmEstMaestra.php";
   } else {
       require_once "./Raiz/KsvmEstMaestra.php";
   }

   class KsvmUsuarioControlador extends KsvmEstMaestra
   {
     /**
      *Función que permite ingresar un usuario
      */
     public function __KsvmAgregarUsuarioControlador()
     {
         $KsvmRol = KsvmEstMaestra :: __KsvmFiltrarCadena($_POST['KsvmRol']);
         $KsvmNomUsu = KsvmEstMaestra :: __KsvmFiltrarCadena($_POST['KsvmNomUsu']);
         $KsvmContra = KsvmEstMaestra :: __KsvmFiltrarCadena($_POST['KsvmContra']);
         $KsvmConContra = KsvmEstMaestra :: __KsvmFiltrarCadena($_POST['KsvmConContra']);
         $KsvmEmail = KsvmEstMaestra :: __KsvmFiltrarCadena($_POST['KsvmEmail']);
         $KsvmTelf = KsvmEstMaestra :: __KsvmFiltrarCadena($_POST['KsvmTelf']);
         $KsvmImgUsu = addslashes(file_get_contents($_FILES['KsvmImgUsu']['tmp_name']));

         if ($KsvmContra != $KsvmConContra) {
             $KsvmAlerta = [
               "Alerta" => "simple",
               "Titulo" => "Error inesperado",
               "Cuerpo" => "Las contraseñas ingresadas no coinciden, Por favor Intentelo de nuevo",
               "Tipo" => "error"
             ];
         } else {
           if ($KsvmEmail != "") {
              $KsvmEmail = "SELECT UsrEmailUsu FROM ksvmvistausuario WHERE UsrEmailUsu = '$KsvmEmail' ";
              $KsvmQuery = KsvmEstMaestra :: __KsvmEjecutaConsulta($KsvmEmail);
              $KsvmEmaEm = $KsvmQuery->rowCount();
           }else{
               $KsvmEmaEm = 0;
           }

             if ($KsvmEmaEm >= 1) {
               $KsvmAlerta = [
               "Alerta" => "simple",
               "Titulo" => "Error inesperado",
               "Cuerpo" => "El Email ingresado ya se encuentra registrado,  Por favor ingrese un Email válido",
               "Tipo" => "error"
              ];
             } else {
               $KsvmNomUsu = "SELECT UsrNomUsu FROM ksvmvistausuario WHERE UsrNomUsu = '$KsvmNomUsu' ";
               $KsvmQuery = KsvmEstMaestra :: __KsvmEjecutaConsulta($KsvmNomUsu);
               if ($KsvmQuery->rowCount() >= 1) {
                 $KsvmAlerta = [
                 "Alerta" => "simple",
                 "Titulo" => "Error inesperado",
                 "Cuerpo" => "El usuario ingresado ya se encuentra registrado,  Por favor ingrese un usuario válido",
                 "Tipo" => "error"
                 ];
               } else {
                 $KsvmContrasenia = KsvmEstMaestra :: __KsvmEncriptacion($KsvmContra);
                 $KsvmNuevoUsu = [
                   "KsvmEpoId" => 1,
                   "KsvmRrlId" => 1,
                   "KsvmNomUsu" => $KsvmNomUsu,
                   "KsvmContraUsu" => $KsvmContrasenia,
                   "KsvmUsrEmailUsu" => $KsvmEmail,
                   "KsvmUsrTelfUsu" => $KsvmTelf,
                   "KsvmUsrImgUsu" => $KsvmImg
                   ];

                 $KsvmGuardarUsu = KsvmEstMaestra :: __KsvmAgregarUsuario($KsvmNuevoUsu);
                 if ($KsvmGuardarUsu->rowCount() >= 1) {
                     $KsvmAlerta = [
                     "Alerta" => "Limpia",
                     "Titulo" => "Grandioso",
                     "Cuerpo" => "El usuario se registró satisfactoriamente",
                     "Tipo" => "success"
                     ];
                 } else {
                     $KsvmAlerta = [
                     "Alerta" => "simple",
                     "Titulo" => "Error inesperado",
                     "Cuerpo" => "No se a podido registrar el usuario",
                     "Tipo" => "error"
                     ];
                 }

               }

             }
         }
         return KsvmEstMaestra :: __KsvmMostrarAlertas($KsvmAlerta);

     }
     /**
      *Función que permite paginar
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
            $KsvmDataUsu = "SELECT SQL_CALC_FOUND_ROWS * FROM ksvmvistausuario WHERE ((RrlId != '$KsvmRol') AND (UsrNomUsu LIKE '%$KsvmBuscar%' 
                          OR RrlNomRol LIKE '%$KsvmBuscar%' OR UsrEmailUsu LIKE '%$KsvmBuscar%')) 
                          LIMIT $KsvmDesde, $KsvmNRegistros";
                          
        } else {
            $KsvmDataUsu = "SELECT SQL_CALC_FOUND_ROWS * FROM ksvmvistausuario WHERE RrlId != '$KsvmRol' LIMIT $KsvmDesde, $KsvmNRegistros" ;
        }
        

        $KsvmConsulta = KsvmEstMaestra :: __KsvmConexion();
    
        $KsvmQuery = $KsvmConsulta->query($KsvmDataUsu);
        $KsvmQuery = $KsvmQuery->fetchAll();
        
        $KsvmDataTot = "SELECT FOUND_ROWS()";
        $KsvmTotalReg = $KsvmConsulta->query($KsvmDataTot);
        $KsvmTotalReg = (int) $KsvmTotalReg->fetchColumn();
        $KsvmNPaginas = ceil($KsvmTotalReg/$KsvmNRegistros);

        $KsvmTabla .= '<table class="mdl-data-table mdl-js-data-table mdl-shadow--6dp full-width table-responsive is-active" id="KsvmListaUsuarios">
                        <thead>
                            <tr>
                                <th class="mdl-data-table__cell--non-numeric">#</th>
                                <th class="mdl-data-table__cell--non-numeric">Usuario</th>
                                <th class="mdl-data-table__cell--non-numeric">Contraseña</th>
                                <th class="mdl-data-table__cell--non-numeric">Telf</th>
                                <th class="mdl-data-table__cell--non-numeric">Email</th>
                                <th class="mdl-data-table__cell--non-numeric">Rol</th>
                                <th style="text-align:center; witdh:30px;">Acción</th>
                            </tr>
                        </thead>
                        <tbody>';

        if ($KsvmTotalReg >= 1 && $KsvmPagina <= $KsvmNPaginas) {
            $KsvmContReg = $KsvmDesde +1;
            foreach ($KsvmQuery as $rows) {
                
                $KsvmTabla .= '<tr>
                                <td class="mdl-data-table__cell--non-numeric">'.$KsvmContReg.'</td>
                                <td class="mdl-data-table__cell--non-numeric">'.$rows['UsrNomUsu'].'</td>
                                <td class="mdl-data-table__cell--non-numeric">'.$rows['UsrContraUsu'].'</td>
                                <td class="mdl-data-table__cell--non-numeric">'.$rows['UsrTelfUsu'].'</td>
                                <td class="mdl-data-table__cell--non-numeric">'.$rows['UsrEmailUsu'].'</td>
                                <td class="mdl-data-table__cell--non-numeric">'.$rows['RrlNomRol'].'</td>
                                <td style="text-align:right; witdh:30px;">';
                                if ($KsvmRol == 1) {
                                    if ($KsvmCodigo == 0) {

                                    $KsvmTabla .=  '<form action="'.KsvmServUrl.'Ajax/KsvmRequisicionAjax.php" method="POST" class="FormularioAjax" data-form="eliminar" enctype="multipart/form-data"> 
                                                    <a id="btn-detail" class="btn btn-sm btn-info" href="'.KsvmServUrl.'KsvmUsuariosCrud/Detail/'.KsvmEstMaestra::__KsvmEncriptacion($rows['UsrId']).'/"><i class="zmdi zmdi-card"></i></a>
                                                    <div class="mdl-tooltip" for="btn-detail">Detalles</div>
                                                    <a id="btn-edit" class="btn btn-sm btn-primary" href="'.KsvmServUrl.'KsvmUsuariosEditar/'.KsvmEstMaestra::__KsvmEncriptacion($rows['UsrId']).'/0/"><i class="zmdi zmdi-edit"></i></a>
                                                    <div class="mdl-tooltip" for="btn-edit">Editar</div>
                                                    <input type="hidden" name="KsvmCodDelete" value="'.KsvmEstMaestra::__KsvmEncriptacion($rows['UsrId']).'">              
                                                    <button id="btn-delete" type="submit" class="btn btn-sm btn-danger"><i class="zmdi zmdi-delete"></i></button>
                                                    <div class="RespuestaAjax"></div>
                                                    </form>';
                                    } else {
                                    $KsvmTabla .= '<form action="'.KsvmServUrl.'Ajax/KsvmRequisicionAjax.php" method="POST" class="FormularioAjax" data-form="eliminar" enctype="multipart/form-data"> 
                                                    <a id="btn-detail" class="btn btn-sm btn-info" href="'.KsvmServUrl.'KsvmUsuarios/Detail/'.KsvmEstMaestra::__KsvmEncriptacion($rows['UsrId']).'"><i class="zmdi zmdi-card"></i></a>
                                                    <div class="mdl-tooltip" for="btn-detail">Detalles</div>
                                                    <a id="btn-edit" class="btn btn-sm btn-primary" href="'.KsvmServUrl.'KsvmUsuariosEditar/'.KsvmEstMaestra::__KsvmEncriptacion($rows['UsrId']).'/1/"><i class="zmdi zmdi-edit"></i></a>
                                                    <div class="mdl-tooltip" for="btn-edit">Editar</div>
                                                    <input type="hidden" name="KsvmCodDelete" value="'.KsvmEstMaestra::__KsvmEncriptacion($rows['UsrId']).'">              
                                                    <button id="btn-delete" type="submit" class="btn btn-sm btn-danger"><i class="zmdi zmdi-delete"></i></button>
                                                    <div class="mdl-tooltip" for="btn-delete">Inhabilitar</div>
                                                    <div class="RespuestaAjax"></div>
                                                    </form>'; 
                                    }
                                }elseif ($KsvmRol == 2 || $KsvmRol == 3){
                                    $KsvmTabla .= '<a id="btn-detail" class="btn btn-sm btn-info" href="'.KsvmServUrl.'KsvmUsuarios/Detail/'.KsvmEstMaestra::__KsvmEncriptacion($rows['UsrId']).'/"><i class="zmdi zmdi-card"></i></a>
                                                    <div class="mdl-tooltip" for="btn-detail">Detalles</div>
                                                    <a id="btn-edit" class="btn btn-sm btn-primary" href="'.KsvmServUrl.'KsvmUsuariosEditar/'.KsvmEstMaestra::__KsvmEncriptacion($rows['UsrId']).'/1/"><i class="zmdi zmdi-edit"></i></a>
                                                    <div class="mdl-tooltip" for="btn-edit">Editar</div>';
                                }else{
                                    $KsvmTabla .= '<a id="btn-detail" class="btn btn-sm btn-info" href="'.KsvmServUrl.'KsvmUsuarios/Detail/'.KsvmEstMaestra::__KsvmEncriptacion($rows['UsrId']).'/"><i class="zmdi zmdi-card"></i></a>
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
                echo '<script> window.location.href=" '.KsvmServUrl.'KsvmUsuariosCrud/"</script>';
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
                    $KsvmTabla .= '<a class = "btn btn-xs btn-success mdl-shadow--8dp " href="'.KsvmServUrl.'KsvmUsuariosCrud/1/">Primero</a>
                                   <span></span>
                                   <a class = "btn btn-xs btn-default mdl-shadow--8dp " href="'.KsvmServUrl.'KsvmUsuariosCrud/'.($KsvmPagina-1).'/"><i class="zmdi zmdi-fast-rewind"></i></a>';
                }

                if ($KsvmPagina == $KsvmNPaginas) {
                    $KsvmTabla .= '<button class = "btn btn-xs btn-default mdl-shadow--8dp disabled"><i class="zmdi zmdi-fast-forward"></i></button>
                                   <span></span>
                                   <button class = "btn btn-xs btn-success mdl-shadow--8dp disabled">Último</button>';
                } else {
                    $KsvmTabla .= '<a class="btn btn-xs btn-default mdl-shadow--8dp" href="'.KsvmServUrl.'KsvmUsuariosCrud/'.($KsvmPagina+1).'/"><i class="zmdi zmdi-fast-forward"></i></a>
                                   <span></span>
                                   <a class="btn btn-xs btn-success mdl-shadow--8dp" href="'.KsvmServUrl.'KsvmUsuariosCrud/'.($KsvmNPaginas).'/">Último</a>';
                                   
                                   
                }
                
             
                $KsvmTabla .= '</nav></div>';    

            } else {
                $KsvmTabla .= '<nav class="navbar-form navbar-right form-group">';
                
                if ($KsvmPagina == 1) {
                    $KsvmTabla .= '<button class = "btn btn-xs btn-success mdl-shadow--8dp disabled">Primero</button>
                                   <span></span>
                                   <button class = "btn btn-xs btn-default mdl-shadow--8dp disabled"><i class="zmdi zmdi-fast-rewind"></i></button>';
                } else {
                    $KsvmTabla .= '<a class = "btn btn-xs btn-success mdl-shadow--8dp " href="'.KsvmServUrl.'KsvmUsuarios/1/">Primero</a>
                                   <span></span>
                                   <a class = "btn btn-xs btn-default mdl-shadow--8dp " href="'.KsvmServUrl.'KsvmUsuarios/'.($KsvmPagina-1).'/"><i class="zmdi zmdi-fast-rewind"></i></a>';
                }

                if ($KsvmPagina == $KsvmNPaginas) {
                    $KsvmTabla .= '<button class = "btn btn-xs btn-default mdl-shadow--8dp disabled"><i class="zmdi zmdi-fast-forward"></i></button>
                                   <span></span>
                                   <button class = "btn btn-xs btn-success mdl-shadow--8dp disabled">Último</button>';
                } else {
                    $KsvmTabla .= '<a class="btn btn-xs btn-default mdl-shadow--8dp" href="'.KsvmServUrl.'KsvmUsuarios/'.($KsvmPagina+1).'/"><i class="zmdi zmdi-fast-forward"></i></a>
                                   <span></span>
                                   <a class="btn btn-xs btn-success mdl-shadow--8dp" href="'.KsvmServUrl.'KsvmUsuarios/'.($KsvmNPaginas).'/">Último</a>';
                                   
                                   
                }
                
                $KsvmTabla .= '</nav></div>'; 
            }
            
        
                                   
        return $KsvmTabla;
      }
     
      /**
       * Función que permite inhabilitar un usuario 
       */
      public function __KsvmEliminarUsuarioControlador()
      {
         $KsvmCode = KsvmEstMaestra :: __KsvmDesencriptacion($_POST['KsvmCodDelete']);
         $KsvmCode = KsvmEstMaestra :: __KsvmFiltrarCadena($KsvmCode);

         $KsvmConsulta = "SELECT UsrId FROM ksvmvistausuario WHERE UsrId = '$KsvmCode'";
         $KsvmQuery = KsvmEstMaestra :: __KsvmEjecutaConsulta($KsvmConsulta);
         $KsvmDataUsuario = $KsvmQuery->fetch();
         if ($KsvmDataUsuario['UsrId'] != 1) {
             $KsvmDelUsu = KsvmEstMaestra :: __KsvmEliminarUsuario($KsvmCode);
             if ($KsvmDelUsu->rowCount() == 1) {
                $KsvmAlerta = [
                    "Alerta" => "Actualiza",
                    "Titulo" => "Empleado Inhabilitado",
                    "Cuerpo" => "El usuario seleccionado ha sido inhabilitado con éxito",
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
       * Función que permite editar un usuario 
       */
      public function __KsvmEditarUsuarioControlador($KsvmCodUsuario)
      {
          $KsvmCodigo = KsvmEstMaestra :: __KsvmDesencriptacion($KsvmCodUsuario);

          return KsvmEstMaestra :: __KsvmEditarUsuario($KsvmCodigo);
      }
      
      /**
       * Función que permite contar un usuario 
       */
      public function __KsvmContarUsuarioControlador()
      {
          return KsvmEstMaestra :: __KsvmContarUsuario(0);
      }

      /**
       * Función que permite actualizar un empleado 
       */
      public function __KsvmActualizarUsuarioControlador()
      {
        $KsvmCode = KsvmEstMaestra :: __KsvmDesencriptacion($_POST['KsvmCodEdit']);

        $KsvmRol = KsvmEstMaestra :: __KsvmFiltrarCadena($_POST['KsvmRol']);
        $KsvmNomUsu = KsvmEstMaestra :: __KsvmFiltrarCadena($_POST['KsvmNomUsu']);
        $KsvmTelf = KsvmEstMaestra :: __KsvmFiltrarCadena($_POST['KsvmTelf']);
        $KsvmEmail = KsvmEstMaestra :: __KsvmFiltrarCadena($_POST['KsvmEmail']);
        $KsvmImgUsu = addslashes(file_get_contents($_FILES['KsvmImgUsu']['tmp_name']));

        if ($KsvmContra != $KsvmConContra) {
          $KsvmAlerta = [
            "Alerta" => "simple",
            "Titulo" => "Error inesperado",
            "Cuerpo" => "Las contraseñas ingresadas no coinciden, Por favor Intentelo de nuevo",
            "Tipo" => "error"
          ];
          return KsvmEstMaestra :: __KsvmMostrarAlertas($KsvmAlerta);
        }

        $KsvmConsulta = "SELECT * FROM ksvmvistausuario WHERE UsrId = '$KsvmCode'";
        $KsvmQuery = KsvmEstMaestra :: __KsvmEjecutaConsulta($KsvmConsulta);
        $KsvmDataUsuario = $KsvmQuery->fetch();

        if ($KsvmNomUsu != $KsvmDataUsuario['UsrNomUsu']) {
            $KsvmConsulta = "SELECT UsrNomUsu FROM ksvmvistausuario WHERE UsrNomUsu = '$KsvmNomUsu'";
            $KsvmQuery = KsvmEstMaestra :: __KsvmEjecutaConsulta($KsvmConsulta);
            if ($KsvmQuery->rowCount() >= 1) {
                $KsvmAlerta = [
                    "Alerta" => "Actualiza",
                    "Titulo" => "Error Inesperado",
                    "Cuerpo" => "El nombre de usuario ingresado ya se encuentra registrado, Por favor intentelo de nuevo",
                    "Tipo" => "info"
                    ];
                    return KsvmEstMaestra :: __KsvmMostrarAlertas($KsvmAlerta);
                    exit();
            }
        }

        $KsvmActualUsu = [
            "KsvmRrlId" => $KsvmRol,
            "KsvmNomUsu" => $KsvmNomUsu,
            "KsvmEmailUsu" => $KsvmEmail,
            "KsvmTelfUsu" => $KsvmTelf,
            "KsvmImgUsu" => $KsvmImgUsu,
            "KsvmCode" => $KsvmCode
            ];

            $KsvmGuardarUsu = KsvmEstMaestra :: __KsvmActualizarUsuario($KsvmActualUsu);
                if ($KsvmGuardarUsu->rowCount() >= 1) {
                    $KsvmAlerta = [
                    "Alerta" => "Actualiza",
                    "Titulo" => "Grandioso",
                    "Cuerpo" => "El usuario se actualizó satisfactoriamente",
                    "Tipo" => "success"
                    ];
                } else {
                    $KsvmAlerta = [
                    "Alerta" => "simple",
                    "Titulo" => "Error inesperado",
                    "Cuerpo" => "No se a podido actualizar la información del usuario",
                    "Tipo" => "info"
                    ];
                }
                return KsvmEstMaestra :: __KsvmMostrarAlertas($KsvmAlerta);
         
        }

        public function __KsvmSeleccionarUsuario(){
            $KsvmSelectUsuario = "SELECT * FROM ksvmusuario01";

            $KsvmConsulta = KsvmEstMaestra :: __KsvmConexion();
            $KsvmQuery = $KsvmConsulta->query($KsvmSelectUsuario);
            $KsvmQuery = $KsvmQuery->fetchAll();
            
            foreach ($KsvmQuery as $row) {
                $KsvmListar .= '<option value="'.$row['UsrId'].'">'.$row['UsrNomUsu'].'</option>';
            }
            return $KsvmListar;
        }
   }
