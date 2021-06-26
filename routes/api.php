<?php

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(["prefix" => "v1/auth", "middleware" => "api"], function () {
    Route::get("check","Auth\AuthController@check");
    Route::post("login", "Auth\AuthController@login")->name("login");
    Route::post("logout", "Auth\AuthController@logout")->name("logout");
    Route::post("refresh", "Auth\AuthController@refresh");
});

Route::group(["prefix" => "v1", "middleware" => "api.auth"], function() {
    Route::resource("users", "UserController");
    Route::resource("roles", "RoleController")->except(['create']);
});
