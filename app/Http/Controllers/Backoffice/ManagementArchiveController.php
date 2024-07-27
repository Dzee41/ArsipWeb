<?php

namespace App\Http\Controllers\Backoffice;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;
use App\Models\{
    Category,
    Archive,

};
use App\DataTables\ArchivesDataTable;
use App\DataTables\ArchivesDataTableEditor;
use DataTables;

class ManagementArchiveController extends Controller
{
    public function categoryIndex()
    {
        $categories = Category::get();
        return view('backoffice.manage_documents.categories.category_index', [
            'categories' => $categories
        ]);
    }

    public function categoryStore()
    {
        $request                    = request();
        $request->validate([
            'category_name' => 'required|string',
            'used_for'      => 'required|string',
        ]);
        $categories                 = new Category();
        $categories->category_name  = $request->category_name;
        $categories->used_for       = $request->used_for;
        $categories->save();
        \Toastr::success('Category is Created successfully!', 'Success', ["positionClass" => "toast-top-right"]);
        return redirect()->route('categories');
    }

    public function categoryUpdate()
    {
        $request    = request();
        $request->validate([
            'category_name' => 'required|string',
            'used_for'      => 'required|string'
        ]);
        $id         = $request->item_id;
        $category   = Category::findOrFail($id);
        $category->category_name    = $request->category_name;
        $category->used_for         = $request->used_for;
        $category->save();
        \Toastr::success('Category is Update successfully!', 'Success', ["positionClass" => "toast-top-right"]);
        return redirect()->route('categories');
    }

    public function categoryDestroy($id)
    {
        $category = Category::findOrFail($id);
        if(!$category) \Toastr::error('Category Not Found!', 'Error', ["positionClass" => "toast-top-right"]);
        $category->delete();
        \Toastr::success('Category is Delete successfully!', 'Success', ["positionClass" => "toast-top-right"]);
        return redirect()->route('categories');
    }

    public function archivesIndex($id=null)
    {
        $data['category'] = Category::findOrFail($id);
        return view('backoffice.manage_documents.archives.archives_index', $data);
    }


    public function tabArchives(Request $request)
    {
        $get_request_id     = $request->id;
        $category_detail    = Category::findOrFail($get_request_id??1);
        $category = Category::get();
        return view('backoffice.manage_documents.archives.archive_table', [
            'category' => $category,
            'category_detail' => $category_detail
        ]);
    }


    public function archiveShow(Request $request, $id)
    {
        /**
         * - get id
         * - tampilkan category archive
         */
        $data['no']                 = 1;
        $data['id_from_request']    = $request->input('id')??$id;
        $data['categories']         = Category::with('archives')->findOrFail($data['id_from_request']);
        $data['category']           = Category::findOrFail($data['id_from_request']);
        $data['category_for_edit']  = Category::all();

        $data['files']               = File::files(public_path('storage/uploads'));
        return view('backoffice.manage_documents.archives._archive_table', $data);
    }


    public function createDocument($id)
    {
        $data['categories'] = Category::all();
        $data['form_category'] = Category::findOrFail($id);
        return view('backoffice.manage_documents.archives._create_document', $data);
    }

    public function storeDocument(Request $request, $id)
    {

        $request->validate([
            'file' => 'required|mimes:zip,pdf,doc,docx,xls,xlsx,odt|max:20480', // Maks 20MB
            'title' => 'required|string',
            'description' => 'required|string'
        ]);
        // dd($request->file->originalName);
        // dd($request->all());

       $archive                 = new Archive();
       $archive->title          = $request->title;
       $archive->description    = $request->description;
       $archive->category_id    = $id;

       // Simpan file
       if ($request->file()) {
            // $fileName = $request->title.'_'.$request->file->getClientOriginalName();
            $fileName = $request->id.'_'.$request->title.'.'.$request->file->extension();
            $filePath = $request->file('file')->storeAs('uploads', $fileName, 'public');
       }

       $archive->file = $fileName;

       $archive->user_id        = \Auth::user()->id;
       $archive->save();
       \Toastr::success('Save archive successfully!', 'Success', ["positionClass" => "toast-top-right"]);
       return redirect()->route('documents.archiveShow', ['id' =>  $archive->category_id]);
    }


    public function download($file)
    {
        $filePath = public_path('storage/uploads/' . $file);

        if (File::exists($filePath)) {
            return Response::download($filePath);
        }

        return redirect()->route('files.index')->with('error', 'File tidak ditemukan.');
    }

    public function editArchive($id)
    {
        // return $data['get_archive_value']  = Category::with('archives')->findOrFail($id);   ,
        $getId_Req                  = request()->input('input_req_edit');
        $data['get_archive_value']  = Archive::findOrFail($getId_Req);  
        $data['categories']         = Category::all();
        $data['form_category']      = Category::findOrFail($id);
        return view('backoffice.manage_documents.archives._edit_document', $data);
    }

    public function updateArchive(Request $request)
    {
        // return request()->all();
        $getId_Req = request()->input('update_arc_id');
        $document = Archive::findOrFail($getId_Req);

        $request->validate([
            'file' => 'required|mimes:zip,pdf,doc,docx,xls,xlsx,odt|max:20480', // Maks 20MB
            'title' => 'required|string',
            'description' => 'required|string'
        ]);

        // Update title
        $document->title = $request->input('title');
        $document->description = $request->input('description');

        // Jika ada file baru yang diunggah
        if ($request->hasFile('file')) {
            // Hapus file lama jika ada
            if ($document->file) {
                $oldFilePath = public_path('storage/uploads/' . $document->file);
                if (File::exists($oldFilePath)) {
                    File::delete($oldFilePath);
                }
            }

            // Simpan file baru
            // Simpan file
            if ($request->file()) {
                // $fileName = $request->title.'_'.$request->file->getClientOriginalName();
                $fileName = $request->id.'_'.$request->title.'.'.$request->file->extension();
                $filePath = $request->file('file')->storeAs('uploads', $fileName, 'public');
            }

            $document->file = $fileName;
        }

        // return request()->input('category_id');

        $document->save();
        \Toastr::success('Edit archive successfully!', 'Success', ["positionClass" => "toast-top-right"]);
        return redirect()->route('documents.archiveShow', ['id' =>  $document->category_id]);
    }

    public function destroyArchive()
    {
        $getArchive = Archive::findOrFail(request()->input('id'));

        // Hapus file fisik jika ada
        if ($getArchive->file) {
            $file = public_path('storage/uploads/' . $getArchive->file);
            if (File::exists($file)) {
                File::delete($file);
            }
        }

        // Hapus data dari database
        $getArchive->delete();

        \Toastr::success('Edit is delete successfully!', 'Success', ["positionClass" => "toast-top-right"]);
        return redirect()->route('documents.archiveShow', ['id' =>  $getArchive->category_id]);
    }

    public function previewPdf($file)
    {
        $filePath = public_path('storage/uploads/' . $file);

        // Periksa apakah file ada
        if (!File::exists($filePath)) {
            return redirect()->back()->with('error', 'File not found.');
        }

        // Return response untuk menampilkan file PDF
        return response()->file($filePath);
    }
}
