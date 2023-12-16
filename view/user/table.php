<div class="col mb-md-0 mb-4">
    <div class="card">
      <div class="card-header pb-0">
        <div class="row">
          <div class="col-lg-6 col-7">
            <h6>Data User</h6>
            <p class="text-sm mb-0">
              <i class="fa fa-check text-info" aria-hidden="true"></i>
              <span class="font-weight-bold ms-1"> <?= count($data) ?> User </span> Secara Keseluruhan
            </p>
          </div>
          <div class="col-lg-6 col-5 my-auto text-end">
            <div class="dropdown float-lg-end pe-4">
                <a href="/user/create" type="button" class="btn btn-primary btn-data" id="btn-create">
                    <i class="fa fa-plus-square"></i> <span>Tambah</span>
                </a>
                <button class="btn btn-warning btn-data" id="download_btn"><i class="fas fa-download"></i> <span>Download</span></button>
          </div>
          </div>
        </div>
      </div>
      <div class="filter" style="display: none;">
        <form action="" method="post" id="form_filter">
          <input type="hidden" name="sql" id="sql">
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
                  Nama
                </th>
                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                    Email
                </th>
                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                    Status Pengguna
                </th>
                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                    Total Donasi
                </th>
                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                    Total Nominal Donasi
                </th>
              </tr>
            </thead>
            <tbody id="table_body">
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>