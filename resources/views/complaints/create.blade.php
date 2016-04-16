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
                <div class="panel-heading">Submit Complaint</div>

                <div class="panel-body">

                    <div class="col-md-6 col-md-offset-3">

                        @if (session('success'))
                        <div class="alert alert-success alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            Successfully submitted your complaint!
                        </div>
                        @endif

                        <form method="POST" action="{{ route('complaints.store') }}" enctype="multipart/form-data">
                            {!! csrf_field() !!}
                            <fieldset class="form-group">
                                <label for="title">Complaint Title</label>
                                <input type="text" class="form-control" id="title" placeholder="" name="title" required>
                            </fieldset>
                            <fieldset class="form-group">
                                <label for="content">Complaint Description</label>
                                <textarea class="form-control" rows="5" id="content" name="content" required></textarea>
                            </fieldset>
                            <fieldset class="form-group">
                                <label for="facility_id">Hospital</label>
                                <br>
                                <select class="form-control" id="facility_id" name="facility_id"required>
                                </select>
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
                            <input type="submit" value="Submit" class="btn btn-primary">
                        </form>
                    </div>
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
            url: '{!! action('FacilitiesController@index'); !!}',
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

    // $(document).on('submit', 'form', function(e) {
    //     e.preventDefault();

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