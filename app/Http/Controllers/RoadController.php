<?php

namespace App\Http\Controllers;

use App\Models\Road;
use Illuminate\Http\Request;

class RoadController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // return response()->json(Road::limit(10)->get());
        return response()->json(Road::get());
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Road  $road
     * @return \Illuminate\Http\Response
     */
    public function show(Road $road)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Road  $road
     * @return \Illuminate\Http\Response
     */
    public function edit(Road $road)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Road  $road
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Road $road)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Road  $road
     * @return \Illuminate\Http\Response
     */
    public function destroy(Road $road)
    {
        //
    }
}
