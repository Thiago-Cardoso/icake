<?php
/**
 * Controller para o cadastro de Usuários
 *
 * @copyright	Copyright 2008-2012, Adriano Carneiro de Moura
 * @link		http://github.com/adrianodemoura/icake 	Projeto iCake
 * @package		icake
 * @subpackage	icake.Controller
 * @since		CakePHP(tm) v 2.1
 * @license		MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
/**
 * @package			icake
 * @subpackage		icake.Controller
 */
class UsuariosController extends AppController {
	/**
	 * Reseta a senha do usuário
	 * 
	 * @param	integer		$id		Id do Usuário
	 * @return	void
	 */
	public function resetar_senha($id=0)
	{
		if ($id==1) 
		{
			$this->Session->setFlash('O Usuário Administrador não pode resetar a senha','default',array('class' => 'msgErro'));
		} else
		{
			$data['Usuario']['id'] 		= $id;
			$data['Usuario']['senha'] 	= '123456';
			$data['Usuario']['senha2'] 	= '123456';
			if (!$this->Usuario->save($data,true,array('senha')))
			{
				$this->Session->setFlash('Erro ao tentar resetar a senha do usuário !!!','default',array('class' => 'msgErro'));
			} else
			{
				$this->Session->setFlash('A senha do usuário foi resetada com sucesso !!!','default',array('class' => 'msgOk'));
			}
		}
		$this->redirect('listar');
	}

	/**
	 * Exibe a tela de listagem
	 * 
	 * @return	void
	 */
	public function editar($id=0)
	{
		if (!in_array('ADMINISTRADOR',$this->Session->read('Usuario.Perfis')))
		{
			if ($this->Session->read('Usuario.id') != $id)
			{
				$this->Session->setFlash('Você não pode editar outros usuários !!!','default', array('class'=>'msgErro'));
				$this->redirect('editar/'.$this->Session->read('Usuario.id'));
			}
		}
		parent::editar($id);
	}

	/**
	 * Função para listar os usuários
	 * 
	 * @retorn	void
	 */
	public function listar()
	{
		if (!in_array('ADMINISTRADOR',$this->Session->read('Usuario.Perfis')))
		{
			if ($this->Session->read('Usuario.id') != $id)
			{
				$this->Session->setFlash('Você não pode listar outros usuários !!!','default', array('class'=>'msgErro'));
				$this->redirect('editar/'.$this->Session->read('Usuario.id'));
			}
		}
		parent::listar();
	}

	/**
	 * Função para exibir a tela de login
	 */
	public function login() 
	{
		if ($this->Session->check('Usuario')) $this->redirect('info');
	}

	/**
	 * Muda o status de online e 
	 * Executa o logOut da sistema
	 * 
	 * @return void
	 */
	public function sair()
	{
		if (!$this->Usuario->updateAll(array('Usuario.online'=>'0',),array('Usuario.id'=>$this->Session->read('Usuario.id'))))
		{
			die('Erro ao tornar status do usuário off-line');
		}
		$this->Session->destroy();
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
		$this->set(compact('msg'));
	}

	/**
	 * Função para executar a autenticação de usuário
	 * 
	 * @param	string	$login
	 * @param	string	$senha
	 * @return	void
	 */
	public function autenticar($login='', $senha='')
	{
		$msg 	= '';
		$login 	= isset($this->data['form']['ed_login']) ? $this->data['form']['ed_login'] : $login;
		$senha 	= isset($this->data['form']['ed_senha']) ? $this->data['form']['ed_senha'] : $senha;

		// se o formulário foi postado
		if ($this->data)
		{
			if (!empty($login) && (!empty($senha)))
			{
				App::uses('Security', 'Utility');
				$senha = Security::hash(Configure::read('Security.salt') . $senha);
				$opcoes['conditions']['Usuario.login'] = $login;
				$opcoes['conditions']['Usuario.senha'] = $senha;
				try
				{
					$dataUsuario = $this->Usuario->find('all',$opcoes);
				} catch (Exception $e)
				{
					if ($e->getCode()==500)
					{
						$this->redirect('../ferramentas/instalabd');
						die();
					}
				}
				
				// se está configurando os status do usuários e ele talvez esteja online, verifica pela data
				$limite = Configure::read('ONLINE');
				if ($limite && $dataUsuario[0]['Usuario']['online'])
				{
					$agora 					= mktime();
					$data					= $dataUsuario[0]['Usuario']['ultimo_click'];
					list($ano,$mes,$dia)	= explode("-",$data); // separamos as partes da data 
					list($dia,$hora)		= explode(" ",$dia);
					list($hora,$min,$seg)	= explode(":",$hora); // transformamos a data do banco em segundos usando a função mktime()
					$ultimoClick			= mktime($hora,$min,$seg,$mes,$dia,$ano);
					$diferenca				= $agora - $ultimoClick;
					$minutos				= $diferenca/60;
					$horas					= $diferenca/3600;
					$dias					= $diferenca/86400;
					
					if ($minutos<=5) $msg = 'O Usuário '.$dataUsuario[0]['Usuario']['nome'].' já está logado !!!';
				}
				
				if (isset($dataUsuario[0]['Usuario']['ativo']) && !$dataUsuario[0]['Usuario']['ativo'])
				{
					$msg = 'Usuário desativado !!!';
				}
				if (empty($msg) && isset($dataUsuario[0]['Usuario']['ativo']) && $dataUsuario[0]['Usuario']['ativo'])
				{
					// recuperando os dados do usuário e jogando na sessão
					$arrUsu['id']  		= $dataUsuario[0]['Usuario']['id'];
					$arrUsu['login']  	= $dataUsuario[0]['Usuario']['login'];
					$arrUsu['email']  	= $dataUsuario[0]['Usuario']['email'];
					$arrUsu['trocar']  	= $dataUsuario[0]['Usuario']['trocar_senha'];
					$arrUsu['ultimo'] 	= $dataUsuario[0]['Usuario']['ultimo_acesso'];
					$arrUsu['acessos'] 	= ($dataUsuario[0]['Usuario']['acessos'])+1;
					$arrUsu['Restricoes']= array();

					// pegando os perfis do usuários
					if (!empty($dataUsuario[0]['Perfil']))
					{
						$restricoes = array();
						$arrPerfis = $dataUsuario[0]['Perfil'];

						// recuperando a restrição de cada perfil
						foreach($arrPerfis as $_linha => $_arrCampos)
						{
							$arrUsu['Perfis'][$_linha] = $_arrCampos['nome'];
							$dataPerfil = $this->Usuario->Perfil->find('all',array('conditions'=>array('Perfil.id'=>$_arrCampos['id'])));
							if (!empty($dataPerfil['0']['Perfil']['restricao']))
							{
								array_push($restricoes,$dataPerfil['0']['Perfil']['restricao']);
							}
						}

						// removendo as duplicidades de restricoes
						$arrNovasRestricoes = array();
						foreach($restricoes as $_item => $_texto)
						{
							$tmpArrRestricoes = explode(',',$_texto);
							foreach($tmpArrRestricoes as $_item => $_letra)
							{
								if (!in_array($_letra,$arrNovasRestricoes)) array_push($arrNovasRestricoes,$_letra);
							}
						}
						// gravando restrições
						asort($arrNovasRestricoes);
						$arrUsu['Restricoes'] = $arrNovasRestricoes;
					} else $arrUsu['Perfis'] = array();

					$this->Session->write('Usuario',$arrUsu);
					$arrPer = array();

					// atualizando dados do usuário
					$this->Usuario->updateAll(
					array(
						'Usuario.acessos'=>$arrUsu['acessos'],
						'Usuario.ultimo_acesso'=>"'".date('Y-m-d H:i:s')."'",
						'Usuario.ultimo_click'=>"'".date('Y-m-d H:i:s')."'",
						'Usuario.online'=>'1',
						),array('Usuario.id'=>$arrUsu['id']));

					// se tem que trocar a senha
					if ($dataUsuario[0]['Usuario']['trocar_senha'])
					{
						$this->Session->setFlash('Necessário trocar a senha !!!','default', array('class'=>'msgErro'));
						$this->redirect('editar/'.$arrUsu['id']);
					} else
					{
						$this->Session->setFlash('Usuário autenticado com sucesso !!!','default', array('class'=>'msgOk'));
					}

					// descobrindo qual é o banco de dados e jogando seu nome na sessão.
					include_once(APP . DS . 'Config' . DS . 'database.php');
					$dbConf 	= new DATABASE_CONFIG();
					$bd 		= $dbConf->default;
					$this->Session->write('Banco',strtolower(str_replace('Database/','',$bd['datasource'])));

					// redirecionando para tela de informações
					$this->redirect('info');exit();
				} elseif(empty($msg)) $msg = 'Login ou senha inválidos !!!';
			} else
			{
				$msg = 'Preencha todos os campos';
			}
		}

		$this->Session->setFlash($msg, 'default', array('class' => 'msgErro'));
		$this->redirect('login');
	}
}
