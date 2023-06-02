<?php

if( isset( $_SERVER['HTTP_X_REQUESTED_WITH'] ) && 
    ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest' ) )
{
  
    $deteksiPerintah=$_POST['varperintah'];
    $myobject= new modelMTK();

    if ($deteksiPerintah=="cari_luassegitiga")
    {
        $myobject->luasSegitiga($_POST) 'varalas'
    }

}

?>