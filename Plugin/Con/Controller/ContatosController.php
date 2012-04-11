<?php
/**
 * Controller para o cadastro de Contatos
 *
 * @copyright	Copyright 2008-2012, Adriano Carneiro de Moura
 * @link		http://github.com/adrianodemoura/icake 	Projeto iCake
 * @package		icake.contatos
 * @subpackage	icake.contatos.controller
 * @since		CakePHP(tm) v 2.1
 * @license		MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
/**
 * @package			icake.contatos
 * @subpackage		icake.contatos.controller
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
	 * Imprime o relatório sintético dos contatos.
	 * 
	 * @return	void
	 */
	public function sintetico()
	{
		$relCampos				= array('Contato.nome','Contato.email','Contato.tel1','Contato.tel3','Contato.aniversario');

		// parâmetros para o pdf
		$relTitulos['0']		= 'Lista Sintética de Contatos';
		$colunas['1']['lar']	= '90';
		$colunas['2']['lar']	= '90';
		$colunas['2']['ali']	= 'C';
		$colunas['3']['lar']	= '30';
		$colunas['3']['ali']	= 'C';
		$colunas['4']['lar']	= '30';
		$colunas['4']['ali']	= 'C';
		$colunas['5']['lar']	= '24';
		$colunas['5']['ali']	= 'C';

		// se o form do relatório foi postado, então recupera os dados do banco
		if (isset($this->data['Rel']))
		{
			$this->layout= isset($this->data['Rel']['Layout']) ? $this->data['Rel']['Layout'] : 'default';
			$this->data  = $this->Contato->find('all',array('fields'=>$relCampos));
		}

		// atualizando a view
		$this->set(compact('relCampos','relTitulos','colunas'));

		// continua o processamento com action pai
		parent::relatorio();
	}

	/**
	 * Exibe a tela para o filtro de aniversariantes ou o relatório conforme o filtro e layout pedido.
	 *
	 * @return	void
	 */
	public function aniversariantes() 
	{
		$title_for_layout = 'Relatório de Aniversariantes';
		$meses		= array(1=>'Janeiro', 2=>'Fevereiro', 3=>'Março', 4=>'Abril', 5=>'Maio', 6=>'Junho', 7=>'Julho', 8=>'Agosto', 9=>'Setembro', 10=>'Outubro', 11=>'Novembro', 12=>'Dezembro');
		$relCampos	= array('Contato.nome','Contato.email','Contato.tel1','Contato.tel3','Contato.aniversario');
		
		// se o form do relatório foi postado, então recupera os dados do banco
		if (isset($this->data['Rel']))
		{
			$this->layout 	= isset($this->data['Rel']['Layout']) ? $this->data['Rel']['Layout'] : 'default';
			$mes			= '00'.$this->data['Rel']['Mes'];
			$mes			= substr($mes,strlen($mes)-2,2);
			$this->set(compact('mes'));
			$opcoes 		= array();
			$opcoes['conditions']['substr(Contato.aniversario,3,2)'] = $mes;
			$opcoes['fields']= $relCampos;
			$this->data 	= $this->Contato->find('all',$opcoes);
		}

		// parâmetros para o pdf
		if (isset($mes)) $relTitulos['0'] = 'Lista dos Aniversariantes do Mês de '.$meses[round($mes)];
		$colunas['1']['lar']	= '90';
		$colunas['2']['lar']	= '90';
		$colunas['2']['ali']	= 'C';
		$colunas['3']['lar']	= '30';
		$colunas['3']['ali']	= 'C';
		$colunas['4']['lar']	= '30';
		$colunas['4']['ali']	= 'C';
		$colunas['5']['lar']	= '24';
		$colunas['5']['ali']	= 'C';

		// parâmetros para a tela de filtro
		$relFiltroTitulo = 'Escolha o Mês para a lista de Aniversariantes';
		$relCamposFiltro['Rel.Mes']['tit'] 				= 'Mês';
		$relCamposFiltro['Rel.Mes']['input']['options'] = $meses;
		$relCamposFiltro['Rel.Mes']['input']['default'] = date('m');

		// jogando tudo na view
		$this->set(compact('relFiltroTitulo','relCamposFiltro','relCampos','relTitulos','colunas','title_for_layout'));

		// continua o processamento com action pai
		parent::relatorio();
	}

	/**
	 * Imprime etiquetas para o cadastro de contatos
	 * 
	 * @return	void
	 */
	public function etiquetas()
	{
		$title_for_layout	= 'Etiquetas';
		$this->set(compact('title_for_layout'));
		parent::relatorio();
	}

	/**
	 * Exibe a tela de pesquisa de contatos
	 * 
	 * @return	void
	 */
	public function buscar()
	{
		$this->layout = 'pesquisar';
		$title_for_layout	= 'Pesquisa';
		if (isset($this->data['Form']['pesquisar']) && !empty($this->data['Form']['pesquisar']))
		{
			//if (isset($this->data['btEnviar'])) unset($this->data['btEnviar']);
			$opcoes['conditions']['OR']['Contato.nome like'] = '%'.$this->data['Form']['pesquisar'].'%';
			$opcoes['conditions']['OR']['Contato.tel1 like'] = '%'.$this->data['Form']['pesquisar'].'%';
			$opcoes['conditions']['OR']['Contato.tel2 like'] = '%'.$this->data['Form']['pesquisar'].'%';
			$opcoes['conditions']['OR']['Contato.tel3 like'] = '%'.$this->data['Form']['pesquisar'].'%';
			$opcoes['conditions']['OR']['Contato.email like'] = '%'.$this->data['Form']['pesquisar'].'%';
			$opcoes['conditions']['OR']['Contato.cpf like'] = '%'.$this->data['Form']['pesquisar'].'%';
			$opcoes['limit']	= '1000';
			$this->data = $this->Contato->find('all',$opcoes);
		} else
		{
			$this->data = array();
		}
		$this->set(compact('title_for_layout'));
	}
}
