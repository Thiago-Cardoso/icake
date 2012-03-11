<?php
	$rel_campos				= array('Estado.nome','Estado.uf');
	$rel_titulos['0']		= 'Lista de Estados';
	$pag_orientacao			= 'P';
	$colunas['1']['tit']	= 'Estado';
	$colunas['1']['lar']	= '90';

	$colunas['2']['tit']	= 'Uf';
	$colunas['2']['lar']	= '20';
	$colunas['2']['ali']	= 'C';

	require_once('../View/Scaffolds/rel_lista.ctp');
?>
