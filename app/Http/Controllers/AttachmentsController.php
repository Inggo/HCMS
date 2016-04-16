<?php

namespace HCMS\Http\Controllers;

use Illuminate\Http\Request;
use HCMS\Http\Requests;
use HCMS\Attachment;

class AttachmentsController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $attachment = Attachment::find($id);
        return response()->download(storage_path('uploads/' . $attachment->filename));
    }
}
