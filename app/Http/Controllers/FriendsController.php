<?php

namespace App\Http\Controllers;

use App\Mail\InviteMail;
use App\Models\Friend;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use PHPUnit\Exception;
use URL;



class FriendsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Show Friends List According to Logged User by Sasi Spenzer
        $Currentuser = Auth::user()->id;
        $friends = Friend::where('user_id', $Currentuser)->where('is_accepted',1)->get()->toArray();

        return view('friends.friends_list',['friends'=>$friends]);
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
    public function store(Request $request)
    {
        try {
            $userID = $request->id;
            $userData = Friend::find($userID);
            $userData->user_id = 0;
            $userData->save();
        } catch (\Exception $exception){
            return $exception->getMessage();
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

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
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function inviteFriends(Request $request){

        $request->validate([
            'email' => 'required|email',
        ]);
        $friendCheck = Friend::where('friend_email', '=',  $request->email)->where('user_id',Auth::user()->id)->first();

        if ($friendCheck === null) {
            $requestEmail = $request->email;
            $userName = Auth::user()->firstname;
            $userID= Auth::user()->id;

            // Save inviting Email
            $user = new Friend();


            $user->friend_email = $requestEmail;
            $user->friend_status = 1;
            $user->created_at = date('Y-m-d');
            $user->updated_at = date('Y-m-d');
            $user->user_id = $userID;
            $user->is_accepted = 0;

            $user->save();

            $newFriendID = $user->id;

            // Generate URL
            $base = URL::to('/');
            $urlCreated = $base.'/global_invite/'.base64_encode($newFriendID);

            $mailIncludes = [
                'url' => $urlCreated,
                'sender_name' => $userName,
            ];

            Mail::to($requestEmail)->send(new InviteMail($mailIncludes));
        } else {
            $erorReturn = array();
            $erorReturn['status'] = false;
            $erorReturn['msg'] = 'This user is Already Invited or Already in your Friend List';
            return $erorReturn;
        }



    }

    public function acceptFriends(Request $request){

        // Decode the ID
        $userID = base64_decode($request->id);

        try{
            $friend = Friend::find($userID);
            $friend->is_accepted = 1;
            $friend->id = $userID;
            $friend->save();
            return view('friends.thank_you_page');
        } catch (Exception $exception){
            return $exception->getCode();
        }


    }

}
