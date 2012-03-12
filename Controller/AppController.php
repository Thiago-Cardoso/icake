<?php
/**
 * Controller principal da aplicação, pai de todos.
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
App::uses('Controller', 'Controller');
class AppController extends Controller {
	/**
	 * Ajudantes para a camada de visão
	 * 
	 * @var		array
	 * @access	public
	 */
	public $helpers	= array('Pagina','Html','Session','Form');

	/**
	 * Executa código antes da renderização
	 * 
	 * @return	void
	 */
	public function beforeRender()
	{
		// verificando o pedido de instalação de plugin
		if ($this->name=='CakeError' && 
			($this->viewVars['code']=='500' || $this->viewVars['error']->getCode()=='500') && 
			!empty($this->request->params['plugin']) &&
			empty($this->data) &&
			$this->Session->check('Usuario.id')
			)
		{
			$this->Session->write('nomePlugin',$this->request->params['plugin']);
			$this->Session->write('erroPlugin',$this->viewVars['name']);
			$this->Session->setFlash('É necessário executar a instalação do plugin <strong>'.$this->request->params['plugin'].'</strong> !!!','default',array('class' => 'msgErro'));
			//$this->redirect(Router::url('/',true).'ferramentas');
		}

		// se está logado vamos configurar o menu
		if ($this->Session->check('Usuario.id'))
		{
			if (!$this->Session->check('menus'))
			{
				$menus 		= array();
				$dirPlugin	= APP . 'Plugin' . DS;
				if (is_dir($dirPlugin))
				{
					$ponteiro	= opendir($dirPlugin);
					while ($nome_dir = readdir($ponteiro))
					if (!in_array($nome_dir,array('.','..')))
					{
						$arq = $dirPlugin . DS . $nome_dir . DS . 'Config' . DS . 'menu.php';
						if (file_exists($arq))
						{
							require_once($arq);
							array_push($menus,$menu);
						}
					}
				}
				$this->Session->write('menus',$menus);
			}
		}

		// jogando as variáveis de ambiente na view
		$opcoes_restricao 	= Configure::read('RESTRICOES');
		$SISTEMA			= Configure::read('SISTEMA');
		$EMPRESA			= Configure::read('EMPRESA');
		$SIGLA				= Configure::read('SIGLA');

		$this->set('onRead','');
		$this->set(compact('opcoes_restricao','SISTEMA','EMPRESA','SIGLA'));
	}

	/**
	 * Exibe a página principal do cadastro de usuários
	 * 
	 * @return 	void
	 */
	public function index()
	{
		$this->redirect('listar');
	}

	/**
	 * Retorno pesquisa para selectBox
	 */
	public function combo($campo='', $valor=0)
	{
		$this->viewPath 	= 'Scaffolds';
		$this->layout		= 'ajax';
		$modelClass 		= $this->modelClass;
		$condicao[$campo]	= $valor;
		$lista_combo		= $this->$modelClass->find('list',array('conditions'=>$condicao));
		$this->set(compact('lista_combo'));
	}

	/**
	 * Exibe a o dbrigd do cadastro.\n
	 * 
	 * @return void
	 */
	public function listar()
	{
		// variáveis pertinentes à função e à view também
		$title_for_layout	= 'Listando '.ucfirst(strtolower($this->name));
		$modelClass			= $this->modelClass;
		$schema[$modelClass]= $this->$modelClass->schema();
		$pagina				= isset($this->params['named']['pagina'])  ? $this->params['named']['pagina']  : 1;
		$direcao			= isset($this->params['named']['direcao']) ? $this->params['named']['direcao'] : 'asc';

		// recuperando a página solicitada
		$paginacao['page'] 		= isset($this->params['named']['pagina'])  ? $this->params['named']['pagina']  : 1;
		$paginacao['sort'] 		= isset($this->params['named']['ordem'])   ? $this->params['named']['ordem']   : $this->$modelClass->displayField;
		$paginacao['direction']	= isset($this->params['named']['direcao']) ? $this->params['named']['direcao'] : 'asc';
		$this->params['named'] 	= $paginacao;
		$this->data				= $this->paginate();

		// atualizando a paginação com os dados da página recuperada
		$paginacao['options'] 	= $this->params['paging'][$modelClass]['options'];
		$paginacao['page'] 		= $this->params['paging'][$modelClass]['page'];
		$paginacao['current'] 	= $this->params['paging'][$modelClass]['current'];
		$paginacao['count'] 	= $this->params['paging'][$modelClass]['count'];
		$paginacao['prevPage'] 	= ($pagina-1);
		$paginacao['nextPage'] 	= ($pagina+1);
		$paginacao['pageCount'] = $this->params['paging'][$modelClass]['pageCount'];

		if ($paginacao['count']>0)
		{
			// se extrapolou a última paǵina redireciona para ela mesma.
			if ($paginacao['pageCount']<$paginacao['page']) $this->redirect('listar/pagina:'.$paginacao['pageCount'].'/ordem:'.$paginacao['sort'].'/direcao:'.$paginacao['direction']);
			
			// se extrapolou a primeira paǵina redireciona para ela mesma.
			if ($pagina<1) $this->redirect('listar/pagina:'.$paginacao['page'].'/ordem:'.$paginacao['sort'].'/direcao:'.$paginacao['direction']);
		}

		// atualiando a view com algumas variáveis
		$this->set('onRead','');
		$this->set(compact('title_for_layout','modelClass','paginacao','schema'));
	}

	/**
	 * Exibe a tela de edição do cadastro filho
	 * 
	 * @param	integer		$id
	 * @retur	void
	 */
	public function editar($id=0, $idHbtm=0)
	{
		// verificando a permissão
		if (in_array('G',$this->Session->read('Usuario.Restricoes')) && $this->name!='Usuarios')
		{
			$this->Session->setFlash('Você não tem autorização para acessar esta página !!!','default',array('class' => 'msgErro'));
			$this->redirect(Router::url('/',true).'usuarios/editar/'.$this->Session->read('Usuario.id'));
		}

		// se postou um id hbtm, executa ação para excluí-lo
		if (!empty($idHbtm))
		{
			$this->setExcluiHbtm($id,$idHbtm);
		}

		// variáveis pertinentes à função e à visão
		$title_for_layout	= 'Editando '.$this->name;
		$modelClass 		= $this->modelClass;
		$this->data 		= $this->$modelClass->read(null,$id);
		$schema[$modelClass]= $this->$modelClass->schema();
		$tipo				= 'editar';

		// recuperando o order by 
		$ordem	= $this->Session->check('Ordem_'.$modelClass) ? $this->Session->read('Ordem_'.$modelClass) : (isset($this->$modelClass->order)?$this->$modelClass->order:$modelClass.'.id');

		// recuperando o primeiro e último
		$primeiro 	= $this->$modelClass->find('first', array('order'=>$ordem,'recursive'=>-1,'fields'=>'id')); 
		$primeiro 	= $primeiro[$modelClass]['id'];
		$ultimo		= $this->$modelClass->find('first', array('order'=>$ordem.' DESC','recursive'=>-1,'fields'=>'id'));
		$ultimo		= $ultimo[$modelClass]['id'];

		// recuperando os dois registro vizinhos
		$arrCmp = explode('.',$ordem);
		$vizinhos = $this->$modelClass->find('neighbors', array('field' => $ordem, 'value' => $this->data[$modelClass][$arrCmp['1']],'fields'=>array('id',$arrCmp['1'])));
		if (isset($vizinhos['prev'][$modelClass]['id'])) $anterior = $vizinhos['prev'][$modelClass]['id']; else $anterior = $primeiro;
		if (isset($vizinhos['next'][$modelClass]['id'])) $proximo  = $vizinhos['next'][$modelClass]['id']; else $proximo  = $ultimo;

		$this->setAssociacoes();

		// recuperando alguns possíveis erros do formulário
		if ($this->Session->check('edicao_erros'))
		{
			$edicao_erros = $this->Session->read('edicao_erros');
			$this->Session->delete('edicao_erros');
		}

		$this->set('onRead','');
		$this->set(compact('id','title_for_layout','lista','modelClass','schema','edicao_erros','primeiro','anterior','proximo','ultimo','tipo'));
	}

	/**
	 * Exibe a tela de exclusão do registro do cadastro
	 * 
	 * @param	integer		$id
	 */
	public function excluir($id=0)
	{
		// variáveis pertinentes à função e à visão
		$title_for_layout	= 'Excluindo '.$this->name;
		$modelClass 		= $this->modelClass;
		$this->data 		= $this->$modelClass->read(null,$id);
		$tipo				= 'excluir';
		$schema[$modelClass]= $this->$modelClass->schema();

		$this->setAssociacoes();

		$this->set('onRead','');
		$this->set(compact('id','tipo','title_for_layout','lista','modelClass'));
		$this->render('editar');
	}

	/**
	 * Executa a exclusão do registro no banco de dados.\n
	 * Após exclusão o sistema é redirecionado a lista.
	 * 
	 * @param	integer		$id
	 * @return	void
	 */
	public function delete($id=0)
	{
		$modelClass = $this->modelClass;
		if ($this->$modelClass->delete($id))
		{
			$this->Session->setFlash('O registro foi excluído com sucesso !!!','default',array('class'=>'msgOk'));
		} else
		{
			$this->Session->setFlash('Erro ao tentar excluir registro','default',array('class'=>'msgErro'));
			$this->Session->write('edicao_erros',$this->$modelClass->validationErrors);
		}
		$this->redirect('listar');
	}

		/**
	 * Exibe a tela de impressão do registro selecionado pelo id
	 * 
	 * @param	integer		$id
	 * @return	void
	 */
	public function imprimir($id=0)
	{
		// variáveis pertinentes à função e à visão
		$title_for_layout	= 'Exibindo '.$this->name;
		$modelClass 		= $this->modelClass;
		$this->data 		= $this->$modelClass->read(null,$id);
		$tipo				= 'imprimir';
		$schema[$modelClass]= $this->$modelClass->schema();

		$this->setAssociacoes();

		$this->set('onRead','');
		$this->set(compact('id','tipo','schema','title_for_layout','modelClass'));
		$this->render('editar');
	}

	/**
	 * Atualiza o registro no banco de dados seja, inclusão, exclusão ou alteração.\n
	 * Após a atualização do banco o sistema é redirecionado para edição ou listagem.
	 * 
	 * @param	array	Matri contendo o com conteudo do registro
	 * @return	void
	 */
	public function salvar($retornar=true)
	{
		if (in_array('G',$this->Session->read('Usuario.Restricoes')))
		{
			if ($this->name!='Usuarios' && $this->Session->read('Usuario.id')!=$this->data['Usuario']['id'])
			{
				$this->Session->setFlash('Tá burlando a lei né engraçadinho !!! Você não pode gravar nada meu chapa !!!','default',array('class' => 'msgErro'));
				$this->redirect(Router::url('/',true).'usuarios/editar/'.$this->Session->read('Usuario.id'));
			} else
			{
				$this->request->data['Usuario']['trocar_senha'] = 0;
			}
		}

		// variáveis padrão
		$modelClass = $this->modelClass;
		$id 		= isset($this->data[$modelClass]['id']) 	? $this->data[$modelClass]['id'] 	: 0;
		$tipo	 	= isset($this->data['tipo']) 				? $this->data['tipo'] 				: 'editar';
		$retorno	= Router::url('/',true);
		if (!empty($this->request->params['plugin'])) $retorno .= $this->request->params['plugin'].'/';
		$retorno 	.= strtolower($this->name);

		// se postou o formulário hbtm
		//debug($this->data); die('tchau');
		switch($tipo)
		{
			case 'novo':
				if ($this->$modelClass->save($this->data))
				{
					$this->Session->setFlash('O registro foi incluído com sucesso !!!','default',array('class' => 'msgOk'));
					$retorno .= '/editar/'.$this->$modelClass->id;
				} else
				{
					$this->Session->setFlash('O formulário ainda contém erros !!!','default',array('class' => 'msgErro'));
					$this->Session->write('edicao_erros',$this->$modelClass->validationErrors);
					$this->Session->write('edicao_data',$this->data);
					$retorno .= '/novo/';
					//debug($this->$modelClass->validationErrors); die();
				}
				break;
			default:
				$salvarCampos = isset($this->salvarCampos) ? $this->salvarCampos : array();
				//debug($this->data);
				if ($this->$modelClass->save($this->data, true, $salvarCampos))
				{
					$this->Session->setFlash('O registro foi salvo com sucesso !!!','default',array('class' => 'msgOk'));
				} else
				{
					$this->Session->setFlash('O formulário ainda contém erros !!!','default',array('class' => 'msgErro'));
					$this->Session->write('edicao_erros',$this->$modelClass->validationErrors);
					$this->Session->write('edicao_data',$this->data);
					//debug($this->$modelClass->validationErrors); die();
				}
				$retorno .= '/editar/'.$id;
				break;
		}
		// quando estiver debugando comente esta linha
		if ($retornar) $this->redirect($retorno);
	}

	/**
	 * Exibe a tela de inclusão de um novo registro do cadastro
	 * 
	 * @return	void
	 */
	public function novo()
	{
		// verifica os campos obrigatórios
		$modelClass = $this->modelClass;
		$schema[$modelClass]= $this->$modelClass->schema();
		$tipo		= 'novo';

		// jogando na view, o conteúdo para campos de relacionamento com outro model
		$associacoes = $this->$modelClass->getAssociated();
		if (count($associacoes))
		{
			foreach($associacoes as $_model => $_tipo)
			{
				$parametros = array();
				if (isset($this->$modelClass->belongsTo[$_model]['conditions']) && !empty($this->$modelClass->belongsTo[$_model]['conditions']))
				{
					$parametros['conditions'] = $this->$modelClass->belongsTo[$_model]['conditions'];
				}
				$parametros['limit'] = 1000;
				$this->set('opcoes_'.strtolower($_model),$this->$modelClass->$_model->find('list',$parametros));
			}
		}

		// recuperando alguns possíveis erros do formulário
		if ($this->Session->check('edicao_erros'))
		{
			$edicao_erros = $this->Session->read('edicao_erros');
			$this->Session->delete('edicao_erros');
		}

		// recuperando os dados inválidos do formulário
		if ($this->Session->check('edicao_data'))
		{
			$this->data = $this->Session->read('edicao_data');
			$this->Session->delete('edicao_data');
		}

		$this->set('onRead','');
		$this->set(compact('title_for_layout','modelClass','tipo','edicao_erros','schema'));
		$this->render('editar');
	}

	/**
	 * Imprime, em pdf, a lista
	 * 
	 * @param	array	$pametros	Matriz com os parâmetros de busca da lista no banco de dados, claúsulas WHERE, ORDER BY, LIMIT e etc ...
	 */
	public function rel_lista($parametros=array())
	{
		//$this->viewPath 	= 'Scaffolds';
		$this->layout 		= 'pdf';
		$modelClass 		= $this->modelClass;
		$this->set(compact('modelClass'));

		// configurando o filtro da lista, caso NÂO tenha sido configurando no filho, e ainda foi passado por algum FORM
		if (!isset($parametros['conditions']))
		{
			if (isset($this->data) && count($this->data))
			{
				unset($this->request->data['btEnviar']);
				foreach($this->data as $_model => $_arrCampos)
				{
					foreach($_arrCampos as $_campo => $_valor)
					{
						$parametros['conditions'][$_model.'.'.$_campo] = $_valor;
					}
				}
			}	
		}

		// recuperando os dados da lista
		$this->data = $this->$modelClass->find('all',$parametros);
	}

	/**
	 * 
	 */
	private function setExcluiHbtm($id=0,$idHbtm=0)
	{
		$this->redirect('editar/'.$id);
	}

	/**
	 * Joga na view o conteúdo de campos associados
	 * 
	 * @return	void
	 */
	private function setAssociacoes()
	{
		$modelClass = $this->modelClass;

		// jogando na view, o conteúdo para campos de relacionamento com outro model
		$associacoes = $this->$modelClass->getAssociated();
		if (count($associacoes))
		{
			foreach($associacoes as $_model => $_tipo)
			{
				$parametros = array();
				$condicao 	= array();

				// recuperando condição de belongsTo
				if (isset($this->$modelClass->belongsTo[$_model]['conditions'])) $condicao = $this->$modelClass->belongsTo[$_model]['conditions'];

				// exclusivo para o cadastro de cidades.
				if ($_model=='Cidade') $condicao['Cidade']['Cidade.estado_id'] = '{Estado.id}';

				// re-escrevendo a condição, caso acha campo {}
				if (!empty($condicao))
				{
					$parametros['conditions'] = $condicao[$_model];
					$arrCondicao 	= $condicao[$_model];
					if (is_array($arrCondicao))
					{
						$condicao		= array();
						foreach($arrCondicao as $_campo => $_valor)
						{
							$valor = $_valor;
							if (strpos($_valor,'}') )
							{
								$tmpValor = ereg_replace('[{}]','',$_valor);
								$tmpValor = explode('.',$tmpValor);
								$valor = $this->data[$tmpValor['0']][$tmpValor['1']];
							}
							$condicao[$_campo] = $valor;
						}
						if (!empty($condicao)) $parametros['conditions'] = $condicao;
					}
				}
				$parametros['conditions'] 	= $condicao;
				$parametros['limit'] 		= 1000;
				$this->set('opcoes_'.strtolower($_model),$this->$modelClass->$_model->find('list',$parametros));
			}
		}
	}

	/**
	 * Realiza uma pesquisa no banco de dados, bom uso para ajax.
	 * 
	 * @parameter 	string 	$campo 	Campo de pesquisa
	 * @parameter 	string 	$texto 	Texto de pesquisa
	 * @parameter	string 	$action	Action para onde será redirecionado ao clicar na resposta
	 * @return 		array 	$lista 	Array com lista de retorno
	 */
	public function pesquisar($campo=null,$texto=null,$action='editar')
	{
		// definindo a view usar
		$this->viewPath = 'Scaffolds';
		$this->layout 	= 'ajax';
		$url 			= Router::url('/',true);
		if (!empty($this->request->params['plugin'])) $url .= $this->request->params['plugin'].'/';

		$parametros										= array();
		$pluralHumanName 								= Inflector::humanize(Inflector::underscore($this->name));
		$modelClass 									= $this->modelClass;
		$id												= isset($this->modelClass->primaryKey) ? $this->modelClass->primaryKey : 'id';
		if (!empty($campo)) $parametros['conditions'] 	= $campo.' like "%'.$texto.'%"';
		if (!empty($campo)) $parametros['order'] 		= $campo;
		if (!empty($campo)) $parametros['limit'] 		= 20;
		$parametros['fields'] 							= array($id,$campo);
		$pesquisa 										= $this->$modelClass->find('list',$parametros);

		$this->Session->write('campoPesquisa'.$this->name,$campo);
		$this->set('link',$url.mb_strtolower(str_replace(' ','_',$pluralHumanName)).'/'.$action);
		$this->set('pesquisa',$pesquisa);
	}
}
