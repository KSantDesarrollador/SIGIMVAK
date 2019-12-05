<?php

  /**
   *Condicion para peticion Ajax
   */
   if ($KsvmPeticionAjax) {
       require_once "../Modelos/KsvmInventarioModelo.php";
   } else {
       require_once "./Modelos/KsvmInventarioModelo.php";
   }

   class KsvmInventarioControlador extends KsvmInventarioModelo
   {
     /**
      *Función que permite ingresar un Inventario
      */
     public function __KsvmAgregarInventarioControlador()
     {
         $KsvmBdgId = KsvmEstMaestra :: __KsvmFiltrarCadena($_POST['KsvmBdgId']);
         $KsvmDuracionInv = KsvmEstMaestra :: __KsvmFiltrarCadena($_POST['KsvmDuracionInv']);

         $KsvmInventario = "SELECT  IvtId FROM ksvmvistainventarios";
         $KsvmQuery = KsvmEstMaestra :: __KsvmEjecutaConsulta($KsvmInventario);
         $KsvmNum = ($KsvmQuery->rowCount())+1;

         $KsvmCodInv = KsvmEstMaestra :: __KsvmGeneraCodigoAleatorio("INV", 6, $KsvmNum);
        
         $KsvmFchElabInv = date("Y-m-d");
         $KsvmHoraInv = date("h:i:s a");

         session_start(['name' => 'SIGIM']);
            $KsvmUser = $_SESSION['KsvmUsuId-SIGIM'];
            $KsvmElabora = "SELECT concat(EpoPriApeEmp,' ',EpoSegApeEmp,' ',EpoPriNomEmp,' ',EpoSegNomEmp) as PerElab FROM ksvmvistaempleado WHERE UsrId = '$KsvmUser'";
            $KsvmQuery = KsvmEstMaestra :: __KsvmConexion()->query($KsvmElabora);
         
         if ($KsvmQuery->rowCount() == 1) {
            $KsvmPerElab = $KsvmQuery->fetch();
            $KsvmPerElabInv = $KsvmPerElab['PerElab'];
         } else {
            $KsvmAlerta = [
                "Alerta" => "simple",
                "Titulo" => "Error inesperado",
                "Cuerpo" => "No se a podido verificar el usuario",
                "Tipo" => "info"
                ];
         }

              $KsvmNuevoInv = [
                "KsvmBdgId" => $KsvmBdgId,
                "KsvmCodInv" => $KsvmCodInv,
                "KsvmPerElabInv" => $KsvmPerElabInv,
                "KsvmFchElabInv" => $KsvmFchElabInv,
                "KsvmHoraInv" => $KsvmHoraInv, 
                "KsvmDuracionInv" => $KsvmDuracionInv
                ];

                $KsvmGuardarInv = KsvmInventarioModelo :: __KsvmAgregarInventarioModelo($KsvmNuevoInv);
                if ($KsvmGuardarInv->rowCount() == 1) {
                    $KsvmAlerta = [
                    "Alerta" => "Actualiza",
                    "Titulo" => "Grandioso",
                    "Cuerpo" => "El Inventario se registró satisfactoriamente",
                    "Tipo" => "success"
                    ];
                } else {
                    $KsvmAlerta = [
                    "Alerta" => "simple",
                    "Titulo" => "Error inesperado",
                    "Cuerpo" => "No se a podido registrar el Inventario",
                    "Tipo" => "info"
                    ];
                }
                
            return KsvmEstMaestra :: __KsvmMostrarAlertas($KsvmAlerta);
        }

     /**
      *Función que permite ingresar una Detalle de Compra
      */
    public function __KsvmAgregarDetalleInventarioControlador()
    {
        $KsvmExtId = KsvmEstMaestra :: __KsvmFiltrarCadena($_POST['KsvmExtId']);
        $KsvmStockInv = KsvmEstMaestra :: __KsvmFiltrarCadena($_POST['KsvmStockInv']);
        $KsvmContFisInv = KsvmEstMaestra :: __KsvmFiltrarCadena($_POST['KsvmContFisInv']);
        $KsvmObservInv = KsvmEstMaestra :: __KsvmFiltrarCadena($_POST['KsvmObservInv']);

        $KsvmDifInv = $KsvmStockInv-$KsvmContFisInv;

        $KsvmNuevoDetalleInv = [
            "KsvmExtId" => $KsvmExtId,
            "KsvmStockInv" => $KsvmStockInv,
            "KsvmContFisInv" => $KsvmContFisInv,
            "KsvmDifInv" => $KsvmDifInv,
            "KsvmObservInv" => $KsvmObservInv

           ];

           $KsvmGuardarDetInv = KsvmInventarioModelo :: __KsvmAgregarDetalleInventarioModelo($KsvmNuevoDetalleInv);
                if ($KsvmGuardarDetInv->rowCount() >= 1) {
                    $KsvmResult = "true";
                } else {
                    $KsvmAlerta = [
                    "Alerta" => "simple",
                    "Titulo" => "Error inesperado",
                    "Cuerpo" => "No se a podido registrar el Pedido",
                    "Tipo" => "info"
                    ];
                    $KsvmResult = "false";
                }
                return $KsvmResult;

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
            $KsvmDataInv = "SELECT SQL_CALC_FOUND_ROWS * FROM ksvmvistainventarios WHERE (IvtCodInv LIKE '%$KsvmBuscar%' 
                          OR IvtPerElabInv LIKE '%$KsvmBuscar%' OR BdgDescBod LIKE '%$KsvmBuscar%'OR IvtFchElabInv LIKE '%$KsvmBuscar%')
                          LIMIT $KsvmDesde, $KsvmNRegistros";
        } else {
            $KsvmDataInv = "SELECT SQL_CALC_FOUND_ROWS * FROM ksvmvistainventarios LIMIT $KsvmDesde, $KsvmNRegistros" ;
        }
        

        $KsvmConsulta = KsvmEstMaestra :: __KsvmConexion();
    
        $KsvmQuery = $KsvmConsulta->query($KsvmDataInv);
        $KsvmQuery = $KsvmQuery->fetchAll();
        
        $KsvmDataTot = "SELECT FOUND_ROWS()";
        $KsvmTotalReg = $KsvmConsulta->query($KsvmDataTot);
        $KsvmTotalReg = (int) $KsvmTotalReg->fetchColumn();
        $KsvmNPaginas = ceil($KsvmTotalReg/$KsvmNRegistros);

        $KsvmTabla .= '<table class="mdl-data-table mdl-js-data-table mdl-shadow--6dp full-width table-responsive">
                        <thead>
                            <tr>
                                <th class="mdl-data-table__cell--non-numeric">#</th>
                                <th class="mdl-data-table__cell--non-numeric">Cod.Inv</th>
                                <th class="mdl-data-table__cell--non-numeric">Fecha</th>
                                <th class="mdl-data-table__cell--non-numeric">Bodega</th>
                                <th class="mdl-data-table__cell--non-numeric">Respomnsable</th>
                                <th class="mdl-data-table__cell--non-numeric">Hora</th>
                                <th class="mdl-data-table__cell--non-numeric">Duración</th>
                                <th style="text-align:center; witdh:30px;">Acción</th>
                            </tr>
                        </thead>
                        <tbody>';

        if ($KsvmTotalReg >= 1 && $KsvmPagina <= $KsvmNPaginas) {
            $KsvmContReg = $KsvmDesde +1;
            foreach ($KsvmQuery as $rows) {
                $KsvmTabla .= '<tr>
                                <td class="mdl-data-table__cell--non-numeric">'.$KsvmContReg.'</td>
                                <td class="mdl-data-table__cell--non-numeric">'.$rows['IvtCodInv'].'</td>
                                <td class="mdl-data-table__cell--non-numeric">'.$rows['IvtFchElabInv'].'</td>
                                <td class="mdl-data-table__cell--non-numeric">'.$rows['BdgDescBod'].'</td>
                                <td class="mdl-data-table__cell--non-numeric">'.$rows['IvtPerElabInv'].'</td>
                                <td class="mdl-data-table__cell--non-numeric">'.$rows['IvtHoraInv'].'</td>
                                <td class="mdl-data-table__cell--non-numeric">'.$rows['IvtDuracionInv'].'</td>
                                <td style="text-align:right; witdh:30px;">';
                                if ($KsvmRol == 1) {
                                    if ($KsvmCodigo == 0) {

                                    $KsvmTabla .=  '<form action="'.KsvmServUrl.'Ajax/KsvmInventarioAjax.php" method="POST" class="FormularioAjax" data-form="eliminar" enctype="multipart/form-data"> 
                                                    <a id="btn-detail" class="btn btn-sm btn-info" href="'.KsvmServUrl.'KsvmInventariosCrud/Detail/'.KsvmEstMaestra::__KsvmEncriptacion($rows['IvtId']).'/"><i class="zmdi zmdi-card"></i></a>
                                                    <div class="mdl-tooltip" for="btn-detail">Detalles</div>
                                                    <a id="btn-edit" class="btn btn-sm btn-primary" href="'.KsvmServUrl.'KsvmInventariosEditar/'.KsvmEstMaestra::__KsvmEncriptacion($rows['IvtId']).'/0/"><i class="zmdi zmdi-edit"></i></a>
                                                    <div class="mdl-tooltip" for="btn-edit">Editar</div>
                                                    <input type="hidden" name="KsvmCodDelete" value="'.KsvmEstMaestra::__KsvmEncriptacion($rows['IvtId']).'">              
                                                    <button id="btn-delete" type="submit" class="btn btn-sm btn-danger"><i class="zmdi zmdi-delete"></i></button>
                                                    <div class="mdl-tooltip" for="btn-delete">Inhabilitar</div>
                                                    <div class="RespuestaAjax"></div>
                                                    </form>';
                                    } else {
                                    $KsvmTabla .= '<form action="'.KsvmServUrl.'Ajax/KsvmInventarioAjax.php" method="POST" class="FormularioAjax" data-form="eliminar" enctype="multipart/form-data"> 
                                                    <a id="btn-detail" class="btn btn-sm btn-info" href="'.KsvmServUrl.'KsvmInventarios/Detail/'.KsvmEstMaestra::__KsvmEncriptacion($rows['IvtId']).'"><i class="zmdi zmdi-card"></i></a>
                                                    <div class="mdl-tooltip" for="btn-detail">Detalles</div>
                                                    <a id="btn-edit" class="btn btn-sm btn-primary" href="'.KsvmServUrl.'KsvmInventariosEditar/'.KsvmEstMaestra::__KsvmEncriptacion($rows['IvtId']).'/1/"><i class="zmdi zmdi-edit"></i></a>
                                                    <div class="mdl-tooltip" for="btn-edit">Editar</div>
                                                    <input type="hidden" name="KsvmCodDelete" value="'.KsvmEstMaestra::__KsvmEncriptacion($rows['IvtId']).'">              
                                                    <button id="btn-delete" type="submit" class="btn btn-sm btn-danger"><i class="zmdi zmdi-delete"></i></button>
                                                    <div class="mdl-tooltip" for="btn-delete">Inhabilitar</div>
                                                    <div class="RespuestaAjax"></div>
                                                    </form>';
                                    }
                                }elseif ($KsvmRol == 2 || $KsvmRol == 3){
                                    $KsvmTabla .= '<a id="btn-detail" class="btn btn-sm btn-info" href="'.KsvmServUrl.'KsvmInventarios/Detail/'.KsvmEstMaestra::__KsvmEncriptacion($rows['IvtId']).'/"><i class="zmdi zmdi-card"></i></a>
                                                    <div class="mdl-tooltip" for="btn-detail">Detalles</div>
                                                    <a id="btn-edit" class="btn btn-sm btn-primary" href="'.KsvmServUrl.'KsvmInventariosEditar/'.KsvmEstMaestra::__KsvmEncriptacion($rows['IvtId']).'/1/"><i class="zmdi zmdi-edit"></i></a>
                                                    <div class="mdl-tooltip" for="btn-edit">Editar</div>';
                                }else{
                                    $KsvmTabla .= '<a id="btn-detail" class="btn btn-sm btn-info" href="'.KsvmServUrl.'KsvmInventarios/Detail/'.KsvmEstMaestra::__KsvmEncriptacion($rows['IvtId']).'/"><i class="zmdi zmdi-card"></i></a>
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
                echo '<script> window.location.href=" '.KsvmServUrl.'KsvmInventariosCrud"</script>';
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
                    $KsvmTabla .= '<a class = "btn btn-xs btn-success mdl-shadow--8dp " href="'.KsvmServUrl.'KsvmInventariosCrud/1/">Primero</a>
                                   <span></span>
                                   <a class = "btn btn-xs btn-default mdl-shadow--8dp " href="'.KsvmServUrl.'KsvmInventariosCrud/'.($KsvmPagina-1).'/"><i class="zmdi zmdi-fast-rewind"></i></a>';
                }

                if ($KsvmPagina == $KsvmNPaginas) {
                    $KsvmTabla .= '<button class = "btn btn-xs btn-default mdl-shadow--8dp disabled"><i class="zmdi zmdi-fast-forward"></i></button>
                                   <span></span>
                                   <button class = "btn btn-xs btn-success mdl-shadow--8dp disabled">Último</button>';
                } else {
                    $KsvmTabla .= '<a class="btn btn-xs btn-default mdl-shadow--8dp" href="'.KsvmServUrl.'KsvmInventariosCrud/'.($KsvmPagina+1).'/"><i class="zmdi zmdi-fast-forward"></i></a>
                                   <span></span>
                                   <a class="btn btn-xs btn-success mdl-shadow--8dp" href="'.KsvmServUrl.'KsvmInventariosCrud/'.($KsvmNPaginas).'/">Último</a>';
                                   
                                   
                }
                
             
                $KsvmTabla .= '</nav></div>';        

            } else {
                $KsvmTabla .= '<nav class="navbar-form navbar-right form-group">';
                
                if ($KsvmPagina == 1) {
                    $KsvmTabla .= '<button class = "btn btn-xs btn-success mdl-shadow--8dp disabled">Primero</button>
                                   <span></span>
                                   <button class = "btn btn-xs btn-default mdl-shadow--8dp disabled"><i class="zmdi zmdi-fast-rewind"></i></button>';
                } else {
                    $KsvmTabla .= '<a class = "btn btn-xs btn-success mdl-shadow--8dp " href="'.KsvmServUrl.'KsvmInventarios/1/">Primero</a>
                                   <span></span>
                                   <a class = "btn btn-xs btn-default mdl-shadow--8dp " href="'.KsvmServUrl.'KsvmInventarios/'.($KsvmPagina-1).'/"><i class="zmdi zmdi-fast-rewind"></i></a>';
                }

                if ($KsvmPagina == $KsvmNPaginas) {
                    $KsvmTabla .= '<button class = "btn btn-xs btn-default mdl-shadow--8dp disabled"><i class="zmdi zmdi-fast-forward"></i></button>
                                   <span></span>
                                   <button class = "btn btn-xs btn-success mdl-shadow--8dp disabled">Último</button>';
                } else {
                    $KsvmTabla .= '<a class="btn btn-xs btn-default mdl-shadow--8dp" href="'.KsvmServUrl.'KsvmInventarios/'.($KsvmPagina+1).'/"><i class="zmdi zmdi-fast-forward"></i></a>
                                   <span></span>
                                   <a class="btn btn-xs btn-success mdl-shadow--8dp" href="'.KsvmServUrl.'KsvmInventarios/'.($KsvmNPaginas).'/">Último</a>';
                                   
                                   
                }
                
                $KsvmTabla .= '</nav></div>'; 
            }
            
        
                                   
        return $KsvmTabla;
      }
     
      /**
       * Función que permite inhabilitar un Inventario 
       */
      public function __KsvmEliminarInventarioControlador()
      {
         $KsvmCode = KsvmEstMaestra :: __KsvmDesencriptacion($_POST['KsvmCodDelete']);
         $KsvmCodInventario = KsvmEstMaestra :: __KsvmFiltrarCadena($KsvmCode);

         $KsvmDelInv = KsvmInventarioModelo :: __KsvmEliminarInventarioModelo($KsvmCodInventario);
         if ($KsvmDelInv->rowCount() == 1) {
            $KsvmAlerta = [
                "Alerta" => "Actualiza",
                "Titulo" => "Inventario Inhabilitado",
                "Cuerpo" => "El Inventario seleccionado ha sido inhabilitado con éxito",
                "Tipo" => "success"
                ];
             
         } else {
            $KsvmAlerta = [
                "Alerta" => "simple",
                "Titulo" => "Error inesperado",
                "Cuerpo" => "No es posible eliminar el Inventario del sistema",
                "Tipo" => "info"
                ];
         }

         return KsvmEstMaestra :: __KsvmMostrarAlertas($KsvmAlerta);
      }

       /**
       * Función que permite eliminar un registro 
       */
      public function __KsvmEliminarRegistroInventario()
      {
         $KsvmCode = KsvmEstMaestra :: __KsvmDesencriptacion($_POST['KsvmCodX']);
         $KsvmCodInventario = KsvmEstMaestra :: __KsvmFiltrarCadena($KsvmCode);

         $KsvmDelInv = KsvmInventarioModelo :: __KsvmEliminarInventario($KsvmCodInventario);
         if ($KsvmDelInv->rowCount() == 1) {
             $KsvmResult = "true";
         } else {
            $KsvmAlerta = [
                "Alerta" => "simple",
                "Titulo" => "Error inesperado",
                "Cuerpo" => "No es posible eliminar el Inventario del sistema",
                "Tipo" => "info"
                ];
                return KsvmEstMaestra :: __KsvmMostrarAlertas($KsvmAlerta);
                $KsvmResult = "false";
         }
         return $KsvmResult;
      }
    
      /**
       * Función que permite editar un Inventario 
       */
      public function __KsvmEditarInventarioControlador($KsvmCodInventario)
      {
          $KsvmCodigo = KsvmEstMaestra :: __KsvmDesencriptacion($KsvmCodInventario);

          return KsvmInventarioModelo :: __KsvmEditarInventarioModelo($KsvmCodigo);
      }
      
      /**
       * Función que permite contar un Inventario 
       */
      public function __KsvmContarInventarioControlador()
      {
          return KsvmInventarioModelo :: __KsvmContarInventarioModelo(0);
      }

      /**
       * Función que permite actualizar un Inventario 
       */
      public function __KsvmActualizarInventarioControlador()
      {
        $KsvmCodInventario = KsvmEstMaestra :: __KsvmDesencriptacion($_POST['KsvmCodEdit']);
        $KsvmExtId = KsvmEstMaestra :: __KsvmFiltrarCadena($_POST['KsvmExtId']);
        $KsvmStockInv = KsvmEstMaestra :: __KsvmFiltrarCadena($_POST['KsvmStockInv']);
        $KsvmContFisInv = KsvmEstMaestra :: __KsvmFiltrarCadena($_POST['KsvmContFisInv']);
        $KsvmDuracionInv = KsvmEstMaestra :: __KsvmFiltrarCadena($_POST['KsvmDuracionInv']);
        $KsvmEstInv = KsvmEstMaestra :: __KsvmFiltrarCadena($_POST['KsvmEstInv']);

        $KsvmActualInv = [
            "KsvmExtId" => $KsvmExtId,
            "KsvmStockInv" => $KsvmStockInv,
            "KsvmContFisInv" => $KsvmContFisInv,
            "KsvmDuracionInv" => $KsvmDuracionInv,
            "KsvmEstInv" => $KsvmEstInv,
            "KsvmCodInventario" => $KsvmCodInventario
            ];

            $KsvmGuardarInv = KsvmInventarioModelo :: __KsvmActualizarInventarioModelo($KsvmActualInv);
                if ($KsvmGuardarInv->rowCount() >= 1) {
                    $KsvmAlerta = [
                    "Alerta" => "Actualiza",
                    "Titulo" => "Grandioso",
                    "Cuerpo" => "El Inventario se actualizó satisfactoriamente",
                    "Tipo" => "success"
                    ];
                } else {
                    $KsvmAlerta = [
                    "Alerta" => "simple",
                    "Titulo" => "Error inesperado",
                    "Cuerpo" => "No se a podido actualizar la información del Inventario",
                    "Tipo" => "info"
                    ];
                }
                return KsvmEstMaestra :: __KsvmMostrarAlertas($KsvmAlerta);
         
        }

        /**
       * Función que permite seleccionar un Inventario 
       */
        public function __KsvmSeleccionarInventario()
        {

            $KsvmBod = $_POST['KsvmBdgCod'];
            $KsvmSelectExt = "SELECT * FROM ksvmvistainventarios WHERE BdgId = '$KsvmBod'";

            $KsvmConsulta = KsvmEstMaestra :: __KsvmConexion();
            $KsvmQuery = $KsvmConsulta->query($KsvmSelectExt);
            $KsvmQuery = $KsvmQuery->fetchAll();
            $KsvmListar = '<option value="" selected="" disabled>Seleccione Inventario</option>';
            $KsvmListar .= '<option value="0" >Nuevo</option>';

            foreach ($KsvmQuery as $row) {
                $KsvmListar .= '<option value="'.$row['IvtId'].'">Cod: '.$row['IvtCodInv'].' Fecha: '.$row['IvtFchElabInv'].'</option>';
            }
            return $KsvmListar;
        }


        /**
         * Función que permite cargar el medicamento 
         */
        public function __KsvmCargarMedicamento()
        {

            $KsvmMedica = $_POST['KsvmIvtMedCod'];
            if ($KsvmMedica != 0) {
                $KsvmSelectExt = "SELECT * FROM ksvmvistadetalleinventario WHERE IvtId = '$KsvmMedica'";
            } else {
                $KsvmSelectExt = "SELECT * FROM ksvmseleccionaexistencia";
            }

            $KsvmConsulta = KsvmEstMaestra :: __KsvmConexion();
            $KsvmQuery = $KsvmConsulta->query($KsvmSelectExt);
            $KsvmQuery = $KsvmQuery->fetchAll();
                $KsvmListar = '<option value="" selected="" disabled>Seleccione Medicamento</option>';

                foreach ($KsvmQuery as $row) {
                    $KsvmListar .= '<option value="'.$row['ExtId'].'">'.$row['MdcDescMed'].' '.$row['MdcConcenMed'].' '.$row['ExtLoteEx'].'</option>';
                }
                return $KsvmListar;
        }

         /**
         * Función que permite cargar el stock 
         */
        public function __KsvmCargarStock()
        {

            $KsvmStock = $_POST['KsvmIvtStkCod'];
            $KsvmDataStock = KsvmInventarioModelo :: __KsvmSeleccionarStock($KsvmStock);
            if ($KsvmDataStock->rowCount() == 1) {
                $KsvmLlenarStock = $KsvmDataStock->fetch();
                $KsvmListar = '<input class="mdl-textfield__input" type="text" name="KsvmStockReq"
                               value="'.$KsvmLlenarStock['DivStockInv'].'">';

            }

            return $KsvmListar;
        }
    
}
   
 