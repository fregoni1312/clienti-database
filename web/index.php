<?php
   $file = ("conta.txt");
   $visite = file($file);
   $visite[0]++;
   //$fp = fopen($file , "w");
   fputs($file , "$visite[0]");
   fclose($fp);
   $ciao=20;
   $ciao++;
echo $ciao;
   echo "    Hai effetuato  $visite[0] visite a questo sito.";
?>
