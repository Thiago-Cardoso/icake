<?php
/**
 * Controller para Ferramentas
 * 
 * @package		icake
 * @subpakage	jcake.controller
 */
/**
 * @package		icake
 * @subpakage	icake.controller
 */
class FerramentasController extends AppController {
	/**
	 * 
	 * Nome do controller
	 * 
	 * @var		string
	 * @access	public
	 */
	public $name 	= 'Ferramentas';

	/**
	 * Model usado pelo controlador
	 * 
	 * @var		array
	 * @access	public
	 */
	public $uses	= array('Ferramenta');

	/**
	 * Ajudantes
	 * 
	 * @var		array
	 * @access	public
	 */
	public $helpers	= array('Jcake.Visao');

	/**
	 * Antes de tudo
	 * 
	 * @return void
	 */
	public function beforeFilter()
	{
		// alterando layout
		$this->layout 	= 'jcake';
		$this->plugin 	= 'jcake';
		parent::beforeFilter();
	}

	/**
	 * Antes da renderização da view
	 * 
	 * Somente administradores pode acessar, salvo se o sistema não foi instalado
	 * 
	 * @return	void
	 */
	public function beforeRender()
	{
		if ($this->Session->check('meusperfis'))
		{
			$meusperfis = $this->Session->read('meusperfis'); if (!in_array('ADMINISTRADOR',$meusperfis)) $this->redirect('../usuarios/acesso_nao_autorizado');
		}
	}

	/**
	 * Exibe a tela inicial de ferramentas
	 * 
	 * @return void
	 */
	public function index()
	{
		if (isset($this->data['Ferramenta']['tipo']))
		{
			$msg = '';
			switch($this->data['Ferramenta']['tipo'])
			{
				case 'limparCache':
					$this->setLimpaCache();
					$msg = 'Cache limpo com sucesso';
					break;
			}
			$this->set('msg',$msg);
		}
	}

	/**
	 * Exibe a tela de instalação do banco de dados
	 * 
	 * Se o banco existir testa as tabelas, caso cliente não tenha sido instalada redireciona para tela de insalação das tabelas
	 * 
	 * @return void
	 */
	public function instalabd()
	{
		$db = ConnectionManager::getInstance();
		$connected = $db->getDataSource('default');
		if ($connected->isConnected())
		{
			// verificando se as tabelas já não foram criadas
			$tabelas = $connected->listSources();
			if (count($tabelas))
			{
				$this->redirect('erro');
			} else
			{
				$this->redirect('instalatb');
			}
		}
		$banco 	= $db->config->default['database'];
		$login	= $db->config->default['login'];
		$senha	= $db->config->default['password'];
		$host	= $db->config->default['host'];
		$this->set(compact('banco','login','senha','host'));
	}

	/**
	 * Exibe a tela de erro para banco já instalado
	 * 
	 * @return void
	 */
	public function erro()
	{
	}

	/**
	 * Exibe a tela de instalação das tabelas da aplicação
	 * 
	 * @return	boolean
	 */
	public function instalatb()
	{
		if (isset($this->data['Ferramenta']['tipo']))
		{
			$msg 	= '';
			$nome	= isset($this->data['Ferramenta']['nome'])  ? $this->data['Ferramenta']['nome']  : '';
			$email	= isset($this->data['Ferramenta']['email']) ? $this->data['Ferramenta']['email'] : '';
			$login	= isset($this->data['Ferramenta']['login']) ? $this->data['Ferramenta']['login'] : '';
			$senha	= isset($this->data['Ferramenta']['senha']) ? $this->data['Ferramenta']['senha'] : '';
			if (!empty($nome) && !empty($login) && !empty($senha) && !empty($email))
			{
				$res = $this->getInstalaTb();
				if ($res)
				{
					// atualizando usuário administrador
					$this->loadModel('Usuario');
					$this->Usuario->create();
					$dataUs['Usuario']['nome']		= mb_strtoupper($nome);
					$dataUs['Usuario']['email']		= mb_strtolower($email);
					$dataUs['Usuario']['login'] 	= mb_strtolower($login);
					$dataUs['Usuario']['senha']		= Security::hash(Configure::read('Security.salt') . $senha);
					$dataUs['Usuario']['modified'] 	= date('Y-m-d h:i:s');
					$dataUs['Usuario']['created'] 	= date('Y-m-d h:i:s');
					if ($this->Usuario->save($dataUs, array('fieldList'=>array('login','nome','email','senha','modified','created')) ))
					{
						$msg = 'Instalação executada com sucesso !';
						$this->redirect('/');
					} else
					{
						$msg = 'Erro ao tentar incluir administrador !';
					}
				} else
				{
					$msg = 'Erro ao executar instalação';
				}
				$this->setLimpaCache();
			} else
			{
				$msg = '<span class="iErro">Preencha todos os campos por favor !!!</span>';
			}
			$this->set('msg',$msg);
		} else
		{
			$db = ConnectionManager::getInstance();
			$connected = $db->getDataSource('default');
			if (!$connected->isConnected())
			{
				$this->redirect('instalabd');
			}
		}
	}

	/**
	 * Executa a instalação do banco de dados
	 * 
	 * @return boolean
	 */
	private function getInstalaTb()
	{
		// csv a importar
		$arrCsv = array('estados','cidades','perfis','usuarios_perfis');

		// instancio o datasource só pra pegar erros do banco
		$db = ConnectionManager::getDataSource('default');

		// verificando se as tabelas já não foram criadas
		$tabelas = $db->listSources();
		if (count($tabelas))
		{
			$this->redirect('erro');
		}

		// instala todas as tabelas do sistema
		$arq = APP.'docs'.DS.'sql'.DS.mb_strtolower(SISTEMA).'.sql';
		if (!file_exists($arq))
		{
			$this->erro = 'Não foi possível localicar o arquivo '.$arq;
			exit('não foi possível localizar o arquivo '.$arq);
			return false;
		}
		$handle  = fopen($arq,"r");
		$texto   = fread($handle, filesize($arq));
		$sqls	 = explode(";",$texto);
		fclose($handle);
		foreach($sqls as $sql) // executando sql a sql
		{
			if (trim($sql))
			{
				$this->Ferramenta->query($sql, $cachequeries=false);
				if ($db->lastError())
				{
					exit($db->lastError());
				}
			}
		}

		// atualiza outras tabelas vias CSV
		foreach($arrCsv as $tabela)
		{
			$this->setPopulaTabela(APP.DS.'docs'.DS.'sql'.DS.$tabela.'.csv',$tabela,$db);
		}

		return true;
	}

	/**
	 * Popula uma tabela do banco com seu aquivo CSV
	 * 
	 * @parameter 	$arq	string	Caminho completo com o nome do arquivo
	 * @parameter	$tabela	string	Nome da tabela a ser populada
	 * @parameter	$db		object	Instancia de banco de dados
	 * @return		boolean
	 */
	private function setPopulaTabela($arq='',$tabela='',$db=null)
	{
		// mandando bala se o csv existe
		if (file_exists($arq))
		{
			$handle  	= fopen($arq,"r");
			$l 			= 0;
			$campos 	= '';
			$cmps	 	= array();
			$valores 	= '';

			// executando linha a linha
			while ($linha = fgetcsv($handle, 2048, ";"))
			{
				if (!$l)
				{
					$i = 0;
					$t = count($linha);
					foreach($linha as $campo)
					{
						$campos .= $campo;
						$i++;
						if ($i!=$t) $campos .= ',';
					}
					// montand os campos da tabela
					$arr_campos = explode(',',$campos);
				} else
				{
					$valores  = '';
					$i = 0;
					$t = count($linha);
					foreach($linha as $valor)
					{
						if ($arr_campos[$i]=='created' || $arr_campos[$i]=='modified') $valor = date("Y-m-d H:i:s");
						$valores .= "'".str_replace("'","\'",$valor)."'";
						$i++;
						if ($i!=$t) $valores .= ',';
					}
					$sql = 'INSERT INTO '.$tabela.' ('.$campos.') VALUES ('.$valores.')';
					$this->Ferramenta->query($sql, $cachequeries=false);
					if ($db->lastError()) exit($db->lastError());
				}
				$l++;
			}
			fclose($handle);

			// verificando se a tabela possui created e modified
			$res = $this->Ferramenta->query('SHOW FULL COLUMNS FROM '.$tabela, $cachequeries=false);
			foreach($res as $_linha => $_arrColunas)
			{
				if ($_arrColunas['COLUMNS']['Field']=='modified')	array_push($cmps,'modified');
				if ($_arrColunas['COLUMNS']['Field']=='created')	array_push($cmps,'created');
			}
			if (count($cmps))
			{
				$sql = '';
				foreach($cmps as $_campo) $sql .= "$_campo='".date("Y-m-d H:i:s")."', ";
				$sql = substr($sql,0,strlen($sql)-2);
				$sql = 'UPDATE '.$tabela.' SET '.$sql;
				$this->Ferramenta->query($sql, $cachequeries=false);
				if ($db->lastError()) exit($db->lastError());
			}

		} else echo 'não foi possivel localizar '.$arq.'<br />';
		return true;
	}

	/**
	 * Limpa o cache
	 * 
	 * @return void
	 */
	private function setLimpaCache()
	{
		Cache::clear();
	}
}
?>
