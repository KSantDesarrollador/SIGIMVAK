<?php

  /**
   *Condicion para peticion Ajax
   */
   if ($KsvmPeticionAjax) {
       require_once "../Raiz/KsvmEstMaestra.php";
   } else {
       require_once "./Raiz/KsvmEstMaestra.php";
   }

   class KsvmAuditoriaModelo extends KsvmEstMaestra
   {
           /**
      *Función que permite imprimir una sesión de auditoría
      */
      protected function __KsvmImprimirAuditoriaModelo()
      {
          $KsvmImprimirAuditoria = "SELECT * FROM ksvmauditoria19";
          $KsvmQuery = KsvmEstMaestra :: __KsvmConexion()->query($KsvmImprimirAuditoria);
          return $KsvmQuery;
      }
     /**
      *Función que permite imprimir una sesión de auditoría
      */
      protected function __KsvmImprimirDetalleAuditoriaModelo($KsvmCodAud)
      {
          $KsvmImprimirAuditoria = "SELECT * FROM ksvmauditoria19 WHERE AdtId = '$KsvmCodAud'";
          $KsvmQuery = KsvmEstMaestra :: __KsvmConexion()->query($KsvmImprimirAuditoria);
          return $KsvmQuery;
      }
     /**
      *Función que permite contar una auditoría
      */
      protected function __KsvmContarAuditoriaModelo($KsvmCodAuditoria)
      {
          $KsvmContarAuditoria = "SELECT AdtId FROM ksvmauditoria19";
          $KsvmQuery = KsvmEstMaestra :: __KsvmConexion()->prepare($KsvmContarAuditoria);
          $KsvmQuery->execute();
          return $KsvmQuery;
      }
   }