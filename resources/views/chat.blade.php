@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">

                    <div id="chatbox">
                        <div class="row">
                            <div class="col-md-8">
                                <div class="card">
                                    <div class="card-header">Chat with </div>
                                    <div class="card-body">
                                        <dl id="messageList"></dl>
                                        <hr>
                                        <form id="sendMessage" method="post">
                                            <div class='input-group'>
                                                <input type='text' name='message' class="form-control" placeholder="Type your message...">

                                                <div class='input-group-append'>
                                                    <button class='btn btn-primary'>Send</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card">
                                    <div class="card-header">Recent Chats</div>
                                    <div class="card-body p-0">
                                        <ul id="onlineUsers" class="list-group list-group-flush"></ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection