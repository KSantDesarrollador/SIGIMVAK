<?php
require_once 'PDF/fpdf.php';
require_once '../Raiz/KsvmConfiguracion.php';

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
    $this->Cell(30,10,utf8_decode('Lista de Unidades Médicas'),0,0,'C');
    // Salto de línea
    $this->Ln(15);
    // Arial bold 11
    $this->SetFont('Arial','B',10);

    $this->Cell(20,10,utf8_decode('Código'),1,0,'C');
    $this->Cell(25,10,utf8_decode('Identidad'),1,0,'C');
    $this->Cell(40,10,utf8_decode('Descripción'),1,0,'C');
    $this->Cell(15,10,utf8_decode('Telf'),1,0,'C');
    $this->Cell(60,10,utf8_decode('Dirección'),1,0,'C');
    $this->Cell(30,10,utf8_decode('Email'),1,1,'C');
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
require_once "../Controladores/KsvmUnidadMedicaControlador.php";
$KsvmIniBod = new KsvmUnidadMedicaControlador();

$KsvmQuery = $KsvmIniBod->__KsvmImprimirUnidadMedicaControlador();
if ($KsvmQuery->rowCount() >= 1) {
    $KsvmListaUnidadMedica = $KsvmQuery->fetchAll();
    // Creación del objeto de la clase heredada
$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Times','',8);
foreach ($KsvmListaUnidadMedica as $row){
    $pdf->Cell(20,8,$row['UmdId'],1,0);
    $pdf->Cell(25,8,$row['UmdIdentUdm'],1,0);
    $pdf->Cell(40,8,$row['UmdNomUdm'],1,0);
    $pdf->Cell(15,8,$row['UmdTelfUdm'],1,0);
    $pdf->Cell(60,8,$row['UmdDirUdm'],1,0);
    $pdf->Cell(30,8,$row['UmdEmailUdm'],1,1);
  }
  $pdf->Output();
}
else{
  echo '<div><strong>No se ha encontrado registros que mostrar....</strong></div>';
}


