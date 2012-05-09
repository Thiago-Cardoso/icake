<?php
	echo $this->Html->css(Router::url('/',true).'css/editar.css', null, array('inline' => false));
	$url 	= Router::url('/',true);
	if (!empty($this->request->params['plugin'])) $url .= $this->request->params['plugin'].'/';
	$url .= strtolower($this->name).'/';
	$tipo 	= isset($tipo) ? $tipo : 'edicao';
	$divisor= isset($divisor) ? $divisor : ':';
	$id		= isset($id) ? $id : 0;
	if (!isset($edicaoCampos)) die('Você não definiu quais campos serão editados ...<br />
		Você deve criar o array $edicaoCampos = array("Model.campo1","Model.campo2"), dentro do arquivo editar.ctp<br />
		Ou dentro da action editar do seu controlador.<br />
		Veja os exemplo dentro de '. APP . 'View');
	
	// botões de ferramentas
	if (!isset($botoesOff))
	{
		if (!in_array('G',$this->Session->read('Usuario.Restricoes')) && in_array($this->action,array('editar','novo')))
		{
			if ($this->action=='editar' && !isset($botoes['0']))
			{
				$botoes['0']['value'] 	= 'Novo';
				$botoes['0']['class'] 	= 'botao';
				$botoes['0']['onclick']= "document.location.href='".$url.'novo'."'";
			}

			if (!isset($botoes['1']))
			{
				$botoes['1']['value'] 	= 'Salvar';
				$botoes['1']['class'] 	= 'botao';
				$botoes['1']['onclick']= "javascript:edicaoForm.submit();";
			}
			
			if ($this->action=='editar' && !isset($botoes['2']))
			{
				$botoes['2']['value'] 	= 'Excluir';
				$botoes['2']['class'] 	= 'botao';
				$botoes['2']['onclick']= "document.location.href='".$url.'excluir/'.$id."'";
			}
		}
		
		if ($this->action=='editar')
		{
			if (!isset($botoes['3']))
			{
				$botoes['3']['value'] 	= 'Atualizar';
				$botoes['3']['class'] 	= 'botao';
				$botoes['3']['onclick']= "document.location.href='".$url.'editar/'.$id."'";
			}

			if (!in_array('I',$this->Session->read('Usuario.Restricoes')) && $this->action != 'imprimir')
			{
				if (!isset($botoes['4']))
				{
					$botoes['4']['value'] 	= 'Imprimir';
					$botoes['4']['class'] 	= 'botao';
					$botoes['4']['onclick']= "document.location.href='".$url.'imprimir/'.$id."'";
				}
			}
		}
		if (!isset($botoes['15']))
		{
			$botoes['15']['value'] 	= 'Fechar';
			$botoes['15']['class'] 	= 'botao';
			$botoes['15']['onclick']= "document.location.href='".$url."listar'";
		}
	}
	
?>

<div id='editar'>

	<!-- botões -->
	<div id='barra'>

		<?php if ($tipo=='excluir') : ?>
		<!-- mensagem para o caso de exclusão -->
		<h2>Você tem certeza que deseja excluir este registro ?</h2>
		<div id='erroSimNao'>
		<a href='<?= str_replace('/excluir/','/delete/',$this->here) ?>'>Sim</a> | <a href='javascript:history.go(-1)'>Não</a>
		</div>
		<?php endif ?>

		<?php if (isset($primeiro) && !isset($paginacao_off)) : ?>
		<!-- paginação -->
		<div id='paginacao'>
			<ul>
				<li><a href='<?= $url .'editar/'.$primeiro ?>' title='primeira registro'> << </a></li>
				<li><a href='<?= $url .'editar/'.$anterior ?>' title='registro anterior'> < </a></li>
				<li><a href='<?= $url .'editar/'.$proximo  ?>' title='próxima página'> > </a></li>
				<li><a href='<?= $url .'editar/'.$ultimo ?>'> >> </a></li>
			</ul>
		</div>
		<?php endif ?>

		<?php if (isset($botoes)) echo $this->element('botoes',array('botoes'=>$botoes)); ?>

		<?php if (in_array($this->action,array('editar')) && isset($camposPesquisa) && count($camposPesquisa) && !isset($paginacao_off)) echo $this->element('pesquisar',array('camposPesquisa'=>$camposPesquisa)); ?>

	</div><!-- FIM BARRA -->
	
	<?php if (isset($edicao_erros) && count($edicao_erros)) : ?>
	<div id='edicaoErros'>
		<ul>
			<?php foreach($edicao_erros as $_campo => $_arrErros) : ?>
				<?php foreach($_arrErros as $_num => $_erro) : ?>
					<li><?= $_erro ?></li>
				<?php endforeach ?>
			<?php endforeach ?>
		</ul>
	</div>
	<?php endif ?>

	<div id='edicaoCampos'>
	<form name='edicaoForm' action='<?= $url.'salvar' ?>' method='post' <?php if (isset($form_onsubmit)) echo 'onsubmit=return '.$form_onsubmit.'();' ?> >
	<input type='hidden' value='<?= $tipo ?>' name='tipo' id='tipo' />
	<?php echo $this->Form->input($modelClass.'.id',array('type'=>'hidden')); ?>

	<?php foreach($edicaoCampos as $_campo) : ?>

	<?php
		$arrCmp = explode('.',$_campo);

		// encurtando pra ficar mais rápido
		$cmp = isset($campos[$arrCmp['0']][$arrCmp['1']]) ? $campos[$arrCmp['0']][$arrCmp['1']] : array();

		// jogando o valor do campo numa variável só pra ficar mais fácil
		$valor = isset($this->data[$arrCmp['0']][$arrCmp['1']]) ? $this->data[$arrCmp['0']][$arrCmp['1']] : "";

		// se pediu focus, então foca o danado.
		if (isset($cmp['focus'])) $this->viewVars['onRead'] .= '$("#'.$this->Form->domId($_campo).'").focus();'."\n";

		// limpando campos data, hora e zero
		if (is_string($valor) && (in_array($valor,array('0000-00-00','0','00:00:00'))))
		{
			$this->request->data[$arrCmp['0']][$arrCmp['1']] = '';
			$valor = '';
		}

		// criando configuração para os campos modified e created
		if (in_array($arrCmp['1'],array('modified','created')))
		{
			$cmp['input']['readonly']	= 'readonly';
			$cmp['input']['type']		= 'leitura';
			$cmp['mascara']				= '99/99/9999 99:99:99';
			if ($arrCmp['1']=='created') $cmp['tit'] = 'Criado';
			if ($arrCmp['1']=='modified')$cmp['tit'] = 'Modificado';
		}

		// propriedades de cada campo
		$cmp['input'] 			= isset($cmp['input']) 			? $cmp['input'] 		: array();
		$cmp['input']['format'] = array('input');
		$cmp['input']['div'] 	= null;

		// campos textarea
		if (isset($schema[$arrCmp['0']][$arrCmp['1']]) && $schema[$arrCmp['0']][$arrCmp['1']]['type']=='text')
		{
			$cmp['input']['type'] = 'textarea';
		}

		// definindo o tipo input do campo
		$cmp['input']['type'] 	= isset($cmp['input']['type']) 	? $cmp['input']['type'] : 'text';
		if ($arrCmp['1']=='id') $cmp['input']['type'] = 'hidden';
		if (in_array($tipo,array('exclusao','impressao'))) $cmp['input']['type'] = 'hidden';
		if (isset($cmp['input']['options']) && count($cmp['input']['options'])==2)
		{
			if (!$valor) $valor = '0';
			$cmp['input']['type'] = 'radio';
			$cmp['input']['legend'] = false;
			$cmp['input']['label'] = false;
		}

		// se tem máscara, então mascara a bitela com jquery
		if (isset($cmp['mascara']))
		{
			$this->viewVars['onRead'] .= '$("#'.$this->Form->domId($_campo).'").mask("'.$cmp['mascara'].'");'."\n";
			$opcoes= isset($cmp['input']['option']) ? $cmp['input']['option'] : array();
			$valor = $this->Pagina->getMascara($valor,$cmp['mascara'],$opcoes);
			if (isset($this->data[$arrCmp['0']][$arrCmp['1']])) $this->request->data[$arrCmp['0']][$arrCmp['1']] = $valor;
		}

		// recuperando opções de campos relacionados
		if (strpos($arrCmp['1'],'_id'))
		{
			$assArrCmp = explode('_',$arrCmp['1']);
			if (isset($this->viewVars['opcoes_'.$assArrCmp['0']]))
			{
				if ($cmp['input']['type'] != 'leitura') $cmp['input']['type'] = 'select';
				$cmp['input']['options'] = $this->viewVars['opcoes_'.$assArrCmp['0']];
			}
		}
		if (isset($this->viewVars['opcoes_'.strtolower($arrCmp['0'])])) // nesta caso para N::N
		{
			if ($cmp['input']['type'] != 'leitura') $cmp['input']['type'] = 'select';
			$cmp['input']['options'] = $this->viewVars['opcoes_'.strtolower($arrCmp['0'])];
			if ($arrCmp['0']==$arrCmp['1']) $cmp['input']['multiple'] = 'multiple';
		}

		// se possui combo
		if (isset($cmp['combo']))
		{
			$actionCombo = 'combo';
			$this->viewVars['onRead'] .= '$("#'.$this->Form->domId($_campo).'").change(function() { setCombo("'.
				$this->Form->domId($cmp['combo']['0']).'","'.Router::url('/',true).$cmp['combo']['1'].'/'.$actionCombo.'/'.$arrCmp['1'].'/",$(this).val()); })'."\n";
		}
	?>

	<!-- CAMPO -->
	<div id='div_<?= strtolower(str_replace('.','_',$_campo)) ?>' class='divCampo'
		<?php if (isset($cmp['div'])) foreach($cmp['div'] as $_tag => $_valor) echo " $_tag='$_valor' "; ?>
	>

		<?php if ($cmp['input']['type'] != 'hidden') : // CAMPOS LEITURA NÃO TEM label ?>
		<label class='labelEdicao' id='id_<?= strtolower(str_replace('.','_',$_campo)) ?>' 
			<?php if (isset($cmp['label'])) foreach($cmp['label'] as $_tag => $_valor) echo " $_tag='$_valor' "; ?>
		><?=(isset($cmp['tit']) ? $cmp['tit'] : $arrCmp['1']);?>
		</label><div class='divisor' style="float: left; padding-right: 3px;"><?= $divisor ?></div>
		<?php endif ?>

		<?php

		// escrevendo o input
		if ($cmp['input']['type']!='leitura' && !in_array($this->action,array('imprimir','excluir'))) 
		{
			if ($arrCmp['1']!='id') echo $this->Form->input($_campo,$cmp['input'],(isset($atributos)?$atributos:null)); 
//			if ($arrCmp['1']=='descricao') debug($cmp['input']);
		}else // SE É SOMENTE LEITURA
		{
			if ($arrCmp['1']!='id')
			{
				// se tem valor padrão e não tem nada cadastrado e se trata de uma inclusão
				if (isset($cmp['input']['default']) && !isset($this->data[$arrCmp['0']][$arrCmp['0']]) && $this->action=='novo')
				{
					$valor = $cmp['input']['default'];
				}
				
				// se o campo é selectBox, pega a segunda opção
				if (!is_array($valor) && isset($cmp['input']['options'][$valor])) $valor = $cmp['input']['options'][$valor];

				// se é um campo N:N, pega o último campo.
				if ($arrCmp['0']==$arrCmp['1'] && isset($this->data[$arrCmp['0']]))
				{
					foreach($this->data[$arrCmp['0']] as $_linha => $_arrCampos)
					{
						$l = 0;
						$t = count($_arrCampos);
						foreach($_arrCampos as $_campo => $_valor)
						{
							$l++;
							if ($l==$t) $valor .= $_valor.', ';
						}
					}
					$valor = substr($valor,0,strlen($valor)-2);
				}

				// escrevendo o valor
				echo '<span class="spanLeitura" id="span_'.$arrCmp['1'].'">' .$valor.'</span>';
				
				// criando o campo oculto, se diferente de modified e created
				if (!in_array($arrCmp['1'],array('modified','created')))
				{
					$cmp['input']['type'] = 'hidden';
					echo $this->Form->input($_campo,$cmp['input']);
				}
			}
		}
		?>

	</div>

	<?php endforeach ?>

<?php 
	if (isset($subFormHBTM))
	{
		echo $this->Html->css(Router::url('/',true).'css/sub_form_hbtm.css', null, array('inline' => false));
		echo '<div id="subFormHBTM">';
		foreach($subFormHBTM as $_nome => $_arrProp)
		{
			$_arrProp['action'] 		= isset($_arrProp['action']) ? $_arrProp['action'] : $this->action;
			$_arrProp['campos'] 		= isset($_arrProp['campos']) ? $_arrProp['campos'] : array();
			$_arrProp['campos_edicao'] 	= isset($_arrProp['campos_edicao']) ? $_arrProp['campos_edicao'] : array($_nome.'.id');

			// atualizando as propriedades dos campos de edição
			foreach($_arrProp['campos_edicao'] as $_campo)
			{
				$a	= explode('.',$_campo);
				$c	= isset($_arrProp['campos'][$a['0']][$a['1']]) ? $_arrProp['campos'][$a['0']][$a['1']] : array();
				if ($a['1']=='id' && isset($this->viewVars['opcoes_'.strtolower($a['0'])]))
				{
					$_arrProp['campos'][$a['0']][$a['1']]['tit'] = isset($_arrProp['campos'][$a['0']][$a['1']]['tit']) ? $_arrProp['campos'][$a['0']][$a['1']]['tit'] : $a['0'];
					$_arrProp['campos'][$a['0']][$a['1']]['input']['options'] = $this->viewVars['opcoes_'.strtolower($a['0'])];
				}
				// aproveitando a xepa, pra definir os campos data
				$_arrProp['data'] =  isset($this->data[$a['0']]) ? $this->data[$a['0']] : array();
			}
			//debug($_arrProp['data']);
			echo $this->Pagina->getHbtmForm($_nome,$_arrProp, $url.$this->action.'/'.$id.'/');
		}
		echo '</div>'."\n";
	}
?>

	</form>
</div><!-- FIM EDICAO CAMOS -->


<?php if (isset($subFormId)) : ?>
<div id='subForm'>
<?php
	$subForm = '<div class="subFormTitulo">'.$subFormTitulo.'</div>';
	$subForm .= '<table border="0" cellpadding="0" cellspacing="0">'."\n";

	// escrevendo o formulário
	if (isset($subFormCampos))
	{
		if (!in_array($this->action,array('imprimir','excluir')))
		{
			$subFormAction = isset($subFormAction) ? $subFormAction : '';
			$subForm .= '<form name="subFormEditar" action="'.$subFormAction.'" method="post" >';
			$subForm .= $this->Form->input($subFormId,array('type'=>'hidden'));
			$subForm .= '<tr>'."\n";
			foreach($subFormCampos as $_campo) // campo a campo
			{
				$arrCmp = explode('.',$_campo);
				$cmp 			= isset($campos[$arrCmp['0']][$arrCmp['1']]) ? $campos[$arrCmp['0']][$arrCmp['1']] : array();
				$cmp['input']	= isset($campos[$arrCmp['0']][$arrCmp['1']]['input']) ? $campos[$arrCmp['0']][$arrCmp['1']]['input'] : array();
				$cmp['input']['type']	= isset($campos[$arrCmp['0']][$arrCmp['1']]['input']['type']) ? $campos[$arrCmp['0']][$arrCmp['1']]['input']['type'] : 'text';
				$cmp['input']['format'] = array('input');
				$cmp['input']['div'] 	= null;

				// se possui combo
				if (isset($cmp['combo']))
				{
					$actionCombo = 'disponiveis';
					$this->viewVars['onRead'] .= '$("#'.$this->Form->domId($_campo).'").change(function() { setCombo("'.
						$this->Form->domId($cmp['combo']['0']).'","'.$url.'../'.$cmp['combo']['1'].'/'.$actionCombo.'/'.$arrCmp['1'].'/",$(this).val()); })'."\n";
				}

				// se tem opções é tipo select
				if (strpos($arrCmp['1'],'_id'))
				{
					$assArrCmp = explode('_',$arrCmp['1']);
					if (isset($this->viewVars['opcoes_'.$assArrCmp['0']])) $cmp['input']['options'] = $this->viewVars['opcoes_'.$assArrCmp['0']];
				}
				if (isset($cmp['input']['options'])) $cmp['input']['type'] = 'select';

				$subForm .= '<td';
				if (isset($cmp['td'])) foreach($cmp['td'] as $_tag => $_valor) $subForm .= " $_tag='$_valor' ";
				$subForm .= '>'.$this->Form->input($_campo,$cmp['input']).'</td>';
			}
			if (isset($subFormFerramentas) && !in_array($this->action,array('imprimir','excluir'))) // ferramentas
			{
				$subForm .= '<td colspan="'.count($subFormFerramentas).'">'.$this->Form->button('',array('class'=>'btSalvarSF','type'=>'submit')).'</td>'."\n";
			}
		}
		$subForm .= '</form>';
		$subForm .= '</tr>'."\n";
	}

	if (isset($subFormData))
	{
		foreach($subFormData as $_linha => $_arrModels)
		{
			// cabeçalho
			if ($_linha==0)
			{
				$subForm .= '<tr>'."\n";
				foreach($subFormListaCampos as $_campo) // campo a campo
				{
					$arrCmp = explode('.',$_campo);
					$cmp 	= isset($campos[$arrCmp['0']][$arrCmp['1']]) ? $campos[$arrCmp['0']][$arrCmp['1']] : array();

					// propriedades do campo
					$tit	= isset($cmp['tit']) ? $cmp['tit'] : $arrCmp['1'];

					// escrevendo o cabeçalho
					$subForm .= '<th';
					if (isset($cmp['th'])) foreach($cmp['th'] as $_tag => $_valor) $subForm .= " $_tag='$_valor' ";
					$subForm .= '>'.$tit.'</th>'."\n";
				}
				if (isset($subFormFerramentas) && !in_array($this->action,array('imprimir','excluir'))) // ferramentas
				{
					$subForm .= '<th colspan="'.count($subFormFerramentas).'">#</th>'."\n";
				}
				$subForm .= '</tr>'."\n";
			}
			
			// linha a linha
			$subForm .= '<tr>'."\n";
			foreach($subFormListaCampos as $_campo)
			{
				$arrCmp = explode('.',$_campo);
				$cmp 	= isset($campos[$arrCmp['0']][$arrCmp['1']]) ? $campos[$arrCmp['0']][$arrCmp['1']] : array();

				// propriedades
				$valor	= $_arrModels[$arrCmp['0']][$arrCmp['1']];
				$mascara= isset($campos[$arrCmp['0']][$arrCmp['1']]['mascara']) ? $campos[$arrCmp['0']][$arrCmp['1']]['mascara'] : '';
				$opcoes	= isset($campos[$arrCmp['0']][$arrCmp['1']]['input']['options']) ? $campos[$arrCmp['0']][$arrCmp['1']]['input']['options'] : array();

				// valor máscarado
				$valor	= $this->Pagina->getMascara($valor,$mascara,$opcoes);

				// escrevendo a célula
				$subForm .= "\t".'<td';
				if (isset($cmp['td'])) foreach($cmp['td'] as $_tag => $_valor) $subForm .= " $_tag='$_valor' ";
				$subForm .= '>'.$valor.'</td>'."\n";
			}
			if (isset($subFormFerramentas)  && !in_array($this->action,array('imprimir','excluir')) )
			{
				foreach($subFormFerramentas as $_linha => $_arrProp)
				{
					$_arrProp['link'] 	= isset($_arrProp['link'])  ? $_arrProp['link']  : '#';
					$_arrProp['click']	= isset($_arrProp['click']) ? $_arrProp['click'] : '';
					$subForm .= "\t".'<td><a href="'.$_arrProp['link'].'"';
					if (!empty($_arrProp['click']))
					{
						$arrCmpS = explode('.',$subFormId);
						$idS	 = $_arrModels[$arrCmpS['0']][$arrCmpS['1']];
						$_arrProp['click'] = str_replace('{id}',$idS,$_arrProp['click']);
						$subForm .= ' onclick="document.location.href=\''.$_arrProp['click'].'\'" ';
					}
					$subForm .= '><img src="'.Router::url('/',true).'img/'.$_arrProp['img'].'" border="0"/></a></td>'."\n";
				}
			}
			$subForm .= '</tr>'."\n";
		}
	}
$subForm .= '</table>'."\n";
echo $subForm;
?>

</div><!-- FIM SUBFORM -->
<?php endif ?>


</div>

<?php
//debug($this->data);
//debug($camposEdicao);
//debug($this->viewVars['schema']);
//debug($campos);
//debug($this->viewVars);
//debug($vizinhos);
//debug($campos);
//debug($camposPesquisa);
//debug($url);
debug($this->Session->read('Usuario.Restricoes'));
?>
