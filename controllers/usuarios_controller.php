<?php
/**
 * Controller para o cadastro de usuários
 * 
 * @package		exemploApp
 * @subpackage	exemploApp.controller
 */
/**
 * @package		exemploApp
 * @subpackage	exemploApp.controller
 */
class UsuariosController extends AppController {
	/**
	 * Nome do controller
	 * 
	 * @var		string
	 * @access	public
	 */
	public $name 		= 'Usuarios';

	/**
	 * Model do controller
	 * 
	 * @var		array
	 * @access	public
	 */
	public $uses		= array('Usuario');

	/**
	 * Componentes
	 * 
	 * @var		array
	 * @access	public
	 */
	public $components	= array('Jcake.Controlador');

	/**
	 * Ajudantes
	 * 
	 * @var		array
	 * @access	public
	 */
	public $helpers		= array('Jcake.Visao');

	/**
	 * 
	 */
	public function beforeFilter()
	{
		if (isset($this->data))
		{
			$this->data['Usuario']['nome']	= mb_strtoupper($this->data['Usuario']['nome']);
			$this->data['Usuario']['email'] = mb_strtolower($this->data['Usuario']['email']);
			$this->data['Usuario']['login'] = mb_strtolower($this->data['Usuario']['login']);
			$campos = array('celular');
			foreach($campos as $_campo)
			{
				if (isset($this->data['Usuario'][$_campo]))
				{
					$this->data['Usuario'][$_campo]	= ereg_replace('-','',$this->data['Usuario'][$_campo]);
				}
			}
		}
		parent::beforeFilter();
	}

	/**
	 * Executa código antes da renderização da view
	 * 
	 * @return	void
	 */
	public function beforeRender()
	{
		$campos							= array();
		$onReadView 					= array();
		$listaCampos 					= array('Usuario.login','Usuario.ativo','Usuario.nome','Usuario.modified','Usuario.created');
		$edicaoCampos					= array('Usuario.login','Usuario.ativo','@','Usuario.nome','#','Usuario.email','#','Usuario.celular','@','Perfil','@','Usuario.modified','Usuario.created');
		$listaFerramentas				= array();
		$botoesEdicao					= array();

		if ($this->action=='imprimir')
		{
			$edicaoCampos				= array('Usuario.login','Usuario.ativo','@','Usuario.nome','#','Usuario.email','@','Perfil','@','Usuario.modified','Usuario.created');
		}

		$camposPesquisa['Usuario.login']= 'Login';
		$camposPesquisa['Usuario.nome']	= 'Nome';

		$campos['Usuario']['login']['input']['label']['text'] 	= 'Login';
		$campos['Usuario']['login']['th']['width'] 				= '200px';
		$campos['Usuario']['login']['td']['align'] 				= 'center';

		$campos['Usuario']['nome']['input']['label']['text'] 	= 'Nome';
		$campos['Usuario']['nome']['input']['size']				= '60';
		$campos['Usuario']['nome']['th']['width']				= '400px';

		$campos['Usuario']['email']['input']['size']			= '60px';

		$campos['Usuario']['celular']['input']['label']['text']	= 'Celular';
		$campos['Usuario']['celular']['th']['width']			= '120px';
		$campos['Usuario']['celular']['mascara']				= ' 99 9999-9999';

		$campos['Usuario']['ativo']['input']['label']['text'] 	= 'Ativo';
		$campos['Usuario']['ativo']['th']['width'] 				= '100px';
		$campos['Usuario']['ativo']['td']['align'] 				= 'center';
		$campos['Usuario']['ativo']['input']['options']			= array('1'=>'Sim','0'=>'Não');
		//$campos['Usuario']['ativo']['input']['type']			= 'radio';
		//$campos['Usuario']['ativo']['input']['fieldset']		= '';
		//$campos['Usuario']['ativo']['input']['legend']			= 'Ativo';

		$perfis	= $this->Usuario->Perfil->find('list');
		$campos['Perfil']['perfil']['input']['label']['text']		= 'Perfis';
		$campos['Perfil']['perfil']['input']['multiple']			= 'checkbox';
		$campos['Perfil']['perfil']['input']['options']				= $perfis;

		if ($this->action=='editar' || $this->action=='novo')
		{
			array_unshift($onReadView,'$("#UsuarioNome").focus();');
		}

		if ($this->action=='imprimir')
		{
			$edicaoCampos = array('Usuario.login','Usuario.ativo','@','Usuario.nome','#','Usuario.email','@','Perfil.nome','@','Usuario.modified','Usuario.created');
		}

		if (in_array($this->action,array('editar','excluir')))
		{
			$campos['Usuario']['login']['input']['readonly'] 	= 'readonly';
		}

		// se possui dados
		if (isset($this->data['Usuario']['login']))
		{
			// se estiver editando o usuário administrador, então não pode removê-lo
			if ($this->data['Usuario']['login']=='admin')
			{
				$botoesEdicao['excluir'] = '';
			}
		}

		// refatorando o botão excluir para o usuário admin
		if ($this->action=='listar')
		{
			$listaFerramentas['excluir']['icone'] 	= 'bt_excluir.png';
			$listaFerramentas['excluir']['off']['2']= true;
		}

		// atualizando a view
		$this->set(compact('perfis','listaCampos','edicaoCampos','campos','camposPesquisa','escreverTitBt','onReadView','listaFerramentas','botoesEdicao'));
	}
}
?>
