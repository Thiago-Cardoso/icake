<?php
	require_once('campos.ctp');
	$rel_campos				= array('Contato.nome','Contato.email','Contato.tel1','Contato.tel3','Contato.aniversario');
	$rel_titulos['0']		= 'Lista Sintética de Contatos';
	//$pag_orientacao			= 'P';

	$colunas['1']['tit']	= $campos['Contato']['nome']['tit'];
	$colunas['1']['lar']	= '90';
	
	$colunas['2']['tit']	= $campos['Contato']['email']['tit'];
	$colunas['2']['lar']	= '90';
	$colunas['2']['ali']	= 'C';

	$colunas['3']['tit']		= $campos['Contato']['tel1']['tit'];
	$colunas['3']['mascara']	= $campos['Contato']['tel1']['mascara'];
	$colunas['3']['lar']		= '30';
	$colunas['3']['ali']		= 'C';
	
	$colunas['4']['tit']		= $campos['Contato']['tel3']['tit'];
	$colunas['4']['mascara']	= $campos['Contato']['tel3']['mascara'];
	$colunas['4']['lar']		= '30';
	$colunas['4']['ali']		= 'C';

	$colunas['5']['tit']		= 'Anivers.';
	$colunas['5']['mascara']	= $campos['Contato']['aniversario']['mascara'];
	$colunas['5']['lar']		= '20';
	$colunas['5']['ali']		= 'C';

	require_once('..'.DS.'View'.DS.'Scaffolds'.DS.'rel_lista.ctp');
?>
