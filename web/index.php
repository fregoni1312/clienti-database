<?php
   $file = ("conta.txt");
   $visite = file($file);
   $ciao=$visite[0]+1;
   $fp = fopen($file , "w");
   file_put_contents($file, $ciao); // solo PHP 5!!!
   fclose($fp);

   echo "Hai effetuato  $ciao visite a questo sito.";
?>
