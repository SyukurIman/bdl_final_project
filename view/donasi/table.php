<div class="col mb-md-0 mb-4">
    <div class="card">
      <div class="card-header pb-0">
        <div class="row">
          <div class="col-lg-6 col-7">
            <h6>Data Donasi</h6>
            <p class="text-sm mb-0">
              <i class="fa fa-check text-info" aria-hidden="true"></i>
              <span class="font-weight-bold ms-1"> .. Donasi</span> Secara
              Keseluruhan
            </p>
          </div>
          <div class="col-lg-6 col-5 my-auto text-end">
            <div class="dropdown float-lg-end pe-4">
                <a href="/donasi/create" type="button" class="btn btn-primary btn-data" id="btn-create">
                    <i class="fa fa-plus-square"></i> <span>Tambah</span>
                </a>
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
                  Nama Donasi
                </th>
                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                    Tanggal Donasi Selesai
                </th>
                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                    Deskripsi Donasi
                </th>
                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                    Nominal Target
                </th>
                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                    Nominal Terkumpul
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
                                    <a href="/donasi/update/<?php echo $data[$i][0] ?>" class="btn btn-warning btn-raised btn-xs" id="btn-ubah" title="Ubah"><i class="icon-edit"></i></a> &nbsp;
                                    <button class="btn btn-danger btn-raised btn-xs" id="btn-hapus" title="Hapus" data-id="<?php echo $data[$i][0] ?>"><i class="icon-trash"></i></button>
                                </div>
                            </div>
                        </td>
                        <td><?php echo $data[$i][1] ?></td>
                        <td><?php echo $data[$i][6] ?></td>
                        <td><?php echo $data[$i][2] ?></td>
                        <td>RP. <?php echo number_format($data[$i][3], 2) ?></td>
                        <td>Rp. </td>
                    </tr>
                <?php } ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>