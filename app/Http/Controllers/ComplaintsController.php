<?php

namespace HCMS\Http\Controllers;

use Illuminate\Http\Request;
use HCMS\Http\Requests;
use HCMS\Attachment;
use HCMS\Complaint;
use HCMS\Reply;
use HCMS\User;
use Auth;

class ComplaintsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Complaint::where(['user_id' => Auth::user()->id])->get();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('complaints.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Store complaint
        $complaint = Complaint::create([
            'title'       => $request->input('title'),
            'facility_id' => $request->input('facility_id'),
            'user_id'     => Auth::user()->id,
        ]);

        // Store reply
        $reply = Reply::create([
            'complaint_id' => $complaint->id,
            'user_id'      => Auth::user()->id,
            'content'      => $request->input('content'),
        ]);

        // Store file within complaint
        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                $attachment = Attachment::create([
                    'reply_id' => $reply->id,
                    'filename' => $file->getClientOriginalName() .
                            '.' . $file->getClientOriginalExtension()
                ]);
                $file->move(storage_path('uploads'));
            }
        }

        return back()->with('success', true);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $complaint = Complaint::find($id);

        if (!$complaint->isViewableBy(Auth::user())) {
            return abort(403);
        }

        return $complaint;
    }
}
