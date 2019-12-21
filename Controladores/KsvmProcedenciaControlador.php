<?php

  /**
   *Condicion para peticion Ajax
   */
   if ($KsvmPeticionAjax) {
       require_once "../Modelos/KsvmProcedenciaModelo.php";
   } else {
       require_once "./Modelos/KsvmProcedenciaModelo.php";
   }

   class KsvmProcedenciaControlador extends KsvmProcedenciaModelo
   {
     /**
      *Función que permite ingresar una Procedencia
      */
     public function __KsvmAgregarProcedenciaControlador()
     {
         $KsvmJerqProc = KsvmEstMaestra :: __KsvmFiltrarCadena($_POST['KsvmJerqProc']);
         $KsvmCodProc = KsvmEstMaestra :: __KsvmFiltrarCadena($_POST['KsvmCodProc']);
         $KsvmNomProc = KsvmEstMaestra :: __KsvmFiltrarCadena($_POST['KsvmNomProc']);
         $KsvmNivProc = KsvmEstMaestra :: __KsvmFiltrarCadena($_POST['KsvmNivProc']);
         $KsvmDescProc = KsvmEstMaestra :: __KsvmFiltrarCadena($_POST['KsvmDescProc']);

         $KsvmCodigo = "SELECT PrcCodProc FROM ksvmprocedencia06 WHERE PrcCodProc ='$KsvmCodProc'";
         $KsvmQuery = KsvmEstMaestra :: __KsvmEjecutaConsulta($KsvmCodigo);
         if ($KsvmQuery->rowCount() == 1) {
            $KsvmAlerta = [
              "Alerta" => "simple",
              "Titulo" => "Error inesperado",
              "Cuerpo" => "El código ingresado ya se encuentra registrado, Por favor ingrese un código válido",
              "Tipo" => "info"
             ];
          }

            $KsvmNombre = "SELECT PrcNomProc FROM ksvmprocedencia06 WHERE PrcNomProc ='$KsvmNomProc'";
            $KsvmQuery = KsvmEstMaestra :: __KsvmEjecutaConsulta($KsvmNombre);
            if ($KsvmQuery->rowCount() == 1) {
            $KsvmAlerta = [
            "Alerta" => "simple",
            "Titulo" => "Error inesperado",
            "Cuerpo" => "El nombre ya se encuentra registrado, Por favor ingrese un nombre válido",
            "Tipo" => "info"
            ];
            }elseif ($KsvmJerqProc == "") {
                $KsvmJerqProc = 0;

            }else{
              $KsvmNuevaProc = [
                "KsvmJerqProc" => $KsvmJerqProc,
                "KsvmCodProc" => $KsvmCodProc,
                "KsvmNomProc" => $KsvmNomProc,
                "KsvmNivProc" => $KsvmNivProc,
                "KsvmDescProc" => $KsvmDescProc
                ];

                $KsvmGuardarProc = KsvmProcedenciaModelo :: __KsvmAgregarProcedenciaModelo($KsvmNuevaProc);
                if ($KsvmGuardarProc->rowCount() >= 1) {
                    $KsvmAlerta = [
                    "Alerta" => "Limpia",
                    "Titulo" => "Grandioso",
                    "Cuerpo" => "La Procedencia se registró satisfactoriamente",
                    "Tipo" => "success"
                    ];
                } else {
                    $KsvmAlerta = [
                    "Alerta" => "simple",
                    "Titulo" => "Error inesperado",
                    "Cuerpo" => "No se a podido registrar la Procedencia",
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
            $KsvmDataProc = "SELECT SQL_CALC_FOUND_ROWS * FROM ksvmprocedencia06 WHERE ((PrcEstProc = 'A') AND (PrcCodProc LIKE '%$KsvmBuscar%' 
                          OR PrcNomProc LIKE '%$KsvmBuscar%' OR PrcNivProc LIKE '%$KsvmBuscar%')) 
                          LIMIT $KsvmDesde, $KsvmNRegistros";
        } else {
            $KsvmDataProc = "SELECT SQL_CALC_FOUND_ROWS * FROM ksvmprocedencia06 WHERE PrcEstProc = 'A' LIMIT $KsvmDesde, $KsvmNRegistros" ;
        }
        

        $KsvmConsulta = KsvmEstMaestra :: __KsvmConexion();
    
        $KsvmQuery = $KsvmConsulta->query($KsvmDataProc);
        $KsvmQuery = $KsvmQuery->fetchAll();
        
        $KsvmDataTot = "SELECT FOUND_ROWS()";
        $KsvmTotalReg = $KsvmConsulta->query($KsvmDataTot);
        $KsvmTotalReg = (int) $KsvmTotalReg->fetchColumn();
        $KsvmNPaginas = ceil($KsvmTotalReg/$KsvmNRegistros);

        $KsvmTabla .= '<table class="mdl-data-table mdl-js-data-table mdl-shadow--6dp full-width table-responsive">
                        <thead>
                            <tr>
                                <th class="mdl-data-table__cell--non-numeric">#</th>
                                <th class="mdl-data-table__cell--non-numeric">Código</th>
                                <th class="mdl-data-table__cell--non-numeric">Nombre</th>
                                <th class="mdl-data-table__cell--non-numeric">Nivel</th>
                                <th class="mdl-data-table__cell--non-numeric">Descripción</th>
                                <th style="text-align:center; witdh:30px;">Acción</th>
                            </tr>
                        </thead>
                        <tbody>';

        if ($KsvmTotalReg >= 1 && $KsvmPagina <= $KsvmNPaginas) {
            $KsvmContReg = $KsvmDesde +1;
            foreach ($KsvmQuery as $rows) {
                $KsvmTabla .= '<tr>
                                <td class="mdl-data-table__cell--non-numeric">'.$KsvmContReg.'</td>
                                <td class="mdl-data-table__cell--non-numeric">'.$rows['PrcCodProc'].'</td>
                                <td class="mdl-data-table__cell--non-numeric">'.$rows['PrcNomProc'].'</td>
                                <td class="mdl-data-table__cell--non-numeric">'.$rows['PrcNivProc'].'</td>
                                <td class="mdl-data-table__cell--non-numeric">'.$rows['PrcDescProc'].'</td>
                                <td style="text-align:right; witdh:30px;">';
                                if ($KsvmRol == 1) {
                                    $KsvmTabla .= '<form action="'.KsvmServUrl.'Ajax/KsvmProcedenciaAjax.php" method="POST" class="FormularioAjax" data-form="eliminar" enctype="multipart/form-data"> 
                                                   <a id="btn-detail" class="btn btn-sm btn-info" href="'.KsvmServUrl.'KsvmProcedenciaCrud/Detail/'.KsvmEstMaestra::__KsvmEncriptacion($rows['PrcId']).'/"><i class="zmdi zmdi-card"></i></a>
                                                   <div class="mdl-tooltip" for="btn-detail">Detalles</div>
                                                   <a id="btn-edit" class="btn btn-sm btn-primary" href="'.KsvmServUrl.'KsvmProcedenciasEditar/'.KsvmEstMaestra::__KsvmEncriptacion($rows['PrcId']).'/0/"><i class="zmdi zmdi-edit"></i></a>
                                                   <div class="mdl-tooltip" for="btn-edit">Editar</div>   
                                                   <input type="hidden" name="KsvmCodDelete" value="'.KsvmEstMaestra::__KsvmEncriptacion($rows['PrcId']).'">              
                                                   <button id="btn-delete" type="submit" class="btn btn-sm btn-danger"><i class="zmdi zmdi-delete"></i></button>
                                                   <div class="mdl-tooltip" for="btn-delete">Inhabilitar</div>
                                                   <div class="RespuestaAjax"></div>
                                                   </form>';
                                }elseif ($KsvmRol == 2){
                                    $KsvmTabla .= '<a id="btn-detail" class="btn btn-sm btn-info" href="'.KsvmServUrl.'KsvmProcedenciaCrud/Detail/'.KsvmEstMaestra::__KsvmEncriptacion($rows['PrcId']).'/"><i class="zmdi zmdi-card"></i></a>
                                                    <div class="mdl-tooltip" for="btn-detail">Detalles</div>
                                                    <a id="btn-edit" class="btn btn-sm btn-primary" href="'.KsvmServUrl.'KsvmProcedenciasEditar/'.KsvmEstMaestra::__KsvmEncriptacion($rows['PrcId']).'/1/"><i class="zmdi zmdi-edit"></i></a>
                                                    <div class="mdl-tooltip" for="btn-edit">Editar</div>';
                                }else{
                                    $KsvmTabla .= '<a id="btn-detail" class="btn btn-sm btn-info" href="'.KsvmServUrl.'KsvmProcedenciaCrud/Detail/'.KsvmEstMaestra::__KsvmEncriptacion($rows['PrcId']).'/"><i class="zmdi zmdi-card"></i></a>
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
                echo '<script> window.location.href=" '.KsvmServUrl.'KsvmProcedenciaCrud"</script>';
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
                    $KsvmTabla .= '<a class = "btn btn-xs btn-success mdl-shadow--8dp " href="'.KsvmServUrl.'KsvmProcedenciaCrud/1/">Primero</a>
                                   <span></span>
                                   <a class = "btn btn-xs btn-default mdl-shadow--8dp " href="'.KsvmServUrl.'KsvmProcedenciaCrud/'.($KsvmPagina-1).'/"><i class="zmdi zmdi-fast-rewind"></i></a>';
                }

                if ($KsvmPagina == $KsvmNPaginas) {
                    $KsvmTabla .= '<button class = "btn btn-xs btn-default mdl-shadow--8dp disabled"><i class="zmdi zmdi-fast-forward"></i></button>
                                   <span></span>
                                   <button class = "btn btn-xs btn-success mdl-shadow--8dp disabled">Último</button>';
                } else {
                    $KsvmTabla .= '<a class="btn btn-xs btn-default mdl-shadow--8dp" href="'.KsvmServUrl.'KsvmProcedenciaCrud/'.($KsvmPagina+1).'/"><i class="zmdi zmdi-fast-forward"></i></a>
                                   <span></span>
                                   <a class="btn btn-xs btn-success mdl-shadow--8dp" href="'.KsvmServUrl.'KsvmProcedenciaCrud/'.($KsvmNPaginas).'/">Último</a>';
                                   
                                   
                }
                
             
                $KsvmTabla .= '</nav></div>';                
            }
            
        
                                   
        return $KsvmTabla;
      }
     
      /**
       * Función que permite inhabilitar una Procedencia 
       */
      public function __KsvmEliminarProcedenciaControlador()
      {
         $KsvmCode = KsvmEstMaestra :: __KsvmDesencriptacion($_POST['KsvmCodDelete']);
         $KsvmCodProcedencia = KsvmEstMaestra :: __KsvmFiltrarCadena($KsvmCode);

         $KsvmDelProc = KsvmProcedenciaModelo :: __KsvmEliminarProcedenciaModelo($KsvmCodProcedencia);
         if ($KsvmDelProc->rowCount() == 1) {
            $KsvmAlerta = [
                "Alerta" => "Actualiza",
                "Titulo" => "Procedencia Inhabilitado",
                "Cuerpo" => "La Procedencia seleccionada ha sido inhabilitada con éxito",
                "Tipo" => "success"
                ];
             
         } else {
            $KsvmAlerta = [
                "Alerta" => "simple",
                "Titulo" => "Error inesperado",
                "Cuerpo" => "No es posible eliminar la procedencia del sistema",
                "Tipo" => "info"
                ];
         }

         return KsvmEstMaestra :: __KsvmMostrarAlertas($KsvmAlerta);
      }
    
      /**
       * Función que permite editar una Procedencia 
       */
      public function __KsvmEditarProcedenciaControlador($KsvmCodProcedencia)
      {
          $KsvmCodigo = KsvmEstMaestra :: __KsvmDesencriptacion($KsvmCodProcedencia);

          return KsvmProcedenciaModelo :: __KsvmEditarProcedenciaModelo($KsvmCodigo);
      }
      
      /**
       * Función que permite contar una Procedencia 
       */
      public function __KsvmContarProcedenciaControlador()
      {
          return KsvmProcedenciaModelo :: __KsvmContarProcedenciaModelo(0);
      }

      /**
       * Función que permite imprimir una Procedencia 
       */
      public function __KsvmImprimirProcedenciaControlador()
      {
        return KsvmProcedenciaModelo :: __KsvmImprimirProcedenciaModelo();
      }

      /**
       * Función que permite actualizar una Procedencia 
       */
      public function __KsvmActualizarProcedenciaControlador()
      {
        $KsvmCodProcedencia = KsvmEstMaestra :: __KsvmDesencriptacion($_POST['KsvmCodEdit']);
        $KsvmJerqProc = KsvmEstMaestra :: __KsvmFiltrarCadena($_POST['KsvmJerqProc']);
        $KsvmCodProc = KsvmEstMaestra :: __KsvmFiltrarCadena($_POST['KsvmCodProc']);
        $KsvmNomProc = KsvmEstMaestra :: __KsvmFiltrarCadena($_POST['KsvmNomProc']);
        $KsvmNivProc = KsvmEstMaestra :: __KsvmFiltrarCadena($_POST['KsvmNivProc']);
        $KsvmDescProc = KsvmEstMaestra :: __KsvmFiltrarCadena($_POST['KsvmDescProc']);

        $KsvmConsulta = "SELECT * FROM ksvmprocedencia06 WHERE PrcId = '$KsvmCodProcedencia'";
        $KsvmQuery = KsvmEstMaestra :: __KsvmEjecutaConsulta($KsvmConsulta);
        $KsvmDataProcedencia = $KsvmQuery->fetch();

        if ($KsvmCodProc != $KsvmDataProcedencia['PrcCodProc'] || $KsvmNomProc != $KsvmDataProcedencia['PrcNomProc']) {
            $KsvmConsulta = "SELECT PrcCodProc FROM ksvmprocedencia06 WHERE PrcCodProc = '$KsvmCodProc'";
            $KsvmQuery = KsvmEstMaestra :: __KsvmEjecutaConsulta($KsvmConsulta);
            if ($KsvmQuery->rowCount() >= 1) {
                $KsvmAlerta = [
                    "Alerta" => "Actualiza",
                    "Titulo" => "Error Inesperado",
                    "Cuerpo" => "El código ingresado ya se encuentra registrado, Por favor ingrese un código válido",
                    "Tipo" => "info"
                    ];
                    return KsvmEstMaestra :: __KsvmMostrarAlertas($KsvmAlerta);
                    exit();
            }

            $KsvmConsulta = "SELECT PrcNomProc FROM ksvmprocedencia06 WHERE PrcNomProc = '$KsvmNomProc'";
            $KsvmQuery = KsvmEstMaestra :: __KsvmEjecutaConsulta($KsvmConsulta);
            if ($KsvmQuery->rowCount() >= 1) {
                $KsvmAlerta = [
                    "Alerta" => "Actualiza",
                    "Titulo" => "Error Inesperado",
                    "Cuerpo" => "El nombre ingresado ya se encuentra registrado, Por favor ingrese un nombre válido",
                    "Tipo" => "info"
                    ];
                    return KsvmEstMaestra :: __KsvmMostrarAlertas($KsvmAlerta);
                    exit();
            }
        }

        $KsvmActualProc = [
            "KsvmJerqProc" => $KsvmJerqProc,
            "KsvmCodProc" => $KsvmCodProc,
            "KsvmNomProc" => $KsvmNomProc,
            "KsvmNivProc" => $KsvmNivProc,
            "KsvmDescProc" => $KsvmDescProc,
            "KsvmCodProcedencia" => $KsvmCodProcedencia
            ];

            $KsvmGuardarProc = KsvmProcedenciaModelo :: __KsvmActualizarProcedenciaModelo($KsvmActualProc);
                if ($KsvmGuardarProc->rowCount() >= 1) {
                    $KsvmAlerta = [
                    "Alerta" => "Actualiza",
                    "Titulo" => "Grandioso",
                    "Cuerpo" => "La Procedencia se actualizó satisfactoriamente",
                    "Tipo" => "success"
                    ];
                } else {
                    $KsvmAlerta = [
                    "Alerta" => "simple",
                    "Titulo" => "Error inesperado",
                    "Cuerpo" => "No se a podido actualizar la información de la Procedencia",
                    "Tipo" => "info"
                    ];
                }
                return KsvmEstMaestra :: __KsvmMostrarAlertas($KsvmAlerta);
         
        }

        /**
         *Funcion que permite mostrar un país
        */
        public function __KsvmSeleccionarPais(){

            $KsvmSelectPais = "SELECT * FROM ksvmseleccionapais";

            $KsvmConsulta = KsvmEstMaestra :: __KsvmConexion();
            $KsvmQuery = $KsvmConsulta->query($KsvmSelectPais);
            $KsvmQuery = $KsvmQuery->fetchAll();
            $KsvmListar = '<option value="" selected="" disabled>Seleccione Pais</option>';

            foreach ($KsvmQuery as $row) {
                $KsvmListar .= '<option value="'.$row['PrcId'].'">'.$row['PrcNomProc'].'</option>';
            }
            return $KsvmListar;
            
        }

        /**
         *Funcion que permite mostrar una provincia
        */
        public function __KsvmSeleccionarProvincia(){

            $KsvmPadre = $_POST['id'];
            $KsvmSelectProvincia = "SELECT * FROM ksvmseleccionaprovincia WHERE PrcJerqProc = '$KsvmPadre'";

            $KsvmConsulta = KsvmEstMaestra :: __KsvmConexion();
            $KsvmQuery = $KsvmConsulta->query($KsvmSelectProvincia);
            $KsvmQuery = $KsvmQuery->fetchAll();
            $KsvmListar = '<option value="" selected="" disabled>Seleccione Provincia</option>';

            foreach ($KsvmQuery as $row) {
                $KsvmListar .= '<option value="'.$row['PrcId'].'">'.$row['PrcNomProc'].'</option>';
            }
            return $KsvmListar;
        }

        /**
         *Funcion que permite mostrar un cantón
        */
        public function __KsvmSeleccionarCanton(){

            $KsvmPadre = $_POST['id'];
            $KsvmSelectCanton = "SELECT * FROM ksvmseleccionacanton WHERE PrcJerqProc = '$KsvmPadre'";

            $KsvmConsulta = KsvmEstMaestra :: __KsvmConexion();
            $KsvmQuery = $KsvmConsulta->query($KsvmSelectCanton);
            $KsvmQuery = $KsvmQuery->fetchAll();
            $KsvmListar = '<option value="" selected="" disabled>Seleccione Cantón</option>';

            foreach ($KsvmQuery as $row) {
                $KsvmListar .= '<option value="'.$row['PrcId'].'">'.$row['PrcNomProc'].'</option>';
            }
            return $KsvmListar;
        }

        /**
         *Funcion que permite mostrar una paroquia
        */
        public function __KsvmSeleccionarParroquia(){

            $KsvmPadre = $_POST['id'];
            $KsvmSelectParroquia = "SELECT * FROM ksvmseleccionaparroquia WHERE PrcJerqProc = '$KsvmPadre'";

            $KsvmConsulta = KsvmEstMaestra :: __KsvmConexion();
            $KsvmQuery = $KsvmConsulta->query($KsvmSelectParroquia);
            $KsvmQuery = $KsvmQuery->fetchAll();
            $KsvmListar = '<option value="" selected="" disabled>Seleccione Parroquia</option>';

            foreach ($KsvmQuery as $row) {
                $KsvmListar .= '<option value="'.$row['PrcId'].'">'.$row['PrcNomProc'].'</option>';
            }
            return $KsvmListar;
        }
         
        /**
         *Funcion que permite seleccionar la procedencia
        */
        public function __KsvmSeleccionaProcedencia($Data){
            $KsvmSelectProv = "SELECT * FROM ksvmprocedencia06 WHERE PrcId = '$Data'";

            $KsvmConsulta = KsvmEstMaestra :: __KsvmConexion();
            $KsvmQuery = $KsvmConsulta->query($KsvmSelectProv);
            $KsvmQuery = $KsvmQuery->fetch();
            return $KsvmQuery;
        }    

        /**
         *Funcion que permite mostrar la Jerarquía
        */
        public function __KsvmMostrarJerarquia($KsvmJerq)
        {
        $KsvmJerarquia = "SELECT * FROM ksvmprocedencia06 WHERE PrcEstProc = 'A' AND PrcId = '$KsvmJerq' ";
        $KsvmQuery = KsvmEstMaestra :: __KsvmConexion()->query($KsvmJerarquia);

        return $KsvmQuery;
        }
    
}
   
 