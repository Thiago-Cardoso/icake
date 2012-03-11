<?php
	$listaCampos		= array('Cidade.nome','Estado.uf','Cidade.created','Cidade.modified');
	$camposPesquisa		= array('Cidade.nome');

	$campos['Cidade']['nome']['tit'] 	= 'Nome';
	$campos['Estado']['uf']['tit'] 		= 'Estado';

	$botoes			= array();
	$ferramentas	= array();

	require_once('../View/Scaffolds/listar.ctp');
?>
