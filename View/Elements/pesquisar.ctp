<?php if (isset($camposPesquisa) && !empty($camposPesquisa)) : ?>

<div id='pesquisa'>
	
	<label>Pesquisar</label>

	<select name='slPesquisa' id='slPesquisa'>
		<?php foreach($camposPesquisa as $_campo) : $arrCmp = explode('.',$_campo) ?>
		<?php //if (isset($schema[$arrCmp['0']][$arrCmp['1']]['key']) && $arrCmp['1']!='id') : ?>
		<option value='<?= $arrCmp['1'] ?>'><?= ucfirst($arrCmp['1']) ?></option>
		<?php //endif ?>
		<?php endforeach ?>
	</select>

	<input type='text' name='edPesquisa' id='edPesquisa' autofocus />

	<div id="rePesquisa"></div>
	<?php 
		$this->viewVars['onRead'] .= '$("#edPesquisa").keyup(function(e){ setPesquisa("'.Router::url('/',true);
		if (!empty($this->request->params['plugin'])) $this->viewVars['onRead'] .= $this->request->params['plugin'].'/';
		$this->viewVars['onRead'] .= strtolower($this->name).'/pesquisar/'.'",(e.keyCode ? e.keyCode : e.which)); })'."\n";
	?>

</div>

<?php endif ?>
