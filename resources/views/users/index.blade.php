@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Users</div>

                <div class="panel-body">
                    <table class="table">
                        <thead>
                            <th>Full Name</th>
                            <th>Email</th>
                            <th>Type</th>
                            <th>Actions</th>
                        </thead>
                        <tbody>
                        @foreach ($users as $user)
                            <tr>
                                <td>{!! $user->full_name !!}</td>
                                <td>{!! $user->email !!}</td>
                                <td>{!! $user->type !!}</td>
                                <td><a href="{{ route('users.edit', $user->id) }}" class="btn btn-primary">Edit</a></td>
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
