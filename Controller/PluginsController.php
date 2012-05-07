<?php
/**
 * Controller para o cadastro de Plugins
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
class PluginsController extends AppController {
	/**
	 * Executa código antes da renderização da view
	 * 
	 * @return	void
	 */
	public function beforeRender()
	{
		$campos['Plugin']['nome']['tit']			= 'Nome';
		$campos['Plugin']['nome']['input']['type']	= 'leitura';
		$campos['Plugin']['ativo']['tit']			= 'Ativo';
		$campos['Plugin']['ativo']['th']['width'] 	= '100px';
		$campos['Plugin']['ativo']['td']['align'] 	= 'center';
		$campos['Plugin']['ativo']['input']['options']['1'] = 'Sim';
		$campos['Plugin']['ativo']['input']['options']['0'] = 'Não';
		$camposPesquisa = array('Plugin.nome');
		$edicaoCampos	= array('Plugin.nome','Plugin.ativo');
		$botoesOff		= true;
		$botoes			= array();
		$botoes['0']	= array();
		$botoes['4']	= array();

		// populando a view
		$this->set(compact('campos','camposPesquisa','edicaoCampos','botoes'));
		
		parent::beforeRender();
	}

	/**
	 * Exibe a tela de paginação do cadastro de plugins
	 * 
	 * @return	void
	 */
	public function listar()
	{
		$this->viewVars['listaCampos'] = array('Plugin.nome','Plugin.ativo');
		parent::listar();
	}

	/**
	 * Executa a exclusão do plugin.\n
	 * Após exclusão o sistema é redirecionado a lista.
	 * 
	 * @param	integer		$id
	 * @return	void
	 */
	public function delete($id=0)
	{
	    // Incluindo Model
		/*App::uses('ConnectionManager', 'Model');
		try
		{
			$bd = ConnectionManager::getDataSource('default');
		} catch (Exception $e)
		{
			$bd = false;
		}
		if ($bd && $bd->isConnected())
		{
			// recuperando o nome do plugin
			$data	= $this->Plugin->find('list',array('conditions'=>array('Plugin.id'=>$id)));
			$plugin	= strtolower($data['1']);

			// verificando se as tabelas já não foram criadas
			$tabelas = $bd->listSources();
			foreach($tabelas as $_tabela)
			{
				if (substr($_tabela,0,4)==$plugin.'_')
				{
					if (!$this->Plugin->query('DROP TABLE '.$_tabela))
					{
						die('Erro ao excluir a tabela '.$_tabela);
					}
				}
			}
		}*/
		$this->Session->delete('menus');
		parent::delete($id);
    }

	/**
	 * Salva o registro de Plugin
	 * 
	 * @return	void
	 */
	public function salvar()
	{
		$this->Session->delete('menus');
		parent::salvar();
	}
}
