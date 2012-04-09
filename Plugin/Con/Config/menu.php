<?php
/**
 * Coloque aqui suas opções de menu
 */
	$nome = 'Contatos';
	$menu['tit'] = 'Contatos';

	// CADASTRO
	$menu['cadastros']['Contatos']			= Router::url('/',true).'con/contatos';
	$menu['cadastros']['e-mails']			= Router::url('/',true).'con/emails';
	$menu['cadastros']['Grupos de e-mails']	= Router::url('/',true).'con/grupos';

	// RELATÓRIOS
	$menu['relatorios']['Etiquetas para Contatos']		= Router::url('/',true).'con/contatos/etiquetas';
	$menu['relatorios']['Lista Sintética de Contatos']	= Router::url('/',true).'con/contatos/sintetico';
	$menu['relatorios']['Lista de Aniversariantes']		= Router::url('/',true).'con/contatos/aniversariantes';

	// FERRAMENTAS
	$menu['ferramentas']['Enviar NewsLetter']	= Router::url('/',true).'con/emails/escrever_msg';

	// AJUDA
	$menu['ajuda']['Contatos'] 				= Router::url('/',true).'con/ajuda/contatos';
?>
