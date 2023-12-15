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
              <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#top_donasi"><i class="fas fa-trophy"></i> <span> Top Donasi Filter</span></button>
              <button class="btn btn-warning btn-data" id="download_btn"><i class="fas fa-download"></i> <span>Download</span></button>
          </div>
          </div>
        </div>
      </div>
      <div class="filter" style="display: none;">
        <form action="" method="post" id="form_filter">
          <input type="hidden" name="sql" id="sql">
          <div class="row px-4">
            <div class="col-lg-6 col-md-6 mb-md-0 mb-4 row">
              <div class="col mt-2">
                <label class="form-label" for="min_nominal" >Minimum Nominal Pembayaran</label>
                <input class="form-control input_form" type="number" name="min_nominal" id="min_nominal">
              </div>
              <div class="col mt-2">
                <label class="form-label" for="max_nominal" >Maximum Nominal Pembayaran</label>
                <input class="form-control input_form" type="number" name="max_nominal" id="max_nominal">
              </div>
            </div>

            <div class="col-lg-6 col-md-6 mb-md-0 mb-4 row">
              <div class="col mt-2">
                <label class="form-label" for="min_tgl_donasi" >Minimum Batas Donasi </label>
                <input class="form-control input_form" type="date" name="min_tgl_donasi" id="min_tgl_donasi">
              </div>
              <div class="col mt-2">
                <label class="form-label" for="max_tgl_donasi" >Maximum Batas Donasi </label>
                <input class="form-control input_form" type="date" name="max_tgl_donasi" id="max_tgl_donasi">
              </div>
            </div>

          </div>
            
        </form>
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
                
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

  
<div class="modal fade" id="top_donasi" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Top Donatur Berdasarkan Tanggal</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form method="post" id="form_top_donasi">
          <div class="mb-3">
            <label for="tanggal_awal" class="col-form-label">tanggal Awal</label>
            <input type="date" class="form-control" id="tanggal_awal">
          </div>
          <div class="mb-3">
            <label for="tanggal_akhir" class="col-form-label">Tanggal Akhir</label>
            <input type="date" class="form-control" id="tanggal_akhir">
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary"  data-bs-dismiss="modal" id="submit_top_donasi">Submit</button>
      </div>
    </div>
  </div>
</div>