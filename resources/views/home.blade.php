@extends('layouts.master')

@section('content')

   
        
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    
                    <user-list-component
                    :invitee="{{Auth::user()}}"
                    
                    />


@endsection
