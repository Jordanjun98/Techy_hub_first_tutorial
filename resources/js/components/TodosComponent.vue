<template>
    <div class="row">
        <div class="container">
            <div class="row">
                <div class="col-md-6 mx-auto">
                    <h1 class="todos-title">Todos</h1>
                    <input name="title" id="title" v-model="todo.title" placeholder="add your title">
                    <button type="button" v-bind:disabled="closebtn" @click="CreateTodoList" class="btn btn-primary">Create</button>
                    <button type="button" v-bind:disabled="closeremove" @click="removelist" class="btn btn-primary">Remove</button>
                    <button type="button" v-bind:disabled="closeupdate" @click="updatetodatabase" class="btn btn-primary">Update</button>
                    <button type="button" v-bind:disabled="cancelall" @click="close" class="btn btn-primary">Close</button> 
                    <div class="todos-wrapper">       
                        <li class="list-group todos-list" v-for="(todo,index) in todos" :key="index">   
                            <a v-on:click="SelectTodoList(todo)" class="list-group-item todos-list-item">{{ todo.title }}</a>  
                        </li>
                    </div>

                    <br>
                        <div>
                            <label class="typo__label">Single select</label>
                            <multiselect v-model="value" :options="options" :searchable="true" :close-on-select="false" :show-labels="false" placeholder="Pick a value"></multiselect>
                            <pre class="language-json"><code>{{ value  }}</code></pre>
                        </div>  
                    </br> 
            
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import Multiselect from 'vue-multiselect'

// register globally
Vue.component('multiselect', Multiselect)

export default {
   
    components:{ Multiselect },

    data: function(){
        return{
            todos:[],
            todo: {
                id:'',
                title:'',
            },
            closebtn: false,                //availabe
            closeupdate:true,               //Not available
            closeremove:true,                //Not available
            value:'',
            options:['select','option'],
            cancelall:true,
            
        };
    },

    mounted(){
        // console.log("test hello world")
        this.getTodos();
    },
    methods:{
        getTodos: function(){
           axios.get('/todos')
           .then(({ data }) =>{         // function(){data}
                this.todos = data;
                console.log(this.todos);
           }
        )},

        CreateTodoList(){
            axios.post('/todos',{
                
                title: this.todo.title
            }).then(response =>{        //function(response){ }
                this.reset();
                this.todos.push(response.data.todo);
                this.getTodos();
            },(error)=>{

            });
            this.closeupdate =true;
            this.closeremove=true;
        },

        SelectTodoList(todo){
            this.todo = todo;
            this.closebtn = true;
            this.closeupdate = false;
            this.closeremove = false;
            this.cancelall = false;
            console.log(todo);
        },

        updatetodatabase(){
            axios.put('/todos/'+ this.todo.id,{
              title:this.todo.title
            }).then((response) => { 
                this.getTodos();
            }, (error) => {

            });
            
            this.closebtn = false;
            this.closeupdate =true;
            this.closeremove=true;
            
        },

        removelist(){
           axios.delete('/todos/' + this.todo.id)
            .then(response =>{
                this.todos.splice(index,1);
                
           }).catch(error => {

           })
           this.getTodos();
           this.closebtn = false;
           this.closeupdate =true;
           this.closeremove=true;
        },
        
        reset(){
            this.todo.title = '';
        },

        close(){
            this.closebtn = false;
            this.closeupdate =true;
            this.closeremove=true;
        }
        


    }
}
</script>
<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>