<?php
	$listaCampos		= array('Cidade.nome','Estado.uf','Cidade.created','Cidade.modified');
	$camposPesquisa		= array('Cidade.nome');

	$campos['Cidade']['nome']['tit'] 	= 'Nome';
	$campos['Estado']['uf']['tit'] 		= 'Estado';

	$botoes['0'] 		= array();
	$ferramentas['2']	= '';

	require_once('../View/Scaffolds/listar.ctp');
?>
