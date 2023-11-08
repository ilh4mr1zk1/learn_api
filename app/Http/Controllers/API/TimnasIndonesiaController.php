<?php

namespace App\Http\Controllers\API;

use App\Helpers\ApiFormatter;
use App\Http\Controllers\Controller;
use App\Models\TimnasIndonesia;
use Exception;
use Illuminate\Http\Request;

class TimnasIndonesiaController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    private $appkey;

    public function __construct() {
        $value = env('APP_KEY', true);
        $this->appkey = str_replace('base64:', '', $value);
    }


    public function index(Request $request) {

        try {

            $header = $request->header('Authorization');

            if ($header == '' || $header != $this->appkey) {
                $response = array("error" => true, "errmsg" => "you have no authorized", "code" => 400, "data" => null );
                return $response;
            }

            $data = TimnasIndonesia::all();
            
            if ($data) {
                // return ApiFormatter::createApi(200, 'Sukses', $data);
                $response = array("status" => "Ok","status_code" => 200, "message" => "Sukses", "data" => $data );
                return $response;

            } else {
                return ApiFormatter::createApi(400, 'Gagal');
            }

            // $response = array("error" => false, "errmsg" => "Data Ditampilkan", "code" => 200, "data" => $data );
            // return $response;
            
        } catch (Exception $error) {
                
            return ApiFormatter::createApi(400, 'Gagal');

        }

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {

        // try {

            $header = $request->header('Authorization');

            if ($header == '' || $header != $this->appkey) {
                $response = array("error" => true, "errmsg" => "you have no authorized", "code" => 400, "data" => null );
                return $response;
            }

            // $request->validate([
            //     'nama_pemain' => 'required',
            //     'daerah_asal_pemain' => 'required',
            //     'posisi_pemain' => 'required'
            // ]);

            $required_form = [
                'nama_pemain' => $request->nama_pemain,
                'daerah_asal_pemain' => $request->daerah_asal_pemain,
                'posisi_pemain' => $request->posisi_pemain
            ];

            if ($required_form['nama_pemain'] == '') {

                $response = array("status" => "Failed","status_code" => 400, "message" => "Nama Pemain Harap Di Isi!", "data" => null );
                return response()->json($response, 400);

            } else if ($required_form['daerah_asal_pemain'] == '') {
                
                $response = array("status" => "Failed","status_code" => 400, "message" => "Daerah Asal Pemain Harap Di Isi!", "data" => null );
                return response()->json($response, 400);

            } else if ($required_form['posisi_pemain'] == '') {

                $response = array("status" => "Failed","status_code" => 400, "message" => "Posisi Pemain Harap Di Isi!", "data" => null );
                return response()->json($response, 400);

            }

            $timnasx = TimnasIndonesia::create([
                'nama_pemain' => htmlspecialchars($request->nama_pemain),
                'daerah_asal_pemain' => htmlspecialchars($request->daerah_asal_pemain),
                'posisi_pemain' => htmlspecialchars($request->posisi_pemain),
            ]);

            // $timnas = TimnasIndonesia::create([
            //     'nama_pemain' => $request->nama_pemain,
            //     'daerah_asal_pemain' => $request->daerah_asal_pemain,
            //     'posisi_pemain' => $request->posisi_pemain,
            // ]);

            $data = TimnasIndonesia::where('id', '=', $timnasx->id)->get();

            if ($data) {
                // return ApiFormatter::createApi(200, 'Sukses', $data);
                 $response = array("status" => "Created","status_code" => 201, "message" => "Sukses Tambah Data", "data" => $timnasx );
                // return $response;

                return response()->json($response, 201);

            } else {
                return ApiFormatter::createApi(400, 'Gagal');
            }

        // } catch (Exception $error) {

            // return ApiFormatter::createApi(400, 'Gagal');

        // }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request) {

        $header = $request->header('Authorization');

        if ($header == '' || $header != $this->appkey) {
            $response = array("error" => true, "errmsg" => "you have no authorized", "code" => 400, "data" => null );
            return $response;
        }

        $id = $request->id;
        // var_dump($ids); exit;

        $server = "localhost";
        $username = "root";
        $password = "";
        $database = "timnas";

        $conn = mysqli_connect($server, $username, $password, $database);

        $queryFindId = mysqli_query($conn, "SELECT * FROM timnas_indonesia WHERE id = '$id' ");
        $cek = mysqli_num_rows($queryFindId);
        // var_dump($cek);exit;

        if ($cek == 1) {

            $data = TimnasIndonesia::where('id', '=', $id)->get();

            if ($data) {
                $response = array("status" => "succes","status_code" => 200, "message" => "Data Ditemukan!", "data" => $data );
                return response()->json($response, 200);
            }

        } else {

            $response = array("status" => "Not Found","status_code" => 404, "message" => "ID Tidak Ditemukan!", "data" => Null );
            return response()->json($response, 404);

        }

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        try {

            $request->validate([
                'id' => 'required',
                'nama_pemain' => 'required',
                'daerah_asal_pemain' => 'required',
                'posisi_pemain' => 'required'
            ]);

            // $timnas = TimnasIndonesia::findOrFail($id);
            $timnas = TimnasIndonesia::find($request->input('id'));

            if ($timnas != NULL) {
                // echo "Ada";
                $timnas->update([
                    'id' => $request->id,
                    'nama_pemain' => $request->nama_pemain,
                    'daerah_asal_pemain' => $request->daerah_asal_pemain,
                    'posisi_pemain' => $request->posisi_pemain,
                ]);
                // $cariId->delete();
                $response = array("status" => "Ok","status_code" => 200, "message" => "Sukses Update Data", "data" => $timnas );
                // return $response;

                return response()->json($response, 200);
            } else {
                $response = array("status" => "Not Found","status_code" => 404, "message" => "ID Tidak Ditemukan", "data" => null );
                // return $response;
                return response()->json($response, 404);
                // return ApiFormatter::createApi(404, 'Not Found');
            }

            // $data = TimnasIndonesia::where('id', '=', $timnas->id)->get();

            // if ($data) {
            //     return ApiFormatter::createApi(200, 'Sukses', $data);
            // } else {
            //     return ApiFormatter::createApi(400, 'Gagal');
            // }

        } catch (Exception $error) {

            return ApiFormatter::createApi(400, 'Gagal');

        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request) {

        try {

            
            $server = "localhost";
            $username = "root";
            $password = "";
            $database = "timnas";

            $conn = mysqli_connect($server, $username, $password, $database);

            $cariId = TimnasIndonesia::find($request->input('id'));


            if ($cariId != NULL) {

                $cariId->delete();
                $response = array("status" => "Ok","status_code" => 200, "message" => "Sukses Hapus Data", "data" => $cariId );
                return $response;

            } else {

                $response = array("status" => "Not Found","status_code" => 404, "message" => "ID Tidak Ditemukan", "data" => null );

                return response()->json($response, 404);

            }

        } catch (Exception $error) {

            return ApiFormatter::createApi(400, 'Gagal');
            
        }

            
        // $queryFindId = mysqli_query($conn, "SELECT * FROM timnas_indonesia WHERE id = '$cariId ' ");
        // $cek = mysqli_num_rows($queryFindId);
        // var_dump($cariId['nama_pemain']);

        // $queryFindId = mysqli_query($conn, "SELECT * FROM timnas_indonesia WHERE id = '$cariId ' ");
        // // var_dump($queryFindId);
        // $cek = mysqli_num_rows($queryFindId);

        // if ($cek == 1) {

        //     $timnas = TimnasIndonesia::findOrFail($id);

        //     $data = $timnas->delete();

        //     if ($data) {
        //         // return ApiFormatter::createApi(200, 'Sukses Hapus Data', $data);
                // $response = array("status" => "Ok","status_code" => 200, "message" => "Sukses Hapus Data", "data" => $cariId );
                // return $response;
        //     }

        // } else {

        //     return ApiFormatter::createApi(404, 'ID Tidak Ditemukan!');

        // }

    }
}
