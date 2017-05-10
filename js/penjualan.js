var counter = 2; //Variabel untuk dynamic input box

function upperCaseF(a) { //Fungsi untuk membuat input kapital secara otomatis
  setTimeout(function() {
    a.value = a.value.toUpperCase();
  }, 1);
}

$(function() { //Fungsi tanggal
  $("#datepicker").datepicker({
    dateFormat: "dd MM yy",
    showButtonPanel: true
  });
});

$(function() { //Fungsi untuk mengambil daftar barang dari database
  $("#no1").autocomplete({ //dan mempopulasikannya di input kode barang secara otomatis
    source: 'search.php'
  });
});

function autofill(x) { //Fungsi untuk mengisi input nama barang secara otomatis berdasarkan input kode barang
  var angka = x.id.substr(2); //Mengambil nomor terakhir dari id input kode barang yang sedang aktif
  var no = $("#no" + angka).val();
  $("#jumlah" + angka).val(1); //Mengisi input jumlah secara otomatis
  $.ajax({
    url: 'proses-ajax.php',
    dataType: "html",
    data: "no=" + no,
  }).success(function(data) {
    var json = data,
      obj = JSON.parse(json);
    if (obj.harga == null) { //Karena menggunakan fungsi onkeyup,
      obj.harga = 0; //maka selama input belum sesuai dengan isi tabel daftar barang, return value berupa nilai null
    }
    obj2 = obj;
    $('#barang' + angka).val(obj.nama_barang);
    $('#harga' + angka).val(obj.harga);
    $('#hitung' + angka).val(obj.harga);
  });
}

function autohitung() { //Fungsi untuk mengisi input total secara otomatis
  var total = 0;
  var diskon = 1;
  if (document.getElementById('toko1').checked) { //Mengecek apakah Toko Sartika dipilih atau tidak
    diskon = 0.9;
  }
  var n;
  if (obj2.harga == null) {
    obj2.harga = 0;
  }
  for (n = 1; n < 11; n++) {
    if ((!$('#hitung' + n).length) || (!$('#hitung' + n).val(""))) { //Jika input box dynamic belum dibuat / belum ada
      break;
    } else {
      total = total + (parseInt($('#harga' + n).val()) * $('#jumlah' + n).val() * diskon);
      $('#total').val(total.toLocaleString('id-ID')); //Membuat format uang indonesia
    }
  }
}

$(document).ready(function() {
    $("#tambah").click(function() {
        if (counter > 10) {
            swal("Error", "Hanya dapat membeli 10 barang!", "error");
            return false;
        }
        var newPembelian = $(document.createElement('div'))
            .attr("id", 'pembelian' + counter);
        newPembelian.after().html('<div class="row"></div><div class="col s4">' +
            '<center><label>No. Barang #' + counter + '</label></center><input type="text" name="no' + counter +
            '" id="no' + counter + '" class="validate" /></div><div class="col s4">' +
            '<center><label>Nama Barang</label></center><input type="text" name="barang' + counter +
            '" id="barang' + counter + '" class="validate" /></div><div class="col s4">' +
            '<center><label>Jumlah Barang</label></center><input type="text" name="jumlah' + counter +
            '" id="jumlah' + counter + '" class="center validate" /></div>');
        newPembelian.appendTo("#gruppenjualan");
        counter++;
    });
    $("#hapus").click(function() {
        if (counter == 2) {
            swal("Error", "Minimal membeli 1 barang!", "error");
            return false;
        }
        counter--;
        $("#penjualan" + counter).remove();
    });
    $("#gajadi").click(function() {
        swal({
            title: "Batalkan transaksi?",
            text: "Semua data yang telah dimasukkan akan hilang!",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Ya, batalkan",
            closeOnConfirm: false
        }, function(isConfirm) {
            console.log(isConfirm);
            if (isConfirm) {
                window.location.href = 'index.html';
            }
        });
    });
});
