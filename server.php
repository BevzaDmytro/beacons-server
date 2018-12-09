<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 08.12.2018
 * Time: 22:38
 */

require_once "vendor/autoload.php";
require_once "SimpleAPI.php";


$router = new \Klein\Klein();

$router->respond("GET", '/beacons-server/api/beacons', [new SimpleAPI(), 'getBeacons']);
$router->respond("GET", '/beacons-server/api/notes', [new SimpleAPI(), 'getNotes']);
$router->respond("GET", '/beacons-server/api/note/[i:id]', function ($request){
    $api = new SimpleAPI();
    $api->getNote($request->id);
});
$router->respond('DELETE', '/beacons-server/api/note/[i:id]', function ($request){
    $api = new SimpleAPI();
    $api->deleteNote($request->id);
});
$router->respond('POST', '/beacons-server/api/note', [new SimpleAPI(), 'addNote']);
$router->respond('PUT', '/beacons-server/api/note/[i:id]', function ($request){
    $api = new SimpleAPI();
    $api->editNote($request->id);
});
$router->respond('GET', '/beacons-server/api/beacon/[i:id]', function ($request){
    $api = new SimpleAPI();
    $api->getNotesForBeacon($request->id);
});


$router->respond("GET", "/beacons-server/test", function (){
    echo "123";});

$router->dispatch();