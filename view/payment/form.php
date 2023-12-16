
<div class="col mb-lg-0 mb-4">
    <div class="card">
      <div class="card-body p-3">
        <div class="row">
          <div class="col">
            <div class="d-flex flex-column h-100">
                <a class="text-body text-sm font-weight-bold mb-0 icon-move-right mt-auto" href="/payment" >
                    <i class="fas fa-arrow-left text-sm ms-1" aria-hidden="true"></i>
                      Kembali
                    </a>
                <h5 class="font-weight-bolder">Update Histori Pembayaran</h5>


                <form id="form-data" method="post" autocompleted="off" enctype="multipart/form-data">
                    <input type="hidden" name="id_payment" value="<?= $data_payment[0][0]?>">
                    <div class="form-group row">
                        <div class="col-6 mt1">
                            <label for="id_donasi">Nama Donasi</label>
                            <input class="form-control input_form" type="text" name="id_donasi" id="" value="<?= $data_payment[0][1] ?>" disabled>
                        </div>

                        <div class="col-6 mt1">
                            <label for="price">Nominal Donasi </label>
                            <input class="form-control input_form" type="text" name="price" disabled value="Rp. <?= number_format($data_payment[0][5], 2) ?>">
                        </div>
      
                        <div class="col-6 mt1">
                            <label for="name_donasi">Nama Donatur</label>
                            <input class="form-control input_form" type="text" name="nama_donasi" value="<?= $data_payment[0][2] ?>">
                        </div>
                
                        <div class="col-6 mt1">
                            <label for="email_donasi">Email </label>
                            <input class="form-control input_form" type="text" name="email_donasi" disabled value="<?= $data_payment[0][3] ?>">
                        </div>
                        
                
                        
                    </div>
                    <div class="form-group">
                        <div class="col mt1">
                            <label for="payment_status">Status Pembayaran</label>
                            <select  class="form-control input_form" name="payment_status" id="payment_status" required >
                                <option value="1" <?= $data_payment[0][4] == 1 ? 'selected' : '' ?> >Menunggu Pembayaran</option>
                                <option value="2" <?= $data_payment[0][4] == 2 ? 'selected' : '' ?> >Pembayaran Berhasil</option>
                                <option value="3" <?= $data_payment[0][4] == 3 ? 'selected' : '' ?> >Pembayaran Expired</option>
                            </select>
                        </div>

                        <div class="col mt-1">
                            <label for="dukungan">Dukungan Donatur</label>
                            <textarea class="form-control input_form" name="dukungan" id="dukungan" rows="10"><?= $data_payment[0][6] ?></textarea>
                        </div>
                    </div>
                
                    <input class="btn btn-primary" type="button" id="simpan" value="Update">
                </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>


