<?php
	header('Content-Type: text/csv');
	$arq = isset($arq) ? $arq : 'csv_'.strtolower($this->name).'_'.date('d-m-Y').'.csv';
	header('Content-Disposition: attachment; filename="'.$arq.'"');
	
//	header('Content-type: application/csv');
	echo $content_for_layout; 
?>
