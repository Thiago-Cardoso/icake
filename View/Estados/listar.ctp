<?php
	$listaCampos		= array('Estado.nome','Estado.uf');
	$camposPesquisa		= array('Estado.nome');

	$campos['Estado']['uf']['tit'] = 'Uf';
	$campos['Estado']['nome']['tit'] = 'Estado';

	$botoes['0'] 		= array();
	$ferramentas		= array();

	require_once('../View/Scaffolds/listar.ctp');
?>
