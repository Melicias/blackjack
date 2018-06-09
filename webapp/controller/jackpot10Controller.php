<?php
use ArmoredCore\Controllers\BaseController;
use ArmoredCore\WebObjects\Redirect;
use ArmoredCore\WebObjects\Session;
use ArmoredCore\WebObjects\View;
use ArmoredCore\WebObjects\Post;

class jackpot10Controller extends BaseController
{
    /**
     * @return view
     * 
     * sends to the view the list with top 10 jackpots and the user jackpot if there is any user loged in
     */
    public function index(){
        //CODE
        $jackpots = Jackpot::find('all',array('order' => 'value_won desc limit 10'));
        if(Session::has("userid")){
            //gets the user in the database by the id
            $user = User::find(Session::get('userid'));
            if($user->block == 1)
                return View::make('base.block');
            $jackpot_user = Jackpot::find('first',array('conditions' => array('id_user=?',Session::get("userid"))));
            return View::make('base.jackpot10', ['jackpots' => $jackpots,'jackpot_user' => $jackpot_user]);
            //return View::make('base.jackpot10', ['jackpots' => $jackpots,'jackpot_user' => (object)['errors' => $jackpot_user]]);
        }else{
            return View::make('base.jackpot10', ['jackpots' => $jackpots]);
        }
    }
}