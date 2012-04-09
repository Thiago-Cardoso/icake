<?php
	if (!isset($listaCampos)) exit('Os Campos da lista não foram definidos !!!<br />Você deve criar o array $listaCampos = array("Model.campo1","Model.campo2"), dentro do arquivo listar.ctp ou então dentro da action listar do seu controlador.<br />Veja os exemplo dentro de '.APP . 'View');
	echo $this->Html->css(Router::url('/',true).'css/listar.css', null, array('inline' => false));
	$url = Router::url('/',true);
	if (!empty($this->request->params['plugin'])) $url .= $this->request->params['plugin'].'/';
	$url .= strtolower($this->name).'/';

	$camposPesquisa = isset($camposPesquisa) ? $camposPesquisa : array();
	
	if (!isset($botoes))
	{
		if (!in_array('G',$this->Session->read('Usuario.Restricoes')) && !isset($botoes['0']))
		{
			$botoes['0']['value'] 	= 'Novo';
			$botoes['0']['class'] 	= 'botao';
			$botoes['0']['onclick']= "document.location.href='".$url.'novo'."'";
		}
	}

	// botões de ferramentas
	if (!isset($botoesFerramentasOff))
	{
		//if (!isset($ferramentas['0']) && !in_array('G',$this->Session->read('Usuario.Restricoes')))
		if (!isset($ferramentas['0']))
		{
			$ferramentas['0']['link'] 	= $url.'editar/{id}';
			$ferramentas['0']['img'] 	= 'bt_editar.png';
			$ferramentas['0']['title']	= 'Clique aqui para editar ...';
		}
		if (!isset($ferramentas['1']) &&!in_array('I',$this->Session->read('Usuario.Restricoes')))
		{
			$ferramentas['1']['link'] 	= $url.'imprimir/{id}';
			$ferramentas['1']['img'] 	= 'bt_imprimir.png';
			$ferramentas['1']['title']	= 'Clique aqui para imprimir ...';
		}
		if (!isset($ferramentas['2']) &&!in_array('G',$this->Session->read('Usuario.Restricoes')))
		{
			$ferramentas['2']['link'] 	= $url.'excluir/{id}';
			$ferramentas['2']['img'] 	= 'bt_excluir.png';
			$ferramentas['2']['title']	= 'Clique aqui para excluir ...';
		}
	}
	if (isset($ferramentas)) asort($ferramentas);
?>
<div id='lista'>

<div id='barra'>
	<?php if (!isset($paginacao_off)) : ?>
	<!-- paginação -->
	<div id='paginacao'>
		<ul>
			<li><a href='<?= $url ?>listar/pagina:1/ordem:<?= $paginacao['sort'] ?>/direcao:<?= $paginacao['direction'] ?>' title='primeira página'> << </a></li>
			<li><a href='<?= $url ?>listar/pagina:<?= $paginacao['prevPage']  ?>/ordem:<?= $paginacao['sort'] ?>/direcao:<?= $paginacao['direction'] ?>'> < </a></li>
			<li><a href='<?= $url ?>listar/pagina:<?= $paginacao['nextPage']  ?>/ordem:<?= $paginacao['sort'] ?>/direcao:<?= $paginacao['direction'] ?>'> > </a></li>
			<li><a href='<?= $url ?>listar/pagina:<?= $paginacao['pageCount'] ?>/ordem:<?= $paginacao['sort'] ?>/direcao:<?= $paginacao['direction'] ?>'> >> </a></li>
		</ul>
	</div>
	<?php endif ?>

	<!-- botões -->
	<?php if (isset($botoes)) echo $this->element('botoes',array('botoes'=>$botoes)); ?>

	<!-- mensagens -->
	<?php if (isset($listaMsg)) echo '<div id="listaMsg">'.$listaMsg.'</div>'; ?>

	<!-- pesquisa -->
	<div id='pesquisa'>
	<?php echo $this->element('pesquisar',array('camposPesquisa'=>$camposPesquisa)); ?>
	</div>

</div>

<table cellspacing='0px' cellpadding='0px' border='0' class='tableLista'>

<?php foreach($this->data as $_linha => $_arrModel) : $id = isset($_arrModel[$modelClass]['id']) ? $_arrModel[$modelClass]['id'] : $_linha; ?>

<?php if ($_linha==0) : ?>
<!-- CABEÇALHO -->
<tr>
	<?php foreach($listaCampos as $_campo) 
	{
		$arrCmp = explode('.',$_campo);
		// criando configuração para os campos modified e created
		if (in_array($arrCmp['1'],array('modified','created')))
		{
			$campos[$arrCmp['0']][$arrCmp['1']]['mascara']	= '99/99/9999 99:99:99';
			if ($arrCmp['1']=='created') $campos[$arrCmp['0']][$arrCmp['1']]['tit'] = 'Criado';
			if ($arrCmp['1']=='modified')$campos[$arrCmp['0']][$arrCmp['1']]['tit'] = 'Modificado';
		}

		// jogando numa variável pra ficar mais fácil
		$cmp = (isset($campos[$arrCmp['0']][$arrCmp['1']])) ? $campos[$arrCmp['0']][$arrCmp['1']] : array();

		// definindo o título do campo
		$tit = isset($cmp['tit']) ? $cmp['tit'] : $arrCmp['1'];
		echo "<th id='th_".strtolower(str_replace('.','_',$_campo))."' class='th_".strtolower($arrCmp['1'])."' ";
		if (isset($cmp['th'])) foreach($cmp['th'] as $_tag => $_valor) echo " $_tag='$_valor' "; 
		// só pode indexar quem tem index
		if (!isset($schema[$arrCmp['0']][$arrCmp['1']]['key']))
		{
			echo '>'.$tit.'</th>'."\n";
		} else
		{
			echo '><a href="'.$url.'listar/pagina:'.$paginacao['page'].'/ordem:'.$arrCmp['1'].'/direcao:'.(($paginacao['direction']=='asc')?'desc':'asc').'">'.$tit.'</a></th>'."\n";
		}
	}
	?>
	<?php if (isset($ferramentas) && count($ferramentas)) : ?>
	<th colspan='<?= count($ferramentas) ?>'>#</th>
	<?php endif ?>
</tr>
<?php endif ?>

<!-- LINHA -->
<tr class='listaTr' id='listaTr_<?=$id?>'<?php if (isset($lista['tr_'.$id])) foreach($lista['tr_'.$id] as $_tag => $_valor) echo " $_tag='$_valor' "; ?>>

<!-- CAMPO A CAMPO -->
<?php foreach($listaCampos as $_campo) : $arrCmp = explode('.',$_campo) ?>
<td id='td_<?= strtolower(str_replace('.','_',$_campo)).'_'.$id ?>' class='td_<?= strtolower(strtolower($arrCmp['1'])) ?>'
<?php
	$cmp = (isset($campos[$arrCmp['0']][$arrCmp['1']])) ? $campos[$arrCmp['0']][$arrCmp['1']] : array();
	if (isset($cmp['td'])) foreach($cmp['td'] as $_tag => $_valor) echo " $_tag='$_valor' ";

	// propriedades
	$valor	= $_arrModel[$arrCmp['0']][$arrCmp['1']];
	$mascara= isset($cmp['mascara']) 			? $cmp['mascara'] 			: '';
	$opcoes	= isset($cmp['input']['options']) 	? $cmp['input']['options'] 	: array();

	// valor máscarado
	$valor	= $this->Pagina->getMascara($valor,$mascara,$opcoes);
?>
><?= $valor ?></td>

<?php endforeach ?>

<!-- FERRAMENTAS -->
<?php if (isset($ferramentas)) : ?>
<?php foreach($ferramentas as $_item => $_arrProp) :  ?>
<?php if (!isset($off[$_item][$id]) ) : ?>
<?php if (isset($_arrProp['link']) && isset($_arrProp['img'])) : ?>
<td>
	<a href='<?= str_replace('{id}',$id,$_arrProp['link']) ?>' <?= (isset($_arrProp['title'])?'title="'.$_arrProp['title'].'"':null) ?> >
	<?php if (!strpos($_arrProp['img'],'ttp://')) : ?>
	<img src='<?= Router::url('/',true).'img/'.$_arrProp['img'] ?>' border='0px' />
	<?php else : ?>
	<img src='<?= $_arrProp['img'] ?>' border='0px' />
	<?php endif ?>
	</a>
</td>
<?php endif ?>
<? else : ?>
<td align='center'><img src='<?= Router::url('/',true).'img/bt_excluir_off.png' ?>' border='0px' /></td>
<?php endif ?>
<?php endforeach ?>
<?php endif ?>

</tr>

<?php endforeach ?>

</table>

<!-- RODAPÉ DA LISTA -->
<div id='tableRodape'>
	Total: <?= number_format($paginacao['count'],0,',','.') ?> - Página: <?= $paginacao['page'] ?> de <?= $paginacao['pageCount'] ?>
</div>

</div>

<?php 
// debug
//debug($ferramentas);
//debug($listaCampos);
//debug($schema);
//echo '<br /><br /><br /><br /><br /><br />';
//debug($this->Session->read('Usuario'));
//debug($this->viewVars['paginacao']);
//debug($camposPesquisa);
?>

