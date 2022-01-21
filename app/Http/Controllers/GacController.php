<?php

namespace App\Http\Controllers;

use App\Models\Gac;
use Illuminate\Http\Request;

class GacController extends Controller
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
     * Save individual give-a-craps.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = $request->user()->id;
        $location_id = $request->input("location_id");

        // Create new gac.
        $gac = Gac::make([
            'location_id' => $location_id,
            'user_id' => $user->id
        ]);
        $gac->save();

        if ($gac) {
            return response()->json([
                "code" => 200,
                "status" => "success"
            ]);
        } else {
            // TODO - throw httpexception.
            return response()->json([
                "code" => 404,
                "status" => "problem"
            ]);
        }
    }

    /**
     * Get a single resource.
     *
     * @param  \App\Gac  $gac
     * @return \Illuminate\Http\Response
     */
    public function show(Gac $gac)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Gac  $gac
     * @return \Illuminate\Http\Response
     */
    public function edit(Gac $gac)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Gac  $gac
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Gac $gac)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Gac  $gac
     * @return \Illuminate\Http\Response
     */
    public function destroy(Gac $gac)
    {
        //
    }
}
