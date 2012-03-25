<?php
	$camposPesquisa		= array('Cidade.nome');
	$edicaoCampos		= array('Cidade.nome','Cidade.estado_id');

	$botoes['0'] = '';
	$botoes['1'] = '';
	$botoes['2'] = '';

	$campos['Cidade']['nome']['tit'] 		= 'Cidade';
	$campos['Cidade']['estado_id']['tit'] 	= 'Estado';

	require_once('../View/Scaffolds/editar.ctp');
?>
