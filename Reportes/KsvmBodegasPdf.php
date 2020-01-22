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
    $this->Cell(30,10,'Lista de Bodegas',0,0,'C');
    // Salto de línea
    $this->Ln(15);
    // Arial bold 11
    $this->SetFont('Arial','B',11);

    $this->Cell(20,10,utf8_decode('Código'),1,0,'C');
    $this->Cell(50,10,utf8_decode('Descripción'),1,0,'C');
    $this->Cell(15,10,utf8_decode('Telf'),1,0,'C');
    $this->Cell(75,10,utf8_decode('Dirección'),1,0,'C');
    $this->Cell(30,10,utf8_decode('Und Médica'),1,1,'C');
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
require_once "../Controladores/KsvmBodegaControlador.php";
$KsvmIniBod = new KsvmBodegaControlador();

$KsvmQuery = $KsvmIniBod->__KsvmImprimirBodegaControlador();
if ($KsvmQuery->rowCount() >= 1) {
    $KsvmListaBodega = $KsvmQuery->fetchAll();
    // Creación del objeto de la clase heredada
$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Times','',7);
foreach ($KsvmListaBodega as $row){
    $pdf->Cell(20,8,$row['BdgCodBod'],1,0);
    $pdf->Cell(50,8,$row['BdgDescBod'],1,0);
    $pdf->Cell(15,8,$row['BdgTelfBod'],1,0);
    $pdf->Cell(75,8,$row['BdgDirBod'],1,0);
    $pdf->Cell(30,8,$row['UmdNomUdm'],1,1);
  }
  $pdf->Output();
}
else{
  echo '<div><strong>No se ha encontrado registros que mostrar....</strong></div>';
}


