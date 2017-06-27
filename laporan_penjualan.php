<?php
  include 'koneksi.php';
  include 'fpdf.php';

  session_start(); //Memulai session
  if (!isset($_SESSION['login'])) { //Jika session belum diset/user belum login
    header("location: login.php"); //Maka akan dialihkan ke halaman login
  }

  $periode = htmlspecialchars($_POST['bulan'])." ".htmlspecialchars($_POST['tahun']);

  $query = $koneksi->prepare ("SELECT *, (SELECT SUM(jumlah) FROM pengaruh WHERE pengaruh.no_transaksi = penjualan.no_transaksi) AS barang FROM penjualan WHERE tanggal LIKE CONCAT ('%', :periode)");
  $query->bindParam(':periode', $periode);
  $query->execute();

  $column_no_transaksi = "";
  $column_tanggal = "";
  $column_nama = "";
  $column_alamat = "";
  $column_kurir = "";
  $column_ongkir = "";
  $column_no_resi = "";;
  $column_barang = "";
  $column_total = "";

  $daftar_bulan = array(
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

  $bulan = $daftar_bulan[date("m")];

  $tanggal = date("d  Y");
  $tanggalsekarang = substr_replace($tanggal, $bulan, 3, 0);

  $keterangan = "Depok, ";
  $keterangan .= $tanggalsekarang;
  $keterangan .= "\n\n\nMahadin Jatirahman";

  $subtotal_ongkir = 0;
  $subtotal = 0;

  while($row = $query->fetch()) {
    $no_transaksi = $row['no_transaksi'];
    $tanggal = $row['tanggal'];
    $nama = $row['nama'];
    $alamat = $row['alamat'];
    $kurir = $row['kurir'];
    $ongkir = number_format($row['ongkir'], 0, '', '.');
    $no_resi = $row['no_resi'];
    if (strlen($no_resi) < 1) $no_resi = "COD";
    $barang = $row['barang'];
    $total = number_format($row['total'], 0, '', '.');
    $subtotal_ongkir += $row['ongkir'];
    $subtotal += $row['total'];

    $column_no_transaksi = $column_no_transaksi.$no_transaksi."\n";
    $column_tanggal = $column_tanggal.$tanggal."\n";
    $column_nama = $column_nama.$nama."\n";
    $column_alamat = $column_alamat.$alamat."\n";
    $column_kurir = $column_kurir.$kurir."\n";
    $column_ongkir = $column_ongkir."Rp. ".$ongkir."\n";
    $column_no_resi = $column_no_resi.$no_resi."\n";
    $column_barang = $column_barang.$barang."\n";
    $column_total = $column_total."Rp. ".$total."\n";
  }

  //Membuat file PDF baru
  $pdf = new FPDF('P','mm','A4');
  $pdf->AddPage();

  //Mengatur judul laporan
  $pdf->SetTitle('Laporan Penjualan');

  //Menambahkan Gambar
  $pdf->Image('images/logo.png', 69, 12, 16, 16);

  $pdf->SetFont('Times','B', 14);
  $pdf->Cell(85);
  $pdf->Cell(30,10,'TOKO ZATI PARTS',0,0,'C');
  $pdf->SetY(16);
  $pdf->SetX(94);
  $pdf->SetFont('Times','B', 12);
  $pdf->Cell(30, 9,'Laporan Penjualan',0,0,'C');
  $pdf->SetY(21);
  $pdf->SetX(94);
  $pdf->Cell(30, 9,'Per '.$periode,0,0,'C');
  $pdf->Ln();

  $Y_Fields_Name_position = 30;

  $pdf->SetFillColor(160, 160, 160);

  $pdf->SetFont('Times','B', 10);
  $pdf->SetY($Y_Fields_Name_position);
  $pdf->SetX(4);
  $pdf->Cell(29,8,'NO. TRANSAKSI',1,0,'C',1);
  $pdf->SetX(33);
  $pdf->Cell(27,8,'TANGGAL',1,0,'C',1);
  $pdf->SetX(60);
  $pdf->Cell(23,8,'NAMA',1,0,'C',1);
  $pdf->SetX(83);
  $pdf->Cell(21,8,'NO. RESI',1,0,'C',1);
  $pdf->SetX(104);
  $pdf->Cell(30,8,'ONGKOS KIRIM',1,0,'C',1);
  $pdf->SetX(134);
  $pdf->Cell(35,8,'JUMLAH BARANG',1,0,'C',1);
  $pdf->SetX(169);
  $pdf->Cell(37,8,'TOTAL PENJUALAN',1,0,'C',1);
  $pdf->Ln();

  $Y_Table_Position = 38;

  $pdf->SetFont('Times','', 9);

  $pdf->SetY($Y_Table_Position);
  $pdf->SetX(4);
  $pdf->MultiCell(29,6,$column_no_transaksi,1,'C');

  $pdf->SetY($Y_Table_Position);
  $pdf->SetX(33);
  $pdf->MultiCell(27,6,$column_tanggal,1,'C');

  $pdf->SetY($Y_Table_Position);
  $pdf->SetX(60);
  $pdf->MultiCell(23,6,$column_nama,1,'C');

  $pdf->SetY($Y_Table_Position);
  $pdf->SetX(83);
  $pdf->MultiCell(21,6,$column_no_resi,1,'C');

  $pdf->SetY($Y_Table_Position);
  $pdf->SetX(104);
  $pdf->MultiCell(30,6,$column_ongkir,1,'C');

  $pdf->SetY($Y_Table_Position);
  $pdf->SetX(134);
  $pdf->MultiCell(35,6,$column_barang,1,'C');

  $pdf->SetY($Y_Table_Position);
  $pdf->SetX(169);
  $pdf->MultiCell(37,6,$column_total,1,'C');

  $tinggi = $pdf->GetY();
  $pdf->SetFillColor(160, 160, 160);

  $pdf->SetFont('Times','B', 10);
  $pdf->SetY($tinggi);
  $pdf->SetX(4);
  $pdf->Cell(100,6,'SUB TOTAL ONGKOS KIRIM :',1,0,'C',1);
  $pdf->SetY($tinggi);

  $pdf->SetX(104);
  $pdf->MultiCell(30,6,"Rp. ".number_format($subtotal_ongkir, 0, ".", "."),1,'C');

  $pdf->SetY($tinggi);
  $pdf->SetX(134);
  $pdf->Cell(35,6,'PENJUALAN :',1,0,'C',1);

  $pdf->SetY($tinggi);

  $pdf->SetX(169);
  $pdf->MultiCell(37,6,"Rp. ".number_format($subtotal, 0, ".", "."),1,'C');

  $pdf->Ln();

  $pdf->SetFont('Times','', 10);

  $pdf->SetX(164);
  $pdf->MultiCell(42,6,$keterangan,0,'C');

  $pdf->Output('D','Laporan Penjualan Bulan '.$bulan.'.pdf');
?>
