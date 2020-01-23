<?php

  /**
   *Condicion para peticion Ajax
   */
   if ($KsvmPeticionAjax) {
       require_once "../Modelos/KsvmMedicamentoModelo.php";
   } else {
       require_once "./Modelos/KsvmMedicamentoModelo.php";
   }

   class KsvmMedicamentoControlador extends KsvmMedicamentoModelo
   {
     /**
      *Función que permite ingresar un Medicamento
      */
     public function __KsvmAgregarMedicamentoControlador()
     {
         $KsvmCtgId = KsvmEstMaestra :: __KsvmFiltrarCadena($_POST['KsvmCtgId']);
         $KsvmCodMed = KsvmEstMaestra :: __KsvmFiltrarCadena($_POST['KsvmCodMed']);
         $KsvmDescMed = KsvmEstMaestra :: __KsvmFiltrarCadena($_POST['KsvmDescMed']);
         $KsvmPresenMed = KsvmEstMaestra :: __KsvmFiltrarCadena($_POST['KsvmPresenMed']);
         $KsvmConcenMed = KsvmEstMaestra :: __KsvmFiltrarCadena($_POST['KsvmConcenMed']);
         $KsvmNivPrescMed = KsvmEstMaestra :: __KsvmFiltrarCadena($_POST['KsvmNivPrescMed']);
         $KsvmNivAtencMed = KsvmEstMaestra :: __KsvmFiltrarCadena($_POST['KsvmNivAtencMed']);
         $KsvmViaAdmMed = KsvmEstMaestra :: __KsvmFiltrarCadena($_POST['KsvmViaAdmMed']);
         if ($_FILES['KsvmFotoMed']['error'] > 0) {
            $KsvmFotoMed = "";
        } else {
            $KsvmFotoMed = file_get_contents($_FILES['KsvmFotoMed']['tmp_name']);
        }      
        
              $KsvmNuevoMed = [
                "KsvmCtgId" => $KsvmCtgId,
                "KsvmCodMed" => $KsvmCodMed,
                "KsvmDescMed" => $KsvmDescMed,
                "KsvmPresenMed" => $KsvmPresenMed,
                "KsvmConcenMed" => $KsvmConcenMed,
                "KsvmNivPrescMed" => $KsvmNivPrescMed,
                "KsvmNivAtencMed" => $KsvmNivAtencMed,
                "KsvmViaAdmMed" => $KsvmViaAdmMed,
                "KsvmFotoMed" => $KsvmFotoMed
                ];

                $KsvmGuardarMed = KsvmMedicamentoModelo :: __KsvmAgregarMedicamentoModelo($KsvmNuevoMed);
                if ($KsvmGuardarMed->rowCount() >= 1) {
                    $KsvmAlerta = [
                    "Alerta" => "Actualiza",
                    "Titulo" => "Grandioso",
                    "Cuerpo" => "El Medicamento se registró satisfactoriamente",
                    "Tipo" => "success"
                    ];
                } else {
                    $KsvmAlerta = [
                    "Alerta" => "simple",
                    "Titulo" => "Error inesperado",
                    "Cuerpo" => "No se a podido registrar el Medicamento",
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
            $KsvmDataEmp = "SELECT SQL_CALC_FOUND_ROWS * FROM ksvmvistamedicamentos WHERE ((MdcEstMed = 'A') AND (MdcCodMed LIKE '%$KsvmBuscar%' 
                           OR MdcDescMed LIKE '%$KsvmBuscar%' OR MdcNivAtencMed LIKE '%$KsvmBuscar%' OR MdcConcenMed LIKE '%$KsvmBuscar%'
                           OR CtgNomCat LIKE '%$KsvmBuscar%')) LIMIT $KsvmDesde, $KsvmNRegistros";
        } else {
            $KsvmDataEmp = "SELECT SQL_CALC_FOUND_ROWS * FROM ksvmvistamedicamentos WHERE MdcEstMed = 'A' LIMIT $KsvmDesde, $KsvmNRegistros" ;
        }
        

        $KsvmConsulta = KsvmEstMaestra :: __KsvmConexion();
    
        $KsvmQuery = $KsvmConsulta->query($KsvmDataEmp);
        $KsvmQuery = $KsvmQuery->fetchAll();
        
        $KsvmDataTot = "SELECT FOUND_ROWS()";
        $KsvmTotalReg = $KsvmConsulta->query($KsvmDataTot);
        $KsvmTotalReg = (int) $KsvmTotalReg->fetchColumn();
        $KsvmNPaginas = ceil($KsvmTotalReg/$KsvmNRegistros);

        if ($KsvmCodigo == 0) {
        $KsvmTabla .= '<table class="mdl-data-table mdl-js-data-table mdl-shadow--6dp full-width table-responsive">
                        <thead>
                            <tr>
                                <th class="mdl-data-table__cell--non-numeric">#</th>
                                <th class="mdl-data-table__cell--non-numeric">Foto</th>
                                <th class="mdl-data-table__cell--non-numeric">Código</th>
                                <th class="mdl-data-table__cell--non-numeric">Descripción</th>
                                <th class="mdl-data-table__cell--non-numeric hide-on-tablet">Nivel</th>
                                <th class="mdl-data-table__cell--non-numeric">Categoría</th>
                                <th class="mdl-data-table__cell--non-numeric">Color</th>
                                <th style="text-align:center; witdh:30px;">Acción</th>
                            </tr>
                        </thead>
                        <tbody>';

        if ($KsvmTotalReg >= 1 && $KsvmPagina <= $KsvmNPaginas) {
            $KsvmContReg = $KsvmDesde +1;
            foreach ($KsvmQuery as $rows) {
                $KsvmTabla .= '<tr>
                                <td class="mdl-data-table__cell--non-numeric">'.$KsvmContReg.'</td>
                                <td class="mdl-data-table__cell--non-numeric"><img style="border-radius:30px;" height="35px" width="35px" src="data:image/jpg;base64,'. base64_encode($rows['MdcFotoMed']).'"/></td>
                                <td class="mdl-data-table__cell--non-numeric">'.$rows['MdcCodMed'].'</td>
                                <td class="mdl-data-table__cell--non-numeric">'.$rows['MdcDescMed'].' '.$rows['MdcConcenMed'].'</td>
                                <td class="mdl-data-table__cell--non-numeric hide-on-tablet">'.$rows['MdcNivAtencMed'].'</td>
                                <td class="mdl-data-table__cell--non-numeric">'.$rows['CtgNomCat'].'</td>
                                <td class="mdl-data-table__cell--non-numeric"><button class="btn btn-md" style="border-color:#000; background-color:'.$rows['CtgColorCat'].';"></button></td>
                                <td style="text-align:right; witdh:30px;">';
                                if ($KsvmRol == 1) {

                                    $KsvmTabla .= '<form action="'.KsvmServUrl.'Ajax/KsvmMedicamentoAjax.php" method="POST" class="FormularioAjax" data-form="eliminar" enctype="multipart/form-data"> 
                                                <a id="btn-detail" class="btn btn-sm btn-info" href="'.KsvmServUrl.'KsvmMedicamentosCrud/Detail/'.KsvmEstMaestra::__KsvmEncriptacion($rows['MdcId']).'/"><i class="zmdi zmdi-card"></i></a>
                                                <div class="mdl-tooltip" for="btn-detail">Detalles</div>
                                                <a id="btn-edit" class="btn btn-sm btn-primary" href="'.KsvmServUrl.'KsvmMedicamentosEditar/'.KsvmEstMaestra::__KsvmEncriptacion($rows['MdcId']).'/0/"><i class="zmdi zmdi-edit"></i></a>
                                                <div class="mdl-tooltip" for="btn-edit">Editar</div>
                                                <input type="hidden" name="KsvmCodDelete" value="'.KsvmEstMaestra::__KsvmEncriptacion($rows['MdcId']).'">              
                                                <button id="btn-delete" type="submit" class="btn btn-sm btn-danger"><i class="zmdi zmdi-delete"></i></button>
                                                <div class="mdl-tooltip" for="btn-delete">Inhabilitar</div>
                                                <div class="RespuestaAjax"></div>
                                                </form>';
                                }elseif ($KsvmRol == 2 || $KsvmRol == 3){
                                    $KsvmTabla .= '<a id="btn-detail" class="btn btn-sm btn-info" href="'.KsvmServUrl.'KsvmCatalogoMedicamentos/Detail/'.KsvmEstMaestra::__KsvmEncriptacion($rows['MdcId']).'/"><i class="zmdi zmdi-card"></i></a>
                                                    <div class="mdl-tooltip" for="btn-detail">Detalles</div>
                                                    <a id="btn-edit" class="btn btn-sm btn-primary" href="'.KsvmServUrl.'KsvmMedicamentosEditar/'.KsvmEstMaestra::__KsvmEncriptacion($rows['MdcId']).'/1/"><i class="zmdi zmdi-edit"></i></a>
                                                    <div class="mdl-tooltip" for="btn-edit">Editar</div>';
                                }else{
                                    $KsvmTabla .= '<a id="btn-detail" class="btn btn-sm btn-info" href="'.KsvmServUrl.'KsvmCatalogoMedicamentos/Detail/'.KsvmEstMaestra::__KsvmEncriptacion($rows['MdcId']).'/"><i class="zmdi zmdi-card"></i></a>
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
                echo '<script> window.location.href=" '.KsvmServUrl.'KsvmMedicamentosCrud/1/"</script>';
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
                    $KsvmTabla .= '<a class = "btn btn-xs btn-success mdl-shadow--8dp " href="'.KsvmServUrl.'KsvmMedicamentosCrud/1/">Primero</a>
                                   <span></span>
                                   <a class = "btn btn-xs btn-default mdl-shadow--8dp " href="'.KsvmServUrl.'KsvmMedicamentosCrud/'.($KsvmPagina-1).'/"><i class="zmdi zmdi-fast-rewind"></i></a>';
                }

                if ($KsvmPagina == $KsvmNPaginas) {
                    $KsvmTabla .= '<button class = "btn btn-xs btn-default mdl-shadow--8dp disabled"><i class="zmdi zmdi-fast-forward"></i></button>
                                   <span></span>
                                   <button class = "btn btn-xs btn-success mdl-shadow--8dp disabled">Último</button>';
                } else {
                    $KsvmTabla .= '<a class="btn btn-xs btn-default mdl-shadow--8dp" href="'.KsvmServUrl.'KsvmMedicamentosCrud/'.($KsvmPagina+1).'/"><i class="zmdi zmdi-fast-forward"></i></a>
                                   <span></span>
                                   <a class="btn btn-xs btn-success mdl-shadow--8dp" href="'.KsvmServUrl.'KsvmMedicamentosCrud/'.($KsvmNPaginas).'/">Último</a>';
                                   
                                   
                }
                
             
                $KsvmTabla .= '</nav></div>';        

            } 

        }else {

            $KsvmTabla = '<div class="full-width text-center" style="padding: 20px 0;">';
            
            if ($KsvmTotalReg >= 1 && $KsvmPagina <= $KsvmNPaginas) {
                $KsvmContReg = $KsvmDesde +1;
                foreach ($KsvmQuery as $rows) {
                                    
                    $KsvmTabla .= '
                                    <div class="mdl-card mdl-shadow--16dp full-width product-card">
                                    <button class="btn btn-md" style="width:100%; background-color:'.$rows['CtgColorCat'].';">'.$rows['CtgNomCat'].'</button>
                                    <div class="mdl-card__title">
                                    <img height="100px" width="100%" src="data:image/jpg;base64,'. base64_encode($rows['MdcFotoMed']).'"/>
                                    </div>
                                    <div class="mdl-card__supporting-text">
                                        <small>'.$rows['MdcPresenMed'].'</small><br>
                                        <small>'.$rows['MdcConcenMed'].'</small><br>
                                    </div>
                                    <div class="mdl-card__actions mdl-card--border">
                                        '.$rows['MdcDescMed'].'
                                        <a class="mdl-button mdl-button--icon mdl-js-button mdl-js-ripple-effect" id="btn-detail" 
                                        href="'.KsvmServUrl.'KsvmCatalogoMedicamentos/Detail/'.KsvmEstMaestra::__KsvmEncriptacion($rows['MdcId']).'/">
                                        <i class="zmdi zmdi-more"></i>
                                        </a>
                                    </div>';
    
                                        
    
                    $KsvmTabla .= '</div>';
                                 $KsvmContReg ++;
                                 }
    
                                
                    $KsvmTabla .= '</div>
    
                               <br>
                               <div class=" mdl-shadow--8dp full-width">
                                <nav class="navbar-form navbar-left form-group" style="margin-left: 20px;">
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
                    echo '<script> window.location.href=" '.KsvmServUrl.'KsvmCatalogoMedicamentos/1/"</script>';
                } else {
                    $KsvmTabla .= '<div class="navbar-form navbar-left> 
                                   <div class="mdl-data-table__cell--non-numeric" colspan="7"><strong>No se encontraron registros...</strong></div>
                                   </div>';
    
                }
            }
    
                 if ($KsvmTotalReg >= 1 && $KsvmPagina <= $KsvmNPaginas && $KsvmCodigo == 1)  {
                    $KsvmTabla .= '<nav class="navbar-form navbar-right form-group" style="margin-right: 20px;">';
                    
                    if ($KsvmPagina == 1) {
                        $KsvmTabla .= '<button class = "btn btn-xs btn-success mdl-shadow--8dp disabled">Primero</button>
                                       <span></span>
                                       <button class = "btn btn-xs btn-default mdl-shadow--8dp disabled"><i class="zmdi zmdi-fast-rewind"></i></button>';
                    } else {
                        $KsvmTabla .= '<a class = "btn btn-xs btn-success mdl-shadow--8dp " href="'.KsvmServUrl.'KsvmCatalogoMedicamentos/1/">Primero</a>
                                       <span></span>
                                       <a class = "btn btn-xs btn-default mdl-shadow--8dp " href="'.KsvmServUrl.'KsvmCatalogoMedicamentos/'.($KsvmPagina-1).'/"><i class="zmdi zmdi-fast-rewind"></i></a>';
                    }
    
                    if ($KsvmPagina == $KsvmNPaginas) {
                        $KsvmTabla .= '<button class = "btn btn-xs btn-default mdl-shadow--8dp disabled"><i class="zmdi zmdi-fast-forward"></i></button>
                                       <span></span>
                                       <button class = "btn btn-xs btn-success mdl-shadow--8dp disabled">Último</button>';
                    } else {
                        $KsvmTabla .= '<a class="btn btn-xs btn-default mdl-shadow--8dp" href="'.KsvmServUrl.'KsvmCatalogoMedicamentos/'.($KsvmPagina+1).'/"><i class="zmdi zmdi-fast-forward"></i></a>
                                       <span></span>
                                       <a class="btn btn-xs btn-success mdl-shadow--8dp" href="'.KsvmServUrl.'KsvmCatalogoMedicamentos/'.($KsvmNPaginas).'/">Último</a>';
                                        
                    }
                    
                    $KsvmTabla .= '</nav></div>'; 
                }
      }
      return $KsvmTabla;
    }
     
      /**
       * Función que permite inhabilitar un Medicamento 
       */
      public function __KsvmEliminarMedicamentoControlador()
      {
         $KsvmCode = KsvmEstMaestra :: __KsvmDesencriptacion($_POST['KsvmCodDelete']);
         $KsvmCodMedicamento = KsvmEstMaestra :: __KsvmFiltrarCadena($KsvmCode);

         $KsvmDelMed = KsvmMedicamentoModelo :: __KsvmEliminarMedicamentoModelo($KsvmCodMedicamento);
         if ($KsvmDelMed->rowCount() == 1) {
            $KsvmAlerta = [
                "Alerta" => "Actualiza",
                "Titulo" => "Medicamento Inhabilitado",
                "Cuerpo" => "El Medicamento seleccionado ha sido inhabilitado con éxito",
                "Tipo" => "success"
                ];
             
         } else {
            $KsvmAlerta = [
                "Alerta" => "simple",
                "Titulo" => "Error inesperado",
                "Cuerpo" => "No es posible eliminar el Medicamento del sistema",
                "Tipo" => "info"
                ];
         }

         return KsvmEstMaestra :: __KsvmMostrarAlertas($KsvmAlerta);
      }
    
      /**
       * Función que permite editar un Medicamento 
       */
      public function __KsvmEditarMedicamentoControlador($KsvmCodMedicamento)
      {
          $KsvmCodigo = KsvmEstMaestra :: __KsvmDesencriptacion($KsvmCodMedicamento);

          return KsvmMedicamentoModelo :: __KsvmEditarMedicamentoModelo($KsvmCodigo);
      }
      
      /**
       * Función que permite contar un Medicamento 
       */
      public function __KsvmContarMedicamentoControlador()
      {
          return KsvmMedicamentoModelo :: __KsvmContarMedicamentoModelo(0);
      }

      /**
       * Función que permite imprimir una Medicamento 
       */
      public function __KsvmImprimirMedicamentoControlador()
      {
        return KsvmMedicamentoModelo :: __KsvmImprimirMedicamentoModelo();
      }

      /**
       * Función que permite actualizar un Medicamento 
       */
      public function __KsvmActualizarMedicamentoControlador()
      {
        $KsvmCodMedicamento = KsvmEstMaestra :: __KsvmDesencriptacion($_POST['KsvmCodEdit']);
        $KsvmCtgId = KsvmEstMaestra :: __KsvmFiltrarCadena($_POST['KsvmCtgId']);
        $KsvmCodMed = KsvmEstMaestra :: __KsvmFiltrarCadena($_POST['KsvmCodMed']);
        $KsvmDescMed = KsvmEstMaestra :: __KsvmFiltrarCadena($_POST['KsvmDescMed']);
        $KsvmPresenMed = KsvmEstMaestra :: __KsvmFiltrarCadena($_POST['KsvmPresenMed']);
        $KsvmConcenMed = KsvmEstMaestra :: __KsvmFiltrarCadena($_POST['KsvmConcenMed']);
        $KsvmNivPrescMed = KsvmEstMaestra :: __KsvmFiltrarCadena($_POST['KsvmNivPrescMed']);
        $KsvmNivAtencMed = KsvmEstMaestra :: __KsvmFiltrarCadena($_POST['KsvmNivAtencMed']);
        $KsvmViaAdmMed = KsvmEstMaestra :: __KsvmFiltrarCadena($_POST['KsvmViaAdmMed']);
        if ($_FILES['KsvmFotoMed']['error'] > 0) {
            $KsvmFotoMed = "";
        } else {
            $KsvmFotoMed = file_get_contents($_FILES['KsvmFotoMed']['tmp_name']);
        } 
        

        $KsvmActualMed = [
            "KsvmCtgId" => $KsvmCtgId,
            "KsvmCodMed" => $KsvmCodMed,
            "KsvmDescMed" => $KsvmDescMed,
            "KsvmPresenMed" => $KsvmPresenMed,
            "KsvmConcenMed" => $KsvmConcenMed,
            "KsvmNivPrescMed" => $KsvmNivPrescMed,
            "KsvmNivAtencMed" => $KsvmNivAtencMed,
            "KsvmViaAdmMed" => $KsvmViaAdmMed,
            "KsvmFotoMed" => $KsvmFotoMed,
            "KsvmCodMedicamento" => $KsvmCodMedicamento
            ];

            $KsvmGuardarMed = KsvmMedicamentoModelo :: __KsvmActualizarMedicamentoModelo($KsvmActualMed);
                if ($KsvmGuardarMed->rowCount() >= 1) {
                    $KsvmAlerta = [
                    "Alerta" => "Actualiza",
                    "Titulo" => "Grandioso",
                    "Cuerpo" => "El Medicamento se actualizó satisfactoriamente",
                    "Tipo" => "success"
                    ];
                } else {
                    $KsvmAlerta = [
                    "Alerta" => "simple",
                    "Titulo" => "Error inesperado",
                    "Cuerpo" => "No se a podido actualizar la información del Medicamento",
                    "Tipo" => "info"
                    ];
                }
                return KsvmEstMaestra :: __KsvmMostrarAlertas($KsvmAlerta);
         
        }

        public function __KsvmSeleccionarMedicamento(){
            $KsvmSelectMed = "SELECT * FROM ksvmseleccionamedicamento ORDER BY MdcDescMed";

            $KsvmConsulta = KsvmEstMaestra :: __KsvmConexion();
            $KsvmQuery = $KsvmConsulta->query($KsvmSelectMed);
            $KsvmQuery = $KsvmQuery->fetchAll();
            
            foreach ($KsvmQuery as $row) {
                $KsvmListar .= '<option value="'.$row['MdcId'].'">'.$row['MdcDescMed'].' '.$row['MdcConcenMed'].'</option>';
            }
            return $KsvmListar;
        }
    
}
   
 