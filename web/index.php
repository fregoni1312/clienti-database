<?php
   $file = ("conta.txt");
   $visite = file($file);
   $visite[0]++;
   $fp = fopen($file , "w");
   fputs($fp , "$visite[0]");
   fclose($fp);
   echo "Hai effetuato  $visite[0] visite a questo sito.";
?>
