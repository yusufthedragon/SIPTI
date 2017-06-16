var counter = parseInt(myform.counter.value); //Variabel untuk dynamic input box
var total1;
var stok;

function upperCaseF(a) { //Fungsi untuk membuat input kapital secara otomatis
  setTimeout(function() {
    a.value = a.value.toUpperCase();
  }, 1);
}

function firstUpperF(a) {
  setTimeout(function() {
    a.value = a.value.charAt(0).toUpperCase() + a.value.slice(1);
  }, 1);
}

$(".klik").keypress(function(event) {
    return false;
});

$(function() { //Fungsi tanggal
  $("#datepicker").datepicker({
    dateFormat: "dd MM yy",
    showButtonPanel: true
  });
});

$(function() { //Fungsi untuk mengambil daftar barang dari database
  $("#no1").autocomplete({ //dan mempopulasikannya di input kode barang secara otomatis
    source: 'search_barang_penjualan.php'
  });
});

function autofill(x) { //Fungsi untuk mengisi input nama barang secara otomatis berdasarkan input kode barang
  var angka = x.id.substr(2); //Mengambil nomor terakhir dari id input kode barang yang sedang aktif
  var no = $("#no" + angka).val();
  if ($("#jumlah" + angka).val().length == 0) {
    $("#jumlah" + angka).val(1); //Mengisi input jumlah secara otomatis
  }
  $.ajax({
    url: 'ajax_barang.php',
    dataType: "html",
    data: "no=" + no,
  }).success(function(data) {
    var untung;
    var json = data,
      obj = JSON.parse(json);
    if (obj.harga == null) { //Karena menggunakan fungsi onkeyup,
      obj.harga = 0; //maka selama input belum sesuai dengan isi tabel daftar barang, return value berupa nilai null
    }
    $('#barang' + angka).val(obj.nama_barang);
    if (obj.harga > 300000) untung = 30000; else untung = obj.harga * 0.1;
    $('#harga' + angka).val(obj.harga + untung);
    $('#hitung' + angka).val(obj.harga + untung);
    $('#stok' + angka).val(obj.stok);
  });
}

function autohitung() { //Fungsi untuk mengisi input total secara otomatis
  var total2 = 0;
  for (var n = 1; n < 11; n++) {
    if ((!$('#hitung' + n).length) || (!$('#hitung' + n).val(""))) { //Jika input box dynamic belum dibuat / belum ada
      break;
    } else {
      total2 = total2 + (parseInt($('#harga' + n).val()) * $('#jumlah' + n).val());
      total1 = total2;
      if (isNaN(total2)) {
        total2 = 0;
      }
      $('#total').val(total2.toLocaleString('id-ID')); //Membuat format uang indonesia
    }
  }
}

$(document).ready(function() {
  $("#tambah").click(function() {
      if (counter > 10) {
          swal("Error", "Hanya dapat menjual 10 barang!", "error");
          return false;
      }
      var newPenjualan = $(document.createElement('div'))
          .attr("id", 'penjualan' + counter);
      newPenjualan.after().html('<div class="row"></div>' + //Menambahkan input group ke div yang baru dibuat barusan
        '<div class="col s4">' +
          '<center>' +
            '<label>No. Barang #' + counter + '</label>' +
            '</center>' +
            '<input type="text" name="no' + counter + '" id="no' + counter + '" class="center autocomplete" onkeyup="autofill(this), autohitung(), upperCaseF(this)" />' +
        '</div>' +
        '<div class="col s4">' +
          '<center>' +
            '<label>Nama Barang</label>' +
          '</center>' +
          '<input type="text" name="barang' + counter + '" id="barang' + counter + '" class="center validate" readonly />' +
        '</div>' +
        '<div class="col s4">' +
          '<center>' +
            '<label>Jumlah Barang</label>' +
          '</center>' +
          '<input type="text" name="jumlah' + counter + '" id="jumlah' + counter + '" class="center validate" onkeyup="autohitung()" autocomplete="off" />' +
        '</div>' +
        '<div class="col s3">' +
          '<input type="text" name="harga' + counter + '" id="harga' + counter + '" class="center validate" hidden />' +
        '</div>' +
        '<div class="col s12">' +
          '<input type="text" name="hitung' + counter + '" id="hitung' + counter + '" hidden />' +
        '</div>');
      newPenjualan.appendTo("#gruppenjualan"); //Menggabungkan div tadi ke dalam input group yang sudah ada
      $("#no" + counter).autocomplete({ //Sama seperti fungsi di baris 17
        source: 'search_barang_penjualan.php'
      });

      counter++;
  });
  $("#hapus").click(function() {
    if (counter == 2) {
        swal("Error", "Minimal menjual 1 barang!", "error");
        return false;
    }
    counter--;
    $("#penjualan" + counter).remove();
  });

  $("#gajadi").click(function() {
    var kosong = true;
    for (var y = 1; y <= counter + 1; y++) {
      $('#hitung' + y).val($('#no' + y).val());
      if (!$('#hitung' + y).val() == "") {
        kosong = false;
      }
    }
    if ((myform.tanggal.value != "") || (myform.nama.value != "") || (myform.alamat.value != "")
    || ((myform.kurir2.checked != false) || (myform.kurir3.checked != false) || (myform.kurir4.checked != false))
    || (myform.ongkir.value != "") || (myform.resi.value != "") || (kosong == false)) {
      swal({
        title: "Anda yakin?",
        text: "Semua data yang telah dimasukkan akan hilang!",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Ya, saya yakin!",
        cancelButtonText: "Batal",
        closeOnConfirm: false
      }, function(isConfirm) {
        if (isConfirm) {
          if (window.location.href == "http://localhost/PI/penjualan.php") {
            window.location = 'index.php';
          } else window.location = history.go(-1);
        }
      });
    } else {
      if (window.location.href == "http://localhost/PI/penjualan.php") {
        window.location = 'index.php';
      } else window.location = history.go(-1);
    }
  });

  $("#konfirmasi").click(function() {
    var cek = false;
    var q = 1;
    for (var x = 1; x < counter; x++) {
      q++;
      if (cek == true) break;
      for (var y = q; y < counter + 1; y++) {
        if ($('#no' + x).val() == $('#no' + y).val()) {
          cek = true;
          a = x;
          b = y;
        }
      }
    }

    for (var x = 1; x < counter; x++) {
      $('#hitung' + x).val($('#barang' + x).val());
      if ((myform.tanggal.value == "") || (myform.nama.value == "")) {
        swal({
          title: "Error!",
          text: "Harap mengisi data Tanggal, Nama Konsumen, dan Barang!",
          type: "error"
        });
        break;
      } else if (((myform.kurir2.checked == true) || (myform.kurir3.checked == true) || (myform.kurir4.checked == true) || (myform.kurir5.checked == true))
      && ((myform.alamat.value == "") || (myform.ongkir.value == 0) || (myform.resi.value == ""))) {
      swal({
        title: "Error!",
        text: "Harap mengisi Alamat, Ongkos Kirim, dan No. Resi jika menggunakan Kurir!",
        type: "error"
      });
      break;
      } else if ((myform.kurir1.checked == true) && ((myform.ongkir.value != 0) || (myform.resi.value != ""))) {
        swal({
          title: "Error!",
          text: "Harap gunakan kurir jika mengisi Ongkos Kirim dan No. Resi!",
          type: "error"
        });
      break;
    } else if ($('#hitung' + x).val() == "") {
        swal({
          title: "Error!",
          text: "Pastikan Barang #" + x + " terisi atau tersedia di database!",
          type: "error"
        });
        break;
      } else if (cek == true) {
        swal({
          title: "Error!",
          text: "Barang #" + a +" dan Barang #" + b + " sama!",
          type: "error"
        });
        break;
      } else if (parseInt($('#jumlah' + x).val()) > parseInt($('#stok' + x).val())) {
        swal({
          title: "Error!",
          text: "Barang #" + x +" hanya tersedia " + $('#stok' + x).val() + " buah di gudang!",
          type: "error"
        });
        break;
      } else {
        autohitung();
        swal({
          title: "Anda yakin?",
          text: "Semua data akan dimasukkan ke database!",
          type: "warning",
          showCancelButton: true,
          confirmButtonColor: "#DD6B55",
          confirmButtonText: "Ya, saya yakin!",
          cancelButtonText: "Batal",
          closeOnConfirm: false
        }, function(isConfirm) {
          if (isConfirm) {
            $('#total').val(total1);
            document.forms["myform"].submit();
          }
        });
      }
    }
  });
});
