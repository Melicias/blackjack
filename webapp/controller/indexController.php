<?php
use ArmoredCore\Controllers\BaseController;
use ArmoredCore\WebObjects\Redirect;
use ArmoredCore\WebObjects\Session;
use ArmoredCore\WebObjects\View;

class indexController extends BaseController
{
    /**
     * @return view
     */
    public function index(){
        if(Session::has("userid")){
            $user = User::find(Session::get('userid'));
            if($user->block == 1)
                return View::make('base.block');
        }
        return View::make('base.index');
    }
}