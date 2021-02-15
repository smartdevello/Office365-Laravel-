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


Route::get("SaveRecord", 'UserController@SaveRecord');

Route::get("dashboard", 'UserController@Dashboard');
Route::get("ReadNoti", 'UserController@ReadNoti');

Route::get('personal_move_plan/{id?}','PersonalController@Load');
Route::get('pmp-request','ApprovalController@View');

Route::get('packing-material','PackingMaterialController@View');
Route::get('change-delivery-confirm','PackingMaterialController@Status');

Route::get("ApprovePMP", "ApprovalController@ApprovePMP");
Route::get('change-approval-confirm','ApprovalController@Status');


Route::post('/save-edit', 'PersonalController@editsave');
Route::get("GetDistance", 'PersonalController@GetDistance');
Route::get("CreateQuote", 'PersonalController@CreateQuote');
Route::get("DeleteQuote", 'PersonalController@DeleteQuote');


Route::get("MailQuote", 'PersonalController@MailQuote');
Route::get("MailInvoice", 'InvoiceController@ViewInvoice');
Route::post("SendMailQuote", 'PersonalController@SendMailQuote');


Route::get("ValidateQuote", "PersonalController@ValidateQuote");
Route::any("ValidateClient", "PersonalController@ValidateClient");

Route::get("ValidateServiceMatch", "PersonalController@ValidateQuote");

Route::get("DriverQuote", "PersonalController@DriverQuoteView");
Route::post("change-status", 'PersonalController@ChangeQuoteStatus');


Route::get('/', 'UserController@CheckLogin');

Route::post("DoLogin", 'UserController@DoLogin');
Route::get("logout", 'UserController@Logout');

Route::get("live-calendar", 'CalendarController@LiveCalendar');
Route::any("operation-calendar", 'OperationCalendarController@LiveCalendar');

Route::get("MakeClientPayment", "PaymentController@PayClient");
Route::get("PaymentSuccess", "PaymentController@PaymentSuccess");

/*
|--------------------------------------------------------------------------
| Jobsheet Related Routes
|--------------------------------------------------------------------------
*/

Route::get("Jobhseet", "JobsheetController@JobhseetView");
Route::post("SaveSign", "JobsheetController@SaveSign");

/*
|--------------------------------------------------------------------------
| Account Manager Related Routes
|--------------------------------------------------------------------------
*/

Route::get("AccountManager", 'AccountManagerController@View');
Route::get("AccountManager/Add", function(){
	$Title = "Add Users";
	return view("AccountManagers.add", compact("Title"));
});
Route::post("AccountManager/SaveAdd", 'AccountManagerController@SaveAdd');
Route::get("AccountManager/Edit/{ID}", 'AccountManagerController@Edit');
Route::post("AccountManager/SaveEdit", 'AccountManagerController@SaveEdit');
Route::get("AccountManager/Delete/{ID}", 'AccountManagerController@Delete');
Route::post("SaveFCM", 'AccountManagerController@SaveFCM');
Route::get("SendNotification", 'AccountManagerController@SendNotification');

/*
|--------------------------------------------------------------------------
| Vans Related Routes
|--------------------------------------------------------------------------
*/

Route::get("vans", 'VanController@View');
Route::get("vans/Add", function(){
	$Title = "Add Vans";
	return view("Van.add", compact("Title"));
});
Route::post("vans/SaveAdd", 'VanController@SaveAdd');
Route::get("vans/Edit/{ID}", 'VanController@Edit');
Route::post("vans/SaveEdit", 'VanController@SaveEdit');
Route::get("vans/Delete/{ID}", 'VanController@Delete');


/*
|--------------------------------------------------------------------------
| Custom Quote Related Routes
|--------------------------------------------------------------------------
*/

Route::get("CustomQuote", 'CustomQuoteController@CustomQuote');
Route::post("save-custom-quote", 'CustomQuoteController@SaveCustomQuote');
Route::get("SearchRoomObject", 'CustomQuoteController@SearchRoomObject');
Route::post("UploadAudio", 'CustomQuoteController@UploadAudio');
Route::get("survey-audio", 'CustomQuoteController@AllAduio');

/*
|--------------------------------------------------------------------------
| Custom Quote Related Routes
|--------------------------------------------------------------------------
*/


/*
|--------------------------------------------------------------------------
| Service Template Related Routes
|--------------------------------------------------------------------------
*/

Route::get("ServiceTemplate", 'ServiceTemplateController@View');
Route::post("ServiceTemplateSave", 'ServiceTemplateController@Save');
Route::get("MailServiceTemplate", 'ServiceTemplateController@MailQuote');
Route::any("ServiceValidateClient", "ServiceTemplateController@ValidateClient");
Route::get("ValidateServiceMatch", "ServiceTemplateController@ValidateQuote");
Route::get("DeleteService", 'ServiceTemplateController@DeleteService');


/*
|--------------------------------------------------------------------------
| Service Template Related Routes
|--------------------------------------------------------------------------
*/






/*
|--------------------------------------------------------------------------
| Appointment Related Routes
|--------------------------------------------------------------------------
*/

Route::get("appointment-calendar", 'AppintmentCalenadarController@View');
Route::post("SaveAppointment", 'AppintmentCalenadarController@Save');



/*
|--------------------------------------------------------------------------
| Appointment Related Routes
|--------------------------------------------------------------------------
*/



/*
|--------------------------------------------------------------------------
| Driver Salary Related Routes
|--------------------------------------------------------------------------
*/


Route::get("driver-salary", 'DriverSalaryController@View');
Route::post("SaveExpenses", 'DriverSalaryController@SaveExpenses');
Route::get("ExpensesDelete/{ID}", 'DriverSalaryController@ExpensesDelete');
Route::post("EditExpenses", 'DriverSalaryController@EditExpenses');
Route::get("pdf-salary", 'DriverSalaryController@PDFSalary');


/*
|--------------------------------------------------------------------------
| Driver Salary Related Routes
|--------------------------------------------------------------------------
*/


/*
|--------------------------------------------------------------------------
| Email Routes
|--------------------------------------------------------------------------
*/

Route::get("email", '\App\Http\Controllers\EmailController@read');
Route::get("email/noclient", '\App\Http\Controllers\EmailController@noclient');
Route::get("email/noclient/edit/{id}", ['uses' => '\App\Http\Controllers\EmailController@noclient_edit', 'as' => 'noclient-edit']);
Route::put("email/noclient/edit/{id}", ['uses' => '\App\Http\Controllers\EmailController@noclient_update', 'as' => 'noclient_update']);

Route::get("email/ignored_email", '\App\Http\Controllers\EmailController@ignored_email');
Route::put("email/ignored_email/edit/{id}", ['uses' => '\App\Http\Controllers\EmailController@ignored_email_update', 'as' => 'ignored_email_update']);
Route::post('email/ignored_email/create', '\App\Http\Controllers\EmailController@ignored_email_create');
Route::delete('/email/ignored_email/delete/{id}', ['uses' => '\App\Http\Controllers\EmailController@ignored_email_delete', 'as' => 'ignored_email_delete']);
