
<div class="col mb-lg-0 mb-4">
    <div class="card">
      <div class="card-body p-3">
        <div class="row">
          <div class="col">
            <div class="d-flex flex-column h-100">
                <a class="text-body text-sm font-weight-bold mb-0 icon-move-right mt-auto" href="/" >
                    <i class="fas fa-arrow-left text-sm ms-1" aria-hidden="true"></i>
                      Kembali
                    </a>
                <h5 class="font-weight-bolder">Setting</h5>


                <form id="form-data" method="post" autocompleted="off" enctype="multipart/form-data">
                    <div class="form-group">
                        <div class="col mt1">
                            <label for="status_trigger">Trigger Input Donasi</label>
                            <select class="form-control input_form" name="status_trigger" id="status_trigger">
                                <option value="off">Off Trigger</option>
                                <option value="on">On Trigger</option>
                            </select>
                        </div>
                    </div>


                    <div class="form-group row">
                        <div class="col-6 mt1">
                            <label for="start_time">Waktu Mulai</label>
                            <input class="form-control input_form" type="time" name="start_time" id="start_time" value="" >
                        </div>
      
                        <div class="col-6 mt1">
                            <label for="end_time">Waktu Selesai</label>
                            <input class="form-control input_form" type="time" name="end_time" id="end_time" value="" >
                        </div>
                
                    </div>

                    
                
                    <input class="btn btn-primary" type="button" id="simpan" value="Apply">
                </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>


