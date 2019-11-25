@extends('layouts.master')

@section('content')
<div class="container-fulid px-5">
    <div class="row">
        <div class="col-sm-2 d-sm-none d-md-block">sidebar</div>
        <div class="col-md-8 col-sm-12 p-3">
        
            <profile :user="{{Auth::user()}}"/>    
            
        </div>
    </div>
</div>

@endsection