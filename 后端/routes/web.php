<?php


Route::get('/', function () {
    return view('welcome');
});

Route::get('/test',function (){
   $c = new \App\Supplier\executeOrder();
   $c->index();
});