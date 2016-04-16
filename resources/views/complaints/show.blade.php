@extends('layouts.app')

@section('header')
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Viewing Complaint #{!! $complaint->id !!}</div>

                <div class="panel-body">

                    <div class="col-md-6 col-md-offset-3">
                        <form method="POST" id="complaint-instant-update" action="">
                            <fieldset class="form-group">
                                <label for="title">Complaint Title</label>
                                <input type="text" class="form-control" id="title" placeholder="" name="title" disabled="" value="{{ $complaint->title }}" style="cursor: default;">
                            </fieldset>
                            <fieldset class="form-group">
                                <label for="facility_id">Hospital / Facility</label>
                                <input type="text" class="form-control" id="facility_id" name="facility_id" disabled="" value="{{ $complaint->facility->name }}" style="cursor: default;">
                            </fieldset>
                            <fieldset class="form-group">
                                <label for="status">Status</label>
                                <input type="text" class="form-control" id="status" placeholder="" name="status"  value="OPEN" style="cursor: context-menu;">
                            </fieldset>
                            <fieldset class="form-group">
                                <label for="assigned">Assigned To</label>
                                <input type="text" class="form-control" id="assigned" placeholder="" name="assigned" value="----" style="cursor: context-menu;">
                            </fieldset>
                            <fieldset class="form-group">
                                <label for="category">Category</label>
                                <input type="text" class="form-control" id="category" placeholder="" name="category"  value="-----" style="cursor: context-menu;">
                            </fieldset>
                            <div class="text-center" style="padding:0px">
                                <text><strong>Attachments</strong></text>
                                <hr style="display: block; border-style: inset; padding-top:0px;
               border-width: 2px;">
                                attachment icons display here....
                            </div>
                        </form>
                    </div>
                </div>
     <div align="center">
       <div class="well col-md-10 col-md-offset-1">
         <div style="margin-top:0px; overflow: hidden;" class="text-left">
           <img src="http://www.gravatar.com/avatar/" style="float:right; display:inline;" />  
           <h4>From: <strong>Juan Dela Cruz</strong></h4> 
           <h5 style="font-size: 14px;">Date: <strong>04-23-2016</strong></h5>
         </div>
         <div style="width:100%; font-size: 16px; padding: 10px; border: 1px solid #ddd; background: #ccc;" class="text-justify">Paragraphs are the building blocks of papers. Many students define paragraphs in terms of length: a paragraph is a group of at least five sentences, a paragraph is half a page long, etc. In reality, though, the unity and coherence of ideas among sentences is what constitutes a paragraph. A paragraph is defined as “a group of sentences or a single sentence that forms a unit” (Lunsford and Connors 116). Length and appearance do not determine whether a section in a paper is a paragraph. For instance, in some styles of writing, particularly journalistic styles, a paragraph can be just one sentence long. Ultimately, a paragraph is a sentence or group of sentences that support one main idea. In this handout, we will refer to this as the “controlling idea,” because it controls what happens in the rest of the paragraph.</div>
         <br>
         <ul>
          <li v-for="attachment in reply.attachments">
           <a href="attachment.filename" ></a>
         </li>
       </ul>

     </div>
     <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#Respond">Respond</button>
   </div>
   

 </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('footer')
<script src="{{ asset('js/select2.full.min.js') }}"></script>

<script type="text/javascript">

function formatFacility (facility) {
    if (facility.loading) return facility.text;

    var markup = "<div class='select2-result-repository clearfix'>" +
        "<div class='select2-result-repository__meta'>" +
          "<div class='select2-result-repository__title'>" + facility.name + "</div>";

    if (facility.province) {
        markup += "<div class='select2-result-repository__description'>" + facility.province + "</div>";
    }

    return markup;
}

function formatFacilitySelection (facility) {
    return facility.name;
}

(function($) {
    $("#facility_id").select2({
        ajax: {
            url: '{!! action('Api\FacilitiesController@index'); !!}',
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
        templateResult: formatFacility,
        templateSelection: formatFacilitySelection
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

    $(document).on('submit', 'form', function(e) {
        // e.preventDefault();

        var $form  = $(this),
            data   = new FormData(),
            params = $form.serializeArray(),
            files  = $form.find('#attachments')[0].files;

        $.each(files, function(i, file) {
            data.append('attachments[' + i + ']', file);
        });

        $.each(params, function(i, param) {
            data.append(param.name, param.value);
        });

        $.ajax({
            url: $form.attr('action'),
            data: data,
            cache: false,
            contentType: false,
            processData: false,
            type: 'POST',
            success: function (result) {
                console.log(result);
            }
        });
    });
})(jQuery);
</script>
@endsection