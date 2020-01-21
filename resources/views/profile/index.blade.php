@extends('layouts.admin')
@section('title', ':: Profile')
@section('page-header')
    Profile
@endsection
@section('breadcrumb')
    <li class="active">Profile</li>
@endsection
@section('content')

    <div class="row">
        <div class="col-md-3">
            <div class="box box-primary">
                @include('profile.summary', ['user' => $user])
            </div>
        </div>
        <div class="col-md-9">
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#activity" data-toggle="tab">Activity</a></li>
                    <li><a href="#timeline" data-toggle="tab">Timeline</a></li>
                    <li><a href="#settings" data-toggle="tab">Settings</a></li>
                    <li><a href="#password" data-toggle="tab">Password</a></li>
                </ul>
                <div class="tab-content">
                    <div class="active tab-pane" id="activity">
                    </div>

                    <div class="tab-pane" id="timeline">
                      </div>

                    <div class="tab-pane" id="settings">
                        @include('profile.settings', ['user' => $user])
                    </div>
                    <div class="tab-pane" id="password">
                        @include('profile.password', ['user' => $user])
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('script')
<script src="{!! asset('js/profile.js') !!}"></script>
@endsection