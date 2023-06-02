<?php

class modelPetugas extends koneksiDB{
    public function __construct(){
        $this->hubungkanDatabase();
    }

    // method untuk Simpan Data Petugas
    public function simpanPetugas($varNIK, $varNama, $varTempat, $varTgl, $varTelp, $varAlamat){
        $varDB =$this->databasenya;
        try {
            // mengecek duplikasi NIK saat diinputkan
            $perintah = $varDB ->prepare("SELECT*FROM petugas WHERE nik='$varNIK'");
            $perintah->execute();
            if ($perintah->rowCount()>0){
                $posisi[0]=true;//acuan kode berhasil
                $posisi[1]="NIK sudah terdaftar";
                $posisi[2]="Duplicate Yes";
            }else{
                $perintah = $varDB ->prepare("INSERT INTO petugas (nik,nama,tempat_lahir,tanggal_lahir,telp,alamat) VALUES (:nik, :nama, :tempat, :tanggal, :telp, :alamat) ");
                $perintah->bindParam("nik",$varNIK);
                $perintah->bindParam("nama",$varNama);
                $perintah->bindParam("tempat",$varTempat);
                $perintah->bindParam("tanggal",$varTgl);
                $perintah->bindParam("telp",$varTelp);
                $perintah->bindParam("alamat",$varAlamat);
                $perintah->execute();
                $posisi[0]=true;//acuan kode berhasil
                $posisi[1]="Data Petugas Berhasil disimpan";
                $posisi[2]="Duplicate No";
            }
           
            return $posisi;
        } catch (PDOException $psn) {
            $posisi[0]=false; //acuan kode salah
            $posisi[1]=$psn->getMessage();
            return $posisi;
        }
    }

    // method untuk Ubah Data Petugas
    public function ubahPetugas($varNIK, $varNama, $varTempat, $varTgl, $varTelp, $varAlamat){
        $varDB =$this->databasenya;
        try {
            $perintah = $varDB ->prepare(" UPDATE petugas SET nama= :nama, tempat_lahir= :tempat, tanggal_lahir= :tanggal,
            telp= :telp, alamat= :alamat WHERE nik= :nik");
            $perintah->bindParam("nik",$varNIK);
            $perintah->bindParam("nama",$varNama);
            $perintah->bindParam("tempat",$varTempat);
            $perintah->bindParam("tanggal",$varTgl);
            $perintah->bindParam("telp",$varTelp);
            $perintah->bindParam("alamat",$varAlamat);
            $perintah->execute();
            $posisi[0]=true;//acuan kode berhasil
            $posisi[1]="Data Petugas Berhasil diubah";
            return $posisi;
        } catch (PDOException $psn) {
            $posisi[0]=false; //acuan kode salah
            $posisi[1]=$psn->getMessage();
            return $posisi;
        }
    }

    // method untuk Hapus Data Petugas
    public function hapusPetugas($varNIK){
        $varDB =$this->databasenya;
        try {
            $perintah = $varDB ->prepare("DELETE FROM petugas WHERE nik= :nik");
            $perintah->bindParam("nik",$varNIK);
            $perintah->execute();
            $posisi[0]=true;//acuan kode berhasil
            $posisi[1]="Data Petugas Berhasil dihapus";
            return $posisi;
        } catch (PDOException $psn) {
            $posisi[0]=false; //acuan kode salah
            $posisi[1]=$psn->getMessage();
            return $posisi;
        }
    }

    //method mengambil record data petugas
    public function recordDataPetugas(){
        $varDB =$this->databasenya;
        try {
            
            $perintah = $varDB ->prepare("SELECT*FROM petugas ORDER BY nik ASC");
            $perintah->execute();
            $posisi[0]=true;//acuan kode berhasil
            $posisi[1]="Data_Petugas";
            $posisi[2]=$perintah->fetchAll(PDO::FETCH_ASSOC);
            return $posisi;
        } catch (PDOException $psn) {
            $posisi[0]=false; //acuan kode salah
            $posisi[1]=$psn->getMessage();
            $posisi[2]=[];
            return $posisi;
        }
    }

    //method mengambil record data petugas 1 baris untuk ditampilkan ke modal inputan
    public function SatuBarisPetugas($varNIK){
        $varDB =$this->databasenya;
        try {
            $perintah = $varDB ->prepare("SELECT*FROM petugas WHERE nik='$varNIK'");
            $perintah->execute();
            $posisi[0]=true;//acuan kode berhasil
            $posisi[1]="Data Petugas Satu Baris";
            $posisi[2]=$perintah->fetchAll(PDO::FETCH_ASSOC);
            return $posisi;
        } catch (PDOException $psn) {
            $posisi[0]=false; //acuan kode salah
            $posisi[1]=$psn->getMessage();
            $posisi[2]=[];
            return $posisi;
        }
    }
}
$(document).on("click",".btn-edit-petugas",function(){

    var posisiBaris = $(this).parents('tr');
    if (posisiBaris .hasClass('child')) {
        posisiBaris = posisiBaris .prev();
    }
    var table = $('#table-petugas').DataTable();
    var data = table.row( posisiBaris ).data();
    $('#txtnik').val(data.nik);
    $('#txtnik').attr("readonly",true);
    $('#txtnama').val(data.nama);
    $('#txttempat').val(data.tempat_lahir);
    $('#txttgl').val(data.tanggal_lahir);
    $('#txttelp').val(data.telp);
    $('#txtalamat').val(data.alamat);
    $('#btnPetugas').text('Ubah');
    $('#petugasModal').modal('show');
    $('#titlePetugasModal').text('Ubah Data');

  });
  $(document).on("click",".btn-hapus-petugas",function(){
    let posisiBaris = $(this).parents('tr');
    if (posisiBaris.hasClass('child')) {
          posisiBaris = posisiBaris.prev();
    }
    let table = $('#table-petugas').DataTable();
    let data = table.row(posisiBaris).data();
    
    swal({
        title: "Delete",
        text: "Apakah anda yakin menghapus data ini ?",
        type: "warning",
        showCancelButton: true,
        confirmButtonClass: "btn-danger",
        confirmButtonText: "Delete",
        closeOnConfirm: false,
        showLoaderOnConfirm: true
    },
function(){

   $.ajax({
   url:"source/controller/controllerPetugas.php",
   type: "POST",
   data: {
            js_nik: data.nik,
            js_perintah:'Hapus_Petugas'
         },
   success: function(data)
   {
        $resp = JSON.parse(data);
        if($resp['hasil'] == true){
          swal($resp['pesan']);
          let xtable = $('#table-petugas').DataTable();
          xtable.ajax.reload( null, false );
        }else{
        swal("Error hapus Petugas: "+$resp['pesan'])
        }

   }
 });
});


  });




?>