<?php
/**
 * Controller para o cadastro de Contatos
 *
 * @copyright	Copyright 2008-2012, Adriano Carneiro de Moura
 * @link		http://github.com/adrianodemoura/icake 	Projeto iCake
 * @package		icake.contatos
 * @subpackage	icake.contatos.Controller
 * @since		CakePHP(tm) v 2.1
 * @license		MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
/**
 * @package			icake.contatos
 * @subpackage		icake.contatos.Controller
 */
class ContatosController extends ConAppController {
	/**
	 * Modelo
	 * 
	 * @var		array
	 * @access	public
	 */
	public $uses	= array('Con.Contato');

	/**
	 * Imprime a lista de cargos
	 * 
	 * @return	void
	 */
	public function rel_lista()
	{
		$parametros['order']					= 'Contato.nome';
		parent::rel_lista($parametros);
	}
}
