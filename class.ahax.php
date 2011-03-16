<?php
/**
* Main Class for AHAX WordPress Plugin
*
* @copyright Copyright (c) 2010 Daniel Doezema. (http://dan.doezema.com)
* @license http://dan.doezema.com/licenses/new-bsd New BSD License
*/
class Ahax {
    
    /**
    * The filter tag used to hook into the ajax request.
    */
    const PREFIX = 'ahax_request_';
    
    /**
    * Enable / Disable output of errors.
    */
    protected $is_debugging = false;
    
   
    /**
    * Create a ahax tag that can be hooked into.
    */
    public static function tag($action) {
        return self::PREFIX . $action;
    } 

    /**
    * Handle the AJAX request.
    */
    public function handleRequest() {
        if($this->isCalledFromCorrectContext()) {
            if(is_string($action = $this->getAction())) {
                $output = apply_filters(self::tag($action), $output = '', $this);
                $this->sendOutput($output);
            }
            $this->sendError('Invalid Action');            
        }
        $this->sendError('Invalid Context');
    }

    /**
    * Return the action from either the $_POST or $_GET
    * $_POST overrides $_GET
    */
    protected function getAction() {
        $action = false;
        $params = array_map('trim', array_merge($_GET, $_POST));
        if(isset($params['action'])) {
            if(isset($params['action']) && (strlen($params['action']) > 0) && preg_match('/^[a-z\_]+$/i', $params['action'])) {
               $action = $params['action'];
            }
        }
        return $action;
    }
    
    /**
    * Send a string to the output buffer, then die.
    */
    protected function sendOutput($output) {
        echo $output;
        die;
    }

    /**
    * Send an error string to the output buffer, then die.
    */
    protected function sendError($output = -1) {
        if($this->isDebugging()) {
            echo 'Error: '. $output;
        }
        die;
    }

    /**
    * Get / Set is debugging is enabled.
    */
    protected function isDebugging($bool = null) {
        if(is_bool($bool)) {
            $this->is_debugging = $bool;
        }
        return $this->is_debugging;
    } 

    /**
    * Make sure the request has been made from the ahax/request.php file.
    */
    protected function isCalledFromCorrectContext() {
        if(stripos($_SERVER['REQUEST_URI'], 'wp-content/plugins/ahax/request.php') !== false) {
            return true;
        }
        return false;
    }
}