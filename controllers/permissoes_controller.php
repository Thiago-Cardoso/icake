<?php
/**
 * Controller para o cadastro de permissões
 * 
 * @package		icake
 * @subpackage	icake.controller
 */
/**
 * @package		icake
 * @subpackage	icake.controller
 */
class PermissoesController extends AppController {
	/**
	 * Nome do controller
	 * 
	 * @var		string
	 * @access	public
	 */
	public $name 		= 'Permissoes';

	/**
	 * Model do controller
	 * 
	 * @var		array
	 * @access	public
	 */
	public $uses		= array('Permissao');

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
	 * Executa código antes da renderização da view
	 * 
	 * Somente administradores pode atualizar todos os registros.
	 * O Usuario Administrador não poderá acessar as senhas dos demais usuários.
	 * O Usuário Administrador com id igual 1 não pode ser deletado e não pode ser questinado a troca de senha.
	 * O Usuário que não é administrador não pode incluir novos usuarios e não pode definir seus perfis.
	 * Não pode ativar e desativar a si próprio e ainda só pode editar ele mesmo.
	 * 
	 * @return	void
	 */
	public function beforeRender()
	{

		$campos				= array();
		$onReadView 		= array();
		$listaCampos 		= array('Permissao.controlador','Permissao.acao','Permissao.acesso','Permissao.modified','Permissao.created');
		$edicaoCampos		= array('Permissao.controlador','#','Permissao.acao','#','Permissao.acesso','@','Perfil','#','Usuario','@','Permissao.modified','Permissao.created');
		$listaFerramentas	= array();
		$botoesEdicao		= array();

		$camposPesquisa['Permissao.login']	= 'Controlador';
		$camposPesquisa['Permissao.nome']	= 'Método';

		$campos['Permissao']['controlador']['input']['label']['text'] 	= 'Controlador';
		$campos['Permissao']['controlador']['input']['size']			= '60';
		$campos['Permissao']['controlador']['th']['width']				= '400px';

		$campos['Permissao']['acao']['input']['label']['text'] 			= 'Método';
		$campos['Permissao']['acao']['input']['size']					= '60';
		$campos['Permissao']['acao']['th']['width']						= '400px';

		$campos['Permissao']['acesso']['input']['label']['text']		= 'Acesso';
		$campos['Permissao']['acesso']['input']['options']				= array('1'=>'Sim','0'=>'Não');
		$campos['Permissao']['acesso']['input']['default']				= 1;

		$perfis	= $this->Permissao->Perfil->find('list',array('conditions'=>array('id !='=>1)));
		$campos['Perfil']['perfil']['input']['label']['text']			= 'Perfis';
		$campos['Perfil']['perfil']['input']['multiple']				= 'checkbox';
		$campos['Perfil']['perfil']['input']['options']					= $perfis;

		$usuarios	= $this->Permissao->Usuario->find('list', array('conditions'=>array('id !='=>1)));
		$campos['Usuario']['usuario']['input']['label']['text']			= 'Usuários';
		$campos['Usuario']['usuario']['input']['multiple']				= 'checkbox';
		$campos['Usuario']['usuario']['input']['options']				= $usuarios;

		if ($this->action=='editar')
		{
			array_unshift($onReadView,'$("#UsuarioControlador").focus();');
		}
		if ($this->action=='novo')
		{
			$edicaoCampos = array('Permissao.controlador','#','Permissao.acao','#','Permissao.acesso','@','Perfil','#','Usuario');
		}

		// título link
		$linkTit[1] = 'Permissões';

		// atualizando a view
		$this->set(compact('linkTit','perfis','listaCampos','edicaoCampos','campos','camposPesquisa','escreverTitBt','onReadView','listaFerramentas','botoesEdicao'));
	}
}
?>
