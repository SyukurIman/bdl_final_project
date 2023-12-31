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
                        <input type="hidden" name="id_data_donasi" value="<?= $position == 'Form Create' ? '' : $data[0][0]?>">
                        <input type="text" class="form-control input_form" name="judul_donasi" value="<?= $position == 'Form Create' ? '' : $data[0][1]?>" id="judul_donasi" required>
                        <p class="help-block" style="display: none;"></p>
                    </div>
                    <div class="col mt-2"> 
                        <label for="target" class="form-label">Target</label>
                        <input type="number" class="form-control input_form" name="target" value="<?= $position == 'Form Create' ? '' : $data[0][3]?>" id="target" required>
                        <p class="help-block" style="display: none;"></p>
                    </div>
                    <div class="col mt-2"> 
                      <label for="batas_waktu_donasi" class="form-label">Batas Donasi</label>
                      <input type="date" class="form-control input_form" name="batas_waktu_donasi" value="<?= $position == 'Form Create' ? '' : $data[0][7]?>" id="batas_waktu_donasi" required>
                      <p class="help-block" style="display: none;"></p>
                  </div>
                    <div class="col mt-2"> 
                        <label for="deskripsi_donasi" class="form-label">Deskripsi Donasi</label>
                        <textarea class="form-control input_form" name="deskripsi_donasi"placeholder="Leave a comment here" id="deskripsi_donasi"><?= $position == 'Form Create' ? '' : $data[0][2]?></textarea>
                        <p class="help-block" style="display: none;"></p>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 ">
                  <div class="col text-center px-6 mt-2 mb-2">
                      <a href="<?= $position == 'Form Create' ? '/../assets/img/no-photo-available.png' : '/../images/donasi/'.$data[0][0].'/'.$data[0][4]?>" target="_blank" id="imgLink">
                        <img src="<?= $position == 'Form Create' ?  '/../assets/img/no-photo-available.png' : '/../images/donasi/'.$data[0][0].'/'.$data[0][4] ?>" class="mb-3 mt-4" id="output" width="150px">
                      </a>
                      <input type="hidden" name="gambar_name" id="gambar_name" value="_" >
                      <input type="hidden" name="gambar_url" id="gambar_url" value="_" >
                      <input type="file" class="form-control" name="gambar_donasi" id="gambar_donasi" onchange="tampilkanGambar(this)" <?= $position == 'Form Create' ? 'required' : '' ?>
                      value="<?= $position == 'Form Create' ? '' : '/../images/donasi/'.$data[0][0].'/'.$data[0][4] ?>">
                      
                  </div>
                </div>
                <script>
                  function tampilkanGambar(input) {
                      var fileInput = input;
                      var output = document.getElementById('output');
                      var imgLink = document.getElementById('imgLink');
                      var inputImage = document.getElementById('gambar_url')
                      var inputNameImage = document.getElementById('gambar_name')


                      if (fileInput.files && fileInput.files[0]) {
                      var fileType = fileInput.files[0].type;
                      var allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];

                      if (allowedTypes.includes(fileType)) {
                          output.src = window.URL.createObjectURL(fileInput.files[0]);
                          imgLink.href = window.URL.createObjectURL(fileInput.files[0]);
                          inputImage.value = window.URL.createObjectURL(fileInput.files[0]);
                          inputNameImage.value = fileInput.files[0].name;
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