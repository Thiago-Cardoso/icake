<?php
/**
 * Controller para o cadastro de perfis
 * 
 * @package		icake
 * @subpackage	icake.controller
 */
/**
 * @package		icake
 * @subpackage	icake.controller
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
		$meusperfis = $this->Session->read('meusperfis');
		if (!in_array('ADMINISTRADOR',$meusperfis)) $this->redirect('../usuarios/acesso_nao_autorizado');

		$campos							= array();
		$onReadView 					= array();
		$listaCampos 					= array('Perfil.nome','Perfil.modified','Perfil.created');
		$edicaoCampos					= array('Perfil.nome','#','Usuario','@','Perfil.modified','#','Perfil.created');
		$listaFerramentas				= array();
		$botoesEdicao					= array();

		if ($this->action=='imprimir')
		{
			$edicaoCampos = array('Perfil.nome','#','Usuario.nome','@','Perfil.modified','Perfil.created');
		}

		$camposPesquisa['Perfil.nome'] 	= 'Nome';

		$campos['Perfil']['nome']['input']['label']['text'] = 'Nome';
		$campos['Perfil']['nome']['input']['size']			= '60';
		$campos['Perfil']['nome']['th']['width']			= '400px';

		$campos['Usuario']['usuario']['input']['label']['text']		= 'Usuário(s)';
		$campos['Usuario']['usuario']['input']['label']['style'] 	= 'min-height: 200px;';
		$campos['Usuario']['usuario']['input']['style']				= 'min-height: 100px;';

		if ($this->action=='editar' || $this->action=='novo')
		{
			$usuarios = $this->Perfil->Usuario->find('list');
			array_unshift($onReadView,'$("#PerfilNome").focus();');
		}

		$this->set(compact('listaCampos','edicaoCampos','campos','camposPesquisa','onReadView','listaFerramentas','botoesEdicao','usuarios'));
	}
}
?>
