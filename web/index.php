<!DOCTYPE html>
<html lang="en">
<head>
<title>Gestione clienti</title>
<link rel="stylesheet" type="text/css" href="style2.css">
</head>
<script>
	function passa_a(valore)
	{
		document.getElementById("stato").value=valore;
		document.getElementById("forma").submit();
	}
	function mettocusore()
	{
		document.getElementById("password1").focus();
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
	function modifica(caso,u,p)
	{
		document.getElementById("nome").value=u;
		document.getElementById("pass").value=p;
		passa_a(caso);
		
	}
</script>
<?
	echo('<body onload="mettocusore();">');
	if(isset($_POST["stato"])&&!empty($_POST["stato"]))
		$stato=$_POST["stato"];
	else
		$stato=0;
	if(isset($_POST["nome"])&&!empty($_POST["nome"]))
		$nome=$_POST["nome"];
	if(isset($_POST["pass"])&&!empty($_POST["pass"]))
		$pass=$_POST["pass"];
	echo("<form name='forma' id='forma' method='post'>");
	echo("<input type='hidden' name='stato' id='stato'>");	
	echo("<input type='hidden' name='nome' id='nome'>");
	echo("<input type='hidden' name='pass' id='pass'>");
	switch($stato)
	{
		//0 e 1 casi per la gestione del login
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
			
				break;
		case 1: MySQL_connect("127.0.0.1","root","") or die("Non riesco a connettermi a MySql");
				MySQL_select_db("utenti") or die("Non trovo il Database [utenti]");
				$query="SELECT * FROM dati ORDER BY username;";
				$recordset=MySQL_Query($query) or die ("La query [".$query."] non funziona!");
				$campo1 = $_POST['username'];
				$campo2 = $_POST['password'];	
				$continua=true;
				while($riga=MySQL_fetch_array($recordset))
				{
					if($riga[0]==$campo1 && $riga[1]==$campo2)
					{	if($riga[2]=='A')
						{
							echo ("<script type='text/javascript'>alert('Bentornato/a $campo1, eccoti alla pagina di amministratore!!!');</script>");
							echo "<script type='text/javascript'>passa_a(3);</script>";
						}
						else 
							echo "<script type='text/javascript'>passa_a(2);</script>";
						$continua=false;
					}
				}
				if(!$continua)
				{	
					echo "<script type='text/javascript'>passa_a(0);</script>";
					echo "<script type='text/javascript'>alert('Utente o password errati');</script>";
				}
				echo("<input type='button' value='Esci dal tuo profilo' onclick='passa_a(0);'><br/>");
				break;
		//Pagina visualizzata dagli utenti senza permesso da amministraore 
		case 2:	echo('<div class="header_2">
				  <h1>MENU</h1>
				</div>
				<div class="topnav">
				  <a onclick="passa_a(0);">Esci dal tuo profilo</a>
				</div>');
				break;
		        break;
		//Pagina visualizza dagli utenti con permesso da amministratore
		case 3:	echo('<div class="header_2">
				  <h1>MENU</h1>
				</div>
				<div class="topnav">
				  <a onclick="passa_a(4);">Elenco utenti</a>
				  <a onclick="passa_a(5);">Nuovo utente</a>
				  <a onclick="passa_a(0);">Esci dal tuo profilo</a>
				</div>');
				break;
		//Form per l'elencazione degli utenti del database
		case 4:	echo('<div class="header_2">
				  <h1>ELENCO UTENTI</h1>
				</div>
				<div class="topnav">
				  <a onclick="passa_a(5);">Nuovo utente</a>
				  <a onclick="passa_a(0);">Esci dal tuo profilo</a>
				</div>');
				MySQL_connect("127.0.0.1","root","") or die("Non riesco a connettermi a MySql");
				MySQL_select_db("utenti") or die("Non trovo il Database [utenti]");
				$query="SELECT * FROM dati ORDER BY username;";
				$recordset=MySQL_Query($query) or die("La query [".$query."] non funziona!");
				$numero=0;			
				
				echo('<table id="customers" align="center">
						  <tr>
							<th>Username</th>
							<th>Password</th>
							<th>Permesso</th>
							<th>Modifica/Cancella</th>
						  </tr>');
				while($riga=MySQL_fetch_array($recordset))
				{
					if($riga["A"])
						$tipo="A";
					echo("<tr>");
						echo("<td>");
							echo $riga["username"]; $nome=$riga["username"];
						echo("</td>");
						echo("<td>");
							echo $riga["password"]; $pass=$riga["password"];
						echo("</td>");
						echo("<td>");
							echo $riga["permesso"];
						echo("</td>");
						echo("<td>");
							echo("<input type='button' value='Seleziona' onclick='modifica(7,\"$nome\",\"$pass\");'>");
						echo("</td>");
					echo("</tr>");
				}
				echo("</table>");				
				break;
		//5 e 6 casi per la creazione di un nuovo utente nel database		
		case 5:echo('<div class="header_2">
				  <h1>CREAZIONE NUOVO UTENTE</h1>
				</div>
				<div class="topnav">
				  <a onclick="passa_a(4);">Elenco utenti</a>
				  <a onclick="passa_a(0);">Esci dal tuo profilo</a>
				</div>');
				echo("Inserire username:");
				echo('<input type = "text" class = "addmod" name = "username_nuovo" placeholder = "Username" required autofocus></br>');
				echo("Inserire la password: ");
				echo('<input type = "password" name = "password_nuovo"  id = "password1" placeholder = "Password" >');
				echo('<input type = "password" name = "ripeti_password" id = "password2" placeholder = "Ripeti Password" >');
				echo("<br/>Selezionare se sei amministratore: ");
				echo('<input type="checkbox" name="amministratore" value="A"/><br/>');
				echo("<input type='button' value='Inserisci Utente' onclick='confronto();'><br/>");
				break;
		case 6:	MySQL_connect("127.0.0.1","root","") or die("Non riesco a connettermi a MySql");
				MySQL_select_db("utenti") or die("Non trovo il Database [utenti]");
				$campo1 = $_POST['username_nuovo'];
				$campo2 = $_POST['password_nuovo'];
				$campo3 = $_POST['amministratore'];	
				if($campo3!='A')
					$campo3='U';
				$query=("INSERT INTO dati(username, password,permesso) VALUES('$campo1','$campo2','$campo3')"); 
				$recordset=MySQL_Query($query) or die("La query [".$query."] non funziona!");
				echo ("<script type='text/javascript'>alert('Utente creato');</script>");
				echo "<script type='text/javascript'>passa_a(5);</script>";
				break;
		//Il caso 7 apre la pagina dove e' possibile modificare o eliminareun utente dal database
		case 7:
				echo('<div class="header_2">
				  <h1>MODIFICA CREDENZIALI '.$nome.'</h1>
				</div>
				<div class="topnav">
				  <a onclick="passa_a(4);">Elenco utenti</a>
				  <a onclick="passa_a(5);">Nuovo Utente</a>
				  <a onclick="passa_a(0);">Esci dal tuo profilo</a>
				</div>');
				echo('Username: '.$nome.'</br>');
				echo("Modifica la password: ");
				echo("<input class='addmod' type = 'text'  name = 'password_nuovo'  id = 'password1' placeholder='".$pass."' >");
				echo("<br/>Selezionare se sei amministratore: ");
				echo('<input type="checkbox" name="amministratore" value="A"/><br/>');
				echo("<input type='button' value='Modifica' onclick='modifica(9,\"$nome\",\"$pass\");'><br/>");
				echo("<input type='button' value='Elimina' onclick='modifica(8,\"$nome\",\"$pass\");'><br/>");
				echo("<input type='button' value='Annulla' onclick='passa_a(4);'><br/>");
				break;
		//Il caso 8 ha la funzione di cancellazione un utente dal database
		case 8:	
				$campo1 = $_POST['nome'];
				MySQL_connect("127.0.0.1","root","") or die("Non riesco a connettermi a MySql");
				MySQL_select_db("utenti") or die("Non trovo il Database [utenti]");
				$query="DELETE FROM dati WHERE username='$campo1'"; 
				$recordset=mysql_query($query);
				echo "<script type='text/javascript'>passa_a(4);</script>";	
		//Il caso 9 ha la funzione di modificare le credenziali di un utente nel database
		case 9:
				$campo1 = $_POST['nome'];
				$campo2 = $_POST['password_nuovo'];				
				if($campo2=="")
					$campo2 = $_POST['pass'];			
				$campo3 = $_POST['amministratore'];
				if($campo3!='A')
						$campo3='U';
				MySQL_connect("127.0.0.1","root","") or die("Non riesco a connettermi a MySql");
				MySQL_select_db("utenti") or die("Non trovo il Database [utenti]");
				$query="UPDATE dati SET password='$campo2', permesso='$campo3' WHERE username='$campo1' LIMIT 1"; 
				$recordset=mysql_query($query);
				echo "<script type='text/javascript'>passa_a(4);</script>";
				$campo2=" ";
				break;
	}
	echo("</form>");
	echo('</body>');
?>
</html>