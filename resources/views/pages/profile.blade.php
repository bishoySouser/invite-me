@extends('layouts.master')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        
        <div class="col-md-8 col-sm-12 p-3">
        
            <profile :user="{{Auth::user()}}"/>    
            
        </div>
    </div>
</div>

@endsection