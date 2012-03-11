<?php
/**
 * Ferramentas para a aplicação icake, somente sistema básico
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
class Ferramenta extends AppModel {
	/**
	 * Nome do model
	 * 
	 * @var		string
	 * @access	public
	 */
	public $name 		= 'Ferramenta';	
	
	/**
	 * Nome da tabela
	 * 
	 * @var		boolean/string
	 * @access	public
	 */
	public $useTable 	= false;
}
