<div class="modal fade editstudent " tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Edit student</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
            <form action="{{route('updatestudent')}}" method="post" id="update-student-form">
                @csrf
                 <input type="hidden" name="cid">
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
                   <label for="">Id</label>
                   <input type="number" name="id" class="form-control" placeholder="Id">
                     <span class="text-danger error-text id_error"></span>
                 </div>
                 <div class="form-group">
                   <label for="">birth Day</label>
                   <input type="date" name="date" class="form-control">
                    <span class="text-danger error-text date_error"></span>
                 </div>
                 <div class="form-group">
                    <button type="submit" class="btn btn-block btn-success">Save changes</button>
                 </div>
            </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        
      </div>
    </div>
  </div>
</div>
