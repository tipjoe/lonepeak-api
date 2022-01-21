<?php

namespace App\Http\Controllers;

use App\Models\Location;
use App\Models\Referral;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class ReferralController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
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
        //
    }

    /**
     * Get a single resource.
     *
     * @param  \App\Models\Referral  $Referral
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, int $id)
    {
        // Lookup referral hash.
        $referral = Referral::where(
            ["hash" => $id, "redeemed" => NULL]
        )->first();

        if ($referral) {
            // See if it's expired.
            $timediff = (int) ((strtotime($referral->expires) - strtotime("now")) / 3600) + 1;
            $referrer = User::find($referral->user_id);
            $location = Location::find($referral->location_id);
            session(['referrer' => $referrer->getFullName()]);
            session(['referree_location' => $location]);
            session(['expires_in' => $timediff]);
            session(['referral_id' => $referral->id]);

            if ($timediff > 0 && !$referral->redeemed) {
                // Good, they have time left.
                // Add cookie to remember the referrer if they're already a member.
                return redirect('register')
                    ->cookie('referral_id', $referral->id);
            } else {
                // Out of time.
                $request->session()->flash(
                    'error',
                    'You tried to use an invitation link that was either expired or already used by another person. Ask ' . session('referrer') . ' for a new invitation.'
                );
                return redirect()->route('welcome');
            }
        } else {
            return redirect()->route('welcome');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Referral  $Referral
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Referral $Referral)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Referral  $Referral
     * @return \Illuminate\Http\Response
     */
    public function destroy(Referral $Referral)
    {
        //
    }

    /**
     * Get a new referral URL.
     *
     * TODO - this shouldn't be in the controller. Move to model or helper lib.
     */
    function createReferralUrl(Request $req) {
        $hash = strtoupper(substr(md5(uniqid(rand(), true)), 0, 7));
        $expires = Carbon::now()->addDay();
        $user = Auth::user();
        $location_id = $req->input("location_id");

        try {
            // First, remove expired invitations (cleanup).
            Referral::whereNull('redeemed')->where(
                "expires", "<", Carbon::now()
            )->delete();

            Referral::create([
                "location_id" => $location_id,
                "user_id" => $user->id,
                "expires" => $expires,
                "hash" => $hash
            ]);

            return response()->json([
                "code" => 200,
                "status" => "success",
                "data" => ["hash" => $hash, "expires" => $expires]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                "code" => 404,
                "status" => "problem"
            ]);
        }
    }

}
