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
	 * Antes de tudo
	 * 
	 * Antes de salvar, atualiza alguns dados do formulário, como deixar alguns campos em minúsculo ou maiúsculo e remover máscaras
	 * 
	 * @return void
	 */
	public function beforeFilter()
	{
		if (isset($this->data) && $this->action != 'login')
		{
			// configurando a caixa para alguns campos
			$this->data['Usuario']['nome']	= mb_strtoupper($this->data['Usuario']['nome']);
			$this->data['Usuario']['email'] = mb_strtolower($this->data['Usuario']['email']);
			$this->data['Usuario']['login'] = mb_strtolower($this->data['Usuario']['login']);

			// removendo a máscara em alguns campos			
			$campos = array('celular');
			foreach($campos as $_campo)
			{
				if (isset($this->data['Usuario'][$_campo]))
				{
					$this->data['Usuario'][$_campo]	= ereg_replace('-','',$this->data['Usuario'][$_campo]);
				}
			}

			// se está editando usuário admin, então ele sempre será admin
			if ($this->data['Usuario']['id']==1)
			{
				$this->data['Perfil']['Perfil'][0] = 1;
			}
		}
		parent::beforeFilter();
	}

	/**
	 * Executa código antes da renderização da view
	 * 
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
			$edicaoCampos = array('Usuario.login','Usuario.ativo','@','Usuario.nome','#','Usuario.email','#','Usuario.celular','@','Perfil.nome','@','Usuario.modified','Usuario.created');
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

		// título link
		$linkTit[1] = 'Usuários';

		// atualizando a view
		$this->set(compact('linkTit','perfis','listaCampos','edicaoCampos','campos','camposPesquisa','escreverTitBt','onReadView','listaFerramentas','botoesEdicao'));
	}

	/**
	 * Exibe a tela de edição do cadastro de usuários
	 * 
	 * Somente o administradores pode editar todos os usuários.
	 * 
	 * @param	integer	$id	Id do registro a ser editado
	 * @return	void
	 */
	public function editar($id=0)
	{
		$perfis = $this->Session->read('perfis'); if (!in_array('ADMINISTRADOR',$perfis)) $this->redirect('acesso_nao_autorizado');
		parent::editar($id);
	}

	/**
	 * Exibe a tela de lista do cadastro de usuários
	 * 
	 * Somente o administradores pode listar todos os usuários.
	 * 
	 * @return	void
	 */
	public function listar()
	{
		$meusperfis = $this->Session->read('meusperfis');
		if (!in_array('ADMINISTRADOR',$meusperfis)) $this->redirect('acesso_nao_autorizado');
		parent::listar();
	}

	/**
	 * Exibe a tela de informação do usúário
	 * 
	 * @return void
	 */
	public function info()
	{
		$msg = '';
		if ($this->Session->check('msg'))
		{
			$msg =  $this->Session->read('msg');
			$this->Session->delete('msg');
		}
		$this->set('msg',$msg);
	}

	/**
	 * Exibe a tela de login
	 * 
	 * @return		void
	 */
	public function login()
	{
		$msg = 'Entre com login e senha válido ...';
		if ($this->data)
		{
			$login = $this->data['login']['login'];
			$senha = Security::hash(Configure::read('Security.salt') . $this->data['login']['senha']);
			if (!empty($login) && (!empty($senha)))
			{
				$opcoes['conditions']['Usuario.login'] = $login;
				$opcoes['conditions']['Usuario.senha'] = $senha;
				$dataUsuario = $this->Usuario->find('all',$opcoes);
				if (count($dataUsuario))
				{
					// recuperando os dados do usuário e jogando na sessão
					$arrUsu['id']  		= $dataUsuario[0]['Usuario']['id'];
					$arrUsu['login']  	= $dataUsuario[0]['Usuario']['login'];
					$arrUsu['email']  	= $dataUsuario[0]['Usuario']['email'];
					$arrUsu['ultimo'] 	= $dataUsuario[0]['Usuario']['ultimo_acesso'];
					$arrUsu['acessos'] 	= ($dataUsuario[0]['Usuario']['acessos'])+1;
					$this->Session->write('usuario',$arrUsu);
					$arrPer = array();
					foreach($dataUsuario[0]['Perfil'] as $_linha => $_arrCampos) array_push($arrPer,$_arrCampos['nome']);
					$this->Session->write('meusperfis',$arrPer);

					// atualizando dados do usuário
					$this->Usuario->updateAll(array('Usuario.acessos'=>$arrUsu['acessos'],'Usuario.ultimo_acesso'=>'"'.date('Y-m-d H:i:s').'"'),array('Usuario.id'=>$arrUsu['id']));

					// redirecionando para tela de informações
					$this->Session->setFlash('<span style="color: #fff;">Login autenticado com sucesso !!!</span>');
					$this->redirect('info');
				} else $msg = '<span style="color: red;">Login ou senha inválidos !!!</span>';
			} else
			{
				$msg = 'Preencha todos os campos !!!';
			}
		}
		$this->set('msg',$msg);
	}
	
	/**
	 * Executa o logOut da sistema
	 * 
	 * @return void
	 */
	public function sair()
	{
		$this->Session->destroy();
		$this->redirect('/');
	}

	/**
	 * Exibe a tela de acesso não autorizado
	 * 
	 * @return	void
	 */
	public function acesso_nao_autorizado()
	{
		// título link
		$linkTit[1] = 'Acesso não autorizado !!!';
		$this->set(compact('linkTit'));
	}
}
?>
