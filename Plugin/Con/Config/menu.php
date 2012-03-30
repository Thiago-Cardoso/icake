<?php
/**
 * Coloque aqui suas opções de menu
 */
	$nome = 'Contatos';

	// CADASTRO
	$menu['cadastro']['Contatos']			= Router::url('/',true).'con/contatos';

	// RELATÓRIOS
	$menu['relatorios']['Lista Sintética']	= Router::url('/',true).'con/contatos/rel_lista';

	// AJUDA
	$menu['ajuda']['Contatos'] 				= Router::url('/',true).'con/ajuda/contatos';
?>
