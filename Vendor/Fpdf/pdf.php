<?php
require_once(APP . 'Vendor' . DS . 'Fpdf' . DS . 'fpdf.php');
define('FPDF_FONTPATH', APP . 'Vendor' . DS . 'Fpdf' . DS . 'font' .DS);

class PDF extends FPDF
{
	var $colunas = array();
	
	function header()
	{
		$this->SetXY(10,7);
		$this->SetFont('Arial','',10);
		if (isset($this->titEsquerdo)) $this->Cell(50,5,utf8_decode($this->titEsquerdo),0,0,'L');
		$this->SetFont('Arial','',12);
//		$this->Image(APP_BASE .'/../css/logo-pbh.jpg',8,3);	
		$this->SetXY(10,7);
		foreach($this->titulo as $_item => $_valor)
		{
			$this->Cell($this->largura-10,5,utf8_decode(substr($_valor,0,100)),0,0,'C');
			$this->ln();
		}
		$this->Line($this->GetX(), $this->GetY(),$this->largura-10,$this->GetY());

		//$this->SetXY(10,30);
		$this->ln();
		$this->Cell(8,5,'#',1,'','C');
		$this->SetFont('Times','B',12);
		foreach($this->colunas as $_coluna => $_arrProp)
		{
			$_arrProp['tit'] = isset($_arrProp['tit']) ? $_arrProp['tit'] : '??';
			$_arrProp['alt'] = isset($_arrProp['alt']) ? $_arrProp['alt'] : 5;
			$_arrProp['bor'] = isset($_arrProp['bor']) ? $_arrProp['bor'] : 1;
			$_arrProp['ali'] = 'C';
			$_arrProp['fun'] = isset($_arrProp['fun']) ? $_arrProp['fun'] : '';
			$this->Cell($_arrProp['lar'], $_arrProp['alt'], utf8_decode($_arrProp['tit']), $_arrProp['bor'],$_arrProp['fun'], $_arrProp['ali']);
		}
		$this->ln();
	}
	
	function Footer()
	{
		//Vai para 1.5 cm da parte inferior
		$this->SetY(-15);
		$this->Line($this->GetX(), $this->GetY(),$this->largura-10,$this->GetY());
		
		//Seleciona a fonte Arial itálico 8
		$this->SetFont('Arial','I',8);

		//Imprime o número da página corrente e o total de páginas
		$this->Cell(0,10,utf8_decode('Página ').$this->PageNo().' de {total}',0,0,'C');
	}
}
?>
