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
		/*border: 1px solid #ccc;*/
		min-width: 500px;
		max-width: 90%;
		margin: 0px auto;
	}
</style>
<div id='pesquisar'>
	<form name='formPesquisar' method='post' action=''>
	<center>
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
