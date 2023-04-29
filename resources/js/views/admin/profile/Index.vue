<template>
  <div>
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Profile</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item">
                <a href="#">Home</a>
              </li>
              <li class="breadcrumb-item active">User Profile</li>
            </ol>
          </div>
        </div>
      </div>
      <!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-3">
            <!-- Profile Image -->
            <div class="card card-primary card-outline">
              <div class="card-body box-profile">
                <div class="text-center">
                  <img
                    class="profile-user-img img-fluid img-circle"
                    :src="profileImageShow()"
                    alt="User profile picture"
                  />
                </div>

                <h3 class="profile-username text-center">{{form.name}}</h3>

                <p class="text-muted text-center">{{form.email}}</p>

              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->

            <!-- /.card -->
          </div>
          <!-- /.col -->
          <div class="col-md-9">
            <div class="card">
              <div class="card-header p-2">
                <ul class="nav nav-pills">

                  <li class="nav-item">
                    <a class="nav-link active" href="#settings" data-toggle="tab"
                      >Profile</a>
                  </li>
                </ul>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <div class="tab-content">

                  <div class="tab-pane active" id="settings">
                    <form class="form-horizontal" @submit.prevent="updateProfile">
                      <div class="form-group row">
                        <label for="inputName" class="col-sm-2 col-form-label"
                          >Name</label
                        >
                        <div class="col-sm-10">
                          <input
                            type="name"
                            v-model="form.name"
                            class="form-control"
                            id="inputName"
                            placeholder="Name"
                             :class="{ 'is-invalid': form.errors.has('name') }"
                          />
                           <HasError :form="form" field="name" />
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="inputEmail" class="col-sm-2 col-form-label"
                          >Email</label
                        >
                        <div class="col-sm-10">
                          <input
                            type="email"
                             v-model="form.email"
                            class="form-control"
                            id="inputEmail"
                            placeholder="Email"
                             :class="{ 'is-invalid': form.errors.has('email') }"
                          />
                           <HasError :form="form" field="email" />
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="inputName2" class="col-sm-2 col-form-label"
                          >Password</label
                        >
                        <div class="col-sm-10">
                          <input
                            type="password"
                             v-model="form.password"
                            class="form-control"
                            id="inputName2"
                            :class="{ 'is-invalid': form.errors.has('password') }"
                            placeholder="Password (optional, if required or skip it)"
                          />
                           <HasError :form="form" field="password" />
                        </div>
                      </div>
                      <div class="form-group row">
                        <label
                          for="inputExperience"
                          class="col-sm-2 col-form-label"
                          >Bio</label
                        >
                        <div class="col-sm-10">
                          <textarea
                            class="form-control"
                            id="inputExperience"
                            placeholder="Bio"
                             v-model="form.bio"
                          ></textarea>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="inputSkills" class="col-sm-2 col-form-label"
                          >Image</label
                        >
                        <div class="col-sm-10">
                          <input
                            type="file"
                            class="form-control"
                            id="inputSkills"
                            @change="changeImage($event)"

                          />
                            <div class="my-3" v-if="form.image">
                                <img :src="updateImage()" width="200" height="150" />
                            </div>
                        </div>
                      </div>
                      <div class="form-group row">
                        <div class="offset-sm-2 col-sm-10">
                          <button type="submit" class="btn btn-success">
                               Submit
                          </button>
                        </div>
                      </div>
                    </form>
                  </div>
                  <!-- /.tab-pane -->
                </div>
                <!-- /.tab-content -->
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </section>
  </div>
</template>

<script>
    export default {
        data(){
          return {
              form : new Form({
                    id:'',
                    name: '',
                    email: '',
                    password: '',
                    bio: '',
                    image: ''
                }),
          }
        },
        mounted(){
            this.getProfile()
        },
        methods:{
            updateImage(){
                let photo = (this.form.image.length > 200) ? this.form.image : "/uploads/images/profile/"+this.form.image;
                return photo;
            },
            profileImageShow(){
                return "/uploads/images/profile/"+this.form.image
            },
            getProfile(){
                axios.get('/admin/profile')
                .then(res => {
                    this.form.fill(res.data)
                })
                .catch(err => {
                    console.log(err);
                })
            },
             changeImage(e){
                 let file = e.target.files[0];
                    if(file['size'] < 2000000){
                        let reader = new FileReader();
                        reader.onload = (evt) => {
                            this.form.image = evt.target.result;
                        };
                        reader.readAsDataURL(file);
                    }else{
                        toast.fire({
                            icon: 'error',
                            title: "Image size less than 2mb"
                        })
                    }

            },
            updateProfile(){
                 this.$Progress.start()
                this.form.put('/admin/profile-update')
                .then(res => {
                     toast.fire({
                        icon: 'success',
                        title: "Profile Updated Successfully"
                    })
                    this.getProfile()
                    this.$Progress.finish()
                })
                .catch(err => {
                    console.log(err);
                     this.$Progress.fail()
                })
            }
        }

    };
</script>

<style scoped></style>
