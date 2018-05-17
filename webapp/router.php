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
Router::get('base/play',            'gameController/index');
Router::get('base/jackpot10',        'jackpot10Controller/index');
Router::get('base/personalArea',     'PersonalAreaController/index');

Router::POST('bets/bet',             'gameController/bet');
Router::POST('bets/stand',           'gameController/stand');
Router::POST('bets/hit',             'gameController/hit');
Router::POST('bets/double',          'gameController/double');
Router::POST('bets/surrender',       'gameController/surrender');











/************** End of URLEncoder Routing Rules ************************************/