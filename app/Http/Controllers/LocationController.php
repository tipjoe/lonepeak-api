<?php

namespace App\Http\Controllers;

use App\Location;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    /**
     * Get a list of locations.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // return response()->json(Location::limit(10)->get());

        $locations = Location::selectRaw('locations.address1, locations.address2,
                locations.created_at, locations.geometry, locations.id,
                locations.latitude, locations.longitude, locations.parcel,
                locations.updated_at,
                DATEDIFF(NOW(), MAX(gacs.created_at)) AS days_since_gac
                AS is_connection'
            )
            ->leftJoin('gacs', 'locations.id', 'gacs.location_id')
            ->groupBy('locations.id');

        return response()->json($locations->get());
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
     * @param  \App\Location  $location
     * @return \Illuminate\Http\Response
     */
    public function show(Location $location)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Location  $location
     * @return \Illuminate\Http\Response
     */
    public function edit(Location $location)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Location  $location
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Location $location)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Location  $location
     * @return \Illuminate\Http\Response
     */
    public function destroy(Location $location)
    {
        //
    }
}
