<?php
	$arq = isset($arq) ? $arq : "csv_".date("d-m-Y").".csv";
	header('Content-type: application/csv');
	header('Content-Disposition: attachment; filename="'.$arq.'"');
	echo $content_for_layout; 
?>
