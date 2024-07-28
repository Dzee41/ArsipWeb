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

use Illuminate\Support\Facades\Log;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Str;
use Carbon\Carbon;

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
        try {
            $request = request();
            $request->validate([
                'category_name' => 'required|string',
                'used_for'      => 'required|string',
                'tab_routes'      => 'nullable|string',
            ],
            [
                'category_name.required' => 'Nama kategori wajib di isi!',
                'used_for.required' => 'Deskripsi wajib di isi!',
            ]);
            $categories                 = new Category();
            $categories->category_name  = $request->category_name;
            $categories->used_for       = $request->used_for;        
            $categories->tab_routes     = $request->tab_routes ?: Str::slug($request->category_name, '_');
            $categories->save();
            Alert::success('Success', 'Kategori berhasil dibuat!');
            return redirect()->route('categories');
        } catch (\Exception $e) {
            Alert::error('Error', ''. $e->getMessage());
            return redirect()->back()->withInput();
        }               
    }

    public function categoryUpdate()
    {
        try {
            $request    = request();
            $request->validate([
                'category_name' => 'required|string',
                'used_for'      => 'required|string'
            ],
            [
                'category_name.required' => 'Nama kategori wajib di isi!',
                'used_for.required' => 'Deskripsi wajib di isi!',
            ]);
            $id         = $request->item_id;
            $category   = Category::findOrFail($id);
            $category->category_name    = $request->category_name;
            $category->used_for         = $request->used_for;
            $category->save();
            
            Alert::success('Success', 'Update kategori berhasil!');
            return redirect()->route('categories');
        } catch (\Exception $e) {
            Alert::error('Error', ''. $e->getMessage());
            return redirect()->back()->withInput();
        }            
    }

    public function categoryDestroy($id)
    {
        try {
            $category = Category::findOrFail($id);

            // Cek kategori berelasi dengan tabel 'archives'
            if ($category->archives()->exists()) {
                Alert::error('Error', 'Gagal hapus, kategori mempunyai koneksi!');
                return redirect()->back()->withInput();
            }

            $category->delete();

            Alert::success('Success', 'Hapus kategori berhasil!');
            return redirect()->route('categories');
        } catch (\Exception $e) {
            Alert::error('Error', ''. $e->getMessage());
            return redirect()->back()->withInput();
        }     

        
    }

    // ------------------------------------------------------------------------------------
    // ------------------------------------------------------------------------------------
    // ------------------------------------------------------------------------------------

    public function archivesIndexAll()
    {
        $archives = Archive::with('category')->get();

        // format tgl
        foreach ($archives as $archive) {
            $archive->formatted_created_at = Carbon::parse($archive->created_at)->isoFormat('dddd, D MMMM YYYY, HH:mm', 'id');
            $archive->formatted_updated_at = Carbon::parse($archive->updated_at)->isoFormat('dddd, D MMMM YYYY, HH:mm', 'id');
        }

        return view('backoffice.manage_documents.archives.archives_all_index', [
            'archives' => $archives,
        ]);
    }

    // Deprecated !!
    public function archivesIndex($id=null)
    {
        $data['category'] = Category::findOrFail($id);
        return view('backoffice.manage_documents.archives.archives_index', $data);
    }

    // Deprecated !!
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


    // Filtered
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

        // format tgl
        foreach ($data['categories']->archives as $archive) {
            $archive->formatted_created_at = Carbon::parse($archive->created_at)->translatedFormat('l, j F Y, H:i');
            $archive->formatted_updated_at = Carbon::parse($archive->updated_at)->translatedFormat('l, j F Y, H:i');
        }

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

        try {
            $request->validate([
                'file' => 'required|mimes:zip,pdf,doc,docx,xls,xlsx,odt,mp4|max:20480', // Maks 20MB
                'title' => 'required|string',
                'description' => 'required|string',
                'category_id' => 'required|integer'
            ],
            [
                'file.required' => "File wajib di isi!",
                'file.mimes' => "Ekstensi file tidka valid, hanya bisa zip, pdf, doc, docx, xls, xlsx, odt, mp4!",
                'file.max' => "Size terlalu besar, max 20MB!",
                'title.required' => "Title wajib di isi!",
                'description.required' => "Description wajib di isi!",
                'category_id.required' => "Category wajib di isi!",
            ]);
    
            $archive                 = new Archive();
            $archive->title          = $request->title;
            $archive->description    = $request->description;
            $archive->category_id    = $request->category_id;
    
            // Simpan file
            if ($request->hasFile('file')) {
                $file = $request->file('file');
                $fileExtension = $file->extension();
                $allowedExtensions = ['zip', 'pdf', 'doc', 'docx', 'xls', 'xlsx', 'odt', 'mp4'];
    
                if (!in_array($fileExtension, $allowedExtensions)) {
                    throw new \Exception('Invalid file extension.');
                }
    
                $fileName = $request->id.'_'.$request->title.'.'.$request->file->extension();
                $filePath = $request->file('file')->storeAs('uploads', $fileName, 'public');
                $archive->file = $fileName;
            } else {
                throw new \Exception('ss');
                return redirect()->back()->withInput();
            }
    
            $archive->user_id        = \Auth::user()->id;
            $archive->save();
            Alert::success('Success', 'Tambah data berhasil!');
            return redirect()->route('documents.archiveShow', ['id' =>  $archive->category_id]);
        } catch (\Exception $e) {
            Alert::error('Error', ''. $e->getMessage());
            return redirect()->back()->withInput();
        }        
    }


    public function download($file)
    {
        // Path relatif dari folder `public/storage`
        $filePath = storage_path('app/public/uploads/' . $file);

        if (File::exists($filePath)) {
            return Response::download($filePath);
        }
    
        return redirect()->to('documents')->with('error', 'File tidak ditemukan.');
    }
    

    public function editArchive($id)
    {
        // return $data['get_archive_value']  = Category::with('archives')->findOrFail($id);   ,
        $getId_Req                  = request()->input('input_req_edit');
        $data['get_archive_value']  = Archive::findOrFail($getId_Req);  
        $data['categories']         = Category::all();
        // $data['form_category']      = Category::findOrFail($id);

        return view('backoffice.manage_documents.archives._edit_document', $data);
    }

    public function updateArchive(Request $request)
    {
        try {
            $getId_Req = request()->input('update_arc_id');
            $document = Archive::findOrFail($getId_Req);
    
            $request->validate([
                'file' => 'mimes:zip,pdf,doc,docx,xls,xlsx,odt,mp4|max:20480', // Maks 20MB
                'title' => 'required|string',
                'description' => 'required|string',
                'category_id' => 'required|integer'
            ],
            [
                'file.mimes' => "Ekstensi file tidka valid, hanya bisa zip, pdf, doc, docx, xls, xlsx, odt, mp4!",
                'file.max' => "Size terlalu besar, max 20MB!",
                'title.required' => "Title wajib di isi!",
                'description.required' => "Description wajib di isi!",
                'category_id.required' => "Category wajib di isi!",
            ]);
    
            $document->title = $request->input('title');
            $document->description = $request->input('description');
    
            if ($request->hasFile('file')) {
                if ($document->file) {
                    $oldFilePath = public_path('storage/uploads/' . $document->file);
                    if (File::exists($oldFilePath)) {
                        File::delete($oldFilePath);
                    }
                }
    
                if ($request->file()) {
                    $fileName = $document->id.'_'.$request->title.'.'.$request->file->extension();
                    $filePath = $request->file('file')->storeAs('uploads', $fileName, 'public');
                }
    
                $document->file = $fileName;
            }
    
            $document->save();
            Alert::success('Success', 'Edit data berhasil!');
            return redirect()->to('/documents');
        } catch (\Throwable $th) {
            Alert::error('Error', ''. $e->getMessage());
            return redirect()->back()->withInput();
        }
    }

    public function destroyArchive($id)
    {
        try {
            $getArchive = Archive::findOrFail($id);

            // Hapus file fisik jika ada
            if ($getArchive->file) {
                $file = storage_path('app/public/uploads/' . $getArchive->file);
                if (File::exists($file)) {
                    File::delete($file);
                }
            }
    
            // Hapus data dari database
            $getArchive->delete();
    
            Alert::success('Success', 'Hapus data berhasil!');
        } catch (\Exception $e) {
            Alert::error('Error', 'Terjadi kesalahan saat menghapus data: ' . $e->getMessage());
        }
        return redirect()->to('/documents');
    }

    public function previewFile($id, $file)
    {

        $archive = Archive::findOrFail($id);
        $filePath = storage_path('app/public/uploads/' . $file);

        // Periksa apakah file ada
        if (!File::exists($filePath)) {
            return redirect()->back()->with('error', 'File not found.');
        }

        $fileMimeType = File::mimeType($filePath);
        $fileUrl = asset('storage/uploads/' . $file);

        switch ($fileMimeType) {
            case 'application/pdf':
                return view('backoffice.manage_documents.archives.preview_file', [
                    'fileType' => 'pdf', 
                    'fileUrl' => $fileUrl,
                    'archive' => $archive
                ]);

            case 'video/mp4':
                return view('backoffice.manage_documents.archives.preview_file', [
                    'fileType' => 'video', 
                    'fileUrl' => $fileUrl,
                    'archive' => $archive
                ]);

            default:
                return response()->download($filePath);
        }
    }

    public function checkFile($file)
    {
        $filePath = storage_path('app/public/uploads/' . $file);

        if (File::exists($filePath)) {
            return response()->json(['exists' => true]);
        }

        return response()->json(['exists' => false]);
    }
}
