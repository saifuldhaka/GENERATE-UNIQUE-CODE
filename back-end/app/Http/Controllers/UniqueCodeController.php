<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Log;
use Carbon\Carbon;
use App\UniqueCode;

class UniqueCodeController extends Controller
{
  public function __construct()
  {
      //
  }


  public function test()
  {
    $response = response()->json(
        [
            'response' => [
                'created' => Carbon::now(),
            ]
        ], 201
    );

    return $response;
  }

  public function createUniqueCode(Request $request)
  {
        $no_of_code = $request->no_of_code;
        $startTime = Carbon::now();

        $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyz';
        $codes = [];

        // save new unique code to DB
        $data = [];
        for ($i=0; $i < $no_of_code; $i++) {
          $temp = [
            'unique_code'=>  substr(str_shuffle($permitted_chars), 0, 7),
            'created_at'=>null,
            'updated_at'=>null
          ];
            // array_push($data, $temp); // if want to batch insert

            try{
              UniqueCode::insert($temp);
            }catch( \Exception $e){
              $i = $i-1; // return previous loop
              Log::info(json_encode($e->getMessage(), true));
            }

        }

        // if want to batch insert
        // foreach (array_chunk($data,1000) as $t)
        // {
        //   try{
        //     UniqueCode::insert($t);
        //   }catch( \Exception $e){
        //
        //     Log::info(json_encode($e->getMessage(), true));
        //   }
        // }

        $endTime = Carbon::now();
        $processTime = $endTime->diffInSeconds($startTime);
        $processTime = gmdate('H:i:s', $processTime);

        $format = 'Y-m-d H:i:s';
        $startTime = Carbon::createFromFormat($format, $startTime);
        $endTime = Carbon::createFromFormat($format, $endTime);

        $response = response()->json(
            [
                'response' => [
                    'start_time' => $startTime->format('Y-m-d H:i:s'),
                    'end_time' => $endTime->format('Y-m-d H:i:s'),
                    'process_time' =>$processTime
                ]
            ], 200
        );

        return $response;
    }
}
