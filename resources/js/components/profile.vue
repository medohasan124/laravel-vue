<template>
  
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Developer</h1>
          </div><!-- /.col -->
         
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class='row'>
                 <!-- /.col -->
          <div class="col-md-12">
            <!-- Widget: user widget style 1 -->
            <div class="card card-widget widget-user">
              <!-- Add the bg color to the header using any of the bg-* classes -->
              <div class="widget-user-header text-white"
                   style="background: url('./photo/background.jpg') center center;">
                <h3 class="widget-user-username text-right">Elizabeth Pierce</h3>
                <h5 class="widget-user-desc text-right">Web Designer</h5>
              </div>
              <div class="widget-user-image">
                <img class="img-circle" :src="form.photo" alt="User Avatar">
              </div>
              <div class="card-footer">
                <div class="row">
                  <div class="col-sm-4 border-right">
                    <div class="description-block">
                      <h5 class="description-header">3,200</h5>
                      <span class="description-text">SALES</span>
                    </div>
                    <!-- /.description-block -->
                  </div>
                  <!-- /.col -->
                  <div class="col-sm-4 border-right">
                    <div class="description-block">
                      <h5 class="description-header">13,000</h5>
                      <span class="description-text">FOLLOWERS</span>
                    </div>
                    <!-- /.description-block -->
                  </div>
                  <!-- /.col -->
                  <div class="col-sm-4">
                    <div class="description-block">
                      <h5 class="description-header">35</h5>
                      <span class="description-text">PRODUCTS</span>
                    </div>
                    <!-- /.description-block -->
                  </div>
                  <!-- /.col -->
                </div>
                <!-- /.row -->
              </div>
            </div>
            <!-- /.widget-user -->
          </div>
          <!-- /.col -->


                   <!-- /.col -->
          <div class="col-md-9">
            <div class="card">
              <div class="card-header p-2">
                <ul class="nav nav-pills">
                  <li class="nav-item"><a class="nav-link " href="#activity" data-toggle="tab">Activity</a></li>
                 
                  <li class="nav-item"><a class="nav-link active" href="#settings" data-toggle="tab">Settings</a></li>
                </ul>
              </div><!-- /.card-header -->
              <div class="card-body">
                <div class="tab-content">
                  <div class="tab-pane"  id="activity">
                    test
                  </div>
                  <!-- /.tab-pane -->
                  <div>
                    <!-- The timeline -->
                    <div class="timeline timeline-inverse">
                      <!-- timeline time label -->
                      <div class="time-label">
                       
                      </div>
                     
                  
                     
                    </div>
                  </div>
                  <!-- /.tab-pane -->

                  <div class="active tab-pane" id="settings">
                    <form class="form-horizontal" content-type='multipart/form-data'>
                      <div class="form-group row">
                        <label for="inputName" class="col-sm-2 col-form-label">Name</label>
                        <div class="col-sm-10">
                          <input type="name" v-model='form.name'class="form-control" id="inputName" placeholder="Name">
                           <p class='text-danger'v-if="form.error.name" v-text='form.error.name'></p>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="inputEmail"  class="col-sm-2 col-form-label">Email</label>
                        <div class="col-sm-10">
                          <input type="email" v-model='form.email' class="form-control" id="inputEmail" placeholder="Email">

                          <p class='text-danger'v-if="form.error.email" v-text='form.error.email'></p>
                        </div>
                      </div>
                     
                      <div class="form-group row">
                        <label for="inputExperience" class="col-sm-2 col-form-label">Password</label>
                        <div class="col-sm-10">
                          <input type="password" v-model='form.password' class="form-control" id="inputPassword" placeholder="Paaword">
                             <p class='text-danger'v-if="form.error.password" v-text='form.error.password'></p>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="inputSkills" class="col-sm-2 col-form-label">Photo</label>
                        <div class="col-sm-10">
                          <input  type="file"  @change='imageUpload' class="form-control" placeholder="file">
                        </div>
                      </div>
                     
                      <div class="form-group row">
                        <div class="offset-sm-2 col-sm-10">
                          <button type="submit" @click.prevent='update()' class="btn btn-primary"> Update</button>
                        </div>
                      </div>
                    </form>
                  </div>
                  <!-- /.tab-pane -->
                </div>
                <!-- /.tab-content -->
              </div><!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
      </div>
    </div>
  </section>

</div>
</template>


<script>

  import Form from '../form.js'
  
export default {

  data(){
    return {
      form : new Form({
        name:'' ,
        email:'' ,
        password:'' ,
        photo:'' 
      }),
    } 
  } ,

  methods:{


    // start update Profile
    update(){
         this.$Progress.start() ;
      //we use from to send data and back the error
      this.form.send('put' , 'api/profile/update' , this.form).then(res =>{
        

       
      }).catch(err =>{
        console.log(this.form.error.name);
      })
         this.$Progress.finish() ;

         Swal.fire({
          icon:'success' ,
          title:'success' ,
          text:'success to update Data'
         })
    } ,
    // end  update Profile

    //Start Upload Photo Profile
  imageUpload(e){

    let file = e.target.files[0];
    let size = e.target.files.size;
    let reader = new FileReader();

   
    reader.onloadend = () =>{
     if(file.size > 50000){
      Swal.fire({
        icon:'error' ,
        title:'opss...' ,
        text:'image is very large'
      })
     }else{
      this.form.photo = reader.result ;
     }
      
    } ;
    reader.readAsDataURL(file);
    
  }
  },
   //end  Upload Photo Profile

  created(){
      //reload Data
         this.$Progress.start() ;

       


       

        let data = axios.get('api/profile').then(
          res => {
            
            this.form.name = res.data.name ;
            this.form.email = res.data.email ; 
            this.form.photo = 'img/'+res.data.photo ; 
          }
         
          ).catch(function(err){
          console.log(err)
        })

          if(this.form.photo == ''){
              this.form.photo ='img/default.png';
          }

  } ,

  name:'developer'
}

</script>