<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\VW_AAEn;
use App\Models\EngineerAttachment;
use App\Models\AttachmentFile;
use App\Models\VW_Docs;
use App\Models\AttReimburseEn;
use App\Models\ReimburseEn;
use Illuminate\Support\Facades\File;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use ZipArchive;

class VAttachmentController extends Controller
{
    public function attach_en($notiket, $en)
    {
        $data['info'] = VW_AAEn::where('en_attach_id', $en)->groupBy('en_attach_id')->first();
        $data['image'] = VW_AAEn::all()->where('en_attach_id', $en);
        
        return view('Pages.Attachment.TEAttach.index')->with($data)->with('notiket', $notiket);
    }
    public function store_attachment_detil(Request $request, $id){
        $dateTime = date("Y-m-d H:i:s", strtotime("+7 hours"));
        $files = $request->file('files_detil');

        $data_type = EngineerAttachment::select('type_attach')->where('engineer_attach_id', $id)->groupBy('engineer_attach_id')->first();
        foreach ($files as $file) {
            $fileName = uniqid().'_'.$file->getClientOriginalName();
            $file->move(public_path('/uploads'), $fileName);
            
            $path = '/uploads/'.$fileName;

            $values_list = [
                'engineer_attach_id'           => $id,
                'filename'    => $fileName,
                'path'    => $path,
                'note'    => $request->note_another_dt,
                'type_attach'    => $data_type->type_attach,
                'created_at'    => $dateTime
            ];
            
            $result = EngineerAttachment::insert($values_list);
        }
        if($files) {
            Alert::toast('Atacchment Successfully Added!', 'success');
            return back();
        }
        else {
            Alert::toast('Error when Upload Attachment', 'error');
            return back();
        }
    }
    public function downloadImage($filename)
    {
        $path = public_path('uploads/'.$filename);

        return response()->download($path);
    }
    public function destroy($id)
    {
        $attachment = EngineerAttachment::find($id);
        
        $fileName = public_path('uploads/' . $attachment->filename);

        if (file_exists($fileName)) {
            unlink($fileName);
        }

        $result = $attachment->delete();
        if ($result) {
            Alert::toast('Atacchment Successfully deleted!', 'success');
            return back();
        } else {
            Alert::toast('Error when deleted this file', 'error');
            return back();
        }
    }
    public function downloadFileTicket($id)
    {
        $depart =  auth()->user()->depart;
        if ($depart == 10) {
            $file_attach_ticket = VW_Docs::find($id);
            $path = 'uploads';
        } else {
            $file_attach_ticket = AttachmentFile::find($id);
            $path = 'files';
        }
        $path = public_path($path.'/'.$file_attach_ticket->filename);

        return response()->download($path);
    }
    public function downloadUploadedADM($id)
    {
        $file_attach_ticket = AttachmentFile::find($id);
        $path = 'uploads/bundle_adm';
        $path = public_path($path.'/'.$file_attach_ticket->filename);

        return response()->download($path);
    }
    public function downloadAttachReimburse($fk_id)
    {
        $getDT = AttReimburseEn::where('fk_id', $fk_id)->get();
        $zipFileName = "$fk_id".'-'."Reimburse.zip";
        $zip = new ZipArchive;

        if ($zip->open(public_path($zipFileName), ZipArchive::CREATE) === true) {
            foreach ($getDT as $value) {
                $filePath = public_path($value->path);

                if (file_exists($filePath)) {
                    $zip->addFile($filePath, basename($filePath));
                }
            }
            
            $zip->close();
            
            return Response::download(public_path($zipFileName))->deleteFileAfterSend();
        } else {
            return response()->json(['message' => 'Failed to create zip archive'], 500);
        }
    }
    public function deleteAttachReimburse($id){
        $fetch = ReimburseEn::where('fk_id', $id)->first();
        $getDT = AttReimburseEn::where('fk_id', $id)->get();
        $deleted = $fetch->delete();
        if($deleted && $getDT) {
            foreach ($getDT as $value) {
                $pathFile = public_path("$value->path");

                if (file_exists($pathFile)) {
                    unlink($pathFile);
                }
                $value->delete();
            }
            Alert::toast('Attach Reimburse Deleted!', 'success');
            return back();
        }
        else {
            Alert::toast('Error Delete Attachment', 'error');
            return back();
        }
    }
}
