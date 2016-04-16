<?php

namespace HCMS\Http\Controllers\Api;

use HCMS\Http\Controllers\Controller;
use Illuminate\Http\Request;
use HCMS\Http\Requests;
use HCMS\User;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request('search')) {
            return User::where('full_name', 'LIKE', '%' . request('search') . '%')->paginate(10);
        }

        return User::paginate(10);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return User::find($id);
    }
}
