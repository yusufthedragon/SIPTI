<?php
  include 'koneksi.php';
  include 'fpdf.php';

  session_start(); //Memulai session
  if (!isset($_SESSION['login'])) { //Jika session belum diset/user belum login
    header("location: login.php"); //Maka akan dialihkan ke halaman login
  }

  $periode = htmlspecialchars($_POST['bulan'])." ".htmlspecialchars($_POST['tahun']); //Menggabungkan Bulan dan Tahun yang diinput untuk dijadikan Periode

  $query = $koneksi->prepare ("SELECT *, (SELECT SUM(jumlah) FROM pengaruh WHERE pengaruh.no_transaksi = pembelian.no_transaksi) AS barang FROM pembelian WHERE tanggal LIKE CONCAT ('%', :periode)");
  $query->bindParam(':periode', $periode);
  $query->execute();

  $daftar_bulan = array( //Array untuk menentukan bulan dalam bahasa Indonesia
    '01' => 'Januari',
    '02' => 'Februari',
    '03' => 'Maret',
    '04' => 'April',
    '05' => 'Mei',
    '06' => 'Juni',
    '07' => 'Juli',
    '08' => 'Agustus',
    '09' => 'September',
    '10' => 'Oktober',
    '11' => 'November',
    '12' => 'Desember',
  );

  $bulan = $daftar_bulan[date("m")]; //date("m") akan menghasilkan nomor bulan yang kemudian dicocokan dengan index array daftar_bulan

  $tanggal = date("d  Y");
  $tanggalsekarang = substr_replace($tanggal, $bulan, 3, 0); //Menggabungkan bulan ke tanggal

  //Membuat field tanda tangan pemilik
  $keterangan = "Depok, ";
  $keterangan .= $tanggalsekarang;
  $keterangan .= "\n\n\nMahadin Jatirahman";

  //Membuat file PDF baru
  $pdf = new FPDF('P','mm','A4');
  $pdf->AddPage();

  //Digunakan untuk mematikan AutoPageBreak sehingga PageBreak akan di-inisiasi sendiri
  $pdf->SetAutoPageBreak(0, 12);

  //Mengatur judul laporan
  $pdf->SetTitle('Laporan Pembelian '.$periode);

  //Menambahkan Gambar
  $pdf->Image('images/logo.png', 69, 12, 16, 16);

  //Menentukan jenis & ukuran font yang digunakan untuk header
  $pdf->SetFont('Times','B', 14);

  //Membuat header
  $pdf->Cell(85);
  $pdf->Cell(30, 10, 'TOKO ZATI PARTS', 0, 0, 'C');
  $pdf->SetY(16);
  $pdf->SetX(94);
  $pdf->SetFont('Times', 'B', 12);
  $pdf->Cell(30, 9, 'Laporan Pembelian', 0, 0, 'C');
  $pdf->SetY(21);
  $pdf->SetX(94);
  $pdf->Cell(30, 9, 'Per '.$periode, 0, 0, 'C');
  $pdf->Ln();

  //Mengubah warna latar belakang cell menjadi abu-abu
  $pdf->SetFillColor(160, 160, 160);

  //Menentukan jenis & ukuran font yang digunakan untuk head table
  $pdf->SetFont('Times', 'B', 10);

  //Mengatur letak posisi Y untuk menempatkan head table
  $Y_Fields_Name_position = 30;
  $pdf->SetY($Y_Fields_Name_position);

  //Membuat head table
  $pdf->SetX(8);
  $pdf->Cell(32, 8, 'NO. TRANSAKSI', 1, 0, 'C', 1);
  $pdf->SetX(40);
  $pdf->Cell(33, 8, 'TANGGAL', 1, 0, 'C', 1);
  $pdf->SetX(73);
  $pdf->Cell(25, 8, 'NO. FAKTUR', 1, 0, 'C', 1);
  $pdf->SetX(98);
  $pdf->Cell(30, 8, 'TOKO', 1, 0, 'C', 1);
  $pdf->SetX(128);
  $pdf->Cell(35, 8, 'JUMLAH BARANG', 1, 0, 'C', 1);
  $pdf->SetX(163);
  $pdf->Cell(39, 8, 'TOTAL PEMBELIAN', 1, 0, 'C', 1);
  $pdf->Ln();

  //Mengatur jenis & ukuran font yang digunakan untuk isi table
  $pdf->SetFont('Times','', 9);

  //Mengatur letak posisi Y untuk isi table
  $Y_Table_Position = 38;

  //Inisialisasi variabel yang digunakan untuk menghitung subtotal
  $subtotal = 0;
  $subtotal_barang = 0;

  $i = 0; //Inisialisasi variabel untuk mengatur letak posisi Y dinamis berdasarkan looping
  $j = 0; //Inisialisasi variabel kondisi untuk melakukan If statement
  $k = 40; //Inisialisasi variabel untuk membatasi jumlah looping

  while($row = $query->fetch()) {
    $pdf->SetY($Y_Table_Position+$i);
    $pdf->SetX(8);
    $pdf->MultiCell(32, 6, $row['no_transaksi'], 1, 'C');

    $pdf->SetY($Y_Table_Position+$i);
    $pdf->SetX(40);
    $pdf->MultiCell(33, 6, $row['tanggal'], 1, 'C');

    $pdf->SetY($Y_Table_Position+$i);
    $pdf->SetX(73);
    $pdf->MultiCell(25, 6, $row['no_faktur'], 1, 'C');

    $pdf->SetY($Y_Table_Position+$i);
    $pdf->SetX(98);
    $pdf->MultiCell(30, 6, $row['toko'], 1, 'C');

    $pdf->SetY($Y_Table_Position+$i);
    $pdf->SetX(128);
    $pdf->MultiCell(35, 6, $row['barang'], 1, 'C');
    $subtotal_barang += $row['barang'];

    $pdf->SetY($Y_Table_Position+$i);
    $pdf->SetX(163);
    $pdf->MultiCell(39, 6, "Rp. ".number_format($row['total'], 0, '', '.'), 1, 'C');
    $subtotal += $row['total'];

    $i = $i + 6; //Mengatur letak posisi Y dinamis setiap kali looping untuk mengatur posisi Y cell
    $j++; //Menambah value variabel counter
    if ($j ==  $k) {
      $pdf->AddPage(); //Menambah halaman baru (PageBreak) jika isi table telah mencapai variabel batas
      $Y_Table_Position = 16; //Mengatur letak posisi Y karena posisi Y halaman 1 berbeda dengan halaman selanjutnya
      $i = 0; //Me-reset variabel
      $j = 0; //Menambah value variabel counter
      $k = 44; //Mengatur batas looping karena jumlah isi table halaman 1 berbeda dengan halaman selanjutnya
    }
  }

  //Mengambil posisi Y isi table terakhir
  $tinggi = $pdf->GetY();

  //Mengatur jenis & ukuran font yang digunakan untuk SUB TOTAL
  $pdf->SetFont('Times', 'B', 10);

  //Membuat SUB TOTAL
  $pdf->SetY($tinggi);
  $pdf->SetX(8);
  $pdf->Cell(120, 6, 'SUB TOTAL', 1, 0, 'C', 1);

  $pdf->SetY($tinggi);
  $pdf->SetX(128);
  $pdf->MultiCell(35, 6, $subtotal_barang, 1, 'C');

  $pdf->SetY($tinggi);
  $pdf->SetX(163);
  $pdf->MultiCell(39, 6, "Rp. ".number_format($subtotal, 0, ".", "."), 1, 'C');

  $pdf->Ln();

  //Mengatur jenis & ukuran font yang digunakan untuk keterangan tanggal & tanda tangan
  $pdf->SetFont('Times', '', 10);

  //Menambah field tanda tangan
  $pdf->SetX(164);
  $pdf->MultiCell(42, 6, $keterangan, 0, 'C');

  $pdf->Output('D', 'Laporan Pembelian Bulan '.$periode.'.pdf'); //"D" berarti file tersebut tidak bisa di preview tapi langsung di download
?>
