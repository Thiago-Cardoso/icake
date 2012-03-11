<?php
	$rel_campos				= array('Usuario.login','Usuario.nome','Usuario.email','Usuario.celular','Usuario.ativo');
	$rel_titulos['0']		= 'Lista de Usuários';

	$campos['Usuario']['ativo']['input']['options']	= array('1'=>'Sim', '0'=>'Não');

	$colunas['1']['tit']	= 'Login';
	$colunas['1']['lar']	= '20';
	$colunas['1']['ali']	= 'C';

	$colunas['2']['tit']	= 'Nome';
	$colunas['2']['lar']	= '100';

	$colunas['3']['tit']	= 'e-mail';
	$colunas['3']['lar']	= '80';

	$colunas['4']['tit']	= 'Celular';
	$colunas['4']['ali']	= 'C';
	$colunas['4']['lar']	= '30';

	$colunas['5']['tit']	= 'Ativo';
	$colunas['5']['lar']	= '20';
	$colunas['5']['ali']	= 'C';

	require_once('campos.ctp');
	require_once('../View/Scaffolds/rel_lista.ctp');
?>
