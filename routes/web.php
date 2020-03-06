<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
use Inqbate\Appcheck;
use Inqbate\Unfuddled;

Route::get('/', function () {


    $connection = new Unfuddle\Connection('https://bitscube.unfuddle.com/', 'jsteynr11f808' , 'Ph@3nix2019');
    $unfuddled = new Unfuddle\Client($connection);


//    $connection = new Appcheck\Connection('e5364ab8c6cd70fbb039c33aa2404b55');
//    $appcheck = new Appcheck\Client($connection);
//
//    $scans = $appcheck->scans();
//
//    dd($scans->getError());
//
//    $scans->debug();

//    $appcheck->scanprofiles();
//    $appcheck->vulnerabilities();
//
//   // $newScan = $appcheck->scan()->create([]);
//
//    $scan = $appcheck->scan(1);
//
//    $scan->update([]);
//    $scan->hubs();
//    $scan->delete();
//    $scan->start();
//    $scan->abort();
//    $scan->pause();
//    $scan->resume();
//    $scan->runs();
//    $scan->status();
//    $scan->vulnerabilities();
//
//
//    $run = $scan->run(1);
//
//    $run->vulnerabilities();
//
//    $vulnerability = $appcheck->vulnerability(1);
//
//    $vulnerability->delete();
//    $vulnerability->update([]);

});
