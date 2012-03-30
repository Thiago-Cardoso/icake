<?php
/**
 * Controlador do Cadastro de Ajuda no plugin de Contatos
 * 
 * @package		Contatos
 * @subpackage	Contatos.Controller
 */
/**
 * @package		Contatos
 * @subpackage	Contatos.Controller
 */
class AjudaController extends ConAppController {
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
		$this->render($pagina);
	}
}
