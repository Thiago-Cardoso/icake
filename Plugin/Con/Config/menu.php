<?php
/**
 * Coloque aqui suas opções de menu
 */
	$nome = 'Contatos';
	$menu['tit'] = 'Contatos';

	// CADASTRO
	$menu['cadastros']['Contatos']			= Router::url('/',true).'con/contatos';
	$menu['cadastros']['e-mails']			= Router::url('/',true).'con/emails';
	$menu['cadastros']['Grupos']			= Router::url('/',true).'con/grupos';

	// RELATÓRIOS
	$menu['relatorios']['Lista Sintética de Contatos']			= Router::url('/',true).'con/contatos/sintetico';
	$menu['relatorios']['Lista de Aniversariantes de um Mês']	= Router::url('/',true).'con/contatos/aniversariantes';

	// FERRAMENTAS
	//$menu['ferramentas']['Enviar Parabéns']	= Router::url('/',true).'con/contatos/parabens';

	// AJUDA
	$menu['ajuda']['Contatos'] 				= Router::url('/',true).'con/ajuda/contatos';
?>
