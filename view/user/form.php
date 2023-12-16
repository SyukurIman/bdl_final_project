
<div class="col mb-lg-0 mb-4">
    <div class="card">
      <div class="card-body p-3">
        <div class="row">
          <div class="col">
            <div class="d-flex flex-column h-100">
                <a class="text-body text-sm font-weight-bold mb-0 icon-move-right mt-auto" href="/user" >
                    <i class="fas fa-arrow-left text-sm ms-1" aria-hidden="true"></i>
                      Kembali
                    </a>
                <h5 class="font-weight-bolder">Input Data User</h5>

                <?= isset($data) ? var_dump($data) : "" ?>
                <form id="form-data" method="post" autocompleted="off" enctype="multipart/form-data">
                    <input type="hidden" name="id_user" value="<?= isset($data) ? $data[0][0] : '' ?>">
                    <div class="form-group">
                        <div class="col mt1">
                            <label for="name">* Nama Lengkap</label>
                            <input class="form-control input_form" type="text" name="name" required id="name" value="<?= isset($data) ? $data[0][1] : ''  ?>" >
                        </div>

                        <div class="col mt1">
                            <label for="email">* Email </label>
                            <input class="form-control input_form" type="email" name="email" id="email" required value="<?= isset($data) ? $data[0][2] : ''?>">
                        </div>

                        <div class="col mt1">
                            <label for="is_admin">Status Pengguna</label>
                            <select  class="form-control input_form" name="is_admin" id="is_admin" required >
                                <option value="0" <?= isset($data) && $data[0][8] == 0 ? 'selected' : '' ?> >Pengguna Biasa</option>
                                <option value="1" <?= isset($data) && $data[0][8] == 1 ? 'selected' : '' ?> >Admin</option>
                            </select>
                        </div>
      
                        <div class="col mt1">
                            <label for="password">Password</label>
                            <input class="form-control input_form" <?= isset($data) ? '' : 'required' ?> type="password" name="password" id="password" >
                        </div>
                
                        
                        
                
                        
                    </div>
                
                    <input class="btn btn-primary" type="button" id="simpan" value="Save">
                </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>


