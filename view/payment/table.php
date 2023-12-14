<div class="col mb-md-0 mb-4">
    <div class="card">
      <div class="card-header pb-0">
        <div class="row">
          <div class="col-lg-6 col-7">
            <h6>Histori Pembayaran</h6>
            <p class="text-sm mb-0">
              <i class="fa fa-check text-info" aria-hidden="true"></i>
              <span class="font-weight-bold ms-1"><?= count($data) ?> Transaksi</span> Secara
              Keseluruhan
            </p>
          </div>
          <div class="col-lg-6 col-5 my-auto text-end">
            <div class="dropdown float-lg-end pe-4">
              <button class="btn btn-secondary btn-data" id="filter_btn"><i class="fas fa-filter"></i> <span>Filter</span></button>
              <button class="btn btn-warning btn-data" id="download_btn"><i class="fas fa-download"></i> <span>Download</span></button>
          </div>
          </div>
        </div>
      </div>
      <div class="card-body m-3 px-2 p-2">
        <div class="table-responsive ">
          <table class="table align-items-center mb-0" id="table" style="width: 100%">
            <thead>
              <tr>
                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                    No
                </th>
                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                    Aksi
                </th>
                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                  Email User
                </th>
                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                    Nama Donasi
                </th>
                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                    Tanggal
                </th>
                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                    Nominal
                </th>
                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                    Status Pembayaran
                </th>
              </tr>
            </thead>
            <tbody>
            <?php $i = 1; ?>
                <?php for ($i = 0; $i < count($data); $i++) { ?>
                    <tr>
                        <td><?= $i+1 ?></td>
                        <td>
                            <div class="text-center">
                                <div class="btn-group btn-group-solid mx-2">
                                    <a href="/payment/update/<?php echo $data[$i][0] ?>" class="btn btn-warning btn-raised btn-xs" id="btn-ubah" title="Ubah"><i class="icon-edit"></i></a>
                                </div>
                            </div>
                        </td>
                        <td><?php echo $data[$i][1] ?></td>
                        <td><?php echo $data[$i][2] ?></td>
                        <td><?php echo $data[$i][3] ?></td>
                        <td>RP. <?php echo number_format($data[$i][4], 2) ?></td>
                        <td><?php echo $data[$i][5] == 1 ? 'Menunggu Pembayaran' : ($data[$i][5] == 2 ? 'Pembayaran Berhasil' : 'Pembayaran Expired') ?></td>
                    </tr>
                <?php } ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>