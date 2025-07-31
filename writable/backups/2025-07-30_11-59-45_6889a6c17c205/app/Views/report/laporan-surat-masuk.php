<?= $this->extend('layout/default') ?>

<?= $this->section('title') ?>
<title>View Kode Klasifikasi &mdash; SDN Krengseng 02</title>
<?= $this->endSection() ?>
<?= $this->section('content') ?>
<div class="page-content">
  <div class="bg-white rounded-2 shadow-sm py-3 px-4 mb-3">
    <!-- judul halaman -->
    <h5 class="page-title py-1 mb-0">
      <i class="mdi mdi-file-document-outline fs-4 align-text-top me-1"></i> Laporan Surat Masuk
    </h5>
  </div>
  <div class="card border-0 shadow-sm mb-5">
    <!-- judul form -->
    <div class="card-header bg-white py-3 px-4">
      <h6 class="form-title mb-0">
        <i class="mdi mdi-filter-outline fs-5 align-text-top me-1"></i> Filter Tanggal Masuk
      </h6>
    </div>
    <div class="card-body p-4">
      <!-- form -->
      <form id="frm-filter" class="needs-validation" novalidate="">
        <div class="row align-items-center">
          <div class="mb-3 col-md-4 col-lg-3">
            <label class="form-label">Tanggal Awal <span class="text-danger">*</span></label>
            <input type="date" id="tanggal_awal" name="tanggal_awal" class="form-control datepicker flatpickr-input" required>
            <div class="invalid-feedback">Tanggal awal tidak boleh kosong.</div>
          </div>

          <div class="mb-3 col-md-4 col-lg-3">
            <label class="form-label">Tanggal Akhir <span class="text-danger">*</span></label>
            <input type="date" id="tanggal_akhir" name="tanggal_akhir" class="form-control datepicker flatpickr-input" required>
            <div class="invalid-feedback">Tanggal akhir tidak boleh kosong.</div>
          </div>
        </div>
      </form>
    </div>
    <div class="card-footer bg-white p-4">
      <!-- button tampil data -->
      <button id="btn-tampil" type="button" class="btn btn-primary btn-label waves-effect waves-light"><i class="ri-user-smile-line label-icon align-middle fs-16 me-2"></i> Tampilkan</button>
      <!-- button cetak data -->
      <button id="btn-cetak" type="button" class="d-none btn btn-warning btn-label waves-effect waves-light"><i class="mdi mdi-printer label-icon align-middle fs-16 me-2"></i> Cetak</button>
      <!-- button export data -->
      <button id="btn-export" type="button" class="d-none btn btn-success btn-label waves-effect waves-light"><i class="mdi mdi-file-excel label-icon align-middle fs-16 me-2"></i> Export</button>
    </div>
  </div>
  <div id="tampil-data" class="d-none bg-white rounded-2 shadow-sm p-4 mb-5">
    <!-- judul tabel -->
    <h6 class="table-title">
      <i class="ti ti-list-details me-1"></i>
      <span id="judul-tabel"></span>
    </h6>

    <hr class="pt-2">

    <div class="table-responsive">
      <!-- tabel untuk menampilkan data dari database -->
      <table id="scroll-horizontal" id="tabel-surat-masuk" class="table table-bordered table-striped table-hover" style="width:100%">
        <thead>
          <tr>
            <th class="text-center">No.</th>
            <th class="text-center">Nomor Agenda</th>
            <th class="text-center">Tanggal Masuk</th>
            <th class="text-center">Asal Surat</th>
            <th class="text-center">Nomor Surat</th>
            <th class="text-center">Tanggal Surat</th>
            <th class="text-center">Perihal</th>
            <th class="text-center">Keterangan</th>
            <th class="text-center">Sifat Surat</th>
          </tr>
        </thead>
      </table>
    </div>
  </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
<script>
  $(document).ready(function() {
    /** Tampil Data
     *****************
     */
    // Menampilkan Laporan Data Surat Masuk
    $('#btn-tampil').click(function() {
      // validasi form input
      // jika ada input (required) yang kosong
      if ($("#frm-filter")[0].checkValidity() === false) {
        // batalkan submit form
        event.preventDefault()
        event.stopPropagation()
      }
      // jika tidak ada input (required) yang kosong
      else {
        // tampilkan preloader
        $('.preloader').fadeIn('slow');

        // memberikan interval waktu sebelum fungsi dijalankan
        setTimeout(function() {
          // tutup preloader
          $('.preloader').fadeOut('fast');
          // tampilkan button cetak dan button export
          $('#btn-cetak').removeClass('d-none');
          $('#btn-export').removeClass('d-none');
          // tampilkan tabel tampil data
          $('#tampil-data').removeClass('d-none');
          // judul tabel
          $('#judul-tabel').html('Laporan Data Surat Masuk Tanggal <strong>' + $('#tanggal_awal').val() + '</strong> s.d. <strong>' + $('#tanggal_akhir').val() + '</strong>.');

          // DataTables plugin untuk membuat nomor urut tabel
          $.fn.dataTableExt.oApi.fnPagingInfo = function(oSettings) {
            return {
              "iStart": oSettings._iDisplayStart,
              "iEnd": oSettings.fnDisplayEnd(),
              "iLength": oSettings._iDisplayLength,
              "iTotal": oSettings.fnRecordsTotal(),
              "iFilteredTotal": oSettings.fnRecordsDisplay(),
              "iPage": Math.ceil(oSettings._iDisplayStart / oSettings._iDisplayLength),
              "iTotalPages": Math.ceil(oSettings.fnRecordsDisplay() / oSettings._iDisplayLength)
            };
          };

          // Menampilkan data dengan datatables serverside processing
          let table = $('#tabel-surat-masuk').DataTable({
            "destroy": true, // menghapus "idTabel" yang sudah ada agar bisa diinisialisasi kembali
            "processing": true, // tampilkan loading saat proses tampil data
            "serverSide": true, // aktifkan serverside processing
            // ajax request untuk mengambil data surat masuk
            "ajax": {
              "type": "GET", // mengirim data dengan method GET
              "url": "<?= site_url('report/generateReport') ?>", // file proses get data
              // data yang dikirim
              "data": {
                function(d) {
                  d.tanggal_awal = $('#tanggal_awal').val();
                  d.tanggal_akhir = $('#tanggal_akhir').val();
                }
              }
            },
            // tampilkan data
            "columns": [{
                "data": "no_agenda"
              },
              {
                "data": "tgl_masuk"
              },
              {
                "data": "asal_surat"
              },
              {
                "data": "nomor_surat"
              },
              {
                "data": "tgl_surat"
              },
              {
                "data": "perihal"
              },
              {
                "data": "keterangan"
              },
              {
                "data": "sifat_surat"
              }
            ],
            "columnDefs": [{
                "targets": 0,
                "searchable": false,
                "width": '30px',
                "className": 'text-center'
              },
              {
                "targets": 1,
                "width": "70px",
                "className": "text-center"
              },
              {
                "targets": 2,
                "width": "70px",
                "className": "text-center"
              },
              {
                "targets": 3,
                "width": "170px"
              },
              {
                "targets": 4,
                "width": "100px",
                "className": "text-center"
              },
              {
                "targets": 5,
                "width": "70px",
                "className": "text-center"
              }
            ],
            "order": [
              [1, "asc"]
            ], // urutkan data berdasarkan "nomor_agenda" secara ascending
            "iDisplayLength": 10, // tampilkan 10 data per halaman
            // membuat nomor urut tabel
            "rowCallback": function(row, data, iDisplayIndex) {
              let info = this.fnPagingInfo();
              let page = info.iPage;
              let length = info.iLength;
              let index = page * length + (iDisplayIndex + 1);
              $('td:eq(0)', row).html(index);
            }
          });
        }, 500);
      }

      // tambahkan class was-validated pada form input saat form input sudah divalidasi
      $("#frm-filter").addClass('was-validated');
    });

    /** Print
     *****************
     * Cetak PDF
     * Export Excel
     */
    // Cetak Laporan dalam format PDF
    $('#btn-cetak').click(function() {
      // validasi form input
      // jika ada input (required) yang kosong
      if ($("#frm-filter")[0].checkValidity() === false) {
        // batalkan submit form
        event.preventDefault()
        event.stopPropagation()
      }
      // jika tidak ada input (required) yang kosong
      else {
        // ambil data hasil submit dari form dan buat variabel untuk menampung data
        let tanggal_awal = $('#tanggal_awal').val();
        let tanggal_akhir = $('#tanggal_akhir').val();

        // alihkan ke halaman cetak laporan
        window.open('<?= site_url('report/downloadPdf') ?>/' + tanggal_awal + '-sd-' + tanggal_akhir, '_blank');
      }

      // tambahkan class was-validated pada form input saat form input sudah divalidasi
      $("#frm-filter").addClass('was-validated');
    });

    // Export Laporan dalam format Ms. Excel
    $('#btn-export').click(function() {
      // validasi form input
      // jika ada input (required) yang kosong
      if ($("#frm-filter")[0].checkValidity() === false) {
        // batalkan submit form
        event.preventDefault()
        event.stopPropagation()
      }
      // jika tidak ada input (required) yang kosong
      else {
        // ambil data hasil submit dari form dan buat variabel untuk menampung data
        let tanggal_awal = $('#tanggal_awal').val();
        let tanggal_akhir = $('#tanggal_akhir').val();

        // alihkan ke halaman export laporan
        location.href = 'laporan-surat-masuk-export-' + tanggal_awal + '-sd-' + tanggal_akhir;
      }

      // tambahkan class was-validated pada form input saat form input sudah divalidasi
      $("#frm-filter").addClass('was-validated');
    });
  });
</script>
<?= $this->endSection() ?>