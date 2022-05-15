<?php

namespace App\Http\Controllers;

use App\Models\Location;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    /**
     * Get a list of locations (full data with geo-info) with days since
     * last GAC. Used for Give-a-Crap Map with colors.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $locations = Location::selectRaw('locations.address1, locations.address2,
                locations.created_at, locations.geometry, locations.id,
                locations.latitude, locations.longitude, locations.parcel,
                locations.updated_at,
                DATEDIFF(NOW(), MAX(gacs.created_at)) AS days_since_gac'
            )
            ->leftJoin('gacs', 'locations.id', 'gacs.location_id')
            ->groupBy('locations.id');

        return response()->json($locations->get());
    }

    /**
     * Get a list of location IDs and addresses (address1).
     *
     * @return \Illuminate\Http\Response
     */
    public function addresses()
    {
        $locations = Location::select('id', 'address1')->get();
        return response()->json($locations);
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
     * @param  \App\Location  $location
     * @return \Illuminate\Http\Response
     */
    public function show(Location $location)
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
