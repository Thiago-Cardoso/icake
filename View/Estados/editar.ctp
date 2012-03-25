<?php
	$camposPesquisa		= array('Estado.nome');
	$edicaoCampos		= array('Estado.nome','Estado.uf');

	$botoes['0'] = '';
	$botoes['1'] = '';
	$botoes['2'] = '';

	$campos['Estado']['nome']['tit'] 		= 'Estado';
	$campos['Estado']['uf']['tit'] 			= 'Uf';

	require_once('../View/Scaffolds/editar.ctp');
?>
