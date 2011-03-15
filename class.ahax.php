<?php
/**
* Main Class for AHAX WordPress Plugin
*
* @copyright Copyright (c) 2010 Daniel Doezema. (http://dan.doezema.com)
* @license http://dan.doezema.com/licenses/new-bsd New BSD License
*/
class Ahax {
    
    // The filter tag used to hook into the ajax request.
    const FILTER_TAG = 'ahax_request';
    
    // Allow the output of errors.
    protected $debug = true;
    
    public function __construct() {
        
    }

    // Handle the ajax requst
    public function handleRequest() {
        if($this->isCalledFromCorrectContext()) {
            if(is_string($action = $this->getAction())) {
                $output = '';
                $output = apply_filters(self::FILTER_TAG, $output, $action);
                $this->sendOutput($output);
            }
            $this->sendError('Invalid Action');            
        }
        $this->sendError('Invalid Context');
    }

    // Return the action from $_POST['action'] > $_GET['action']
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
    
    // Send filtered output to the output buffer and die.
    protected function sendOutput($output) {
        echo $output;
        die;
    }

    // Send an error to the output buffer and die (send = output & die).
    protected function sendError($output = -1) {
        if($this->isDebugging()) {
            echo $output;
        }
        die;
    }

    protected function isDebugging($bool = null) {
        if(is_bool($bool)) {
            $this->debug = $bool;
        }
        return $this->debug;
    } 

    // Make sure the request has been made from the ahax/request.php file.
    protected function isCalledFromCorrectContext() {
        if(stripos($_SERVER['REQUEST_URI'], 'wp-content/plugins/ahax/request.php') !== false) {
            return true;
        }
        return false;
    }
}