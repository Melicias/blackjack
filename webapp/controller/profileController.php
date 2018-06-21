<?php
use ArmoredCore\Controllers\BaseController;
use ArmoredCore\WebObjects\Redirect;
use ArmoredCore\WebObjects\Session;
use ArmoredCore\WebObjects\View;
use ArmoredCore\WebObjects\Post;

class profileController extends BaseController
{
    /**
     * @return view
     */
    public function index(){
        if(!Session::has("userid"))
            return Redirect::toRoute('base/index');
        $userid = Session::get('userid');
        $user = User::find($userid);
        //check if user is blocked
        if($user->block != 0)
            return Redirect::toRoute('base/index');
        return View::make('base.profile', ["user" => $user]);
    }
    
    public function changeUser(){
        if(!Session::has("userid"))
            return Redirect::toRoute('base/index');
        $userid = Session::get('userid');
        $user = User::find($userid);
        //check if user is blocked
        if($user->block != 0)
            return Redirect::toRoute('base/index');
        if(strlen(Post::get("pass")) != 0){
            $user->pass = Post::get("pass");
        }
        if(strcmp($user->email,Post::get("email")) !== 0){
            $user->email = Post::get("email");
        }
        $user->full_name = Post::get("full_name");
        $user->birthday = Post::get("birthday");
        if($user->is_valid()){
            //sets the password as hash, after check if password is < 30
            if(strlen(Post::get("pass")) != 0){
                $user->pass = password_hash($user->pass, PASSWORD_DEFAULT);
            }
            $user->save();
            return View::make('base.profile', ["user" => $user, "changed" => (object)['errors' => "The user has been updated"]]);
        } else {
            //return form with data/errors
            return View::make('base.profile', ['user' => $user]);
        }
        
    }
}