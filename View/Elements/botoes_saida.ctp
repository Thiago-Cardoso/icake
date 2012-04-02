<div id='botoess'>
 	<input type='button' name='btPdf' 	id='btPdf' 	value='Pdf' 	class='botao' />
	<input type='button' name='btTela' 	id='btTel'	value='Tela' 	class='botao' />
	<input type='button' name='btCsv' 	id='btCsv'	value='Csv'		class='botao' />
	<input type='button' name='btImp' 	id='btImp'	value='Impressora'	class='botao' />
</div>
<?php $this->viewVars['onRead'] .= '$("#btPdf").click(function() { $("#RelLayout").val("pdf");	 	$("form").get(0).submit(); }); '."\n"; ?>
<?php $this->viewVars['onRead'] .= '$("#btTel").click(function() { $("#RelLayout").val("tela"); 	$("form").get(0).submit(); }); '."\n"; ?>
<?php $this->viewVars['onRead'] .= '$("#btCsv").click(function() { $("#RelLayout").val("csv");  	$("form").get(0).submit(); }); '."\n"; ?>
<?php $this->viewVars['onRead'] .= '$("#btPdf").click(function() { $("#RelLayout").val("pdf");	 	$("form").get(0).submit(); }); '."\n"; ?>
<?php $this->viewVars['onRead'] .= '$("#btTel").click(function() { $("#RelLayout").val("tela"); 	$("form").get(0).submit(); }); '."\n"; ?>
<?php $this->viewVars['onRead'] .= '$("#btImp").click(function() { $("#RelLayout").val("imp");  	$("form").get(0).submit(); }); '."\n"; ?>
