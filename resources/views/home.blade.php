@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header"> General Chat Room </div>
                <chatbox user-id='{{ $userId }}' room-id='{{ $roomId }}' :initial-messages='@json($messages)'> </chatbox>
            </div>
        </div>
    </div>
</div>

@endsection