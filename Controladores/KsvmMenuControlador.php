<?php

  /**
   *Condicion para peticion Ajax
   */
   if ($KsvmPeticionAjax) {
       require_once "../Modelos/KsvmMenuModelo.php";
   } else {
       require_once "./Modelos/KsvmMenuModelo.php";
   }

   class KsvmMenuControlador extends KsvmMenuModelo
   {
     /**
      *Función que permite ingresar un Menu
      */
     public function __KsvmAgregarMenuControlador()
     {
         $KsvmJerqMen = KsvmEstMaestra :: __KsvmFiltrarCadena($_POST['KsvmJerqMen']);
         $KsvmNomMen = KsvmEstMaestra :: __KsvmFiltrarCadena($_POST['KsvmNomMen']);
         $KsvmNivelMen = KsvmEstMaestra :: __KsvmFiltrarCadena($_POST['KsvmNivelMen']);
         $KsvmIconMen = KsvmEstMaestra :: __KsvmFiltrarCadena($_POST['KsvmIconMen']);
         $KsvmUrlMen = KsvmEstMaestra :: __KsvmFiltrarCadena($_POST['KsvmUrlMen']);
         $KsvmLeyendMen = KsvmEstMaestra :: __KsvmFiltrarCadena($_POST['KsvmLeyendMen']);


              $KsvmUrl = "SELECT MnuUrlMen FROM ksvmmenu17 WHERE MnuUrlMen = '$KsvmUrlMen'";
              $KsvmQuery = KsvmEstMaestra :: __KsvmEjecutaConsulta($KsvmUrl);  
             if ($KsvmQuery->rowCount() >= 1) {
               $KsvmAlerta = [
               "Alerta" => "simple",
               "Titulo" => "Error inesperado",
               "Cuerpo" => "La Url ingresada ya se encuentra registrada, Por favor ingrese una Url válida",
               "Tipo" => "info"
              ];
            
          }else{
              $KsvmNuevoMenu = [
                "KsvmJerqMen" => $KsvmJerqMen,
                "KsvmNomMen" => $KsvmNomMen,
                "KsvmNivelMen" => $KsvmNivelMen,
                "KsvmIconMen" => $KsvmIconMen,
                "KsvmUrlMen" => $KsvmUrlMen,
                "KsvmLeyendMen" => $KsvmLeyendMen
                ];

                $KsvmGuardarMenu = KsvmMenuModelo :: __KsvmAgregarMenuModelo($KsvmNuevoMenu);
                if ($KsvmGuardarMenu->rowCount() == 1) {
                    $KsvmAlerta = [
                    "Alerta" => "Actualiza",
                    "Titulo" => "Grandioso",
                    "Cuerpo" => "El Menú se registró satisfactoriamente",
                    "Tipo" => "success"
                    ];
                } else {
                    $KsvmAlerta = [
                    "Alerta" => "simple",
                    "Titulo" => "Error inesperado",
                    "Cuerpo" => "No se a podido registrar el Menú",
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
            $KsvmDataMenu = "SELECT SQL_CALC_FOUND_ROWS * FROM ksvmmenu17 WHERE ((MnuEstMen = 'A') AND (MnuNomMen LIKE '%$KsvmBuscar%' 
                          OR MnuNivelMen LIKE '%$KsvmBuscar%')) 
                          LIMIT $KsvmDesde, $KsvmNRegistros";
        } else {
            $KsvmDataMenu = "SELECT SQL_CALC_FOUND_ROWS * FROM ksvmmenu17 WHERE MnuEstMen = 'A' LIMIT $KsvmDesde, $KsvmNRegistros" ;
        }
        

        $KsvmConsulta = KsvmEstMaestra :: __KsvmConexion();
    
        $KsvmQuery = $KsvmConsulta->query($KsvmDataMenu);
        $KsvmQuery = $KsvmQuery->fetchAll();
        
        $KsvmDataTot = "SELECT FOUND_ROWS()";
        $KsvmTotalReg = $KsvmConsulta->query($KsvmDataTot);
        $KsvmTotalReg = (int) $KsvmTotalReg->fetchColumn();
        $KsvmNPaginas = ceil($KsvmTotalReg/$KsvmNRegistros);

        $KsvmTabla .= '<table class="mdl-data-table mdl-js-data-table mdl-shadow--6dp full-width table-responsive">
                        <thead>
                            <tr>
                                <th class="mdl-data-table__cell--non-numeric">#</th>
                                <th class="mdl-data-table__cell--non-numeric">Jerarquía</th>
                                <th class="mdl-data-table__cell--non-numeric">Nombre</th>
                                <th class="mdl-data-table__cell--non-numeric">Nivel</th>
                                <th class="mdl-data-table__cell--non-numeric">Url</th>
                                <th class="mdl-data-table__cell--non-numeric">Icono</th>
                                <th style="text-align:center; witdh:30px;">Acción</th>
                            </tr>
                        </thead>
                        <tbody>';

        if ($KsvmTotalReg >= 1 && $KsvmPagina <= $KsvmNPaginas) {
            $KsvmContReg = $KsvmDesde +1;
            foreach ($KsvmQuery as $rows) {

                if ($rows['MnuUrlMen'] == "") {
                    $KsvmUrl = "Sin Información";
                }else{
                    $KsvmUrl = $rows['MnuUrlMen'];
                  }
                  
                $KsvmJerq = $rows['MnuJerqMen'];
                
                $KsvmMostrarJerq = new KsvmMenuModelo();
                $KsvmMenu = $KsvmMostrarJerq -> __KsvmMostrarJerarquiaModelo($KsvmJerq);
    
                if ($KsvmMenu->rowCount() == 1) {
                    $KsvmJerarquia = $KsvmMenu->fetch();
                    $KsvmNomJerq = $KsvmJerarquia['MnuNomMen'];
                }else {
                    $KsvmNomJerq = "Es Menú padre";
                }

                $KsvmTabla .= '<tr>
                                <td class="mdl-data-table__cell--non-numeric">'.$KsvmContReg.'</td>
                                <td class="mdl-data-table__cell--non-numeric">'.$KsvmNomJerq.'</td>
                                <td class="mdl-data-table__cell--non-numeric">'.$rows['MnuNomMen'].'</td>
                                <td class="mdl-data-table__cell--non-numeric">'.$rows['MnuNivelMen'].'</td>
                                <td class="mdl-data-table__cell--non-numeric">'.$KsvmUrl.'</td>
                                <td class="mdl-data-table__cell--non-numeric"><i style="font-size:25px;" class="'.$rows['MnuIconMen'].'"></i></td>
                                <td style="text-align:right; witdh:30px;">';
                                if ($KsvmRol == 1) {
                                    $KsvmTabla .= '<form action="'.KsvmServUrl.'Ajax/KsvmMenuAjax.php" method="POST" class="FormularioAjax" data-form="eliminar" enctype="multipart/form-data"> 
                                                   <a id="btn-detail" class="btn btn-sm btn-info" href="'.KsvmServUrl.'KsvmMenuCrud/Detail/'.KsvmEstMaestra::__KsvmEncriptacion($rows['MnuId']).'/"><i class="zmdi zmdi-card"></i></a>
                                                   <div class="mdl-tooltip" for="btn-detail">Detalles</div>
                                                   <a id="btn-edit" class="btn btn-sm btn-primary" href="'.KsvmServUrl.'KsvmMenuEditar/'.KsvmEstMaestra::__KsvmEncriptacion($rows['MnuId']).'/0/"><i class="zmdi zmdi-edit"></i></a>
                                                   <div class="mdl-tooltip" for="btn-edit">Editar</div>   
                                                   <input type="hidden" name="KsvmCodDelete" value="'.KsvmEstMaestra::__KsvmEncriptacion($rows['MnuId']).'">              
                                                   <button id="btn-delete" type="submit" class="btn btn-sm btn-danger"><i class="zmdi zmdi-delete"></i></button>
                                                   <div class="mdl-tooltip" for="btn-delete">Inhabilitar</div>
                                                   <div class="RespuestaAjax"></div>
                                                   </form>';
                                }elseif ($KsvmRol == 2){
                                    $KsvmTabla .= '<a id="btn-detail" class="btn btn-sm btn-info" href="'.KsvmServUrl.'KsvmMenuCrud/Detail/'.KsvmEstMaestra::__KsvmEncriptacion($rows['MnuId']).'/"><i class="zmdi zmdi-card"></i></a>
                                                    <div class="mdl-tooltip" for="btn-detail">Detalles</div>
                                                    <a id="btn-edit" class="btn btn-sm btn-primary" href="'.KsvmServUrl.'KsvmMenuEditar/'.KsvmEstMaestra::__KsvmEncriptacion($rows['MnuId']).'/1/"><i class="zmdi zmdi-edit"></i></a>
                                                    <div class="mdl-tooltip" for="btn-edit">Editar</div>';
                                }else{
                                    $KsvmTabla .= '<a id="btn-detail" class="btn btn-sm btn-info" href="'.KsvmServUrl.'KsvmMenuCrud/Detail/'.KsvmEstMaestra::__KsvmEncriptacion($rows['MnuId']).'/"><i class="zmdi zmdi-card"></i></a>
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
                echo '<script> window.location.href=" '.KsvmServUrl.'KsvmMenuCrud"</script>';
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
                    $KsvmTabla .= '<a class = "btn btn-xs btn-success mdl-shadow--8dp " href="'.KsvmServUrl.'KsvmMenuCrud/1/">Primero</a>
                                   <span></span>
                                   <a class = "btn btn-xs btn-default mdl-shadow--8dp " href="'.KsvmServUrl.'KsvmMenuCrud/'.($KsvmPagina-1).'/"><i class="zmdi zmdi-fast-rewind"></i></a>';
                }

                if ($KsvmPagina == $KsvmNPaginas) {
                    $KsvmTabla .= '<button class = "btn btn-xs btn-default mdl-shadow--8dp disabled"><i class="zmdi zmdi-fast-forward"></i></button>
                                   <span></span>
                                   <button class = "btn btn-xs btn-success mdl-shadow--8dp disabled">Último</button>';
                } else {
                    $KsvmTabla .= '<a class="btn btn-xs btn-default mdl-shadow--8dp" href="'.KsvmServUrl.'KsvmMenuCrud/'.($KsvmPagina+1).'/"><i class="zmdi zmdi-fast-forward"></i></a>
                                   <span></span>
                                   <a class="btn btn-xs btn-success mdl-shadow--8dp" href="'.KsvmServUrl.'KsvmMenuCrud/'.($KsvmNPaginas).'/">Último</a>';
                                   
                                   
                }
                
             
                $KsvmTabla .= '</nav></div>';  

            }
            
                                   
        return $KsvmTabla;
      }
     
      /**
       * Función que permite inhabilitar un Menu 
       */
      public function __KsvmEliminarMenuControlador()
      {
         $KsvmCode = KsvmEstMaestra :: __KsvmDesencriptacion($_POST['KsvmCodDelete']);
         $KsvmCodMenu = KsvmEstMaestra :: __KsvmFiltrarCadena($KsvmCode);

         $KsvmDelMenu = KsvmMenuModelo :: __KsvmEliminarMenuModelo($KsvmCodMenu);
         if ($KsvmDelMenu->rowCount() == 1) {
            $KsvmAlerta = [
                "Alerta" => "Actualiza",
                "Titulo" => "Menu Inhabilitado",
                "Cuerpo" => "El Menú seleccionado ha sido inhabilitado con éxito",
                "Tipo" => "success"
                ];
             
         } else {
            $KsvmAlerta = [
                "Alerta" => "simple",
                "Titulo" => "Error inesperado",
                "Cuerpo" => "No es posible eliminar el Menú del sistema",
                "Tipo" => "info"
                ];
         }

         return KsvmEstMaestra :: __KsvmMostrarAlertas($KsvmAlerta);
      }
    
      /**
       * Función que permite editar un Menu 
       */
      public function __KsvmEditarMenuControlador($KsvmCodMenu)
      {
          $KsvmCodigo = KsvmEstMaestra :: __KsvmDesencriptacion($KsvmCodMenu);

          return KsvmMenuModelo :: __KsvmEditarMenuModelo($KsvmCodigo);
      }
      
      /**
       * Función que permite contar un Menu 
       */
      public function __KsvmContarMenuControlador()
      {
          return KsvmMenuModelo :: __KsvmContarMenuModelo(0);
      }

      /**
       * Función que permite imprimir una Menu 
       */
      public function __KsvmImprimirMenuControlador()
      {
        return KsvmMenuModelo :: __KsvmImprimirMenuModelo();
      }

      /**
       * Función que permite actualizar un Menu 
       */
      public function __KsvmActualizarMenuControlador()
      {
        $KsvmCodMenu = KsvmEstMaestra :: __KsvmDesencriptacion($_POST['KsvmCodEdit']);
        $KsvmJerqMen = KsvmEstMaestra :: __KsvmFiltrarCadena($_POST['KsvmJerqMen']);
        $KsvmNomMen = KsvmEstMaestra :: __KsvmFiltrarCadena($_POST['KsvmNomMen']);
        $KsvmNivelMen = KsvmEstMaestra :: __KsvmFiltrarCadena($_POST['KsvmNivelMen']);
        $KsvmIconMen = KsvmEstMaestra :: __KsvmFiltrarCadena($_POST['KsvmIconMen']);
        $KsvmUrlMen = KsvmEstMaestra :: __KsvmFiltrarCadena($_POST['KsvmUrlMen']);
        $KsvmLeyendMen = KsvmEstMaestra :: __KsvmFiltrarCadena($_POST['KsvmLeyendMen']);

        $KsvmConsulta = "SELECT * FROM ksvmmenu17 WHERE MnuId = '$KsvmCodMenu'";
        $KsvmQuery = KsvmEstMaestra :: __KsvmEjecutaConsulta($KsvmConsulta);
        $KsvmDataMenu = $KsvmQuery->fetch();

        if ($KsvmUrlMen != $KsvmDataMenu['MnuUrlMen']) {

            $KsvmConsulta = "SELECT MnuUrlMen FROM ksvmmenu17 WHERE MnuUrlMen = '$KsvmUrlMen'";
            $KsvmQuery = KsvmEstMaestra :: __KsvmEjecutaConsulta($KsvmConsulta);
            if ($KsvmQuery->rowCount() >= 1) {
                $KsvmAlerta = [
                    "Alerta" => "Actualiza",
                    "Titulo" => "Error Inesperado",
                    "Cuerpo" => "La Url ingresada ya se encuentra registrada, Por favor ingrese una Url válida",
                    "Tipo" => "error"
                    ];
                    return KsvmEstMaestra :: __KsvmMostrarAlertas($KsvmAlerta);
                    exit();
            }
        }

        $KsvmActualMenu = [
            "KsvmJerqMen" => $KsvmJerqMen,
            "KsvmNomMen" => $KsvmNomMen,
            "KsvmNivelMen" => $KsvmNivelMen,
            "KsvmIconMen" => $KsvmIconMen,
            "KsvmUrlMen" => $KsvmUrlMen,
            "KsvmLeyendMen" => $KsvmLeyendMen,
            "KsvmCodMenu" => $KsvmCodMenu
            ];

            $KsvmGuardarMenu = KsvmMenuModelo :: __KsvmActualizarMenuModelo($KsvmActualMenu);
                if ($KsvmGuardarMenu->rowCount() >= 1) {
                    $KsvmAlerta = [
                    "Alerta" => "Actualiza",
                    "Titulo" => "Grandioso",
                    "Cuerpo" => "El Menú se actualizó satisfactoriamente",
                    "Tipo" => "success"
                    ];
                } else {
                    $KsvmAlerta = [
                    "Alerta" => "simple",
                    "Titulo" => "Error inesperado",
                    "Cuerpo" => "No se a podido actualizar la información del Menú",
                    "Tipo" => "info"
                    ];
                }
                return KsvmEstMaestra :: __KsvmMostrarAlertas($KsvmAlerta);
         
        }

        public function __KsvmSeleccionarMenu(){
            $KsvmSelectMenu = "SELECT * FROM ksvmmenu17 WHERE MnuNivelMen = 0";

            $KsvmConsulta = KsvmEstMaestra :: __KsvmConexion();
            $KsvmQuery = $KsvmConsulta->query($KsvmSelectMenu);
            $KsvmQuery = $KsvmQuery->fetchAll();
            
            foreach ($KsvmQuery as $row) {
                $KsvmListar .= '<option value="'.$row['MnuId'].'">'.$row['MnuNomMen'].'</option>';
            }
            return $KsvmListar;
        }
    
}
   
 