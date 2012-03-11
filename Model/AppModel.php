<?php
/**
 * Model Principal da aplicação
 *
 * @copyright	Copyright 202, Adriano Carneiro de Moura
 * @link		http://github.com/adrianodemoura/icake 	Projeto iCake
 * @package		icake
 * @subpackage	icake.Model
 * @since		CakePHP(tm) v 2.1
 * @license		MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
/**
 * @package			icake
 * @subpackage		icake.Model
 */
App::uses('Model', 'Model');
class AppModel extends Model {
	/**
	 * Executa código antes de salvar
	 * 
	 * @param	array	$options
	 * @return	boolean	
	 */
	public function beforeSave($options=array())
	{
		$ignorarCampos 	= isset($this->ignorarCampos) 	? $this->ignorarCampos 	: array();
		$limparCampos	= isset($this->limparCampos) 	? $this->limparCampos 	: array();
		$camposMinusculo= array('email');

		// dando o loop em todo conteúdo
		foreach($this->data[$this->name] as $_campo => $_valor)
		{
			// colocando tudo em maiúsculo
			if (!in_array($_campo,$ignorarCampos))
			{
				$this->data[$this->name][$_campo] = mb_strtoupper($_valor,'utf-8');
			}
			
			// colocando tudo em minúsculo
			if (in_array($_campo,$camposMinusculo))
			{
				$this->data[$this->name][$_campo] = mb_strtolower($_valor,'utf-8');
			}
			
			// convertendo data
			if (isset($this->_schema[$_campo]['type']) && $this->_schema[$_campo]['type'] == 'date')
			{
				$valor = explode('/',$this->data[$this->name][$_campo]); //01/02/2004
				if (isset($valor['2']) && $valor['1'] && $valor['0'])
				{
					$this->data[$this->name][$_campo] = $valor['2'].'-'.$valor['1'].'-'.$valor['0'];
				}
			}

			// convertendo data hora
			if (isset($this->_schema[$_campo]['type']) && $this->_schema[$_campo]['type'] == 'datetime' && !in_array($_campo,array('created','modified')))
			{
				$_valor = $this->data[$this->name][$_campo];
				$data	= trim(substr($_valor,0,10));
				$hora	= trim(substr($_valor,11,10)); if ($hora=='') $hora = date('H:i:s');
				$valor = explode('/',$data);
				if (isset($valor['2']) && $valor['1'] && $valor['0'])
				{
					$this->data[$this->name][$_campo] = $valor['2'].'-'.$valor['1'].'-'.$valor['0'].' '.$hora;
				}
			}

			// removendo máscara de alguns campos
			if  ( (!in_array($_campo,$ignorarCampos) && in_array($_campo,array('cpf','cep','telefone','celular') ))
				OR 
				 (in_array($_campo,$limparCampos)) 
				)
			{
				$arrLimpa = array('(',')','.','-','/',' ','_');
				$this->data[$this->name][$_campo] = str_replace($arrLimpa,'',$this->data[$this->name][$_campo]);
			}
		}
		//debug($this->data);die();
		return true;
	}
}
