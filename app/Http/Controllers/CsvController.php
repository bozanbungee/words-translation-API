<?php

/**
 * Controller implements csv import into DB
 *
 * ##routes
 *
 * # GET  http://localhost:8000/load_csv - Controller @loadCsv
 * Load view where user can send csv trough multipart form
 * This route accept get parameter ?api-token=API-Token from .env file. The only route that accept api-token trough get parameter
 * If api-token is not sent url return Unauthorized.
 * Form redirect and act to route http://localhost:8000/api/v1/csv/get_csv_from_upload - Controller @getFromUpload
 *
 * # POST http://localhost:8000/api/v1/csv/get_csv_from_folder - Controller @getFromFolder
 * Load csv in DB by giving file name in post parameter filename=name_of_csv without .csv extension
 */


namespace App\Http\Controllers;

use Faker\Provider\DateTime;
use Illuminate\Http\Request;
use App\Translate;
use Illuminate\Support\Facades\File;
use Maatwebsite\Excel\Facades\Excel;


class CsvController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //Protect Store controller from non authenticated User
        $this->middleware('auth',['only' => [
            'loadCsv',
            'getFromFolder'

        ]]);
    }


    //Return View for Loading file from multipart form.
    //Protected zone by auth middleware. Should be send get parameter ?api-token=API-TOKEN from .env file
    public function loadCsv(Request $request){


      return view('csv_import');



    }

    //Load Csv file from Public csv folder by giving POST parameter @file=file.csv.
    //Protected zone by auth middleware. Should be send parameter ?api-token=API-TOKEN from .env file or Api-Token header
    public function getFromFolder (Request $request)
    {

        $file = base_path() . DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR . 'csv' . DIRECTORY_SEPARATOR . $request->input('filename').'.csv';



        if (File::exists($file)){


        $data= Excel::load('public/csv/'.$request->input('filename').'.csv', function($reader) {

            })->get();

           return $this->insertCsvToDB($data);



        }
        else{
            return response()->json(['status'=>'fail','message' => "The file doesn't exist"], 404)->header('Accept', 'application/json');

        }




    }

    public function getFromUpload (Request $request)
    {

        if($request->hasFile('csv_file')){

            $path = $request->file('csv_file')->getRealPath();

            $data = Excel::load($path, function($reader) {

            })->get();


            return $this->insertCsvToDB($data);


        }

        else{
            return response()->json(['status'=>'fail','message' => "The file was not uploaded or file format is not .csv "], 404)->header('Accept', 'application/json');

        }

    }



    public function insertCsvToDB($data){



        if(!empty($data) && $data->count()){

            foreach ($data as $key => $value) {

                $insert[] = [
                    'word' => $value->word,
                    'meaning' => $value->meaning,
                    'word_in_bg' => $this->getEnToBgString($value->word),
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at'=> date('Y-m-d H:i:s')
                ];

            }

            if(!empty($insert)){

               Translate::insert($insert);

                return response()->json(['status'=>'success','data' => $insert], 200)->header('Accept', 'application/json');

            }

        }

    }


    //Validate CRUD operation
    public function validateCsv(Request $request, $key){


        $rules = [

            'store'=>[
                'word' => 'required|alpha|min:2|max:50',
                'meaning' => 'required|min:2|max:100'],

            'update'=>[
                'word' => 'required|alpha|min:2|max:50',
                'meaning' => 'required|min:2|max:100']

            //Could be add more rules for additional fileds...
        ];


        $validator = $this->validate($request, $rules[$key]);


    }


}
