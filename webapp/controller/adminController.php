<?php
use ArmoredCore\Controllers\BaseController;
use ArmoredCore\WebObjects\Redirect;
use ArmoredCore\WebObjects\Session;
use ArmoredCore\WebObjects\View;
use ArmoredCore\WebObjects\Post;

class adminController extends BaseController
{
    public function index(){
        return View::make('admin.index');
    }

    public function login(){
        return View::make('admin.login');
    }

    public function afterLogin(){
        $username = Post::get("username");
        //go and gets user by the username and checks if is an by is_admin = 1
        $user = User::find(array("username" => $username, "is_admin" => 1));
        //checks if user exists
        if($user != null){
            $pass = Post::get("pass");
            if($user->pass === $pass){
                Session::set('adminid', $user->id);
                //Redirect::toRoute('home/worksheet');
                return View::make('admin.index', ["users" => adminController::getUsers()]);
            }else{
                //wrong password
                //return form with data/errors
                return View::make('admin.login', ["erroPass" => (object)['errors' => "A password não esta correta!",'username' => $username]]);
            }
        }else{
            //username doesnt exist
            //return form with data/errors
            return View::make('admin.login', ["erroUsername" => (object)['errors' => "O username ". $username ." não existe!"]]);
        }
    }

    public function getUsers(){
        //gets all users with a condition: is_admin = 0
        return User::find('all', array('conditions' => 'is_admin = 0'));
    }

    public function block(){
        if(Post::has("block")){
            $id = Post::get('block');
            $user = User::find($id);
            $user->update_attributes(array("block" => 1));
        }else{
            $id = Post::get('unblock');
            $user = User::find($id);
            $user->update_attributes(array("block" => 0));
        }
        return View::make('admin.index', ["users" => adminController::getUsers()]);
    }

}