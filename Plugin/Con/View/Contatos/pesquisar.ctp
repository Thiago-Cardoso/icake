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
<?php foreach($this->data as $_linha => $_arrModel) : ?>
<ul>
	<li>
		<?php if ($this->Session->check('Usuario.id')) : ?>
		<a title='Clique aqui para editar este contato ...' href='<?= Router::url('/',true).'con/contatos/editar/'.$_arrModel['Contato']['id'] ?>'><?= $_arrModel['Contato']['nome'] ?></a>
		<?php else : ?>
		<?= $_arrModel['Contato']['nome'] ?>
		<?php endif ?>
		<br />
		<?php if (!empty($_arrModel['Contato']['tel1'])) echo $this->Pagina->getMascara($_arrModel['Contato']['tel1'],'(99)9999-9999'); ?><br />
		<?php if (!empty($_arrModel['Contato']['tel2'])) echo  $this->Pagina->getMascara($_arrModel['Contato']['tel2'],'(99)9999-9999'); ?><br />
		<?php if (!empty($_arrModel['Contato']['tel3'])) echo $this->Pagina->getMascara($_arrModel['Contato']['tel3'],'(99)9999-9999'); ?><br />
		<?php if (!empty($_arrModel['Contato']['email'])) echo  $_arrModel['Contato']['email'] ?><br />
	</li>
</ul>
<?php endforeach ?>

<?php endif ?>
