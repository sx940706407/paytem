<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>data-platform</title>
    @include('virtual/layout/css')

   <meta name="csrf-token" content="{{ csrf_token() }}">

</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <a href="javascript:;">data</a>
  </div>
  <!-- /.login-logo -->
  <div class="login-box-body" id="loginAgent">

      <div class="form-group has-feedback">
        <input type="phone" 
        v-validate="'required'" 
        :class="{'input':true,'is-danger':errors.has('phone')}" 
        v-model.number="phone"
        class="form-control" name="phone"  placeholder="管理账号">
      
      <span v-show="errors.has('phone')" class="text-danger">@{{ errors.first('phone') }}</span>

        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <input type="password"
         v-validate="'required'"
         :class="{'input':true,'is-danger':errors.has('password')}"
         v-model="password" name="password" class="form-control" placeholder="密码">

         <span v-show="errors.has('password')" class="text-danger">@{{ errors.first('password') }}</span>

        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      </div>


      {{-- <div class="form-group has-feedback" v-if="catchShow" >
        <input type="input"  name="captch" v-model.trim="captch" class="form-control" placeholder="验证码">

         <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback" v-if="catchShow">
        <img src="{{url('captchBuilder')}}" alt="captch" v-on:Click="changeCaptch">
      
      </div> --}}



      <div class="row">
        <div class="col-xs-8">
          <div class="checkbox icheck">
{{--             <label>
              <input type="checkbox" name="remember" v-model="remember" >Remember Me
            </label> --}}
          </div>
        </div>
        <!-- /.col -->
        <div class="col-xs-4">
          <button  class="btn btn-primary btn-block btn-flat" v-on:Click="login">登陆</button>
        </div>
        <!-- /.col -->
      </div>

  </div>
  <!-- /.login-box-body -->
</div>
<!-- /.login-box -->
  
</body>

<script src="{{asset('bower_components/jquery/dist/jquery.min.js')}} "></script>
<script src="{{asset('bower_components/bootstrap/dist/js/bootstrap.min.js')}} "></script> 

@include('virtual/bower/vue')
<script>
var loginAgent = new Vue({
    el : '#loginAgent',
    data :{
        phone : '',
        password: '',
        catchShow: false,
        captch:''

    },
    methods: {
        login: function (){
            axios.post('/virtual/loginDo',{
              phone: this.phone,
              password: this.password,
              captch: this.captch
            },{
              headers:{
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr('content')
              }
            })
            .then(function (res){
               if (res.data.stateCode != 200) {
                  layer.msg(res.data.stateMsg); return;

               }
               if (res.data.stateCode == 200) {
                  window.location.href="/virtual/index";
               }

            })
            .catch(function (err){
                console.log(err);
            });
        },
        changeCaptch : function(){

        }
    },
    computed: {

    }
});
</script>
</html>
