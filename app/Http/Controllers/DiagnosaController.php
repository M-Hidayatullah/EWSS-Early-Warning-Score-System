<?php

namespace App\Http\Controllers;

use App\Models\Diagnosa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;


class DiagnosaController extends Controller
{

    public function diagnosa(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'nama'             => 'required|string',
            'alamat'           => 'required',
            'usia'             => 'required|numeric',
            'tingkat_kesadaran'=> 'required|string',
            'pernafasan'       => 'required|numeric',
            'denyut_nadi'      => 'required|numeric',
            'tekanan_darah'    => 'required|numeric',
            'suhu'             => 'required|numeric'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), Response::HTTP_BAD_REQUEST);
        }


        // range  1-4
        $status_diagnosa = null;
        $keterangan_diagnosa = null;
        $diagnosa_value = $this::getDiagnosis($request->tingkat_kesadaran, $request->suhu, $request->tekanan_darah, $request->pernafasan,  $request->denyut_nadi);

        if ($diagnosa_value === 0 || $diagnosa_value === 1) {
            $status_diagnosa = 1;
            $keterangan_diagnosa = "Pasien dalam kondisi stabil.";
        }

        if ($diagnosa_value === 2 || $diagnosa_value === 3) {
            $status_diagnosa = 2;
            $keterangan_diagnosa = "Pengkajian ulang harus dilakukan oleh perawat Primer / PJ Shift.";
        }

        if ($diagnosa_value === 4 || $diagnosa_value === 5) {
            $status_diagnosa = 3;
            $keterangan_diagnosa = "Pengkajian ulang harus dilakukan oleh perawat Primer / PJ Shift dan diketahui oleh dokter jaga residen.";
        }

        if ($diagnosa_value >= 6) {
            $status_diagnosa = 4;
            $keterangan_diagnosa = "Aktifkan code blue, TMRC melakukan tatalaksana kegawatan pada pasien, dokter jaga dan DPJP diharuskan hadir disamping pasien dan berkolaborasi untuk menentukan rencana perawatan pasien selanjutnya.";
        }

        $diagnosa = Diagnosa::create([
            'nama'             => $request->nama,
            'alamat'           => $request->alamat,
            'usia'             => $request->usia,
            'tingkat_kesadaran'=> $request->tingkat_kesadaran,
            'pernafasan'       => $request->pernafasan,
            'denyut_nadi'      => $request->denyut_nadi,
            'tekanan_darah'    => $request->tekanan_darah,
            'suhu'             => $request->suhu,
            'hasil'            => $status_diagnosa,
            'keterangan_hasil' => $keterangan_diagnosa,
        ]);


        return response()->json([

            "data"=> [
                "message"   => "Hasil Diagnosa",
                'hasil' => $status_diagnosa,
                'Keterangan_Hasil' => $keterangan_diagnosa
            ],

            "response" => [

                "status"    => Response::HTTP_OK,


            ],

        ]);

    }


    private static function getDiagnosis(String $tingkat_kesadaran, Float $suhu, int $tekananDarah, int $pernafasan,  int $nadi) {

        // get value diagnosis tingkat kesadaran
        $tingkat_kesadaran_value = 0;
        if($tingkat_kesadaran === "apatis")
        {
            $tingkat_kesadaran_value = 1;
        } else if ($tingkat_kesadaran === "coma") {
            $tingkat_kesadaran_value = 3;
        } else if ($tingkat_kesadaran === "stupor") {
            $tingkat_kesadaran_value = 2;
        }else if ($tingkat_kesadaran === "somnolen"){
            $tingkat_kesadaran_value = 1;
        }else if($tingkat_kesadaran === "cpmposmentis"){
            $tingkat_kesadaran_value = 0;
        }else if ($tingkat_kesadaran === "delirium"){
            $tingkat_kesadaran_value = 2;
        }

        // get value diagnosis suhu
        $suhu_value = 0;
        if ($suhu > 38.5){
            $suhu_value = 2;
        }

        if ($suhu >= 38 && $suhu <= 38.5){
            $suhu_value = 1;
        }

        if ($suhu >= 36 && $suhu <= 38){
            $suhu_value = 0;
        }

        if ($suhu >= 35 && $suhu <= 36){
            $suhu_value = 1;
        }

        if ($suhu < 35){
            $suhu_value = 2;
        }

        // get value diagnosis tekanan_darah
        $tekananDarah_value = 0;
        if ($tekananDarah >= 200 && $tekananDarah <= 220){
            $tekananDarah_value = 2;
        }

        if ($tekananDarah >= 160 && $tekananDarah <= 199){
            $tekananDarah_value = 1;
        }

        if ($tekananDarah >= 101 && $tekananDarah <= 159){
            $tekananDarah_value = 0;
        }

        if ($tekananDarah >= 81 && $tekananDarah <= 100){
            $tekananDarah_value = 1;
        }

        if ($tekananDarah >= 71 && $tekananDarah <= 80){
            $tekananDarah_value = 2;
        }

        if ($tekananDarah < 70){
            $tekananDarah_value = 3;
        }

        if ($tekananDarah > 220){
            $tekananDarah_value = 3;
        }


        //get value diagnosis pernafasan
        $pernafasan_value = 0;
        if ($pernafasan >= 21 && $pernafasan <= 29){
            $pernafasan_value = 2;
        }

        if ($pernafasan >= 18 && $pernafasan <= 20){
            $pernafasan_value = 1;
        }

        if ($pernafasan >= 9 && $pernafasan <= 17){
            $pernafasan_value = 0;
        }

        if ($pernafasan == 8){
            $pernafasan_value = 1;
        }

        if ($pernafasan < 8){
            $pernafasan_value = 2;
        }

        if ($pernafasan > 30){
            $pernafasan_value = 3;
        }


        //  get value diagnosis nadi
        $nadi_value = 0;
        if ($nadi > 130){
            $nadi_value = 3;
        }

        if ($nadi >= 111 && $nadi <= 129){
            $nadi_value = 2;
        }

        if ($nadi >= 101 && $nadi <= 110){
            $nadi_value = 1;
        }

        if ($nadi >= 51 && $nadi <= 100){
            $nadi_value = 0;
        }

        if ($nadi >= 40 && $nadi <= 50){
            $nadi_value = 1;
        }

        if ($nadi < 40){
            $nadi_value = 2;
        }

        return $tingkat_kesadaran_value + $suhu_value + $pernafasan_value + $nadi_value + $tekananDarah_value;

    }


    public function history($id){


        $diagnosa = Diagnosa::whereId($id)->first();


        if ($diagnosa) {
            return response()->json([
                'message' => 'History Diagnosa',
                'data'    => $diagnosa,
                'success' => true,

                // "label"=> [
                //     "message"   => "Hasil Diagnosa",
                //     'hasil' => 'Berbahaya',
                //     'Keterangan_Hasil' => 'Pasien Berbahaya dan direkomendasikan ke ruangan A'
                // ],

                "response" => [

                    "status"    => Response::HTTP_OK,


                ],
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Diagnosa Tidak Ditemukan!',
                'data'    => ''
            ], 401);
        }


    }

    public function histories(){

        $diagnosa = Diagnosa::all();

        return response()->json([
            'message' => 'History Diagnosa',
            'status' => Response::HTTP_OK,
            'data' => $diagnosa
        ]);

    }


}
