<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Blade\UserController;
use App\Http\Controllers\Blade\RoleController;
use App\Http\Controllers\Blade\PermissionController;
use App\Http\Controllers\Blade\HomeController;
use App\Http\Controllers\Blade\ApiUserController;
use App\Http\Controllers\Blade\GroupController;
use App\Http\Controllers\Blade\AmountController;
use App\Http\Controllers\Blade\StudentController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\GraphicController;
/*
|--------------------------------------------------------------------------
| Blade (front-end) Routes
|--------------------------------------------------------------------------
|
| Here is we write all routes which are related to web pages
| like UserManagement interfaces, Diagrams and others
|
*/

// Default laravel auth routes
Auth::routes();


// Welcome page
Route::get('/', function (){
    return redirect()->route('home');
})->name('welcome');

// Web pages
Route::group(['middleware' => 'auth'],function (){


    //Attendance
    Route::get('attendance',[AttendanceController::class,'index'])->name('attendanceIndex');
    Route::post('attendance/create',[AttendanceController::class,'create'])->name('attendanceCreate');
    Route::get('inspection/group',[AttendanceController::class,'show'])->name('inspectionIndex');
    Route::post('inspection/group',[AttendanceController::class,'filter'])->name('filterGroup');
    Route::get('inspection/student',[AttendanceController::class, 'filterShowStudent'])->name('filterShowStudent');
    Route::post('inspection/student',[AttendanceController::class, 'filterStudent'])->name('filterStudent');

    Route::get('inspection/group/{id}',[AttendanceController::class,'selected']);
    //Teacher
    Route::get('teacher',[TeacherController::class,'index'])->name('teacherIndex');
    Route::get('teacher/add',[TeacherController::class,'add'])->name('teacherAdd');
    Route::post('teacher/create',[TeacherController::class,'create'])->name('teacherCreate');
    Route::get('teacher/{id}/edit',[TeacherController::class,'edit'])->name('teacherEdit');
    Route::post('teacher/update/{id}',[TeacherController::class,'update'])->name('teacherUpdate');
    Route::delete('teacher/delete/{id}',[TeacherController::class,'destroy'])->name('teacherDestroy');

    //Student
    Route::get('students',[StudentController::class,'index'])->name('studentIndex');
    Route::get('students/add',[StudentController::class,'add'])->name('studentAdd');
    Route::post('students/create',[StudentController::class,'create'])->name('studentCreate');
    Route::get('students/{id}/edit',[StudentController::class,'edit'])->name('studentEdit');
    Route::post('students/update/{id}',[StudentController::class,'update'])->name('studentUpdate');
    Route::delete('students/delete/{id}',[StudentController::class,'destroy'])->name('studentDestroy');
    Route::get('students/graphic', [StudentController::class, 'graphicAdd'])->name('graphicStudentAdd');

    //Amount
    Route::get('amounts',[AmountController::class,'index'])->name('amountIndex');
    Route::get('amounts/add',[AmountController::class,'add'])->name('amountAdd');
    Route::post('amounts/create',[AmountController::class,'create'])->name('amountCreate');
    Route::get('amounts/{id}/edit',[AmountController::class,'edit'])->name('amountEdit');
    Route::post('amounts/update/{id}',[AmountController::class,'update'])->name('amountUpdate');
    Route::delete('amounts/delete/{id}',[AmountController::class,'destroy'])->name('amountDestroy');
    //Graphic
    Route::get('graphics',[GraphicController::class,'index'])->name('graphicIndex');
    Route::get('graphics/{id}/students',[GraphicController::class,'graphicStudents'])->name('graphicStudents');
    Route::get('graphics/{id}/add',[GraphicController::class,'add'])->name('graphicAdd');
    Route::post('graphics/create',[GraphicController::class,'create'])->name('graphicCreate');
    Route::get('graphics/{id}/edit',[GraphicController::class,'edit'])->name('graphicEdit');
    Route::post('graphics/update/{id}',[GraphicController::class,'update'])->name('graphicUpdate');
    Route::delete('graphics/delete/{id}',[GraphicController::class,'destroy'])->name('graphicDestroy');
    Route::get('graphics/pay/{id}',[GraphicController::class,'graphicPay'])->name('graphicPay');
    Route::get('graphics/all', [GraphicController::class, 'graphicAll'])->name('graphicAll');
    Route::get('graphics/history', [GraphicController::class, 'graphicHistory'])->name('graphicHistory');
    Route::get('graphic-export/{id}', [GraphicController::class, 'export'])->name('excelExport');
    //Groups
    Route::get('groups',[GroupController::class,'index'])->name('groupIndex');
    Route::get('groups/add',[GroupController::class,'add'])->name('groupAdd');
    Route::post('groups/create',[GroupController::class,'create'])->name('groupCreate');
    Route::get('groups/{id}/edit',[GroupController::class,'edit'])->name('groupEdit');
    Route::post('groups/update/{id}',[GroupController::class,'update'])->name('groupUpdate');
    Route::delete('groups/delete/{id}',[GroupController::class,'destroy'])->name('groupDestroy');
    // there should be graphics, diagrams about total conditions
    Route::get('/home', [HomeController::class,'index'])->name('home');
    // Users
    Route::get('/users',[UserController::class,'index'])->name('userIndex');
    Route::get('/user/add',[UserController::class,'add'])->name('userAdd');
    Route::post('/user/create',[UserController::class,'create'])->name('userCreate');
    Route::get('/user/{id}/edit',[UserController::class,'edit'])->name('userEdit');
    Route::post('/user/update/{id}',[UserController::class,'update'])->name('userUpdate');
    Route::delete('/user/delete/{id}',[UserController::class,'destroy'])->name('userDestroy');
    Route::get('/user/theme-set/{id}',[UserController::class,'setTheme'])->name('userSetTheme');

    // Permissions
    Route::get('/permissions',[PermissionController::class,'index'])->name('permissionIndex');
    Route::get('/permission/add',[PermissionController::class,'add'])->name('permissionAdd');
    Route::post('/permission/create',[PermissionController::class,'create'])->name('permissionCreate');
    Route::get('/permission/{id}/edit',[PermissionController::class,'edit'])->name('permissionEdit');
    Route::post('/permission/update/{id}',[PermissionController::class,'update'])->name('permissionUpdate');
    Route::delete('/permission/delete/{id}',[PermissionController::class,'destroy'])->name('permissionDestroy');

    // Roles
    Route::get('/roles',[RoleController::class,'index'])->name('roleIndex');
    Route::get('/role/add',[RoleController::class,'add'])->name('roleAdd');
    Route::post('/role/create',[RoleController::class,'create'])->name('roleCreate');
    Route::get('/role/{role_id}/edit',[RoleController::class,'edit'])->name('roleEdit');
    Route::post('/role/update/{role_id}',[RoleController::class,'update'])->name('roleUpdate');
    Route::delete('/role/delete/{id}',[RoleController::class,'destroy'])->name('roleDestroy');

    // ApiUsers
    Route::get('/api-users',[ApiUserController::class,'index'])->name('api-userIndex');
    Route::get('/api-user/add',[ApiUserController::class,'add'])->name('api-userAdd');
    Route::post('/api-user/create',[ApiUserController::class,'create'])->name('api-userCreate');
    Route::get('/api-user/show/{id}',[ApiUserController::class,'show'])->name('api-userShow');
    Route::get('/api-user/{id}/edit',[ApiUserController::class,'edit'])->name('api-userEdit');
    Route::post('/api-user/update/{id}',[ApiUserController::class,'update'])->name('api-userUpdate');
    Route::delete('/api-user/delete/{id}',[ApiUserController::class,'destroy'])->name('api-userDestroy');
    Route::delete('/api-user-token/delete/{id}',[ApiUserController::class,'destroyToken'])->name('api-tokenDestroy');
});

// Change language session condition
//Route::get('/language/{lang}',function ($lang){
//    $lang = strtolower($lang);
//    if ($lang == 'ru' || $lang == 'uz')
//    {
//        session([
//            'locale' => $lang
//        ]);
//    }
//    return redirect()->back();
//});

/*
|--------------------------------------------------------------------------
| This is the end of Blade (front-end) Routes
|-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\
*/
