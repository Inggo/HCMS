<?php

namespace HCMS\Http\Controllers;

use Illuminate\Http\Request;
use HCMS\Http\Requests;
use HCMS\Attachment;
use HCMS\Complaint;
use HCMS\Reply;
use Auth;

class RepliesController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $complaint = Complaint::find($request->input('complaint_id'));

        $reply = Reply::create([
            'user_id'      => Auth::user()->id,
            'complaint_id' => $complaint->id,
            'content'      => $request->input('content'),
            'from_assigned_user_id' => $complaint->assigned_user_id,
            'to_assigned_user_id'   => $request->has('assigned_user_id') ?
                $request->input('assigned_user_id') :
                $complaint->assigned_user_id,
        ]);

        // Update complaint info
        if ($request->has('assigned_user_id') && $complaint->assignedUser->id != $request->input('assigned_user_id')) {
            $complaint->assigned_user_id = $request->input('assigned_user_id');
            $complaint->save();
        }

        if ($request->has('category') && $complaint->category != $request->input('category')) {
            $complaint->category = $request->input('category');
            $complaint->save();
        }

        if ($request->has('status') && $complaint->status != $request->input('status')) {
            $complaint->status = $request->input('status');
            $complaint->save();
        }

        // Store file within reply
        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                $filename = $file->getClientOriginalName() . '.' . $file->getClientOriginalExtension();
                $attachment = Attachment::create([
                    'reply_id' => $reply->id,
                    'filename' => $filename,
                ]);
                $file->move(storage_path('uploads'), $filename);
            }
        }

        $complaint->touch();

        return back()->with('success', true);
    }
}
