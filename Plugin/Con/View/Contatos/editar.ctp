<?php
	$edicaoCampos = array('Contato.nome','Contato.endereco','Contato.bairro'
		,'Contato.cep','Contato.estado_id','Contato.cidade_id',
		'Contato.tel1','Contato.tel2','Contato.tel3',
		'Contato.email','Contato.twitter','Contato.facebook','Contato.gtalk',
		'Contato.msn','Contato.aniversario','Contato.obs'
	);
	$camposPesquisa	= array('Cidade.nome','Contato.email');

	require_once('campos.ctp');
	require_once('..'.DS.'View'.DS.'Scaffolds'.DS.'editar.ctp');
?>
