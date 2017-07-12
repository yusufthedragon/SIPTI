<?php
  include 'koneksi.php';
  include 'fpdf.php';

  session_start(); //Memulai session
  if (!isset($_SESSION['login'])) { //Jika session belum diset/user belum login
    header("location: login.php"); //Maka akan dialihkan ke halaman login
  }

  $query = $koneksi->prepare ("SELECT *, (harga * stok) AS total FROM inventory WHERE stok > 0");
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
  $pdf->SetTitle('Laporan Inventory');

  //Menambahkan Gambar
  $pdf->Image('images/logo.png', 69, 12, 16, 16);

  //Menentukan jenis & ukuran font yang digunakan untuk header
  $pdf->SetFont('Times', 'B', 14);

  //Membuat header
  $pdf->Cell(85);
  $pdf->Cell(30, 10, 'TOKO ZATI PARTS', 0, 0, 'C');
  $pdf->SetY(16);
  $pdf->SetX(94);
  $pdf->SetFont('Times', 'B', 12);
  $pdf->Cell(30, 9, 'Laporan Inventory', 0, 0, 'C');
  $pdf->SetY(21);
  $pdf->SetX(94);
  $pdf->Cell(30, 9, 'Per '.$tanggalsekarang, 0, 0, 'C');

  //Mengubah warna latar belakang cell menjadi abu-abu
  $pdf->SetFillColor(160, 160, 160);

  //Menentukan jenis & ukuran font yang digunakan untuk head table
  $pdf->SetFont('Times','B', 10);

  //Mengatur letak posisi Y untuk menempatkan head table
  $Y_Fields_Name_position = 32;
  $pdf->SetY($Y_Fields_Name_position);

  //Membuat head table
  $pdf->SetX(8);
  $pdf->Cell(32, 8, 'KODE BARANG', 1, 0, 'C', 1);
  $pdf->SetX(40);
  $pdf->Cell(68, 8, 'NAMA BARANG', 1, 0, 'C', 1);
  $pdf->SetX(108);
  $pdf->Cell(26, 8,'HARGA', 1, 0, 'C', 1);
  $pdf->SetX(134);
  $pdf->Cell(29, 8, 'JUMLAH STOK', 1, 0, 'C', 1);
  $pdf->SetX(163);
  $pdf->Cell(39, 8, 'TOTAL ASET', 1, 0, 'C', 1);
  $pdf->Ln();

  //Mengatur jenis & ukuran font yang digunakan untuk isi table
  $pdf->SetFont('Times', '', 9);

  //Mengatur letak posisi Y untuk isi table
  $Y_Table_Position = 40;

  //Inisialisasi variabel yang digunakan untuk menghitung subtotal
  $subtotal = 0;

  $i = 0; //Inisialisasi variabel untuk mengatur letak posisi Y dinamis berdasarkan looping
  $j = 0; //Inisialisasi variabel counter untuk melakukan If statement
  $k = 40; //Inisialisasi variabel untuk membatasi jumlah looping

  while($row = $query->fetch()) {
    $pdf->SetY($Y_Table_Position+$i);
    $pdf->SetX(8);
    $pdf->MultiCell(32, 6, $row['kode_barang'], 1, 'C');

    $pdf->SetY($Y_Table_Position+$i);
    $pdf->SetX(40);
    $pdf->MultiCell(68, 6, $row['nama_barang'], 1, 'C');

    $pdf->SetY($Y_Table_Position+$i);
    $pdf->SetX(108);
    $pdf->MultiCell(26, 6, "Rp. ".number_format($row['harga'], 0, '', '.'), 1, 'C');
    $subtotal += $row['total'];

    $pdf->SetY($Y_Table_Position+$i);
    $pdf->SetX(134);
    $pdf->MultiCell(29, 6, $row['stok'], 1, 'C');

    $pdf->SetY($Y_Table_Position+$i);
    $pdf->SetX(163);
    $pdf->MultiCell(39, 6, "Rp. ".number_format($row['total'], 0, '', '.'), 1, 'C');

    $i = $i + 6; //Mengatur letak posisi Y dinamis setiap kali looping untuk mengatur posisi Y cell
    $j++; //Menambah value variabel counter
    if ($j ==  $k) { //Jika perulangan telah mencapai variabel batas (k)
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
  $pdf->Cell(155, 6, 'SUB TOTAL ASET', 1, 0, 'C', 1);

  $pdf->SetY($tinggi);
  $pdf->SetX(163);
  $pdf->MultiCell(39, 6, "Rp. ".number_format($subtotal, 0, ".", "."), 1, 'C');

  $pdf->Ln();

  //Mengatur jenis & ukuran font yang digunakan untuk keterangan tanggal & tanda tangan
  $pdf->SetFont('Times', '', 10);

  //Menambah field tanda tangan
  $pdf->SetX(164);
  $pdf->MultiCell(42, 6, $keterangan, 0, 'C');

  $pdf->Output('D','Laporan Inventory Bulan '.$bulan.'.pdf'); //"D" berarti file tersebut tidak bisa di preview tapi langsung di download
?>
