<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="viewport" content="width=device-width, initial-scale = 1.0">
        <title>student|register</title>
        <link rel="stylesheet" href="{{asset('vendor/bootstrap/css/bootstrap.min.css')}}">
        <link rel="stylesheet" href="{{asset('datatable/css/dataTables.bootstrap.min.css')}}">
        <link rel="stylesheet" href="{{asset('datatable/css/dataTables.bootstrap4.min.css')}}">
        <link rel="stylesheet" href="{{asset('sweetalert2/sweetalert2.min.css')}}">
        <link rel="stylesheet" href="{{asset('toastr/toastr.min.css')}}">
    </head>
    <body>
         <div class="container" style="margin-top:45px;">
             <div class="row">
                 <div class="col-md-8">
                     <div class="card">
                          <div class="card-header">Register</div>
                          <div class="card-body">
                             <table class="table table-hover table-condensed" id="student-table">
                                 <thead>
                                     <th><input type="checkbox" name="main_checkbox"><label></label></th>
                                     <th>First name</th>
                                     <th>Last name</th>
                                     <th>student_ID</th>
                                     <th>birthday</th>
                                     <th>Actions  <button class="btn btn-sm btn-danger d-none" id="deleteAllBtn">Delete All</button></th>
                                 </thead>
                                 <tbody>
                                 </tbody>
                             </table>
                          </div>
                     </div>
                 </div>
                 <div class="col-md-4">
                      <div class="card">
                           <div class="card-header">New student</div>
                           <div class="card-body">
                               <form action="{{route('create')}}" method="post" id="add-student-form">
                                @csrf
                                   <div class="form-group">
                                       <label for="">first name</label>
                                       <input type="text" name="first" class="form-control" placeholder="Enter first name">
                                        <span class="text-danger error-text first_error"></span>
                                   </div>
                                   <div class="form-group">
                                       <label for="">last name</label>
                                       <input type="text" name="last" class="form-control" placeholder="Enter last name">
                                       <span class="text-danger error-text last_error"></span>
                                   </div>
                                    <div class="form-group">
                                       <label for="">ID</label>
                                       <input type="number" name="id" class="form-control" placeholder="Id">
                                        <span class="text-danger error-text id_error"></span>
                                   </div>
                                   <div class="form-group">
                                       <label for="">birth Day</label>
                                       <input type="date" name="date" class="form-control" >
                                        <span class="text-danger error-text date_error"></span>
                                   </div>
                                   <div class="form-group">
                                       <button type="submit" class="btn btn-block btn-success">Save</button>
                                   </div>
                               </form>
                           </div>
                      </div>
                 </div>
             </div>
         </div>

         @include('dashboard.student.edit-student')
         <script src="{{asset('vendor/jquery/jquery-3.6.0.min.js')}}"></script>
         <script src="{{asset('vendor/bootstrap/js/bootstrap.min.js')}}"></script>
          <script src="{{asset('vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
           <script src="{{asset('datatable/js/jquery.datatables.min.js')}}"></script>
           <script src="{{asset('datatable/js/datatables.bootstrap4.min.js')}}"></script>
            <script src="{{asset('sweetalert2/sweetalert2.min.js')}}"></script>
             <script src="{{asset('toastr/toastr.min.js')}}"></script>
             <script>
                toastr.options.preventDuplicates = true;

                $.ajaxSetup({
                    headers:{
                        'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
                    }
                });

                $(function(){
                     $('#add-student-form').on('submit',function(e){
                         e.preventDefault();
                         var form = this;
                         $.ajax({
                             url:$(form).attr('action'),
                             method:$(form).attr('method'),
                             data:new FormData(form),
                             processData:false,
                             dataType:'json',
                             contentType:false,
                             beforeSend:function(){
                                   $(form).find('span.error-text').text('');
                             },
                             success:function(data){
                                   if(data.code == 0){
                                         $.each(data.error,function(prefix, val){
                                              $(form).find('span.'+prefix+'_error').text(val[0]);
                                         });
                                   }else{
                                        $(form)[0].reset();
                                      $('#student-table').DataTable().ajax.reload(null, false);
                                       toastr.success(data.msg);
                                   }
                             }
                         });
                     });
                   var table = $('#student-table').DataTable({
                         processing:true,
                         info:true,
                         ajax:"{{route('getstudentlist')}}",
                         "pageLength":5,
                         "aLengthMenu":[[5,10,25,50,-1],[5,10,25,50,"All"]],
                         columns:[
                             //{data:'id',name:'id'},
                              {data:'checkbox',name:'checkbox', orderable:false, searchable:false},
                             {data:'first_name',name:'first_name'},
                             {data:'last_name',name:'last_name'},
                             {data:'student_id',name:'student_id'},
                             {data:'date',name:'date'},
                             {data:'actions',name:'actions', orderable:false, searchable:false},
                         ]
                     }).on('draw', function(){
                        $('input[name="student_checkbox"]').each(function(){this.checked = false;});
                        $('input[name="main_checkbox"]').prop('checked', false);
                        $('button#deleteAllBtn').addClass('d-none');
                     });
                     $(document).on('click','#editstudent',function(){
                       var student_Id = $(this).data('id');
                       $('.editstudent').find('form')[0].reset();
                        $('.editstudent').find('span.error-text').text('');
                       $.post('<?= route("getstudentDetails") ?>',{student_Id:student_Id},function(data){
                            
                             $('.editstudent').find('input[name="cid"]').val(data.details.id);
                             $('.editstudent').find('input[name="first"]').val(data.details.first_name);
                             $('.editstudent').find('input[name="last"]').val(data.details.last_name);
                             $('.editstudent').find('input[name="id"]').val(data.details.student_id);
                              $('.editstudent').find('input[name="date"]').val(data.details.date);
                            $('.editstudent').modal('show');
                       },'json');
                     });

                     $('#update-student-form').on('submit', function(e){
                         e.preventDefault();
                         var form = this;
                         $.ajax({
                             url:$(form).attr('action'),
                             method:$(form).attr('method'),
                             data:new FormData(form),
                             processData:false,
                             dataType:'json',
                             contentType:false,
                             beforeSend: function(){
                                 $(form).find('span.error-text').text('');
                             },
                             success: function(){
                                  if(data.code == 0){
                                        $.each(data.error,function(prefix, val){
                                              $(form).find('span.'+prefix+'_error').text(val[0]);
                                         });
                                  }else{
                                       $('#student-table').DataTable().ajax.reload(null, false);
                                       $('.editstudent').modal('hide');
                                       $('.editstudent').find('form')[0].reset();
                                       toastr.success(data.msg);
                                  }
                             }
                         });
                     });

                     $(document).on('click','#deletestudent',function(){
                          var student_Id = $(this).data('id');
                          var url = '<?= route("deletestudent") ?>';

                          swal.fire({
                              title:'Are you sure?',
                              html:'you want to <b>delete</b> this is student',
                              showCancelButton:true,
                              showCloseButton:true,
                              cancelButtonText:'Cancel',
                              confirmButtonText:'yes, Delete',
                              cancelButtonColor:'#d33',
                              confirmButtonColor:'#556ee6',
                              whidth:300,
                              allowOutsideClick:false
                          }).then(function(result){
                             if(result.value){
                                 $.post(url,{student_Id:student_Id},function(data){
                                    if(data.code == 1){
                                         $('#student-table').DataTable().ajax.reload(null, false);
                                         toastr.success(data.msg);
                                    }else{
                                         toastr.error(data.msg);
                                    }

                                 },'json');
                             }
                          });

                     });

                     $(document).on('click', 'input[name="main_checkbox"]',function(){
                         if(this.checked){
                             $('input[name="student_checkbox"]').each(function(){
                                 this.checked = true;
                             });
                         }else{
                               $('input[name="student_checkbox"]').each(function(){
                                 this.checked = false;
                             });
                         }

                         toggledeleteAllBtn();
                     });

                     $(document).on('change','input[name="student_checkbox"]',function(){
                         if($('input[name="student_checkbox"]').length == $('input[name="student_checkbox"]:checked').length){
                             $('input[name="main_checkbox"]').prop('checked', true);
                         }else{
                              $('input[name="main_checkbox"]').prop('checked', false);
                         }
                         toggledeleteAllBtn();
                     });

                     function toggledeleteAllBtn(){
                         if($('input[name="student_checkbox"]:checked').length > 0){
                             $('button#deleteAllBtn').text('Delete ('+$('input[name="student_checkbox"]:checked').length+')').removeClass('d-none');

                         }else{
                             $('button#deleteAllBtn').addClass('d-none');
                         }
                     }

                     $(document).on('click','button#deleteAllBtn',function(){
                         var checkedstudents = [];
                         $('input[name="student_checkbox"]:checked').each(function(){
                             checkedstudents.push($(this).data('id'));
                         });

                         var url = '{{ route("deleteselectedstudent") }}';
                         if(checkedstudents.length > 0){
                             swal.fire({
                                 title:'Are you sure?',
                                 html:'you want to Delete <b>('+checkedstudents.length+')</b> students',
                                 showCancelButton:true,
                                 showCloseButton:true,
                                 confirmButtonText:'yes ,Delete',
                                 cancelButtonText:'Cancel',
                                 cancelButtonColor:'#d33',
                                 confirmButtonColor:'#556ee6',
                                 whidth:300,
                                 allowOutsideClick:false
                              }).then(function(result){
                                  if(result.value){
                                      $.post(url,{student_Ids:checkedstudents}, function(data){
                                           if(data.code == 1){
                                                $('#student-table').DataTable().ajax.reload(null, false);
                                                 toastr.success(data.msg);
                                           }
                                      }, 'json');
                                  }
                              })
                         }
                     });

                });


             </script>
    </body>
      
</html>
