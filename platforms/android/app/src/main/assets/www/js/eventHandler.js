/**************************************************
* This javascript file handles all event handlers *
* for the program                                 * 
**************************************************/


function showModal(){
    document.getElementById('toDoModal').style.display='block';
}

function closeModal(){
    document.getElementById('toDoModal').style.display='none';
}

function onBackKeyDown(event){
    if(document.getElementById('toDoModal').style.display="block"){
            document.getElementById('toDoModal').style.display="none";          
    }
}

function loadXMLTable(){
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            if(document.getElementById('submitButton'))
            displayXMLTable(this);
            
        }
    };
    xmlhttp.open("GET", "xml/toDoList.xml", true);
    xmlhttp.send();
}

function displayXMLTable(xml){
    var i;
    var xmlDoc = xml.responseXML;
    var table="<tr><th>Item</th><th>Destination</th></tr>";
    var x = xmlDoc.getElementsByTagName("todo");
    for (i = 0; i <x.length; i++) { 
        table += "<tr><td>" +
        x[i].getElementsByTagName("item")[0].childNodes[0].nodeValue +
        "</td><td>" +
        x[i].getElementsByTagName("dest")[0].childNodes[0].nodeValue +
        "</td><td>" +
        "<span id=i onclick='removeXMLDocItem()' class='close'>&times;</span>" +
        "</td></tr>"; 
    }
    document.getElementById("printTable").innerHTML = table;
}
/*
function addToXML(){
    var item = document.getElementById('item').value;
    var dest = document.getElementById('dest').value;

   // alert("item entered: " + item +
    //      "Destination: " + dest);
/*
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
           new function(this){
                var xmlDoc = this.xmlResponseXML;

                var newItemElement = xmlDoc.createElement('todo');

                newItemElement.appendChild(xmlDoc.createElement('item', item));
                newItemElement.appendChild(xmlDoc.createElement('dest', dest));

                var x = xmlDoc.getElementsByTagName('list')[0];

                x.appendChild(newItemElement);

                displayXMLTable(this);
            };
        }
    };
    xmlhttp.open("GET", "xml/toDoList.xml", true);
    xmlhttp.send();

}
*/
function callGoogle(){
    //https://maps.googleapis.com/maps/api/place/findplacefromtext/json?input=tires&inputtype=textquery&fields=formatted_address,name,open_now,rating&locationbias=circle:2000@42.3330,83.0465&key=AIzaSyD1BD2SIhcmvk7SmV1NGBrgaEQOLqjx4fI;
    
    let options = {maximumAge: 1000 * 60 * 60,
                   timeout: 20000, 
                   enableHighAccuracy: true};

    //if location is turned off, ask to turn it on, else run the call
    cordova.plugins.diagnostic.isGpsLocationEnabled(function(enabled){
        //GPS is on, find location
        //alert(enabled);
        if(enabled){
            navigator.geolocation.getCurrentPosition(onSuccess, onError, options);
        } else {
            requestGPS();
        }
    });
    //navigator.geolocation.getCurrentPosition(onSuccess, onError, options);
}


function onSuccess(position) {
    var lat = position.coords.latitude;
    var long = position.coords.longitude;
    var currentLoc = lat + "," + long; 
    var tempLocation = "1801 Michigan Ave, Detroit, MI 48216";
    var locName = 'Firestone Complete Auto Care';


    document.getElementById('printApiCall').innerHTML = "lat: " + lat + "\n long: " + long;

    if(currentLoc != ""){
        if(window.confirm("A location was found to handle one of your items! Would you like to go " +
            "there now? \n\nItem: Tires \nLocation found: " + locName)){
                window.open("geo:0,0?q=" + tempLocation + "(" + tempLocation + ")" + '_system');
        }
    }

    //window.open("geo:0,0?q=" + currentLoc + "(" + currentLoc + ")" + '_system');
    
    //window.open("geo:0,0?q=" + tempLocation + "(" + tempLocation + ")" + '_system');

    //Call up google and get an item based off of phone's current position at time oh hitting button.
    var HTTPREQ = "https://maps.googleapis.com/maps/api/geocode/xml?latlng=" + lat + "," + long +"&key=AIzaSyD1BD2SIhcmvk7SmV1NGBrgaEQOLqjx4fI"; 

    var URLREQ = "https://maps.googleapis.com/maps/api/place/findplacefromtext/json?input=tires&inputtype=textquery&fields=formatted_address,name,rating&locationbias=circle:2000@42.3330,83.0465&key=AIzaSyD1BD2SIhcmvk7SmV1NGBrgaEQOLqjx4fI";

    var LATLONG = lat + "," + long;
    var KEY = "AIzaSyD1BD2SIhcmvk7SmV1NGBrgaEQOLqjx4fI";
    $.ajax({
        url: "https://maps.googleapis.com/maps/api/place/findplacefromtext/json?input=tires&inputtype=textquery&fields=formatted_address,name,rating&locationbias=circle:2000@42.3330,83.0465&key=AIzaSyD1BD2SIhcmvk7SmV1NGBrgaEQOLqjx4fI",
        type: "GET",
        success: function(data){
            alert('data');
        }
    });

    notifyUser(currentLoc);

    //directions.navigateTo(lat,long);
        
    //.done(function(data){
    //    alert('data');
    //});
    //.error(function(error){
    //    alert("failed call");
    //});
    /*
    $.getJSON({
        url: "https://maps.googleapis.com/maps/api/place/findplacefromtext/json?input=tires&inputtype=textquery&fields=formatted_address,name,open_now,rating&locationbias=circle:2000@42.3330,83.0465&key=AIzaSyD1BD2SIhcmvk7SmV1NGBrgaEQOLqjx4fI",
        type: "GET"
    })
    .done(function(data){
        alert(data); //print the data out
    });
    */
    /*
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            getGoogleXML(this);
        }
    };
    xmlhttp.open("GET", HTTPREQ, true);
    xmlhttp.send();
*/
    //document.getElementById('printApiCall').innerHTML = returnJSON;
}

//For some reason my notifications don't work.
function notifyUser(currentLoc){
    let props = cordova.plugins.notification.local.getDefaults();

    let inThreeSec = new Date();
    inThreeSec.setSeconds(inThreeSec.getSeconds()+1);
    let id = new Date().getMilliseconds();

    let noteOptions = {
        id: id,
        title: 'Title test notification',
        text: "put the found location: " + currentLoc,
        at: inThreeSec,
        badge: 1,
        data: {
            prop: "prop value",
            num: 42
        }
    };

    if(prop.actions){
        noteOptions.actions = [{id: "yes", title: "Yes"}, {id: "no", title: "No"}];
    }

    cordova.plugins.notification.local.schedule(noteOptions);

    navigator.notification.alert("added notification id " + id);

    //This will be used when user hits no
    //cordova.plugins.notification.local.clear(id, function(){

    //});
}

function getGoogleXML(xml){
    var i;
    var xmlDoc = xml.responseXML;
    var x = xmlDoc.getElementsByTagName("result")[1];
    var y = x[1].getElementsByTagName("address_component")[0].childNodes[0].nodeValue
    document.getElementById('printApiCall').innerHTML = x;

}

function onError(error){
    alert('code: '  + error.code    + '\n' +
        'message: ' + error.message + '\n');
}

function requestGPS(){
    cordova.plugins.locationAccuracy.canRequest(function(canRequest){
        if(canRequest){
            cordova.plugins.locationAccuracy.request(function(success){
                console.log("Successfully requested accuracy: " + success.message);
            }, function(error){
                console.error("Accuracy request failed: error code: " + error.code + "; error message=" + error.message);
                if(error.code !== cordova.plugins.locationAccuracy.ERROR_USER_DISAGREED){
                    if(window.confirm("Failed to automatically set Location mode to 'High Accuracy'."+
                        " Would you like to switch to the Location Settings page and do it manually?")){
                            cordova.plugins.diagnostic.switchToLocationSettings();
                    }
                }
            }, cordova.plugins.locationAccuracy.REQUEST_PRIORITY_HIGH_ACCURACY);
        } else {
            //If you can't make a location request, get permission and ask again.
            app.geoPerm;
        }
    });
}