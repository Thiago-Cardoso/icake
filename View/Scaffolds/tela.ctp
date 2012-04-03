<?php
	$arq = APP.'View'.DS.$this->name.DS.'campos.ctp';
	if (!empty($this->plugin)) $arq = APP.'Plugin'.DS.$this->plugin.DS.'View'.DS.$this->name.DS.'campos.ctp';
	if (file_exists($arq)) require_once($arq);
?>

<?php if ($this->layout != 'imp') : ?>
<center><a href='javascript:history.go(-1);'>Voltar</a></center>
<?php endif ?>
<?php
	$texto = '<table border="1px" class="lista">';

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
					if (!strpos($c,'_id') && $_campo!='id') array_push($RelCampos,$c);
				}
			}
		}
	}
	//debug($csvCampos);

	// cabeçalho
	$texto .= "<tr>\n";
	$texto .= "\t<td>#</td>\n";
	foreach($relCampos as $_item => $_campo)
	{
		$a 		= explode('.',$_campo);
		$tit	= isset($campos[$a['0']][$a['1']]['tit']) ? $campos[$a['0']][$a['1']]['tit'] : $_campo;
		$texto .= "\t<th>$tit</th>\n";
	}
	$texto .= "</tr>\n";

	// montando o arquivo, linha a linha
	foreach($this->data as $_item => $_arrModel)
	{
		$l = 1;
		$texto .= "<tr>\n";
		$texto .= "\t<td>$l</td>\n";

		// montando campo a campo
		foreach($relCampos as $_item => $_campo)
		{
			$a = explode('.',$_campo);
			$texto .= "\t<td>";
			
			$c = explode('.',$_campo);
			$mascara = isset($campos[$c['0']][$c['1']]['mascara']) ? $campos[$c['0']][$c['1']]['mascara'] : '';

			$texto .= $this->Pagina->getMascara($_arrModel[$a['0']][$a['1']],$mascara);
			$texto .= "</td>\n";
		}
		$texto .= "</tr>\n";
		$l++;
	}
	$texto .= "</table>";

	echo $texto;
?>
