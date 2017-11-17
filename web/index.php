<?php
$archivo = "conta.txt"; // Archivo il numero di visitatori
if(file_exists($archivo)){
$conta = file_get_contents($archivo);
$cook = $_COOKIE[‘cooki’]; // leggiamo il cookie
if (!$cook)$contador ++; // // se non esiste il cookie incremento i visitatori

}else{
// Creo archivio contatore. Será con la 1ª visita
touch($archivo);
chmod($archivo, 0755);
$conta= 1; // Valor por defecto si no existe fichero de visitas
}

// Grabamos cookie de 1 hora de duracion
setcookie("cook",1, time() + 3600);

// Grabamos contador
file_put_contents($archivo, $conta); // solo PHP 5!!!
echo "Hai effettuauo l'accesso a questa pagina $conta volte."
?> 
