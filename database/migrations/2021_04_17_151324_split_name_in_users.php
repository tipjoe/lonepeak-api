<?php

use App\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class SplitNameInUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        User::all()->each(function ($item, $key) {
            $name = explode(" ", $item->first);
            if (strpos($item->first, '&')) {
                // Couple name.
                $item->first = $name[0] . " " . $name[1] . " " . $name[2];
                $item->last = $name[3];
            } elseif (count($name) > 2){
                // Has middle name.
                $item->first = $name[0];
                $item->middle = $name[1];
                $item->last = $name[2];
            } else {
                // First last.
                $item->first = $name[0];
                $item->last = $name[1];
            }
            $item->save();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        echo "Nothing to see here.";
    }
}
