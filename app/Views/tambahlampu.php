<?php 
$data['title'] = "Data Laporan";
echo view('_partials/header', $data); 
?>
<?php echo view('_partials/sidebar'); ?>

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Data Laporan</h1>
            </div>
            <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">Data Laporan</li>
            </ol>
            </div>
        </div>
        </div>
    </div>

<!-- SELECT2 EXAMPLE -->
<section class="content">
      <div class="container-fluid">
        <div class="card card-default card-primary collapsed-card">
          <div class="card-header">
            <h3 class="card-title">Tambah Data</h3>

            <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-plus"></i></button>
              <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-remove"></i></button>
            </div>
            
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <div class="row">
              <div class="col-md-6">
              <form id="addLaporan" method="POST" action="">
                
                <div class="form-group">
                    <label for="tambah_lampu">Tambah Lampu</label>
                    <input type="number" name="tambah_lampu" class="form-control" id="tambah_lampu" placeholder="Tambah Lampu" required autofocus>
                </div>
                <!-- /.form-group -->
              
              <!-- /.col -->
              </form>
            </div>
            <!-- /.row -->
          </div>
          <!-- /.card-body -->
            <div class="card-footer">
                <button id="submitLaporan" type="submit button" class="btn btn-primary">Submit</button>
            </div>
        </div>
        <!-- /.card -->
    </div>
</section>


<!-- TABLE -->
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Data Laporan</h3>

                            <div class="card-tools">
                                <!-- <div class="input-group input-group-sm" style="width: 150px;">
                                    <input type="text" name="table_search" class="form-control float-right" placeholder="Search">

                                    <div class="input-group-append">
                                        <button type="submit" class="btn btn-default">
                                        <i class="fas fa-search"></i>
                                        </button>
                                    </div>
                                </div> -->
                            </div>
                        </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0" style="height: 350px;">
                <table class="table table-hover text-nowrap table-head-fixed">
                  <thead>
                    <tr>
                      <th>Tanggal</th>
                      <th>Lampu Nyala</th>
                      <th>Lampu Mati</th>
                      <th>Lampu Baru</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody id="tbody">
                    
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- col-12 -->
        </div>
        <!-- /.row -->
        </div>
    </div>
</div>


<!-- Update Model -->
<form action="" method="POST" class="users-update-record-model form-horizontal">
    <div id="update-modal" data-backdrop="static" data-keyboard="false" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="custom-width-modalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" style="width:55%;">
            <div class="modal-content" style="overflow: hidden;">
                <div class="modal-header">
                    <h4 class="modal-title" id="custom-width-modalLabel">Update</h4>
                    <button type="button" class="close" data-dismiss="modal"
                            aria-hidden="true">×
                    </button>
                </div>
                <div class="modal-body" id="updateBody">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-dismiss="modal">Close
                    </button>
                    <button type="button" class="btn btn-success updateLaporan">Update
                    </button>
                </div>
            </div>
        </div>
    </div>
</form>

<!-- Delete Model -->
<form action="" method="POST" class="users-remove-record-model">
    <div id="remove-modal" data-backdrop="static" data-keyboard="false" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="custom-width-modalLabel"
         aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-dialog-centered" style="width:55%;">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="custom-width-modalLabel">Delete</h4>
                    <button type="button" class="close remove-data-from-delete-form" data-dismiss="modal" aria-hidden="true">×
                    </button>
                </div>
                <div class="modal-body">
                    <p>Apakah Anda yakin ingin menghapus data laporan ini?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default waves-effect remove-data-from-delete-form" data-dismiss="modal">Close
                    </button>
                    <button type="button" class="btn btn-danger waves-effect waves-light deleteLaporan">Delete
                    </button>
                </div>
            </div>
        </div>
    </div>
</form>

<script src="https://code.jquery.com/jquery-3.4.0.min.js"></script>
<script src="https://www.gstatic.com/firebasejs/5.10.1/firebase.js"></script>
<script>
    // Initialize Firebase
    var firebaseConfig = {
        apiKey: "<?= ENV('apiKey') ?>",
        authDomain: "<?= ENV('authDomain') ?>",
        databaseURL: "<?= ENV('databaseURL') ?>",
        storageBucket: "<?= ENV('storageBucket') ?>",
        messagingSenderId: "<?= ENV('messagingSenderId') ?>",
        appId: "<?= ENV('appId') ?>",
        measurementId: "<?= ENV('measurementId') ?>",
        appId: "<?= ENV('appId') ?>"
    };
    firebase.initializeApp(firebaseConfig);

    var database = firebase.database();

    var lastIndex = 0;

    // Get Data
    firebase.database().ref('laporan/data_laporan/').on('value', function (snapshot) {
        var value = snapshot.val();
        var htmls = [];
        $.each(value, function (index, value) {
            if (value) {
                htmls.push('<tr>\
                <td>' + value.tanggal + '</td>\
                <td>' + value.tambah_lampu + '</td>\
                <td>' + value.lampu_mati + '</td>\
                <td>' + value.lampu_baru + '</td>\
                <td><button data-toggle="modal" data-target="#update-modal" class="btn btn-info updateLaporan" data-id="' + index + '">Update</button>\
                <button data-toggle="modal" data-target="#remove-modal" class="btn btn-danger removeLaporan" data-id="' + index + '">Delete</button></td>\
            </tr>');
            }
            lastIndex = index;
        });
        $('#tbody').html(htmls);
        $("#submitLaporan").removeClass('disabled');
    });

    // Add Data
    $('#submitLaporan').on('click', function () {
        var values = $("#addLaporan").serializeArray();
        var tambah_lampu = values[0].value;
        var userID = lastIndex + 1;
        //var userID = lastIndex + 1;

        firebase.database().ref('lampu/tambah_lampu/' + userID).set({
            tambah_lampu: tambah_lampu,
        });

        // Reassign lastID value
        lastIndex = userID;
        $("#addLaporan input").val("");
        // menampilkan alert
        alert("Berhasil menambah data");
        // toastr.success("Berhasil menambah data");
    });

    // Update Data
    var updateID = 0;
    $('body').on('click', '.updateLaporan', function () {
        updateID = $(this).attr('data-id');
        firebase.database().ref('laporan/data_laporan/' + updateID).on('value', function (snapshot) {
            var values = snapshot.val();
            var updateData = '<div class="form-group">\
                <label for="edit_tanggal" class="col-md-12 col-form-label">Tanggal</label>\
                <div class="col-md-12">\
                    <input id="edi_tanggal" name="tanggal" type="date" value="' + values.tanggal + '" class="form-control" data-inputmask-alias="datetime" data-inputmask-inputformat="dd/mm/yyyy" data-mask required autofocus>\
                </div>\
            </div>\
            <div class="form-group">\
                <label for="edit_lampu_nyala" class="col-md-12 col-form-label">Lampu Nyala</label>\
                <div class="col-md-12">\
                    <input id="edit_lampu_nyala" type="text" class="form-control" name="tambah_lampu" value="' + values.tambah_lampu + '" placeholder="Lampu Nyala" required autofocus>\
                </div>\
            </div>\
            <div class="form-group">\
                <label for="edit_lampu_mati" class="col-md-12 col-form-label">Lampu Mati</label>\
                <div class="col-md-12">\
                    <input id="edit_lampu_mati" type="text" class="form-control" name="lampu_mati" value="' + values.lampu_mati + '" placeholder="Lampu Mati" required autofocus>\
                </div>\
            </div>\
            <div class="form-group">\
                <label for="edit_lampu_baru" class="col-md-12 col-form-label">Lampu Baru</label>\
                <div class="col-md-12">\
                    <input id="edit_lampu_baru" type="text" class="form-control" name="lampu_mati" value="' + values.lampu_baru + '" placeholder="Lampu Baru" required autofocus>\
                </div>\
            </div>';

            $('#updateBody').html(updateData);
        });
    });

    $('.updateLaporan').on('click', function () {
        var values = $(".users-update-record-model").serializeArray();
        var postData = {
            tanggal: values[0].value,
            tambah_lampu: values[1].value,
            lampu_mati: values[2].value,
            lampu_baru: values[3].value,
        };
        var updates = {};
        updates['/laporan/data_laporan/' + updateID] = postData;
        firebase.database().ref().update(updates);
        // menyembunyikan modal 
        $("#update-modal").modal('hide');
        // menampilkan alert
        alert("Berhasil mengubah data");
    });

    // Remove Data
    $("body").on('click', '.removeLaporan', function () {
        var id = $(this).attr('data-id');
        $('body').find('.users-remove-record-model').append('<input name="id" type="hidden" value="' + id + '">');
    });

    $('.deleteLaporan').on('click', function () {
        var values = $(".users-remove-record-model").serializeArray();
        var id = values[0].value;
        firebase.database().ref('laporan/data_laporan/' + id).remove();
        $('body').find('.users-remove-record-model').find("input").remove();
        // menyembunyikan modal
        $("#remove-modal").modal('hide');
        // menampilkan alert
        alert("Berhasil menghapus data");
        // toastr.success("Berhasil menghapus data");
    });
    $('.remove-data-from-delete-form').click(function () {
        $('body').find('.users-remove-record-model').find("input").remove();
    });
</script>

<!-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script> -->

<?php echo view('_partials/footer'); ?>