<?php
/**
 * @author Oliver Blum <blumanski@gmail.com>
 * @date 2016-01-02
 *
 * This is error module index controller
 * All errors may end up in here
 */

Namespace Bang\Modules\Error;

class indexController extends \Bang\SuperController implements \Bang\ControllerInterface
{
	/**
	 * Modules DB Model
	 * @var object
	 */
	private $Data;
	
	/**
	 * View object
	 * @var object
	 */
	private $View;
	
	/**
	 * ErrorLog object
	 * @var object
	 */
	private $ErrorLog;
	
	/**
	 * Instance of Language object
	 * @var object
	 */
	private $Lang;
	
	/**
	 * Keeps the template overwrite folder path
	 * If a template is available in the template folder, it allows
	 * to load that template instead of the internal one.
	 * So, one can easily change templates from the template without touching
	 * the module code.
	 * @var string
	 */
	private $Overwrite;
	
	/**
	 * Instance of Mail object
	 * @var object
	 */
	private $Mail;
	
    /**
     * Mo need but could
     * @param object $di
     */
    public function __construct(\stdClass $di) {
    	
    	$this->path     		= dirname(dirname(__FILE__));
    	// assign class variables
    	$this->ErrorLog 		= $di->ErrorLog;
    	$this->View				= $di->View;
    	$this->Session          = $di->Session;
    	$this->Lang				= $di->View->Lang;
    }
    
    /**
     * Display default error page
     */
    public function indexAction() {
    	$this->View->setMainIndex('error.php');
    }
    
    /**
     * Trigegrs a 404 error
     */
    public function error404Action()
    {
    	print '<pre>';
    	print_r('Error 404');
    	print '</pre>';
    	$this->return404();
    }
    
    /**
     * Permission test
     * 1. Test if user is logged in
     */
    public function testPermisions()
    {
    	// 1. if user is not logegd in, redirect to login with message
    	if($this->Session->loggedIn() === false) {
    		$this->Session->setError($this->Lang->get('application_notlogged_in'));
    		Helper::redirectTo('/account/index/login/');
    		exit;
    	}
    	 
    	 
    }
    
    /**
     * Must be in all classes
     * @return array
     */
    public function __debugInfo() {
    
    	$reflect	= new \ReflectionObject($this);
    	$varArray	= array();
    
    	foreach ($reflect->getProperties(\ReflectionProperty::IS_PUBLIC) as $prop) {
    		$propName = $prop->getName();
    		 
    		if($propName !== 'DI' && $propName != 'CNF') {
    			//print '--> '.$propName.'<br />';
    			$varArray[$propName] = $this->$propName;
    		}
    	}
    
    	return $varArray;
    }
    
}