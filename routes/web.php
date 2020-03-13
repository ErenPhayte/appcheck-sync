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
use Inqbate\Unfuddle;

Route::get('/', function () {


//    $connection = new Unfuddle\Connection('https://bitscube.unfuddle.com/', 'jsteynr11f808' , 'Ph@3nix2019');
//    $unfuddle = new Unfuddle\Client($connection);
//
//
//    $data = $unfuddle->people();



    $connection = new Appcheck\Connection('e5364ab8c6cd70fbb039c33aa2404b55');
    $appcheck = new Appcheck\Client($connection);

    $data = $appcheck->scan()->all();

    dump($data);

    $data = $appcheck->scan()->profiles();

    dump($data);

    $data = $appcheck->scan('122f5c9b23284dfb')->status();

    dump($data);

    $data = $appcheck->scan('122f5c9b23284dfb');

    dump($data);

    $data = $appcheck->scan('122f5c9b23284dfb')->run()->all();

    dump($data);

    $data = $appcheck->scan('122f5c9b23284dfb')->run('365fb831eb234976');

    dump($data);

    //$data = $appcheck->scan('122f5c9b23284dfb')->run('365fb831eb234976d')->delete();

  // dump($data->debug());

    $data = $appcheck->vulnerability()->all();

    dump($data);

    $data = $appcheck->scan('122f5c9b23284dfb')->vulnerability()->all();

    dump($data);

    $data = $appcheck->scan('122f5c9b23284dfb')->run('365fb831eb234976')->vulnerability()->all();

    dump($data);

//
//    $data = $appcheck->scan()->create([
//        'name' => 'api test',
//        'targets' => 'https://inqbate.com'
//    ]);
//
//    dd($data);

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
