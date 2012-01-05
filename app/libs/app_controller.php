<?php

/**
 * Todas las controladores heredan de esta clase en un nivel superior
 * por lo tanto los metodos aqui definidos estan disponibles para
 * cualquier controlador.
 *
 * @category Kumbia
 * @package Controller
 * */
// @see Controller nuevo controller
require_once CORE_PATH . 'kumbia/controller.php';

class AppController extends Controller {


    final protected function initialize() {

    }

    final protected function finalize() {
        
    }
    
    public function logout() {
        Load::lib('SdAuth');
        SdAuth::logout();                
        return Router::redirect('../');
    }
    
    /*public function logout () {
        Load::lib('SdAuth');
        SdAuth::logout();
        //View::template('login2');
        Router::redirect();
    }*/

}
