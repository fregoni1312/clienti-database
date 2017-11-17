<?php
   $file = ("conta.txt");
   $visite = file($file);
   $visite[0]++;
   $fp = fopen($file , "w");
   fputs($fp , "$visite[0]");
   fclose($fp);
   echo $visite[0];
?>
