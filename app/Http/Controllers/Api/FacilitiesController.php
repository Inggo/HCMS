<?php

namespace HCMS\Http\Controllers\Api;

use HCMS\Http\Controllers\Controller;
use Illuminate\Http\Request;
use HCMS\Http\Requests;
use HCMS\Facility;

class FacilitiesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request('search')) {
            return Facility::where('name', 'LIKE', '%' . request('search') . '%')->paginate(10);
        }

        return Facility::paginate(10);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Facility::find($id);
    }
}
