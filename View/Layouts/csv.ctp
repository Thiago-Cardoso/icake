<?php
	$arq = isset($arq) ? $arq : 'csv_'.strtolower($this->name).'_'.date('d-m-Y').'.csv';
	header('Content-type: application/csv');
	header('Content-Disposition: attachment; filename="'.$arq.'"');
	echo $content_for_layout; 
?>
