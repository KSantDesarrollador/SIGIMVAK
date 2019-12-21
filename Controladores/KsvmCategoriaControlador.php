<?php

  /**
   *Condicion para peticion Ajax
   */
   if ($KsvmPeticionAjax) {
       require_once "../Modelos/KsvmCategoriaModelo.php";
   } else {
       require_once "./Modelos/KsvmCategoriaModelo.php";
   }

   class KsvmCategoriaControlador extends KsvmCategoriaModelo
   {
     /**
      *Función que permite ingresar una Categoria
      */
     public function __KsvmAgregarCategoriaControlador()
     {
         $KsvmNomCat = KsvmEstMaestra :: __KsvmFiltrarCadena($_POST['KsvmNomCat']);
         $KsvmColorCat = KsvmEstMaestra :: __KsvmFiltrarCadena($_POST['KsvmColorCat']);

         $KsvmNombreCat = "SELECT KsvmNomCat FROM ksvmcategoria10 WHERE KsvmNomCat ='$KsvmNomCat'";
         $KsvmQuery = KsvmEstMaestra :: __KsvmEjecutaConsulta($KsvmNombreCat);
         if ($KsvmQuery->rowCount() == 1) {
            $KsvmAlerta = [
              "Alerta" => "simple",
              "Titulo" => "Error inesperado",
              "Cuerpo" => "La categoría ingresada ya se encuentra registrada, Por favor ingrese una categoría válida",
              "Tipo" => "info"
             ];
        
          }else{
              $KsvmNuevaCat = [
                "KsvmNomCat" => $KsvmNomCat,
                "KsvmColorCat" => $KsvmColorCat,
                ];

                $KsvmGuardarCat = KsvmCategoriaModelo :: __KsvmAgregarCategoriaModelo($KsvmNuevaCat);
                if ($KsvmGuardarCat->rowCount() >= 1) {
                    $KsvmAlerta = [
                    "Alerta" => "Limpia",
                    "Titulo" => "Grandioso",
                    "Cuerpo" => "El Categoría se registró satisfactoriamente",
                    "Tipo" => "success"
                    ];
                } else {
                    $KsvmAlerta = [
                    "Alerta" => "simple",
                    "Titulo" => "Error inesperado",
                    "Cuerpo" => "No se a podido registrar el Categoría",
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
            $KsvmDataCat = "SELECT SQL_CALC_FOUND_ROWS * FROM ksvmcategoria10 WHERE ((CtgEstCat = 'A') AND (CtgNomCat LIKE '%$KsvmBuscar%')) 
                            ORDER BY CtgNomCat LIMIT $KsvmDesde, $KsvmNRegistros";
        } else {
            $KsvmDataCat = "SELECT SQL_CALC_FOUND_ROWS * FROM ksvmcategoria10 WHERE CtgEstCat = 'A' ORDER BY CtgNomCat LIMIT $KsvmDesde, $KsvmNRegistros" ;
        }
        

        $KsvmConsulta = KsvmEstMaestra :: __KsvmConexion();
    
        $KsvmQuery = $KsvmConsulta->query($KsvmDataCat);
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
                                <th class="mdl-data-table__cell--non-numeric">Color</th>
                                <th class="mdl-data-table__cell--non-numeric">Estado</th>
                                <th style="text-align:center; witdh:30px;">Acción</th>
                            </tr>
                        </thead>
                        <tbody>';

        if ($KsvmTotalReg >= 1 && $KsvmPagina <= $KsvmNPaginas) {
            $KsvmContReg = $KsvmDesde +1;
            foreach ($KsvmQuery as $rows) {

                $KsvmEstado = "";
                if ($rows['CtgEstCat'] == 'A') {
                    $KsvmEstado = "Activo";
                }else {
                    $KsvmEstado = "Inactivo";
                }

                $KsvmTabla .= '<tr>
                                <td class="mdl-data-table__cell--non-numeric">'.$KsvmContReg.'</td>
                                <td class="mdl-data-table__cell--non-numeric">'.$rows['CtgNomCat'].'</td>
                                <td class="mdl-data-table__cell--non-numeric"><button class="btn btn-md" style="border-color:#000; background-color:'.$rows['CtgColorCat'].';"></button></td>
                                <td class="mdl-data-table__cell--non-numeric">'.$KsvmEstado.'</td>
                                <td style="text-align:right; witdh:30px;">';
                                if ($KsvmRol == 1) {
                                    $KsvmTabla .= '<form action="'.KsvmServUrl.'Ajax/KsvmCategoriaAjax.php" method="POST" class="FormularioAjax" data-form="eliminar" enctype="multipart/form-data"> 
                                                   <a id="btn-detail" class="btn btn-sm btn-info" href="'.KsvmServUrl.'KsvmCategoriasCrud/Detail/'.KsvmEstMaestra::__KsvmEncriptacion($rows['CtgId']).'/"><i class="zmdi zmdi-card"></i></a>
                                                   <div class="mdl-tooltip" for="btn-detail">Detalles</div>
                                                   <a id="btn-edit" class="btn btn-sm btn-primary" href="'.KsvmServUrl.'KsvmCategoriasEditar/'.KsvmEstMaestra::__KsvmEncriptacion($rows['CtgId']).'/0/"><i class="zmdi zmdi-edit"></i></a>
                                                   <div class="mdl-tooltip" for="btn-edit">Editar</div>   
                                                   <input type="hidden" name="KsvmCodDelete" value="'.KsvmEstMaestra::__KsvmEncriptacion($rows['CtgId']).'">              
                                                   <button id="btn-delete" type="submit" class="btn btn-sm btn-danger"><i class="zmdi zmdi-delete"></i></button>
                                                   <div class="mdl-tooltip" for="btn-delete">Inhabilitar</div>
                                                   <div class="RespuestaAjax"></div>
                                                   </form>';
                                }elseif ($KsvmRol == 2){
                                    $KsvmTabla .= '<a id="btn-detail" class="btn btn-sm btn-info" href="'.KsvmServUrl.'KsvmCategoriasCrud/Detail/'.KsvmEstMaestra::__KsvmEncriptacion($rows['CtgId']).'/"><i class="zmdi zmdi-card"></i></a>
                                                    <div class="mdl-tooltip" for="btn-detail">Detalles</div>
                                                    <a id="btn-edit" class="btn btn-sm btn-primary" href="'.KsvmServUrl.'KsvmCategoriasEditar/'.KsvmEstMaestra::__KsvmEncriptacion($rows['CtgId']).'/1/"><i class="zmdi zmdi-edit"></i></a>
                                                    <div class="mdl-tooltip" for="btn-edit">Editar</div>';
                                }else{
                                    $KsvmTabla .= '<a id="btn-detail" class="btn btn-sm btn-info" href="'.KsvmServUrl.'KsvmCategoriasCrud/Detail/'.KsvmEstMaestra::__KsvmEncriptacion($rows['CtgId']).'/"><i class="zmdi zmdi-card"></i></a>
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
                echo '<script> window.location.href=" '.KsvmServUrl.'KsvmCategoriasCrud"</script>';
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
                    $KsvmTabla .= '<a class = "btn btn-xs btn-success mdl-shadow--8dp " href="'.KsvmServUrl.'KsvmCategoriasCrud/1/">Primero</a>
                                   <span></span>
                                   <a class = "btn btn-xs btn-default mdl-shadow--8dp " href="'.KsvmServUrl.'KsvmCategoriasCrud/'.($KsvmPagina-1).'/"><i class="zmdi zmdi-fast-rewind"></i></a>';
                }

                if ($KsvmPagina == $KsvmNPaginas) {
                    $KsvmTabla .= '<button class = "btn btn-xs btn-default mdl-shadow--8dp disabled"><i class="zmdi zmdi-fast-forward"></i></button>
                                   <span></span>
                                   <button class = "btn btn-xs btn-success mdl-shadow--8dp disabled">Último</button>';
                } else {
                    $KsvmTabla .= '<a class="btn btn-xs btn-default mdl-shadow--8dp" href="'.KsvmServUrl.'KsvmCategoriasCrud/'.($KsvmPagina+1).'/"><i class="zmdi zmdi-fast-forward"></i></a>
                                   <span></span>
                                   <a class="btn btn-xs btn-success mdl-shadow--8dp" href="'.KsvmServUrl.'KsvmCategoriasCrud/'.($KsvmNPaginas).'/">Último</a>';
                                   
                                   
                }
                
             
                $KsvmTabla .= '</nav></div>';                
            }
            
        
                                   
        return $KsvmTabla;
      }
     
      /**
       * Función que permite inhabilitar una Categoria 
       */
      public function __KsvmEliminarCategoriaControlador()
      {
         $KsvmCode = KsvmEstMaestra :: __KsvmDesencriptacion($_POST['KsvmCodDelete']);
         $KsvmCodCat = KsvmEstMaestra :: __KsvmFiltrarCadena($KsvmCode);

        $KsvmDelCat = KsvmCategoriaModelo :: __KsvmEliminarCategoriaModelo($KsvmCodCat);
        if ($KsvmDelCat->rowCount() == 1) {
            $KsvmAlerta = [
                "Alerta" => "Actualiza",
                "Titulo" => "Categoria Inhabilitado",
                "Cuerpo" => "El Categoria seleccionada ha sido inhabilitado con éxito",
                "Tipo" => "success"
                ];
             
         } else {
            $KsvmAlerta = [
                "Alerta" => "simple",
                "Titulo" => "Error inesperado",
                "Cuerpo" => "No es posible eliminar la categoría del sistema",
                "Tipo" => "info"
                ];
         }

         return KsvmEstMaestra :: __KsvmMostrarAlertas($KsvmAlerta);
      }
    
      /**
       * Función que permite editar una Categoria 
       */
      public function __KsvmEditarCategoriaControlador($KsvmCodCategoria)
      {
          $KsvmCodigo = KsvmEstMaestra :: __KsvmDesencriptacion($KsvmCodCategoria);

          return KsvmCategoriaModelo :: __KsvmEditarCategoriaModelo($KsvmCodigo);
      }
      
      /**
       * Función que permite contar una Categoria 
       */
      public function __KsvmContarCategoriaControlador()
      {
          return KsvmCategoriaModelo :: __KsvmContarCategoriaModelo(0);
      }

      /**
       * Función que permite imprimir una Categoría 
       */
      public function __KsvmImprimirCategoriaControlador()
      {
        return KsvmCategoriaModelo :: __KsvmImprimirCategoriaModelo();
      }

      /**
       * Función que permite actualizar una Categoria 
       */
      public function __KsvmActualizarCategoriaControlador()
      {
        $KsvmCodCat = KsvmEstMaestra :: __KsvmDesencriptacion($_POST['KsvmCodEdit']);
        $KsvmNomCat = KsvmEstMaestra :: __KsvmFiltrarCadena($_POST['KsvmNomCat']);
        $KsvmColorCat = KsvmEstMaestra :: __KsvmFiltrarCadena($_POST['KsvmColorCat']);

        $KsvmConsulta = "SELECT * FROM ksvmcategoria10 WHERE CtgId = '$KsvmCodCat'";
        $KsvmQuery = KsvmEstMaestra :: __KsvmEjecutaConsulta($KsvmConsulta);
        $KsvmDataCategoria = $KsvmQuery->fetch();

        if ($KsvmNomCat != $KsvmDataCategoria['CtgNomCat']) {
            $KsvmConsulta = "SELECT CtgNomCat FROM ksvmcategoria10 WHERE CtgNomCat = '$KsvmNomCat'";
            $KsvmQuery = KsvmEstMaestra :: __KsvmEjecutaConsulta($KsvmConsulta);
            if ($KsvmQuery->rowCount() >= 1) {
                $KsvmAlerta = [
                    "Alerta" => "Actualiza",
                    "Titulo" => "Error Inesperado",
                    "Cuerpo" => "La categoría ingresada ya se encuentra registrada, Por favor ingrese una categoría válida",
                    "Tipo" => "info"
                    ];
                    return KsvmEstMaestra :: __KsvmMostrarAlertas($KsvmAlerta);
                    exit();
            }
        }

        $KsvmActualCat = [
            "KsvmNomCat" => $KsvmNomCat,
            "KsvmColorCat" => $KsvmColorCat,
            "KsvmCodCategoria" => $KsvmCodCat
            ];

            $KsvmGuardarCat = KsvmCategoriaModelo :: __KsvmActualizarCategoriaModelo($KsvmActualCat);
                if ($KsvmGuardarCat->rowCount() >= 1) {
                    $KsvmAlerta = [
                    "Alerta" => "Actualiza",
                    "Titulo" => "Grandioso",
                    "Cuerpo" => "El Categoría se actualizó satisfactoriamente",
                    "Tipo" => "success"
                    ];
                } else {
                    $KsvmAlerta = [
                    "Alerta" => "simple",
                    "Titulo" => "Error inesperado",
                    "Cuerpo" => "No se a podido actualizar la información de la Categoría",
                    "Tipo" => "info"
                    ];
                }
                return KsvmEstMaestra :: __KsvmMostrarAlertas($KsvmAlerta);
         
        }

        public function __KsvmSeleccionarCategoria(){
            $KsvmSelectCat = "SELECT * FROM ksvmseleccionacategoria";

            $KsvmConsulta = KsvmEstMaestra :: __KsvmConexion();
            $KsvmQuery = $KsvmConsulta->query($KsvmSelectCat);
            $KsvmQuery = $KsvmQuery->fetchAll();
            
            foreach ($KsvmQuery as $row) {
                $KsvmListar .= '<option value="'.$row['CtgId'].'">'.$row['CtgNomCat'].'</option>';
            }
            return $KsvmListar;
        }
    
}
   
 