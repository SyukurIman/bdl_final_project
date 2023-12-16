
<div class="col mb-lg-0 mb-4">
    <div class="card">
      <div class="card-body p-3">
        <div class="row">
          <div class="col">
            <div class="d-flex flex-column h-100">
                <a class="text-body text-sm font-weight-bold mb-0 icon-move-right mt-auto" href="/donasi" >
                    <i class="fas fa-arrow-left text-sm ms-1" aria-hidden="true"></i>
                      Kembali
                    </a>
                <h5 class="font-weight-bolder">Create Payment</h5>

                <div class="row">
                    <div class="col-5 text-end mt-0">
                        <a href="<?= '/../images/donasi/'.$data_donasi[0][0].'/'.$data_donasi[0][4]?>" target="_blank" id="imgLink">
                            <img src="<?= '/../images/donasi/'.$data_donasi[0][0].'/'.$data_donasi[0][4] ?>" class="mb-3 mt-4 rounded" id="output" width="300px">
                        </a>
                    </div>
                    <div class="col-6 p-3">
                        <h3 class="font-weight-bolder"><?= $data_donasi[0][1] ?></h3>
                        <p class="text-sm mb-0">
                            <i class="fa fa-solid fa-money-bill" aria-hidden="true"></i>
                            <span class="font-weight-bold ms-1">Donasi Terkumpul Rp. <?= number_format($data_donasi[0][8], 2) ?></span> 
                            Dari Target Rp. <?= number_format($data_donasi[0][3], 2) ?>
                            <?php ?>
                        </p>
                        <p class="text-sm mb-0"><?= $data_donasi[0][2] ?></p>
                    </div>
                </div>


                <form id="form-data" method="post" autocompleted="off" enctype="multipart/form-data">

                    <div class="form-group row">
                        <input type="hidden" name="id_data_donasi" id="id_data_donasi" value="<?= $data_donasi[0][0] ?>">
                        <div class="col-6 mt1">
                            <label for="price">* Nominal Donasi </label>
                            <input class="form-control input_form" type="text" name="price" value="" required>
                        </div>
      
                        <div class="col-6 mt1">
                            <label for="name_donasi">Nama Donatur</label>
                            <input class="form-control input_form" type="text" name="nama_donasi" value="">
                        </div>
            
                                
                    </div>
                    <div class="form-group">
                        <div class="col mt1">
                            <label for="user">* Select User</label>
                            <select  class="form-control input_form" name="user" id="user" required >
                                <?php for ($i=0; $i < count($data_user); $i++) { ?>
                                    <option value="<?= $data_user[$i][0] ?>" > <?= $data_user[$i][1] ?></option>
                                <?php }  ?>
                                
                            </select>
                        </div>

                        <div class="col mt-1">
                            <label for="dukungan">Dukungan Donatur</label>
                            <textarea class="form-control input_form" name="dukungan" id="dukungan"  rows="10"></textarea>
                        </div>
                    </div>
                
                    <input class="btn btn-primary" type="button" value="Create Payment" id="simpan">
                </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>


