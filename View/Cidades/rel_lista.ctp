<?php
	$rel_campos				= array('Cidade.nome','Estado.uf');
	$rel_titulos['0']		= 'Lista de Cidades';
	$pag_orientacao			= 'P';
	$colunas['1']['tit']	= 'Cidade';
	$colunas['1']['lar']	= '90';
	
	$colunas['2']['tit']	= 'Estado';
	$colunas['2']['lar']	= '20';
	$colunas['2']['ali']	= 'C';

	require_once('../View/Scaffolds/rel_lista.ctp');
?>
