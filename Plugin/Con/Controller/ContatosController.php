<?php
/**
 * Controller para o cadastro de Contatos
 *
 * @copyright	Copyright 2008-2012, Adriano Carneiro de Moura
 * @link		http://github.com/adrianodemoura/icake 	Projeto iCake
 * @package		icake.contatos
 * @subpackage	icake.contatos.Controller
 * @since		CakePHP(tm) v 2.1
 * @license		MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
/**
 * @package			icake.contatos
 * @subpackage		icake.contatos.Controller
 */
class ContatosController extends ConAppController {
	/**
	 * Modelo
	 * 
	 * @var		array
	 * @access	public
	 */
	public $uses	= array('Con.Contato');

	/**
	 * Imprime a lista de cargos
	 * 
	 * @return	void
	 */
	public function rel_lista()
	{
		$parametros['order']					= 'Contato.nome';
		parent::rel_lista($parametros);
	}

	/**
	 * Exibe a tela para o filtro de aniversariantes
	 *
	 * @return	void
	 */
	public function aniversariantes() 
	{
		if (isset($this->data['Rel']))
		{
			$this->layout 	= isset($this->data['Rel']['Layout']) ? $this->data['Rel']['Layout'] : 'pdf';
			$mes			= $this->data['Rel']['Mes'];
			$opcoes 		= array();
			$opcoes['conditions']['substr(Contato.aniversario,3,2)'] = $mes;
			$this->data 	= $this->Contato->find('all',$opcoes);
			$this->set(compact('meses','mes'));
		}
		
		// definindo a visão com base no layout
		switch($this->layout)
		{
			case 'pdf':
				$visao = 'pdf_aniversariantes';
				break;
			case 'tela':
				$visao = 'tela_aniversariantes';
				$this->layout = 'default';
				break;
			case 'csv':
				$visao = 'csv_aniversariantes';
				break;
			case 'imp':
				$visao = 'imp_aniversariantes';
				break;
			default:
				$visao = 'fil_aniversariantes';
				break;
		}
		$this->render($visao);
	}


	/**
	 * Exibe a tela para envio de parabéns
	 * 
	 * @return	void
	 */
	public function parabens() 
	{
	}
}
