<?php

  /**
   *Condicion para peticion Ajax
   */
   if ($KsvmPeticionAjax) {
       require_once "../Modelos/KsvmPreciosXProveedorModelo.php";
   } else {
       require_once "./Modelos/KsvmPreciosXProveedorModelo.php";
   }

   class KsvmPreciosXProveedorControlador extends KsvmPreciosXProveedorModelo
   {
     /**
      *Función que permite ingresar Precios
      */
     public function __KsvmAgregarPreciosXProveedorControlador()
     {
         $KsvmPvdId = KsvmEstMaestra :: __KsvmFiltrarCadena($_POST['KsvmPvdId']);
         $KsvmMdcId = KsvmEstMaestra :: __KsvmFiltrarCadena($_POST['KsvmMdcId']);
         $KsvmValorUntPre = KsvmEstMaestra :: __KsvmFiltrarCadena($_POST['KsvmValorUntPre']);

              $KsvmNuevoPrecio = [
                "KsvmPvdId" => $KsvmPvdId,
                "KsvmMdcId" => $KsvmMdcId,
                "KsvmValorUntPre" => $KsvmValorUntPre,
                ];

                $KsvmGuardarPrecio = KsvmPreciosXProveedorModelo :: __KsvmAgregarPreciosXProveedorModelo($KsvmNuevoPrecio);
                if ($KsvmGuardarPrecio->rowCount() >= 1) {
                    $KsvmAlerta = [
                    "Alerta" => "Actualiza",
                    "Titulo" => "Grandioso",
                    "Cuerpo" => "El Precio se registró satisfactoriamente",
                    "Tipo" => "success"
                    ];
                } else {
                    $KsvmAlerta = [
                    "Alerta" => "simple",
                    "Titulo" => "Error inesperado",
                    "Cuerpo" => "No se a podido registrar el Precio",
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
            $KsvmDataAle = "SELECT SQL_CALC_FOUND_ROWS * FROM ksvmvistapreciosprov WHERE (MdcDescMed LIKE '%$KsvmBuscar%' 
                           OR PvdRazSocProv LIKE '%$KsvmBuscar%') LIMIT $KsvmDesde, $KsvmNRegistros";
        } else {
            $KsvmDataAle = "SELECT SQL_CALC_FOUND_ROWS * FROM ksvmvistapreciosprov LIMIT $KsvmDesde, $KsvmNRegistros" ;
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
                                <th class="mdl-data-table__cell--non-numeric">Proveedor</th>
                                <th class="mdl-data-table__cell--non-numeric">Medicamento</th>
                                <th class="mdl-data-table__cell--non-numeric">Concentracion</th>
                                <th class="mdl-data-table__cell--non-numeric">ValorUnitario</th>
                                <th style="text-align:center; witdh:30px;">Acción</th>
                            </tr>
                        </thead>
                        <tbody>';

        if ($KsvmTotalReg >= 1 && $KsvmPagina <= $KsvmNPaginas) {
            $KsvmContReg = $KsvmDesde +1;
            foreach ($KsvmQuery as $rows) {
                $KsvmTabla .= '<tr>
                                <td class="mdl-data-table__cell--non-numeric">'.$KsvmContReg.'</td>
                                <td class="mdl-data-table__cell--non-numeric">'.$rows['PvdRazSocProv'].'</td>
                                <td class="mdl-data-table__cell--non-numeric">'.$rows['MdcDescMed'].'</td>
                                <td class="mdl-data-table__cell--non-numeric">'.$rows['MdcConcenMed'].'</td>
                                <td class="mdl-data-table__cell--non-numeric">'.$rows['PprValorUntPre'].'</td>
                                <td style="text-align:right; witdh:30px;">';
                                if ($KsvmRol == 1) {
                                    if ($KsvmCodigo == 0) {

                                    $KsvmTabla .=  '<form action="'.KsvmServUrl.'Ajax/KsvmPreciosXProveedorAjax.php" method="POST" class="FormularioAjax" data-form="eliminar" enctype="multipart/form-data"> 
                                                    <a id="btn-detail" class="btn btn-sm btn-info" href="'.KsvmServUrl.'KsvmPreciosXProveedorCrud/Detail/'.KsvmEstMaestra::__KsvmEncriptacion($rows['PprId']).'/"><i class="zmdi zmdi-card"></i></a>
                                                    <div class="mdl-tooltip" for="btn-detail">Detalles</div>
                                                    <a id="btn-edit" class="btn btn-sm btn-primary" href="'.KsvmServUrl.'KsvmPreciosXProveedorEditar/'.KsvmEstMaestra::__KsvmEncriptacion($rows['PprId']).'/0/"><i class="zmdi zmdi-edit"></i></a>
                                                    <div class="mdl-tooltip" for="btn-edit">Editar</div>
                                                    <input type="hidden" name="KsvmCodDelete" value="'.KsvmEstMaestra::__KsvmEncriptacion($rows['PprId']).'">              
                                                    <button id="btn-delete" type="submit" class="btn btn-sm btn-danger"><i class="zmdi zmdi-delete"></i></button>
                                                    <div class="RespuestaAjax"></div>
                                                    </form>';
                                    } else {
                                    $KsvmTabla .= '<form action="'.KsvmServUrl.'Ajax/KsvmPreciosXProveedorAjax.php" method="POST" class="FormularioAjax" data-form="eliminar" enctype="multipart/form-data"> 
                                                    <a id="btn-detail" class="btn btn-sm btn-info" href="'.KsvmServUrl.'KsvmPreciosXProveedor/Detail/'.KsvmEstMaestra::__KsvmEncriptacion($rows['PprId']).'"><i class="zmdi zmdi-card"></i></a>
                                                    <div class="mdl-tooltip" for="btn-detail">Detalles</div>
                                                    <a id="btn-edit" class="btn btn-sm btn-primary" href="'.KsvmServUrl.'KsvmPreciosXProveedorEditar/'.KsvmEstMaestra::__KsvmEncriptacion($rows['PprId']).'/1/"><i class="zmdi zmdi-edit"></i></a>
                                                    <div class="mdl-tooltip" for="btn-edit">Editar</div>
                                                    <input type="hidden" name="KsvmCodDelete" value="'.KsvmEstMaestra::__KsvmEncriptacion($rows['PprId']).'">              
                                                    <button id="btn-delete" type="submit" class="btn btn-sm btn-danger"><i class="zmdi zmdi-delete"></i></button>
                                                    <div class="mdl-tooltip" for="btn-delete">Inhabilitar</div>
                                                    <div class="RespuestaAjax"></div>
                                                    </form>'; 
                                    }
                                }elseif ($KsvmRol == 2 || $KsvmRol == 3){
                                    $KsvmTabla .= '<a id="btn-detail" class="btn btn-sm btn-info" href="'.KsvmServUrl.'KsvmPreciosXProveedor/Detail/'.KsvmEstMaestra::__KsvmEncriptacion($rows['PprId']).'/"><i class="zmdi zmdi-card"></i></a>
                                                    <div class="mdl-tooltip" for="btn-detail">Detalles</div>
                                                    <a id="btn-edit" class="btn btn-sm btn-primary" href="'.KsvmServUrl.'KsvmPreciosXProveedorEditar/'.KsvmEstMaestra::__KsvmEncriptacion($rows['PprId']).'/1/"><i class="zmdi zmdi-edit"></i></a>
                                                    <div class="mdl-tooltip" for="btn-edit">Editar</div>';
                                }else{
                                    $KsvmTabla .= '<a id="btn-detail" class="btn btn-sm btn-info" href="'.KsvmServUrl.'KsvmPreciosXProveedor/Detail/'.KsvmEstMaestra::__KsvmEncriptacion($rows['PprId']).'/"><i class="zmdi zmdi-card"></i></a>
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
                echo '<script> window.location.href=" '.KsvmServUrl.'KsvmPreciosXProveedorCrud/1/"</script>';
            }elseif ($KsvmTotalReg >= 1 && $KsvmCodigo == 1){
                echo '<script> window.location.href=" '.KsvmServUrl.'KsvmPreciosXProveedor/1/"</script>';
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
                    $KsvmTabla .= '<a class = "btn btn-xs btn-success mdl-shadow--8dp " href="'.KsvmServUrl.'KsvmPreciosXProveedorCrud/1/">Primero</a>
                                   <span></span>
                                   <a class = "btn btn-xs btn-default mdl-shadow--8dp " href="'.KsvmServUrl.'KsvmPreciosXProveedorCrud/'.($KsvmPagina-1).'/"><i class="zmdi zmdi-fast-rewind"></i></a>';
                }

                if ($KsvmPagina == $KsvmNPaginas) {
                    $KsvmTabla .= '<button class = "btn btn-xs btn-default mdl-shadow--8dp disabled"><i class="zmdi zmdi-fast-forward"></i></button>
                                   <span></span>
                                   <button class = "btn btn-xs btn-success mdl-shadow--8dp disabled">Último</button>';
                } else {
                    $KsvmTabla .= '<a class="btn btn-xs btn-default mdl-shadow--8dp" href="'.KsvmServUrl.'KsvmPreciosXProveedorCrud/'.($KsvmPagina+1).'/"><i class="zmdi zmdi-fast-forward"></i></a>
                                   <span></span>
                                   <a class="btn btn-xs btn-success mdl-shadow--8dp" href="'.KsvmServUrl.'KsvmPreciosXProveedorCrud/'.($KsvmNPaginas).'/">Último</a>';
                                               
                }
                
             
                $KsvmTabla .= '</nav></div>';   

            } elseif($KsvmTotalReg >= 1 && $KsvmPagina <= $KsvmNPaginas && $KsvmCodigo == 1) {
                $KsvmTabla .= '<nav class="navbar-form navbar-right form-group">';
                
                if ($KsvmPagina == 1) {
                    $KsvmTabla .= '<button class = "btn btn-xs btn-success mdl-shadow--8dp disabled">Primero</button>
                                   <span></span>
                                   <button class = "btn btn-xs btn-default mdl-shadow--8dp disabled"><i class="zmdi zmdi-fast-rewind"></i></button>';
                } else {
                    $KsvmTabla .= '<a class = "btn btn-xs btn-success mdl-shadow--8dp " href="'.KsvmServUrl.'KsvmPreciosXProveedor/1/">Primero</a>
                                   <span></span>
                                   <a class = "btn btn-xs btn-default mdl-shadow--8dp " href="'.KsvmServUrl.'KsvmPreciosXProveedor/'.($KsvmPagina-1).'/"><i class="zmdi zmdi-fast-rewind"></i></a>';
                }

                if ($KsvmPagina == $KsvmNPaginas) {
                    $KsvmTabla .= '<button class = "btn btn-xs btn-default mdl-shadow--8dp disabled"><i class="zmdi zmdi-fast-forward"></i></button>
                                   <span></span>
                                   <button class = "btn btn-xs btn-success mdl-shadow--8dp disabled">Último</button>';
                } else {
                    $KsvmTabla .= '<a class="btn btn-xs btn-default mdl-shadow--8dp" href="'.KsvmServUrl.'KsvmPreciosXProveedor/'.($KsvmPagina+1).'/"><i class="zmdi zmdi-fast-forward"></i></a>
                                   <span></span>
                                   <a class="btn btn-xs btn-success mdl-shadow--8dp" href="'.KsvmServUrl.'KsvmPreciosXProveedor/'.($KsvmNPaginas).'/">Último</a>';
                                   
                                   
                }
                
                $KsvmTabla .= '</nav></div>'; 
            }
            
        
                                   
        return $KsvmTabla;
      }
     
      /**
       * Función que permite inhabilitar Precios
       */
      public function __KsvmEliminarPreciosXProveedorControlador()
      {
         $KsvmCode = KsvmEstMaestra :: __KsvmDesencriptacion($_POST['KsvmCodDelete']);
         $KsvmCodePrecio = KsvmEstMaestra :: __KsvmFiltrarCadena($KsvmCode);

         $KsvmDelPrecio = KsvmPreciosXProveedorModelo :: __KsvmEliminarPreciosXProveedorModelo($KsvmCodePrecio);
         if ($KsvmDelPrecio->rowCount() == 1) {
            $KsvmAlerta = [
                "Alerta" => "Actualiza",
                "Titulo" => "Precio Inhabilitado",
                "Cuerpo" => "El Precio seleccionado ha sido inhabilitado con éxito",
                "Tipo" => "success"
                ];
         } else {
            $KsvmAlerta = [
                "Alerta" => "simple",
                "Titulo" => "Error inesperado",
                "Cuerpo" => "No es posible eliminar el Precio seleccionada",
                "Tipo" => "info"
                ];
         }

         return KsvmEstMaestra :: __KsvmMostrarAlertas($KsvmAlerta);
      }
    
      /**
       * Función que permite editar Precios 
       */
      public function __KsvmEditarPreciosXProveedorControlador($KsvmCodEditar)
      {
          $KsvmCodPrecio = KsvmEstMaestra :: __KsvmDesencriptacion($KsvmCodEditar);

          return KsvmPreciosXProveedorModelo :: __KsvmEditarPreciosXProveedorModelo($KsvmCodPrecio);
      }
      
      /**
       * Función que permite contar Precios 
       */
      public function __KsvmContarPreciosXProveedorControlador()
      {
          return KsvmPreciosXProveedorModelo :: __KsvmContarPreciosXProveedorModelo(0);
      }

      /**
       * Función que permite imprimir un Precio 
       */
      public function __KsvmImprimirPreciosXProveedorControlador()
      {
        return KsvmPreciosXProveedorModelo :: __KsvmImprimirPreciosXProveedorModelo();
      }

      /**
       * Función que permite actualizar Precios 
       */
      public function __KsvmActualizarPreciosXProveedorControlador()
      {
        $KsvmCodPrecio = KsvmEstMaestra :: __KsvmDesencriptacion($_POST['KsvmCodEdit']);
        $KsvmPvdId = KsvmEstMaestra :: __KsvmFiltrarCadena($_POST['KsvmPvdId']);
        $KsvmMdcId = KsvmEstMaestra :: __KsvmFiltrarCadena($_POST['KsvmMdcId']);
        $KsvmValorUntPre = KsvmEstMaestra :: __KsvmFiltrarCadena($_POST['KsvmValorUntPre']);

        $KsvmConsulta = "SELECT * FROM ksvmvistapreciosprov WHERE PprId = '$KsvmCodPrecio'";
        $KsvmQuery = KsvmEstMaestra :: __KsvmEjecutaConsulta($KsvmConsulta);
        $KsvmDataPrecios = $KsvmQuery->fetch();

        $KsvmActualPrecio = [
            "KsvmPvdId" => $KsvmPvdId,
            "KsvmMdcId" => $KsvmMdcId,
            "KsvmValorUntPre" => $KsvmValorUntPre,
            "KsvmCodPrecio" => $KsvmCodPrecio
            ];

            $KsvmGuardarPrecio = KsvmPreciosXProveedorModelo :: __KsvmActualizarPreciosXProveedorModelo($KsvmActualPrecio);
                if ($KsvmGuardarPrecio->rowCount() >= 1) {
                    $KsvmAlerta = [
                    "Alerta" => "Actualiza",
                    "Titulo" => "Grandioso",
                    "Cuerpo" => "El Precio se actualizó satisfactoriamente",
                    "Tipo" => "success"
                    ];
                } else {
                    $KsvmAlerta = [
                    "Alerta" => "simple",
                    "Titulo" => "Error inesperado",
                    "Cuerpo" => "No se a podido actualizar la información del Precio",
                    "Tipo" => "info"
                    ];
                }
                return KsvmEstMaestra :: __KsvmMostrarAlertas($KsvmAlerta);
         
        }
    
}
   
 