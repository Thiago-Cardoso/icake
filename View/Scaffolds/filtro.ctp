<?php
	$arq = APP.'View'.DS.$this->name.DS.'campos.ctp';
	if (!empty($this->plugin)) $arq = APP.'Plugin'.DS.$this->plugin.DS.'View'.DS.$this->name.DS.'campos.ctp';
	if (file_exists($arq)) require_once($arq);
?>

<style>
	.divRegistro
	{
		display: block;
		clear: both;
	}
	select
	{
		width: 120px;
	}
	#aniversariantes
	{
		width: 500px;
		margin: 40px auto;
	}
	label
	{
		display: block;
		float: left;
		min-width: 100px;
		text-align: right;
		margin: 0px 5px 0px 0px;
		line-height: 30px;
	}
	#campos
	{
		width: 250px;
		margin: 0px auto;
	}
	#botoess
	{
		text-align: center;
		margin: 10px 0px 10px 0px;
	}
	#btEnviar
	{ !!!
		width: 150px;
	}
</style>
<div id='aniversariantes' class='quadro'>
	<?php if (isset($relFiltroTitulo)) : ?>
	<center><h4><?= $relFiltroTitulo ?></h4></center>
	<?php endif ?>
	
	<form name='formAniver' method='post' action=''>
	<input type='hidden' value='default' name='data[Rel][Layout]' id='RelLayout' />

	<div id='campos'>

	<?php if (isset($relCamposFiltro)) : ?>
		<?php foreach($relCamposFiltro as $_campo => $_arrProp) : ?>
		
			<?php $_arrProp['tit'] 				= isset($_arrProp['tit'])	? $_arrProp['tit']		: $_campo ?>
			<?php $_arrProp['input'] 			= isset($_arrProp['input']) ? $_arrProp['input'] 	: array() ?>
			<?php $_arrProp['input']['format'] 	= array('input'); ?>
			<?php $_arrProp['input']['div'] 	= null; ?>

			<label id='label<?= str_replace('.','',$_campo) ?>' for='<?= str_replace('.','',$_campo) ?>'><?= $_arrProp['tit'] ?></label>
			<?php echo $this->Form->input($_campo, $_arrProp['input']); ?>

		<?php endforeach ?>

	<?php else : ?>

		<center><h4>Escoha a saída do relatório</h4></center>

	<?php endif ?>

	</div>

	<?php echo $this->element('botoes_saida'); ?>

	</form>

	<div id='obs'>
		<?php if (isset($relCamposFiltro)) : ?>
		<p>* Campos obrigatórios.</p>
		<?php endif ?>
	</div>

</div>
