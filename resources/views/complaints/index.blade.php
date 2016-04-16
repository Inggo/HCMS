@extends('layouts.app')

@section('header')
<link href="{{ asset('css/jquery.dataTables.min.css') }}" rel='stylesheet' type='text/css'>
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Complaints</div>

                <div class="panel-body">
                    <table class="table table-bordered" id="complaints-table" style="font-size: 12px; width: 100%; ">
                        <thead style="background-color: #efeff5">
                            <tr>
                                <th style="width:15%;">Last Update</th>
                                <th style="width:30%;">Title</th>
                                <th style="width:30%;">Complainant</th>
                                <th style="width:15%;">Status</th>
                                <th style="width:10%;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($complaints as $complaint)
                            <tr>
                                <td data-order="{{ $complaint->updated_at->getTimestamp() }}">{!! $complaint->updated_at->diffForHumans() !!}</td>
                                <td>{!! $complaint->title !!}</td>
                                <td>{!! $complaint->user->full_name !!}</td>
                                <td>{!! $complaint->status !!}</td>
                                <td align="center">
                                    <a href="{{ action('ComplaintsController@show', $complaint->id) }}" class="btn btn-success">View</a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('footer')
<script src="{{ asset('js/jquery.dataTables.min.js') }}"></script>

<script type="text/javascript">
$(document).ready(function(){
    $('#complaints-table').DataTable({
        "order": [[0, "desc"]]
    });
});
</script>
@endsection