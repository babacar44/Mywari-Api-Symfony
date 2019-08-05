<?php

/**
 * This file has been auto-generated
 * by the Symfony Routing Component.
 */

return [
    false, // $matchHost
    [ // $staticRoutes
        '/api/addcompte' => [[['_route' => 'creer_compte', '_controller' => 'App\\Controller\\CompteController::creer'], null, ['POST' => 0], null, false, false, null]],
        '/api/depot' => [[['_route' => 'depot', '_controller' => 'App\\Controller\\DepotController::deposer'], null, null, null, false, false, null]],
        '/api/partenaire' => [[['_route' => 'partenaire', '_controller' => 'App\\Controller\\PartenaireController::createPartenaire'], null, ['POST' => 0], null, false, false, null]],
        '/api/inscription' => [[['_route' => 'admin_register', '_controller' => 'App\\Controller\\UserController::register'], null, ['POST' => 0], null, false, false, null]],
        '/api/login' => [
            [['_route' => 'api_login', '_controller' => 'App\\Controller\\UserController::login'], null, ['POST' => 0], null, false, false, null],
            [['_route' => 'api_login_check'], null, null, null, false, false, null],
        ],
        '/api/profile' => [[['_route' => 'api_profile', '_controller' => 'App\\Controller\\UserController::profile'], null, null, null, false, false, null]],
        '/api' => [[['_route' => 'api_home', '_controller' => 'App\\Controller\\UserController::home'], null, null, null, true, false, null]],
        '/admin' => [[['_route' => 'easyadmin', '_controller' => 'EasyCorp\\Bundle\\EasyAdminBundle\\Controller\\AdminController::indexAction'], null, null, null, true, false, null]],
        '/logout' => [[['_route' => 'api_logout'], null, null, null, false, false, null]],
    ],
    [ // $regexpList
        0 => '{^(?'
                .'|/api(?'
                    .'|(?:/(index)(?:\\.([^/]++))?)?(*:42)'
                    .'|/(?'
                        .'|docs(?:\\.([^/]++))?(*:72)'
                        .'|contexts/(.+)(?:\\.([^/]++))?(*:107)'
                    .')'
                .')'
            .')/?$}sDu',
    ],
    [ // $dynamicRoutes
        42 => [[['_route' => 'api_entrypoint', '_controller' => 'api_platform.action.entrypoint', '_format' => '', '_api_respond' => 'true', 'index' => 'index'], ['index', '_format'], null, null, false, true, null]],
        72 => [[['_route' => 'api_doc', '_controller' => 'api_platform.action.documentation', '_format' => '', '_api_respond' => 'true'], ['_format'], null, null, false, true, null]],
        107 => [
            [['_route' => 'api_jsonld_context', '_controller' => 'api_platform.jsonld.action.context', '_format' => 'jsonld', '_api_respond' => 'true'], ['shortName', '_format'], null, null, false, true, null],
            [null, null, null, null, false, false, 0],
        ],
    ],
    null, // $checkCondition
];
