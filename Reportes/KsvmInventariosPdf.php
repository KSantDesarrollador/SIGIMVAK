<?php
require_once 'PDF/fpdf.php';
require_once '../Raiz/KsvmConfiguracion.php';

if (isset($_GET['Cod'])) {
  
  class PDF extends FPDF
{ 

// Cabecera de página
function Header()
{
  $KsvmUrlImg = '../Vistas/assets/img/Logo.png';
    // Logo
    $this->Image($KsvmUrlImg,10,8,13);
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
    $this->Cell(30,10,'Detalle de Inventario',0,0,'C');
    // Salto de línea
    $this->Ln(15);
    // Arial bold 11
    $this->SetFont('Arial','B',10);

    $this->Cell(30,10,utf8_decode('Cod.Inventario'),1,0,'C');
    $this->Cell(40,10,utf8_decode('Medicamento'),1,0,'C');
    $this->Cell(30,10,utf8_decode('Lote'),1,0,'C');
    $this->Cell(30,10,utf8_decode('Fch.Caducidad'),1,0,'C');
    $this->Cell(20,10,utf8_decode('Stock'),1,0,'C');
    $this->Cell(20,10,utf8_decode('Cnt.Físico'),1,0,'C');
    $this->Cell(20,10,utf8_decode('Diferencia'),1,1,'C');

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
require_once "../Controladores/KsvmInventarioControlador.php";
$KsvmIniInventario = new KsvmInventarioControlador();

$KsvmQuery = $KsvmIniInventario->__KsvmImprimirDetalleInventarioControlador($_GET['Cod']);
if ($KsvmQuery->rowCount() >= 1) {
    $KsvmListaInventario = $KsvmQuery->fetchAll();
    // Creación del objeto de la clase heredada
$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Times','',8);
foreach ($KsvmListaInventario as $row){
  $pdf->Cell(30,8,$row['IvtCodInv'],1,0);
  $pdf->Cell(40,8,$row['MdcDescMed'].' '.$row['MdcConcenMed'],1,0);
  $pdf->Cell(30,8,$row['ExtLoteEx'],1,0);
  $pdf->Cell(30,8,$row['ExtFchCadEx'],1,0);
  $pdf->Cell(20,8,$row['DivStockInv'],1,0);
  $pdf->Cell(20,8,$row['DivContFisInv'],1,0);
  $pdf->Cell(20,8,$row['DivDifInv'],1,1);
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
  $KsvmUrlImg = '../Vistas/assets/img/Logo.png';
    // Logo
    $this->Image($KsvmUrlImg,10,8,13);
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
    $this->Cell(30,10,'Lista de Inventarios',0,0,'C');
    // Salto de línea
    $this->Ln(15);
    // Arial bold 11
    $this->SetFont('Arial','B',10);

    $this->Cell(20,10,utf8_decode('Código'),1,0,'C');
    $this->Cell(50,10,utf8_decode('Bodega'),1,0,'C');
    $this->Cell(25,10,utf8_decode('Fecha'),1,0,'C');
    $this->Cell(20,10,utf8_decode('Hora'),1,0,'C');
    $this->Cell(20,10,utf8_decode('Duración'),1,0,'C');
    $this->Cell(40,10,utf8_decode('Responsable'),1,0,'C');
    $this->Cell(15,10,utf8_decode('Estado'),1,1,'C');
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
require_once "../Controladores/KsvmInventarioControlador.php";
$KsvmIniInventario = new KsvmInventarioControlador();

$KsvmQuery = $KsvmIniInventario->__KsvmImprimirInventarioControlador();
if ($KsvmQuery->rowCount() >= 1) {
    $KsvmListaInventario = $KsvmQuery->fetchAll();
    // Creación del objeto de la clase heredada
$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Times','',8);
foreach ($KsvmListaInventario as $row){
    $pdf->Cell(20,8,$row['IvtCodInv'],1,0);
    $pdf->Cell(50,8,$row['BdgDescBod'],1,0);
    $pdf->Cell(25,8,$row['IvtFchElabInv'],1,0);
    $pdf->Cell(20,8,$row['IvtHoraInv'],1,0);
    $pdf->Cell(20,8,$row['IvtDuracionInv'],1,0);
    $pdf->Cell(40,8,$row['IvtPerElabInv'],1,0);
    $pdf->Cell(15,8,$row['IvtEstInv'],1,1);
  }
  $pdf->Output();
}
else{
  echo '<div><strong>No se ha encontrado registros que mostrar....</strong></div>';
}

}
