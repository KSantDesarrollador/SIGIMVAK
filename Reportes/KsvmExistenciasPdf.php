<?php
require_once 'PDF/fpdf.php';
require_once '../Raiz/KsvmConfiguracion.php';

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
    $this->Cell(30,10,'Lista de Existencias',0,0,'C');
    // Salto de línea
    $this->Ln(15);
    // Arial bold 11
    $this->SetFont('Arial','B',10);

    // $this->Cell(20,10,utf8_decode('Imagen'),1,1,'C');
    $this->Cell(30,10,utf8_decode('Medicamento'),1,0,'C');
    $this->Cell(20,10,utf8_decode('Lote'),1,0,'C');
    $this->Cell(30,10,utf8_decode('Fecha Cad'),1,0,'C');
    $this->Cell(20,10,utf8_decode('Stock'),1,0,'C');
    $this->Cell(30,10,utf8_decode('Presentación'),1,0,'C');
    $this->Cell(30,10,utf8_decode('Cod.Barras'),1,0,'C');
    $this->Cell(30,10,utf8_decode('BinLoc'),1,1,'C');
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
require_once "../Controladores/KsvmExistenciaControlador.php";
$KsvmIniExistencia = new KsvmExistenciaControlador();

$KsvmQuery = $KsvmIniExistencia->__KsvmImprimirExistenciaControlador();
if ($KsvmQuery->rowCount() >= 1) {
    $KsvmListaExistencia = $KsvmQuery->fetchAll();

    // Creación del objeto de la clase heredada
$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Times','',8);
$pdf->SetAutoPageBreak(true, 20);

foreach ($KsvmListaExistencia as $row){
    // $pdf->Cell(20,10,$row['MdcFotoMed'],1,0);
    $pdf->Cell(30,8,$row['MdcDescMed'].' '.$row['MdcConcenMed'],1,0);
    $pdf->Cell(20,8,$row['ExtLoteEx'],1,0);
    $pdf->Cell(30,8,$row['ExtFchCadEx'],1,0);
    $pdf->Cell(20,8,$row['ExbStockEbo'],1,0);
    $pdf->Cell(30,8,$row['ExtPresentEx'],1,0);
    $pdf->Cell(30,8,$row['ExtCodBarEx'],1,0);
    $pdf->Cell(30,8,$row['ExtBinLocEx'],1,1);
  }
  $pdf->Output();
}
else{
  echo '<div><strong>No se ha encontrado registros que mostrar....</strong></div>';
}


