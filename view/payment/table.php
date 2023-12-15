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