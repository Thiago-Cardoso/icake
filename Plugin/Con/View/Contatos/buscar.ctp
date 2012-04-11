<?php ?>
<style>
	#pesquisar
	{
		width: 80%;
		margin: 0px auto;
	}
	a
	{
		text-decoration: none;
		color: #333;
	}
	a:hover
	{
		color: green;
	}
	#resposta
	{
		min-width: 500px;
		max-width: 90%;
		margin: 0px auto;
	}
	h5
	{
		margin: 0px;
		padding: 0px;
	}
	h5,
	#FormPesquisar,
	#btEnviar
	{
		font-size: 20px;
	}
	#resposta
	{
		font-size: 20px;
	}
	#logo
	{
		position: absolute;
		margin: 0px 0px 0px 210px;
	}
</style>
<div id='pesquisar'>
	<div id='logo'><img src='img/buscar.png' /></div>
	<form name='formPesquisar' method='post' action=''>
	<center>
	<h5>Digite um texto para pesquisar em contatos ...</h5>
	<input type='text' name='data[Form][pesquisar]' id='FormPesquisar' autofocus />
	<input type='submit' name='btEnviar' id='btEnviar' value='Ok' />
	</center>
	</form>
</div>
<?php if (isset($this->data)) : ?>
<div id='resposta'>

<?php foreach($this->data as $_linha => $_arrModel) : ?>
<ul>
	<li>
		<?php if ($this->Session->check('Usuario.id')) : ?>
		<?php if (isset($_arrModel['Contato']['id'])) : ?>
		<a title='Clique aqui para editar este contato ...' 
			href='<?= Router::url('/',true).'con/contatos/editar/'.$_arrModel['Contato']['id'] ?>'>
			<?= $_arrModel['Contato']['nome'] ?>
		</a>
		<?php endif ?>
		<?php else : ?>
		<?= $_arrModel['Contato']['nome'] ?>
		<?php endif ?>
		<br />
		<?php if (!empty($_arrModel['Contato']['tel1'])) echo $this->Pagina->getMascara($_arrModel['Contato']['tel1'],'(99)9999-9999').'<br />'; ?>
		<?php if (!empty($_arrModel['Contato']['tel2'])) echo $this->Pagina->getMascara($_arrModel['Contato']['tel2'],'(99)9999-9999').'<br />'; ?>
		<?php if (!empty($_arrModel['Contato']['tel3'])) echo $this->Pagina->getMascara($_arrModel['Contato']['tel3'],'(99)9999-9999').'<br />'; ?>
		<?php if (!empty($_arrModel['Contato']['email'])) echo  $_arrModel['Contato']['email'] ?><br />
	</li>
</ul>
<?php endforeach ?>

</div>
<?php endif ?>
