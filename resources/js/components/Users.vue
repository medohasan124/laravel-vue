<template>
   <!-- Main content -->
   <!-- Content Wrapper. Contains page content -->

  <div>
  
    <div v-if='!$gate.isAdmin()'>
      <not-found></not-found>
    </div>

  <div class="content-wrapper" v-if='$gate.isAdmin()'>



    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Users</h1>
          </div><!-- /.col -->

            <div class="col-sm-6 ">
               <button class='btn btn-success float-right'  data-toggle="modal" data-target="#addUsers">Add User <i class='fas fa-plus'></i></button>
              </div><!-- /.col -->
             
            </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
               <table class="table table-striped" id='usersTable'>
          <thead>
            <tr>
              <th scope="col">#</th>
              <th scope="col">Name</th>
              <th scope="col">Email</th>
              <th scope="col">Type</th>
              <th scope="col">Controle</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(user , index) in users" :key='user.id'>
                <td>{{ index + 1 }}</td>
                <td>{{ user.name }}</td>
                <td>{{ user.email }}</td>
                <td>{{ user.type }}</td>

                <td>
                    <button class='btn btn-primary' @click='editUser(user)'>Edit <i class='fas fa-pen'></i></button>
                    <button class='btn btn-danger' @click='DeleteUser(user.name , user.id)'>Delete <i class='fas fa-trash'></i></button>
                </td>
            </tr>
          </tbody>
        </table>
      </div>

  </section>



<!-- Modal -->
<div class="modal fade" id="addUsers"  tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" v-if='modalMode == "add" ' id="exampleModalLabel">Add User</h5> <h5 class="modal-title" v-if='modalMode == "update" ' id="exampleModalLabel">Update User</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form  @keyup='form.clear($event.target.name)' >
              <div class="form-group">
                <label for="exampleInputEmail1">Username</label>
                <input type="text" class="form-control" name='name' v-model='form.name'  aria-describedby="emailHelp" placeholder="Enter Username">
                <p class='text-danger'v-if="form.error.name" v-text='form.error.name'></p>
               
              </div>
              <div class="form-group">
                <label for="exampleInputPassword1">Password</label>
                <input type="password" name='password' v-model='form.password'  class="form-control" id="exampleInputPassword1" placeholder="Password">
                <p  class='text-danger' v-if="form.error.password"  v-text='form.error.password'></p>
              </div>

              <div class="form-group">
                <label for="exampleInputEmail1">Email</label>
                <input type="email" name='email' v-model='form.email' class="form-control" aria-describedby="emailHelp" placeholder="Enter Email">
                 <p class='text-danger' v-if="form.error.email"  v-text='form.error.email'></p>
              </div>

              <div class="form-group">
                <label for="exampleInputEmail1">Type</label>
               <select class='form-control' @click='form.clear("type")'  name='type' v-model='form.type'>
                <option v-for='data in type'  v-text='data.name' :value='data.id'></option>
               </select>

                 <p class='text-danger' v-if="form.error.type"  v-text='form.error.type'></p>
              </div>
              
              
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" onclick="$('#addUsers').modal('hide');" class="btn btn-secondary closing" data-dismiss="modal">Close</button>

        <button type="button" @click='send()' :disabled='form.hide'  class="btn btn-primary test" v-if='modalMode =="add"'>Save changes</button>

        <button type="button" @click='update(form.id)' :disabled='form.hide'  class="btn btn-primary test" v-if='modalMode =="update"'>Update</button>

      </div>
    </div>
  </div>
</div>


</div>


   
 </div>

</template>

<script>

import Form  from '../form.js' 

    export default {
        data(){
            return{

              modalMode:'add' ,
              type: [
              {name:'Admin' , id:1} ,
              {name:'User' , id:2} ,
             
              ] ,
              users:{} ,
                
           form: new Form({
            name:'' ,
            password:'' ,
            email:'' ,
            type:'' ,
           }) ,
          
               
            }
            
        } ,
        methods:{

          loadUsers(){

               this.$Progress.start();

                $('#usersTable').DataTable().ajax.reload();
            
          } ,

          editUser(user){

            this.modalMode = 'update' ;
            console.log(user);
            this.form.fill(user);
            $('#addUsers').modal('show');
            
          } ,

           send(){

            this.form.hide = true ;
           
              this.form.send('post' , 'api/user' , this.form)
              .then(res =>{
                  Toast.fire({
                 icon: 'success',
                  title: 'created in successfully'
                  })  
                $('.closing').click();

                this.loadUsers() ;
                this.form.clearing() ;
                
              }).catch(err =>{
                console.log(err);
              })
            
           } ,

           update(id){
             this.$Progress.start();

            this.form.hide = true ;
           
              this.form.update('put' , 'api/user/'+id , this.form)
              .then(res =>{
                  Toast.fire({
                 icon: 'success',
                  title: 'Update in successfully'
                  })  
                $('.closing').click();

                this.loadUsers() ;


                 this.form.hide = false ;
                
              }).catch(err =>{
                console.log(err);
              })


            
           } ,



           DeleteUser(name , id){
              Swal.fire({
                        title: 'Are you sure?',
                        text: "You won't be Delete " + name,
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, delete it!'
                  }).then((result) => {
                        if (result.isConfirmed) {
                          
                          this.form.delete(id).then(res =>{
                           
                            Swal.fire(
                            'Deleted!',
                            name + ' has been deleted.',
                            'success'
                          )
                             this.loadUsers() ;
                           
                          }).catch(err =>{
                            console.log(err);
                          })
                        }
                  })
           }
        } ,

        mounted(){

          if(this.$gate.isAdmin()){

             $(document).ready(function () {
                $('#usersTable').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: 'api/user',
                    columns: [
                      { data: 'id' },
                      { data: 'name' },
                      { data: 'email'},
                      { data: 'type'},
                      { data: 'action'}
                    ]
                });
            });  

        

           $(document).on('click' , '.editButton' , (evt) => {

            let data = JSON.parse($(evt.target).attr('id'));

             this.editUser(data) ;

           
           });

           $(document).on('click' , '.deleteButton' , (evt) => {

            let data = JSON.parse($(evt.target).attr('id'));

             this.DeleteUser(data.name , data.id) ;

           
           })
            
          }  
        } ,
       name:'Users'
    }


   
</script>
