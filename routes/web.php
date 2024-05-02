<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\ThemeController;
use App\Http\Controllers\SpreadSheetContoller;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\SourceController;
use App\Http\Controllers\SLAController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PackageController;
use App\Http\Controllers\SPController;
use App\Http\Controllers\DataAjaxController;
use App\Http\Controllers\SeverityController;
use App\Http\Controllers\PartnerController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\ReportCOntroller;
use App\Http\Controllers\PartController;
use App\Http\Controllers\MasterController;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\VAttachmentController;
use App\Http\Controllers\PKnowledgeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\WebsiteController;
use App\Http\Controllers\BoardController;
use App\Http\Controllers\TrelloController;
use App\Http\Controllers\PICController;
use App\Http\Controllers\IssueController;
use App\Http\Controllers\LogAsController;
use App\Http\Controllers\AccomodationController;
use App\Http\Controllers\DocsController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\LogistikController;

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
Route::auth();
    Route::get('Register=HGT-Services', [RegisterController::class, 'regs']);
        Route::post('/check-username-email', [DataAjaxController::class, 'checkUsernameAndEmail'])->name('check.UserMail');
    Route::post('Add/User-HGT', [RegisterController::class, 'store']);
    Route::get('/Dashboard', [BoardController::class, 'dashboard']);
    
    Route::get('/newLogin', function () {
        return view('auth.newLogin');
    });

    Route::get('get-tickets/', [BoardController::class, 'getTickets']);
    Route::get('ticketsToday/', [BoardController::class, 'getTicketsToday']);
    Route::get('status/{tiketID}', [BoardController::class, 'getStatusDash']);
Route::group(['middleware'=>'auth'], function(){
    Route::get('/', [HomeController::class, 'main']);
    Route::get('/WhatsNews', [HomeController::class, 'wn_form']);
        Route::get('/Choose-dept', [LogAsController::class, 'vw_choose']);
        Route::PATCH('Update/Dept', [LogAsController::class, 'update_dept']);
        // Download Docs
        Route::post('/Docs-download', [HomeController::class, 'downloadDocs']);
        // Time Square Input
        Route::post('add/Timeline', [HomeController::class, 'store_wn_square'])->name('time.square');
    Route::get('ticketsTodayFD/', [DataAjaxController::class, 'getTicketsTodayFD']);

    Route::patch('/theme', [ThemeController::class, 'update']);
    Route::get('/spreadsheet', [SpreadSheetContoller::class, 'index']);
    // LOCATION AJAX
    Route::get('cities', [DataAjaxController::class,'cities'])->name('cities');
    Route::get('districts', [DataAjaxController::class,'districts'])->name('districts');
    Route::get('villages', [DataAjaxController::class,'villages'])->name('villages');
    // ENGINEER AJAX
    Route::get('engineer', [DataAjaxController::class,'engineer'])->name('engineer');
    // Type Unit AJAX
    Route::get('typeunit', [DataAjaxController::class,'typeunit'])->name('typeunit');
    // Category AJAX
    Route::get('category', [DataAjaxController::class,'category'])->name('category');
    // GetProject By Partner AJAX
    Route::get('getProjectsByPartner', [DataAjaxController::class,'get_project_partner'])->name('getProjectsByPartner');
    // Filter User KPI AJAX
    Route::get('filter/user-KPI', [DataAjaxController::class,'kpi_user'])->name('filter_user_kpi');
    // Filter Raw Data Report Ticket
    Route::get('dtProject', [DataAjaxController::class,'dtProject'])->name('GetdtProject');
    // Category Reqs AJax
    Route::get('/categories/fetch', [DataAjaxController::class, 'getCategories'])->name('fetch.category.reqs');
    // MANAGE TICKET
    Route::get('helpdesk/manage=Ticket', [TicketController::class, 'manage'])->name('manage.ticket');
        Route::post('helpdesk/manage=Ticket/sorting', [TicketController::class, 'manage'])->name('sorting.ticket');
    Route::get('helpdesk/form=TabsTicket', [TicketController::class, 'form']);
    Route::get('helpdesk/form=Ticket', [TicketController::class, 'notabs'])->name('form.ticket');
    Route::get('helpdesk/Ticket=closed', [TicketController::class, 'closed_page'])->name('ticket.closed');
        Route::post('helpdesk/ticket=Closed/sorting', [TicketController::class, 'closed_page'])->name('sorting.closed');
    Route::get('helpdesk/Ticket=Canceled', [TicketController::class, 'cancel_page'])->name('ticket.cancel');
        Route::post('helpdesk/ticket=Canceled/sorting', [TicketController::class, 'cancel_page'])->name('sorting.cancel');
    Route::get('helpdesk/Ticket=today', [TicketController::class, 'ticket_today'])->name('ticket.today');
        // Data Ajax in notabs
        Route::get('/typeTicket', [DataAjaxController::class, 'fetchTypeTicket'])->name('refresh.type.ticket');
        Route::get('/source', [DataAjaxController::class, 'fetchSource'])->name('refresh.source');
        Route::get('/sla', [DataAjaxController::class, 'fetchSLA'])->name('refresh.sla');
        Route::get('/merk', [DataAjaxController::class, 'fetchUnitMerk'])->name('refresh.merk.unit');
        Route::get('/category', [DataAjaxController::class, 'fetchUnitCategory'])->name('refresh.category.unit');
        Route::get('/partner', [DataAjaxController::class, 'fetchPartner'])->name('refresh.partner');
        Route::get('/typeOffice', [DataAjaxController::class, 'fetchTypeCompany'])->name('refresh.type.office');
        Route::get('/location', [DataAjaxController::class, 'fetchLocation'])->name('refresh.location');
        Route::get('/servicePoint', [DataAjaxController::class, 'fetchServicePoint'])->name('refresh.sp');
        Route::get('/categoryNote', [DataAjaxController::class, 'fetchTypeNote'])->name('refresh.cateogry.note');
        Route::get('/fetch-select', [DataAjaxController::class, 'fetchSelect'])->name('fetch.select');
        // Detil Ticket
        Route::get('Detail/Ticket={id}', [TicketController::class, 'detil'])->where(['id' => '.*']);
            // Add Type Unit and updated to the ticket
            Route::post('dt-Type/{notik}/Added-Updated', [TicketController::class, 'add_not_exist_dt_type'])->where(['notik' => '.*']);
            // Adding Log Note
            Route::post('Note/{notiket}/Added', [TicketController::class, 'add_note_at_detil'])->where(['notiket' => '.*']);
            // ENGINEER RECEIVE TICKET
            Route::patch('Update/{key}/Engineer-Ticket', [TicketController::class, 'update_engineer'])->where(['key' => '.*']);
            // L2 ENGINEER Update
            Route::post('Update/L2-Engineer/{key}/Ticket', [TicketController::class, 'update_l2engineer'])->where(['key' => '.*']);
            // Change ENGINEER TICKET
            Route::patch('Update/{key}/Change-Engineer', [TicketController::class, 'change_engineer'])->where(['key' => '.*']);
            // L2 Take Ticket for Supporting
            Route::patch('L2/Take-Ticket/{key}', [TicketController::class, 'l2_support'])->where(['key' => '.*']);
            // Adding Part
            Route::post('Part/{notiket}/Added', [TicketController::class, 'store_part_dt'])->where(['notiket' => '.*']);
                // Detail Part
                Route::get('Ticket/{id}/Part-Detail', [TicketController::class, 'part_detail'])->where(['id' => '.*']);
                // Update Part
                Route::patch('Update/Part/{notiket}', [TicketController::class, 'update_part_detail'])->where(['notiket' => '.*']);
                // Delete Part
                Route::delete('Delete/{id}/Part/{notiket}', [TicketController::class, 'delete_list_part'])->name('dstr.part')->where(['notiket' => '.*']);
                // PART JOURNEY
                Route::patch('Update/Part-log/{id}', [TicketController::class, 'update_journey_part'])->name('trip.part')->where(['id' => '.*']);
            // Change Status Part Reqs
            Route::patch('Update/{id}/Part-Reqs', [TicketController::class, 'update_part_after'])->where(['id' => '.*']);
            // Change Status Ticket Sending to Engineer
            Route::patch('Update/{id}/Send-to/Engineer', [TicketController::class, 'update_ticket_send_to_engineer'])->where(['id' => '.*']);
            // Update Unit
            Route::patch('Update-Unit/{id}/Detail-Ticket', [TicketController::class, 'dt_updt_unit'])->where(['id' => '.*']);
            // Reqs Reimburse 
            Route::get('preview-Attach/Reimburse/{fk}', [TicketController::class, 'previewReimburse']);
                // Download Attachment Reimburse
                Route::post('attach-Reimburse/Download/en/{fk_id}', [VAttachmentController::class, 'downloadAttachReimburse']);
                // Delete Reimburse Attach
                Route::post('delete/Reimburse/En/{id}', [VAttachmentController::class, 'deleteAttachReimburse'])->where(['id' => '.*']);
        // TIMELINE TICKET
        Route::get('Timeline/Engineer/Ticket={id}', [TicketController::class, 'timeline_engineer'])->where(['id' => '.*']);
            // ATTACHMENT ENGINEER TIMELINE
                Route::post('Add-Attachment/Engineer', [TicketController::class, 'store_attachment_engineer']);
            // ATTACHMENT L2 ENGINEER TIMELINE
                Route::post('Add/Timeline-Note/L2-Engineer', [TicketController::class, 'store_attachment_l2engineer']);
        // TIMELINE L2TICKET
        Route::get('Timeline/L2-Engineer/Ticket={id}', [TicketController::class, 'timeline_L2engineer'])->where(['id' => '.*']);
        // ~ Buat Ticket
        Route::post('Create/Ticket-HGT', [TicketController::class, 'add_ticket']);
            // Attachment file
            Route::post('File-Attachment/upload', [TicketController::class, 'attachment_file'])->name('File-Attachment.upload');
            // Download File Ticket
            Route::post('Attach-download/File-Ticket/{id}', [VAttachmentController::class, 'downloadFileTicket']);
            // Attachment Upload ADM
                Route::post('Add-Attachment/ADM/{id}', [TicketController::class, 'store_attach_adm'])->where(['id' => '.*']);
                // Download File Uploaded ADM
                Route::post('uploaded-download/ADM/{id}', [VAttachmentController::class, 'downloadUploadedADM']);
        // ~ Delete Ticket
        Route::delete('Remove/{id}/Ticket-HGT', [TicketController::class, 'destroy_ticket'])->where(['id' => '.*']);
        //Update Schedule Engineer
        Route::patch('Update-Ticket/Schedule/{id}', [TicketController::class, 'update_schedule_en'])->where(['id' => '.*']);
        //Update Requested Part from engineer
        Route::patch('Fulfilled/Part-Reqs/{id}', [TicketController::class, 'update_part_ready'])->where(['id' => '.*']);
        //Update End User for Ticket
        Route::patch('update/End-User/{id}', [TicketController::class, 'updt_end_user'])->where(['id' => '.*']);
        // Close Ticket Instant
        Route::patch('Close/Ticket/{id}', [TicketController::class, 'updt_close_instant'])->where(['id' => '.*']);
        // Cancle Ticket
        Route::patch('Ticket-Cancle/{id}', [TicketController::class, 'cancle_ticket'])->where(['id' => '.*']);
        // Open Ticket From CLosed
        Route::patch('Return/Ticket/{id}', [TicketController::class, 'prev_sts_ticket'])->where(['id' => '.*']);
        // Remove Engineer
        Route::patch('Remove-Engineer/Ticket/{id}', [TicketController::class, 'remove_en_dt'])->where(['id' => '.*']);
        //Update Schedule Engineer
        Route::patch('Change-SLA/Ticket={key}', [TicketController::class, 'updt_sla'])->where(['key' => '.*']);
        // Delete Log Note Ticket
        Route::delete('Delete/Log-Note/{id}', [TicketController::class, 'delete_dt_note']);
        // Delete Log Note Ticket
        Route::patch('edit/Log-Note/{id}', [TicketController::class, 'edt_note']);
        // Edit Case ID
        Route::patch('edit-InfoTicket/Ticket={id}', [TicketController::class, 'edt_info_ticket']);
        // ~ Duplicate Note
        Route::post('Duplicate/{id}/Note', [TicketController::class, 'store_dpl_note']);
    // END MANAGE TICKET
    // PIC
        // vw page activity
        Route::get('Data/Activity=PIC', [PICController::class, 'vw_actPIC']);
            // ~ Add Desc
            Route::post('Add/Act-Desc/PIC', [PICController::class, 'store']);
            // Edit Desc
            Route::patch('Edit/Act-Desc/{id}/PIC', [PICController::class, 'update']);
            // Delete Desc
            Route::delete('Delete/Act-Desc/{id}/PIC', [PICController::class, 'remove']);
    // END PIC
    // Form Master
        // Source
        Route::get('Master/data=Source', [SourceController::class, 'source']);
            // ~ Tambah Source, Edit, Delete
            Route::post('Add/Source-HGT', [SourceController::class, 'store']);
            Route::patch('Update/{id}/Source-HGT', [SourceController::class, 'update']);
            Route::patch('Remove/{id}/Source-HGT', [SourceController::class, 'remove']);
        // SLA
        Route::get('Master/data=SLA', [SLAController::class, 'sla']);
            // ~ Tambah SLA, Edit, Delete
            Route::post('Add/SLA-HGT', [SLAController::class, 'store']);
            Route::patch('Update/{id}/SLA-HGT', [SLAController::class, 'update']);
            Route::patch('Remove/{id}/SLA-HGT', [SLAController::class, 'remove']);
        // Project
        Route::get('Master/data=Project', [ProjectController::class, 'project']);
        Route::get('Form-Add/data=Project', [ProjectController::class, 'form_add']);
        Route::get('Edit/data=Project/{id}', [ProjectController::class, 'form_udpate']);
            // ~ Tambah Project, Edit, Delete
            Route::post('Add/Project-HGT', [ProjectController::class, 'store']);
            Route::patch('Update/{id}/Project', [ProjectController::class, 'update']);
            Route::patch('Remove/{id}/Project', [ProjectController::class, 'destroy']);
        // User
        Route::get('Master/data=User', [UserController::class, 'user']);
        Route::post('Master/data=User/sorting', [UserController::class, 'user'])->name('sorting.user');
            // ~ Tambah User, Edit, Deactivated
            Route::patch('Update/{id}/User-HGT', [UserController::class, 'verify']);
            Route::patch('Deactivated/{id}/User-HGT', [UserController::class, 'deactivated']);
        // Service Point
        Route::get('Master/data=ServicePoint', [SPController::class, 'service_point']);
            // SP-DT
            Route::get('/SP-DT', [SPController::class, 'sp_dt']);
        Route::get('Form/data=ServicePoint', [SPController::class, 'form_sp']);
        Route::get('Form/{id}/Edit=ServicePoint', [SPController::class, 'form_udpate']);
            // ~ Tambah Service Point, Edit, Delete
            Route::post('Add/data=ServicePoint', [SPController::class, 'store']);
            Route::patch('Edit/{id}/data=ServicePoint', [SPController::class, 'update']);
            Route::patch('deleted/{id}/data=ServicePoint', [SPController::class, 'destroy']);
        // Severity
        Route::get('Master/data=Severity', [SeverityController::class, 'severity']);
            // ~ Tambah Serverity, Edit, Delete
            Route::post('Add/data=Severity', [SeverityController::class, 'store']);
            Route::patch('update/{id}/data=Severity', [SeverityController::class, 'update']);
            Route::patch('remove/{id}/data=Severity', [SeverityController::class, 'remove']);
        // Partner
        Route::get('Master/data=Partner', [PartnerController::class, 'partner']);
        Route::get('Form/Partner', [PartnerController::class, 'form']);
        Route::get('Form=edit/{id}/Partner', [PartnerController::class, 'form_patch']);
            // ~ Tambah Partner, Edit, Delete
            Route::post('Add/data=Partner', [PartnerController::class, 'store_partner']);
            Route::patch('update/{id_ptn}/data=Partner', [PartnerController::class, 'patch_partner']);
            Route::patch('delete/{id_ptn}/data=Partner', [PartnerController::class, 'destroy_partner']);
        // Report
        Route::get('Report/data=Ticket', [ReportCOntroller::class, 'report']);
        // Compare
        Route::get('Compare/report=Ticket', [ReportCOntroller::class, 'compare']);
            // KPI Detil Report
            Route::get('Data/Detil-Report/{notiket}', [ReportCOntroller::class, 'getViewDetilReport'])->where(['notiket' => '.*']);
            Route::get('getAjaxDetil/{notiket}', [ReportCOntroller::class, 'getReportDetil'])->where(['notiket' => '.*']);
        Route::post('Report/data=Ticket/sorting', [ReportCOntroller::class, 'report'])->name('sorting.report');
        Route::post('Compare/report=Ticket/sorting', [ReportCOntroller::class, 'compare'])->name('sorting.compare');
            // Export Excel
            Route::post('export-ticket/Report', [ReportCOntroller::class, 'export']);
            Route::post('Data/Report/PIC', [ReportCOntroller::class, 'exportDataPIC']);
            Route::post('Data/Report/Split', [ReportCOntroller::class, 'exportDataSplit']);
            // Report Chart
            Route::get('Report/Chart/Monthly-Ticket', [ReportCOntroller::class, 'chart']);
            Route::post('Report/data=Daily/sorting', [ReportCOntroller::class, 'chart'])->name('sorting.chart');
                // Get Data Chart
                Route::get('/chart', [ReportCOntroller::class, 'getDataMonthlyChart'])->name('chart.data');
            // Report KPI
                // Engineer
                Route::get('Report/data=KPI-User', [ReportCOntroller::class, 'kpi']);
                Route::post('Report/data=KPI-User/sorting', [ReportCOntroller::class, 'kpi'])->name('sorting.kpi');
                    // Export Excel KPI
                    Route::post('export-KPI/Report', [ReportCOntroller::class, 'export_kpi']);
                // KPI Detil Report
                Route::get('Detil-Report/{notiket}', [ReportCOntroller::class, 'getTicketDetails'])->where(['notiket' => '.*']);
                // END Engineer
                // L2
                Route::get('Report/KPI/data=L2-en', [ReportCOntroller::class, 'kpiL2']);
                Route::post('Report/KPI/data=L2-en/sorting', [ReportCOntroller::class, 'kpiL2'])->name('sorting.kpiL2');
                    // Export Excel KPI
                    Route::post('export-KPI/L2/Report', [ReportCOntroller::class, 'export_kpiL2']);
                // end L2
            // Lat & Lng Report
            Route::get('Report/data=Lat&Lng', [ReportCOntroller::class, 'latlng']);
            Route::post('Report/data=LatLng/sorting', [ReportCOntroller::class, 'latlng'])->name('sorting.latlng');
                // Export Excel LatLng
                Route::post('export-LatLng/Report', [ReportCOntroller::class, 'export_latlng']);
            // Report Activity Helpdesk
            Route::get('Report/data=Act-Helpdesk', [ReportCOntroller::class, 'ActHP']);
            Route::post('Report/data=Act-Helpdesk/sorting', [ReportCOntroller::class, 'ActHP'])->name('sorting.act.helpdesk');
                // Export Excel Act Helpdesk
                Route::post('export/Act-Helpdesk/Report', [ReportCOntroller::class, 'export_act_hp']);
            // Report History Ticket
            Route::get('Report/data=History-Ticket', [ReportCOntroller::class, 'hisTicket']);
            Route::POST('Report/data=History-Ticket/sorting', [ReportCOntroller::class, 'hisTicket'])->name('sorting.hisTicket');
                // Detil
                Route::get('Detil/History-Ticket/{notiket}', [ReportCOntroller::class, 'detHisTiket'])->where(['notiket' => '.*']);
                // Export History Ticket
                Route::post('export/History-Ticket/Report', [ReportCOntroller::class, 'export_his_ticket']);
                // Export SLA History Ticket
                Route::post('export/History-SLA-Ticket/Report', [ReportCOntroller::class, 'export_cnt_sla']);
            // Report Each Week
            Route::get('Report/data=Each-Week', [ReportCOntroller::class, 'eachWeek']);
            Route::POST('Report/Each-Week/sorting', [ReportCOntroller::class, 'eachWeek'])->name('sorting.eachWeek');
                //Detail Report Each Week
                Route::get('Pending-EW/Timeframe={timeframe}/{project}/{month}/{year}', [ReportCOntroller::class, 'dtEWPending']);
            // Report Each Month
            Route::get('Report/data=Each-Month', [ReportCOntroller::class, 'eachMonth']);
            Route::POST('Report/Each-Month/sorting', [ReportCOntroller::class, 'eachMonth'])->name('sorting.eachMonth');
                //Detail Report Each Timeframe
                Route::get('Pending-EM/Timeframe={timeframe}/{project}/{year}', [ReportCOntroller::class, 'dtEMPending']);
            // Export Report Timeframe Ticket
            Route::post('export/{tfr}/Summary-Ticket', [ReportCOntroller::class, 'export_wmly_tc']);
            // Report Each Week SP
            Route::get('Report/SP=Each-{validate}', [ReportCOntroller::class, 'eachWeekSP']);
            Route::POST('Report/SP=Each-{validate}/sorting', [ReportCOntroller::class, 'eachWeekSP'])->name('sorting.ewSP');
                //Detail Report Each Week /SP
                Route::get('Summary-SP/{validate}/{timeframe}/{sp}/{month}/{year}', [ReportCOntroller::class, 'dtSPPending']);
            // Export Report Timeframe SP
            Route::post('export/{vdt}/Summary-SP', [ReportCOntroller::class, 'export_wmly_sp']);
            // Report Each Week AE
            Route::get('Report/AE=Each-{validate}', [ReportCOntroller::class, 'eachWeekAE']);
            Route::POST('Report/AE=Each-{validate}/sorting', [ReportCOntroller::class, 'eachWeekAE'])->name('sorting.ewAE');
                //Detail Report Act Engineer Each Week
                Route::get('Summary-AE/{validate}/{timeframe}/{en}/{month}/{year}', [ReportCOntroller::class, 'dtActEW']);
            // Export Report Timeframe AE
            Route::post('export/{vdt}/Summary-AE', [ReportCOntroller::class, 'export_wmly_ae']);
            // Report Act Helpdesk
            Route::get('Report/Helpdesk=Each-{validate}', [ReportCOntroller::class, 'eachWeekHP']);
            Route::POST('Report/Helpdesk=Each-{validate}/sorting', [ReportCOntroller::class, 'eachWeekHP'])->name('sorting.ewHP');
                //Detail Report Act Helpdesk
                Route::get('Summary-HP/{validate}/{timeframe}/{hp}/{month}/{year}', [ReportCOntroller::class, 'dtEHP']);
                // Export Report Timeframe Act Helpdesk
                Route::post('export/{vdt}/Summary-Act/Helpdesk', [ReportCOntroller::class, 'export_actHP']);
            // Report Pending Ticket
            Route::get('Report/Data=Ticket-Pending', [ReportCOntroller::class, 'pedningTicket']);
            Route::POST('Report/data=Pending-Ticket/sorting', [ReportCOntroller::class, 'pedningTicket'])->name('sorting.pdTicket');
                // Export SLA History Ticket
                Route::post('export/Pending-Ticket/Report', [ReportCOntroller::class, 'export_pdTC']);
            // Report Pending Ticket
            Route::get('Report/Data=Top-Part', [ReportCOntroller::class, 'topPart']);
            Route::POST('Report/Data=Top-Part/sorting', [ReportCOntroller::class, 'topPart'])->name('sorting.topPart');
                // Export Top Part
                    // Weekly
                    Route::post('export/Top-Part/EW/Report', [ReportCOntroller::class, 'export_ew_topPart']);
                    // Monthly
                    Route::post('export/Top-Part/EM/Report', [ReportCOntroller::class, 'export_em_topPart']);
        // Report Ticket ADM
        Route::get('Report/Ticket/Admin', [ReportCOntroller::class, 'report_tc_adm']);
        Route::post('Report/Ticket/Admin/sorting', [ReportCOntroller::class, 'report_tc_adm'])->name('sort.tc.report');
            // Export Excel
            Route::post('export-ticket/Report=Ticket/Admin', [ReportCOntroller::class, 'export_dt_ticket']);
        // Report Expenses Acc
        Route::get('/Report-Expenses', [ReportCOntroller::class, 'getViewReportExpenses']);
            // Export Excel
            Route::post('export-data/Report=Expenses', [ReportCOntroller::class, 'export_expenses']);
        // Part Type
        Route::get('Master/data=Type-Part', [PartController::class, 'type_part']);
            // CRUD
            Route::post('Add/data=Type-Part', [PartController::class, 'store']);
            Route::patch('update/{id}/data=Type-Part', [PartController::class, 'update']);
            Route::patch('remove/{id}/data=Type-Part', [PartController::class, 'remove']);
        // Category Unit
        Route::get('Master/data=Category-Unit', [MasterController::class, 'vw_ctgr_unit']);
            // CRUD
            Route::post('Add/data=Category-Unit', [MasterController::class, 'store_ctgr_unit']);
            Route::patch('update/{id}/data=Category-Unit', [MasterController::class, 'update_ctgr_unit']);
            Route::patch('remove/{id}/data=Category-Unit', [MasterController::class, 'remove_ctgr_unit']);
        // Merk Unit
        Route::get('Master/data=Merk-Unit', [MasterController::class, 'vw_merk_unit']);
            // CRUD
            Route::post('Add/data=Merk-Unit', [MasterController::class, 'store_merk_unit']);
            Route::patch('update/{id}/data=Merk-Unit', [MasterController::class, 'update_merk_unit']);
            Route::patch('remove/{id}/data=Merk-Unit', [MasterController::class, 'remove_merk_unit']);
        // Office Type
        Route::get('Master/data=Office-Type', [MasterController::class, 'vw_office_type']);
            // CRUD
            Route::post('Add/data=Office-Type', [MasterController::class, 'store_office_type']);
            Route::patch('update/{id}/data=Office-Type', [MasterController::class, 'update_office_type']);
            Route::patch('remove/{id}/data=Office-Type', [MasterController::class, 'remove_office_type']);
        // Category Note
        Route::get('Master/data=Category-Note', [MasterController::class, 'ktgr_note']);
            // CRUD
            Route::post('Add/data=Category-Note', [MasterController::class, 'store_ktgr_note']);
            Route::patch('update/{id}/data=Category-Note', [MasterController::class, 'update_ktgr_note']);
            Route::patch('remove/{id}/data=Category-Note', [MasterController::class, 'remove_ktgr_note']);
        // Unit Type
        Route::get('Master/data=Unit-Type', [MasterController::class, 'vw_unit_type']);
        // Sts Pending
        Route::get('Master/data=Stats-Pending', [MasterController::class, 'stsPending']);
            // CRUD
            Route::post('Add/data=Ktgr-Pending', [MasterController::class, 'store_ktgr_pending']);
            Route::patch('update/{id}/data=Ktgr-Pending', [MasterController::class, 'update_ktgr_pending']);
            Route::patch('remove/{id}/data=Ktgr-Pending', [MasterController::class, 'destroy_ktgr_pending']);
        // Type Act PIC
        Route::get('Master/data=Type-Act/PIC', [MasterController::class, 'TAP']);
            // CRUD
            Route::post('Add/data=Type-Act/PIC', [MasterController::class, 'store_TAP']);
            Route::patch('update/{id}/data=Type-Act/PIC', [MasterController::class, 'update_TAP']);
            Route::patch('remove/{id}/data=Type-Act/PIC', [MasterController::class, 'destroy_TAP']);
    // Initialize
        // Merk && Category
        Route::get('Initialize/data=Merk-Category', [MasterController::class, 'init_merk_category']);
            //ADD
            Route::post('Add-Initialize/data=Merk-Category', [MasterController::class, 'add_init_merk_category']);
            //UPDATE
            Route::patch('update/{id}/Initialize=Merk-Category', [MasterController::class, 'update_init_merk_category']);
            //Remove
            Route::patch('remove/{id}/Initialize=Merk-Category', [MasterController::class, 'remove_init_merk_category']);
            
        // Type Ticket
        Route::get('Master/data=Type-Ticket', [MasterController::class, 'type_ticket']);
            // CRUD
            Route::post('Add/data=Type-Ticket', [MasterController::class, 'store_ticket_type']);
            Route::patch('update/{id}/data=Type-Ticket', [MasterController::class, 'update_ticket_type']);
            Route::patch('remove/{id}/data=Type-Ticket', [MasterController::class, 'remove_ticket_type']);
        // Category Part
        Route::get('Master/data=Category-Part', [MasterController::class, 'ktgr_part']);
            // CRUD
            Route::post('Add/data=Category-Part', [MasterController::class, 'store_ktgr_part']);
            Route::patch('update/{id}/data=Category-Part', [MasterController::class, 'update_ktgr_part']);
            Route::patch('remove/{id}/data=Category-Part', [MasterController::class, 'remove_ktgr_part']);
        // Category Expenses
        Route::get('Master/data=Ctgr-Expenses', [MasterController::class, 'CxP']);
            // ~ CRUD
            Route::post('Add/Data=CtgrExpenses', [MasterController::class, 'store_CxP']);
            Route::patch('Update/{id}/Data=CtgrExpenses', [MasterController::class, 'update_CxP']);
            Route::patch('Remove/{id}/Data=CtgrExpenses', [MasterController::class, 'remove_CxP']);
        // Category Reqs
        Route::get('Master/data=Ctgr-Reqs', [MasterController::class, 'Creqs']);
            // ~ CRUD
            Route::post('Add/Data=CtgrReqs', [MasterController::class, 'store_Creqs']);
            Route::patch('Update/{id}/Data=CtgrReqs', [MasterController::class, 'update_Creqs']);
            Route::patch('Remove/{id}/Data=CtgrReqs', [MasterController::class, 'remove_Creqs']);
        // Category Reqs
        Route::get('Master/Data=TypeOfTransportation', [MasterController::class, 'TTns']);
            // ~ CRUD
            Route::post('Add/Data=TypeOfTransportation', [MasterController::class, 'store_TTns']);
            Route::patch('Update/{id}/Data=TypeOfTransportation', [MasterController::class, 'update_TTns']);
            Route::patch('Remove/{id}/Data=TypeOfTransportation', [MasterController::class, 'remove_TTns']);
        // Main Website HGT Services
            // Category Product
            Route::get('Master/data-Web=Category-Product', [WebsiteController::class, 'vw_web_ctgr_prd']);
            // Content Product
            Route::get('Master/data-Web=Product', [WebsiteController::class, 'vw_web_prd']);
                // add prodcut
                Route::post('Add/data-Web=Product', [WebsiteController::class, 'store_wb_upload']);
            // Inquiry Message
            Route::get('Data/Inquiry-Message', [WebsiteController::class, 'vw_web_inquiry_msg']);
    // Expenses
    Route::get('Form/Reqs-Expenses/{id}', [AccomodationController::class, 'expenses']);
        // Request Accomodation
        Route::get('{dsc}/Reqs-Accomodation/{id}', [AccomodationController::class, 'request_reimburse']);
            // Add Reqs
            Route::post('{dsc}/{id}/Reqs-Reimburse/En', [AccomodationController::class, 'add_req_reimburse_en']);
            // Delete Reqs
            Route::delete('Delete/Reqs-En/{id}', [AccomodationController::class, 'destroy_reqs']);
            // DELETE DETIL
            Route::delete('Delete/Detil/Reqs-En/{id}', [AccomodationController::class, 'destroy_dt_en']);
            // Check update Detil
            Route::patch('/Update-Detil', [AccomodationController::class, 'check_detail_reqs_en']);
            // Check update Attach
            Route::patch('/Update-Attach', [AccomodationController::class, 'attach_detail_reqs_en']);
        // Confirm Lead EN
        Route::patch('Confirm/Reqs-En/{id}', [AccomodationController::class, 'confirm_reqs']);
        // Reject Accounting
        Route::patch('Reject/{dsc}/Reqs-En/{id}', [AccomodationController::class, 'reject_reqs'])->name('reject.reqs');
        // Store Expenses
        Route::post('Store/Expenses/Reqs-{id}', [AccomodationController::class, 'store_expenses'])->name('store.expenses');
        // Execute Reqs
        Route::patch('Execute/Reqs-En/{id}', [AccomodationController::class, 'execute_reqs'])->name('execute.reqs');
        // Add Note
        Route::patch('add-note/{id}/LE', [AccomodationController::class, 'add_note_le'])->name('add.note.le');
        // Finish Reqs
        Route::patch('Finish/Reqs-En/{id}', [AccomodationController::class, 'finish_reqs'])->name('done.reqs');
    Route::get('My-Expenses/id={id}', [AccomodationController::class, 'vw_request_reimburse']);
        // Filter
        Route::post('My-Expenses/id={id}/sorting', [AccomodationController::class, 'vw_request_reimburse'])->name('sorting.request');
        // Get Excel Reimburse
        Route::post('Excel/Data-Reimburse', [AccomodationController::class, 'get_reqs_excel'])->name('excel.reimburse');
    Route::get('Print-Out/{id}-{sub}', [AccomodationController::class, 'inv_ex']);
    Route::post('Receipt/{id}/Download', [AccomodationController::class, 'downloadReceiptment'])->name('receipt.download');

    // Admin Page
    Route::get('Inquiry/Docs', [DocsController::class, 'vw_upload_docs']);
        //Update Docs Received
        Route::patch('Update-Ticket/Docs/{id}', [DocsController::class, 'update_receive_docs'])->where(['id' => '.*']);
    
    // Logistik Page
    // Listed Page
    Route::get('Listed-Return/Parts', [LogistikController::class, 'page_listed_part']);
    Route::get('Ticket/AWB/Update={key}', [LogistikController::class, 'view_awb'])->where(['key' => '.*']);
        // Added List
        Route::post('Add-List/AWB/{notiket}/{pid}', [LogistikController::class, 'store_part_list_awb'])->where(['notiket' => '.*']);
            // Deleted List\
            Route::delete('Delete/List-awb/{id}/{part}', [LogistikController::class, 'repeat_list'])->where(['id' => '.*']);
            // Update AWB List\
            Route::patch('Update/All-List/{id}', [LogistikController::class, 'update_awb_all_list'])->where(['id' => '.*']);
        //Update Done AWB
        Route::patch('Update-Ticket/AWB/{id}', [LogistikController::class, 'update_finish_awb'])->where(['id' => '.*']);
        // Get Excel Listed Part
        Route::post('Excel/Listed-Parts', [LogistikController::class, 'excel_lp'])->name('excel.lp');
    
    // Search Issue
    Route::get('Search/Data-Issue', [IssueController::class, 'srch']);
        // Directing search issue ticket
        Route::post('Direct/Issue-Ticket', [IssueController::class, 'dirSearchIssue']);

    // Search location
    Route::get('/search', [LocationController::class, 'index']);

    // View Profile
    Route::get('Profile/{user}', [ProfileController::class, 'profile']);
        // Edit User
        Route::patch('update/user/{user}', [ProfileController::class, 'update_biodata'])->name('update.user');
        // Reset Password
        Route::patch('Reset-Password/{user}', [ProfileController::class, 'reset_password'])->name('reset.password');
        // Upload Image
        Route::post('Add-Image/User', [ProfileController::class, 'upload_image_user']);
    
    // VIEW ATTACHMENT
    Route::get('Ticket={notiket}/Attachment/{en}', [VAttachmentController::class, 'attach_en'])->where(['notiket' => '.*' ,'en' => '.*']);
        // Download Image
        Route::post('/Attach-download/en/{filename}', [VAttachmentController::class, 'downloadImage'])->where(['filename' => '.*']);
        // Add Another Attachment
        Route::post('Add/Attachment/{id}', [VAttachmentController::class, 'store_attachment_detil'])->where(['id' => '.*']);
        // Delete Attachment Engineer
        Route::delete('/Attachment/{id}', [VAttachmentController::class, 'destroy'])->name('attachment.destroy');
    // PROBLEM KNOWLEDGE
    Route::get('/Problem-Knowledge', [PKnowledgeController::class, 'pknowledge']);
    // Trello
    Route::get('Trello/Engineer', [TrelloController::class, 'trelloEn']);


    Route::get('/Calendar', [CalendarController::class, 'index']);
    Route::get('/events', [CalendarController::class, 'getData']);

    // Test Page
    Route::get('/Test', [TestController::class, 'index']);
    Route::post('/test/upload', [TestController::class, 'upload']);
    // Route::get("/Test", function(){
    //     return view("Pages.Test.test");
    // });

    Route::get('provinces', [PackageController::class,'provinces'])->name('provinces');
    Route::get('cities', [PackageController::class,'cities'])->name('cities');
    Route::get('districts', [PackageController::class,'districts'])->name('districts');
    Route::get('villages', [PackageController::class,'villages'])->name('villages');
    // END FORM MASTER
    // 500 for undefined routes
    Route::get('/NotVerified', function () {
        return view('Pages.Error.500');
    });
});
// 404 for undefined routes
Route::any('/{page?}',function(){
    return View::make('Pages.Error.404');
})->where('page','.*');
Auth::routes();