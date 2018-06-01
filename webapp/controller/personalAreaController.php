<?php
use ArmoredCore\Controllers\BaseController;
use ArmoredCore\WebObjects\Redirect;
use ArmoredCore\WebObjects\Session;
use ArmoredCore\WebObjects\View;
use ArmoredCore\WebObjects\Post;

class personalAreaController extends BaseController
{
    public function index(){
        if(!Session::has("userid"))
            return Redirect::toRoute('base/index');
        //CODE
        $userid = Session::get('userid');
        $user = User::find($userid);

        $userMovements = UserMovement::find('all',array('conditions' => array('id_user=?',$userid),
                                            'order' => 'movement_date desc limit 10')); //limit 10
        
        return View::make('base.personalArea', ["userMovements" => $userMovements , "user" => $user]);
    }


    public function addFunds(){
        if(!Session::has("userid"))
            return Redirect::toRoute('base/index');
        $money = Post::get('funds');
        //error, value is lower than 1 and higher than 10000
        //ctype_digit -> Checks if all of the characters in the provided string, text, are numerical.
        if($money < 0 || $money > 10000 || !ctype_digit($money))
            return Redirect::toRoute('base/personalArea');
        $userid = Session::get('userid');
        //gets the user in the database by the id
        $user = User::find($userid);
        $credits = $user->money + ($money*4);
        $user->update_attributes(array("money" => $credits));
        //we need to add the funds to the user and multiply by 4 because 1€ its 4 credits
        $movement = new UserMovement(array('id_user' => $userid,'money_type' => 'pay',
                                           'credito' => ($money*4)/*,'movement_date' => date('Y-m-d H:i:s')*/,
                                           'description' => 'Carregamento ' . $money . "€",'saldo' => $credits));
        $movement->save();
        return Redirect::toRoute('base/personalArea');
        //$this::index();
        
    }
}