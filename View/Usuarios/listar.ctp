<?php
	$this->viewVars['tit_cadastro'] = 'Usuários';

	$listaCampos	= array('Usuario.login','Usuario.ativo','Usuario.nome','Usuario.email','Usuario.celular');
	$camposPesquisa	= array('Usuario.login','Usuario.nome','Usuario.email','Usuario.celular');

	// desligando o excluir do perfil administrador
	$off['2']['1'] = true;

	require_once('campos.ctp');
	require_once('../View/Scaffolds/listar.ctp');
?>
