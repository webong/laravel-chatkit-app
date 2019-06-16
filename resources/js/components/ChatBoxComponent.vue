<template>
  <div class="card-body">
    <dl v-for="message in messages" :key="message.id">
      <dt><strong>{{ message.sender }}</strong></dt>
      <dd>{{ message.text }}</dd>
    </dl>
    <hr>
    <div class="input-group">
        <input type="text" v-model="message" class="form-control" placeholder="Type your message...">

        <div class="input-group-append">
          <button @click="sendMessage" class="btn btn-primary">Send</button>
        </div>
    </div>
  </div>
</template>


<script>
import axios from 'axios';

export default {
    props: ['getmessages'],
    data () {
        return {
            message: '',
            messages: this.getmessages,
        }
    },
    mounted () {
        const vm = this

        setInterval(function(){ 
            axios.get(window.location.href)
            .then(res => {
                console.log(res);
                vm.messages = res['data'];
            }); 
        
        }, 3000);
    },
    methods: {
        sendMessage() {
            console.log(this.message);
            axios.post( window.location.href, {
                message: this.message
            })
            .then(res => {
                this.message = '';
            });
        }
    }
};
</script>
