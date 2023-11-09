<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mail\TicketMailable;
use Illuminate\Support\Facades\Mail;
use RealRashid\SweetAlert\Facades\Alert;
use App\Models\CategoryUnit;
use App\Models\Merk;
use App\Models\OfficeType;
use App\Models\TypeUnit;
use App\Models\MerkCategory;
use App\Models\TypeTicket;
use App\Models\CategoryPart;
use App\Models\WB_Category_Product;
use App\Models\CategoryNote;
use App\Models\StsPending;
use App\Models\TypeActPIC;

class MasterController extends Controller
{
    // Start Master Category
        public function vw_ctgr_unit()
        {
            $data['ktgr'] = CategoryUnit::all()->where('deleted', 0);
            $data['merk_data'] = Merk::all()->where('deleted', 0);
            return view('Pages.CategoryUnit.index')->with($data);
        }
        
        public function store_ctgr_unit(Request $request)
        {
            $dateTime = date("Y-m-d H:i:s", strtotime("+7 hours"));
            
            $values = [
                'merk_id'    => $request->add_ktgr_merk,
                'category_name'    => $request->ctgr_unit_val,
                'deleted'    => 0,
                'created_at'    => $dateTime
            ];
            
            if($values) {
                CategoryUnit::insert($values);
                Alert::toast('Successfully Saved Data', 'success');
                return redirect('Master/data=Category-Unit');
            } else {
                Alert::toast('Failed Saving', 'error');
                return back();
            }
        }

        public function update_ctgr_unit(Request $request, $id){
            $value = [
                'merk_id'    => $request->updt_ktgr_unit,
                'category_name'    => $request->edt_ctgr_unit
            ];
            $query = CategoryUnit::where('category_id', $id)->first();
            $result = $query->update($value);
            if ($result) {
                Alert::toast('Successfully Updated Data', 'success');
                return back();
            }
            else {
                Alert::toast('Failed Updating', 'error');
                return back();
            }
        }

        public function remove_ctgr_unit(Request $request, $id){
            $value = [
                'deleted'    => 1
            ];
            $query = CategoryUnit::where('category_id', $id)->first();
            $result = $query->update($value);
            if ($result) {
                Alert::toast('Successfully Removed Data', 'success');
                return back();
            }
            else {
                Alert::toast('Failed Deleting', 'error');
                return back();
            }
        }
    // END Master Category

    // Start Master Merk
        public function vw_merk_unit()
        {
            $data['merk'] = Merk::all()->where('deleted', 0);
            return view('Pages.MerkUnit.index')->with($data);
        }
        
        public function store_merk_unit(Request $request)
        {
            $dateTime = date("Y-m-d H:i:s", strtotime("+7 hours"));
            
            $values = [
                'merk'    => $request->merk_unit_val,
                'deleted'    => 0,
                'created_at'    => $dateTime
            ];
            
            if($values) {
                Merk::insert($values);
                Alert::toast('Successfully Stored Data', 'success');
                return redirect('Master/data=Merk-Unit');
            } else {
                Alert::toast('Failed saving', 'error');
                return back();
            }
        }

        public function update_merk_unit(Request $request, $id){
            $value = [
                'merk'    => $request->edt_merk_unit
            ];
            if ($value) {
            $query = Merk::where('id', $id)->first();
            $query->update($value);
                Alert::toast('Successfully Updated Data', 'success');
                return back();
            }
            else {
                Alert::toast('Failed Updating', 'error');
                return back();
            }
        }

        public function remove_merk_unit(Request $request, $id){
            $value = [
                'deleted'    => 1
            ];
            if ($value) {
            $query = Merk::where('id', $id)->first();
            $query->update($value);
                Alert::toast('Successfully Destroy Data', 'success');
                return back();
            }
            else {
                Alert::toast('Failed Removing', 'error');
                return back();
            }
        }
    // END Master Category
    // Start Master Office Type
        public function vw_office_type()
        {
            $data['office_type'] = OfficeType::all()->where('deleted', 0);
            return view('Pages.OfficeType.index')->with($data);
        }
        public function store_office_type(Request $request)
        {
            $dateTime = date("Y-m-d H:i:s", strtotime("+7 hours"));
            
            $values = [
                'name_type'    => $request->type_name,
                'deleted'    => 0,
                'created_at'    => $dateTime
            ];
            
            if($values) {
                OfficeType::insert($values);
                Alert::toast('Successfully Stored Data', 'success');
                return redirect('Master/data=Office-Type');
            } else {
                Alert::toast('Failed Saving', 'error');
                return back();
            }
        }

        public function update_office_type(Request $request, $id){
            $value = [
                'name_type'    => $request->edt_name_type
            ];
            if ($value) {
            $query = OfficeType::where('office_type_id', $id)->first();
            $query->update($value);
                Alert::toast('Successfully Updated Data', 'success');
                return back();
            }
            else {
                Alert::toast('Failed Updating', 'error');
                return back();
            }
        }

        public function remove_office_type(Request $request, $id){
            $value = [
                'deleted'    => 1
            ];
            if ($value) {
            $query = OfficeType::where('office_type_id', $id)->first();
            $query->update($value);
                Alert::toast('Successfully Removed Data', 'success');
                return back();
            }
            else {
                Alert::toast('Failed Removing', 'error');
                return back();
            }
        }
    // End Master Office Type
    // Start Unit Type
        public function vw_unit_type()
        {
            $data['type_unit'] = TypeUnit::all()->where('deleted', 0);
            return view('Pages.UnitType.index')->with($data);
        }
    // end Unit Type
    // Start Initialize
        // Merk & KTGR
        public function init_merk_category()
        {
            $data['init_mc'] = MerkCategory::all()->where('deleted', 0);
            $data['merk'] = Merk::all()->where('deleted', 0);
            $data['ktgr'] = CategoryUnit::all()->where('deleted', 0);
            return view('Pages.Initialize.m&c')->with($data);
        }
        public function add_init_merk_category(Request $request)
        {
            $dateTime = date("Y-m-d H:i:s", strtotime("+7 hours"));
            
            $values = [
                'merk_id'    => $request->init_merk,
                'category_id'    => $request->init_ktgr,
                'created_at'    => $dateTime
            ];
            
            if($values) {
                MerkCategory::insert($values);
                Alert::toast('Successfully Stored Data', 'success');
                return back();
            } else {
                Alert::toast('Failed Saving', 'error');
                return back();
            }
        }
        public function update_init_merk_category(Request $request, $id){
            $value = [
                'merk_id'    => $request->edt_init_merk,
                'category_id'    => $request->edt_init_ktgr
            ];
            $query = MerkCategory::where('id', $id)->first();
            if ($query) {
                $query->update($value);
                Alert::toast('Successfully Updated Data', 'success');
                return back();
            }else {
                Alert::toast('Failed Updating', 'error');
                return back();
            }
        }

        public function remove_init_merk_category(Request $request, $id){
            $value = [
                'deleted'    => 1
            ];
            $query = MerkCategory::where('id', $id)->first();
            if ($query) {
                $query->update($value);
                Alert::toast('Successfully Removed Data', 'success');
                return back();
            }
            else {
                Alert::toast('Failed Removing', 'error');
                return back();
            }
        }
    // End Init
    // Start Type Ticket
        public function type_ticket()
        {
            $data['type_tic'] = TypeTicket::all()->where('deleted', 0);
            return view('Pages.TypeTicket.index')->with($data);
        }
        
        public function store_ticket_type(Request $request)
        {
            $dateTime = date("Y-m-d H:i:s", strtotime("+7 hours"));
            
            $values = [
                'type_name'    => $request->type_ticket_name,
                'created_at'    => $dateTime
            ];
            
            if($values) {
                TypeTicket::insert($values);
                Alert::toast('Procedure stored successfully!', 'success');
                return back();
            } else {
                Alert::toast('Failed Saving!', 'error');
                return back();
            }
        }
        public function update_ticket_type(Request $request, $id){
            $value = [
                'type_name'    => $request->edt_ticket_type_name
            ];
            $query = TypeTicket::where('id', $id)->first();
            if ($query) {
                $query->update($value);
                Alert::toast('Successfully Updated Data', 'success');
                return back();
            }else {
                Alert::toast('Failed Updating', 'error');
                return back();
            }
        }

        public function remove_ticket_type(Request $request, $id){
            $value = [
                'deleted'    => 1
            ];
            $query = TypeTicket::where('id', $id)->first();
            if ($query) {
                $query->update($value);
                Alert::toast('Successfully Removed Data', 'success');
                return back();
            }
            else {
                Alert::toast('Failed Removing', 'error');
                return back();
            }
        }
    // END Type TIcket
    // Start KTGR Part
        public function ktgr_part()
        {
            $data['ktgr_part'] = CategoryPart::all()->where('deleted', 0);
            return view('Pages.CategoryPart.index')->with($data);
        }
        
        public function store_ktgr_part(Request $request)
        {
            $dateTime = date("Y-m-d H:i:s", strtotime("+7 hours"));
            
            $values = [
                'type_name'    => $request->part_kategory_name,
                'created_at'    => $dateTime
            ];
            
            if($values) {
                CategoryPart::insert($values);
                Alert::toast('Procedure stored successfully!', 'success');
                return back();
            } else {
                Alert::toast('Failed Saving!', 'error');
                return back();
            }
        }
        public function update_ktgr_part(Request $request, $id){
            $value = [
                'type_name'    => $request->edt_part_kategory_name
            ];
            $query = CategoryPart::where('id', $id)->first();
            if ($query) {
                $query->update($value);
                Alert::toast('Successfully Updated Data', 'success');
                return back();
            }else {
                Alert::toast('Failed Updating', 'error');
                return back();
            }
        }

        public function remove_ktgr_part(Request $request, $id){
            $value = [
                'deleted'    => 1
            ];
            $query = CategoryPart::where('id', $id)->first();
            if ($query) {
                $query->update($value);
                Alert::toast('Successfully Removed Data', 'success');
                return back();
            }
            else {
                Alert::toast('Failed Removing', 'error');
                return back();
            }
        }
    // END KTGR Part
    // Start KTGR Note
        public function ktgr_note()
        {
            $data['ktgr_note'] = CategoryNote::all()->where('deleted', 0);
            return view('Pages.CategoryNote.index')->with($data);
        }

        
        public function store_ktgr_note(Request $request)
        {
            $dateTime = date("Y-m-d H:i:s", strtotime("+7 hours"));
            
            $values = [
                'ktgr_name'    => $request->ktgr_note_name,
                'created_at'    => $dateTime
            ];
            
            $execute = CategoryNote::insert($values);
            if($execute) {
                Alert::toast('Procedure stored successfully!', 'success');
                return back();
            } else {
                Alert::toast('Failed Saving!', 'error');
                return back();
            }
        }
        
        public function update_ktgr_note(Request $request, $id){
            $value = [
                'ktgr_name'    => $request->edt_note_kategory_name
            ];
            $query = CategoryNote::where('id', $id)->first();
            $execute = $query->update($value);
            if ($execute) {
                Alert::toast('Successfully Updated Data', 'success');
                return back();
            }else {
                Alert::toast('Failed Updating', 'error');
                return back();
            }
        }

        public function remove_ktgr_note(Request $request, $id){
            $value = [
                'deleted'    => 1
            ];
            $query = CategoryNote::where('id', $id)->first();
            $destroy = $query->update($value);
            if ($destroy) {
                Alert::toast('Successfully Removed Data', 'success');
                return back();
            }
            else {
                Alert::toast('Failed Removing', 'error');
                return back();
            }
        }
    // END KTGR Note
    // Start Status Pending
        public function StsPending()
        {
            $data['query'] = StsPending::all()->where('deleted', 0);
            return view('Pages.StsPending.index')->with($data);
        }

        public function store_ktgr_pending(Request $request)
        {
            $dateTime = date("Y-m-d H:i:s", strtotime("+7 hours"));
            
            $values = [
                'ktgr_pending'    => $request->ktgr_pd_name,
                'created_at'    => $dateTime
            ];
            
            $execute = StsPending::insert($values);
            if($execute) {
                Alert::toast('Procedure stored successfully!', 'success');
                return back();
            } else {
                Alert::toast('Failed Saving!', 'error');
                return back();
            }
        }
        public function update_ktgr_pending(Request $request, $id){
            $value = [
                'ktgr_pending'    => $request->val_edt_ktgrpd
            ];
        $query = StsPending::where('id', $id)->first();
            $destroy = $query->update($value);
            if ($destroy) {
                Alert::toast('Successfully Update Data', 'success');
                return back();
            }
            else {
                Alert::toast('Failed Removing', 'error');
                return back();
            }
        }
        public function destroy_ktgr_pending(Request $request, $id){
            $value = [
                'deleted'    => 1
            ];
            $query = StsPending::where('id', $id)->first();
            $destroy = $query->update($value);
            if ($destroy) {
                Alert::toast('Successfully Removed Data', 'success');
                return back();
            }
            else {
                Alert::toast('Failed Removing', 'error');
                return back();
            }
        }
    // END Status Pending
    // Start Status Pending
        public function TAP()
        {
            $data['query'] = TypeActPIC::all()->where('deleted', 0);
            return view('Pages.TypeActPIC.master')->with($data);
        }

        public function store_TAP(Request $request)
        {
            $dateTime = date("Y-m-d H:i:s", strtotime("+7 hours"));
            
            $values = [
                'name'    => $request->act_type_pic,
                'created_at'    => $dateTime
            ];
            if($values) {
                $execute = TypeActPIC::insert($values);
                Alert::toast('Procedure stored successfully!', 'success');
                return back();
            } else {
                Alert::toast('Failed Saving!', 'error');
                return back();
            }
        }
        public function update_TAP(Request $request, $id){
            $value = [
                'name'    => $request->val_edt_tap
            ];
            $query = TypeActPIC::where('id', $id)->first();
            if ($query) {
                $query->update($value);
                Alert::toast('Successfully Update Data', 'success');
                return back();
            }
            else {
                Alert::toast('Failed Removing', 'error');
                return back();
            }
        }
        public function destroy_TAP(Request $request, $id){
            $value = [
                'deleted'    => 1
            ];
            $query = TypeActPIC::where('id', $id)->first();
            if ($query) {
                $query->update($value);
                Alert::toast('Successfully Removed Data', 'success');
                return back();
            }
            else {
                Alert::toast('Failed Removing', 'error');
                return back();
            }
        }
    // END Status Pending
}
