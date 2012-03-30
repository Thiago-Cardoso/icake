<?php
	$listaCampos		= array('Contato.nome','Cidade.nome','Estado.nome');
	$camposPesquisa		= array('Contato.nome');

	require_once('campos.ctp');
	require_once('../View/Scaffolds/listar.ctp');
?>
