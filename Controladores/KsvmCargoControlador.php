<?php

  /**
   *Condicion para peticion Ajax
   */
   if ($KsvmPeticionAjax) {
       require_once "../Modelos/KsvmCargoModelo.php";
   } else {
       require_once "./Modelos/KsvmCargoModelo.php";
   }

   class KsvmCargoControlador extends KsvmCargoModelo
   {
     /**
      *Función que permite ingresar un cargo
      */
     public function __KsvmAgregarCargoControlador()
     {
         $KsvmUmdId = KsvmEstMaestra :: __KsvmFiltrarCadena($_POST['KsvmUmdId']);
         $KsvmNomCar = KsvmEstMaestra :: __KsvmFiltrarCadena($_POST['KsvmNomCar']);

         $KsvmCargo = "SELECT CrgNomCar FROM ksvmvistacargos WHERE CrgNomCar ='$KsvmNomCar'";
         $KsvmQuery = KsvmEstMaestra :: __KsvmEjecutaConsulta($KsvmCargo);
         if ($KsvmQuery->rowCount() >= 1) {
            $KsvmAlerta = [
              "Alerta" => "simple",
              "Titulo" => "Error inesperado",
              "Cuerpo" => "El cargo ingresado ya se encuentra registrado, Por favor ingrese un cargo válido",
              "Tipo" => "info"
             ];

             }else{
              $KsvmNuevoCargo = [
                "KsvmUmdId" => $KsvmUmdId,
                "KsvmNomCar" => $KsvmNomCar
                ];

                $KsvmGuardarCargo = KsvmCargoModelo :: __KsvmAgregarCargoModelo($KsvmNuevoCargo);
                if ($KsvmGuardarCargo->rowCount() >= 1) {
                    $KsvmAlerta = [
                    "Alerta" => "Limpia",
                    "Titulo" => "Grandioso",
                    "Cuerpo" => "El cargo se registró satisfactoriamente",
                    "Tipo" => "success"
                    ];
                } else {
                    $KsvmAlerta = [
                    "Alerta" => "simple",
                    "Titulo" => "Error inesperado",
                    "Cuerpo" => "No se a podido registrar el cargo",
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
            $KsvmDataCargo = "SELECT SQL_CALC_FOUND_ROWS * FROM ksvmvistacargos WHERE ((CrgEstCar = 'A') AND (UmdNomUdm LIKE '%$KsvmBuscar%' 
                          OR CrgNomCar LIKE '%$KsvmBuscar%')) LIMIT $KsvmDesde, $KsvmNRegistros";
        } else {
            $KsvmDataCargo = "SELECT SQL_CALC_FOUND_ROWS * FROM ksvmvistacargos WHERE CrgEstCar = 'A' LIMIT $KsvmDesde, $KsvmNRegistros" ;
        }
        

        $KsvmConsulta = KsvmEstMaestra :: __KsvmConexion();
    
        $KsvmQuery = $KsvmConsulta->query($KsvmDataCargo);
        $KsvmQuery = $KsvmQuery->fetchAll();
        
        $KsvmDataTot = "SELECT FOUND_ROWS()";
        $KsvmTotalReg = $KsvmConsulta->query($KsvmDataTot);
        $KsvmTotalReg = (int) $KsvmTotalReg->fetchColumn();
        $KsvmNPaginas = ceil($KsvmTotalReg/$KsvmNRegistros);

        $KsvmTabla .= '<table class="mdl-data-table mdl-js-data-table mdl-shadow--6dp full-width table-responsive">
                        <thead>
                            <tr>
                                <th class="mdl-data-table__cell--non-numeric">#</th>
                                <th class="mdl-data-table__cell--non-numeric">CrgNomCar</th>
                                <th class="mdl-data-table__cell--non-numeric">UmdNomUdm</th>
                                <th class="mdl-data-table__cell--non-numeric">CrgEstCar</th>
                                <th style="text-align:center; witdh:30px;">Acción</th>
                            </tr>
                        </thead>
                        <tbody>';

        if ($KsvmTotalReg >= 1 && $KsvmPagina <= $KsvmNPaginas) {
            $KsvmContReg = $KsvmDesde +1;
            foreach ($KsvmQuery as $rows) {

                $KsvmEstado = "";
                if ($rows['CrgEstCar'] == 'A') {
                    $KsvmEstado = "Activo";
                }else {
                    $KsvmEstado = "Inactivo";
                }
              
                $KsvmTabla .= '<tr>
                                <td class="mdl-data-table__cell--non-numeric">'.$KsvmContReg.'</td>
                                <td class="mdl-data-table__cell--non-numeric">'.$rows['CrgNomCar'].'</td>
                                <td class="mdl-data-table__cell--non-numeric">'.$rows['UmdNomUdm'].'</td>
                                <td class="mdl-data-table__cell--non-numeric">'.$KsvmEstado.'</td>
                                <td style="text-align:right; witdh:30px;">';
                                if ($KsvmRol == 1) {
                                    $KsvmTabla .= '<form action="'.KsvmServUrl.'Ajax/KsvmCargoAjax.php" method="POST" class="FormularioAjax" data-form="eliminar" enctype="multipart/form-data"> 
                                                   <a id="btn-detail" class="btn btn-sm btn-info" href="'.KsvmServUrl.'KsvmCargosCrud/Detail/'.KsvmEstMaestra::__KsvmEncriptacion($rows['CrgId']).'/"><i class="zmdi zmdi-card"></i></a>
                                                   <div class="mdl-tooltip" for="btn-detail">Detalles</div>
                                                   <a id="btn-edit" class="btn btn-sm btn-primary" href="'.KsvmServUrl.'KsvmCargosEditar/'.KsvmEstMaestra::__KsvmEncriptacion($rows['CrgId']).'/0/"><i class="zmdi zmdi-edit"></i></a>
                                                   <div class="mdl-tooltip" for="btn-edit">Editar</div>   
                                                   <input type="hidden" name="KsvmCodDelete" value="'.KsvmEstMaestra::__KsvmEncriptacion($rows['CrgId']).'">              
                                                   <button id="btn-delete" type="submit" class="btn btn-sm btn-danger"><i class="zmdi zmdi-delete"></i></button>
                                                   <div class="mdl-tooltip" for="btn-delete">Inhabilitar</div>
                                                   <div class="RespuestaAjax"></div>
                                                   </form>';
                                }elseif ($KsvmRol == 2){
                                    $KsvmTabla .= '<a id="btn-detail" class="btn btn-sm btn-info" href="'.KsvmServUrl.'KsvmCargos/Detail/'.KsvmEstMaestra::__KsvmEncriptacion($rows['CrgId']).'/"><i class="zmdi zmdi-card"></i></a>
                                                    <div class="mdl-tooltip" for="btn-detail">Detalles</div>
                                                    <a id="btn-edit" class="btn btn-sm btn-primary" href="'.KsvmServUrl.'KsvmCargosEditar/'.KsvmEstMaestra::__KsvmEncriptacion($rows['CrgId']).'/1/"><i class="zmdi zmdi-edit"></i></a>
                                                    <div class="mdl-tooltip" for="btn-edit">Editar</div>';
                                }else{
                                    $KsvmTabla .= '<a id="btn-detail" class="btn btn-sm btn-info" href="'.KsvmServUrl.'KsvmCargos/Detail/'.KsvmEstMaestra::__KsvmEncriptacion($rows['CrgId']).'/"><i class="zmdi zmdi-card"></i></a>
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
                echo '<script> window.location.href=" '.KsvmServUrl.'KsvmCargosCrud"</script>';
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
                    $KsvmTabla .= '<a class = "btn btn-xs btn-success mdl-shadow--8dp " href="'.KsvmServUrl.'KsvmCargosCrud/">Primero</a>
                                   <span></span>
                                   <a class = "btn btn-xs btn-default mdl-shadow--8dp " href="'.KsvmServUrl.'KsvmCargosCrud/'.($KsvmPagina-1).'/"><i class="zmdi zmdi-fast-rewind"></i></a>';
                }

                if ($KsvmPagina == $KsvmNPaginas) {
                    $KsvmTabla .= '<button class = "btn btn-xs btn-default mdl-shadow--8dp disabled"><i class="zmdi zmdi-fast-forward"></i></button>
                                   <span></span>
                                   <button class = "btn btn-xs btn-success mdl-shadow--8dp disabled">Último</button>';
                } else {
                    $KsvmTabla .= '<a class="btn btn-xs btn-default mdl-shadow--8dp" href="'.KsvmServUrl.'KsvmCargosCrud/'.($KsvmPagina+1).'/"><i class="zmdi zmdi-fast-forward"></i></a>
                                   <span></span>
                                   <a class="btn btn-xs btn-success mdl-shadow--8dp" href="'.KsvmServUrl.'KsvmCargosCrud/'.($KsvmNPaginas).'/">Último</a>';
                                   
                                   
                }
                
             
                $KsvmTabla .= '</nav></div>';                
            }
            
        
                                   
        return $KsvmTabla;
      }
     
      /**
       * Función que permite inhabilitar un cargo 
       */
      public function __KsvmEliminarCargoControlador()
      {
         $KsvmCode = KsvmEstMaestra :: __KsvmDesencriptacion($_POST['KsvmCodDelete']);
         $KsvmCodCargo = KsvmEstMaestra :: __KsvmFiltrarCadena($KsvmCode);

        $KsvmDelCargo = KsvmCargoModelo :: __KsvmEliminarCargoModelo($KsvmCodCargo);
        if ($KsvmDelCargo->rowCount() == 1) {
            $KsvmAlerta = [
                "Alerta" => "Actualiza",
                "Titulo" => "Cargo Inhabilitado",
                "Cuerpo" => "El cargo seleccionado ha sido inhabilitado con éxito",
                "Tipo" => "success"
                ];
             
         } else {
            $KsvmAlerta = [
                "Alerta" => "simple",
                "Titulo" => "Error inesperado",
                "Cuerpo" => "No es posible eliminar el cargo del sistema",
                "Tipo" => "info"
                ];
         }

         return KsvmEstMaestra :: __KsvmMostrarAlertas($KsvmAlerta);
      }
    
      /**
       * Función que permite editar un cargo 
       */
      public function __KsvmEditarCargoControlador($KsvmCodCargo)
      {
          $KsvmCodigo = KsvmEstMaestra :: __KsvmDesencriptacion($KsvmCodCargo);

          return KsvmCargoModelo :: __KsvmEditarCargoModelo($KsvmCodigo);
      }
      
      /**
       * Función que permite contar un cargo 
       */
      public function __KsvmContarCargoControlador()
      {
          return KsvmCargoModelo :: __KsvmContarCargoModelo(0);
      }

      /**
       * Función que permite imprimir un cargo 
       */
      public function __KsvmImprimirCargoControlador()
      {
        return KsvmCargoModelo :: __KsvmImprimirCargoModelo();
      }

      /**
       * Función que permite actualizar un cargo
       */
      public function __KsvmActualizarCargoControlador()
      {
        $KsvmCodCargo = KsvmEstMaestra :: __KsvmDesencriptacion($_POST['KsvmCodEdit']);
        $KsvmUmdId = KsvmEstMaestra :: __KsvmFiltrarCadena($_POST['KsvmUmdId']);
        $KsvmNomCar = KsvmEstMaestra :: __KsvmFiltrarCadena($_POST['KsvmNomCar']);

        $KsvmConsulta = "SELECT * FROM ksvmvistacargos WHERE CrgId = '$KsvmCodCargo'";
        $KsvmQuery = KsvmEstMaestra :: __KsvmEjecutaConsulta($KsvmConsulta);
        $KsvmDataCargo = $KsvmQuery->fetch();

        if ($KsvmNomCar != $KsvmDataCargo['CrgNomCar']) {
            $KsvmConsulta = "SELECT CrgNomCar FROM ksvmvistacargos WHERE CrgNomCar = '$KsvmNomCar'";
            $KsvmQuery = KsvmEstMaestra :: __KsvmEjecutaConsulta($KsvmConsulta);
            if ($KsvmQuery->rowCount() >= 1) {
                $KsvmAlerta = [
                    "Alerta" => "Actualiza",
                    "Titulo" => "Error Inesperado",
                    "Cuerpo" => "El cargo ingresado ya se encuentra registrado, Por favor ingrese un cargo válido",
                    "Tipo" => "info"
                    ];
                    return KsvmEstMaestra :: __KsvmMostrarAlertas($KsvmAlerta);
                    exit();
            }
        }

        $KsvmActualCargo = [
            "KsvmUmdId" => $KsvmUmdId,
            "KsvmNomCar" => $KsvmNomCar,
            "KsvmCodCargo" => $KsvmCodCargo
            ];

            $KsvmGuardarCargo = KsvmCargoModelo :: __KsvmActualizarCargoModelo($KsvmActualCargo);
                if ($KsvmGuardarCargo->rowCount() >= 1) {
                    $KsvmAlerta = [
                    "Alerta" => "Actualiza",
                    "Titulo" => "Grandioso",
                    "Cuerpo" => "El cargo se actualizó satisfactoriamente",
                    "Tipo" => "success"
                    ];
                } else {
                    $KsvmAlerta = [
                    "Alerta" => "simple",
                    "Titulo" => "Error inesperado",
                    "Cuerpo" => "No se a podido actualizar la información del cargo",
                    "Tipo" => "info"
                    ];
                }
                return KsvmEstMaestra :: __KsvmMostrarAlertas($KsvmAlerta);
         
        }

        public function __KsvmSeleccionarCargo(){
            $KsvmSelectCargo = "SELECT * FROM ksvmseleccionacargo";

            $KsvmConsulta = KsvmEstMaestra :: __KsvmConexion();
            $KsvmQuery = $KsvmConsulta->query($KsvmSelectCargo);
            $KsvmQuery = $KsvmQuery->fetchAll();
            
            foreach ($KsvmQuery as $row) {
                $KsvmListar .= '<option value="'.$row['CrgId'].'">'.$row['CrgNomCar'].'</option>';
            }
            return $KsvmListar;
        }
    
}
   
 