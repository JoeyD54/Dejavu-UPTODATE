/**************************************************
* This javascript file handles all calls to the   *
* local xml file                                  * 
**************************************************/

//function loadXMLTable(){
  //  document.getElementById('printHere').innerHTML = "success";
    /*
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function(){
        if(this.readyState == 4 && this.status == 200){
            displayXMLTable(this);
        }
    };
    xhttp.open("GET", "xml/toDoList.xml", true);
    xhttp.send();
}

function displayXMLTable(xml){
    var x, i, list, item, dest, xmlDoc;
    xmlDoc = xml.responseXML;
    item = "";
    dest = "";
    x = xmlDoc.getElementsByTagName('todo');
    for(i = 0; i < x.length; i++){

        item = x[i].getElementsByTagName('item')[0].childNodes[0].nodeValue;
        dest = x[i].getElementsByTagName('dest')[0].childNodes[0].nodeValue;

        /*
        list += "<li class = 'w3-bar'> <span id = 'removeItem'" +
            "class = 'w3-bar-item w3-button w3-white w3-large w3-right>X</span>" +
            "<div class='w3-bar-item'> " + 
                "<span class='w3-large'>" x[i].getElementsByTagName('item')[0].childNodes[0].nodeValue; "</span>" +
                "<"
            "</div";
            
    }
   document.getElementById('test').innerHTML = 'success';

}
*/