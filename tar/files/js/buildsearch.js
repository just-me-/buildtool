function likeBuild(myElement, id){

	var user_do_alrdy_like = $("input[name*='userlikethis_"+id+"']").val();
	var likes = $("input[name*='userlikes_"+id+"']").val();
	
	var hidden_likes = 0; 
	var user_like_this = 0; 
	var newText = ""; 
	
	// chance icon to glow / normal
	// count up or down
	if(user_do_alrdy_like == 1){
		$("#v_img_"+id).attr("src","wcf/icon/Veteran.png");
		v_counter_1
		v_img_1
		// count down
		likes--; 
		hidden_likes=likes; 
		if(likes < 1){
			likes = ""; 
		}
		newText = "Du magst diesen Beitrag nicht mehr.";
		
	} else {
		user_like_this = 1; 
		$("#v_img_"+id).attr("src","wcf/icon/Veteran_glow.png");
		// count up
		likes++; 
		hidden_likes=likes; 
		newText = "Du magst diesen Beitrag!";
	}
	$("#v_img_"+id).attr("title", newText);
	$("#v_counter_"+id).text(likes);
	$("input[name*='userlikethis_"+id+"']").val(user_like_this)
	$("input[name*='userlikes_"+id+"']").val(hidden_likes)
	
	// send ajax request
	$.ajax({
		type: "GET",
		url: "/index.php/EsoBuildsearch/",
		data: {ajax: 1, build: id, user_like_this: user_like_this},
		success: function(data) {
			// $("#ajax_div").html(data);
		},
		error: function(data) {
			// $("#ajax_div").html("fehler");
		}
	});

}

function icon_out(element, id){
	var user_do_alrdy_like = $("input[name*='userlikethis_"+id+"']").val();
	var icon = "wcf/icon/Veteran.png"; 
	if(user_do_alrdy_like == 1) {
		icon = "wcf/icon/Veteran_glow.png"; 
	}
	element.src = icon; 
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