<?php
/**
 * Controller Pai de todos
 * 
 * @package       icake
 * @subpackage    icake.app
 */

/**
 * @package       icake
 * @subpackage    icake.app
 */
class AppController extends Controller {
	/**
	 * Executa código antes de tudo
	 * 
	 * Se o usuário não está autenticado é redirecionado para a tela de login, caso não esteja na tela principal
	 * 
	 * Atualiza objeto View com as opções de menu que serão usadas na lista, somente para cadastros de Cidades, Estados e Perfis
	 * 
	 * @return	void
	 */
	public function beforeFilter()
	{
		if (!$this->Session->check('usuario') && $this->action != 'login' && $this->name != 'Principal' && $this->name != 'Ferramentas')
		{
			$this->redirect(Router::url('/',true).'usuarios/login');
		}
		
		if ($this->Session->check('meusperfis'))
		{
			$meusperfis = $this->Session->read('meusperfis');
			$this->set(compact('meusperfis'));
		}

		// menu para o módulo sistema
		if (in_array($this->name,array('Cidades','Estados','Perfis','Usuarios')))
		{
			$listaMenu['Cidades']	= 'cidades';
			$listaMenu['Estados']	= 'estados';
			if (isset($meusperfis) && in_array('ADMINISTRADOR',$meusperfis))
			{
				$listaMenu['Perfis']	= 'perfis';
				$listaMenu['Usuários']	= 'usuarios';
			}
			$this->set(compact('listaMenu'));
		}
	}

	/**
	 * Página inicial do cadastro
	 * 
	 * @return	void
	 */
	public function index()
	{
		$this->Controlador->index();
	}

	/**
	 * Exibe a tela para criar um novo registro
	 * 
	 * @return	void
	 */
	public function novo()
	{
		$this->Controlador->novo();
	}

	/**
	 * Exibe a tela de edição do registro
	 * 
	 * @param	integer		$id	Id do registro a ser editado
	 * @return	void
	 */
	public function editar($id=0)
	{
		$this->Controlador->editar($id);
	}

	/**
	 * Exibe a tela de exclusão
	 * 
	 * @param	integer		$id	Id do registro a ser excluído
	 * @return	void
	 */
	public function excluir($id=0)
	{
		$this->Controlador->editar($id);
	}

	/**
	 * Executa a exclusão do registro
	 * 
	 * @param	integer		$id	Id do registro a ser excluído
	 * @return	void
	 */
	public function delete($id=0)
	{
		$this->Controlador->delete($id);
	}

	/**
	 * Imprimi na tela o registro selecionado
	 * 
	 * @param	integer		$id	Id do registro a ser excluído
	 * @return	void
	 */
	public function imprimir($id=0)
	{
		$this->Controlador->imprimir($id);
	}

	/**
	 * Lista do cadastro de cidades
	 * 
	 * @return 	void
	 */
	public function listar()
	{
		$this->Controlador->listar();
	}

	/**
	 * Realiza uma pesquisa no banco de dados
	 * 
	 * @parameter 	string 	$texto 	Texto de pesquisa
	 * @parameter 	string 	$campo 	Campo de pesquisa
	 * @parameter	string 	$action	Action para onde será redirecionado ao clicar na resposta
	 * @return 		array 	$lista 	Array com lista de retorno
	 */
	public function pesquisar($campo=null,$texto=null,$action='editar')
	{
		$this->Controlador->pesquisar($campo, $texto, $action);
	}

	/**
	 * Retorna uma lista do banco de dados para comboBox
	 * 
	 * exemplo: http://localhost/sistema/controle/combo/campo/filtro
	 * 
	 * @parameter	string	$campo		Campo a sofrer o filtro
	 * @parameter	string	$filtro		Texto a ser aplicado no filtro
	 * @access		public
	 * @return 		string
	 */
	public function combo($campo=null,$filtro=null)
	{
		$this->Controlador->combo($campo, $filtro);
	}
}

?>
