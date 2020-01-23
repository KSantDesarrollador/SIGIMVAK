<?php

  /**
   *Condicion para peticion Ajax
   */
   if ($KsvmPeticionAjax) {
       require_once "../Modelos/KsvmUnidadMedicaModelo.php";
   } else {
       require_once "./Modelos/KsvmUnidadMedicaModelo.php";
   }

   class KsvmUnidadMedicaControlador extends KsvmUnidadMedicaModelo
   {
     /**
      *Función que permite ingresar un UnidadMedica
      */
     public function __KsvmAgregarUnidadMedicaControlador()
     {
        if ($_POST['KsvmIdParroquia'] == "") {
            $KsvmCodProc = $_POST['KsvmIdPais'];
         } else {
            $KsvmCodProc = $_POST['KsvmIdParroquia'];
         }
         
         
         $KsvmPrcId = KsvmEstMaestra :: __KsvmFiltrarCadena($KsvmCodProc);
         $KsvmIdentUdm = KsvmEstMaestra :: __KsvmFiltrarCadena($_POST['KsvmIdentUdm']);
         $KsvmNomUdm = KsvmEstMaestra :: __KsvmFiltrarCadena($_POST['KsvmNomUdm']);
         $KsvmTelfUdm = KsvmEstMaestra :: __KsvmFiltrarCadena($_POST['KsvmTelfUdm']);
         $KsvmDirUdm = KsvmEstMaestra :: __KsvmFiltrarCadena($_POST['KsvmDirUdm']);
         $KsvmEmailUdm = KsvmEstMaestra :: __KsvmFiltrarCadena($_POST['KsvmEmailUdm']);

         $KsvmEmaUd = "";

         $KsvmIdentificacion = "SELECT UmdIdentUdm FROM ksvmunidadmedica09 WHERE UmdIdentUdm ='$KsvmIdentUdm'";
         $KsvmQuery = KsvmEstMaestra :: __KsvmEjecutaConsulta($KsvmIdentificacion);
         if ($KsvmQuery->rowCount() >= 1) {
            $KsvmAlerta = [
              "Alerta" => "simple",
              "Titulo" => "Error inesperado",
              "Cuerpo" => "El número de identificación ingresado ya se encuentra registrado, Por favor ingrese un número válido",
              "Tipo" => "info"
             ];
         } elseif ($KsvmEmailUdm != "") {
              $KsvmEmailQ = "SELECT UmdEmailUdm FROM ksvmunidadmedica09 WHERE UmdEmailUdm ='$KsvmEmailUdm'";
              $KsvmQuery = KsvmEstMaestra :: __KsvmEjecutaConsulta($KsvmEmailQ);
              $KsvmEmaUd = $KsvmQuery->rowCount();
           }else{
               $KsvmEmaUd = 0;
           }
         
             if ($KsvmEmaUd >= 1) {
               $KsvmAlerta = [
               "Alerta" => "simple",
               "Titulo" => "Error inesperado",
               "Cuerpo" => "El Email ingresado ya se encuentra registrado, Por favor ingrese un Email válido",
               "Tipo" => "info"
              ];
             }else{
              $KsvmNuevaUndMed = [
                "KsvmPrcId" => $KsvmPrcId,
                "KsvmIdentUdm" => $KsvmIdentUdm,
                "KsvmNomUdm" => $KsvmNomUdm,
                "KsvmTelfUdm" => $KsvmTelfUdm,
                "KsvmDirUdm" => $KsvmDirUdm,
                "KsvmEmailUdm" => $KsvmEmailUdm
                ];

                $KsvmGuardarUndMed = KsvmUnidadMedicaModelo :: __KsvmAgregarUnidadMedicaModelo($KsvmNuevaUndMed);
                if ($KsvmGuardarUndMed->rowCount() >= 1) {
                    $KsvmAlerta = [
                    "Alerta" => "Actualiza",
                    "Titulo" => "Grandioso",
                    "Cuerpo" => "La Unidad Médica se registró satisfactoriamente",
                    "Tipo" => "success"
                    ];
                } else {
                    $KsvmAlerta = [
                    "Alerta" => "simple",
                    "Titulo" => "Error inesperado",
                    "Cuerpo" => "No se a podido registrar la Unidad Médica",
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
            $KsvmDataUndMed = "SELECT SQL_CALC_FOUND_ROWS * FROM ksvmunidadmedica09 WHERE ((UmdEstUdm = 'A') AND (UmdIdentUdm LIKE '%$KsvmBuscar%' 
                          OR UmdNomUdm LIKE '%$KsvmBuscar%' OR UmdEmailUdm LIKE '%$KsvmBuscar%')) 
                          LIMIT $KsvmDesde, $KsvmNRegistros";
        } else {
            $KsvmDataUndMed = "SELECT SQL_CALC_FOUND_ROWS * FROM ksvmunidadmedica09 WHERE UmdEstUdm = 'A' LIMIT $KsvmDesde, $KsvmNRegistros" ;
        }
        

        $KsvmConsulta = KsvmEstMaestra :: __KsvmConexion();
    
        $KsvmQuery = $KsvmConsulta->query($KsvmDataUndMed);
        $KsvmQuery = $KsvmQuery->fetchAll();
        
        $KsvmDataTot = "SELECT FOUND_ROWS()";
        $KsvmTotalReg = $KsvmConsulta->query($KsvmDataTot);
        $KsvmTotalReg = (int) $KsvmTotalReg->fetchColumn();
        $KsvmNPaginas = ceil($KsvmTotalReg/$KsvmNRegistros);

        $KsvmTabla .= '<table class="mdl-data-table mdl-js-data-table mdl-shadow--6dp full-width table-responsive">
                        <thead>
                            <tr>
                                <th class="mdl-data-table__cell--non-numeric">#</th>
                                <th class="mdl-data-table__cell--non-numeric">Ruc</th>
                                <th class="mdl-data-table__cell--non-numeric">Nombre</th>
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
                                <td class="mdl-data-table__cell--non-numeric">'.$rows['UmdIdentUdm'].'</td>
                                <td class="mdl-data-table__cell--non-numeric">'.$rows['UmdNomUdm'].'</td>
                                <td class="mdl-data-table__cell--non-numeric">'.$rows['UmdTelfUdm'].'</td>
                                <td class="mdl-data-table__cell--non-numeric">'.$rows['UmdDirUdm'].'</td>
                                <td class="mdl-data-table__cell--non-numeric">'.$rows['UmdEmailUdm'].'</td>
                                <td style="text-align:right; witdh:30px;">';
                                if ($KsvmRol == 1) {
                                    $KsvmTabla .= '<form action="'.KsvmServUrl.'Ajax/KsvmUnidadMedicaAjax.php" method="POST" class="FormularioAjax" data-form="eliminar" enctype="multipart/form-data"> 
                                                   <a id="btn-detail" class="btn btn-sm btn-info" href="'.KsvmServUrl.'KsvmUnidadesMedicasCrud/Detail/'.KsvmEstMaestra::__KsvmEncriptacion($rows['UmdId']).'/"><i class="zmdi zmdi-card"></i></a>
                                                   <div class="mdl-tooltip" for="btn-detail">Detalles</div>
                                                   <a id="btn-edit" class="btn btn-sm btn-primary" href="'.KsvmServUrl.'KsvmUnidadesMedicasEditar/'.KsvmEstMaestra::__KsvmEncriptacion($rows['UmdId']).'/0/"><i class="zmdi zmdi-edit"></i></a>
                                                   <div class="mdl-tooltip" for="btn-edit">Editar</div>   
                                                   <input type="hidden" name="KsvmCodDelete" value="'.KsvmEstMaestra::__KsvmEncriptacion($rows['UmdId']).'">              
                                                   <button id="btn-delete" type="submit" class="btn btn-sm btn-danger"><i class="zmdi zmdi-delete"></i></button>
                                                   <div class="mdl-tooltip" for="btn-delete">Inhabilitar</div>
                                                   <div class="RespuestaAjax"></div>
                                                   </form>';
                                }elseif ($KsvmRol == 2){
                                    $KsvmTabla .= '<a id="btn-detail" class="btn btn-sm btn-info" href="'.KsvmServUrl.'KsvmUnidadesMedicasCrud/Detail/'.KsvmEstMaestra::__KsvmEncriptacion($rows['UmdId']).'/"><i class="zmdi zmdi-card"></i></a>
                                                    <div class="mdl-tooltip" for="btn-detail">Detalles</div>
                                                    <a id="btn-edit" class="btn btn-sm btn-primary" href="'.KsvmServUrl.'KsvmUnidadesMedicasEditar/'.KsvmEstMaestra::__KsvmEncriptacion($rows['UmdId']).'/1/"><i class="zmdi zmdi-edit"></i></a>
                                                    <div class="mdl-tooltip" for="btn-edit">Editar</div>';
                                }else{
                                    $KsvmTabla .= '<a id="btn-detail" class="btn btn-sm btn-info" href="'.KsvmServUrl.'KsvmUnidadesMedicasCrud/Detail/'.KsvmEstMaestra::__KsvmEncriptacion($rows['UmdId']).'/"><i class="zmdi zmdi-card"></i></a>
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
                echo '<script> window.location.href=" '.KsvmServUrl.'KsvmUnidadesMedicasCrud"</script>';
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
                    $KsvmTabla .= '<a class = "btn btn-xs btn-success mdl-shadow--8dp " href="'.KsvmServUrl.'KsvmUnidadesMedicasCrud/1/">Primero</a>
                                   <span></span>
                                   <a class = "btn btn-xs btn-default mdl-shadow--8dp " href="'.KsvmServUrl.'KsvmUnidadesMedicasCrud/'.($KsvmPagina-1).'/"><i class="zmdi zmdi-fast-rewind"></i></a>';
                }

                if ($KsvmPagina == $KsvmNPaginas) {
                    $KsvmTabla .= '<button class = "btn btn-xs btn-default mdl-shadow--8dp disabled"><i class="zmdi zmdi-fast-forward"></i></button>
                                   <span></span>
                                   <button class = "btn btn-xs btn-success mdl-shadow--8dp disabled">Último</button>';
                } else {
                    $KsvmTabla .= '<a class="btn btn-xs btn-default mdl-shadow--8dp" href="'.KsvmServUrl.'KsvmUnidadesMedicasCrud/'.($KsvmPagina+1).'/"><i class="zmdi zmdi-fast-forward"></i></a>
                                   <span></span>
                                   <a class="btn btn-xs btn-success mdl-shadow--8dp" href="'.KsvmServUrl.'KsvmUnidadesMedicasCrud/'.($KsvmNPaginas).'/">Último</a>';
                                   
                                   
                }
                
             
                $KsvmTabla .= '</nav></div>';                
            }
            
        
                                   
        return $KsvmTabla;
      }
     
      /**
       * Función que permite inhabilitar un UnidadMedica 
       */
      public function __KsvmEliminarUnidadMedicaControlador()
      {
         $KsvmCode = KsvmEstMaestra :: __KsvmDesencriptacion($_POST['KsvmCodDelete']);
         $KsvmCodUnidadMedica = KsvmEstMaestra :: __KsvmFiltrarCadena($KsvmCode);

         $KsvmDelUndMed = KsvmUnidadMedicaModelo :: __KsvmEliminarUnidadMedicaModelo($KsvmCodUnidadMedica);
         if ($KsvmDelUndMed->rowCount() == 1) {
            $KsvmAlerta = [
                "Alerta" => "Actualiza",
                "Titulo" => "UnidadMedica Inhabilitado",
                "Cuerpo" => "La Unidad Médica seleccionada ha sido inhabilitada con éxito",
                "Tipo" => "success"
                ];
             
         } else {
            $KsvmAlerta = [
                "Alerta" => "simple",
                "Titulo" => "Error inesperado",
                "Cuerpo" => "No es posible eliminar la Unidad Médica del sistema",
                "Tipo" => "info"
                ];
         }

         return KsvmEstMaestra :: __KsvmMostrarAlertas($KsvmAlerta);
      }
    
      /**
       * Función que permite editar un UnidadMedica 
       */
      public function __KsvmEditarUnidadMedicaControlador($KsvmCodUnidadMedica)
      {
          $KsvmCodigo = KsvmEstMaestra :: __KsvmDesencriptacion($KsvmCodUnidadMedica);

          return KsvmUnidadMedicaModelo :: __KsvmEditarUnidadMedicaModelo($KsvmCodigo);
      }
      
      /**
       * Función que permite contar un UnidadMedica 
       */
      public function __KsvmContarUnidadMedicaControlador()
      {
          return KsvmUnidadMedicaModelo :: __KsvmContarUnidadMedicaModelo(0);
      }

      /**
       * Función que permite imprimir una UnidadMedica 
       */
      public function __KsvmImprimirUnidadMedicaControlador()
      {
        return KsvmUnidadMedicaModelo :: __KsvmImprimirUnidadMedicaModelo();
      }

      /**
       * Función que permite actualizar un UnidadMedica 
       */
      public function __KsvmActualizarUnidadMedicaControlador()
      {
        $KsvmCodUnidadMedica = KsvmEstMaestra :: __KsvmDesencriptacion($_POST['KsvmCodEdit']);
        if ($_POST['KsvmIdParroquia'] == "") {
            $KsvmCodProc = $_POST['KsvmIdPais'];
         } else {
            $KsvmCodProc = $_POST['KsvmIdParroquia'];
         }
         
         
        $KsvmPrcId = KsvmEstMaestra :: __KsvmFiltrarCadena($KsvmCodProc);
        $KsvmIdentUdm = KsvmEstMaestra :: __KsvmFiltrarCadena($_POST['KsvmIdentUdm']);
        $KsvmNomUdm = KsvmEstMaestra :: __KsvmFiltrarCadena($_POST['KsvmNomUdm']);
        $KsvmTelfUdm = KsvmEstMaestra :: __KsvmFiltrarCadena($_POST['KsvmTelfUdm']);
        $KsvmDirUdm = KsvmEstMaestra :: __KsvmFiltrarCadena($_POST['KsvmDirUdm']);
        $KsvmEmailUdm = KsvmEstMaestra :: __KsvmFiltrarCadena($_POST['KsvmEmailUdm']);

        $KsvmConsulta = "SELECT * FROM ksvmunidadmedica09 WHERE UmdId = '$KsvmCodUnidadMedica'";
        $KsvmQuery = KsvmEstMaestra :: __KsvmEjecutaConsulta($KsvmConsulta);
        $KsvmDataUnidadMedica = $KsvmQuery->fetch();

        if ($KsvmIdentUdm != $KsvmDataUnidadMedica['UmdIdentUdm']) {
            $KsvmConsulta = "SELECT UmdIdentUdm FROM ksvmunidadmedica09 WHERE UmdIdentUdm = '$KsvmIdentUdm'";
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

        $KsvmActualUndMed = [
            "KsvmPrcId" => $KsvmPrcId,
            "KsvmIdentUdm" => $KsvmIdentUdm,
            "KsvmNomUdm" => $KsvmNomUdm,
            "KsvmTelfUdm" => $KsvmTelfUdm,
            "KsvmDirUdm" => $KsvmDirUdm,
            "KsvmEmailUdm" => $KsvmEmailUdm,
            "KsvmCodUnidadMedica" => $KsvmCodUnidadMedica
            ];

            $KsvmGuardarUndMed = KsvmUnidadMedicaModelo :: __KsvmActualizarUnidadMedicaModelo($KsvmActualUndMed);
                if ($KsvmGuardarUndMed->rowCount() >= 1) {
                    $KsvmAlerta = [
                    "Alerta" => "Actualiza",
                    "Titulo" => "Grandioso",
                    "Cuerpo" => "La Unidad Médica se actualizó satisfactoriamente",
                    "Tipo" => "success"
                    ];
                } else {
                    $KsvmAlerta = [
                    "Alerta" => "simple",
                    "Titulo" => "Error inesperado",
                    "Cuerpo" => "No se a podido actualizar la información de la Unidad Médica",
                    "Tipo" => "info"
                    ];
                }
                return KsvmEstMaestra :: __KsvmMostrarAlertas($KsvmAlerta);
         
        }

        public function __KsvmSeleccionarUndMedica(){
            $KsvmSelectCat = "SELECT * FROM ksvmvistaunidadesmedicas";

            $KsvmConsulta = KsvmEstMaestra :: __KsvmConexion();
            $KsvmQuery = $KsvmConsulta->query($KsvmSelectCat);
            $KsvmQuery = $KsvmQuery->fetchAll();
            
            foreach ($KsvmQuery as $row) {
                $KsvmListar .= '<option value="'.$row['UmdId'].'">'.$row['UmdNomUdm'].'</option>';
            }
            return $KsvmListar;
        }

    
}
   
 