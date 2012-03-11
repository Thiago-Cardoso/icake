<?php
/**
 * Model para o cadastro de Perfis
 *
 * @copyright	Copyright 2008-2012, Adriano Carneiro de Moura
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
class Perfil extends AppModel {
	/**
	 * Nome do model
	 * 
	 * @var		string
	 * @access	public
	 */
	public $name 			= 'Perfil';

	/**
	 * Campo padrão do model
	 * 
	 * @var		string
	 * @access	public
	 */
	public $displayField 	= 'nome';

	/**
	 * Campo de ordenação padrão
	 * 
	 * @var		string
	 * @access	public
	 */
	public $order		 	= 'Perfil.nome';

	/**
	 * Nome da tabela no banco de dados
	 * 
	 * @var		string
	 * @access	public
	 */
	public $useTable		= 'perfis';

	/**
	 * Regras de validação para cada campo do model
	 * 
	 * @var		array
	 * @access	public
	 */
	public $validate = array
	(
		'nome' => array
		(
			1 	=> array
			(
				'rule' 		=> 'notEmpty',
				'required' 	=> true,
				'message' 	=> 'É necessário informar o nome do Perfil !',
			)
		),
		'restricao'	=> array
		(
			'rule'		=> 'getNaoPodeParaAdministrador', 
			'message'	=> 'O Administrador pode tudo seu oreia !!!'
		)
	);

	/**
	 * Não permite que administradores sejam censurados, eles podem tudo.
	 * 
	 * @retur	boolean 
	 */
	public function getNaoPodeParaAdministrador()
	{
		if (isset($this->data['Perfil']['restricao']) && count($this->data['Perfil']['restricao']) && $this->data['Perfil']['id'] == 1)
		{
			return false;
		}
		return true;
	}

	/**
	 * Executa código antes de salvar
	 * 
	 * @param	array	$options
	 * @return	boolean	
	 */
	public function beforeSave($options=array())
	{
		if (isset($this->data['Perfil']['restricao']) && !empty($this->data['Perfil']['restricao']))
		{
			$this->data['Perfil']['restricao'] = implode(',',$this->data['Perfil']['restricao']);
		}
		return parent::beforeSave($options);
	}
}

?>
