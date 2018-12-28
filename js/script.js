function getXMLHttpRequest() {
	var xhr = null;
	
	if (window.XMLHttpRequest || window.ActiveXObject) {
		if (window.ActiveXObject) {
			try {
				xhr = new ActiveXObject("Msxml2.XMLHTTP");
			} catch(e) {
				xhr = new ActiveXObject("Microsoft.XMLHTTP");
			}
		} else {
			xhr = new XMLHttpRequest(); 
		}
	} else {
		alert("Votre navigateur ne supporte pas l'objet XMLHTTPRequest...");
		return null;
	}
	
	return xhr;
}

function supprimer(rep){
	if(confirm('Etes-vous sûr de vouloir supprimer le fichier ')){
		var xhr = getXMLHttpRequest();
		xhr.onreadystatechange = function() {
			if (xhr.readyState == 4 && (xhr.status == 200 || xhr.status == 0)) {
				if(xhr.responseText=="erreur"){//detecte les erreurs 
					alert("erreur");
				}
			}
		};
		xhr.open("GET", "sup.php?rep="+rep,false);
		xhr.send(null);
	}
}

function baseName(str)
{
   var base = new String(str).substring(str.lastIndexOf('/') + 1); 
   return base;
}

function nouveauDossier(rep){
	var nom = prompt("Nouveau Dossier :","");
	var xhr = getXMLHttpRequest();
	xhr.onreadystatechange = function() {
		if (xhr.readyState == 4 && (xhr.status == 200 || xhr.status == 0)) {
			if(xhr.responseText=="erreur"){//detecte les erreurs 
				alert("le dossier n'a pas pu être créé");
			}
		}
	};	
	if(nom!=null){
		xhr.open("POST", "creerdossier.php?rep="+rep,false);
		xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		xhr.send("nom="+nom);
	}
	
}

function rename(rep){
	var nom = prompt("Nouveau nom pour "+ baseName(rep)+" :",baseName(rep));
	var xhr = getXMLHttpRequest();
	xhr.onreadystatechange = function() {
		if (xhr.readyState == 4 && (xhr.status == 200 || xhr.status == 0)) {
			if(xhr.responseText=="erreur"){//detecte les erreurs 
				alert("erreur! Le fichier existe peut-être déjà");
			}
		}
	};	
	if(nom!=null){
		xhr.open("POST", "rename.php?rep="+rep,false);
		xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		xhr.send("nom="+nom);
	}
}

function deplacer(rep,aDeplacer){
	window.open("deplacerVers.php?rep="+rep+"&aDeplacer="+aDeplacer,"deplacer vers","menubar=no,scrollbars=yes,width=450,height=300");
}

function deplacerVers(source,destination){
	var xhr = getXMLHttpRequest();
	xhr.onreadystatechange = function() {
		if (xhr.readyState == 4 && (xhr.status == 200 || xhr.status == 0)) {
			if(xhr.responseText=="erreur"){//detecte les erreurs 
				alert("erreur! Le fichier existe peut-être déjà");
			}
		}
	};	
	xhr.open("POST", "deplacer.php",false);
	xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	xhr.send("source="+source+"&destination="+destination);
	window.opener.location.reload();
	window.close();
}
