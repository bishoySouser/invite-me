@extends('layouts.master')

@section('content')
<div class="container-fuild m-5">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <router-view :id="{{Auth::id()}}"></router-view>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection