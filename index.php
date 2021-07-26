<?php ;?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>pvrBEATS - Chat</title>

    <!-- Load required Bootstrap and BootstrapVue CSS -->
    <link type="text/css" rel="stylesheet" href="//unpkg.com/bootstrap/dist/css/bootstrap.min.css" />
    <link type="text/css" rel="stylesheet" href="//unpkg.com/bootstrap-vue@latest/dist/bootstrap-vue.min.css" />
    <!--link rel="stylesheet" href="CSS/style.css"-->
    <style>
        [v-cloak] {
            display: none;
        }
    </style>


</head>
<body>
    <div class="container" id="app" v-cloak>
        <div class="row">
            <div class="col-md-12 mt-5">
                <h1 class="text-center">PHP OOP VUEJS CRUD</h1>
                <hr>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div>
                    <b-button id="show-btn" @click="showModal">Add Message</b-button>

                    <b-modal ref="my-modal" hide-footer title="pvrBEATS - Anonymous Chat" >
                        <div class="d-block text-center">
                            <h3>CREATE ANONYMOUSLY</h3>
                            <p>Post anonymously and voice your opinions without the fear of prejudice. We offers you pseudo anonymity... pvrBeats.</p>
                            <div>
                                <form action="" @submit.prevent="onSubmit">
                                    <div class="form-group">
                                        <label for="">Username</label>
                                        <input type="text" v-model="username" class="form-control">
                                    </div>
                                    <div class="form-group">    
                                        <label for="">Message</label>
                                        <input type="text" v-model="message" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <button class="btn btn-sm btn-outline-info">Add Message</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <b-button class="mt-3" variant="outline danger" block @click="hideModal">DONE</b-button>
                    </b-modal>
                </div>
            </div>
        </div>
        <div class="row" v-if="chat.length">
            <div class="col-md-12">
                <table class="table table-borderless">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Username</th>
                            <th>Message</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(msg, i) in chat" :key="msg.id">
                            <td>{{i+1}}</td>
                            <td>{{msg.username}}</td>
                            <td>{{msg.message}}</td>
                            <td>
                                <button @click="deleteMessage(msg.id)" class="btn btn-sm btn-outline-danger">Delete</button>
                                <button @click="editMessage(msg.id)" class="btn btn-sm btn-outline-info">Edit</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Load polyfills to support older browsers -->
    <script src="//polyfill.io/v3/polyfill.min.js?features=es2015%2CIntersectionObserver" crossorigin="anonymous"></script>
    <!-- Load Vue followed by BootstrapVue -->
    <script src="//unpkg.com/vue@latest/dist/vue.min.js"></script>
    <script src="//unpkg.com/bootstrap-vue@latest/dist/bootstrap-vue.min.js"></script>
    <!-- Load the following for BootstrapVueIcons support -->
    <script src="//unpkg.com/bootstrap-vue@latest/dist/bootstrap-vue-icons.min.js"></script>
    <!-- Axios -->
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <!--script src="./JS/script.js"></script-->
    <script>
        var app = new Vue ({
            el: '#app',
            data: {
                 username: '',
                 message: '',
                 chat: {}
            },
            methods:{
                showModal() {
                    this.$refs['my-modal'].show()
                },
                hideModal() {
                    this.$refs['my-modal'].hide()
                },
                onSubmit() {
                    if (this.username !== '' && this.message !== '') {
                        var fd = new FormData()

                        fd.append('username', this.username)
                        fd.append('message', this.message)

                        axios({
                            url: 'anon_msg.php',
                            method: 'post',
                            data: fd
                        })
                        .then(res => {
                            console.log(res.data.res)
                            if (res.data.res == 'success') {
                                alert('Message added')
                                this.username = ''
                                this.message = ''

                                app.hideModal()
                            }else {
                                alert('...you forgot something. Try again.')
                            }
                        })
                        .catch(err => {
                            console.log(err)
                        })
                    }else{
                        alert('...you forgot something. Try again.')
                    }
                },
                getChatMessages(){
                    axios({
                        url: 'sync_chat.php',
                        method: 'get'
                    })
                    .then(res => {
                        //console.log(res.data.rows)
                        this.chat = res.data.rows

                        
                    })
                    .catch(err =>{
                        console.log(err)
                    })
                },
                deleteMessage(id){ 
                    if (window.confirm('Delete this record')) {
                        var fd = new FormData()

                        fd.append('id', id)

                        axios({
                            url:'delete_message.php',
                            method:'post',
                            data: fd
                        })
                        .then(res => {
                            console.log(id)
                            if(res.data.res == 'success'){
                                alert('deleted successfully')
                                app.getChatMessages();
                            }else{
                                alert('error')
                            }
                        })
                        .catch(err => {
                            console.log(err)
                        })
                    }
                },
                editMessage(id){

                }
            },
            mounted: function(){
                this.getChatMessages()
            }
        })
    </script>
</body>
</html>