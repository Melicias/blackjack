<?php
/**
 * Created by PhpStorm.
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
Router::get('base/play',             'gameController/index');
Router::get('base/jackpot10',        'jackpot10Controller/index');

Router::get('base/personalArea',     'personalAreaController/index');
Router::POST('money/addFunds',       'personalAreaController/addFunds');

Router::POST('bets/bet',             'gameController/bet');
Router::POST('bets/stand',           'gameController/stand');
Router::POST('bets/hit',             'gameController/hit');
Router::POST('bets/double',          'gameController/double');
Router::POST('bets/surrender',       'gameController/surrender');


Router::get('admin/',                'adminController/login');
Router::get('admin/login',           'adminController/login');
Router::get('admin/users',           'adminController/users');
Router::get('admin/admins',          'adminController/admins');
Router::get('admin/logout',          'adminController/logout');
Router::get('admin/changePassword',  'adminController/getChangePasswordPage');
Router::POST('admin/login',          'adminController/afterLogin');
Router::POST('admin/block',          'adminController/block');
Router::POST('admin/changePassword', 'adminController/changePassword');
Router::POST('admin/users',          'adminController/redirectToUsers');

Router::get('base/profile',          'profileController/index');
Router::POST('base/profile',         'profileController/changeUser');

Router::get('base/block',            'blockController/index');
Router::POST('block/unblock',        'blockController/unblock');

/************** End of URLEncoder Routing Rules ************************************/