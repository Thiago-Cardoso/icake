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
	}

	/**
	 * Retorna o relatório dos aniversariantes
	 * 
	 * @param	integer		$mês	Mês
	 * @param	integer		$ano	Ano
	 * @return	void
	 */
	public function rel_aniversariantes()
	{
		if (!isset($this->data['Ani']))
		{
			$this->Session->setFlash('O Mês não foi informado !!!','default',array('class' => 'msgErro'));
			$this->redirect('aniversariantes');
		}
		$mes	= $this->data['Ani']['Mes'];
		$meses 	= array(1=>'Janeiro', 2=>'Fevereiro', 3=>'Março', 4=>'Abril', 5=>'Maio', 6=>'Junho', 7=>'Julho', 8=>'Agosto', 9=>'Setembro', 10=>'Outubro', 11=>'Novembro', 12=>'Dezembro');
		$opcoes = array();
		$opcoes['conditions']['substr(Contato.aniversario,3,2)'] = $mes;
		$this->data = $this->Contato->find('all',$opcoes);
		$this->layout = 'pdf';
		
		$this->set(compact('meses','mes'));
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
