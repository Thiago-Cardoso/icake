<?php
/**
 * Controller para as ferramentas da aplicação icake.
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
Configure::write('debug', 2);
class FerramentasController extends AppController {
	/**
	 * Model usado pelo controlador
	 * 
	 * @var		array
	 * @access	public
	 */
	public $uses	= array('Ferramenta');

	/**
	 * Exibe a tela inicial de ferramentas
	 * 
	 * @return void
	 */
	public function index()
	{
		if ($this->data)
		{
			//debug($this->data);
			$msg = '';
			switch($this->data['Ferramenta']['tipo'])
			{
				case 'instalarPlugin':
					$dir 	= APP . 'Plugin'. DS . ucfirst(strtolower($this->data['plugin'])). DS . 'Docs' . DS . 'Sql'. DS;
					$plugin	= strtolower($this->data['plugin']);
					$arq	= $dir.$plugin.'.sql';
					if (file_exists($arq))
					{
						if ($this->getInstalaSql($dir,$plugin))
						{
							$msg = 'Plugin instalado com sucesso !!!';
						} else
						{
							$msg = 'Erro ao tentar instalar plugin';
						}
					} else
					{
						$msg = 'Não foi possível localizar o arquivo '.$arq;
					}
					break;
			}
			$this->set(compact('msg'));
		}
		
		// se enviou o nome do plugin a ser instalado
		if ($this->Session->check('nomePlugin'))
		{
			$this->set('nomePlugin',$this->Session->read('nomePlugin'));
			$this->Session->delete('nomePlugin');
		}
		
		// se enviou o erro de plugin
		if ($this->Session->check('erroPlugin'))
		{
			$this->set('msg',$this->Session->read('erroPlugin'));
			$this->Session->delete('erroPlugin');
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
		// limpando o cache model na marra
		if(!in_array(strtolower(PHP_OS),array('winnt','windows','win','w')))
		{
			$dirCache	= APP . 'tmp' . DS . 'cache' . DS . 'models'. DS;
			$ponteiro	= opendir($dirCache);
			while ($nome_itens = readdir($ponteiro)) if (!in_array($nome_itens,array('.','..','vazio'))) unlink($dirCache.$nome_itens);
		}

		// Incluindo Model
		App::uses('ConnectionManager', 'Model');
		try
		{
			$bd = ConnectionManager::getDataSource('default');
		} catch (Exception $e)
		{
			$bd = false;
		}
		if ($bd && $bd->isConnected())
		{
			// verificando se as tabelas já não foram criadas
			$tabelas = $bd->listSources();
			if (count($tabelas))
			{
				$this->redirect('erro');
			} else
			{
				$this->redirect('instalatb');
			}
		} else
		{
			if (!file_exists(APP . DS . 'Config' . DS . 'database.php')) exit('NÃO FOI POSSÍVEL ENCONTRAR O ARQUIVO DE CONFIGURAÇÃO DO BANCO DE DADOS !!!');
			else
			{
				include_once(APP . DS . 'Config' . DS . 'database.php');
				$dbConf = new DATABASE_CONFIG();
			}
			$bd 			= $dbConf->default;
			$banco 			= $bd['database'];
			$login			= $bd['login'];
			$senha			= $bd['password'];
			$host			= $bd['host'];
			$data_source	= $bd['datasource'];
			$encoding		= $bd['encoding'];
			$this->set(compact('banco','login','senha','host','data_source','encoding'));
		}
	}

	/**
	 * Exibe a tela de erro para banco já instalado
	 * 
	 * @return void
	 */
	public function erro()
	{
		echo '<pre>fudeu !!!</pre>';
	}

	/**
	 * Exibe a tela de instalação das tabelas da aplicação
	 * 
	 * @return	boolean
	 */
	public function instalatb()
	{
		// incluindo Model
		App::uses('ConnectionManager', 'Model');
		$bd = ConnectionManager::getDataSource('default');

		if (isset($this->data['Ferramenta']['tipo']))
		{
			$msg 	= '';
			$erro	= '';
			$nome	= isset($this->data['Ferramenta']['nome'])  ? $this->data['Ferramenta']['nome']  : '';
			$email	= isset($this->data['Ferramenta']['email']) ? $this->data['Ferramenta']['email'] : '';
			$login	= isset($this->data['Ferramenta']['login']) ? $this->data['Ferramenta']['login'] : '';
			$senha	= isset($this->data['Ferramenta']['senha']) ? $this->data['Ferramenta']['senha'] : '';
			$senha2	= isset($this->data['Ferramenta']['senha2']) ? $this->data['Ferramenta']['senha2'] : '';
			if (!empty($nome) && !empty($login) && !empty($senha) && !empty($email) && ($senha==$senha2) )
			{
				$arqSql = 'icake';
				if ($bd->config['datasource'] != 'Database/Mysql')
				{
					$t = strtolower(str_replace('Database/','',$bd->config['datasource']));
					$arqSql .= '_'.$t;
				}

				$res = $this->getInstalaSql(APP . 'Docs' . DS . 'Sql' . DS, $arqSql);
				if ($res)
				{
					/*App::uses('Security', 'Utility');
					$senha = Security::hash(Configure::read('Security.salt') . $senha);*/

					// atualizando usuário administrador
					$this->loadModel('Usuario');
					$this->Usuario->create();
					$dataUs['Usuario']['nome']			= mb_strtoupper($nome);
					$dataUs['Usuario']['email']			= mb_strtolower($email);
					$dataUs['Usuario']['login'] 		= mb_strtolower($login);
					$dataUs['Usuario']['senha']			= $senha;
					$dataUs['Usuario']['senha2']		= $senha2;
					$dataUs['Usuario']['ultimo_acesso']	= date('Y-m-d h:i:s');
					$dataUs['Usuario']['modified'] 		= date('Y-m-d h:i:s');
					$dataUs['Usuario']['created'] 		= date('Y-m-d h:i:s');
					$dataUs['Usuario']['perfil_id'] 	= '1';
					if ($this->Usuario->save($dataUs, array('fieldList'=>array('login','nome','email','senha','ultimo_acesso','modified','created','perfil_id')) ))
					{
						// populando escolas com conteúdo diretamente do SGE
						$this->Session->setFlash(Configure::read('SISTEMA').' instalado com sucesso !!!', 'default', array('class' => 'msgOk'));
						$this->redirect('/');
					} else
					{
						debug($this->Usuario->validationErrors); 
						die($this->Usuario->data);
					}
				} else
				{
					$erro = 'Erro ao executar instalação';
				}
			} else
			{
				$erro = 'Preencha todos os campos por favor !!!';
				if (($senha!=$senha2)) $erro = 'As senhas estão diferentes !!!';
			}
			if (!empty($erro))
			{
				$this->Session->setFlash($erro, 'default', array('class' => 'loginErro'));
			} else
			{
				$this->Session->setFlash($msg, 'default', array('class' => 'loginOk'));
			}
		} else
		{
			$bd = ConnectionManager::getDataSource('default');
			if (!$bd->isConnected())
			{
				exit('não contectou');
				$this->redirect('instalabd');
			}
		}
	}

	/**
	 * Executa a instalação do banco de dados
	 * 
	 * @return boolean
	 */
	private function getInstalaSql($dir='',$arq='')
	{
		// limpando o cache model na marra
		if(!in_array(strtolower(PHP_OS),array('winnt','windows','win','w')))
		{
			$dirCache	= APP . 'tmp' . DS . 'cache' . DS . 'models'. DS;
			$ponteiro	= opendir($dirCache);
			while ($nome_itens = readdir($ponteiro)) if (!in_array($nome_itens,array('.','..','vazio'))) unlink($dirCache.$nome_itens);
		}

		// arquivo
		$arq = $dir.$arq.'.sql';

		// instancio o datasource só pra pegar erros do banco
		App::uses('ConnectionManager', 'Model');
		$bd = ConnectionManager::getDataSource('default');

		// instala todas as tabelas do icake
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
				try
				{
					$this->Ferramenta->query($sql, $cachequeries=false);
				} catch (exception $ex)
				{
					die('erro ao executar: '.$sql.'<br />'.$ex->getMessage());
				}
			}
		}

		// descobrindo os arquivos CSV
		$arrCsv 	= array();
		$ponteiro	= opendir($dir);
		while ($nome_itens = readdir($ponteiro))
		{
			$arrNome = explode('.',$nome_itens);
			if (strtolower($arrNome['1'])=='csv') array_unshift($arrCsv,$arrNome['0']);
		}

		// atualiza outras tabelas vias CSV
		foreach($arrCsv as $tabela)
		{
			$this->setPopulaTabela($dir.$tabela.'.csv',$tabela,$bd);
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
	private function setPopulaTabela($arq='',$tabela='',$bd=null)
	{
		// limpando o cache model na marra
		if(!in_array(strtolower(PHP_OS),array('winnt','windows','win','w')))
		{
			$dirCache	= APP . 'tmp' . DS . 'cache' . DS . 'models'. DS;
			$ponteiro	= opendir($dirCache);
			while ($nome_itens = readdir($ponteiro)) if (!in_array($nome_itens,array('.','..','vazio'))) unlink($dirCache.$nome_itens);
		}

		// importando o database pra saber com qual banco estamos lidando.
/*		App::uses('ConnectionManager', 'Model');
		$bd = ConnectionManager::getDataSource('default');
*/
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
						$valor = str_replace("'",'',$valor);
						$valores .= "'".str_replace("'","\'",$valor)."'";
						$i++;
						if ($i!=$t) $valores .= ',';
					}
					$sql = 'INSERT INTO '.$tabela.' ('.$campos.') VALUES ('.$valores.')';
					try
					{
						$this->Ferramenta->query($sql, $cachequeries=false);
					} catch (exception $ex)
					{
						die('erro ao executar: '.$sql.'<br />'.$ex->getMessage());
					}
				}
				$l++;
			}
			fclose($handle);

			// verificando se a tabela possui created e modified
			if ($bd->config['datasource'] == 'Database/Mysql')
			{
				try
				{
					$res = $this->Ferramenta->query('SHOW FULL COLUMNS FROM '.$tabela, $cachequeries=false);

				} catch (exception $ex)
				{
					die('erro ao executar: recuperar lista de tabelas<br />'.$ex->getMessage());
				}
				foreach($res as $_linha => $_arrColunas)
				{
					if ($_arrColunas['COLUMNS']['Field']=='modified')	array_push($cmps,'modified');
					if ($_arrColunas['COLUMNS']['Field']=='created')	array_push($cmps,'created');
				}
			}
			
			if ($bd->config['datasource'] == 'Database/Postgres')
			{
				try
				{
					$res = $this->Ferramenta->query('SELECT column_name FROM information_schema.columns WHERE table_name =\''.$tabela.'\'', $cachequeries=false);
				} catch (exception $ex)
				{
					echo '<pre>'.print_r($ex,true).'</pre>';
					die('erro ao executar: recuperar lista de tabelas<br />'.$ex->getMessage());
				}
				foreach($res as $_linha => $_arrColunas)
				{
					if ($_arrColunas['0']['column_name']=='modified')	array_push($cmps,'modified');
					if ($_arrColunas['0']['column_name']=='created')	array_push($cmps,'created');
				}
			}
			
			if (count($cmps))
			{
				$sql = '';
				foreach($cmps as $_campo) $sql .= "$_campo='".date("Y-m-d H:i:s")."', ";
				$sql = substr($sql,0,strlen($sql)-2);
				$sql = 'UPDATE '.$tabela.' SET '.$sql;
				try
				{
					$this->Ferramenta->query($sql, $cachequeries=false);
				} catch (exception $ex)
				{
					die('erro ao executar: '.$sql.'<br />'.$ex->getMessage());
				}
			}

		} else echo 'não foi possivel localizar '.$arq.'<br />';

		return true;
	}
}
