<!DOCTYPE html>
<html lang="en">
<head>
<title>Gestione clienti</title>
<link rel="stylesheet" type="text/css" href="style.css">
</head>
<script>
	function passa_a(valore)
	{
		document.getElementById("stato").value=valore;
		document.getElementById("forma").submit();
	}
	function mettocusore()
	{
		document.getElementById("password").select();
	}
	function confronto()
	{
		var first,second;
		first=document.getElementById("password1").value;
		second=document.getElementById("password2").value;
		if(first==""||second=="")
			alert("!!!Inserire le password per effettuare il controllo!!!")
		else 
			if (first==second)
			{
				passa_a(6);
			}
			else
			{
				alert("!!!La password non e' corretta!!!");
			}
	}	
	function controlla_parametri()
	{
		var first,second;
		first=document.getElementById("password1").value;
		second=document.getElementById("username").value;
		if(first==""||second=="")
			alert("!!!Inserire le credenziali!!!");
		else
			passa_a(1);	
	}
</script>
<?
	echo('<body onload="mettocusore();">');
	if(isset($_POST["stato"])&&!empty($_POST["stato"]))
		$stato=$_POST["stato"];
	else
		$stato=0;
	echo("<form name='forma' id='forma' method='post'>");
	echo("<input type='hidden' name='stato' id='stato'>");	

	//////////////
	function a_capo($primo,$appoggio)
	{
		if($primo)
			$primo=false;
		else
			fwrite($appoggio,"\n");
		return $primo;
	}
	/////////////
	switch($stato)
	{
		case 0: echo('
				<div class="body"></div>
				<div class="grad"></div>
				<div class="header">
					<div>Gestione<span>Clienti</span></div>
				</div>
				<br>
				<div class="login">
						<input type="text" placeholder="username" name="username" id = "username"><br>
						<input type="password" placeholder="password" name="password" id = "password1"><br>
						<input type="button" value="Login" onclick="controlla_parametri();">
				</div>');
				//echo("<script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>");		
				break;
		case 1: $campo1 = $_POST['username'];
				$campo2 = $_POST['password'];	
				if (($handle = fopen("utenti.csv", "r"))) 
				{
					while ($riga = fgetcsv($handle, 1000, ";")) 
					{	
						if($campo1==$riga[0] && $campo2==$riga[1] && !$continua)
						{	
							if($riga[2]=='A')
							{
								echo ("<script type='text/javascript'>alert('Bentornato/a $campo1, eccoti alla pagina di amministratore!!!');</script>");
								echo "<script type='text/javascript'>passa_a(3);</script>";
							}
							else 
								echo "<script type='text/javascript'>passa_a(2);</script>";
							$continua=true;
						}	
					}
				    fclose($handle);
					if(!$continua)
					{	
						echo ("<script type='text/javascript'>alert('Errore, username o password sbagliati');</script>");
						echo "<script type='text/javascript'>passa_a(0);</script>";
					}				
				}
				else
					echo "!!!0Errore del sistema, riprovare piu' tardi!!!";
				echo("<input type='button' value='Esci dal tuo profilo' onclick='passa_a(0);'><br/>");
				break;
		case 2:	echo('<div class="header_2">
				  <h1>MENU</h1>
				</div>
				<div class="topnav">
				  <a onclick="passa_a(0);">Esci dal tuo profilo</a>
				</div>');
				break;
		        break;
		case 3:	echo('<div class="header_2">
				  <h1>MENU</h1>
				</div>
				<div class="topnav">
				  <a onclick="passa_a(4);">Elenco utenti</a>
				  <a onclick="passa_a(5);">Nuovo utente</a>
				  <a onclick="passa_a(7);">Elimina Utente</a>
				  <a onclick="passa_a(9);">Modifica Utente</a>
				  <a onclick="passa_a(0);">Esci dal tuo profilo</a>
				</div>');
				break;
		case 4:	echo('<div class="header_2">
				  <h1>ELENCO UTENTI</h1>
				</div>
				<div class="topnav">
				  <a onclick="passa_a(5);">Nuovo utente</a>
				  <a onclick="passa_a(7);">Elimina Utente</a>
				  <a onclick="passa_a(9);">Modifica Utente</a>
				  <a onclick="passa_a(0);">Esci dal tuo profilo</a>
				</div>');
				//echo("ELENCO UTENTI<br/>");
				if (($handle = fopen("utenti.csv", "r"))) 
					{
						echo('<table id="customers" align="center">
						  <tr>
							<th>Username</th>
							<th>Password</th>
							<th>Permesso</th>
						  </tr>');
						while ($riga = fgetcsv($handle, 1000, ";")) 
						{	echo("<tr>");
							for($k=0;$k<count($riga);$k++)
								echo("<td>".$riga[$k]."</td>");
							echo("</tr>");	
						}
						echo("</table>");
						fclose($handle);
					}		
				else
					echo "non riesco ad aprire il file, mannaggia!";				
				break;
		case 5:echo('<div class="header_2">
				  <h1>CREAZIONE NUOVO UTENTE</h1>
				</div>
				<div class="topnav">
				  <a onclick="passa_a(4);">Elenco utenti</a>
				  <a onclick="passa_a(7);">Elimina Utente</a>
				  <a onclick="passa_a(9);">Modifica Utente</a>
				  <a onclick="passa_a(0);">Esci dal tuo profilo</a>
				</div>');
				echo("Inserire username:");
				echo('<input type = "text" class = "form-control" name = "username_nuovo" placeholder = "Username" required autofocus></br>');
				echo("Inserire la password: ");
				echo('<input type = "password" class = "form-control" name = "password_nuovo"  id = "password1" placeholder = "Password" required>');
				echo('<input type = "password" class = "form-control" name = "ripeti_password" id = "password2" placeholder = "Ripeti Password" required>');
				echo("<br/>Selezionare se sei amministratore: ");
				echo('<input type="checkbox" name="amministratore" value="A"/><br/>');
				echo("<input type='button' value='Inserisci Utente' onclick='confronto();'><br/>");
				break;
		case 6:	$campo1 = $_POST['username_nuovo'];
				$campo2 = $_POST['password_nuovo'];
				$campo3 = $_POST['amministratore'];
				$SALVA=1;
				if (($handle = fopen("utenti.csv", "r"))) 
				{
					while ($riga = fgetcsv($handle, 1000, ";")) 
					{	echo "$riga[0]-";
						if($riga[0]==$campo1)
						{
							echo ("<script type='text/javascript'>alert('Mi dispiace questo utente esiste gia, per favore inserire un altro username!!!');</script>");
							$SALVA=0;
						}
					}
				    fclose($handle);	
				}
				else
					echo ("<script type='text/javascript'>alert('!!!Errore del sistema, riprovare piu' tardi!!!');</script>");	
				
				if (($handle = fopen("utenti.csv", "a")) && $SALVA==1) 
				{	
					fwrite($handle,"\n");
					fwrite($handle,$campo1);
					fwrite($handle,";");
					fwrite($handle,$campo2);
					fwrite($handle,";");
					if($campo3!='A')
						$campo3='U';
					fwrite($handle,$campo3);
					fclose($handle);
					echo ("<script type='text/javascript'>alert('Utente creato');</script>");
				}		
				//else
					//echo ("<script type='text/javascript'>alert('!!!Errore, nome utente gia' utilizzato!!!');</script>");	
				echo "<script type='text/javascript'>passa_a(5);</script>";
				break;
			
		//Per cancellare utente;
		case 7:	echo('<div class="header_2">
				  <h1>ELIMINA UTENETE</h1>
				</div>
				<div class="topnav">
				  <a onclick="passa_a(4);">Elenco utenti</a>
				  <a onclick="passa_a(5);">Nuovo utente</a>
				  <a onclick="passa_a(9);">Modifica Utente</a>
				  <a onclick="passa_a(0);">Esci dal tuo profilo</a>
				</div>');
				echo("Eliminazione utente<br/>");
				echo("<input type='text' name='cancellare'>");	
				echo("<input type='button' value='Elimina' onclick='passa_a(8);'><br/>");
				break;
		case 8:	$primo=true;
				$cancellato=false;
				if (($handle = fopen("utenti.csv", "r"))) 
				{	
					$canc=$_POST['cancellare'];
					$appoggio = fopen("appoggio.csv", "w");
					while ($riga = fgetcsv($handle, 1000, ";")) 
					{
							$riga2=implode(";",$riga);
							if($riga[0]!=$canc)
							{	
								$primo=a_capo($primo,$appoggio);
								fwrite($appoggio,$riga2);	
							}
							else 
								$cancellato=true;
					}
					fclose($handle);
					fclose($appoggio);
					unlink('utenti.csv');
					rename('appoggio.csv','utenti.csv');	
				}		
				else
					echo "non riesco ad aprire il file, mannaggia!";
				if(!$cancellato)
					echo "<script type='text/javascript'>alert('!!!Non esiste nessun utente con quel username!!!');</script>";
				else 
					echo "<script type='text/javascript'>alert('Utente cancellato');</script>";
				echo "<script type='text/javascript'>passa_a(7);</script>";
				break;	
		//Per modificare credenziali
		case 9:echo('<div class="header_2">
				  <h1>MODIFICA CREDENZIALI UTENTE</h1>
				</div>
				<div class="topnav">
				  <a onclick="passa_a(4);">Elenco utenti</a>
				  <a onclick="passa_a(5);">Nuovo Utente</a>
				  <a onclick="passa_a(7);">Elimina Utente</a>
				  <a onclick="passa_a(0);">Esci dal tuo profilo</a>
				</div>');
				echo("Inserire username:");
				echo('<input type = "text" class = "form-control" name = "username_nuovo" placeholder = "Username" required autofocus></br>');
				echo("Inserire la password: ");
				echo('<input type = "password" class = "form-control" name = "password_nuovo"  id = "password1" placeholder = "Password" required>');
				echo("<br/>Selezionare se sei amministratore: ");
				echo('<input type="checkbox" name="amministratore" value="A"/><br/>');
				echo("<input type='button' value='Modifica' onclick='passa_a(10);'><br/>");
				break;
		case 10:$campo1 = $_POST['username_nuovo'];
				$campo2 = $_POST['password_nuovo'];
				$campo3 = $_POST['amministratore'];
				$modificato=false;
				$primo=true;
				if (($handle = fopen("utenti.csv", "r"))) 
				{	
					$appoggio = fopen("appoggio.csv", "w");
					while ($riga = fgetcsv($handle, 1000, ";")) 
					{
							$riga2=implode(";",$riga);
							if($riga[0]!=$campo1)
							{	
								$primo=a_capo($primo,$appoggio);
								fwrite($appoggio,$riga2);	
							}
							else 
							{	$modificato=true;
								$primo=a_capo($primo,$appoggio);
								fwrite($appoggio,$campo1);
								fwrite($appoggio,";");
								fwrite($appoggio,$campo2);
								fwrite($appoggio,";");
								if($campo3!='A')
									$campo3='U';
								fwrite($appoggio,$campo3);
							}
					}
					fclose($handle);
					fclose($appoggio);
					unlink('utenti.csv');
					rename('appoggio.csv','utenti.csv');	
				}		
				else
					echo "non riesco ad aprire il file, mannaggia!";
				if(!$modificato)
					echo "<script type='text/javascript'>alert('!!!Non esiste nessun utente con quel username!!!');</script>";
				else 
					echo "<script type='text/javascript'>alert('Utente modificato');</script>";
				echo "<script type='text/javascript'>passa_a(9);</script>";
				break;
			
	}
	echo("</form>");
	echo('</body>');
?>
</html>