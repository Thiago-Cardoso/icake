<?php
/**
 * Controller para o cadastro de perfis
 * 
 * @package		exemploApp
 * @subpackage	exemploApp.controller
 */
/**
 * @package		exemploApp
 * @subpackage	exemploApp.controller
 */
class PerfisController extends AppController {
	/**
	 * Nome do controller
	 * 
	 * @var		string
	 * @access	public
	 */
	public $name 		= 'Perfis';

	/**
	 * Model do controller
	 * 
	 * @var		array
	 * @access	public
	 */
	public $uses		= array('Perfil');

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
			$this->data['Perfil']['nome'] = mb_strtoupper($this->data['Perfil']['nome']);
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
		$listaCampos 					= array('Perfil.nome','Perfil.modified','Perfil.created');
		$edicaoCampos					= array('Perfil.nome','#','Cliente','Usuario','@','Perfil.modified','#','Perfil.created');
		$listaFerramentas				= array();
		$botoesEdicao					= array();

		if ($this->action=='imprimir')
		{
			$edicaoCampos = array('Perfil.nome','#','Cliente.nome','#','Usuario.nome','@','Perfil.modified','Perfil.created');
		}

		$camposPesquisa['Perfil.nome'] 	= 'Nome';

		$campos['Perfil']['nome']['input']['label']['text'] = 'Nome';
		$campos['Perfil']['nome']['input']['size']			= '60';
		$campos['Perfil']['nome']['th']['width']			= '400px';

		$campos['Cliente']['cliente']['input']['label']['text']		= 'Cliente(s)';
		$campos['Cliente']['cliente']['input']['label']['style'] 	= 'min-height: 200px;';
		$campos['Cliente']['cliente']['input']['style']				= 'min-height: 100px;';

		$campos['Usuario']['usuario']['input']['label']['text']		= 'Usuário(s)';
		$campos['Usuario']['usuario']['input']['label']['style'] 	= 'min-height: 200px;';
		$campos['Usuario']['usuario']['input']['style']				= 'min-height: 100px;';

		if ($this->action=='editar' || $this->action=='novo')
		{
			$clientes = $this->Perfil->Cliente->find('list');
			$usuarios = $this->Perfil->Usuario->find('list');
			array_unshift($onReadView,'$("#PerfilNome").focus();');
		}

		$this->set(compact('listaCampos','edicaoCampos','campos','camposPesquisa','onReadView','listaFerramentas','botoesEdicao','clientes','usuarios'));
	}
}
?>
