<?php
/**
 * Controller da página principal
 * 
 * @package 	exemploApp
 * @subpackage	exemploApp.controller
 */
/**
 * @package 	meucake
 * @subpackage	jcake.controller
 */
class PrincipalController extends AppController {
	/**
	 * Nome do controlador
	 * 
	 * @var		string
	 * @access	public
	 */
	public $name = 'Principal';

	/**
	 * Nome do model
	 * 
	 * @var		string
	 * @access	public
	 */
	public $uses = array();

	/**
	 * Ajudantes
	 * 
	 * @var		array
	 * @access	public
	 */
	public $helpers		= array('Jcake.Visao');

	/**
	 * Exibe a tela principal
	 * 
	 * @return		void
	 */
	public function index()
	{
	}
}
?>
