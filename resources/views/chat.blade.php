@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Chatting with {{ $user->name }} </div>
                <chatbox :getmessages='@json($messages)'> </chatbox>
                <!-- <div class="card-body">
                    <dl id="messageList">
                        <dt>Coffee</dt>
                        <dd>Black hot drink</dd>
                        <dt>Milk</dt>
                        <dd>White cold drink</dd>
                    </dl>
                    <hr>
                    <form id="sendMessage" method="post">
                        <div class="input-group">
                            <input type="text" name="message" class="form-control" placeholder="Type your message...">

                            <div class="input-group-append">
                                <button class="btn btn-primary">Send</button>
                            </div>
                        </div>
                    </form>
                </div> -->
            </div>
        </div>
    </div>
</div>

@endsection