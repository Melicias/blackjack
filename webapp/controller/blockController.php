<?php
use ArmoredCore\Controllers\BaseController;
use ArmoredCore\WebObjects\Redirect;
use ArmoredCore\WebObjects\Session;
use ArmoredCore\WebObjects\View;
use ArmoredCore\WebObjects\Post;

class blockController extends BaseController
{
    /**
     * @return view
     */
    public function index(){
        //check if user is login
        if(!Session::has("userid"))
            return Redirect::toRoute('base/index');
        $userid = Session::get('userid');
        $user = User::find($userid);
        //check if user is blocked
        if($user->block == 0)
            return Redirect::toRoute('base/index');
        return View::make('base.block', ["user" => $user]);
    }

    /**
     * @return view
     * 
     * unlocks the user
     */
    public function unblock(){
        if(!Session::has("userid"))
            return Redirect::toRoute('base/index');
        $userid = Session::get('userid');
        $user = User::find($userid);
        if($user->block == 0)
            return Redirect::toRoute('base/index');
        $money = Post::get('funds');
        //error, value is lower than 1 and higher than 10000
        //ctype_digit -> Checks if all of the characters in the provided string, text, are numerical.
        if($money <= 0 || $money > 10000 || !ctype_digit($money))
            return Redirect::toRoute('base/block');
        $credits = $user->money + ($money*4);
        $user->update_attributes(array("money" => $credits,"block" => 0));
        return Redirect::toRoute('base/index');
    }

}