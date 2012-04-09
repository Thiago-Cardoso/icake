<?php ?>
<div id='botoess'>
 	<input type='button' name='btPdf' 	id='btPdf' 	value='Pdf' 	class='botao' />
	<input type='button' name='btTela' 	id='btTel'	value='Tela' 	class='botao' />
	<?php if (!in_array('VISITANTE',$this->Session->read('Usuario.Perfis'))) : ?>
	<input type='button' name='btCsv' 	id='btCsv'	value='Csv'		class='botao' />
	<?php endif ?>
	<input type='button' name='btImp' 	id='btImp'	value='Impressora'	class='botao' />
</div>
<?php $this->viewVars['onRead'] .= '$("#btPdf").click(function() { $("#RelLayout").val("pdf");	 	this.form.target="";	this.form.submit(); }); '."\n"; ?>
<?php $this->viewVars['onRead'] .= '$("#btTel").click(function() { $("#RelLayout").val("tela"); 	this.form.target="";	this.form.submit(); }); '."\n"; ?>
<?php $this->viewVars['onRead'] .= '$("#btCsv").click(function() { $("#RelLayout").val("csv");  	this.form.target="";	this.form.submit(); }); '."\n"; ?>
<?php $this->viewVars['onRead'] .= '$("#btImp").click(function() { $("#RelLayout").val("imp");  	this.form.target="_blank"; 	this.form.submit(); }); '."\n"; ?>
