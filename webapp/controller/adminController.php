<?php
use ArmoredCore\Controllers\BaseController;
use ArmoredCore\WebObjects\Redirect;
use ArmoredCore\WebObjects\Session;
use ArmoredCore\WebObjects\View;
use ArmoredCore\WebObjects\Post;

class adminController extends BaseController
{
    /**
     * @return view
     */
    public function index(){
        //return View::make('admin.index');
    }

    /**
     * @return view
     */
    public function login(){
        if(Session::has("adminid"))
            return View::make('admin.index', ["users" => adminController::getUsers()]);
        return View::make('admin.login');
    }

    /**
     * @return view 
     * 
     * checks if username and password are in db and check if its a correct match
     */
    public function afterLogin(){
        $username = Post::get("username");
        //go and gets user by the username and checks if is an by is_admin = 1
        $user = User::find(array("username" => $username, "is_admin" => 1));
        //checks if user exists
        if($user != null){
            $pass = Post::get("pass");
            if ($user->checkPassword($pass)) {
                if($user->block == 1){
                    //The admin is blocked
                    //return form with data/errors
                    return View::make('admin.login', ["erroBlock" => (object)['errors' => "The account " . $user->username . " is block!!"]]);
                }else{
                    Session::set('adminid', $user->id);
                    //return with all users
                    return View::make('admin.index', ["users" => adminController::getUsers()]);
                }
            }else{
                //wrong password
                //return form with data/errors
                return View::make('admin.login', ["erroPass" => (object)['errors' => "A password não esta correta!",'username' => $username]]);
            }
        }else{
            //go and gets user by the username and checks if is an by is_admin = 2
            $user = User::find(array("username" => $username, "is_admin" => 2));
            //checks if user exists
            if($user != null){
                $pass = Post::get("pass");
                if(password_verify($pass, $user->pass)){
                    if($user->block == 1){
                        //The admin is blocked
                        //return form with data/errors
                        return View::make('admin.login', ["erroBlock" => (object)['errors' => "A conta " . $user->username . " esta bloqueada!!"]]);
                    }else{
                        Session::set('adminid', $user->id);
                        //return with all users
                        return View::make('admin.index', ["users" => adminController::getUsers()]);
                    }
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
    }

    /**
     * @return array with all users
     */
    public function getUsers(){
        //gets all users with a condition: is_admin = 0
        return User::find('all', array('conditions' => 'is_admin = 0'));
    }

    /**
     * @return array with all users
     */
    public function getAdmins(){
        //gets all admin with a condition: is_admin = 1
        return User::find('all', array('conditions' => 'is_admin = 1'));
    }

    /**
     * @return view
     * 
     * block/unblock an user
     */
    public function block(){
        if(!Session::has("adminid"))
            return Redirect::toRoute('base/index');
        $user;
        if(Post::has("block")){
            $id = Post::get('block');
            $user = User::find($id);
            //sets block -> 1 and 1 means he is now blocked
            $user->update_attributes(array("block" => 1));
        }else{
            $id = Post::get('unblock');
            //sets block -> 0 and 0 means he is now unblocked
            $user = User::find($id);
            $user->update_attributes(array("block" => 0));
        }
        if($user->is_admin == 1)
            return View::make('admin.admins', ["admins" => adminController::getAdmins()]);
        return View::make('admin.index', ["users" => adminController::getUsers()]);
    }

    /**
     * @return view
     * 
     * return view with users
     */
    public function users(){
        if(!Session::has("adminid"))
            return Redirect::toRoute('base/index');
        return View::make('admin.index', ["users" => adminController::getUsers()]);
    }

    /**
     * @return view
     * 
     * return view with admins
     */
    public function admins(){
        if(!Session::has("adminid"))
            return Redirect::toRoute('base/index');
        $admin = User::find(Session::get('adminid'));
        if($admin->is_admin == 2)
            return View::make('admin.admins', ["admins" => adminController::getAdmins()]);
        return View::make('admin.index', ["users" => adminController::getUsers()]);
    }

    /**
     * @return view
     */
    public function logout(){
        if(!Session::has("adminid"))
            return Redirect::toRoute('base/index');
        Session::remove('adminid');
        Redirect::toRoute('admin/login');
    }

    /**
     * @return view
     * return change password view
     */
    public function getChangePasswordPage(){
        if(!Session::has("adminid"))
            return Redirect::toRoute('base/index');
        $user = User::find(Session::get('adminid'));
        return View::make('admin.changePassword', ["user" => $user]);
    }

    /**
     * @return view
     * 
     * change password of an admin
     */
    public function changePassword(){
        if(!Session::has("adminid"))
            return Redirect::toRoute('base/index');
        $user = User::find(Session::get('adminid'));
        if(Post::has("newPass")){
            if(Post::has("repeatPass")){
                $newPass = Post::get('newPass');
                if(strlen($newPass) <= 30 && strlen($newPass) >= 3){
                    $repeatPass = Post::get('repeatPass');
                    if($newPass === $repeatPass){
                        if(!$user->checkPassword($newPass)){
                            $newPassHash = password_hash($newPass, PASSWORD_DEFAULT);
                            $user->update_attributes(array('pass' => $newPassHash));                
                            return View::make(
                                'admin.changePassword', 
                                [
                                    "user" => $user,
                                    "passwordChanged" => (object)[
                                        'errors' => "PassWord has been updated!"
                                    ]
                                ]
                            );
                        }else{
                            return View::make('admin.changePassword', ["user" => $user,"erroPassSameAsOld" => (object)['errors' => "You have to change the password to one different password from the old one!"]]);
                        }
                    }else{
                        return View::make('admin.changePassword', ["user" => $user,"erroPassNotTheSame" => (object)['errors' => "The 2 passwords must match!"]]);
                    }
                }else{
                    return View::make('admin.changePassword', ["user" => $user,"erroLenghtPass" => (object)['errors' => "The must lenght must be between 3 and 30!"]]);
                }
            }else{
                return View::make('admin.changePassword', ["user" => $user,"erroRepeatPass" => (object)['errors' => "You have to fill this field!2"]]);
            }
        }else{
            return View::make('admin.changePassword', ["user" => $user,"erroNewPass" => (object)['errors' => "You have to fill this field!1"]]);
        }
    }

    public function redirectToUsers(){
        if(!Session::has("adminid"))
            return Redirect::toRoute('base/index');
        return View::make('admin.index', ["users" => adminController::getUsers()]);
    }

}