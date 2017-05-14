<?php


namespace App\Http\Controllers;
use App\Translate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class TranslateController extends Controller
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
            'store',
            'update',
            'destroy'
        ]]);
    }

    //Show All records from  database
    public function index(){

//        $translates= Translate::all();
//        return response()->json($translates);

        return $this->getEnToBgString('Say Hello');



    }

    //Show All Database by giving perPage and get params ?page
    //Simple: rootUrl/paginate/15?page=5 will response json
    public function paginate($perPage){

        $translate = DB::table('translates')->paginate($perPage);

        return response()->json(['status'=>'success','data' => $translate], 200)->header('Accept', 'application/json');
    }

    //Store Word and Meaning in Database
    public function store(Request $request){

        //Protected Zone via Api-Token Header
        $translate = new Translate;
        $this->validateRequest($request, $key='store'); //Call validation CRUD method

        $translate->word =$request->input('word');
        $translate->word_in_bg = $this->getEnToBgString($request->input('word')); //Get translate from getEnToBgString()
        $translate->meaning =$request->input('meaning');
        $translate->save();
        return response()->json(['status'=>'success','data' => $translate], 200)->header('Accept', 'application/json');

    }

    //Show certain word and Meaning from Database by giving id
    public function show(Request $request, $id){

        $translates = Translate::find($id);
        if(!$translates){
            return response()->json(['status'=>'fail','message' => "The id with {$id} doesn't exist"], 404);
        }
        return response()->json(['status'=>'success','data' => $translates], 200)->header('Accept', 'application/json');
    }


    //Show certain word and Meaning from Database by giving word
    public function showWord(Request $request, $word){

        $translates = Translate::where('word', $word)->first();

        if(!$translates){
            return response()->json(['status'=>'fail','message' => "The word  {$word} doesn't exist"], 404);
        }
        return response()->json(['status'=>'success','data' => $translates], 200);
    }

    //Update certain word and Meaning to Database by giving id
    public function update(Request $request, $id){

        //Protected Zone via Api-Token Header

        $translate  = Translate::find($id);

        $this->validateRequest($request, $key='update'); //Call validation CRUD method

        $translate->word = $request->input('word');
        $translate->word_in_bg = $this->getEnToBgString($request->input('word')); //Get translate from getEnToBgString()
        $translate->meaning =$request->input('meaning');
        $translate->save();
        return response()->json(['status'=>'success','data' => $translate], 200)->header('Accept', 'application/json');

    }

    //Delete word and Meaning from Database by giving id
    public function destroy(Request $request, $id){

        //Protected Zone via Api-Token Header

        $translate = Translate::find($id);
        if(!$translate){
            return response()->json(['status'=>'fail','message' => "The id with {$id} doesn't exist"], 404)->header('Accept', 'application/json');
        }

        $translate->delete();

        return response()->json(['status'=>'success','data' => $translate], 200)->header('Accept', 'application/json');
    }




    //Validate CRUD operation
    public function validateRequest(Request $request, $key){


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
