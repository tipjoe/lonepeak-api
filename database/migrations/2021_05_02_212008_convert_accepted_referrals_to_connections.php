<?php

use App\Referral;
use App\User;
use Carbon\Carbon;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ConvertAcceptedReferralsToConnections extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $referrals = Referral::whereNotNull('redeemed')->get();
        foreach($referrals as $r) {
            // Get the referring user.
            $referrer = $r->user;

            // Get the referred user.
            $referree = User::where('referral_id', $r->id)->first();

            // Connect them.
            if ($referree) {
                $referrer->connectionsFromMe()->attach($referree->id, ['confirmed_at' => $r->updated_at]);
            }
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        echo "Sorry, dude, you're SOL!";
    }
}
