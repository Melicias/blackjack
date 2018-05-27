<?php
use ArmoredCore\Controllers\BaseController;
use ArmoredCore\WebObjects\Redirect;
use ArmoredCore\WebObjects\Session;
use ArmoredCore\WebObjects\View;
use ArmoredCore\WebObjects\Post;

class jackpot10Controller extends BaseController
{
    public function index(){
        //CODE
        $jackpots = Jackpot::find('all',array('order' => 'value_won desc limit 10'));
        if(Session::has("userid")){
            $jackpot_user = Jackpot::find('first',array('conditions' => array('id_user=?',Session::get("userid"))));
            return View::make('base.jackpot10', ['jackpots' => $jackpots,'jackpot_user' => $jackpot_user]);
        }else{
            return View::make('base.jackpot10', ['jackpots' => $jackpots]);
        }
    }
}