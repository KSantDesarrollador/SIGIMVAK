<?php
require_once 'PDF/fpdf.php';
require_once '../Vistas/Contenidos/barcode.php';
require_once '../Raiz/KsvmConfiguracion.php';
// require_once '../Vistas/Contenidos/barcode.php';

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
    $this->Ln(10);
    // Arial bold 11
    $this->SetFont('Arial','B',11);

}

// function ImprovedTable($data) {
//   $CodigoBarras = $data;

//  } //Funcion ImprovedTable

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

$KsvmQuery = $KsvmIniExistencia->__KsvmEditarExistenciaControlador($_GET['Cod']);
if ($KsvmQuery->rowCount() >= 1) {
    $KsvmListaExistencia = $KsvmQuery->fetch();

    // Creación del objeto de la clase heredada
    $pdf = new PDF();
    $pdf->AliasNbPages();
    $pdf->AddPage();
    $pdf->SetFont('Times','',15);
    $pdf->SetAutoPageBreak(true, 20);
	  $y = $pdf->GetY();

    $code = $KsvmListaExistencia['ExtCodBarEx'];
        
    barcode('Codigos/'.$code.'.png', $code, 60, 'horizontal', 'code128', true);

    $pdf->SetFont('Times','B',15);
    $pdf->Cell(190,10,utf8_decode($KsvmListaExistencia['BdgDescBod']),0,1,'C');
    $pdf->Ln(5);
    $pdf->SetFont('Times','B',10);
    $pdf->Cell(90,10,utf8_decode('Medicamento'),1,0,'C');
    $pdf->Cell(50,10,utf8_decode('Lote'),1,0,'C');
    $pdf->Cell(50,10,utf8_decode('Fecha de Caducidad'),1,1,'C');
    $pdf->SetFont('Times','',8);
    $pdf->Cell(90,10,$KsvmListaExistencia['MdcDescMed'].' '.$KsvmListaExistencia['MdcConcenMed'],1,0,'C');
    $pdf->Cell(50,10,$KsvmListaExistencia['ExtLoteEx'],1,0,'C');
    $pdf->Cell(50,10,$KsvmListaExistencia['ExtFchCadEx'],1,1,'C');
    $pdf->SetFont('Times','B',10);
    $pdf->Cell(90,25,utf8_decode('Código de localización'),1,1,'C');
    $pdf->SetFont('Times','',12);
    $pdf->Cell(90,25,$KsvmListaExistencia['ExtBinLocEx'],1,0,'C');
    $pdf->Cell(100,50,$pdf->Image('Codigos/'.$code.'.png',110,$y+45,80,0,'png'),0,1,'C');

    $y = $y+15;
        
    $pdf->Output();
}
else{
  echo '<div><strong>No se ha encontrado registros que mostrar....</strong></div>';
}
}

