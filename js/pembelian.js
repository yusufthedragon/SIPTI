var counter = parseInt(myform.counter.value); //Variabel untuk dynamic input box
var total1; //Variabel untuk menyalin

function upperCaseF(a) { //Fungsi untuk membuat input kapital secara otomatis
  setTimeout(function() {
    a.value = a.value.toUpperCase();
  }, 1);
}

$(function() { //Fungsi Tanggal
  $("#datepicker").datepicker({
    dateFormat: "dd MM yy",
    showButtonPanel: true
  });
});

$(function() { //Fungsi untuk mengambil daftar barang dari database
  $("#no1").autocomplete({ //dan mempopulasikannya di input Kode Barang secara otomatis
    source: 'search_barang_pembelian.php'
  });
});

$(".klik").keypress(function(event) { //Fungsi untuk mencegah user menekan keyboard pada Tanggal
    return false;
});

function autofill(x) { //Fungsi untuk mengisi input Nama Barang secara otomatis berdasarkan Kode Barang
  var angka = x.id.substr(2); //Mengambil nomor terakhir dari id Kode Barang yang sedang aktif
  var no = $("#no" + angka).val();
  if ($("#jumlah" + angka).val().length == 0) { //Jika Jumlah Barang belum terisi
    $("#jumlah" + angka).val(1); //Mengisi Jumlah Barang secara otomatis
  }
  $.ajax({
    url: 'ajax_barang.php',
    dataType: "html",
    data: "no=" + no,
  }).success(function(data) {
    var json = data,
      obj = JSON.parse(json);
    if (obj.harga == null) { //Karena menggunakan fungsi onkeyup,
      obj.harga = 0; //maka selama input belum sesuai dengan isi tabel daftar barang, return value berupa nilai null
    }
    $('#barang' + angka).val(obj.nama_barang);
    $('#harga' + angka).val(obj.harga);
  });
}

function autohitung() { //Fungsi untuk mengisi Total secara otomatis
  console.log($('#harga' + n).val());
  var total = 0; //Variabel untuk menyimpan Total harga
  var diskon = 1;
  if (document.getElementById('toko1').checked) { //Mengecek apakah Toko Sartika dipilih atau tidak
    diskon = 0.9;
  }
  for (var n = 1; n < counter; n++) {
    if (($('#harga' + n).val() == 0) || ($('#harga' + n).val() == undefined)) { //Jika Kode Barang tidak terisi / tersedia di database
      break;
    } else {
      total = total + (parseInt($('#harga' + n).val()) * parseInt($('#jumlah' + n).val()) * diskon); //Menghitung Total
      total1 = total;
      if (isNaN(total)) {
        total = 0;
      }
      $('#total').val(total.toLocaleString('id-ID')); //Membuat format uang indonesia
    }
  }
}

$(document).ready(function() {

  $("#tambah").click(function() {
    if (counter > 10) { //Hanya dapat menginput 10 jenis barang
      swal("BARANG TERLALU BANYAK", "Hanya dapat membeli 10 jenis barang!", "error");
      return false;
    }
    var newPembelian = $(document.createElement('div')) //Membuat div baru untuk menempatkan input group baru
      .attr("id", 'pembelian' + counter);
    newPembelian.after().html('<div class="row"></div>' + //Menambahkan input group ke div yang baru dibuat barusan
      '<div class="col s4">' +
        '<center>' +
          '<label>Kode Barang #' + counter + '</label>' +
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
      '</div>');
    newPembelian.appendTo("#gruppembelian"); //Menggabungkan div tadi ke dalam input group yang sudah ada
    $("#no" + counter).autocomplete({ //Sama seperti fungsi di baris 17
      source: 'search_barang_pembelian.php'
    });
    counter++;
  });

  $("#hapus").click(function() {
    if (counter == 2) { //Mengecek apakah user menghapus satu-satunya input group barang
      swal("Error", "Minimal membeli 1 jenis barang!", "error");
      return false;
    }
    counter--;
    $("#pembelian" + counter).remove(); //Menghapus dynamic textbox terakhir
    autohitung();
  });

  $("#gajadi").click(function() {
    //Mengecek apakah ada data barang yang diisi
    var kosong = true;
    for (var y = 1; y < counter; y++) {
      if ($("#harga" + y).val() != 0) {
        kosong = false;
      }
    }

    if ((myform.tanggal.value != "") || (myform.faktur.value != "") || //Jika ada data yang terisi
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
    //Mengecek apakah ada barang yang sama atau tidak
    var sama = false;
    var q, w;
    for (q = 1; q < counter; q++) {
      for (w = 1; w < counter; w++) {
        if (q == w) break;
        if ($("#no" + q).val() == $("#no" + w).val()) {
          sama = true;
        }
      }
    }

    for (var x = 1; x < counter; x++) {
      if ((myform.tanggal.value == "") || (myform.faktur.value == "") || //Mengecek apakah data lengkap atau tidak
      ((myform.toko1.checked == false) && (myform.toko2.checked == false) && (myform.toko3.checked == false) && (myform.toko4.checked == false))) {
        swal("DATA TIDAK LENGKAP!", "Harap masukkan seluruh data!", "error");
      } else if (myform.faktur.value.length > 10 ) { //Mengecek apakah No. Faktur terlalu panjang atau tidak
        swal("NO. FAKTUR TERLALU PANJANG!", "Panjang No. Faktur maksimal 10 karakter!", "error");
      } else if ($("#barang" + x).val() == "") { //Jika Kode Barang tidak terisi / tersedia di database
        swal({
          title: "BARANG TIDAK ADA DI DATABASE!",
          text: "Pastikan Barang No. #" + x + " terisi atau tersedia di database!",
          type: "error"
        });
        break;
      } else if (sama == true) { //Jika ada data barang yang sama
        q = q-1;
        w = w-1;
        swal({
          title: "BARANG DUPLIKAT!",
          text: "Pastikan Barang No. #" + w + " dan Barang No. #" + q + " tidak sama!",
          type: "error"
        });
        break;
      } else if ($('#jumlah' + x).val() < 1) { //Jika Jumlah Barang < 1
        swal({
          title: "JUMLAH BARANG KOSONG!",
          text: "Pastikan Jumlah Barang No. #" + x + " lebih dari 0!",
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
            $("#counter").val(counter);
            document.forms["myform"].submit();
          }
        });
      }
    }
  });

  $("#edit").click(function() {
    for (var x = 1; x < counter; x++) {
      if ((myform.tanggal.value == "") || (myform.faktur.value == "") ||
      ((myform.toko1.checked == false) && (myform.toko2.checked == false) && (myform.toko3.checked == false) && (myform.toko4.checked == false))) {
        swal("Error!", "Harap masukkan seluruh data!", "error");
      } else if ($('#hitung' + x).val() == "") {
        swal({
          title: "Error!",
          text: "Pastikan No. Barang #" + x + " terisi atau tersedia di database!",
          type: "error"
        });
        break;
      } else if ($('#jumlah' + x).val() < 1) {
        swal({
          title: "Error!",
          text: "Pastikan Jumlah Barang #" + x + " lebih dari 0!",
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
            if (total1 != undefined) {
              $('#total').val(total1);
            }
            document.forms["myform"].submit();
          }
        });
      }
    }
  });
});
