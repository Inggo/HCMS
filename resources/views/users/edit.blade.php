@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Edit User</div>

                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ route('users.update', $user->id) }}">
                        {!! csrf_field() !!}

                        <input name="_method" type="hidden" value="PUT">

                        <div class="form-group">
                            <label class="col-md-4 control-label">User ID</label>

                            <div class="col-md-6">
                                <input type="text" class="form-control" name="full_name" value="{{ $user->id }}" readonly>
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('full_name') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">Full Name</label>

                            <div class="col-md-6">
                                <input type="text" class="form-control" name="full_name" value="{{ $user->full_name }}">

                                @if ($errors->has('full_name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('full_name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">E-Mail Address</label>

                            <div class="col-md-6">
                                <input type="email" class="form-control" name="email" value="{{ $user->email }}">

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('contact_number') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">Contact Number</label>

                            <div class="col-md-6">
                                <input type="text" class="form-control" name="contact_number" value="{{ $user->contact_number }}">

                                @if ($errors->has('contact_number'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('contact_number') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('type') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">User Type</label>

                            <div class="col-md-6">
                                <select name="type" class="form-control">
                                    @foreach (HCMS\User::$types as $type => $label)
                                    <option value="{{ $type }}"{!! $user->type === $label ? ' selected' : '' !!}>{!! $label !!}</option>
                                    @endforeach
                                </select>

                                @if ($errors->has('contact_number'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('contact_number') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-btn fa-save"></i>Save
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
