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
                  <form action="{{ route('student.check') }}" method="post" autocomplete="off" id="login-form">
                       
                      @csrf
                      <div class="form-group">
                         <label for="">first name</label>
                          <input type="text" class="form-control" name="full_first_name" placeholder="Enter your name" value="{{ old('first_name') }}">
                            <span class="text-danger error-text full_first_name_error" style="color:red;"></span>
                      </div>
                      <div class="form-group">
                         <label for="password">password</label>
                          <input type="password" class="form-control" name="password" placeholder="Enter your password" value="{{ old('student_id') }}">
                            <span class="text-danger error-text password_error" style="color:red;"></span>
                      </div>
                       <div class="form-group">
                          <input type="submit" value="login" class="btn btn-dark" id="login-btn">
                      
                      </div>
                      <br>
                         <a href="{{route('student.register')}}">create an account</a>
                    
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

                     $('#login-form').on('submit',function(e){
                         
                          e.preventDefault();
                          var form = this;
                          $('#login-btn').val('please wait...');
                          
                          $.ajax({
                              url:$(form).attr('action'),
                              method:$(form).attr('method'),
                              data:$(this).serialize(),
                              dataType:'json',
                               beforeSend:function(){
                                   $(form).find('span.error-text').text('');
                               },
                              success:function(res){

                                  if(res.code == 0){
                                         $.each(res.error,function(prefix, val){
                                              $(form).find('span.'+prefix+'_error').text(val[0]);
                                         });
                                         $('#login-btn').val('login');
                                         toastr.error(res.msg);
                                   }else{
                                        $(form)[0].reset();
                                     
                                       toastr.success(res.msg);
                                         $('#login-btn').val('login');
                                        window.location ='{{route('Home')}}';
                                   }
                              }
                          });
                     });

                });
             </script>
    </body>
</html>
