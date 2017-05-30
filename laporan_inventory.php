<?php
  include 'koneksi.php';
  include 'fpdf.php';

  $query = $koneksi->prepare ("SELECT *, (harga * stok) AS total FROM inventory WHERE stok > 0");
  $query->execute();

  $column_kode_barang = "";
  $column_nama_barang = "";
  $column_harga = "";
  $column_stok = "";
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
    $kode_barang = $row['kode_barang'];
    $nama_barang = $row['nama_barang'];
    $harga = number_format($row['harga'], 0, '', '.');
    $stok = $row['stok'];
    $total = number_format($row['total'], 0, '', '.');
    $subtotal += $row['total'];

    $column_kode_barang = $column_kode_barang.$kode_barang."\n";
    $column_nama_barang = $column_nama_barang.$nama_barang."\n";
    $column_harga = $column_harga."Rp. ".$harga."\n";
    $column_stok = $column_stok.$stok."\n";
    $column_total = $column_total."Rp. ".$total."\n";
  }

  //Create a new PDF file
  $pdf = new FPDF('P','mm','A4');
  $pdf->AddPage();

  $pdf->SetTitle('Laporan Inventory');

  //Menambahkan Gambar
  $pdf->Image('images/logo.png', 69, 12, 16, 16);

  $pdf->SetFont('Times','B', 14);
  $pdf->Cell(85);
  $pdf->Cell(30,10,'TOKO ZATI PARTS',0,0,'C');
  $pdf->SetY(16);
  $pdf->SetX(94);
  $pdf->SetFont('Times','B', 12);
  $pdf->Cell(30, 9,'Laporan Inventory',0,0,'C');
  $pdf->SetY(21);
  $pdf->SetX(94);
  $pdf->Cell(30, 9,'Per '.$tanggalsekarang,0,0,'C');
  $pdf->Ln();

  //Fields Name position
  $Y_Fields_Name_position = 30;

  //First create each Field Name
  //Gray color filling each Field Name box
  $pdf->SetFillColor(160, 160, 160);
  //Bold Font for Field Name
  $pdf->SetFont('Times','B', 10);
  $pdf->SetY($Y_Fields_Name_position);
  $pdf->SetX(8);
  $pdf->Cell(32,8,'KODE BARANG',1,0,'C',1);
  $pdf->SetX(40);
  $pdf->Cell(68,8,'NAMA BARANG',1,0,'C',1);
  $pdf->SetX(108);
  $pdf->Cell(26,8,'HARGA',1,0,'C',1);
  $pdf->SetX(134);
  $pdf->Cell(29,8,'JUMLAH STOK',1,0,'C',1);
  $pdf->SetX(163);
  $pdf->Cell(39,8,'TOTAL MODAL',1,0,'C',1);
  $pdf->Ln();

  //Table position, under Fields Name
  $Y_Table_Position = 38;

  //Now show the columns
  $pdf->SetFont('Times','', 9);

  $pdf->SetY($Y_Table_Position);
  $pdf->SetX(8);
  $pdf->MultiCell(32,6,$column_kode_barang,1,'C');

  $pdf->SetY($Y_Table_Position);
  $pdf->SetX(40);
  $pdf->MultiCell(68,6,$column_nama_barang,1,'C');

  $pdf->SetY($Y_Table_Position);
  $pdf->SetX(108);
  $pdf->MultiCell(26,6,$column_harga,1,'C');

  $pdf->SetY($Y_Table_Position);
  $pdf->SetX(134);
  $pdf->MultiCell(29,6,$column_stok,1,'C');

  $pdf->SetY($Y_Table_Position);
  $pdf->SetX(163);
  $pdf->MultiCell(39,6,$column_total,1,'C');

  $tinggi = $pdf->GetY();
  $pdf->SetFillColor(160, 160, 160);

  $pdf->SetFont('Times','B', 10);
  $pdf->SetY($tinggi);
  $pdf->SetX(8);
  $pdf->Cell(155,6,'SUB TOTAL MODAL',1,0,'C',1);
  $pdf->SetY($tinggi);

  $pdf->SetX(163);
  $pdf->MultiCell(39,6,"Rp. ".number_format($subtotal, 0, ".", "."),1,'C');

  $pdf->Ln();

  $pdf->SetFont('Times','', 10);

  $pdf->SetX(164);
  $pdf->MultiCell(42,6,$keterangan,0,'C');

  $pdf->Output('','Laporan Inventory Bulan '.$bulan.' - Toko Zati Parts');

?>
