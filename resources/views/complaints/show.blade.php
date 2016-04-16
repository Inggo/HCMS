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