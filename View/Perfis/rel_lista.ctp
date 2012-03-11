<?php
	$rel_campos				= array('Perfil.nome','Perfil.restricao');
	$rel_titulos['0']		= 'Lista de Perfis';
	$pag_orientacao			= 'P';
	$colunas['1']['tit']	= 'Perfil';
	$colunas['1']['lar']	= '90';
	
	$colunas['2']['tit']	= 'Restrição';
	$colunas['2']['lar']	= '60';

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

	require_once('../View/Scaffolds/rel_lista.ctp');
?>
