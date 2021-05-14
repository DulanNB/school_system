<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return redirect('login');
});


Route::group(['middleware' =>['auth','admin']],function() {

Route::get('/student_index', 'StudentController@index')->name('student.index');
Route::get('/student_create', 'StudentController@create')->name('student.create');
Route::post('/student_store', 'StudentController@store')->name('student.store');
Route::get('/student_edit/{id}', 'StudentController@edit')->name('student.edit');
Route::delete('/student_destroy/{id}', 'StudentController@destroy')->name('student.destroy');
Route::patch('/student_update/{id}', 'StudentController@update')->name('student.update');

Route::get('/student_enroll_view/{id}', 'StudentController@enroll_view')->name('student.enroll_view');
Route::get('/student_course_view/{id}', 'StudentController@course_view')->name('student.course_view');
Route::post('/student_enroll/{id}', 'StudentController@enroll')->name('student.enroll');


Route::get('/course_index', 'CourseController@course_index')->name('course.index');
Route::get('/course_create', 'CourseController@course_create')->name('course.create');
Route::post('/course_store', 'CourseController@course_store')->name('course.store');
Route::delete('/course_destroy/{id}', 'CourseController@course_destroy')->name('course.destroy');


});

Auth::routes();


