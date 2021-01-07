# Jaar 1 Periode 1

# E-Labs

Dit project maakt gebruik van bootstrap en fontawesome.

## Installatie database:

Maak een database aan genaamd 'E-Labs' en upload de sql die in de root folder staat. Om een connectie met de database te maken moet in example.env.php gedupliceerd worden en .env.php als naam krijgen. Vul vervolgens de inlog gegevens voor de database in bij het .env.php bestand dit zorgt er voor dat deze gegevens anoniem blijven.

Importeer het e-labs.sql bestand om de database structuur en tabellen te krijgen.

## Installatie localhost:

Om de site onder localhost te installeren moet de rootmap van E-labs "E-labs" in het htdocs mapje van Xampp worden gekopieerd. Vervolgens moeten zowel Apache als MySQL in Xampp gestart zijn en kan er naar localhost/e-labs/ worden genavigeerd. Hier kan er ingelogd worden met inloggegevens die in de database voorkomen. De wachtwoorden zijn versleuteld, en worden door de projectgoep verstrekt. 

## Installatie server:

Voor de installatie op een server maken we gebruik van FileZilla. Maak verbinding met de webserver d.m.v. de inloggegevens die door de hosting partij zijn verstrekt. Vervolgens navigeer naar public>htdocs in het rechter paneel van FileZilla. Plaats hier de root folder van E-labs "E-labs" in de Htdocs folder. Het is belangrijk dat de native mysql includes aan staan(de features die ook bij xampp aan gezet worden)

Vervolgens kan er naar de url genavigeerd worden (De url is of een lokaal ip adres, of een domeinadres) hier kan ingelogd worden met inloggegevens die door de projectgroep zijn verstrekt. 



## Live demo:

http://e-labs.serverict.nl <br>
\*Heeft geen mailserver actief
