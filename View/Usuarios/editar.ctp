<?php
	$this->viewVars['tit_cadastro'] = 'Usuários';
	$edicaoCampos 	= array('Usuario.login','Usuario.ativo','Usuario.trocar_senha','Usuario.nome','Usuario.email','Usuario.celular','Usuario.estado_id','Usuario.cidade_id','Usuario.perfil_id','Usuario.senha','Usuario.senha2');
	$camposPesquisa	= array('Usuario.login','Usuario.nome','Usuario.email','Usuario.celular');

	$this->request->data['Usuario']['restricoes']			= '';
	foreach($this->Session->read('Usuario.Restricoes') as $_letra)
	{
		$this->request->data['Usuario']['restricoes'] .= $opcoes_restricao[$_letra].', ';
	}

	if (in_array($this->action,array('editar')))
	{
		$campos['Usuario']['login']['input']['type'] 	= 'leitura';
		$campos['Usuario']['nome']['focus'] 			= true;
		if ($this->data['Usuario']['id'] != $this->Session->read('Usuario.id'))
		{
			$edicaoCampos = array('Usuario.login','Usuario.ativo','Usuario.trocar_senha','Usuario.nome','Usuario.email','Usuario.celular','Usuario.estado_id','Usuario.cidade_id','Usuario.perfil_id');
		}

		if (!$this->Session->read('Usuario.perfil')=='ADMINISTRADOR')
		{
			if ($this->Session->read('Usuario.perfil')=='VISITANTE')
			{
				$botoes = array();
			} else
			{
				$botoes['1']['value'] 	= 'Salvar';
				$botoes['1']['class'] 	= 'botao';
				$botoes['1']['onclick']= "javascript:edicaoForm.submit();";
			}
			$paginacao_off = true;
			$edicaoCampos = array('Usuario.login','Usuario.nome','Usuario.email','Usuario.celular','Usuario.estado_id','Usuario.cidade_id','Usuario.senha','Usuario.senha2','Usuario.perfil_id','Usuario.restricoes');
		}

		// se está editando o usuário administrador, ele não pode ser excluído
		if (isset($this->data['Usuario']['id']) && $this->data['Usuario']['id']==1)
		{
			$botoes['2'] = array();
		}
		

		// administrador não precisa definir perfil, pois ele pode tudo meu chapa !!!
		if ($this->data['Usuario']['id'] == $this->Session->read('Usuario.id'))
		{
			$edicaoCampos 	= array('Usuario.login','Usuario.nome','Usuario.email','Usuario.celular','Usuario.estado_id','Usuario.cidade_id','Usuario.senha','Usuario.senha2');
		}
	}

	// ninguém mais pode ser administrador.
	if (in_array($this->action,array('novo','editar')))
	{
		unset($this->viewVars['opcoes_perfil']['1']);
	}

	if (in_array($this->action,array('excluir','imprimir')))
	{
		$edicaoCampos = array('Usuario.login','Usuario.ativo','Usuario.trocar_senha','Usuario.nome','Usuario.email','Usuario.celular','Usuario.estado_id','Usuario.cidade_id','Usuario.perfil_id');
	}

	if (in_array($this->action,array('novo')))
	{
		$campos['Usuario']['login']['focus'] 		= true;
	}

	// limpando a senha
	$this->request->data['Usuario']['senha'] = '';

	require_once('campos.ctp');
	require_once(APP . DS . 'View' . DS . 'Scaffolds' . DS . 'editar.ctp');
?>
