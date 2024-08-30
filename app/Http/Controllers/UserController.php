<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Http\Requests\UserRequest;

class UserController extends Controller
{
    function callAPI($curl, $data)
    {   
        //Encoding the data to json format
        $jsonData = json_encode($data);

        //Defining the headers
        $headers = array(
            'Content-Type: application/json',
            'Authorization: Bearer ******************' //Use huggingface personal token
        );

        // Initializing a curl session
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $curl);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        //Executing the curl session and get the response
        $response = curl_exec($ch);

        //Checking errors
        if ($response === false) {
            $error = curl_error($ch);
            curl_close($ch);
            echo "Curl Error Occured";
        }
        
        curl_close($ch);

        $response = json_decode($response, true);

        return $response;
    }

    function filter(Request $request)
    {   
        $type = 0;
        if($request->filter == 'positive') $type = 1;
        else if ($request->filter == 'negative') $type = 2;
        else if ($request->filter == 'neutral') $type = 3;
        
        if($type == 0) return redirect('home');
        else $usersData = User::where('Type', '=', $type)->get();
        return view('home', ['usersInfo'=>$usersData, 'isSelect'=>$type]);
    }

    function update($id)
    {
        $usersData = User::find($id);
        return view('update-comment', ['data'=>$usersData]);
    }

    function updateComment(UserRequest $request, $id)
    {
        $curl = "https://api-inference.huggingface.co/models/cardiffnlp/twitter-roberta-base-sentiment-latest";

        //Preparing data to sent to the request body
        $data = array(
            "inputs" => $request->userComment
        );

        $response = $this->callAPI($curl, $data);

        //1-Positive, 2-Negative, 3-Neutral
        $type = 1;
        if($response[0][0]['label'] == "positive") $type = 1;
        else if($response[0][0]['label'] == "negative") $type = 2;
        else if($response[0][0]['label'] == "neutral") $type = 3;
        
        $usersData = User::find($id);

        $usersData->ID = $request->userID;
        $usersData->Name = $request->userName;
        $usersData->Comment = $request->userComment;
        $usersData->Type = $type;
        
        if($usersData->save()){
            return redirect('home');
        }
        else{
            return "Update failed";
        }
    }

    function deleteComment($id)
    {
        $isDeleted = User::destroy($id);
        if($isDeleted){
            return redirect('home');
        }
    }

    function allComments()
    {
        $usersData =  User::all();
        return view('home', ['usersInfo'=>$usersData]);
    }

    function addComment(UserRequest $request)
    {
        $curl = "https://api-inference.huggingface.co/models/cardiffnlp/twitter-roberta-base-sentiment-latest";

        //Preparing data to sent to the request body
        $data = array(
            "inputs" => $request->userComment
        );

        $response = $this->callAPI($curl, $data);

        //1-Positive, 2-Negative, 3-Neutral
        $type = 1;
        if($response[0][0]['label'] == "positive") $type = 1;
        else if($response[0][0]['label'] == "negative") $type = 2;
        else if($response[0][0]['label'] == "neutral") $type = 3;

        $user = new User();
        $user->ID = $request->userID;
        $user->Name = $request->userName;
        $user->Comment = $request->userComment;
        $user->Type = $type;
        $user->save();

        if($user){
            return redirect('home');
        }
        else{
            echo "Process failed!";
        }
    }

    function search(Request $request)
    {   
        $usersInfo =  User::all();
        $searchKey = $request->searchComments;

        if($searchKey==NULL) return redirect('home');

        //Decoding the json to an array
        $decodedUsersInfo = json_decode($usersInfo, true);

        $comments = array();

        foreach($decodedUsersInfo as $item)
        {
            $comments[] = $item['Comment'];
        }

        $curl = "https://api-inference.huggingface.co/models/sentence-transformers/all-MiniLM-L6-v2";

        //Preparing data to sent to the request body
        $data = array(
            "inputs" => array(
                "source_sentence" => $searchKey,
                "sentences" => $comments
            )
        );

        $response = $this->callAPI($curl, $data);

        arsort($response);

        $threshold = 0.40;
        $slice = 1;

        foreach($response as $index => $val)
        {   
            if($val < $threshold) break;
            $slice += 1;
        }

        $response = array_slice($response, 0, $slice, true);

        $responseArray = array_keys($response);
        $searchResults = [];
        foreach($responseArray as $index => $val)
        {
            $searchResults [] = $usersInfo[$val];
        }

        return view('home', ['usersInfo'=>$searchResults, 'searchInfo'=>$request->searchComments]);
    }
}
