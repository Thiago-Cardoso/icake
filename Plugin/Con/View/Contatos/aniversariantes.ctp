<style>
	.divRegistro
	{
		display: block;
		clear: both;
	}
	select
	{
		width: 70px;
		text-align: center;
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
		width: 200px;
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
	
	<form name='formAniver' method='post' action='<?= $this->here ?>/../rel_aniversariantes'>
	<div id='campos'>
		
		<div id='divMes' class='divRegistro'>
		<label class='labelMes'> * Mês :</label>
		<select name='data[Ani][Mes]' id='AniMes' >
			<?php for($i=1; $i<13; $i++) : ?>
			<?php $s = ($i==date('m')) ? 'selected="selected"' : ''; ?>
			<option value="<?=$i?>" <?=$s?> > <?= $i ?></option>
			<?php endfor ?>
		</select>
		</div>
		
	</div>

	<div id='botoess'>
		<input type='submit' name='btEnviar' id='btEnviar' value='Enviar' />
	</div>
	</form>

	<div id='obs'>
		<p>* Campos obrigatórios.</p>
	</div>

</div>
