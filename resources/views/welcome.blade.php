@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Welcome</div>

                <div class="panel-body">
                    <h4>Most Notorious Health Facilities</h4>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>New</th>
                                    <th>Open</th>
                                    <th>Resolved</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($facilities as $facility)
                                <tr>
                                    <td>{!! $facility->name !!}</td>
                                    <td>{!! $facility->newComplaints() !!}</td>
                                    <td>{!! $facility->openComplaints() !!}</td>
                                    <td>{!! $facility->resolvedComplaints() !!}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
