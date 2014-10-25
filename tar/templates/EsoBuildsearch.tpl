{include file='documentHeader'}
    <head>
        <title>Buildsearch - {lang}{PAGE_TITLE}{/lang}</title>
        {include file='headInclude' sandbox=false}
		<link rel="stylesheet" type="text/css" media="screen" href="wcf/style/EsoBuildsearch.css">
		<script type="text/javascript">
		function toggle(control){
			var elem = document.getElementById(control);
			if(elem.style.display == "none"){
				elem.style.display = "block";
			}else{
				elem.style.display = "none";
			}
		}
		</script>
    </head>
    <body>
		{include file='header' sandbox=false}
        <div id="main">
         <div>
          <div>
            <div class="mainHeadline">
                <div class="headlineContainer">
                    <h2>{$siteName}</h2>
                    <p>{$siteBeschreibung}</p>
                </div>
            </div>
            
            {if $userMessages|isset}{@$userMessages}{/if}
            
			<div id="myMain">
				{@$myChance}
				<div id="actions">
					<div class="floatleft">
						<!-- <a class="button" href="javascript:toggle('createBuild')">Neues Build erstellen</a> -->
						<a class="button" data-toggle="collapse" data-parent="#forms" href="#createBuild_">Neues Build erstellen</a>
		
					</div>
					
					<div class="floatleft">
						<button class="button btn btn-primary btn-lg" data-toggle="modal" data-target="#myModal" style="margin-left: 250px">
							Hilfe und Informationen
						</button>
						
						<!-- Modal -->
						<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
						  <div class="modal-dialog">
							<div class="modal-content">
							  <div class="modal-header">
								<button type="button" class="floatright close" data-dismiss="modal" aria-hidden="true">&times;</button>
								<h2 class="modal-title" id="myModalLabel">Hilfe und Informationen zu der ESO Buildsuche</h2>
							  </div>
							  <div class="modal-body">
								<h3>Was ist das?</h4>
								<p>
								Herzlich willkommen zur Buildsuche von Abaddons Mund!<br/>
								Dieses Programm ist dazu gedacht, Builds zentral zu sammeln. Benutzer können ihre Builds erstellen, sich von andere Inspirationen holen, 
								Tips und Tricks in Kommentaren weitergeben oder einfach stöbern; welche Builds sind auf unserem Server besonders beliebt. <br/> 
								Dieses Tool ist <b>nicht</b> dazu gedacht, ein eigenständiger Buildeditor zu werden. Hier soll jeweils lediglich ein Link auf entsprechende Editoren-Seiten eingebunden werden.
								(Zum Beispiel von de.gw2skills.net)
								</p>
								
								<h3>Work in progress</h4>
								<p>
								Bestimmt schon ein verhasster Satz unter Gw2 Spielern. 
								Hier einzelne 2Do's: <br/>
								</p>
								
								<h4>Kommentare und Bewertungen</h4>
								<p>
								Wie Dir bestimmt schon aufgefallen ist, gibt es eine Spalte mir Bewertungspunkten. Momentan ist eine fixe Zahl eingetragen - lass Dich nicht verwirren. 
								Die restliche Mechanik wurde bereits realisiert. Zusammen mit dem Feature der Kommentare, soll das dynamische Berechnen demnächst implementiert werden. 
								Jedem Benutzer soll es ermöglicht werden, einen Kommentar (bzw. Bewertung) für einzelne Builds zu verfassen. 
								Ab einer gewissen Anzahl negativer Kommentare, wird ein Build automatisch aus der Datenbank entfernt. Dies soll die Moderation entlasten. <br/>
								Anderst als bei den Builds wird eine Überarbeitung des Kommentars ausgeschlossen sein. 
								Ob und von wem Kommentare gelöscht werden können, ist noch offen. 
								Zusammen mit diesen Extras wird auch die Sortierung der Buildauflistung überarbeitet. 
								</p>
								
								<h4>Anzahl Klicks</h4>
								<p>
								Es soll ersichtlich sein, wie oft ein Build schon angeklickt wurde. Entsprechend soll das Ranking angepasst werden. Das Grundgerüst für diese Funktion wurde schon erstellt - jedoch wieder ausgeblendet. 
								Momentan ist es nicht möglich, einen Counter hoch zu zählen, ohne dass im Hintergrund die Seite nochmals neu geladen wird. 
								Aufgrund der Einbuse dieses (teils sehr grossen) Ärgernisses, wurde dies momentan auf Eis gelegt. 
								</p>
								
								<h4>JavaScript</h4>
								<p>
								Momentan wird nur eine serverseitige Valedierung verwendet. Eine clientseitige soll jedoch demnächst folgen. 
								Aufgrund der beiden Kombinationen kann es möglich sein, dass sich Fehler einschleichen (oder bereits in der serverseitigen Valedierung eingeschlichen haben.)
								Falls es eine Buildkonstelation gibt, welche möglich sein sollte; jedoch vom Programm verweigert wird - oder das Programm eine Waffenwahl zulässt, 
								die eigentlich nicht möglich sein sollte, so meldet dies bitte möglichst rekonstruierbar. 
								<br/>
								Zusätzlich sollen Infoboxen implementiert werden. (Vorallem für die Waffensetz wird es einen Rollover geben, wodurch die Darstellung benutzerfreundlicher gestaltet werden soll. 
								Teils sind die Icons wirklich etwas klein; momentan ist ein kleinflächiger "Standart-Rollover" eingebunden.) 
								</p>
								
								<h4>Teilen</h4>
								<p>
								Damit Du Builds Freunden weiterempfehlen  oder in einem Forumpost verlinken kannst, soll es eine Funktion geben, die durch einen Klick einen generierten Link in deine Zwischenablage legt. 
								Wird dieser aufgerufen, wird automatisch das entsprechende Build geöffnet und fokusiert. 
								</p>
								
								<h3>Kontakt</h4>
								<p>
								Da dieses Tool für <i>Euch</i> entwickelt wurde, wäre es schön, ihr tut eurer Meinung kund im entsprechendem Therad. Hier der Link: <a href="http://www.abaddons-mund.eu/index.php?page=Thread&threadID=319">BETA BuildSearch-Tool</a><br/>
								Das momentane Plugin soll auf eure Bedürfnisse zugeschnitten sein - so, dass es <i>wirklich brauchbar</i> ist. 
								Es wäre schade, man würde das Tool nicht verwenden, nur weil es den Ansprüchen nicht gerecht wird. <br/>
								Gerne kann man mich auch direkt im Spiel erreichen; <b>Merlin.6750</b>. <br/><br/>
								Ich freue mich auf Deine Anregungen!<br/>
								Gruss, Marcel
								</p>
								
							  </div>
							  <div class="modal-footer">
								<button type="button" class="button btn btn-default" data-dismiss="modal">Schliessen</button>
							  </div>
							</div><!-- /.modal-content -->
						  </div><!-- /.modal-dialog -->
						</div><!-- /.modal -->
					</div>
					
					<div class="floatright">
						<!-- <a class="button" href="javascript:toggle('editBuild')">Meine Builds verwalten</a> -->
						<a class="button" data-toggle="collapse" data-parent="#forms" href="#editBuild_">Meine Builds verwalten</a>
					</div>
				</div>
				
				<div id="createBuild_" class="collapse">
					<div id="createBuild" class="clear">
					<!-- <div id="createBuild" class="clear" style="display: none;">  -->
						{@$createBuild}
					</div>
				</div>
				
				<div id="editBuild_" class="collapse">
					<div id="editBuild" class="clear">
					<!-- <div id="editBuild" class="clear" style="display: none;"> -->
						{@$editBuild}
					</div>
				</div>
				
				<div id="filter" class="clear">
					{@$filter}
				</div>
				
				<div id="gefundeneHeader">
					<div class="beschreibung floatleft">Beschreibung</div>
					<div class="spielbereich floatleft">Spielbereich</div>
					<div class="buildauslegung floatleft">Buildauslegung</div>
					<div class="klasse floatleft">Klasse</div>
					<div class="haupthand floatleft">Hauptwaffensatz</div>
					<div class="begleithand floatleft">Nebenwaffensatz</div>
					<div class="bewertung floatleft">Bewertung</div>
				</div>
				
				<div class="datensatz clear">
					{@$datensatz}
				</div>
			</div>
		   </div>
		 </div>
        </div>
		{include file='footer' sandbox=false}
		<script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
		<script src="wcf/bs/bootstrap.js" type="text/javascript"></script>
    </body>
</html>