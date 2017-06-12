<?php
session_start();
if(isset($_FILES['fichiercsv']))
{
	$uploadfile = "uploads/" . basename($_FILES['fichiercsv']['name']);
	if (move_uploaded_file($_FILES['fichiercsv']['tmp_name'], $uploadfile)) 
	{
			    echo "<div class='alert alert-success'><h4><i class='fa fa-check'></i> Le fichier est valide, et a été téléchargé avec succès.</h4></div>";
			    $_SESSION["uploadedFile"]=$uploadfile;
	} 
	else 
	{
			    echo "Erreur";
	}
			
			
}

