<?php

namespace App\Http\Controllers;

use App\Referral;
use App\Road;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MapController extends Controller
{

    /**
     * Get geojson road data for the give-a-crap map.
     */
    public function getRoads()
    {
        // return response()->json(Road::limit(10)->get());
        return response()->json(Road::get());
    }

    /**
     * Get a new referral URL.
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
