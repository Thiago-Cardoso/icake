<?php
/**
 * Model Grupo para módulo de contatos
 *
 * @package		contato
 * @subpackage	contato.Model
 */
/**
 * @package		contato
 * @subpackage	contato.Model
 */
class Grupo extends ConAppModel {
	/**
	 * Nome do model
	 * 
	 * @var		string
	 * @access	public
	 */
	public $name 			= 'Grupo';

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
	public $order		 	= 'Grupo.nome';

	/**
	 * Nome da tabela do banco de dados
	 * 
	 * @var		string
	 * @access	public
	 */
	public $useTable 		= 'grupos';

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
				'message' 	=> 'É necessário informar o nome do Contato!',
			),
			2 	=> array
			(
				'rule' 		=> 'isUnique',
				'required' 	=> true,
				'message' 	=> 'Este e-mail já foi cadastrado!',
			)
		)
	);
}

?>
