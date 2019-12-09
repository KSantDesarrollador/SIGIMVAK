<?php

/** Copyright 2019 Klever Santiago Vaca Muela*/

     class KsvmVistaModelo
     {
       /**
        *Funcion que permite cargar las diferentes vistas
        */
       protected function __KsvmCargarContenidoModelo($KsvmVistas)
       {
          $KsvmPermitidas = ["KsvmEscritorioAdmin", "KsvmEscritorioTec", "KsvmEscritorioUsu", "KsvmCatalogoMedicamentos", "KsvmCompras", "KsvmDetallesCompraEditar",
           "KsvmInventarios", "KsvmDetallesInventarioEditar", "KsvmProveedores", "KsvmEmpleados", "KsvmUsuarios", "KsvmBitacora" , "KsvmIngresos", "KsvmEgresos", 
           "KsvmRequisiciones", "KsvmDetallesRequisicionEditar", "KsvmReporteGeneral", "KsvmReporteEstadistico", "KsvmAuditoria", "KsvmAlertas", "KsvmAlertasCrud", 
           "KsvmAlertasEditar", "KsvmBodegas", "KsvmBodegasCrud", "KsvmBodegasEditar", "KsvmBodegaXUsuarioCrud", "KsvmBodegaXUsuarioEditar", "KsvmCargosCrud", 
           "KsvmCargosEditar", "KsvmCategoriasCrud", "KsvmCategoriasEditar", "KsvmComprasCrud", "KsvmComprasEditar", "KsvmEmpleadosCrud", "KsvmEmpleadosEditar", 
           "KsvmExistencias", "KsvmExistenciasCrud", "KsvmExistenciasEditar", "KsvmInventariosCrud", "KsvmInventariosEditar", "KsvmMedicamentosCrud", 
           "KsvmMedicamentosEditar", "KsvmMenuCrud", "KsvmMenuEditar", "KsvmMenuXRolCrud", "KsvmMenuXRolEditar", "KsvmParametros", "KsvmParametrosCrud", 
           "KsvmProcedenciaCrud", "KsvmProcedenciasEditar", "KsvmProveedoresCrud", "KsvmProveedoresEditar", "KsvmRequisicionesCrud", "KsvmRequisicionesEditar", 
           "KsvmRolesCrud", "KsvmRolesEditar", "KsvmTransaccionesCrud", "KsvmTransaccionesEditar", "KsvmDetallesTransaccionEditar", "KsvmUnidadesMedicasCrud", 
           "KsvmUnidadesMedicasEditar", "KsvmUsuariosCrud", "KsvmUsuariosEditar"];

           if (in_array($KsvmVistas, $KsvmPermitidas)) {
              if (is_file("./Vistas/Contenidos/" . $KsvmVistas . ".php")) {
                $KsvmContenido = "./Vistas/Contenidos/" . $KsvmVistas . ".php";
              } else {
                 $KsvmContenido = "Login";
              }

           }elseif ($KsvmVistas == "Login") {
              $KsvmContenido = "Login";
           } elseif ($KsvmVistas == "index") {
               $KsvmContenido = "Login";
           } else{
                $KsvmContenido = "404";
           }
            return $KsvmContenido;
       }
     }
