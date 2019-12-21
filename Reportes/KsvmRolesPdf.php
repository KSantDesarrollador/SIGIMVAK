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
    $this->Cell(30,10,'Lista de Roles',0,0,'C');
    // Salto de línea
    $this->Ln(15);
    // Arial bold 11
    $this->SetFont('Arial','B',10);

    $this->Cell(50,10,utf8_decode('Código'),1,0,'C');
    $this->Cell(90,10,'Nombre',1,0,'C');
    $this->Cell(50,10,'Estado',1,1,'C');
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
require_once "../Controladores/KsvmRolControlador.php";
$KsvmIniRol = new KsvmRolControlador();

$KsvmQuery = $KsvmIniRol->__KsvmImprimirRolControlador();
if ($KsvmQuery->rowCount() >= 1) {
    $KsvmListaRol = $KsvmQuery->fetchAll();
    // Creación del objeto de la clase heredada
$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Times','',9);
foreach ($KsvmListaRol as $row){
    $pdf->Cell(50,8,$row['RrlId'],1,0);
    $pdf->Cell(90,8,$row['RrlNomRol'],1,0);
    $pdf->Cell(50,8,$row['RrlEstRol'],1,1);
  }
  $pdf->Output();
}
else{
  echo '<div><strong>No se ha encontrado registros que mostrar....</strong></div>';
}

