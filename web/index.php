<?php
   $file = ("conta.txt");
   $visite = file($file);
   echo "visite vale: $visite ";
   $ciao=$visite[0]+1;
   $fp = fopen($file , "w");
   fputs($file , "$ciao");
  //// file_put_contents($file, $ciao); // solo PHP 5!!!
   fclose($fp);
 
    //echo $ciao;
   echo "Hai effetuato  $ciao visite a questo sito.";
   ////echo "    Hai effetuato  $visite[0] visite a questo sito.";
?>
