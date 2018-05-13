<?php
use ArmoredCore\Controllers\BaseController;
use ArmoredCore\WebObjects\Redirect;
use ArmoredCore\WebObjects\Session;
use ArmoredCore\WebObjects\View;
use ArmoredCore\WebObjects\Post;

class gameController extends BaseController
{
    public function index(){
        return View::make('base.game');
    }

    public function bet(){
        $bet_value = Post::get("bet_value");
        $userid = Session::get('userid');
        $user = User::find($userid);
        if($user->money > $bet_value){
            $user->money -= $bet_value;
            $user->update_attributes(array('money' => $user->money));
            if($user->is_valid()){
                $user->save();
                //return View::make('base.game');
                Redirect::toRoute('base/jogar');
            } else {
                
            }
        }
    }

}