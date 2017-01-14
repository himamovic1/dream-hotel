function liveQuery(searchBox, live) {
	var queryString = searchBox.value;

	// Ako je string validan pocinjemo pretragu
	if(validateQuery(queryString) && queryString.length > 0) {
		max = '&max=0';
		if(live) max = '&max=2';

		// AJAX request za pretragu na serveru
		httpRequest = null;
		if(window.XMLHttpRequest)
			httpRequest = new XMLHttpRequest();
		else
			httpRequest = new ActiveXObject("Microsoft.XMLHTTP");

		httpRequest.onreadystatechange = function() {
			if(this.readyState == 4 && this.status == 200)
				document.getElementById('livePreview').innerHTML = this.responseText;
		}

		httpRequest.open('GET', 'searchEngine.php?query=' + queryString + max, true);
		httpRequest.send();
	}
	else document.getElementById('livePreview').innerHTML = "";

	return false;
}

function staticQuery() {
	liveQuery(document.getElementById('searchbox'), false);
	document.getElementById('livePreview').focus();
	return false;
}

function enterQuery() {
	if(event.keyCode == 13) staticQuery();
	return false;
}

function validateQuery(query) {
	var pattern = /^[a-zA-Z0-9\.\/-_*]+[a-zA-Z0-9\.\/-_*\s]*$/;
	return pattern.test(query);
}