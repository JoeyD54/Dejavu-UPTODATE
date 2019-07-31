/*****************************
 * Project: Deja Vu          *
 *                           *
 * Developers: Joey Domnino  *
 *           Nidhi Ghorpade  *
 *                           *
 *                           *
 * This page handles the     *
 * Initialization of the app *
 *                           *
 *****************************/


let app = {
    permissions: null,
    init: function () {
        document.addEventListener('deviceready', app.ready, false);
        console.log('init');
    },
    ready: function () {
        //plugins ready
        app.permissions = cordova.plugins.permissions;
        console.log(app.permissions);
        
        //add button listeners
        console.log('adding listeners');
        //document.getElementById('doXMLWork').addEventListener('click', loadXMLTable);
        document.getElementById('insertButton').addEventListener('click', showModal);
        document.getElementById('callApi').addEventListener('click', callGoogle);
        document.addEventListener('backbutton', onBackKeyDown);
        document.getElementById('closeScreen').addEventListener('click', closeModal);
        document.getElementById('cancelButton').addEventListener('click', closeModal);
        //document.getElementById('submitButton').addEventListener('click', addToXML);
        document.addEventListener('deviceready', loadXMLTable);
        document.addEventListener('deviceready', app.geoPerm);
        document.addEventListener('deviceready', callGoogle);

        cordova.plugins.notification.local.on("click", function(notification){
            navigator.notification.alert('clicked: ' + notification.id);

        });
        cordova.plugins.notification.local.on("trigger", function(notification){
            navigator.notification.alert('triggered: ' + notification.id);            
        });
         
        cordova.plugins.diagnostic.isGpsLocationEnabled(function(enabled){
            //GPS is on, find location
            if(enabled){
                if(document.addEventListener('deviceready')){
                    let options = {maximumAge: 1000 * 60 * 60,
                        timeout: 20000, 
                        enableHighAccuracy: true};

                    navigator.geolocation.getCurrentPosition(onSuccess, onError, options);
                }
            } else {
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
                })
            }
        }, function(error){
            alert('the followin error occured: ' + error);
        });
    },
    geoPerm: function () {
        let perms = ["android.permission.ACCESS_COARSE_LOCATION",
            "android.permission.ACCESS_FINE_LOCATION",
            "android.permission.ACCESS_BACKGROUND_LOCATION"
        ]
        app.permissions.checkPermission("android.permission.ACCESS_COARSE_LOCATION", function (status) {
            console.log('success checking permission');
            console.log('HAS ACCESS_COURSE_LOCATION:', status.hasPermission);

            if (!status.hasPermission) {
                app.permissions.requestPermissions(perms, function (status) {
                    console.log('success requesting ACCESS_*_LOCATION permission');
                }, function (err) {
                    console.log('failed to set permission');
                });
            } else {
                //alert ('your coordinates:');
                //callGoogle();
            }
        }, function (err) {
            console.log(err);
        });
    }
}
app.init();