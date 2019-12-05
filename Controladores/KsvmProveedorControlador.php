<?php

  /**
   *Condicion para peticion Ajax
   */
   if ($KsvmPeticionAjax) {
       require_once "../Modelos/KsvmProveedorModelo.php";
   } else {
       require_once "./Modelos/KsvmProveedorModelo.php";
   }

   class KsvmProveedorControlador extends KsvmProveedorModelo
   {
     /**
      *Función que permite ingresar un Proveedor
      */
     public function __KsvmAgregarProveedorControlador()
     {
         if ($_POST['KsvmIdParroquia'] == "") {
            $KsvmCodProc = $_POST['KsvmIdPais'];
         } else {
            $KsvmCodProc = $_POST['KsvmIdParroquia'];
         }
         
         
         $KsvmPrcId = KsvmEstMaestra :: __KsvmFiltrarCadena($KsvmCodProc);
         $KsvmTipProv = KsvmEstMaestra :: __KsvmFiltrarCadena($_POST['KsvmTipProv']);
         $KsvmIdentProv = KsvmEstMaestra :: __KsvmFiltrarCadena($_POST['KsvmIdentProv']);
         $KsvmRazSocProv = KsvmEstMaestra :: __KsvmFiltrarCadena($_POST['KsvmRazSocProv']);
         $KsvmTelfProv = KsvmEstMaestra :: __KsvmFiltrarCadena($_POST['KsvmTelfProv']);
         $KsvmDirProv = KsvmEstMaestra :: __KsvmFiltrarCadena($_POST['KsvmDirProv']);
         $KsvmEmailProv = KsvmEstMaestra :: __KsvmFiltrarCadena($_POST['KsvmEmailProv']);
         $KsvmPerContProv = KsvmEstMaestra :: __KsvmFiltrarCadena($_POST['KsvmPerContProv']);
         $KsvmCarContProv = KsvmEstMaestra :: __KsvmFiltrarCadena($_POST['KsvmCarContProv']);

         $KsvmEmaProv = "";

         $KsvmIdentificacion = "SELECT PvdIdentProv FROM ksvmvistaproveedores WHERE PvdIdentProv ='$KsvmIdentProv'";
         $KsvmQuery = KsvmEstMaestra :: __KsvmEjecutaConsulta($KsvmIdentificacion);
         if ($KsvmQuery->rowCount() >= 1) {
            $KsvmAlerta = [
              "Alerta" => "simple",
              "Titulo" => "Error inesperado",
              "Cuerpo" => "El número de identificación ingresado ya se encuentra registrado, Por favor ingrese un número válido",
              "Tipo" => "info"
             ];
         } elseif ($KsvmEmailProv != "") {
              $KsvmEmailQ = "SELECT PvdEmailProv FROM ksvmvistaproveedores WHERE PvdEmailProv ='$KsvmEmailProv'";
              $KsvmQuery = KsvmEstMaestra :: __KsvmEjecutaConsulta($KsvmEmailQ);
              $KsvmEmaProv = $KsvmQuery->rowCount();
           }else{
               $KsvmEmaProv = 0;
           }
         
             if ($KsvmEmaProv >= 1) {
               $KsvmAlerta = [
               "Alerta" => "simple",
               "Titulo" => "Error inesperado",
               "Cuerpo" => "El Email ingresado ya se encuentra registrado, Por favor ingrese un Email válido",
               "Tipo" => "info"
              ];
             }else{
              $KsvmNuevoProv = [
                "KsvmPrcId" => $KsvmPrcId,
                "KsvmTipProv" => $KsvmTipProv,
                "KsvmIdentProv" => $KsvmIdentProv,
                "KsvmRazSocProv" => $KsvmRazSocProv,
                "KsvmTelfProv" => $KsvmTelfProv,
                "KsvmDirProv" => $KsvmDirProv,
                "KsvmEmailProv" => $KsvmEmailProv,
                "KsvmPerContProv" => $KsvmPerContProv,
                "KsvmCarContProv" => $KsvmCarContProv
                ];

                $KsvmGuardarProv = KsvmProveedorModelo :: __KsvmAgregarProveedorModelo($KsvmNuevoProv);
                if ($KsvmGuardarProv->rowCount() >= 1) {
                    $KsvmAlerta = [
                    "Alerta" => "Limpia",
                    "Titulo" => "Grandioso",
                    "Cuerpo" => "El Proveedor se registró satisfactoriamente",
                    "Tipo" => "success"
                    ];
                } else {
                    $KsvmAlerta = [
                    "Alerta" => "simple",
                    "Titulo" => "Error inesperado",
                    "Cuerpo" => "No se a podido registrar el Proveedor",
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
            $KsvmDataProv = "SELECT SQL_CALC_FOUND_ROWS * FROM ksvmvistaproveedores WHERE ((PvdEstProv = 'A') AND (PvdIdentProv LIKE '%$KsvmBuscar%' 
                          OR PvdRazSocProv LIKE '%$KsvmBuscar%' OR PvdEmailProv LIKE '%$KsvmBuscar%')) 
                          LIMIT $KsvmDesde, $KsvmNRegistros";
        } else {
            $KsvmDataProv = "SELECT SQL_CALC_FOUND_ROWS * FROM ksvmvistaproveedores WHERE PvdEstProv = 'A' LIMIT $KsvmDesde, $KsvmNRegistros" ;
        }
        

        $KsvmConsulta = KsvmEstMaestra :: __KsvmConexion();
    
        $KsvmQuery = $KsvmConsulta->query($KsvmDataProv);
        $KsvmQuery = $KsvmQuery->fetchAll();
        
        $KsvmDataTot = "SELECT FOUND_ROWS()";
        $KsvmTotalReg = $KsvmConsulta->query($KsvmDataTot);
        $KsvmTotalReg = (int) $KsvmTotalReg->fetchColumn();
        $KsvmNPaginas = ceil($KsvmTotalReg/$KsvmNRegistros);

        $KsvmTabla .= '<table class="mdl-data-table mdl-js-data-table mdl-shadow--6dp full-width table-responsive">
                        <thead>
                            <tr>
                                <th class="mdl-data-table__cell--non-numeric">#</th>
                                <th class="mdl-data-table__cell--non-numeric"># Identidad</th>
                                <th class="mdl-data-table__cell--non-numeric">Razón Social</th>
                                <th class="mdl-data-table__cell--non-numeric">Telf</th>
                                <th class="mdl-data-table__cell--non-numeric">Dirección</th>
                                <th class="mdl-data-table__cell--non-numeric">Email</th>
                                <th style="text-align:center; witdh:30px;">Acción</th>
                            </tr>
                        </thead>
                        <tbody>';

        if ($KsvmTotalReg >= 1 && $KsvmPagina <= $KsvmNPaginas) {
            $KsvmContReg = $KsvmDesde +1;
            foreach ($KsvmQuery as $rows) {
                $KsvmTabla .= '<tr>
                                <td class="mdl-data-table__cell--non-numeric">'.$KsvmContReg.'</td>
                                <td class="mdl-data-table__cell--non-numeric">'.$rows['PvdIdentProv'].'</td>
                                <td class="mdl-data-table__cell--non-numeric">'.$rows['PvdRazSocProv'].'</td>
                                <td class="mdl-data-table__cell--non-numeric">'.$rows['PvdTelfProv'].'</td>
                                <td class="mdl-data-table__cell--non-numeric">'.$rows['PvdDirProv'].'</td>
                                <td class="mdl-data-table__cell--non-numeric">'.$rows['PvdEmailProv'].'</td>
                                <td style="text-align:right; witdh:30px;">';
                                if ($KsvmRol == 1) {
                                    if ($KsvmCodigo == 0) {

                                    $KsvmTabla .= '<form action="'.KsvmServUrl.'Ajax/KsvmRequisicionAjax.php" method="POST" class="FormularioAjax" data-form="eliminar" enctype="multipart/form-data"> 
                                                <a id="btn-detail" class="btn btn-sm btn-info" href="'.KsvmServUrl.'KsvmProveedoresCrud/Detail/'.KsvmEstMaestra::__KsvmEncriptacion($rows['PvdId']).'/"><i class="zmdi zmdi-card"></i></a>
                                                <div class="mdl-tooltip" for="btn-detail">Detalles</div>
                                                <a id="btn-edit" class="btn btn-sm btn-primary" href="'.KsvmServUrl.'KsvmProveedoresEditar/'.KsvmEstMaestra::__KsvmEncriptacion($rows['PvdId']).'/0/"><i class="zmdi zmdi-edit"></i></a>
                                                <div class="mdl-tooltip" for="btn-edit">Editar</div>
                                                <input type="hidden" name="KsvmCodDelete" value="'.KsvmEstMaestra::__KsvmEncriptacion($rows['PvdId']).'">              
                                                <button id="btn-delete" type="submit" class="btn btn-sm btn-danger"><i class="zmdi zmdi-delete"></i></button>
                                                <div class="mdl-tooltip" for="btn-delete">Inhabilitar</div>
                                                <div class="RespuestaAjax"></div>
                                                </form>';
                                    } else {
                                    $KsvmTabla .= '<form action="'.KsvmServUrl.'Ajax/KsvmRequisicionAjax.php" method="POST" class="FormularioAjax" data-form="eliminar" enctype="multipart/form-data"> 
                                                    <a id="btn-detail" class="btn btn-sm btn-info" href="'.KsvmServUrl.'KsvmProveedores/Detail/'.KsvmEstMaestra::__KsvmEncriptacion($rows['PvdId']).'"><i class="zmdi zmdi-card"></i></a>
                                                    <div class="mdl-tooltip" for="btn-detail">Detalles</div>
                                                    <a id="btn-edit" class="btn btn-sm btn-primary" href="'.KsvmServUrl.'KsvmProveedoresEditar/'.KsvmEstMaestra::__KsvmEncriptacion($rows['PvdId']).'/1/"><i class="zmdi zmdi-edit"></i></a>
                                                    <div class="mdl-tooltip" for="btn-edit">Editar</div>
                                                    <input type="hidden" name="KsvmCodDelete" value="'.KsvmEstMaestra::__KsvmEncriptacion($rows['PvdId']).'">              
                                                    <button id="btn-delete" type="submit" class="btn btn-sm btn-danger"><i class="zmdi zmdi-delete"></i></button>
                                                    <div class="mdl-tooltip" for="btn-delete">Inhabilitar</div>
                                                    <div class="RespuestaAjax"></div>
                                                    </form>';
                                    }
                                }elseif ($KsvmRol == 2 || $KsvmRol == 3){
                                    $KsvmTabla .= '<a id="btn-detail" class="btn btn-sm btn-info" href="'.KsvmServUrl.'KsvmProveedores/Detail/'.KsvmEstMaestra::__KsvmEncriptacion($rows['PvdId']).'/"><i class="zmdi zmdi-card"></i></a>
                                                    <div class="mdl-tooltip" for="btn-detail">Detalles</div>
                                                    <a id="btn-edit" class="btn btn-sm btn-primary" href="'.KsvmServUrl.'KsvmProveedoresEditar/'.KsvmEstMaestra::__KsvmEncriptacion($rows['PvdId']).'/1/"><i class="zmdi zmdi-edit"></i></a>
                                                    <div class="mdl-tooltip" for="btn-edit">Editar</div>';
                                }else{
                                    $KsvmTabla .= '<a id="btn-detail" class="btn btn-sm btn-info" href="'.KsvmServUrl.'KsvmProveedores/Detail/'.KsvmEstMaestra::__KsvmEncriptacion($rows['PvdId']).'/"><i class="zmdi zmdi-card"></i></a>
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
                echo '<script> window.location.href=" '.KsvmServUrl.'KsvmProveedoresCrud"</script>';
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
                    $KsvmTabla .= '<a class = "btn btn-xs btn-success mdl-shadow--8dp " href="'.KsvmServUrl.'KsvmProveedoresCrud/1/">Primero</a>
                                   <span></span>
                                   <a class = "btn btn-xs btn-default mdl-shadow--8dp " href="'.KsvmServUrl.'KsvmProveedoresCrud/'.($KsvmPagina-1).'/"><i class="zmdi zmdi-fast-rewind"></i></a>';
                }

                if ($KsvmPagina == $KsvmNPaginas) {
                    $KsvmTabla .= '<button class = "btn btn-xs btn-default mdl-shadow--8dp disabled"><i class="zmdi zmdi-fast-forward"></i></button>
                                   <span></span>
                                   <button class = "btn btn-xs btn-success mdl-shadow--8dp disabled">Último</button>';
                } else {
                    $KsvmTabla .= '<a class="btn btn-xs btn-default mdl-shadow--8dp" href="'.KsvmServUrl.'KsvmProveedoresCrud/'.($KsvmPagina+1).'/"><i class="zmdi zmdi-fast-forward"></i></a>
                                   <span></span>
                                   <a class="btn btn-xs btn-success mdl-shadow--8dp" href="'.KsvmServUrl.'KsvmProveedoresCrud/'.($KsvmNPaginas).'/">Último</a>';
                                   
                                   
                }
                
             
                $KsvmTabla .= '</nav></div>';         

            } else {
                $KsvmTabla .= '<nav class="navbar-form navbar-right form-group">';
                
                if ($KsvmPagina == 1) {
                    $KsvmTabla .= '<button class = "btn btn-xs btn-success mdl-shadow--8dp disabled">Primero</button>
                                   <span></span>
                                   <button class = "btn btn-xs btn-default mdl-shadow--8dp disabled"><i class="zmdi zmdi-fast-rewind"></i></button>';
                } else {
                    $KsvmTabla .= '<a class = "btn btn-xs btn-success mdl-shadow--8dp " href="'.KsvmServUrl.'KsvmProveedores/1/">Primero</a>
                                   <span></span>
                                   <a class = "btn btn-xs btn-default mdl-shadow--8dp " href="'.KsvmServUrl.'KsvmProveedores/'.($KsvmPagina-1).'/"><i class="zmdi zmdi-fast-rewind"></i></a>';
                }

                if ($KsvmPagina == $KsvmNPaginas) {
                    $KsvmTabla .= '<button class = "btn btn-xs btn-default mdl-shadow--8dp disabled"><i class="zmdi zmdi-fast-forward"></i></button>
                                   <span></span>
                                   <button class = "btn btn-xs btn-success mdl-shadow--8dp disabled">Último</button>';
                } else {
                    $KsvmTabla .= '<a class="btn btn-xs btn-default mdl-shadow--8dp" href="'.KsvmServUrl.'KsvmProveedores/'.($KsvmPagina+1).'/"><i class="zmdi zmdi-fast-forward"></i></a>
                                   <span></span>
                                   <a class="btn btn-xs btn-success mdl-shadow--8dp" href="'.KsvmServUrl.'KsvmProveedores/'.($KsvmNPaginas).'/">Último</a>';
                                   
                                   
                }
                
                $KsvmTabla .= '</nav></div>'; 
            }
            
        
                                   
        return $KsvmTabla;
      }
     
      /**
       * Función que permite inhabilitar un Proveedor 
       */
      public function __KsvmEliminarProveedorControlador()
      {
         $KsvmCode = KsvmEstMaestra :: __KsvmDesencriptacion($_POST['KsvmCodDelete']);
         $KsvmCodProveedor = KsvmEstMaestra :: __KsvmFiltrarCadena($KsvmCode);

         $KsvmDelProv = KsvmProveedorModelo :: __KsvmEliminarProveedorModelo($KsvmCodProveedor);
         if ($KsvmDelProv->rowCount() == 1) {
            $KsvmAlerta = [
                "Alerta" => "Actualiza",
                "Titulo" => "Proveedor Inhabilitado",
                "Cuerpo" => "El Proveedor seleccionado ha sido inhabilitado con éxito",
                "Tipo" => "success"
                ];
        
         } else {
            $KsvmAlerta = [
                "Alerta" => "simple",
                "Titulo" => "Error inesperado",
                "Cuerpo" => "No es posible eliminar el Proveedor del sistema",
                "Tipo" => "info"
                ];
         }

         return KsvmEstMaestra :: __KsvmMostrarAlertas($KsvmAlerta);
      }
    
      /**
       * Función que permite editar un Proveedor 
       */
      public function __KsvmEditarProveedorControlador($KsvmCodProveedor)
      {
          $KsvmCodigo = KsvmEstMaestra :: __KsvmDesencriptacion($KsvmCodProveedor);

          return KsvmProveedorModelo :: __KsvmEditarProveedorModelo($KsvmCodigo);
      }
      
      /**
       * Función que permite contar un Proveedor 
       */
      public function __KsvmContarProveedorControlador()
      {
          return KsvmProveedorModelo :: __KsvmContarProveedorModelo(0);
      }

      /**
       * Función que permite actualizar un Proveedor 
       */
      public function __KsvmActualizarProveedorControlador()
      {
        $KsvmCodProveedor = KsvmEstMaestra :: __KsvmDesencriptacion($_POST['KsvmCodEdit']);
        
        if ($_POST['KsvmIdParroquia'] == "") {
            $KsvmCodProc = $_POST['KsvmIdPais'];
         } else {
            $KsvmCodProc = $_POST['KsvmIdParroquia'];
         }
         
         
         $KsvmPrcId = KsvmEstMaestra :: __KsvmFiltrarCadena($KsvmCodProc);
        $KsvmTipProv = KsvmEstMaestra :: __KsvmFiltrarCadena($_POST['KsvmTipProv']);
        $KsvmIdentProv = KsvmEstMaestra :: __KsvmFiltrarCadena($_POST['KsvmIdentProv']);
        $KsvmRazSocProv = KsvmEstMaestra :: __KsvmFiltrarCadena($_POST['KsvmRazSocProv']);
        $KsvmTelfProv = KsvmEstMaestra :: __KsvmFiltrarCadena($_POST['KsvmTelfProv']);
        $KsvmDirProv = KsvmEstMaestra :: __KsvmFiltrarCadena($_POST['KsvmDirProv']);
        $KsvmEmailProv = KsvmEstMaestra :: __KsvmFiltrarCadena($_POST['KsvmEmailProv']);
        $KsvmPerContProv = KsvmEstMaestra :: __KsvmFiltrarCadena($_POST['KsvmPerContProv']);
        $KsvmCarContProv = KsvmEstMaestra :: __KsvmFiltrarCadena($_POST['KsvmCarContProv']);

        $KsvmConsulta = "SELECT * FROM ksvmvistaproveedores WHERE PvdId = '$KsvmCodProveedor'";
        $KsvmQuery = KsvmEstMaestra :: __KsvmEjecutaConsulta($KsvmConsulta);
        $KsvmDataProveedor = $KsvmQuery->fetch();

        if ($KsvmIdent != $KsvmDataProveedor['PvdIdentEmp']) {
            $KsvmConsulta = "SELECT PvdIdentProv FROM ksvmvistaproveedores WHERE PvdIdentProv = '$KsvmIdentProv'";
            $KsvmQuery = KsvmEstMaestra :: __KsvmEjecutaConsulta($KsvmConsulta);
            if ($KsvmQuery->rowCount() >= 1) {
                $KsvmAlerta = [
                    "Alerta" => "Actualiza",
                    "Titulo" => "Error Inesperado",
                    "Cuerpo" => "El número de identificación ingresado ya se encuentra registrado, Por favor ingrese un número válido",
                    "Tipo" => "info"
                    ];
                    return KsvmEstMaestra :: __KsvmMostrarAlertas($KsvmAlerta);
                    exit();
            }
        }

        $KsvmActualProv = [
            "KsvmPrcId" => $KsvmPrcId,
            "KsvmTipProv" => $KsvmTipProv,
            "KsvmIdentProv" => $KsvmIdentProv,
            "KsvmRazSocProv" => $KsvmRazSocProv,
            "KsvmTelfProv" => $KsvmTelfProv,
            "KsvmDirProv" => $KsvmDirProv,
            "KsvmEmailProv" => $KsvmEmailProv,
            "KsvmPerContProv" => $KsvmPerContProv,
            "KsvmCarContProv" => $KsvmCarContProv,
            "KsvmCodProveedor" => $KsvmCodProveedor
            ];

            $KsvmGuardarProv = KsvmProveedorModelo :: __KsvmActualizarProveedorModelo($KsvmActualProv);
                if ($KsvmGuardarProv->rowCount() >= 1) {
                    $KsvmAlerta = [
                    "Alerta" => "Actualiza",
                    "Titulo" => "Grandioso",
                    "Cuerpo" => "El Proveedor se actualizó satisfactoriamente",
                    "Tipo" => "success"
                    ];
                } else {
                    $KsvmAlerta = [
                    "Alerta" => "simple",
                    "Titulo" => "Error inesperado",
                    "Cuerpo" => "No se a podido actualizar la información del Proveedor",
                    "Tipo" => "info"
                    ];
                }
                return KsvmEstMaestra :: __KsvmMostrarAlertas($KsvmAlerta);
         
        }

        public function __KsvmSeleccionarProveedor(){
            $KsvmSelectProv = "SELECT * FROM ksvmseleccionaproveedor";

            $KsvmConsulta = KsvmEstMaestra :: __KsvmConexion();
            $KsvmQuery = $KsvmConsulta->query($KsvmSelectProv);
            $KsvmQuery = $KsvmQuery->fetchAll();

            foreach ($KsvmQuery as $row) {
                $KsvmListar .= '<option value="'.$row['PvdId'].'">'.$row['PvdRazSocProv'].'</option>';
            }
            return $KsvmListar;
        }
        
}
   
 