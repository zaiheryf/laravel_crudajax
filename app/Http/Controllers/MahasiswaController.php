<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\MahasiswaModel; //load model yang digunakan

class MahasiswaController extends Controller
{
    //method yang dipanggil pertama kali
    public function index(){
        return view('mahasiswa_index'); //load view
    }

    //method untuk tampilkan data di tabel
    public function data(){
        $data  = MahasiswaModel::select("*")->orderBy('created_at', 'DESC')->get(); //query get semua data ke model
        $form = view("mahasiswa_data", ['data' => $data]); //passing data ke view
        $darr=array('data'=>''.$form.''); //convert ke bentuk array
        return response()->json($darr); //convert ke respone json
    }

    //method untuk tampilkan form input
    public function input(){
        $form = view("mahasiswa_input"); //load view
        $darr=array('data'=>''.$form.''); //convert ke bentuk array
        return response()->json($darr); //convert ke respone json
    }

    //method untuk insert data
    public function create(Request $request)
    {   
        $postall = $request->all(); //tangkap semua parameter yang di post
        $inputclear = \Arr::except($request->all(), array('_token', '_method')); //pisahkan parameter token 
        $npm = $request->input('npm'); //tangkap parameter npm yang di post

        $cek = MahasiswaModel::where('npm', '=', $npm)->count(); //query cek npm apakah sudah ada di tabel atau belum
        if($cek) {
            return response()->json([ //respon json jika gagal
                'status' => false,
                'info' => "NPM Sudah ada di database"
            ], 201);
            return false;
        }

        $post = MahasiswaModel::create($inputclear); //jika lolos pengecekan npm maka query insert ini jalan 
        return response()->json([ //respon json jika berhasil
            'status' => true,
            'info' => 'Success'
        ], 201);
    }

    //method untuk tampilkan form edit
    public function edit(Request $request)
    {
        $where = array('id' => $request->input('id')); //tangkap parameter id yang di post
        $post  = MahasiswaModel::where($where)->first(); //get ke tabel di model berdasarkan id

        $form = view("mahasiswa_edit", ['data' => $post]); //passing data ke view
        $darr=array('data'=>''.$form.''); //convert ke bentuk array
        return response()->json($darr); //convert ke respone json
    }

    //method untuk update data
    public function update(Request $request)
    {
        $postall = $request->all(); //tangkap semua parameter yang di post
        $inputclear = \Arr::except($request->all(), array('_token', '_method')); //pisahkan parameter token 
        $id = $request->input('id'); //tangkap parameter id yang di post
        $npm = $request->input('npm'); //tangkap parameter npm yang di post

        $npm_b = MahasiswaModel::select('npm')->where('id', $id)->first(); //get data by id untuk dapatkan npm lama 

        $cek = MahasiswaModel::where([ //query cek npm apakah sudah ada di tabel atau belum dibandingkan dengan npm baru dan lama
            ['npm', '!=', $npm_b->npm],
            ['npm', '=', $npm]
        ])->count();
        if($cek) {
            return response()->json([ //respon json jika gagal
                'status' => false,
                'info' => "NPM Sudah ada di database"
            ], 201);
            return false;
        }

        MahasiswaModel::where('id', $id)->update($inputclear); //jika lolos pengecekan npm maka query update ini jalan 
        return response()->json([ //respon json jika berhasil
            'status' => true,
            'info' => "Success"
        ], 201);
    }

    //method untuk delete data
    public function destroy($id)
    {
        MahasiswaModel::where('id', $id)->delete(); //query delete data berdasarkan id
        return response()->json([ //respon json jika berhasil
            'status' => true,
            'info' => "Success"
        ], 201);
    }

}
