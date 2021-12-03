<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Siswa</title>

    <link href="<?php echo base_url('assets/css/bootstrap.min.css'); ?>" rel="stylesheet">
</head>

<body>
    <br>
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h1>Data Siswa</h1>
                <br>
                <a href="#AddForm" data-toggle="modal" class="btn btn-primary">Add</a>

                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Nim</th>
                            <th scope="col">Nama</th>
                            <th scope="col">Kota</th>
                            <th scope="col">Action</th>

                        </tr>
                    </thead>
                    <tbody id="data">

                    </tbody>
                </table>
            </div>
        </div>


    </div>
    </div>


    <!-- Load bootstrap js file -->
    <script src="<?php echo base_url('assets/js/jquery.min.js'); ?>" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="<?php echo base_url('assets/js/bootstrap.min.js'); ?>" crossorigin="anonymous"></script>

    <script>
        $(document).ready(function() {
            getData()
        });

        function getData() {
            $.ajax({
                type: 'POST',
                url: '<?php echo base_url() . "ajax/getdata" ?>',
                dataType: 'JSON',
                success: function(data) {
                    var baris = '';
                    for (var i = 0; i < data.length; i++) {
                        baris += '<tr>' +
                            '<td>' + data[i].nim + '</td>' +
                            '<td>' + data[i].nama + '</td>' +
                            '<td>' + data[i].kota + '</td>' +
                            '<td><a href="#EditForm" data-toggle="modal" class="btn btn-warning" onclick="edit(' + data[i].nim + ')">Edit</a>' + ' <a href="#HapusForm" data-toggle="modal" class = "btn btn-danger" onclick = "hapusdata(' + data[i].nim + ')"> Delete </a></td> ' +

                            '</tr>';
                    }
                    $('#data').html(baris);
                }
            });
        }
    </script>

    <!-- js adddata -->

    <script>
        function addData() {

            var nama = $("[name='nama']").val();
            var kota = $("[name='kota']").val();

            $.ajax({
                type: "POST",
                url: "<?php echo base_url('ajax/tambahdata') ?>",
                data: "nama=" + nama + "&kota=" + kota,
                dataType: "JSON",
                success: function(hasil) {
                    $("#pesan").html(hasil.pesan);

                    if (hasil.pesan == '') {
                        $("#AddForm").modal('hide');

                        getData();

                        $("[name='nama'],[name='kota']").val('');
                    }
                }
            });
        }
    </script>
    <!-- end -->


    <!-- js edit -->
    <script>
        function edit(x) {
            $.ajax({
                type: "POST",
                url: '<?php echo base_url("ajax/ambilNim"); ?>',
                data: "nim=" + x,
                dataType: "JSON",
                success: function(hasil) {
                    $('#EditForm [name="nim"]').val(hasil[0].nim);
                    $('#EditForm [name="nama"]').val(hasil[0].nama);
                    $('#EditForm [name="kota"]').val(hasil[0].kota);
                }
            });
        }
    </script>

    <script>
        function editData() {
            var nim = $("#EditForm [name='nim']").val();
            var nama = $("#EditForm [name='nama']").val();
            var kota = $("#EditForm [name='kota']").val();
            $.ajax({
                type: 'POST',
                data: 'nim=' + nim + '&nama=' + nama + '&kota=' + kota,
                url: '<?php echo base_url('ajax/editdata'); ?>',
                dataType: 'json',
                success: function(hasil) {
                    $("#pesan").html(hasil.pesan);
                    if (hasil.pesan == '') {
                        $("#EditForm").modal('hide');
                        getData();
                    }
                }
            })
        }
    </script>
    <!-- end -->

    <!-- js hapus -->
    <script>
        function hapusdata(nim) {
            var tanya = confirm("apakah yakin anda menghapus data?");
            if (tanya) {
                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url('ajax/hapusdata'); ?>",
                    data: "nim=" + nim,
                    success: function() {
                        getData();
                    }
                });
            }
        }
    </script>
    <!-- Modal add-->
    <div class="modal fade" id="AddForm" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <!-- title -->
                    <h5 class="modal-title">Add Data Siswa</h5>
                    <!-- button -->
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <!-- content -->
                <div class="modal-body">
                    <p id="pesan"></p>
                    <div class="form-group">
                        <label>Nama</label>
                        <input type="text" class="form-control" name="nama">
                    </div>
                    <div class="form-group">
                        <label>Kota</label>
                        <input type="text" class="form-control" name="kota">
                    </div>
                </div>
                <!-- end content -->

                <!-- button submit -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="addData()">Save</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Edit-->
    <div class="modal fade" id="EditForm" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Data Siswa</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p id="pesan"></p>
                    <div class="form-group">
                        <label>Nama</label>
                        <input type="text" class="form-control" name="nama">
                    </div>
                    <div class="form-group">
                        <label>Kota</label>
                        <input type="text" class="form-control" name="kota">
                    </div>
                    <input type="hidden" name="nim">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="editData()">Update</button>
                </div>
            </div>
        </div>
    </div>
</body>

</html>