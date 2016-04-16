@extends('layouts.app')

@section('header')
<link href="{{ asset('css/chosen.min.css') }}" rel='stylesheet' type='text/css'>
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

                    <form method="POST" action="{{ route('complaints.store') }}">
                        {!! csrf_field() !!}
                        <fieldset class="form-group">
                            <label for="title">Complaint Title</label>
                            <input type="text" class="form-control" id="title" placeholder="" style="width: 40%;">
                        </fieldset>
                        <fieldset class="form-group">
                            <label for="desc">Complaint Description</label>
                            <textarea class="form-control"  style="width: 40%;" rows="5" id="desc"></textarea>
                        </fieldset>
                        <fieldset class="form-group">
                            <label for="desc">Hospital</label>
                            <br>
                            <select class="chzn-select form-control" multiple="true" id="hospital" name="hospital" style="width:40%;">
                                <option value="AC">A</option>
                                <option value="AD">B</option>
                                <option value="AM">C</option>
                                <option value="AP">D</option>
                            </select>
                        </fieldset>
                        <fieldset class="form-group">
                            <label for="file_up">Attach Files</label>
                            <br>
                            <div class="input-group" style="width: 40%;">
                                <span class="input-group-btn">
                                    <span class="btn btn-primary btn-file">
                                        Browse<input type="file" id="file_up" name="file_up" multiple>
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
@endsection

@section('footer')
<script src="{{ asset('js/chosen.jquery.min.js') }}"></script>

<script type="text/javascript">
    $(function() {
        $(".chzn-select").chosen();
    });

    $(document).on('change', '.btn-file :file', function() {
        var input = $(this),
        numFiles = input.get(0).files ? input.get(0).files.length : 1,
        label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
        input.trigger('fileselect', [ numFiles, label]);
    });

    $(document).ready( function() {
        $('.btn-file :file').on('fileselect', function(event,  numFiles, label) {

            var input = $(this).parents('.input-group').find(':text'),
            log = numFiles > 1 ? numFiles + ' files selected' : label;

            if (input.length) {
                input.val(log);
            }
      });
    });
</script>
@endsection