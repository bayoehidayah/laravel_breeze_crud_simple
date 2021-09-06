<?php

namespace App\Http\Controllers;

use App\Http\Requests\BookRequest;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Yajra\DataTables\Facades\DataTables;

class BookController extends Controller
{
    public function index(){
        return view("books.index");
    }

    public function datas(){
        $datas = Book::with("maker:_id,name")->get();

        return DataTables::of($datas)
            ->addIndexColumn()
            ->editColumn("maker.name", function($datas){
                if(!$datas->maker){
                    return "";
                }

                return $datas->maker->name;
            })
            ->editColumn("created_at", function($datas){
                return $this->changeDateTimeStyle($datas->created_at, true);
            })
            ->addColumn("actions", function($datas){
                $html = "";

                $html .= '<a href="'.route("book.edit", [$datas->_id]).'" class="inline-flex items-center px-4 py-2 bg-blue-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-900 focus:outline-none focus:border-blue-900 focus:ring ring-blue-300 disabled:opacity-25 transition ease-in-out duration-150">Update</a> ';

                $html .= '<button type="button" class="inline-flex items-center px-4 py-2 bg-red-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 active:bg-red-900 focus:outline-none focus:border-red-900 focus:ring ring-red-300 disabled:opacity-25 transition ease-in-out duration-1500" onclick="deleteItem(\''.$datas->id.'\')">Delete</button>';

                return $html;
            })
            ->rawColumns(["actions"])
            ->make(true);
    }

    public function form($id = null){
        $data = [];
        if($id != null){
            $book = Book::find($id);
            if(!$book){
                return Redirect::back()->withErrors("Buku tidak temukan");
            }

            $data["book"] = $book;

        }

        return view("books.form", $data);
    }

    public function saveBook(BookRequest $request, $id = null){
        if($id != null){
            $book = Book::find($id);
            if(!$book){
                return Redirect::back()->withInput($request->all())
                    ->withErrors("Buku tidak temukan");
            }
        }

        try {
            if($id != null){
                if(!$book->update($request->all())){
                    throw new \Exception("Terjadi kesalahan dalam menyimpan data");
                }
            }
            else{
                $request->merge(["created_by" => Auth::id()]);
                if(!Book::create($request->all())){
                    throw new \Exception("Terjadi kesalahan dalam menyimpan data");
                }
            }

            return Redirect::route("book.index")->with("success", "Berhasil menyimpan data");

        } catch (\Throwable $th) {
            return Redirect::back()->withInput($request->all())
                ->withErrors($th->getMessage());
        }
    }

    public function deleteData($id){
        $book = Book::find($id);
        if(!$book){
            return response()->json([
                "result" => "error",
                "title" => "Buku tidak ditemukan"
            ]);
        }

        try {
            if(!$book->delete()){
                throw new \Exception("Terjadi kesalahan dalam menghapus data");
            }

            return response()->json([
                "result" => "success",
                "title" => "Berhasil menghapus data"
            ]);

        } catch (\Throwable $th) {
            return response()->json([
                "result" => "error",
                "title" => $th->getMessage()
            ]);
        }
    }
}
