<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

 
// some of methods below are for administrator-only and some for everyone

$routes->match(['get','post'],      '/',                         'AuthController::index',        ['filter' => 'noauth']);

$routes->get('logout', 'AuthController::logout');
$routes->match(['get','post'],      'register',                  'AuthController::register',     ['filter' => 'noauth']);
$routes->match(['get','post'],      'profile',                   'AuthController::profile',      ['filter' => 'auth']);

$routes->get('dashboard', 'Dashboard::index',['filter' => 'auth']);
// users
    $routes->match(['get','post'],  'users',                     'Users::index',                 ['filter' => ['auth', 'usermoderator'] ]);
    $routes->match(['get','post'],  'users/info/(:segment)',     'Users::info/$1',               ['filter' => ['auth', 'usermoderator'] ]);
    // edit
    $routes->match(['get','post'],  'users/edit/(:segment)',     'Users::edit/$1',               ['filter' => ['auth', 'usermoderator'] ]);
    $routes->match(['get','post'],  'users/decrease_privileges/(:segment)', 'Users::decrease_privileges/$1', ['filter' => ['auth', 'usermoderator'] ]);
    $routes->match(['get','post'],  'users/increase_privileges/(:segment)', 'Users::increase_privileges/$1', ['filter' => ['auth', 'usermoderator'] ]);
    $routes->match(['get','post'],  'users/delete_confirm/(:segment)', 'Users::delete_confirm/$1', ['filter' => ['auth', 'usermoderator'] ]);
    // add

// buildings
    $routes->match(['get','post'],  'buildings',                 'Buildings::index',             ['filter' => ['auth']]);
    $routes->match(['get','post'],  'buildings/info/(:segment)', 'Buildings::info/$1',           ['filter' => ['auth'] ]);
    $routes->match(['get','post'],  'buildings/add',             'Buildings::add',               ['filter' => ['auth', 'usermoderator'] ]);
    $routes->match(['get','post'],  'buildings/edit/(:segment)', 'Buildings::edit/$1',           ['filter' => ['auth', 'usermoderator'] ]);
    $routes->match(['get','post'],  'buildings/delete_confirm/(:segment)', 'Buildings::delete_confirm/$1',  ['filter' => ['auth', 'usermoderator'] ]);

// rooms
    $routes->match(['get','post'],  'rooms',                     'Rooms::index',                 ['filter' => ['auth']]);
    $routes->match(['get','post'],  'rooms/by_building/(:segment)', 'Rooms::by_building/$1',     ['filter' => ['auth'] ]              );
    // add data
    $routes->match(['get','post'],  'rooms/add',                 'Rooms::add',                   ['filter' => ['auth', 'usermoderator'] ]    );
    $routes->match(['get','post'],  'rooms/add/(:segment)',      'Rooms::add/$1',                ['filter' => ['auth', 'usermoderator'] ]    );
    $routes->match(['get','post'],  'rooms/(:segment)/add_slot', 'Rooms::add_slot/$1',           ['filter' => ['auth', 'usermoderator'] ]    );
    $routes->match(['get','post'],  'rooms/(:segment)/add_slot/(:segment)', 'Rooms::add_slot/$1/$2', ['filter' => ['auth', 'usermoderator'] ]);
    // info
    $routes->match(['get','post'],  'rooms/info/(:segment)',     'Rooms::info/$1',               ['filter' => ['auth'] ]);
    // edit
    $routes->match(['get','post'],  'rooms/edit/(:segment)',     'Rooms::edit/$1',               ['filter' => ['auth', 'usermoderator'] ]    );
    // delete
    $routes->match(['get','post'],  '/rooms/delete_slot_confirm/(:segment)',  'Rooms::delete_slot_confirm/$1',  ['filter' => ['auth', 'usermoderator'] ] );
    $routes->match(['get','post'],  '/rooms/delete_room_confirm/(:segment)',  'Rooms::delete_room_confirm/$1',  ['filter' => ['auth', 'usermoderator'] ] );

// room types
    $routes->match(['get','post'],  'roomtypes',                 'Roomtypes::index',             ['filter' => ['auth']]                      );
    // add
    $routes->match(['get','post'],  'roomtypes/add/',            'Roomtypes::add',               ['filter' => ['auth', 'usermoderator'] ]    );
    // edit
    $routes->match(['get','post'],  'roomtypes/edit/(:segment)', 'Roomtypes::edit/$1',           ['filter' => ['auth', 'usermoderator'] ]    );
    $routes->match(['get','post'],  'roomtypes/delete_confirm/(:segment)', 'Roomtypes::delete_confirm/$1',  ['filter' => ['auth', 'usermoderator'] ]    );


// reservations
    $routes->match(['get','post'],  'reservations',              'Reservations::index',          ['filter' => ['auth'] ]                     );
    // $routes->match(['get','post'],  'reservations/filtering',    'Reservations::filtering',      ['filter' => ['auth', 'usermoderator'] ]    );
    $routes->match(['get','post'],  'reservations/monthly',      'Reservations::monthly',        ['filter' => ['auth', 'usermoderator'] ]    );
    $routes->match(['get','post'],  'reservations/by_user/',     'Reservations::by_user/',       ['filter' => ['auth', 'usermoderator'] ]    );
    $routes->match(['get','post'],  'reservations/by_filter',    'Reservations::by_filter',      ['filter' => ['auth', 'usermoderator'] ]    );
    $routes->match(['get','post'],  'reservations/filter_settings', 'Reservations::filter_settings',   ['filter' => ['auth', 'usermoderator'] ]    );
    $routes->match(['get','post'],  'reservations/add',          'Reservations::add',            ['filter' => ['auth', 'usermoderator'] ]    );
    $routes->match(['get','post'],  'reservations/add_details',  'Reservations::add_details',    ['filter' => ['auth', 'usermoderator'] ]    );
    $routes->match(['get','post'],  'reservations/add_pricing',  'Reservations::add_pricing',    ['filter' => ['auth', 'usermoderator'] ]    );
    $routes->match(['post'],        'reservations/add_final',    'Reservations::add_final',      ['filter' => ['auth', 'usermoderator'] ]    );
    $routes->match(['get','post'],  'reservations/info/(:segment)',   'Reservations::info/$1',   ['filter' => ['auth', 'usermoderator'] ]    );
    $routes->match(['get','post'],  'reservations/edit/(:segment)',   'Reservations::edit/$1',   ['filter' => ['auth', 'usermoderator'] ]    );
    $routes->match(['get','post'],  'reservations/delete_confirm/(:segment)',   'Reservations::delete_confirm/$1',   ['filter' => ['auth', 'usermoderator'] ]    );


// get JSONs 
    $routes->match(['get'],  'get_rooms_of_building/(:segment)',   'GetJsonController::get_rooms_of_building/$1',   ['filter' => ['auth', 'usermoderator'] ]    );
    $routes->match(['get'],  'get_slots_by_room_number_by_building_id/(:segment)/(:segment)',   'GetJsonController::get_slots_by_room_number_by_building_id/$1/$2',   ['filter' => ['auth', 'usermoderator'] ]    );
    $routes->match(['get'],  'calculate_end_date/(:segment)/(:segment)',   'GetJsonController::calculate_end_date/$1/$2',   ['filter' => ['auth', 'usermoderator'] ]    );



// 