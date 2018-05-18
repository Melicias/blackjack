<?php
use ArmoredCore\Controllers\BaseController;
use ArmoredCore\WebObjects\Redirect;
use ArmoredCore\WebObjects\Session;
use ArmoredCore\WebObjects\View;
use ArmoredCore\WebObjects\Post;

class jackpot10Controller extends BaseController
{
    public function index(){
        //CODE
        $jackpots = Jackpot::find('all',array('order' => 'value_won desc'));

        return View::make('base.jackpot10', ['jackpots' => $jackpots]);
    }
}