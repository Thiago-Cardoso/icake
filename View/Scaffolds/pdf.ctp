<?php
	$arq = APP.'View'.DS.$this->name.DS.'campos.ctp';
	if (!empty($this->plugin)) $arq = APP.'Plugin'.DS.$this->plugin.DS.'View'.DS.$this->name.DS.'campos.ctp';
	if (file_exists($arq)) require_once($arq);

	// definindo as configurações obrigatórias do relatório lista
	$arquivo 		= isset($arquivo) 		? str_replace(' ','_',$arquivo)	: 'Relatório de '.$this->name;
	$cabecalho		= isset($cabecalho) 	? $cabecalho 	: 'cabecalho';
	$rodape			= isset($rodape)		? $rodape	 	: 'rodape';
	$reg_por_linha	= isset($reg_por_linha) ? $reg_por_linha: 30;
	$pag_orientacao	= isset($pag_orientacao)? $pag_orientacao: 'L';
	$pag_formato	= isset($pag_formato)	? $pag_formato	: 'a4';
	$font_size		= isset($font_size)		? $font_size	: '7';
	if (isset($config['titulo']) && $arquivo=='relatorio') $arquivo = str_replace(' ','_',$config['titulo']);
	$relTitulos['0']= isset($relTitulos['0']) ? $relTitulos['0'] : 'Relatório';

	// usando a bola de cristal pra criar os parâmetros obrigatórios
	if (!isset($colunas))
	{
		$colunas = array();
	}

	// adivinhando os campos, caso o oreia não tenha informado
	if (!isset($relCampos))
	{
		$relCampos = array();
		if (isset($this->data))
		{
			foreach($this->data as $_item => $_arrModel)
			{
				foreach($_arrModel as $_model => $_arrCampos)
				{
					$l = 1;
					foreach($_arrCampos as $_campo => $_arrProp)
					{
						if (!strpos($_campo,'id') && $_campo != 'id' && isset($_arrProp['length']))
						{
							$cmp = $_model.'.'.$_campo;
							array_push($relCampos,$cmp);
							$colunas[$l]['lar'] = 20;
							$colunas[$l]['tit'] = $_campo;
							$l++;
						}
					}
				}
			}
		}
	} else
	{
		$l = 1;
		foreach($relCampos as $_item => $_campo)
		{
			$c = explode('.',$_campo);
			$tit = isset($campos[$c['0']][$c['1']]['tit']) ? $campos[$c['0']][$c['1']]['tit'] : $_campo;
			$colunas[$l]['tit'] = $tit;	
			$l++;
		}
	}
	//debug($relCampos);

	require_once(APP.'Vendor' . DS . 'Fpdf' . DS . 'pdf.php');
	$pdf = new PDF($pag_orientacao);
	$pdf->titEsquerdo = $SIGLA.' - '.$SISTEMA;
	$pdf->AliasNbPages( '{total}' );
	$pdf->largura = ($pag_orientacao=='L') ? $pdf->DefPageSize['1'] : $pdf->DefPageSize['0'];

	// configurando os títulos do relatório
	$i = 0;
	foreach($relTitulos as $_item => $_valor)
	{
		if (strpos($_valor,'{'))
		{
			$campo 		= substr($_valor,strpos($_valor,'{'),strlen($_valor));
			$campo 		= ereg_replace('[ {}]','',$campo);
			$arrCampo	= explode('.',$campo);
			$vlrCampo 	= isset($this->data['0'][$arrCampo['0']][$arrCampo['1']]) ? $this->data['0'][$arrCampo['0']][$arrCampo['1']] : ' !!!! ';
			$_valor		= str_replace('{'.$campo.'}',$vlrCampo,$_valor);
		}
		$pdf->titulo[$i] = $_valor;
		$i++;
	}

	// configurando as colunas
	$pdf->colunas = $colunas;
	$tc	= count($pdf->colunas);
	//debug($colunas);

	// primeira página
	$pdf->addPage();

	// linha a linha
	$pdf->SetFont('Arial','',$font_size);
	foreach($this->data as $_linha => $_arrModel)
	{
		$pdf->Cell(8,5,($_linha+1),1,'','C');
		$i = 1;
		foreach($relCampos as $_item => $_campo)
		{
			// recuperando o valor do campo no this->data
			$arrCampo 	= explode('.',$_campo);
			$valor		= isset($_arrModel[$arrCampo['0']][$arrCampo['1']]) ? $_arrModel[$arrCampo['0']][$arrCampo['1']] : '';
			$mascara	= isset($campos[$arrCampo['0']][$arrCampo['1']]['mascara']) ? $campos[$arrCampo['0']][$arrCampo['1']]['mascara'] : '';
			$opcoes		= isset($campos[$arrCampo['0']][$arrCampo['1']]['input']['options']) ? $campos[$arrCampo['0']][$arrCampo['1']]['input']['options'] : array();
			$valor		= $this->Pagina->getMascara($valor,$mascara,$opcoes);

			// propriedades obrigatórias
			$pdf->colunas[$i]['ali'] = isset($pdf->colunas[$i]['ali']) ? $pdf->colunas[$i]['ali'] : 'L';
			$pdf->colunas[$i]['lar'] = isset($pdf->colunas[$i]['lar']) ? $pdf->colunas[$i]['lar'] : '10';

			// escrevendo a célula
			$pdf->Cell($pdf->colunas[$i]['lar'], 5, utf8_decode($valor),1,'',$pdf->colunas[$i]['ali']);
			$i++;
		}
		$pdf->ln();
	}

	// imprimindo o pdf no pdf, :p
	$pdf->Output($arquivo.'.pdf','D');
	exit(0);

// debug
//debug($this->data);
?>
