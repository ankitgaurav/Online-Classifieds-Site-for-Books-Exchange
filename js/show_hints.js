function showHint(str) {
    if (str.length == 0) { 
        document.getElementById("inner").innerHTML = "";
        document.getElementById("hints").style.display = "none";
        return;
    }
    else {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                document.getElementById("hints").style.display = "block";
                document.getElementById("hints").innerHTML = xmlhttp.responseText;
            }
        }
        xmlhttp.open("GET", "quicksearch.php?search_text=" + str, true);
        xmlhttp.send();
    }
}
