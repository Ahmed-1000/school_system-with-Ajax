<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="viewport" content="width=device-width, initial-scale = 1.0">
         <link rel="stylesheet" href="{{asset('vendor/bootstrap/css/bootstrap.min.css')}}">
        <link rel="stylesheet" href="{{asset('datatable/css/dataTables.bootstrap.min.css')}}">
        <link rel="stylesheet" href="{{asset('datatable/css/dataTables.bootstrap4.min.css')}}">
        <link rel="stylesheet" href="{{asset('sweetalert2/sweetalert2.min.css')}}">
        <link rel="stylesheet" href="{{asset('toastr/toastr.min.css')}}">
    </head>
    <body>
        <div class="container">
             <div class="row">
                <div class="col-md-4 offset-md-4" style="margin-top: 45px;">
                 <h1>student login</h1>
                 <div id="show_success_alert"></div>
                  <form action="{{ route('student.createB') }}" method="post" autocomplete="on" id="register-form">
                       
                      @csrf
                      <div class="form-group">
                         <label for="">full name</label>
                          <input type="text" class="form-control" id="full_first_name" name="full_first_name" placeholder="Enter your name" value="{{ old('full_first_name') }}">
                             <span class="text-danger full_first_name_error"></span>
                      </div>
                       <div class="form-group">
                         <label for="">password</label>
                          <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password" value="{{ old('password') }}">
                            <span class="text-danger password_error"></span>
                      </div>
                      <div class="form-group">
                         <label for="">confirm password</label>
                          <input type="password" class="form-control" id="cpassword" name="cpassword" placeholder="confirm password" value="{{ old('cpassword') }}">
                             <span class="text-danger cpassword_error"></span>
                      </div>
                       <div class="form-group">
                          <input type="submit" value="register" class="btn btn-dark" id="register-btn">
                      
                      </div>
                      <br>
                         <a href="{{route('student.login')}}">already have account</a>
                    
                    </form>    
                 
                 
                 
                 
                 
                 
                 </div>
            
            
            
            
            
            </div>
        
        
        
        </div>

          <script src="{{asset('vendor/jquery/jquery-3.6.0.min.js')}}"></script>
         <script src="{{asset('vendor/bootstrap/js/bootstrap.min.js')}}"></script>
          <script src="{{asset('vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
           <script src="{{asset('datatable/js/jquery.datatables.min.js')}}"></script>
           <script src="{{asset('datatable/js/datatables.bootstrap4.min.js')}}"></script>
            <script src="{{asset('sweetalert2/sweetalert2.min.js')}}"></script>
             <script src="{{asset('toastr/toastr.min.js')}}"></script>
             <script>
                  $.ajaxSetup({
                    headers:{
                        'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
                    }
                });
                $(function(){

                     $('#register-form').on('submit',function(e){
                         
                          e.preventDefault();
                          
                          $('#register-btn').val('please wait...');
                          var form = this;
                          $.ajax({
                              url:$(form).attr('action'),
                              method:$(form).attr('method'),
                              data:$(this).serialize(),
                              dataType:'json',
                              beforeSend:function(){
                                   $(form).find('span.error-text').text('');
                             },
                              success:function(data){
                                  if(data.code == 0){
                                         $.each(data.error,function(prefix, val){
                                              $(form).find('span.'+prefix+'_error').text(val[0]);
                                         });
                                          $('#register-btn').val('register');
                                   }else{
                                        $(form)[0].reset();
                                      
                                       toastr.success(data.msg);
                                        $('#register-btn').val('register');
                                   }
                              }
                          });
                     });

                     
                });
             </script>
    </body>
</html>
