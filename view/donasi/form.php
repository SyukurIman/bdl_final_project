<div class="row my-4 justify-content-md-center">
    <div class="col-lg-11 col-md-auto mb-md-0 mb-4 ">
      <div class="card">
        <div class="card-header pb-0">
          <div class="row">
            <div class="col-lg-6 col-7">
              <h6>Inpur Data Donasi</h6>
            </div>
          </div>
        </div>
        <div class="card-body px-0 pb-2">
            <form id="form-data" method="post" autocompleted="off" enctype="multipart/form-data">
            <div class="row my-4 px-4">
                <div class="col-lg-6 col-md-6 mb-md-0 mb-4 ">
                    <div class="col mt-2"> 
                        <label for="judul_donasi" class="form-label">Judul</label>
                        <input type="hidden" name="id_data_donasi" value="<?= $position == 'Form Create' ? '' : $data?>">
                        <input type="text" class="form-control input_form" name="judul_donasi" value="<?= $position == 'Form Create' ? '' : $data?>" id="judul_donasi" required>
                        <p class="help-block" style="display: none;"></p>
                    </div>
                    <div class="col mt-2"> 
                        <label for="target" class="form-label">Target</label>
                        <input type="number" class="form-control input_form" name="target" value="<?= $position == 'Form Create' ? '' : $data?>" id="target" required>
                        <p class="help-block" style="display: none;"></p>
                    </div>
                    <div class="col mt-2"> 
                      <label for="batas_waktu_donasi" class="form-label">Batas Donasi</label>
                      <input type="date" class="form-control input_form" name="batas_waktu_donasi" value="<?= $position == 'Form Create' ? '' : $data?>" id="batas_waktu_donasi" required>
                      <p class="help-block" style="display: none;"></p>
                  </div>
                    <div class="col mt-2"> 
                        <label for="deskripsi_donasi" class="form-label">Deskripsi Donasi</label>
                        <textarea class="form-control input_form" name="deskripsi_donasi"placeholder="Leave a comment here" id="deskripsi_donasi"><?= $position == 'Form Create' ? '' : $data?></textarea>
                        <p class="help-block" style="display: none;"></p>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 ">
                  <div class="col text-center px-6 mt-2 mb-2">
                      <a href="<?= $position == 'Form Create' ? '/../assets/img/no-photo-available.png' : '/../images/donasi/'.$data->id_data_donasi.'/'.$data->gambar_donasi?>" target="_blank" id="imgLink">
                        <img src="<?= $position == 'Form Create' ?  '/../assets/img/no-photo-available.png' : '/../images/donasi/'.$data->id_data_donasi.'/'.$data->gambar_donasi ?>" class="mb-3 mt-4" id="output" width="150px">
                      </a>
                      <input type="file" class="form-control" name="gambar_donasi" id="gambar_donasi" onchange="tampilkanGambar(this)" <?= $position == 'Form Create' ? 'required' : '' ?>
                      value="<? $position == 'Form Create' ? '' : '/../images/donasi/'.$data->id_data_donasi.'/'.$data->gambar_donasi ?>">
                  </div>
                </div>
                <script>
                  function tampilkanGambar(input) {
                      var fileInput = input;
                      var output = document.getElementById('output');
                      var imgLink = document.getElementById('imgLink');

                      if (fileInput.files && fileInput.files[0]) {
                      var fileType = fileInput.files[0].type;
                      var allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];

                      if (allowedTypes.includes(fileType)) {
                          output.src = window.URL.createObjectURL(fileInput.files[0]);
                          imgLink.href = window.URL.createObjectURL(fileInput.files[0]);
                      } else {
                          alert('Hanya file gambar dengan format JPEG, PNG, atau GIF yang diizinkan.');
                          fileInput.value = ''; // Membersihkan input file
                          output.src = "/../assets/img/no-photo-available.png";
                          imgLink.href = "/../assets/img/no-photo-available.png";
                      }
                      } else {
                      output.src = "/../assets/img/no-photo-available.png";
                      imgLink.href = "/../assets/img/no-photo-available.png";
                      }
                  }
                </script>
              </div>
              <div class="text-left px-4">
                <button type="button" id="simpan" class="btn btn-primary btn-data">Simpan</button>
              </div>
            </form>
        </div>
      </div>
    </div>
</div>