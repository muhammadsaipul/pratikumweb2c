$(document).ready(function(){


$('#txthasil').prop('disabled',true);
$('#btnTes').click(function(){
    $.ajax({
        url:".source/controller/controllerMtk.php",
        method:"POST",
        data:{
            varalas: $('#txtalas').val(),
            vartinggi : $('txttinggi').val(),
            varperintah:"cari_luassegitiga"
        },
        success:function(respond){
            $data=JSON.parse (respond);
            $('$#txthasil').val($data ['hasil']);
            alert($data['pesan']);
            }
        
    });
});
});
