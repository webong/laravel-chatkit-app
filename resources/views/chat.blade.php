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
                                    <div class="card-header">Chatting with {{ $user->name }} </div>
                                    <div class="card-body">
                                        <dl id="messageList">

                                        </dl>
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
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
 
</script>

@endsection