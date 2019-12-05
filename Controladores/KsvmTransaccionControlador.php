<?php

  /**
   *Condicion para peticion Ajax
   */
   if ($KsvmPeticionAjax) {
       require_once "../Modelos/KsvmTransaccionModelo.php";
   } else {
       require_once "./Modelos/KsvmTransaccionModelo.php";
   }

   class KsvmTransaccionControlador extends KsvmTransaccionModelo
   {
     /**
      *Función que permite ingresar una Transaccion
      */
     public function __KsvmAgregarTransaccionControlador()
     {
        $KsvmRqcId = KsvmEstMaestra :: __KsvmFiltrarCadena($_POST['KsvmRqcId']);
        $KsvmTipoTran = KsvmEstMaestra :: __KsvmFiltrarCadena($_POST['KsvmTipoTran']);
        $KsvmDestinoTran = KsvmEstMaestra :: __KsvmFiltrarCadena($_POST['KsvmDestinoTran']);

        $KsvmTransaccion = "SELECT TsnId FROM ksvmvistatransacciones";
        $KsvmQuery = KsvmEstMaestra :: __KsvmEjecutaConsulta($KsvmTransaccion);
        $KsvmNum = ($KsvmQuery->rowCount())+1;

        $KsvmNumTran = KsvmEstMaestra :: __KsvmGeneraCodigoAleatorio("00", 6, $KsvmNum);

        session_start(['name' => 'SIGIM']);
        $KsvmUser = $_SESSION['KsvmUsuId-SIGIM'];
        $KsvmElabora = "SELECT concat(EpoPriApeEmp,' ',EpoSegApeEmp,' ',EpoPriNomEmp,' ',EpoSegNomEmp) as PerElab FROM ksvmvistaempleado WHERE UsrId = '$KsvmUser'";
        $KsvmQuery = KsvmEstMaestra :: __KsvmConexion()->query($KsvmElabora);
         
         if ($KsvmQuery->rowCount() == 1) {
            $KsvmPerElab = $KsvmQuery->fetch();

            $KsvmFchRevTran = "no registrado";
            $KsvmPerReaTran = $KsvmPerElab['PerElab'];
            $KsvmPerRevTran = "no registrado"; 
         } else {
            $KsvmAlerta = [
                "Alerta" => "simple",
                "Titulo" => "Error inesperado",
                "Cuerpo" => "No se a podido verificar el usuario",
                "Tipo" => "info"
                ];
         }

                $KsvmNuevaTran = [
                "KsvmRqcId" => $KsvmRqcId,
                "KsvmNumTran," => $KsvmNumTran,
                "KsvmTipoTran" => $KsvmTipoTran,
                "KsvmDestinoTran" => $KsvmDestinoTran,
                "KsvmPerReaTran" => $KsvmPerReaTran,
                "KsvmFchRevTran" => $KsvmFchRevTran,
                "KsvmPerRevTran" => $KsvmPerRevTran
                ];

                $KsvmGuardarTran = KsvmTransaccionModelo :: __KsvmAgregarTransaccionModelo($KsvmNuevaTran);
                if ($KsvmGuardarTran->rowCount() >= 1) {
                    $KsvmAlerta = [
                    "Alerta" => "Limpia",
                    "Titulo" => "Grandioso",
                    "Cuerpo" => "La Transacción se registró satisfactoriamente",
                    "Tipo" => "success"
                    ];
                } else {
                    $KsvmAlerta = [
                    "Alerta" => "simple",
                    "Titulo" => "Error inesperado",
                    "Cuerpo" => "No se a podido registrar la Transacción",
                    "Tipo" => "info"
                    ];
                }
                
            return KsvmEstMaestra :: __KsvmMostrarAlertas($KsvmAlerta);
        }

     /**
      *Función que permite ingresar una Detalle de Transaccion
      */
    public function __KsvmAgregarDetalleTransaccionControlador()
    {
        $KsvmExtId = KsvmEstMaestra :: __KsvmFiltrarCadena($_POST['KsvmExtId']);
        $KsvmTipoTran = KsvmEstMaestra :: __KsvmFiltrarCadena($_POST['KsvmTipoTran']);
        $KsvmCantTran = KsvmEstMaestra :: __KsvmFiltrarCadena($_POST['KsvmCantTran']);
        $KsvmObservTran = KsvmEstMaestra :: __KsvmFiltrarCadena($_POST['KsvmObservTran']);

        $KsvmNuevoDetalleTran = [
            "KsvmExtId" => $KsvmExtId,
            "KsvmTipoTran" => $KsvmTipoTran,
            "KsvmCantTran" => $KsvmCantTran,
            "KsvmObservTran" => $KsvmObservTran

           ];

           $KsvmGuardarDetTran = KsvmTransaccionModelo :: __KsvmAgregarDetalleTransaccionModelo($KsvmNuevoDetalleTran);
                if ($KsvmGuardarDetTran->rowCount() >= 1) {
                    $KsvmResult = "true";
                } else {
                    $KsvmAlerta = [
                    "Alerta" => "simple",
                    "Titulo" => "Error inesperado",
                    "Cuerpo" => "No se a podido registrar la Transacción",
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
            $KsvmDataTran = "SELECT SQL_CALC_FOUND_ROWS * FROM ksvmvistatransacciones WHERE ((TsnId != 'X') AND (TsnNumTran LIKE '%$KsvmBuscar%' 
                          OR TsnTipoTran LIKE '%$KsvmBuscar%' OR TsnNomMedTran LIKE '%$KsvmBuscar%'OR RqcNumReq LIKE '%$KsvmBuscar%')) 
                          LIMIT $KsvmDesde, $KsvmNRegistros";
        } else {
            $KsvmDataTran = "SELECT SQL_CALC_FOUND_ROWS * FROM ksvmvistatransacciones WHERE TsnId != 'X' LIMIT $KsvmDesde, $KsvmNRegistros" ;
        }
        

        $KsvmConsulta = KsvmEstMaestra :: __KsvmConexion();
    
        $KsvmQuery = $KsvmConsulta->query($KsvmDataTran);
        $KsvmQuery = $KsvmQuery->fetchAll();
        
        $KsvmDataTot = "SELECT FOUND_ROWS()";
        $KsvmTotalReg = $KsvmConsulta->query($KsvmDataTot);
        $KsvmTotalReg = (int) $KsvmTotalReg->fetchColumn();
        $KsvmNPaginas = ceil($KsvmTotalReg/$KsvmNRegistros);

        $KsvmTabla .= '<table class="mdl-data-table mdl-js-data-table mdl-shadow--6dp full-width table-responsive">
                        <thead>
                            <tr>
                                <th class="mdl-data-table__cell--non-numeric">#</th>
                                <th class="mdl-data-table__cell--non-numeric"># Transacción</th>
                                <th class="mdl-data-table__cell--non-numeric">Fecha</th>
                                <th class="mdl-data-table__cell--non-numeric">Tipo</th>
                                <th class="mdl-data-table__cell--non-numeric">Destino</th>
                                <th class="mdl-data-table__cell--non-numeric">Responsable</th>
                                <th style="text-align:center; witdh:30px;">Acción</th>
                            </tr>
                        </thead>
                        <tbody>';

        if ($KsvmTotalReg >= 1 && $KsvmPagina <= $KsvmNPaginas) {
            $KsvmContReg = $KsvmDesde +1;
            foreach ($KsvmQuery as $rows) {
                $KsvmBodega = $rows['TsnDestinoTran'];
                $KsvmSelectBodega = "SELECT * FROM ksvmseleccionabodega WHERE BdgId = '$KsvmBodega'";
                $KsvmConsulta = KsvmEstMaestra :: __KsvmConexion();
                $KsvmQuery = $KsvmConsulta->query($KsvmSelectBodega);
                $KsvmQuery = $KsvmQuery->fetch();
                $KsvmBodDest = $KsvmQuery['BdgDescBod'];

                $KsvmTabla .= '<tr>
                                <td class="mdl-data-table__cell--non-numeric">'.$KsvmContReg.'</td>
                                <td class="mdl-data-table__cell--non-numeric">'.$rows['TsnNumTran'].'</td>
                                <td class="mdl-data-table__cell--non-numeric">'.$rows['TsnFchReaTran'].'</td>
                                <td class="mdl-data-table__cell--non-numeric">'.$rows['TsnTipoTran'].'</td>
                                <td class="mdl-data-table__cell--non-numeric">'.$KsvmBodDest.'</td>
                                <td class="mdl-data-table__cell--non-numeric">'.$rows['TsnPerReaTran'].'</td>
                                <td style="text-align:right; witdh:30px;">';
                                if ($KsvmRol == 1) {
                                    if ($KsvmCodigo == 0) {

                                    $KsvmTabla .= '<form action="'.KsvmServUrl.'Ajax/KsvmTransaccionAjax.php" method="POST" class="FormularioAjax" data-form="eliminar" enctype="multipart/form-data"> 
                                                    <a id="btn-detail" class="btn btn-sm btn-info" href="'.KsvmServUrl.'KsvmTransaccionesCrud/Detail/'.KsvmEstMaestra::__KsvmEncriptacion($rows['TsnId']).'"><i class="zmdi zmdi-card"></i></a>
                                                    <div class="mdl-tooltip" for="btn-detail">Detalles</div>
                                                    <a id="btn-edit" class="btn btn-sm btn-primary" href="'.KsvmServUrl.'KsvmTransaccionesEditar/'.KsvmEstMaestra::__KsvmEncriptacion($rows['TsnId']).'/0/"><i class="zmdi zmdi-edit"></i></a>
                                                    <div class="mdl-tooltip" for="btn-edit">Editar</div>
                                                    <input type="hidden" name="KsvmCodDelete" value="'.KsvmEstMaestra::__KsvmEncriptacion($rows['TsnId']).'">              
                                                    <button id="btn-delete" type="submit" class="btn btn-sm btn-danger"><i class="zmdi zmdi-delete"></i></button>
                                                    <div class="mdl-tooltip" for="btn-delete">Inhabilitar</div>
                                                    <div class="RespuestaAjax"></div>
                                                    </form>';
                                    } elseif ($KsvmCodigo == 1) { 
                                    $KsvmTabla .= '<form action="'.KsvmServUrl.'Ajax/KsvmTransaccionAjax.php" method="POST" class="FormularioAjax" data-form="eliminar" enctype="multipart/form-data"> 
                                                    <a id="btn-detail" class="btn btn-sm btn-info" href="'.KsvmServUrl.'KsvmIngresos/Detail/'.KsvmEstMaestra::__KsvmEncriptacion($rows['TsnId']).'"><i class="zmdi zmdi-card"></i></a>
                                                    <div class="mdl-tooltip" for="btn-detail">Detalles</div>
                                                    <a id="btn-edit" class="btn btn-sm btn-primary" href="'.KsvmServUrl.'KsvmTransaccionesEditar/'.KsvmEstMaestra::__KsvmEncriptacion($rows['TsnId']).'/1/"><i class="zmdi zmdi-edit"></i></a>
                                                    <div class="mdl-tooltip" for="btn-edit">Editar</div>
                                                    <input type="hidden" name="KsvmCodDelete" value="'.KsvmEstMaestra::__KsvmEncriptacion($rows['TsnId']).'">              
                                                    <button id="btn-delete" type="submit" class="btn btn-sm btn-danger"><i class="zmdi zmdi-delete"></i></button>
                                                    <div class="mdl-tooltip" for="btn-delete">Inhabilitar</div>
                                                    <div class="RespuestaAjax"></div>
                                                    </form>';
                                    } else {
                                    $KsvmTabla .= '<form action="'.KsvmServUrl.'Ajax/KsvmTransaccionAjax.php" method="POST" class="FormularioAjax" data-form="eliminar" enctype="multipart/form-data"> 
                                                    <a id="btn-detail" class="btn btn-sm btn-info" href="'.KsvmServUrl.'KsvmEgresos/Detail/'.KsvmEstMaestra::__KsvmEncriptacion($rows['TsnId']).'"><i class="zmdi zmdi-card"></i></a>
                                                    <div class="mdl-tooltip" for="btn-detail">Detalles</div>
                                                    <a id="btn-edit" class="btn btn-sm btn-primary" href="'.KsvmServUrl.'KsvmTransaccionesEditar/'.KsvmEstMaestra::__KsvmEncriptacion($rows['TsnId']).'/2/"><i class="zmdi zmdi-edit"></i></a>
                                                    <div class="mdl-tooltip" for="btn-edit">Editar</div>
                                                    <input type="hidden" name="KsvmCodDelete" value="'.KsvmEstMaestra::__KsvmEncriptacion($rows['TsnId']).'">              
                                                    <button id="btn-delete" type="submit" class="btn btn-sm btn-danger"><i class="zmdi zmdi-delete"></i></button>
                                                    <div class="mdl-tooltip" for="btn-delete">Inhabilitar</div>
                                                    <div class="RespuestaAjax"></div>
                                                    </form>';
                                    }
                                }elseif ($KsvmRol == 2 || $KsvmRol == 3){
                                    if ($KsvmCodigo == 1) {
                                        $KsvmTabla .= '<a id="btn-detail" class="btn btn-sm btn-info" href="'.KsvmServUrl.'KsvmIngresos/Detail/'.KsvmEstMaestra::__KsvmEncriptacion($rows['TsnId']).'/"><i class="zmdi zmdi-card"></i></a>
                                                    <div class="mdl-tooltip" for="btn-detail">Detalles</div>
                                                    <a id="btn-edit" class="btn btn-sm btn-primary" href="'.KsvmServUrl.'KsvmTransaccionesEditar/'.KsvmEstMaestra::__KsvmEncriptacion($rows['TsnId']).'/1/"><i class="zmdi zmdi-edit"></i></a>
                                                    <div class="mdl-tooltip" for="btn-edit">Editar</div>';
                                    } else {
                                        $KsvmTabla .= '<a id="btn-detail" class="btn btn-sm btn-info" href="'.KsvmServUrl.'KsvmEgresos/Detail/'.KsvmEstMaestra::__KsvmEncriptacion($rows['TsnId']).'/"><i class="zmdi zmdi-card"></i></a>
                                                    <div class="mdl-tooltip" for="btn-detail">Detalles</div>
                                                    <a id="btn-edit" class="btn btn-sm btn-primary" href="'.KsvmServUrl.'KsvmTransaccionesEditar/'.KsvmEstMaestra::__KsvmEncriptacion($rows['TsnId']).'/2/"><i class="zmdi zmdi-edit"></i></a>
                                                    <div class="mdl-tooltip" for="btn-edit">Editar</div>';
                                    }
                                    
                                    
                                }else{
                                    if ($KsvmCodigo == 1) {
                                        $KsvmTabla .= '<a id="btn-detail" class="btn btn-sm btn-info" href="'.KsvmServUrl.'KsvmIngresos/Detail/'.KsvmEstMaestra::__KsvmEncriptacion($rows['TsnId']).'/"><i class="zmdi zmdi-card"></i></a>
                                                    <div class="mdl-tooltip" for="btn-detail">Detalles</div>';
                                    } else {
                                        $KsvmTabla .= '<a id="btn-detail" class="btn btn-sm btn-info" href="'.KsvmServUrl.'KsvmEgresos/Detail/'.KsvmEstMaestra::__KsvmEncriptacion($rows['TsnId']).'/"><i class="zmdi zmdi-card"></i></a>
                                                    <div class="mdl-tooltip" for="btn-detail">Detalles</div>';
                                    }
                                    
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
                echo '<script> window.location.href=" '.KsvmServUrl.'KsvmTransaccionesCrud/1/"</script>';
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
                    $KsvmTabla .= '<a class = "btn btn-xs btn-success mdl-shadow--8dp " href="'.KsvmServUrl.'KsvmTransaccionesCrud/1/">Primero</a>
                                   <span></span>
                                   <a class = "btn btn-xs btn-default mdl-shadow--8dp " href="'.KsvmServUrl.'KsvmTransaccionesCrud/'.($KsvmPagina-1).'/"><i class="zmdi zmdi-fast-rewind"></i></a>';
                }

                if ($KsvmPagina == $KsvmNPaginas) {
                    $KsvmTabla .= '<button class = "btn btn-xs btn-default mdl-shadow--8dp disabled"><i class="zmdi zmdi-fast-forward"></i></button>
                                   <span></span>
                                   <button class = "btn btn-xs btn-success mdl-shadow--8dp disabled">Último</button>';
                } else {
                    $KsvmTabla .= '<a class="btn btn-xs btn-default mdl-shadow--8dp" href="'.KsvmServUrl.'KsvmTransaccionesCrud/'.($KsvmPagina+1).'/"><i class="zmdi zmdi-fast-forward"></i></a>
                                   <span></span>
                                   <a class="btn btn-xs btn-success mdl-shadow--8dp" href="'.KsvmServUrl.'KsvmTransaccionesCrud/'.($KsvmNPaginas).'/">Último</a>';
                                   
                                   
                }
                
                $KsvmTabla .= '</nav></div>';       

            } elseif ($KsvmTotalReg >= 1 && $KsvmPagina <= $KsvmNPaginas && $KsvmCodigo == 1) {
                $KsvmTabla .= '<nav class="navbar-form navbar-right form-group">';
                
                if ($KsvmPagina == 1) {
                    $KsvmTabla .= '<button class = "btn btn-xs btn-success mdl-shadow--8dp disabled">Primero</button>
                                   <span></span>
                                   <button class = "btn btn-xs btn-default mdl-shadow--8dp disabled"><i class="zmdi zmdi-fast-rewind"></i></button>';
                } else {
                    $KsvmTabla .= '<a class = "btn btn-xs btn-success mdl-shadow--8dp " href="'.KsvmServUrl.'KsvmIngresos/1/">Primero</a>
                                   <span></span>
                                   <a class = "btn btn-xs btn-default mdl-shadow--8dp " href="'.KsvmServUrl.'KsvmIngresos/'.($KsvmPagina-1).'/"><i class="zmdi zmdi-fast-rewind"></i></a>';
                }

                if ($KsvmPagina == $KsvmNPaginas) {
                    $KsvmTabla .= '<button class = "btn btn-xs btn-default mdl-shadow--8dp disabled"><i class="zmdi zmdi-fast-forward"></i></button>
                                   <span></span>
                                   <button class = "btn btn-xs btn-success mdl-shadow--8dp disabled">Último</button>';
                } else {
                    $KsvmTabla .= '<a class="btn btn-xs btn-default mdl-shadow--8dp" href="'.KsvmServUrl.'KsvmIngresos/'.($KsvmPagina+1).'/"><i class="zmdi zmdi-fast-forward"></i></a>
                                   <span></span>
                                   <a class="btn btn-xs btn-success mdl-shadow--8dp" href="'.KsvmServUrl.'KsvmIngresos/'.($KsvmNPaginas).'/">Último</a>';
                                   
                                   
                }
                
                $KsvmTabla .= '</nav></div>'; 

            } else {
                $KsvmTabla .= '<nav class="navbar-form navbar-right form-group">';
                
                if ($KsvmPagina == 1) {
                    $KsvmTabla .= '<button class = "btn btn-xs btn-success mdl-shadow--8dp disabled">Primero</button>
                                   <span></span>
                                   <button class = "btn btn-xs btn-default mdl-shadow--8dp disabled"><i class="zmdi zmdi-fast-rewind"></i></button>';
                } else {
                    $KsvmTabla .= '<a class = "btn btn-xs btn-success mdl-shadow--8dp " href="'.KsvmServUrl.'KsvmEgresos/1/">Primero</a>
                                   <span></span>
                                   <a class = "btn btn-xs btn-default mdl-shadow--8dp " href="'.KsvmServUrl.'KsvmEgresos/'.($KsvmPagina-1).'/"><i class="zmdi zmdi-fast-rewind"></i></a>';
                }

                if ($KsvmPagina == $KsvmNPaginas) {
                    $KsvmTabla .= '<button class = "btn btn-xs btn-default mdl-shadow--8dp disabled"><i class="zmdi zmdi-fast-forward"></i></button>
                                   <span></span>
                                   <button class = "btn btn-xs btn-success mdl-shadow--8dp disabled">Último</button>';
                } else {
                    $KsvmTabla .= '<a class="btn btn-xs btn-default mdl-shadow--8dp" href="'.KsvmServUrl.'KsvmEgresos/'.($KsvmPagina+1).'/"><i class="zmdi zmdi-fast-forward"></i></a>
                                   <span></span>
                                   <a class="btn btn-xs btn-success mdl-shadow--8dp" href="'.KsvmServUrl.'KsvmEgresos/'.($KsvmNPaginas).'/">Último</a>';
                                   
                                   
                }
                
                $KsvmTabla .= '</nav></div>'; 
            }
            
        
                                   
        return $KsvmTabla;
      }
     
      /**
       * Función que permite inhabilitar una Transaccion 
       */
      public function __KsvmEliminarTransaccionControlador()
      {
         $KsvmCode = KsvmEstMaestra :: __KsvmDesencriptacion($_POST['KsvmCodDelete']);
         $KsvmCodTransaccion = KsvmEstMaestra :: __KsvmFiltrarCadena($KsvmCode);

         $KsvmDelTran = KsvmTransaccionModelo :: __KsvmEliminarTransaccionModelo($KsvmCodTransaccion);
         if ($KsvmDelTran->rowCount() == 1) {
            $KsvmAlerta = [
                "Alerta" => "Actualiza",
                "Titulo" => "Transaccion Inhabilitado",
                "Cuerpo" => "La Transacción seleccionada ha sido inhabilitada con éxito",
                "Tipo" => "success"
                ];
             
         } else {
            $KsvmAlerta = [
                "Alerta" => "simple",
                "Titulo" => "Error inesperado",
                "Cuerpo" => "No es posible eliminar la Transacción del sistema",
                "Tipo" => "info"
                ];
         }

         return KsvmEstMaestra :: __KsvmMostrarAlertas($KsvmAlerta);
      }

      /**
       * Función que permite eliminar un registro 
       */
      public function __KsvmEliminarRegistroTransaccion()
      {
         $KsvmCode = KsvmEstMaestra :: __KsvmDesencriptacion($_POST['KsvmCodX']);
         $KsvmCodTransaccion = KsvmEstMaestra :: __KsvmFiltrarCadena($KsvmCode);

         $KsvmDelComp = KsvmTransaccionModelo :: __KsvmEliminarTransaccion($KsvmCodTransaccion);
         if ($KsvmDelComp->rowCount() == 1) {
                $KsvmResult = "true";
             
         } else {
            $KsvmAlerta = [
                "Alerta" => "simple",
                "Titulo" => "Error inesperado",
                "Cuerpo" => "No es posible eliminar la Transaccion del sistema",
                "Tipo" => "info"
                ];
                return KsvmEstMaestra :: __KsvmMostrarAlertas($KsvmAlerta);
                $KsvmResult = "false";
         }

      }
    
      /**
       * Función que permite editar una Transaccion 
       */
      public function __KsvmEditarTransaccionControlador($KsvmCodTransaccion)
      {
          $KsvmCodigo = KsvmEstMaestra :: __KsvmDesencriptacion($KsvmCodTransaccion);

          return KsvmTransaccionModelo :: __KsvmEditarTransaccionModelo($KsvmCodigo);
      }

            /**
       * Función que permite editar una Detalle de Transaccion 
       */
      public function  __KsvmEditarDetalleTransaccionControlador($KsvmCodTransaccion)
      {
          $KsvmCodigo = KsvmEstMaestra :: __KsvmDesencriptacion($KsvmCodTransaccion);

          return KsvmTransaccionModelo :: __KsvmEditarDetalleTransaccionModelo($KsvmCodigo);
      }

      /**
       * Función que permite editar una Detalle de Transaccion 
       */
      public function  __KsvmEditarDataTransaccionControlador($KsvmCodTransaccion)
      {
          $KsvmCodigo = KsvmEstMaestra :: __KsvmDesencriptacion($KsvmCodTransaccion);

          return KsvmTransaccionModelo :: __KsvmCargarDataModelo($KsvmCodigo);
      }
      
      
      /**
       * Función que permite contar una Transaccion 
       */
      public function __KsvmContarTransaccionControlador()
      {
          return KsvmTransaccionModelo :: __KsvmContarTransaccionModelo(0);
      }

      /**
       * Función que permite actualizar una Transaccion 
       */
      public function __KsvmActualizarTransaccionControlador()
      {
        $KsvmCodTransaccion = KsvmEstMaestra :: __KsvmDesencriptacion($_POST['KsvmCodEdit']);
        $KsvmRqcId = KsvmEstMaestra :: __KsvmFiltrarCadena($_POST['KsvmRqcId']);
        $KsvmStockIniTran = KsvmEstMaestra :: __KsvmFiltrarCadena($_POST['KsvmStockIniTran']);
        $KsvmTipoTran = KsvmEstMaestra :: __KsvmFiltrarCadena($_POST['KsvmTipoTran']);
        $KsvmCantTran = KsvmEstMaestra :: __KsvmFiltrarCadena($_POST['KsvmCantTran']);
        $KsvmNomMedTran = KsvmEstMaestra :: __KsvmFiltrarCadena($_POST['KsvmNomMedTran']);
        $KsvmDestinoTran = KsvmEstMaestra :: __KsvmFiltrarCadena($_POST['KsvmDestinoTran']);
        $KsvmFchRevTran = KsvmEstMaestra :: __KsvmFiltrarCadena($_POST['KsvmFchRevTran']);
        $KsvmPerRevTran = KsvmEstMaestra :: __KsvmFiltrarCadena($_POST['KsvmPerRevTran']);
        $KsvmObservTran = KsvmEstMaestra :: __KsvmFiltrarCadena($_POST['KsvmObservTran']);

        $KsvmActualTran = [
            "KsvmRqcId" => $KsvmRqcId,
            "KsvmNumTran" => $KsvmNumTran,
            "KsvmTipoTran" => $KsvmTipoTran,
            "KsvmCantTran" => $KsvmCantTran,
            "KsvmNomMedTran" => $KsvmNomMedTran,
            "KsvmDestinoTran" => $KsvmDestinoTran,
            "KsvmFchRevTran" => $KsvmFchRevTran,
            "KsvmPerRevTran" => $KsvmPerRevTran,
            "KsvmObservTran" => $KsvmObservTran,
            "KsvmCodTransaccion" => $KsvmCodTransaccion
            ];

            $KsvmGuardarTran = KsvmTransaccionModelo :: __KsvmActualizarTransaccionModelo($KsvmActualTran);
                if ($KsvmGuardarTran->rowCount() >= 1) {
                    $KsvmAlerta = [
                    "Alerta" => "Actualiza",
                    "Titulo" => "Grandioso",
                    "Cuerpo" => "La Transacción se actualizó satisfactoriamente",
                    "Tipo" => "success"
                    ];
                } else {
                    $KsvmAlerta = [
                    "Alerta" => "simple",
                    "Titulo" => "Error inesperado",
                    "Cuerpo" => "No se a podido actualizar la información de la Transacción",
                    "Tipo" => "info"
                    ];
                }
                return KsvmEstMaestra :: __KsvmMostrarAlertas($KsvmAlerta);
         
        }

        public function __KsvmSeleccionBodega($KsvmBodega){
            $KsvmSelectBodega = "SELECT * FROM ksvmseleccionabodega WHERE BdgId = '$KsvmBodega'";

            $KsvmConsulta = KsvmEstMaestra :: __KsvmConexion();
            $KsvmQuery = $KsvmConsulta->query($KsvmSelectBodega);
            $KsvmQuery = $KsvmQuery->fetch();
            return $KsvmQuery;
        }
    
}
 
 
