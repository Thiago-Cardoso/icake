<?php
/**
 * Controller para o cadastro de usuários
 * 
 * @package		icake
 * @subpackage	icake.controller
 */
/**
 * @package		icake
 * @subpackage	icake.controller
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
	 * Executa código antes da renderização da view
	 * 
	 * Somente administradores pode atualizar dados
	 * 
	 * @return	void
	 */
	public function beforeRender()
	{
		if (in_array($this->action,array('editar','novo','listar','excluir','deletar')))
		{
			$meusperfis = $this->Session->read('meusperfis');
			if (!in_array('ADMINISTRADOR',$meusperfis)) $this->redirect('acesso_nao_autorizado');
		}

		$campos				= array();
		$onReadView 		= array();
		$listaCampos 		= array('Usuario.login','Usuario.ativo','Usuario.nome','Usuario.celular','Usuario.modified','Usuario.created');
		$edicaoCampos		= array('Usuario.login','Usuario.ativo','@','Usuario.nome','#','Usuario.email','#','Usuario.celular','@','Perfil','@','Usuario.modified','Usuario.created');
		$listaFerramentas	= array();
		$botoesEdicao		= array();

		$camposPesquisa['Usuario.login']= 'Login';
		$camposPesquisa['Usuario.nome']	= 'Nome';

		$campos['Usuario']['login']['input']['label']['text'] 	= 'Login';
		$campos['Usuario']['login']['input']['align']			= 'center';
		$campos['Usuario']['login']['th']['width'] 				= '200px';
		$campos['Usuario']['login']['td']['align'] 				= 'center';

		$campos['Usuario']['nome']['input']['label']['text'] 	= 'Nome';
		$campos['Usuario']['nome']['input']['size']				= '60';
		$campos['Usuario']['nome']['th']['width']				= '400px';

		$campos['Usuario']['senha']['input']['label']['text'] 	= 'Senha';
		$campos['Usuario']['senha']['input']['type'] 			= 'password';
		$campos['Usuario']['senha']['input']['maxlength'] 		= 20;
		$campos['Usuario']['senha']['input']['size']			= 19;
		$campos['Usuario']['senha2']['input']['label']['text'] 	= 'repita a senha';
		$campos['Usuario']['senha2']['input']['type'] 			= 'password';
		$campos['Usuario']['senha2']['input']['maxlength'] 		= 20;
		$campos['Usuario']['senha2']['input']['size']			= 19;

		$campos['Usuario']['email']['input']['size']			= '60px';

		$campos['Usuario']['celular']['input']['label']['text']	= 'Celular';
		$campos['Usuario']['celular']['th']['width']			= '120px';
		$campos['Usuario']['celular']['td']['align']			= 'center';
		$campos['Usuario']['celular']['mascara']				= '99 9999-9999';

		$campos['Usuario']['ativo']['input']['label']['text'] 	= 'Ativo';
		$campos['Usuario']['ativo']['th']['width'] 				= '100px';
		$campos['Usuario']['ativo']['td']['align'] 				= 'center';
		$campos['Usuario']['ativo']['input']['options']			= array('1'=>'Sim','0'=>'Não');

		$perfis	= $this->Usuario->Perfil->find('list');
		$campos['Perfil']['perfil']['input']['label']['text']	= 'Perfis';
		$campos['Perfil']['perfil']['input']['multiple']		= 'checkbox';
		$campos['Perfil']['perfil']['input']['options']			= $perfis;

		if ($this->action=='editar')
		{
			array_unshift($onReadView,'$("#UsuarioNome").focus();');
			if (isset($this->data['Usuario']['id']) && $this->data['Usuario']['id']==$this->Session->read('usuario.id'))
			{
				$this->data['Usuario']['senha'] 	= '';
				$this->data['Usuario']['senha2'] 	= '';
				$edicaoCampos = array('Usuario.login','Usuario.ativo','@','Usuario.nome','@','Usuario.senha','Usuario.senha2','Usuario.email','#','Usuario.celular','@','Perfil','@','Usuario.modified','Usuario.created');
			}
		}
		if ($this->action=='novo')
		{
			array_unshift($onReadView,'$("#UsuarioLogin").focus();');
			$edicaoCampos = array('Usuario.login','Usuario.ativo','@','Usuario.nome','@','Usuario.senha','Usuario.senha2','Usuario.email','#','Usuario.celular','@','Perfil','@','Usuario.modified','Usuario.created');
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
			$listaFerramentas['excluir']['off']['1']= true;
		}

		// título link
		$linkTit[1] = 'Usuários';

		// atualizando a view
		$this->set(compact('linkTit','perfis','listaCampos','edicaoCampos','campos','camposPesquisa','escreverTitBt','onReadView','listaFerramentas','botoesEdicao'));
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
