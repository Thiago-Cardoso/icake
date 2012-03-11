<?php
	if (isset($this->data['Perfil']['id']) && $this->data['Perfil']['id']==1)
	{
		$edicaoCampos	= array('Perfil.nome');
		if (!in_array('l',$this->Session->read('Usuario.Restricoes')))
		{
			$botoes['9']['value'] 	= 'Fechar';
			$botoes['9']['class'] 	= 'botao';
			$botoes['9']['onclick']= "document.location.href='".Router::url('/',true).strtolower($this->name)."'";
		}
		$campos['Perfil']['nome']['input']['readonly'] = 'readonly';
	} else
	{
		$edicaoCampos	= array('Perfil.nome','Perfil.restricao');
	}
	$camposPesquisa		= array('Perfil.nome');

	$campos['Perfil']['nome']['tit']					= 'Perfil';
	$campos['Perfil']['restricao']['tit']				= 'Restrições';
	$campos['Perfil']['restricao']['input']['type']		= 'select';
	$campos['Perfil']['restricao']['input']['multiple'] = 'checkbox';
	$campos['Perfil']['restricao']['input']['options']	= $opcoes_restricao;
	if (isset($this->data['Perfil']['restricao']))
	{
		$this->request->data['Perfil']['restricao'] = explode(',',$this->data['Perfil']['restricao']);
	}

	if (in_array($tipo,array('imprimir','excluir')))
	{
		// re-escrevendo o conteúdo pra restrição ficar bunitinho
		foreach($this->data as $_model => $_arrCampos)
		{
			$tmpRestricao = '';
			$arrRestricao = $this->data['Perfil']['restricao'];
			foreach($arrRestricao as $_letra) if (isset($opcoes_restricao[$_letra])) $tmpRestricao .= $opcoes_restricao[$_letra].', ';
			if (!empty($tmpRestricao))
			{
				$tmpRestricao = substr($tmpRestricao,0,strlen($tmpRestricao)-2);
				$this->request->data['Perfil']['restricao'] = $tmpRestricao;
			}
		}
	}

	require_once('../View/Scaffolds/editar.ctp');
?>
