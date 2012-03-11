<?php
	$listaCampos		= array('Perfil.nome','Perfil.restricao');
	$camposPesquisa		= array('Perfil.nome');

	$campos['Perfil']['nome']['tit']				= 'Perfil';
	$campos['Perfil']['restricao']['tit']			= 'Restrições';
	$campos['Perfil']['restricao']['th']['style']	= 'width: 400px;';

	// desligando o excluir do perfil administrador
	$off['2']['1'] = true;

	// re-escrevendo o conteúdo pra restrição ficar bunitinho
	foreach($this->data as $_linha => $_arrModel)
	{
		$arrRestricao = explode(',',$this->data[$_linha]['Perfil']['restricao']);
		$tmpRestricao = '';
		foreach($arrRestricao as $_letra) if (isset($opcoes_restricao[$_letra])) $tmpRestricao .= $opcoes_restricao[$_letra].', ';
		if (!empty($tmpRestricao))
		{
			$tmpRestricao = substr($tmpRestricao,0,strlen($tmpRestricao)-2);
			$this->request->data[$_linha]['Perfil']['restricao'] = $tmpRestricao;
		}
	}

	require_once('../View/Scaffolds/listar.ctp');
?>
