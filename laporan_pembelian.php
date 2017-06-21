<?php
  include 'koneksi.php';
  include 'fpdf.php';

  session_start(); //Memulai session
  if (!isset($_SESSION['login'])) { //Jika session belum diset/user belum login
    header("location: login.php"); //Maka akan dialihkan ke halaman login
  }

  $periode = htmlspecialchars($_POST['bulan'])." ".htmlspecialchars($_POST['tahun']);

  $query = $koneksi->prepare ("SELECT *, (SELECT SUM(jumlah) FROM pengaruh WHERE pengaruh.no_transaksi = pembelian.no_transaksi) AS barang FROM pembelian WHERE tanggal LIKE CONCAT ('%', :periode)");
  $query->bindParam(':periode', $periode);
  $query->execute();

  $column_no_transaksi = "";
  $column_tanggal = "";
  $column_no_faktur = "";
  $column_toko = "";
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

  $subtotal = 0;

  while($row = $query->fetch()) {
    $no_transaksi = $row['no_transaksi'];
    $tanggal = $row['tanggal'];
    $no_faktur = $row['no_faktur'];
    $toko = $row['toko'];
    $barang = $row['barang'];
    $total = number_format($row['total'], 0, '', '.');
    $subtotal += $row['total'];

    $column_no_transaksi = $column_no_transaksi.$no_transaksi."\n";
    $column_tanggal = $column_tanggal.$tanggal."\n";
    $column_no_faktur = $column_no_faktur.$no_faktur."\n";
    $column_toko = $column_toko.$toko."\n";
    $column_barang = $column_barang.$barang."\n";
    $column_total = $column_total."Rp. ".$total."\n";
  }

  //Membuat file PDF baru
  $pdf = new FPDF('P','mm','A4');
  $pdf->AddPage();

  //Mengatur judul laporan
  $pdf->SetTitle('Laporan Pembelian');

  //Menambahkan Gambar
  $pdf->Image('images/logo.png', 69, 12, 16, 16);

  $pdf->SetFont('Times','B', 14);
  $pdf->Cell(85);
  $pdf->Cell(30,10,'TOKO ZATI PARTS',0,0,'C');
  $pdf->SetY(16);
  $pdf->SetX(94);
  $pdf->SetFont('Times','B', 12);
  $pdf->Cell(30, 9,'Laporan Pembelian',0,0,'C');
  $pdf->SetY(21);
  $pdf->SetX(94);
  $pdf->Cell(30, 9,'Per '.$periode,0,0,'C');
  $pdf->Ln();

  $Y_Fields_Name_position = 30;

  $pdf->SetFillColor(160, 160, 160);

  $pdf->SetFont('Times','B', 10);
  $pdf->SetY($Y_Fields_Name_position);
  $pdf->SetX(8);
  $pdf->Cell(32,8,'NO. TRANSAKSI',1,0,'C',1);
  $pdf->SetX(40);
  $pdf->Cell(33,8,'TANGGAL',1,0,'C',1);
  $pdf->SetX(73);
  $pdf->Cell(25,8,'NO. FAKTUR',1,0,'C',1);
  $pdf->SetX(98);
  $pdf->Cell(30,8,'TOKO',1,0,'C',1);
  $pdf->SetX(128);
  $pdf->Cell(35,8,'JUMLAH BARANG',1,0,'C',1);
  $pdf->SetX(163);
  $pdf->Cell(39,8,'TOTAL PEMBELIAN',1,0,'C',1);
  $pdf->Ln();

  $Y_Table_Position = 38;

  $pdf->SetFont('Times','', 9);

  $pdf->SetY($Y_Table_Position);
  $pdf->SetX(8);
  $pdf->MultiCell(32,6,$column_no_transaksi,1,'C');

  $pdf->SetY($Y_Table_Position);
  $pdf->SetX(40);
  $pdf->MultiCell(33,6,$column_tanggal,1,'C');

  $pdf->SetY($Y_Table_Position);
  $pdf->SetX(73);
  $pdf->MultiCell(25,6,$column_no_faktur,1,'C');

  $pdf->SetY($Y_Table_Position);
  $pdf->SetX(98);
  $pdf->MultiCell(30,6,$column_toko,1,'C');

  $pdf->SetY($Y_Table_Position);
  $pdf->SetX(128);
  $pdf->MultiCell(35,6,$column_barang,1,'C');

  $pdf->SetY($Y_Table_Position);
  $pdf->SetX(163);
  $pdf->MultiCell(39,6,$column_total,1,'C');

  $tinggi = $pdf->GetY();
  $pdf->SetFillColor(160, 160, 160);

  $pdf->SetFont('Times','B', 10);
  $pdf->SetY($tinggi);
  $pdf->SetX(8);
  $pdf->Cell(155,6,'SUB TOTAL PEMBELIAN',1,0,'C',1);
  $pdf->SetY($tinggi);

  $pdf->SetX(163);
  $pdf->MultiCell(39,6,"Rp. ".number_format($subtotal, 0, ".", "."),1,'C');

  $pdf->Ln();

  $pdf->SetFont('Times','', 10);

  $pdf->SetX(164);
  $pdf->MultiCell(42,6,$keterangan,0,'C');

  $pdf->Output('','Laporan Pembelian Bulan '.$bulan.' - Toko Zati Parts');
?>
