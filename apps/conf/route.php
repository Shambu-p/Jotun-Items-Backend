<?php

use Absoft\Line\Core\HTTP\JSONResponse;
use Absoft\Line\Core\HTTP\Route;
use Application\Controllers\CategoriesController;
use Application\Controllers\DepartmentsController;
use Application\Controllers\DevicesController;
use Application\Controllers\ReceiveController;
use Application\Controllers\TestController;
use Application\Controllers\UsersController;


//Administration::routes();

Route::get("/home/:hello", [new TestController(), 'show']);
Route::get("/view", [new TestController(), 'view']);
Route::get("/save", [new TestController(), 'save']);
Route::get("/", "/first_page");
Route::get("/about_us", "/about_us");


Route::get("/api/problem", function($request){
    $response = new JSONResponse();
    $response->prepareData(["first" => "working"]);
    return $response;
});
Route::get("/api/devices", [new DevicesController(), 'show']);
Route::post("/api/devices/add", [new DevicesController(), 'save']);
Route::post("/api/devices/edit", [new DevicesController(), 'update']);
Route::post("/api/device", [new DevicesController(), 'view']);

Route::get("/api/users", [new UsersController(), 'show']);
Route::post("/api/users/add", [new UsersController(), 'save']);
Route::post("/api/user/view", [new UsersController(), 'view']);
Route::post("/api/users/edit", [new UsersController(), 'update']);

Route::post("/api/receive/new", [new ReceiveController(), 'save']);
Route::get("/api/receives", [new ReceiveController(), 'show']);

Route::get("/api/categories", [new CategoriesController(), 'show']);
Route::post("/api/categories/add", [new CategoriesController(), 'save']);

Route::get("/api/departments", [new DepartmentsController(), 'show']);
Route::post("/api/departments/add", [new DepartmentsController(), 'save']);

Route::get("/404", "/not_found");
Route::get("/api/404", function ($request){
    $response = new JSONResponse();
    $response->prepareError("route not found");
    return $response;
});