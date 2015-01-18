{include file='documentHeader'}
    <head>
        <title>Buildsearch - {lang}{PAGE_TITLE}{/lang}</title>
        {include file='headInclude' sandbox=false}
		<link rel="stylesheet" type="text/css" media="screen" href="wcf/style/EsoBuildsearch.css?v=1064">
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
                    <p>{@$siteBeschreibung}</p>
                </div>
            </div>
            
            {if $userMessages|isset}{@$userMessages}{/if}
            
			<div id="myMain">
				{@$myChance}
				<div id="jsInfoBox" class="fehlerBox" style="display: none;">Dummy Error</div>
				<div id="actions">
					<div class="floatleft">
						<!-- <a class="button" href="javascript:toggle('createBuild')">Neues Build erstellen</a> -->
						<a class="button" data-toggle="collapse" data-parent="#forms" href="#createBuild_">Neues Build erstellen</a>
		
					</div>
					
					<div class="floatleft">
						<button class="button btn btn-primary btn-lg ml250" data-toggle="modal" data-target="#myModal">
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
								Herzlich willkommen zur Buildsuche von Legendary!<br/>
								Dieses Programm ist dazu gedacht, Builds zentral zu sammeln. Benutzer können ihre Builds erstellen, sich von andere Inspirationen holen, 
								oder einfach stöbern; welche Builds sind in unserer Gilde besonders beliebt. <br/> 
								Dieses Tool ist <b>nicht</b> dazu gedacht, ein eigenständiger Buildeditor zu werden. Hier soll jeweils lediglich ein Link auf entsprechende Editoren-Seiten eingebunden werden.
								(Zum Beispiel von elderscrollsbote.de/planer/)
								</p>
								
								<h3>Work in progress</h4>
								<p>
								Hier einzelne 2Do's, welche teils schon halbwegs implementiert sind und andere, die erst auf der Planungsliste stehen: <br/>
								</p>
								
								<h4>Like-Funktion</h4>
								<p>
								Diese Funktion ist teils schon integriert. Es soll die Möglichkeit gegeben werden, über eine Like-Funktion (das Veteran-Icon)
								Builds positiv zu bewerten. Eine Kommentar und Bewertungsfunktion wird es in dem Sinne aber nicht geben. <br/>
								Dies soll über Ajax umgesetzt werden um das Benutzererlebnis zu optimieren. (Auch könnte das Filtermenü als Ajax-Schnittstelle umgeschrieben werden.)
								</p>
								
								<h4>CSS</h4>
								<p>
								Zur Zeit ist das Tool noch in Gw2 Farben gehalten. Das kommt davon, dass ich es ursprünglich damals für eine Gw2-Community grob erstellt hatte. <br/>
								Die zur Zeit etwas hellen Farben im Vergleich zum restlichen Forum sollen etwas besser angegliedert werden - ein angepasstes Design eben. 
								</p>
								
								<h4>Mehr Optionen</h4>
								<p>
								Zur Zeit sind Grundangaben möglich wie Klasse und Waffen. Je nach Feedback können weitere Kriterien wie "ist Vampir", Art der Rüstungsteile, Nahrung uns so weiter impelemtiert werden. <br/>
								Grundsätzlich können diese Informationen bereits in der Beschreibung weiter gegeben werden. Ausserdem sind sie auch im externen Buildplaner enthalten. Es bleibt abzuwiegen, 
								wie sinnvoll solche Erweiterungen wären wenn man den Gedanken beibehält, nicht als eigenständiges Tool auftreten zu wollen. 
								</p>
								
								<h4>Fork me</h4>
								<p>
								Die Lizenz soll später geändert werden, dass Forks erlaubt sind. Zuvor muss jedoch die Datenbank normalisiert werden und der Code grundlegend ausgemistet werden. <br/>
								Zur Zeit war es jedoch genug Aufwand, das Tool für die neue Software WBB4 bzw. das Framework WCF 2.0.x umzuschreiben, da das Gw2 Forum noch die alte Version hatte. 
								</p>
								
								<h4>Icons</h4>
								<p>
								Zum einen sollen die Icons erneuert werden und zum andern sollen die vielen Selects durch Icons teils abgelöst werden für mehr Benutzerfreundlichkeit. <br/>
								Zur Zeit sind die Logos auch noch von Gw2. Es gilt folgendes erklärt: <i>Ich habe keine Ansprüche oder andere Formen von Eigentum bezüglich der Inhalte von ArenaNet oder ZeniMax.</i>
								</p>
								
								<h4>Teilen</h4>
								<p>
								Damit Du Builds Freunden weiterempfehlen oder in einem Forumpost verlinken kannst, soll es eine Funktion geben, die durch einen Klick einen generierten Link in deine Zwischenablage legt. 
								Wird dieser aufgerufen, wird automatisch das entsprechende Build geöffnet und fokusiert. 
								</p>
								
								<h3>Kontakt</h3>
								<p>
								Da dieses Tool für <i>Euch</i> entwickelt wurde, wäre es schön, ihr tut eurer Meinung kund im entsprechendem Therad. Hier der Link: <a href="http://www.gilde-legendary.de/index.php/Thread/14906-BuildSearchTool/?postID=79273#post79220">BETA BuildSearch-Tool</a><br/>
								Das momentane Plugin soll auf eure Bedürfnisse zugeschnitten sein - so, dass es <i>wirklich brauchbar</i> ist. 
								Es wäre schade, man würde das Tool nicht verwenden, nur weil es den Ansprüchen nicht gerecht wird. <br/><br/>
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
					<div class="bewertung floatright">Bewertung</div>
				</div>
				
				<div class="datensatz clear">
					{@$datensatz}
				</div>
			</div>
		   </div>
		 </div>
        </div>
		{include file='footer' sandbox=false}
  		<script src="https://code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
		<script src="wcf/bs/bootstrap.js" type="text/javascript"></script>
		<script src="wcf/js/buildsearch.js" type="text/javascript"></script>
		<link rel="stylesheet" href="//code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css">
		<script>
			$( document ).tooltip({ position: { my: "left+15 center", at: "right center" } });
		</script>
    </body>
</html>