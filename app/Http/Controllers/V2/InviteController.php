<?php

namespace App\Http\Controllers\V2;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\InviteCode;
use App\Http\Controllers\V2\SteamController;

class InviteController extends Controller
{

    public function index(Request $request) {
        return view('V2/index');
    }

    public function invite($invite_code, Request $request) {
        if(!self::checkInviteCode($invite_code)) {
            redirect()->route('v2index');
        }

        $request->session()->put('invite_code', $invite_code);
        return redirect(SteamController::url(route('v2steamverify', ['invite_code' => $invite_code])));
    }

    public function steamverify(Request $request) {
        $invite_code = $request->session()->get('invite_code', null);

        if(!$invite_code) {
            return redirect()->route('v2index');
        }

        SteamController::url(route('v2steamverify', ['invite_code' => $invite_code]));
    }

    /**
     * Checks if the Invite Code is good or not
     * @param $invite
     * @return bool
     */
    public static function checkInviteCode($invite_to_check) {

        $invite_row = \App\InviteCode::where('invite_code', $invite_to_check)->first();
        if(!is_object($invite_row)) {
            return false;
        }
        if($invite_row->user !== null) {
            return false;
        }
        return true;
    }

    /**
     * Assign User to an Invite Code, hereby using the invite code up.
     * @param $invite_code
     * @param $user
     * @return bool
     */
    public function assignInviteCode($invite_code, $user) {

        $invite_row = \App\InviteCode::where('invite_code', $invite_code)->first();

        if(!$invite_row || !$user) {
            return false;
        }

        if(!$user->id) {
            return false;
        }

        $invite_row->userID = $user->id;

        if(!$invite_row->save()) {
            return false;
        }

        return true;
    }
}
