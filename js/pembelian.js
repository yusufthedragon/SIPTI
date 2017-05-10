var counter = 2; //Variabel untuk dynamic input box
var obj2; //Variabel untuk menghitung total secara otomatis
var total = 0; //Variabel untuk menyimpan total harga

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
      $('#total').val(total);
    }
  }
}

$(document).ready(function() {

  $("#tambah").click(function() {
    if (counter > 10) { //Hanya dapat menginput 10 jenis barang
      swal("Error", "Hanya dapat membeli 10 jenis barang!", "error");
      return false;
    }
    var newPembelian = $(document.createElement('div')) //Membuat div baru untuk menempatkan input group baru
      .attr("id", 'pembelian' + counter);
    newPembelian.after().html('<div class="row"></div>' + //Menambahkan input group ke div yang baru dibuat barusan
      '<div class="col s4">' +
        '<center>' +
          '<label>No. Barang #' + counter + '</label>' +
          '</center>' +
          '<input type="text" name="no' + counter + '" id="no' + counter + '" class="validate" onkeyup="autofill(this), autohitung()" />' +
      '</div>' +
      '<div class="col s4">' +
        '<center>' +
          '<label>Nama Barang</label>' +
        '</center>' +
        '<input type="text" name="barang' + counter + '" id="barang' + counter + '" class="validate" readonly />' +
      '</div>' +
      '<div class="col s4">' +
        '<center>' +
          '<label>Jumlah Barang</label>' +
        '</center>' +
        '<input type="text" name="jumlah' + counter + '" id="jumlah' + counter + '" class="center validate" onkeyup="autohitung()" />' +
      '</div>' +
      '<div class="col s3">' +
        '<input type="text" name="harga' + counter + '" id="harga' + counter + '" class="center validate" hidden />' +
      '</div>' +
      '<div class="col s12">' +
        '<input type="text" name="hitung' + counter + '" id="hitung' + counter + '" hidden />' +
      '</div>');
    newPembelian.appendTo("#gruppembelian"); //Menggabungkan div tadi ke dalam input group yang sudah ada
    $("#no" + counter).autocomplete({ //Sama seperti fungsi di baris 17
      source: 'search.php'
    });

    counter++;
  });

  $("#hapus").click(function() {
    if (counter == 2) { //Mengecek apakah user menghapus satu-satunya input group barang
      swal("Error", "Minimal membeli 1 jenis barang!", "error");
      return false;
    }
    counter--;
    $("#pembelian" + counter).remove(); //Menghapus input group
  });

  $("#gajadi").click(function() {
    var kosong = true;
    for (var y = 11; y >= counter - 1; y--) {
      $('#hitung' + y).val($('#no' + y).val());
      console.log($('#hitung' + y).val());
      if (!$('#hitung' + y).val() == "") {
        kosong = false;
      }
    }
    if ((myform.tanggal.value != "") || (myform.faktur.value != "") ||
    ((myform.toko1.checked != false) || (myform.toko2.checked != false) || (myform.toko3.checked != false) || (myform.toko4.checked != false))
    || (kosong == false)) {
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
          window.location = 'index.php';
        }
      });
    } else window.location = 'index.php';
  });

  $("#konfirmasi").click(function() {
    for (var x = 11; x >= counter - 1; x--) {
      $('#hitung' + x).val($('#barang' + x).val());
      if ((myform.tanggal.value == "") || (myform.faktur.value == "") ||
      ((myform.toko1.checked == false) && (myform.toko2.checked == false) && (myform.toko3.checked == false) && (myform.toko4.checked == false))) {
        swal("Error!", "Harap input seluruh data!", "error");
      } else if ($('#hitung' + x).val() == "") {
        swal({
          title: "Error!",
          text: "Pastikan No. Barang #" + x + " terisi atau tersedia di database!",
          type: "error"
        });
        break;
      } else {
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
            document.forms["myform"].submit();
          }
        });
      }
    }
  });
});