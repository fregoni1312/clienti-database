<?php
   $file = ("conta.txt");
   $visite = file($file);
   $ciao=$visite+1;
   //$fp = fopen($file , "w");
   //fputs($file , "$visite[0]");
   file_put_contents($file, $visitie[0]); // solo PHP 5!!!
   fclose($fp);
  
    echo $ciao;
   echo "    Hai effetuato  $visite[0] visite a questo sito.";
?>
