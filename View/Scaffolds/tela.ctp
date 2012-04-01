<center><a href='<?= $urlVolta ?>'>Voltar</a></center>
<?php
	$texto = '<table border="1px" class="lista">';

	// se o oreia não informou os campos, vaou pegar todos, :p
	if (!isset($csvCampos))
	{
		$csvCampos = array();
		foreach($this->data as $_item => $_arrModel)
		{
			foreach($_arrModel as $_model => $_arrCampos)
			{
				foreach($_arrCampos as $_campo => $_valor)
				{
					$c = $_model.'.'.$_campo;
					if (!strpos($c,'_id') && $_campo!='id') array_push($csvCampos,$c);
				}
			}
		}
	}
	//debug($csvCampos);

	// cabeçalho
	$texto .= "<tr>\n";
	$texto .= "\t<td>#</td>\n";
	foreach($csvCampos as $_item => $_campo)
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
		foreach($csvCampos as $_item => $_campo)
		{
			$a = explode('.',$_campo);
			$texto .= "\t<td>".$_arrModel[$a['0']][$a['1']]."</td>\n";
		}
		$texto .= "</tr>\n";
		$l++;
	}
	$texto .= "</table>";

	echo $texto;
?>
