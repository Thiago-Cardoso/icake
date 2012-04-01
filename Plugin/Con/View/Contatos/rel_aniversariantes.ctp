<?php 
	require_once('campos.ctp');

	$rel_campos			= array('Contato.nome','Contato.email','Contato.tel1','Contato.tel3','Contato.aniversario');
	$rel_titulos['0']	= 'Lista de Aniversariantes do Mês de '.$meses[$mes];

	$colunas['1']['tit']	= 'Nome';
	$colunas['1']['lar']	= '90';

	$colunas['2']['tit']	= 'e-mail';
	$colunas['2']['lar']	= '60';

	$colunas['3']['tit']	= 'Telefone';
	$colunas['3']['lar']	= '30';
	$colunas['3']['ali']	= 'C';

	$colunas['4']['tit']	= 'Celular';
	$colunas['4']['lar']	= '30';
	$colunas['4']['ali']	= 'C';

	$colunas['5']['tit']	= 'Aniver.';
	$colunas['5']['lar']	= '20';
	$colunas['5']['ali']	= 'C';

	require_once(APP.'View'.DS.'Scaffolds'.DS.'rel_lista.ctp');
?>
