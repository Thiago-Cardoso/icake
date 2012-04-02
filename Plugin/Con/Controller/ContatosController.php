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
		$layout = 'default';
		$meses	= array(1=>'Janeiro', 2=>'Fevereiro', 3=>'Março', 4=>'Abril', 5=>'Maio', 6=>'Junho', 7=>'Julho', 8=>'Agosto', 9=>'Setembro', 10=>'Outubro', 11=>'Novembro', 12=>'Dezembro');
		
		// se o form do relatório foi postado, então recuperao os dados do banco
		if (isset($this->data['Rel']))
		{
			$layout		 	= isset($this->data['Rel']['Layout']) ? $this->data['Rel']['Layout'] : 'default';
			$mes			= $this->data['Rel']['Mes'];
			$opcoes 		= array();
			$opcoes['conditions']['substr(Contato.aniversario,3,2)'] = $mes;
			$this->data 	= $this->Contato->find('all',$opcoes);
			$this->set(compact('mes'));
		}

		switch($layout)
		{
			case 'pdf':
				$rel_campos			= array('Contato.nome','Contato.email','Contato.tel1','Contato.tel3','Contato.aniversario');
				$rel_titulos['0']	= 'Lista dos Aniversariantes do Mês de '.$meses[$mes];
				$colunas['1']['lar']		= '90';
				$colunas['2']['lar']		= '90';
				$colunas['2']['ali']		= 'C';
				$colunas['3']['lar']		= '30';
				$colunas['3']['ali']		= 'C';
				$colunas['4']['lar']		= '30';
				$colunas['4']['ali']		= 'C';
				$colunas['5']['lar']		= '24';
				$colunas['5']['ali']		= 'C';
				$this->set(compact('rel_campos','rel_titulos','colunas'));
				break;
			default:
				// parâmetros para a tela de filtro
				$relTitulo = 'Escolha o mês e o Ano para a lista de Aniversariantes';
				$relCamposFiltro['Rel.Mes']['tit'] = 'Mês';
				$relCamposFiltro['Rel.Mes']['input']['options'] = $meses;
				$relCamposFiltro['Rel.Mes']['input']['default'] = date('m');
				$this->set(compact('relTitulo','relCamposFiltro'));
		}

		parent::relatorio($layout);
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
