<?php
	$arq = APP.'View'.DS.$this->name.DS.'campos.ctp';
	if (!empty($this->plugin)) $arq = APP.'Plugin'.DS.$this->plugin.DS.'View'.DS.$this->name.DS.'campos.ctp';
	if (file_exists($arq)) require_once($arq);

	$texto = '';

	// se o oreia não informou os campos, vaou pegar todos, :p
	if (!isset($relCampos))
	{
		$relCampos = array();
		foreach($this->data as $_item => $_arrModel)
		{
			foreach($_arrModel as $_model => $_arrCampos)
			{
				foreach($_arrCampos as $_campo => $_valor)
				{
					$c = $_model.'.'.$_campo;
					if (!strpos($c,'_id') && $_campo!='id') array_push($relCampos,$c);
				}
			}
		}
	}
	//debug($relCampos);

	// cabeçalho
	foreach($relCampos as $_item => $_campo)
	{
		$a 		= explode('.',$_campo);
		$tit	= isset($campos[$a['0']][$a['1']]['tit']) ? $campos[$a['0']][$a['1']]['tit'] : $_campo;
		$texto .= '"'.$tit.'",';
	}
	$texto .= "\n";

	// montando o arquivo, linha a linha
	foreach($this->data as $_item => $_arrModel)
	{
		$l = 1;
		foreach($relCampos as $_item => $_campo)
		{
			$c = explode('.',$_campo);
			$mascara = isset($campos[$c['0']][$c['1']]['mascara']) ? $campos[$c['0']][$c['1']]['mascara'] : '';

			$texto .= '"'.$this->Pagina->getMascara($_arrModel[$c['0']][$c['1']],$mascara).'",';
		}
		$texto .= "\n";
		$l++;
	}
	
	echo $texto;
?>
