<?php
/**
 * Controller para o cadastro de Ajuda
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
class AjudaController extends AppController {
	/**
	 * Model
	 * 
	 * @var		null
	 * @access	public
	 */
	public $uses	= null;

	/**
	 * Exibe a página solicitada
	 * 
	 * @return	void
	 */
	public function pag()
	{
		$pagina 		= 'pag';
		$arrParams 		= func_get_args();
		$pagina 		= $arrParams['0'];
		if ($pagina=='online') $this->onLine();
		$this->render($pagina);
	}

	/**
	 * Exibe a tela com usuários online
	 */
	public function onLine()
	{
		$this->loadModel('Usuario');
		$Usuario = new Usuario();
		$Usuario->belongsTo = array();
		$Usuario->hasAndBelongsToMany = array();
		$online = Configure::read('ONLINE');
		$usuarios = $Usuario->find('list',array('conditions'=>array('Usuario.online=true','Usuario.ultimo_click>DATE_SUB(NOW(), INTERVAL '.$online.' MINUTE)')));
		$this->set(compact('usuarios'));
	}
}
