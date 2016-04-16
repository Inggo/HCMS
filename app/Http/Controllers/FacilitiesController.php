<?php

namespace HCMS\Http\Controllers;

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
        return Facility::all();
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
