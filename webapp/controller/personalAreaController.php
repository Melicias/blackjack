<?php
use ArmoredCore\Controllers\BaseController;
use ArmoredCore\WebObjects\Redirect;
use ArmoredCore\WebObjects\Session;
use ArmoredCore\WebObjects\View;
use ArmoredCore\WebObjects\Post;

class personalAreaController extends BaseController
{
    public function index(){
        //CODE
        $userid = Session::get('userid');
        //know if this is right
        //check with teacher
        //Session::destroy();
        //Session::set('userid',$userid);

        
        return View::make('base.personalArea');
    }
}