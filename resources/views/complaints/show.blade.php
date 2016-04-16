@extends('layouts.app')

@section('header')
<link href="{{ asset('css/select2.min.css') }}" rel='stylesheet' type='text/css'>
<style>
.btn-file {
    position: relative;
    overflow: hidden;
}
.btn-file input[type=file] {
    position: absolute;
    top: 0;
    right: 0;
    min-width: 100%;
    min-height: 100%;
    font-size: 100px;
    text-align: right;
    filter: alpha(opacity=0);
    opacity: 0;
    outline: none;
    background: white;
    cursor: inherit;
    display: block;
}
</style>
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Viewing Complaint #{!! $complaint->id !!}</div>

                <div class="panel-body">

                    <div class="col-md-6 col-md-offset-3">

                        @if (session('success'))
                        <div class="alert alert-success alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            Successfully saved your response!
                        </div>
                        @endif

                        <form method="POST" id="complaint-instant-update" action="{{ action('RepliesController@store') }}">
                            {!! csrf_field() !!}
                            <fieldset class="form-group">
                                <label for="title">Complaint Title</label>
                                <input type="text" class="form-control" id="title" placeholder="" name="title" disabled="" value="{{ $complaint->title }}" style="cursor: default;">
                            </fieldset>
                            <fieldset class="form-group">
                                <label for="title">Complaint Description</label>
                                <textarea class="form-control" rows="5" id="content" name="content" disabled style="cursor: default">{!! $complaint->replies()->first()->content !!}</textarea>
                            </fieldset>
                            <fieldset class="form-group">
                                <label for="facility_id">Hospital / Facility</label>
                                <input type="text" class="form-control" id="facility_id" name="facility_id" disabled="" value="{{ $complaint->facility->name }}" style="cursor: default;">
                            </fieldset>
                            <fieldset class="form-group">
                                <label for="status">Status</label>
                                <select class="form-control" name="status" id="status">
                                    @foreach (HCMS\Complaint::$statuses as $status => $label)
                                    <option value="{{ $status }}"{{ $label === $complaint->status ? ' selected' : '' }}>{!! $label !!}</option>
                                    @endforeach
                                </select>
                            </fieldset>
                            <fieldset class="form-group">
                                <label for="assigned">Assigned To</label>
                                <select class="form-control" id="assigned_user_id" name="assigned_user_id">
                                    <option value="{{ $complaint->assignedUser->id }}" selected="selected">{!! $complaint->assignedUser->full_name !!} ({!! $complaint->assignedUser->email !!})</option>
                                </select>
                            </fieldset>
                            <fieldset class="form-group">
                                <label for="category">Category</label>
                                <select class="form-control" id="category" name="category">

                                    <option value="Not Set">Not Set</option>
                                    <optgroup label="Clinical Quality">
                                        <option value="Examinations"{{ $complaint->category === 'Examinations' ? ' selected' : '' }}>Examinations</option>
                                        <option value="Patient journey"{{ $complaint->category === 'Patient Journey' ? ' selected' : '' }}>Patient Journey</option>
                                        <option value="Quality of care"{{ $complaint->category === 'Quality of care' ? ' selected' : '' }}>Quality of care</option>
                                        <option value="Treatment"{{ $complaint->category === 'Treatment' ? ' selected' : '' }}>Treatment</option>
                                    </optgroup>

                                    <optgroup label="Clinical Safety">
                                        <option value="Errors in diagnosis"{{ $complaint->category === 'Errors in diagnosis' ? ' selected' : '' }}>Errors in diagnosis</option>
                                        <option value="Medication errors"{{ $complaint->category === 'Medication errors' ? ' selected' : '' }}>Medication errors</option>
                                        <option value="Safety incidents"{{ $complaint->category === 'Safety incidents' ? ' selected' : '' }}>Safety incidents</option>
                                        <option value="Skills and conduct"{{ $complaint->category === 'Skills and conduct' ? ' selected' : '' }}>Skills and conduct</option>
                                    </optgroup>

                                    <optgroup label="Institutional Issues">
                                        <option value="Bureaucracy"{{ $complaint->category === 'Bureaucracy' ? ' selected' : '' }}>Bureaucracy</option>
                                        <option value="Environment"{{ $complaint->category === 'Environment' ? ' selected' : '' }}>Environment</option>
                                        <option value="Finance and billing"{{ $complaint->category === 'Finance and billing' ? ' selected' : '' }}>Finance and billing</option>
                                        <option value="Service issues"{{ $complaint->category === 'Service issues' ? ' selected' : '' }}>Service issues</option>
                                        <option value="Staffing and resources"{{ $complaint->category === 'Staffing and resources' ? ' selected' : '' }}>Staffing and resources</option>
                                    </optgroup>

                                    <optgroup label="Timing and Access">
                                        <option value="Access and admission"{{ $complaint->category === 'Access and admission' ? ' selected' : '' }}>Access and admission</option>
                                        <option value="Delays"{{ $complaint->category === 'Delays' ? ' selected' : '' }}>Delays</option>
                                        <option value="Discharge"{{ $complaint->category === 'Discharge' ? ' selected' : '' }}>Discharge</option>
                                        <option value="Referrals"{{ $complaint->category === 'Referrals' ? ' selected' : '' }}>Referrals</option>
                                    </optgroup>

                                    <optgroup label="Communication">
                                        <option value="Communication breakdown"{{ $complaint->category === 'Communication breakdown' ? ' selected' : '' }}>Communication breakdown</option>
                                        <option value="Incorrect information"{{ $complaint->category === 'Incorrect information' ? ' selected' : '' }}>Incorrect information</option>
                                        <option value="Patient-staff dialogue"{{ $complaint->category === 'Patient-staff dialogue' ? ' selected' : '' }}>Patient-staff dialogue</option>
                                    </optgroup>

                                    <optgroup label="Humaneness / Caring">
                                        <option value="Respect, dignity, and caring"{{ $complaint->category === 'Respect, dignity, and caring' ? ' selected' : '' }}>Respect, dignity, and caring</option>
                                        <option value="Staff attitudes"{{ $complaint->category === 'Staff attitudes' ? ' selected' : '' }}>Staff attitudes</option>
                                    </optgroup>

                                    <optgroup label="Patient Rights">
                                        <option value="Abuse"{{ $complaint->category === 'Abuse' ? ' selected' : '' }}>Abuse</option>
                                        <option value="Confidentiality"{{ $complaint->category === 'Confidentiality' ? ' selected' : '' }}>Confidentiality</option>
                                        <option value="Consent"{{ $complaint->category === 'Consent' ? ' selected' : '' }}>Consent</option>
                                        <option value="Discrimination"{{ $complaint->category === 'Discrimination' ? ' selected' : '' }}>Discrimination</option>
                                    </optgroup>

                                </select>
                            </fieldset>
                            <input type="hidden" name="complaint_id" value="{{ $complaint->id }}">
                            <input type="hidden" name="content" value="Updated complaint information">
                            <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Save</button>
                            <div class="text-center" style="padding:0px">
                                <text><strong>Attachments</strong></text>
                                <hr style="display: block; border-style: inset; padding-top:0px;
               border-width: 2px;">
                                @if ($complaint->replies()->first()->attachments)

                                @foreach ($complaint->replies()->first()->attachments as $attachment)
                                    <a href="{{ action('AttachmentsController@show', $attachment->id) }}">{!! $attachment->filename !!}</a>
                                @endforeach

                                @endif
                            </div>
                        </form>
                    </div>
                </div>
                <div class="row">
                    @foreach ($complaint->replies()->skip(1)->take(100)->get() as $reply)
                    <div class="well col-md-10 col-md-offset-1" style="{{ $complaint->user->id === $reply->user->id ? 'background: #8c8cff;' : '' }}">
                        <div style="margin-top: 0px; overflow: hidden;" class="text-left">
                            <img src="http://www.gravatar.com/avatar/{{ md5(trim($reply->user->email))}}" style="float:right; display:inline;" />  
                            <h4><strong>{{ $reply->user->full_name }}</strong></h4> 
                            <h5 style="font-size: 14px;"><strong>{{ $reply->created_at->diffForHumans() }}</strong></h5>
                        </div>
                        <div style="width:100%; font-size: 16px; padding: 10px; margin: 0 0 10px; border: 1px solid #ddd; background: #ccc;" class="text-justify">{!! $reply->content !!}</div>
                        @if ($reply->attachments)
                        <ul>
                            @foreach ($reply->attachments as $attachment)
                            <li>
                                <a href="{{ action('AttachmentsController@show', $attachment->id) }}">{!! $attachment->filename !!}</a>
                            </li>
                            @endforeach
                        </ul>
                        @endif
                    </div>
                    @endforeach
                </div>
                <div class="row">
                    <div class="col-md-10 col-md-offset-1">
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#respond" style="margin-bottom: 20px">Respond</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>




<div id="respond" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Action</h4>
      </div>
      <form method="POST" id="response-form" action="{{ action('RepliesController@store') }}"  enctype="multipart/form-data">
        {!! csrf_field() !!}
        <input type="hidden" name="complaint_id" value="{{ $complaint->id }}">
        <div class="modal-body">
            <fieldset class="form-group">
                <label for="respond">Response</label>
                <textarea class="form-control" rows="5" id="content" name="content"></textarea>
            </fieldset>

            <fieldset class="form-group">
                <label for="attachments">Attach Files</label>
                <br>
                <div class="input-group">
                    <span class="input-group-btn">
                    <span class="btn btn-primary btn-file">
                Browse<input type="file" id="attachments" name="attachments[]" multiple>
              </span>
            </span>
            <input type="text" class="form-control" placeholder="Filename" readonly style="cursor:context-menu;">
          </div>
        </fieldset>
      </div>
      <div class="modal-footer">
        <input type="submit" class="btn btn-primary" value="submit"> 
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </form>
  </div>

</div>
</div>

@endsection

@section('footer')
<script src="{{ asset('js/select2.full.min.js') }}"></script>

<script type="text/javascript">

function formatUser (user) {
    if (user.loading) return user.text;

    var markup = "<div class='select2-result-repository clearfix'>" +
        "<div class='select2-result-repository__meta'>" +
          "<div class='select2-result-repository__title'>" + user.full_name + "</div>";

    if (user.email) {
        markup += "<div class='select2-result-repository__description'>" + user.email + "</div>";
    }

    return markup;
}

function formatUserSelection (user) {
    return user.text || (user.full_name + '(' + user.email + ')');
}

(function($) {
    $("#assigned_user_id").select2({
        ajax: {
            url: '{!! action('Api\UsersController@index'); !!}',
            dataType: 'json',
            delay: 250,
            data: function (params) {
                return {
                    search: params.term,
                    page: params.page
                };
            },
            processResults: function (result, params) {
                params.page = params.page || 1;

                return {
                    results: result.data,
                    pagination: {
                        more: result.current_page < result.last_page
                    }
                };
            },
            cache: true
        },
        escapeMarkup: function (markup) {
            return markup;
        },
        minimumInputLength: 1,
        templateResult: formatUser,
        templateSelection: formatUserSelection
    });

    $(document).on('change', '.btn-file :file', function () {
        var input = $(this),
        numFiles = input.get(0).files ? input.get(0).files.length : 1,
        label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
        input.trigger('fileselect', [ numFiles, label]);
    });

    $(document).ready(function() {
        $('.btn-file :file').on('fileselect', function(event,  numFiles, label) {

            var input = $(this).parents('.input-group').find(':text'),
            log = numFiles > 1 ? numFiles + ' files selected' : label;

            if (input.length) {
                input.val(log);
            }
        });
    });

    // $(document).on('submit', 'form', function(e) {
    //     // e.preventDefault();

    //     var $form  = $(this),
    //         data   = new FormData(),
    //         params = $form.serializeArray(),
    //         files  = $form.find('#attachments')[0].files;

    //     $.each(files, function(i, file) {
    //         data.append('attachments[' + i + ']', file);
    //     });

    //     $.each(params, function(i, param) {
    //         data.append(param.name, param.value);
    //     });

    //     $.ajax({
    //         url: $form.attr('action'),
    //         data: data,
    //         cache: false,
    //         contentType: false,
    //         processData: false,
    //         type: 'POST',
    //         success: function (result) {
    //             console.log(result);
    //         }
    //     });
    // });
})(jQuery);
</script>
@endsection