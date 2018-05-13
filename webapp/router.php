<?php
/**
 * Created by PhpStorm.
 * User: smendes
 * Date: 02-05-2016
 * Time: 11:18
 */
use ArmoredCore\Facades\Router;

/****************************************************************************
 *  URLEncoder/HTTPRouter Routing Rules
 *  Use convention: controllerName@methodActionName
 ****************************************************************************/

Router::get('/',                     'indexController/index');
Router::get('base/index',            'indexController/index');

Router::get('base/regist_login',     'registerLoginController/regist_login');
Router::POST('base/login',           'registerLoginController/login');
Router::POST('base/registo',         'registerLoginController/regist_login_made');

Router::get('base/logout',           'registerLoginController/logout');
Router::get('base/jogar',            'gameController/index');

Router::POST('base/bet',             'gameController/bet');









/************** End of URLEncoder Routing Rules ************************************/