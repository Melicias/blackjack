<?php
use ArmoredCore\Controllers\BaseController;
use ArmoredCore\WebObjects\Redirect;
use ArmoredCore\WebObjects\Session;
use ArmoredCore\WebObjects\View;
use ArmoredCore\WebObjects\Post;

class registerLoginController extends BaseController
{
    public function regist_login(){
        return View::make('base.regist_login');
    }
    
    public function regist_login_made(){
        //add is_Admin and money to the new user
        //is_admin = 0 means the user doesnt have any admin rights, its a normal user
        $is_admin = array('is_admin' => 0,'money' => 400);
        //joins the 2 arrays (array_merge)
        $values = array_merge(Post::getAll(), $is_admin);
        //creates new user
        $user = new User($values);

        if($user->is_valid()){
            $user->save();
            //var_dump($user);
            registerLoginController::afterLogin($user);
        } else {
            //return form with data/errors
            return View::make('base.regist_login', ['user' => $user]);
        }
    }

    public function login(){
        $username = Post::get("username");
        //go and gets user by the username and checks if is a player by is_admin = 0
        $user = User::find(array("username" => $username, "is_admin" => 0));
        //checks if user exists
        if($user != null){
            $pass = Post::get("pass");
            if($user->pass === $pass){
                registerLoginController::afterLogin($user);
            }else{
                //wrong password
                //return form with data/errors
                return View::make('base.regist_login', ["erroPass" => (object)['errors' => "A password não esta correta!",'username' => $username]]);
            }
        }else{
            //username doesnt exist
            //return form with data/errors
            return View::make('base.regist_login', ["erroUsername" => (object)['errors' => "O username ". $username ." não existe!"]]);
        }
    }

    private function afterLogin($user){
        Session::set('user', $user);
        return View::make('base.index');
    }

    public function logout(){
        Session::destroy();
        Redirect::toRoute('base/index');
    }

}