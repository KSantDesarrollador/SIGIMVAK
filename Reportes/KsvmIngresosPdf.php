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
    $this->Cell(30,10,'Detalle de Ingresos',0,0,'C');
    // Salto de línea
    $this->Ln(15);
    // Arial bold 11
    $this->SetFont('Arial','B',10);

    $this->Cell(20,10,utf8_decode('#Ingreso'),1,0,'C');
    $this->Cell(20,10,utf8_decode('Tipo'),1,0,'C');
    $this->Cell(40,10,utf8_decode('Medicamento'),1,0,'C');
    $this->Cell(30,10,utf8_decode('Concentración'),1,0,'C');
    $this->Cell(20,10,utf8_decode('Lote'),1,0,'C');
    $this->Cell(20,10,utf8_decode('Cantidad'),1,0,'C');
    $this->Cell(40,10,utf8_decode('Observación'),1,1,'C');

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
require_once "../Controladores/KsvmTransaccionControlador.php";
$KsvmIniTransaccion = new KsvmTransaccionControlador();

$KsvmQuery = $KsvmIniTransaccion->__KsvmImprimirDetalleTransaccionControlador($_GET['Cod']);
if ($KsvmQuery->rowCount() >= 1) {
    $KsvmListaTransaccion = $KsvmQuery->fetchAll();
    // Creación del objeto de la clase heredada
$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Times','',8);
foreach ($KsvmListaTransaccion as $row){
  $pdf->Cell(20,8,$row['TsnNumTran'],1,0);
  $pdf->Cell(20,8,$row['DtsTipoTran'],1,0);
  $pdf->Cell(40,8,$row['MdcDescMed'],1,0);
  $pdf->Cell(30,8,$row['MdcConcenMed'],1,0);
  $pdf->Cell(20,8,$row['ExtLoteEx'],1,0);
  $pdf->Cell(20,8,$row['DtsCantTran'],1,0);
  $pdf->Cell(40,8,$row['DtsObservTran'],1,1);
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
    $this->Cell(30,10,'Lista de Ingresos',0,0,'C');
    // Salto de línea
    $this->Ln(15);
    // Arial bold 11
    $this->SetFont('Arial','B',11);

    $this->Cell(20,10,utf8_decode('Código'),1,0,'C');
    $this->Cell(30,10,utf8_decode('Tipo'),1,0,'C');
    $this->Cell(55,10,utf8_decode('Bodega'),1,0,'C');
    $this->Cell(30,10,utf8_decode('Fecha'),1,0,'C');
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
require_once "../Controladores/KsvmTransaccionControlador.php";
$KsvmIniTransaccion = new KsvmTransaccionControlador();

$KsvmQuery = $KsvmIniTransaccion->__KsvmImprimirTransaccionesControlador("Ingreso");
if ($KsvmQuery->rowCount() >= 1) {
    $KsvmListaTransaccion = $KsvmQuery->fetchAll();
    // Creación del objeto de la clase heredada
$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Times','',9);
foreach ($KsvmListaTransaccion as $row){
    $pdf->Cell(20,8,$row['TsnNumTran'],1,0);
    $pdf->Cell(30,8,$row['TsnTipoTran'],1,0);
    $pdf->Cell(55,8,$row['TsnDestinoTran'],1,0);
    $pdf->Cell(30,8,$row['TsnFchReaTran'],1,0);
    $pdf->Cell(40,8,$row['TsnPerReaTran'],1,0);
    $pdf->Cell(15,8,$row['TsnEstTran'],1,1);
  }
  $pdf->Output();
}
else{
  echo '<div><strong>No se ha encontrado registros que mostrar....</strong></div>';
}

}
