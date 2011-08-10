<?php
/**
 * Controller da página principal
 * 
 * @package 	exemploApp
 * @subpackage	exemploApp.controller
 */
/**
 * @package 	meucake
 * @subpackage	jcake.controller
 */
class PrincipalController extends AppController {
	/**
	 * Nome do controlador
	 * 
	 * @var		string
	 * @access	public
	 */
	public $name = 'Principal';

	/**
	 * Nome do model
	 * 
	 * @var		string
	 * @access	public
	 */
	public $uses = array();

	/**
	 * Ajudantes
	 * 
	 * @var		array
	 * @access	public
	 */
	public $helpers		= array('Jcake.Visao');

	/**
	 * Exibe a tela principal
	 * 
	 * @return		void
	 */
	public function index()
	{
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
				$this->loadModel('Usuario');
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
					$this->Session->write('perfis',$arrPer);

					// atualizando dados do usuário
					$this->Usuario->updateAll(array('Usuario.acessos'=>$arrUsu['acessos'],'Usuario.ultimo_acesso'=>'"'.date('Y-m-d H:i:s').'"'),array('Usuario.id'=>$arrUsu['id']));

					// redirecionando para tela de informações
					$this->Session->setFlash('<span style="color: green;">Login autenticado com sucesso !!!</span>');
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
}
?>
