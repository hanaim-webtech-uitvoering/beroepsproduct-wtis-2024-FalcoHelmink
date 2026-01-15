Beste Docent 
hierbij een aantal vaste gegevens 

mocht de signup pagina niet werken (ik ga er niet van uit maar het kan) deze gegevens gebruiken 
Username: FalcoH
Wachtwoord: 123

Personeels Account (deze kan niet aangemaakt worden per design.):
Username: FalcoChef
Wachtwoord: 123

op de pagina UpdateOrder.inc.php kan het zijn dat er geen orders worden getoont.
dit is omdat er op deze pagina allen orders worden getoont die vandaag zien aangevraagd. 
er wordt er hierbij vanuit gegaan dat niemand een dag van te voren een pizza besteld. 

al wilt u deze functie proberen Dient u deze code in de database in te voeren: 
UPDATE Pizza_Order
SET datetime = Cast(GETDATE()as smalldatetime);

mocht u denken dat er geen GitHub pushes zijn. deze pagina is gemaakt op de beroepsproduct-wtis-2024-FalcoHelmink repository en op de beroepsproduct-wtis-2024-falcohelmink webserver 