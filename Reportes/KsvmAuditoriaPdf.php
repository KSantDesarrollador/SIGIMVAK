<?php
require_once 'PDF/fpdf.php';
require_once '../Raiz/KsvmConfiguracion.php';

if (isset($_GET['Cod'])) {
  
  class PDF extends FPDF
{ 

// Cabecera de página
function Header()
{
  $KsvmUrlImg = '../Vistas/assets/img/medicamentos.png';
    // Logo
    $this->Image($KsvmUrlImg,10,10,20);
    // Arial bold 15
    $this->SetFont('Arial','B',17);
    // Movernos a la derecha
    $this->Cell(80);
    // Título
    $this->Cell(30,10,'SIGIMVAK',0,0,'C');
    // Movernos a la derecha
    $this->Cell(45);
    // Arial bold 10
    $this->SetFont('Arial','B',9);
    setlocale(LC_ALL, 'es_EC.UTF-8');
    $this->Cell(30,10,strftime("%d  de %B del %Y"),0,0,'C'); //date("d") . " de " . date("F") . " del " . date("Y")
    // Salto de línea
    $this->Ln(10);
    // Arial bold 12
    $this->SetFont('Arial','B',14);
    $this->Cell(50,10,'_____________________________________________________________________', 0,0);
    // Salto de línea
    $this->Ln(15);
    // Movernos a la derecha
    $this->Cell(80);
    // Título
    $this->Cell(30,10,utf8_decode('Detalle de Auditoría'),0,0,'C');
    // Salto de línea
    $this->Ln(15);
    // Arial bold 11
    $this->SetFont('Arial','B',10);

}

// Pie de página
function Footer()
{
    // Posición: a 1,5 cm del final
    $this->SetY(-15);
    // Arial italic 8
    $this->SetFont('Arial','B',8);
    // Número de página
    $this->Cell(0,10,utf8_decode('Página').$this->PageNo().'/{nb}',0,0,'C');
}
}
$KsvmPeticionAjax = true;
require_once "../Controladores/KsvmAuditoriaControlador.php";
$KsvmIniBitacora = new KsvmAuditoriaControlador();

$KsvmQuery = $KsvmIniBitacora->__KsvmImprimirDetalleAuditoriaControlador($_GET['Cod']);
if ($KsvmQuery->rowCount() >= 1) {
    $KsvmListaAuditoria = $KsvmQuery->fetchAll();
    // Creación del objeto de la clase heredada
$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Times','',9);
foreach ($KsvmListaAuditoria as $row){
    if ($row['AdtValorAntAud'] != NULL) {
        $KsvmValAnt = $row['AdtValorAntAud'];
    }else{
        $KsvmValAnt = "Sin datos";
    }
    if ($row['AdtValorNvoAud'] != NULL) {
        $KsvmValNvo = $row['AdtValorNvoAud'];
    }else{
        $KsvmValNvo = "Sin datos";
    }
    if ($row['AdtFchCreaAud'] != NULL) {
        $KsvmFchCrea = $row['AdtFchCreaAud'];
    }else{
        $KsvmFchCrea = "Sin datos";
    }
    if ($row['AdtFchModAud'] != NULL) {
        $KsvmFchMod = $row['AdtFchModAud'];
    }else{
        $KsvmFchMod = "Sin datos";
    }

  $pdf->Cell(40);
  $pdf->Cell(60,13,utf8_decode('Tabla'),1,0,'C');
  $pdf->Cell(60,13,$row['AdtNomTabAud'],1,1,'C');
  $pdf->Cell(40);
  $pdf->Cell(60,13,utf8_decode('Id.Registro'),1,0,'C');
  $pdf->Cell(60,13,$row['AdtIdRegAud'],1,1,'C');
  $pdf->Cell(40);
  $pdf->Cell(60,13,utf8_decode('Campo'),1,0,'C');
  $pdf->Cell(60,13,$row['AdtCampTabAud'],1,1,'C');
  $pdf->Cell(40);
  $pdf->Cell(60,13,utf8_decode('Val.Anterior'),1,0,'C');
  $pdf->Cell(60,13,$KsvmValAnt,1,1,'C');
  $pdf->Cell(40);
  $pdf->Cell(60,13,utf8_decode('Val.Nuevo'),1,0,'C');
  $pdf->Cell(60,13,$KsvmValNvo,1,1,'C');
  $pdf->Cell(40);
  $pdf->Cell(60,13,utf8_decode('Fch.Crea'),1,0,'C');
  $pdf->Cell(60,13,$KsvmFchCrea,1,1,'C');
  $pdf->Cell(40);
  $pdf->Cell(60,13,utf8_decode('Fch.Mod'),1,0,'C');
  $pdf->Cell(60,13,$KsvmFchMod,1,1,'C');
  $pdf->Cell(40);
  $pdf->Cell(60,13,utf8_decode('Usuario'),1,0,'C');
  $pdf->Cell(60,13,$row['AdtUsuModAud'],1,1,'C');
  $pdf->Cell(40);
  $pdf->Cell(60,13,utf8_decode('Sentencia'),1,0,'C');
  $pdf->Cell(60,13,$row['AdtSentenciaAud'],1,1,'C');
  }
  $pdf->Output();
}
else{
  echo '<div><strong>No se ha encontrado registros que mostrar....</strong></div>';
}

} else {
  
  class PDF extends FPDF
{ 

// Cabecera de página
function Header()
{
  $KsvmUrlImg = '../Vistas/assets/img/medicamentos.png';
    // Logo
    $this->Image($KsvmUrlImg,10,10,20);
    // Arial bold 15
    $this->SetFont('Arial','B',17);
    // Movernos a la derecha
    $this->Cell(80);
    // Título
    $this->Cell(30,10,'SIGIMVAK',0,0,'C');
    // Movernos a la derecha
    $this->Cell(45);
    // Arial bold 10
    $this->SetFont('Arial','B',9);
    setlocale(LC_ALL, 'es_EC.UTF-8');
    $this->Cell(30,10,strftime("%d  de %B del %Y"),0,0,'C'); //date("d") . " de " . date("F") . " del " . date("Y")
    // Salto de línea
    $this->Ln(10);
    // Arial bold 12
    $this->SetFont('Arial','B',14);
    $this->Cell(50,10,'_____________________________________________________________________', 0,0);
    // Salto de línea
    $this->Ln(15);
    // Movernos a la derecha
    $this->Cell(80);
    // Título
    $this->Cell(30,10,utf8_decode('Lista de Auditoría'),0,0,'C');
    // Salto de línea
    $this->Ln(15);
    // Arial bold 11
    $this->SetFont('Arial','B',8);

    $this->Cell(30,10,utf8_decode('Tabla'),1,0,'C');
    $this->Cell(5,10,utf8_decode('Id'),1,0,'C');
    $this->Cell(20,10,utf8_decode('Campo'),1,0,'C');
    $this->Cell(30,10,utf8_decode('Val.Ant'),1,0,'C');
    $this->Cell(30,10,utf8_decode('Val.Nvo'),1,0,'C');
    $this->Cell(20,10,utf8_decode('Fch.Crea'),1,0,'C');
    $this->Cell(20,10,utf8_decode('Fch.Mod'),1,0,'C');
    $this->Cell(20,10,utf8_decode('Usuario'),1,0,'C');
    $this->Cell(15,10,utf8_decode('Sentencia'),1,1,'C');
}

// Pie de página
function Footer()
{
    // Posición: a 1,5 cm del final
    $this->SetY(-15);
    // Arial italic 8
    $this->SetFont('Arial','B',8);
    // Número de página
    $this->Cell(0,10,utf8_decode('Página').$this->PageNo().'/{nb}',0,0,'C');
}
}
$KsvmPeticionAjax = true;
require_once "../Controladores/KsvmAuditoriaControlador.php";
$KsvmIniBitacora = new KsvmAuditoriaControlador();

$KsvmQuery = $KsvmIniBitacora->__KsvmImprimirAuditoriaControlador();
if ($KsvmQuery->rowCount() >= 1) {
    $KsvmListaAuditoria = $KsvmQuery->fetchAll();
    // Creación del objeto de la clase heredada
$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Times','',6);
foreach ($KsvmListaAuditoria as $row){
    if ($row['AdtValorAntAud'] != NULL) {
        $KsvmValAnt = $row['AdtValorAntAud'];
    }else{
        $KsvmValAnt = "Sin datos";
    }
    if ($row['AdtValorNvoAud'] != NULL) {
        $KsvmValNvo = $row['AdtValorNvoAud'];
    }else{
        $KsvmValNvo = "Sin datos";
    }
    if ($row['AdtFchCreaAud'] != NULL) {
        $KsvmFchCrea = $row['AdtFchCreaAud'];
    }else{
        $KsvmFchCrea = "Sin datos";
    }
    if ($row['AdtFchModAud'] != NULL) {
        $KsvmFchMod = $row['AdtFchModAud'];
    }else{
        $KsvmFchMod = "Sin datos";
    }
    $pdf->Cell(30,8,$row['AdtNomTabAud'],1,0);
    $pdf->Cell(5,8,$row['AdtIdRegAud'],1,0);
    $pdf->Cell(20,8,$row['AdtCampTabAud'],1,0);
    $pdf->Cell(30,8,$KsvmValAnt,1,0);
    $pdf->Cell(30,8,$KsvmValNvo,1,0);
    $pdf->Cell(20,8,$KsvmFchCrea,1,0);
    $pdf->Cell(20,8,$KsvmFchMod,1,0);
    $pdf->Cell(20,8,$row['AdtUsuModAud'],1,0);
    $pdf->Cell(15,8,$row['AdtSentenciaAud'],1,1);
  }
  $pdf->Output();
}
else{
  echo '<div><strong>No se ha encontrado registros que mostrar....</strong></div>';
}
}




