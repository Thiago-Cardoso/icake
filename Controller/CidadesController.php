<?php
/**
 * Controller para o cadastro de Cidades
 *
 * @copyright	Copyright 2008-2012, Adriano Carneiro de Moura
 * @link		http://github.com/adrianodemoura/icake 	Projeto iCake
 * @package		icake
 * @subpackage	icake.Controller
 * @since		CakePHP(tm) v 2.1
 * @license		MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
/**
 * @package			icake
 * @subpackage		icake.Controller
 */
class CidadesController extends AppController {
	/**
	 * Modelo
	 * 
	 * @var		array
	 * @access	public
	 */
	public $uses	= array('Cidade');

	/**
	 * Imprime a lista de cargos
	 * 
	 * @return	void
	 */
	public function rel_lista()
	{
		$parametros['order']					= 'Estado.uf';
		parent::rel_lista($parametros);
	}
}
