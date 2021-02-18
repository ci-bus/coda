function llamada_ajax(url, callback) {
    var xmlHttp;
    try {
        xmlHttp = new XMLHttpRequest(); // Firefox, Opera 8.0+, Safari
    } catch (e) {
        try {
            xmlHttp = new ActiveXObject("Msxml2.XMLHTTP"); // Internet Explorer
        } catch (e) {
            try {
                xmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
            } catch (e) {
                alert("Tu explorador no soporta AJAX.");
                return false;
            }
        }
    }
    var timestamp = parseInt(new Date().getTime().toString().substring(0, 10));
    var nocacheurl = url + "&t=" + timestamp;
    xmlHttp.onreadystatechange = function () {
        if (xmlHttp.readyState == 4 && xmlHttp.readyState != null) {
            callback(xmlHttp.responseText);
            /*
            document.getElementById(divid).innerHTML = xmlHttp.responseText;
            setTimeout('refreshdiv()', seconds * 1000);
            */
        }
    }
    xmlHttp.open("GET", nocacheurl, true);
    xmlHttp.send(null);
}