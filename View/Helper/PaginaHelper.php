<?php
/**
 * Ajudante Pagina
 * 
 * Auxilia na renderização da camada de visão, definindo a Posição, configurano o jQuery.
 * 
 * @author		Adriano C. de Moura
 * @package		icake2
 * @subpackage	icake2.view.helper
 */
/**
 * @package		icake2
 * @subpackage	icake2.view.helper 
 */
class PaginaHelper extends AppHelper {
	/**
	 * Ajudantes
	 * 
	 * @var		array
	 * @access	public
	 */
	public $helpers	= array('Session','Form');

	/**
	 * Retorno o valor do campo mascarado
	 * 
	 * @parameter	string		$valor		Valor do campo
	 * @param		string		$mascara	Máscara a ser aplicada no valor
	 * @param		array		$opcoes		Opções para exibição, exemplo: 1=>Sim, 0=>Não
	 * @return		string		$mascarado	Campo mascarado
	 */
	public function getMascara($valor='', $mascara='', $opcoes=array())
	{
		$mascarado = $valor;
		switch($mascara)
		{
			case 'datahora':
			case '00/00/0000 00:00:00':
			case '99/99/9999 99:99:99':
				$mascarado = substr($valor,8,2).'/'.substr($valor,5,2).'/'.substr($valor,0,4).' '.substr($valor,11,8);
				if ($valor=='0000-00-00 00:00:00' || strlen($valor)==0) $mascarado = '';
				break;
			case 'data':
			case '00/00/0000';
			case '99/99/9999'; //9999-99-99
				$mascarado 	= substr($valor,8,2).'/'.substr($valor,5,2).'/'.substr($valor,0,4);
				$hora		= trim(substr($valor,11,10));
				if ($valor=='0000-00-00') $mascarado = '';
				if ($hora!='00:00:00') $mascarado .= ' '.$hora;
				break;
			case 'hora':
			case '99:99:99':
			case '99:99':
				$mascarado = $this->Time->format('H:i:s',strtotime($valor)).'%';
				if ($valor=='00:00:00') $mascarado = '';
				if ($valor=='00:00') $mascarado = '';
				break;
			case '9':
			case '99':
				if ($valor=='0') $mascarado = '';
				break;
			case 'cpf':
			case '999.999.999-99':
				$mascarado = substr($valor,0,3).'.'.substr($valor,3,3).'.'.substr($valor,6,3).'-'.substr($valor,9,2);
				if ($valor=='') $mascarado = '';
				break;
			case 'cnpj':
			case '99.999.999/9999-99':
				$mascarado = substr($valor,0,2).'.'.substr($valor,2,3).'.'.substr($valor,5,3).'/'.substr($valor,8,4).'-'.substr($valor,12,2);
				if ($valor=='0') $mascarado = '';
				break;
			case 'aniversario':
			case '99/99':
				$mascarado = substr($valor,0,2).'/'.substr($valor,2,2);
				break;
			case 'cep':
			case '99.999-999':
				$mascarado = substr($valor,0,2).'.'.substr($valor,2,3).'-'.substr($valor,5,3);
				if ($valor=='') $mascarado = '';
				break;
			case 'telefone':
			case 'celular':
			case '(99)9999-9999':
				$mascarado = '('.substr($valor,0,2).')'.substr($valor,2,4).'-'.substr($valor,6,4);
				if ($valor=='') $mascarado = '';
				break;
			case 'rme':
				$mascarado = substr($valor,0,4).' '.number_format(substr($valor,4,strlen($valor)),0,',','.');
				if ($valor=='') $mascarado = '';
				break;
		}
		if (count($opcoes)>0)
		{
			foreach($opcoes as $_val1 => $_val2)
			{
				if ($valor==$_val1) $mascarado = $_val2;
			}
		}
		return $mascarado;
	}

	/**
	 * Retorna o subFormulário HTBM
	 */
	public function getHbtmForm($nome='',$sb=array(),$url='')
	{
		// variáveis obrigatórias
		$nome			= !empty($nome)				? $nome			: 'desconhecido';
		$sb['name'] 	= isset($sb['name']) 		? $sb['name'] 	 : 'subForm';
		$sb['actionF'] 	= isset($sb['actionF']) 	? $sb['actionF'] : '';
		$sb['action'] 	= isset($sb['action']) 		? $sb['action']  : 'editar';
		$sb['titulo']	= isset($sb['titulo']) 		? $sb['titulo']  : $nome;
		$totF			= isset($sb['ferramentas']) ? count($sb['ferramentas']) : 0;
		$subForm		= '';

		// validando os campos obrigatórios
		if (!isset($sb['campos_edicao'])) return 'Você não definiu os campos para edição para o form hbtm de '.$nome.'<br />'."\n";

		// incluindo formulário de edição
		$subForm .= '<table class="sbTable" id="sbTable'.$nome.'" border="0" cellspacing="0" cellpadding="0">';
		
		// incluindo cabeçalho
		$subForm .= '<tr>';
		foreach($sb['campos_edicao'] as $_campo)
		{
			$a		= explode('.',$_campo);
			$cmp	= isset($sb['campos'][$a['0']][$a['1']]) ? $sb['campos'][$a['0']][$a['1']] : array();
			$tit	= isset($cmp['tit']) ? $cmp['tit'] : $a['1'];

			$subForm .= "\t".'<th';
			if (isset($cmp['th'])) foreach($cmp['th'] as $_tag => $_valor) $subForm .= " $tag='$_valor' ";
			$subForm .= '>'.Inflector::pluralize($tit).'</th>'."\n";
		}
		if (!in_array($sb['action'],array('imprimir','excluir'))) // ferramentas
		{
			$subForm .= "\t".'<th colspan="'.$totF.'">#</td>'."\n";
		}
		$subForm .= '</tr>'."\n";

		// incluindo data
		if (isset($sb['data']))	
		{
			$l = 1;
			foreach($sb['data'] as $_linha => $_arrCampos)
			{
				$subForm .= '<tr id="hbtmTr'.$nome.$l.'">'."\n";

				$hbtmProp['type'] 		= 'hidden';
				$hbtmProp['value']		= $_arrCampos['id'];
				$hbtmProp['format'] 	= array('input');
				$hbtmProp['div'] 		= null;
		
				$subForm .= $this->Form->input($nome.'.'.$nome.'.'.$l,$hbtmProp)."\n";

				$campos_lista = isset($sb['campos_lista']) ? $sb['campos_lista'] : $_arrCampos;
				foreach($campos_lista as $_campo => $_valor)
				{
					$c = isset($sb['campos'][$nome][$_campo])? $sb['campos'][$nome][$_campo] : array();  
					if ($_campo != 'id')
					{
						$subForm .= '<td';
						if (isset($c['td'])) foreach($c['td'] as $_tag => $_valor) $subForm .= " $_tag='$_valor' ";
						$subForm .= '>'.$_valor.'</td>';
					}
				}
				if (!in_array($sb['action'],array('imprimir','excluir')) )
				{
					$subForm .= "\t".'<td>';
					$subForm .= '<a href="javascript:$(\'#hbtmTr'.$nome.$l.'\').remove(); document.edicaoForm.submit();">';
					$subForm .= '<img src="'.Router::url('/',true).'img/bt_excluir" border="0" /></a></td>'."\n";
				}
				$subForm .= '</tr>';
				$l++;
			}
		}
		
		// incluindo select
		if (!in_array($sb['action'],array('imprimir','excluir')) )
		{
			$subForm .= '<tr>';
			foreach($sb['campos_edicao'] as $_campo)
			{
				// quebrando o nome do campo
				$a		= explode('.',$_campo);
				$cmp	= isset($sb['campos'][$a['0']][$a['1']]) ? $sb['campos'][$a['0']][$a['1']] : array();

				// opções padrão
				$cmp['input']['empty'] 	= isset($cmp['input']['empty']) ? $cmp['input']['empty'] : ' -- Escolha um '.$a['0'].' --';
				$cmp['input']['format'] = array('input');
				$cmp['input']['div'] 	= null;

				// definindo o type
				$cmp['input']['type']	= isset($cmp['input']['type']) ? $cmp['input']['type'] : 'text';
				if (isset($cmp['input']['options']) && isset($sb['data'])) // mas sem option, então vira select
				{
					$cmp['input']['type'] = 'select';
					foreach($sb['data'] as $_linha => $_arrCampos) unset($cmp['input']['options'][$_arrCampos['id']]);
				}

				$subForm .= "\t".'<td align="center" ';
				if (isset($cmp['td'])) foreach($cmp['td'] as $_tag => $_valor) $subForm .= " $tag='$_valor' ";
				$subForm .= '>'.$this->Form->input($a['0'].'.'.$a['0'].'.0',$cmp['input']);
				$subForm .= '</td>'."\n";
			}
			if (!in_array($sb['action'],array('imprimir','excluir'))) // ferramentas
			{
				$subForm .= '<td colspan="'.$totF.'">';
				$subForm .= $this->Form->button('*',array('class'=>'btSalvarSF','type'=>'submit'));
				$subForm .= '</td>'."\n";
			}
			$subForm .= '</tr>'."\n";
		}

		$subForm .= '</table>'."\n";

		return $subForm;
	}
}
