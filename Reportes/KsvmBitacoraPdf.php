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
    $this->Cell(30,10,utf8_decode('Detalle de Sesión'),0,0,'C');
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
require_once "../Controladores/KsvmBitacoraControlador.php";
$KsvmIniBitacora = new KsvmBitacoraControlador();

$KsvmQuery = $KsvmIniBitacora->__KsvmImprimirDetalleBitacoraControlador($_GET['Cod']);
if ($KsvmQuery->rowCount() >= 1) {
    $KsvmListaBitacora = $KsvmQuery->fetchAll();
    // Creación del objeto de la clase heredada
$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Times','',9);
foreach ($KsvmListaBitacora as $row){
  $pdf->Cell(40);
  $pdf->Cell(60,13,utf8_decode('Código'),0,0,'C');
  $pdf->Cell(60,13,$row['BtcCodBit'],0,1,'C');
  $pdf->Cell(40);
  $pdf->Cell(60,13,utf8_decode('Rol'),0,0);
  $pdf->Cell(60,13,$row['BtcTipoBit'],0,1,'C');
  $pdf->Cell(40);
  $pdf->Cell(60,13,utf8_decode('Usuario'),0,0,'C');
  $pdf->Cell(60,13,$row['UsrNomUsu'],0,1,'C');
  $pdf->Cell(40);
  $pdf->Cell(60,13,utf8_decode('Fecha'),0,0,'C');
  $pdf->Cell(60,13,$row['BtcFchBit'],0,1,'C');
  $pdf->Cell(40);
  $pdf->Cell(60,13,utf8_decode('Hora Inicio'),0,0,'C');
  $pdf->Cell(60,13,$row['BtcHoraInBit'],0,1,'C');
  $pdf->Cell(40);
  $pdf->Cell(60,13,utf8_decode('Hora Fin'),0,0,'C');
  $pdf->Cell(60,13,$row['BtcHoraFinBit'],0,1,'C');
  $pdf->Cell(40);
  $pdf->Cell(60,13,utf8_decode('Año'),0,0,'C');
  $pdf->Cell(60,13,$row['BtcAnioBit'],0,1,'C');
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
    $this->Cell(30,10,'Lista de Sesiones',0,0,'C');
    // Salto de línea
    $this->Ln(15);
    // Arial bold 11
    $this->SetFont('Arial','B',10);

    $this->Cell(30,10,utf8_decode('Código'),1,0,'C');
    $this->Cell(40,10,utf8_decode('Rol'),1,0,'C');
    $this->Cell(40,10,utf8_decode('Usuario'),1,0,'C');
    $this->Cell(25,10,utf8_decode('Fecha'),1,0,'C');
    $this->Cell(20,10,utf8_decode('Hora Inicio'),1,0,'C');
    $this->Cell(20,10,utf8_decode('Hora Fin'),1,0,'C');
    $this->Cell(15,10,utf8_decode('Año'),1,1,'C');
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
require_once "../Controladores/KsvmBitacoraControlador.php";
$KsvmIniBitacora = new KsvmBitacoraControlador();

$KsvmQuery = $KsvmIniBitacora->__KsvmImprimirBitacoraControlador();
if ($KsvmQuery->rowCount() >= 1) {
    $KsvmListaBitacora = $KsvmQuery->fetchAll();
    // Creación del objeto de la clase heredada
$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Times','',7);
foreach ($KsvmListaBitacora as $row){
    $pdf->Cell(30,8,$row['BtcCodBit'],1,0);
    $pdf->Cell(40,8,$row['BtcTipoBit'],1,0);
    $pdf->Cell(40,8,$row['UsrNomUsu'],1,0);
    $pdf->Cell(25,8,$row['BtcFchBit'],1,0);
    $pdf->Cell(20,8,$row['BtcHoraInBit'],1,0);
    $pdf->Cell(20,8,$row['BtcHoraFinBit'],1,0);
    $pdf->Cell(15,8,$row['BtcAnioBit'],1,1);
  }
  $pdf->Output();
}
else{
  echo '<div><strong>No se ha encontrado registros que mostrar....</strong></div>';
}
}




