function getVote(myElement){

	// count voteing up
	// chance icon to glow normal
	// send ajax request
	
	// need span and img object

}

function validateNewBuild(){

	var kurzbeschreibung = document.getElementsByName("createTitel")[0];
	var beschreibung = document.getElementsByName("createLink")[0];
	var link = document.getElementsByName("createBeschreibung")[0];
	var errorDiv = document.getElementById("jsInfoBox");
	var errormessange = ""; 
	var error = 0; 
	
    if (kurzbeschreibung.value == null || kurzbeschreibung.value == "") {
        errormessange += "Kurzbeschreibung darf nicht leer sein!  <br/>";
        addClass("errorVal", kurzbeschreibung);
        error = 1; 
    } else {
    	removeClass("errorVal", kurzbeschreibung);
    }
    
    if (beschreibung.value == null || beschreibung.value == "") {
        errormessange += "Beschreibung darf nicht leer sein! <br/>";
        addClass("errorVal", beschreibung);
        error = 1; 
    } else {
    	removeClass("errorVal", beschreibung);
    }
    
    if (link.value == null || link.value == "") {
        errormessange += "Linkangabe darf nicht leer sein! <br/>";
        addClass("errorVal", link);
        error = 1; 
    } else {
    	removeClass("errorVal", link);
    }
    
    if (errormessange != "") {
    	errorDiv.innerHTML = errormessange; 
    	errorDiv.style.display = "block"; 
	} else {
		errorDiv.style.display = "none"; 
	}    
	
	var infoBox = document.getElementById("infoBox");
	if (infoBox != null) {
		infoBox.style.display = "none";
	}
	
	if (error == 1) {
		return false;
	}
    
}

function addClass( classname, element ) {
    var cn = element.className;
    //test for existance
    if( cn.indexOf( classname ) != -1 ) {
    	return;
    }
    //add a space if the element already has class
    if( cn != '' ) {
    	classname = ' '+classname;
    }
    element.className = cn+classname;
}

function removeClass( classname, element ) {
    var cn = element.className;
    var rxp = new RegExp( "\\s?\\b"+classname+"\\b", "g" );
    cn = cn.replace( rxp, '' );
    element.className = cn;
}