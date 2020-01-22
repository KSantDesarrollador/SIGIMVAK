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
    $this->Cell(30,10,'Lista de Usuarios',0,0,'C');
    // Salto de línea
    $this->Ln(15);
    // Arial bold 11
    $this->SetFont('Arial','B',10);

    // $this->Cell(20,10,utf8_decode('Foto'),1,1,'C');
    $this->Cell(45,10,utf8_decode('Empleado'),1,0,'C');
    $this->Cell(20,10,utf8_decode('Rol'),1,0,'C');
    $this->Cell(30,10,utf8_decode('Usuario'),1,0,'C');
    $this->Cell(50,10,utf8_decode('Contraseña'),1,0,'C');
    $this->Cell(30,10,utf8_decode('Email'),1,0,'C');
    $this->Cell(15,10,utf8_decode('Telf'),1,1,'C');
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
require_once "../Controladores/KsvmUsuarioControlador.php";
$KsvmIniUsuario = new KsvmUsuarioControlador();

$KsvmQuery = $KsvmIniUsuario->__KsvmImprimirUsuarioControlador();
if ($KsvmQuery->rowCount() >= 1) {
    $KsvmListaUsuario = $KsvmQuery->fetchAll();

    // Creación del objeto de la clase heredada
$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Times','',7);
foreach ($KsvmListaUsuario as $row){
    // $pdf->Cell(20,10,$row['UsrImgUsu'],1,0);
    $pdf->Cell(45,8,$row['EpoNomEmp'],1,0);
    $pdf->Cell(20,8,$row['RrlNomRol'],1,0);
    $pdf->Cell(30,8,$row['UsrNomUsu'],1,0);
    $pdf->Cell(50,8,$row['UsrContraUsu'],1,0);
    $pdf->Cell(30,8,$row['UsrEmailUsu'],1,0);
    $pdf->Cell(15,8,$row['UsrTelfUsu'],1,1);
  }
  $pdf->Output();
}
else{
  echo '<div><strong>No se ha encontrado registros que mostrar....</strong></div>';
}


