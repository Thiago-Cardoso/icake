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
	{
		width: 150px;
	}
</style>
<div id='aniversariantes' class='quadro'>
	<center><h3>Escolha o mês e o Ano para a lista de Aniversariantes</h3></center>
	
	<form name='formAniver' method='post' action='' >
	<input type='hidden' value='default' name='data[Rel][Layout]' id='RelLayout' />

	<div id='campos'>
		
		<div id='divMes' class='divRegistro'>
		<label class='labelMes'> * Mês :</label>
		<select name='data[Rel][Mes]' id='RelMes' >
			<?php foreach($meses as $_item => $_valor) : ?>
			<?php $s = ($_item==date('m')) ? 'selected="selected"' : ''; ?>
			<option value="<?=$_item?>" <?=$s?> > <?= $_valor ?></option>
			<?php endforeach ?>
		</select>
		</div>
		
	</div>

	<div id='botoess'>
		<input type='button' name='btPdf' 	id='btPdf' 	value='Pdf' 	class='botao' />
		<input type='button' name='btTela' 	id='btTel'	value='Tela' 	class='botao' />
		<input type='button' name='btCsv' 	id='btCsv'	value='Csv'		class='botao' />
	</div>
	<?php $this->viewVars['onRead'] .= '$("#btPdf").click(function() { $("#RelLayout").val("pdf");	 	$("form").get(0).submit(); }); '."\n"; ?>
	<?php $this->viewVars['onRead'] .= '$("#btTel").click(function() { $("#RelLayout").val("tela"); 	$("form").get(0).submit(); }); '."\n"; ?>
	<?php $this->viewVars['onRead'] .= '$("#btCsv").click(function() { $("#RelLayout").val("csv");  	$("form").get(0).submit(); }); '."\n"; ?>

	</form>

	<div id='obs'>
		<p>* Campos obrigatórios.</p>
	</div>

</div>
