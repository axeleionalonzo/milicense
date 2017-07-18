(function() {

// Initialize Firebase
var config = {
	apiKey: "AIzaSyBuN0-VcY1ZyCxJWmW2er0hWFfCrc5kHOc",
	authDomain: "geo-license.firebaseapp.com",
	databaseURL: "https://geo-license.firebaseio.com",
   	storageBucket: "geo-license.appspot.com",
	messagingSenderId: "6432295404"
};
// Get a reference to the database service
firebase.initializeApp(config);

var app = angular.module('licenseApp', ['chieffancypants.loadingBar', 'firebase'], function($interpolateProvider) {
	$interpolateProvider.startSymbol('[[');
	$interpolateProvider.endSymbol(']]');
}).config(function(cfpLoadingBarProvider) {
	cfpLoadingBarProvider.includeSpinner = false; // toggle spinner
    cfpLoadingBarProvider.includeBar = true; // toggle loading bar
});

app.controller('loginController', function($scope, $http) {

	$scope.greet = "Hello!";
	$scope.welcome = ["Hola!","Indo!","Bonjour!","Ciao!","Ola!","Namaste!","Salaam!","Konnichiwa!","Merhaba!","Jambo!","Ni Hau!","Hallo!","Hello!"];
	$scope.greet = $scope.welcome[Math.floor(Math.random() * $scope.welcome.length)];
	$scope.errorCode = false;

	// get auth methods from database
	var auth = firebase.auth();

	// getting the elements
	var txtEmail = $("input#email");
	var txtPassword = $("input#password");
	var txtToken = $("input#token");
	var btnLogin = $("button#login");
	var card = $("div.card");
	var cardAction = card.find("div.card-action");

	// add login event
	btnLogin.click(function(e) {
	    // get email and pass
	    var email = txtEmail.val();
	    var pass = txtPassword.val();
	    var token = txtToken.val();

		// sign in
		auth.signInWithEmailAndPassword(email, pass).then(function() {
		  	// Sign-in successful.
		  	// Send token to your backend via HTTPS
		  	cardAction.fadeOut(1000);
			$http.post('./login', {
				"_token":			token,
				"email":			email,
				"password":			pass
			}).then(function successCallback(response) {
				$scope.greet = "Your account is being validated. Have a nice day! :)";
			  	window.location.replace('./license');
			}, function errorCallback(response) {
				console.log(response);
				$scope.errorCode = true;
				$scope.errorMessage = response;
		  		cardAction.fadeIn(1000);
				auth.signOut();
				// called asynchronously if an error occurs
				// or server returns response with an error status.
			});
		}, function(error) {
			// Handle Errors here.
			console.log(errorMessage);
			$scope.errorCode = error.code;
			$scope.errorMessage = error.message;
		});
	});

	// check for user state changes
	// auth.onAuthStateChanged(function(user) {
	//   if (user) {
	//     // User is signed in.
	//     console.log(user);
	//   } else {
	//     console.log("no user");
	//   }
	// });
});

app.controller('licenseController', function($scope, $interval, $http, $filter, $firebaseObject, $firebaseArray) {

	// download the data into a local object
	var ref = firebase.database().ref();

	// get auth methods from database
	var auth = firebase.auth();

	$scope.licenses = [];
	$scope.genData = [];
	$scope.act_date = "...";
	$scope.genData.status = 0;
	$scope.license = "";
	$scope.sortType = 'act_date'; // set the default sort type
	$scope.sortReverse = false; // set the default sort order
	$scope.searchLicense = ""; // set the default search/filter term
	$scope.placeholder = "I'm feeling lucky"; // set the default search/filter term
	$scope.licenses = $firebaseArray(ref.child("licenses")); // populate licenses from firebase

	var pholder = ref.child('greetings');

	pholder.on('value', snap => $scope.placeholder = snap.val()); // sync object changes using on()

	// controls the ticking time on adding a license
	var tick = function() {
		$scope.act_date = new Date();
	}

	var onModalHide = function() {
		$scope.licgenform.$setPristine();
		$scope.licgenform.$setUntouched();
	};

	// handler controllers
	$scope.handlers = function() {
	    $("#menu-toggle").click(function(e) {
	        e.preventDefault();
	        $("#wrapper").toggleClass("toggled");
	    });

		$("#close_instruction").click(function(e) {
	        e.preventDefault();
	        $(this).parent().parent().parent().fadeOut();
	    });

		$("#addLicenseModal").modal({
		    complete : onModalHide
		});

		$("#genLicenseModal").modal({
		    complete : onModalHide
		});

		$("a#logout").click(function(e) {
			auth.signOut();
	    });
		
		tick();
		$interval(tick, 1000);
	}

	// parse string and int with 000
	function pad(str, max) {

		str = str.toString();
		return str.length < max ? pad("0" + str, max) : str;
	}

	// adds license
	$scope.addLicense = function() {

		// gets js datetime ready for mysql datetime
		var act_date = $scope.act_date.toISOString().slice(0, 19).replace('T', ' ');
		var timestamp = new Date().valueOf(); // get id based time

		$("#addLicenseModal").modal("close");

		$scope.licenses.$add({
			"id":			timestamp,
			"act_code":		$scope.newLic.act_code,
			"organization":	$scope.newLic.organization,
			"status":		$scope.newLic.status,
			"device_code":	$scope.newLic.device_code = 0,
			"project":		$scope.newLic.project,
			"act_date":		act_date
	    }).then(function() {
			// adds the new license to the view
			$scope.newLic = ""; // clears the input fields
			$scope.newLic.status = 0;
			// reset errors on the input
			$scope.addlicform.$setPristine();
			$scope.addlicform.$setUntouched();
		}, function(error) {
			Materialize.toast("Something went wrong! " + error, 4000, 'red');
		});
	};

	// gets the license details ready for edit
	// makes the table row editabel
	$scope.getLicense = function(license) {

		// change the button to edit mode using angular filter array
		var id = license.$id;
		ref.child("licenses").child(id).update({"editing": 1});

		// var el = $('tr#'+ license.id);
		// el.find('input[data="canEdit"]').removeAttr('readonly');
	};

	// updates the editable license
	$scope.updateLicense = function(license) {

		var id = license.$id;
		// ref.child("licenses").child(id).update({"loading": 1});

		if (license.status == undefined) {
			console.debug("status: Must be a boolean value (0,1)");
			license.status = 0;
		}

		var licenseData = $scope.licenses.$getRecord(id);

		var postData = {
			"id":			licenseData.id,
			"act_code":		licenseData.act_code,
			"organization":	licenseData.organization,
			"status":		licenseData.status,
			"device_code":	licenseData.device_code,
			"project":		licenseData.project,
			"act_date":		licenseData.act_date
		};

		// Write the new post's data simultaneously in the posts list and the user's post list.
		var updates = {};
		updates['/licenses/' + id] = postData;

		ref.update(updates).then(function() {
		}, function(error) {
			Materialize.toast("Something went wrong! " + error, 4000, 'red');
		});
	};

	$scope.toDelete = function(license) {

		var id = license.$id;
		var licenseData = $scope.licenses.$getRecord(id);

		licenseData.confirmDelete = true;

		$scope.deleteindex = license;
	};

	// deletes the motha fucka license :D
	$scope.deleteLicense = function(license) {

		$scope.licenses.$remove(license)
	};

	// generates license(s)
	$scope.generate = function() {

		var licToGen = $scope.genData.toGenerate;
		var licensesAct = $scope.genData.act_code;
		var prefix = $scope.genData.prefix;

		$("#genLicenseModal").modal("close");

		if (licToGen) {
			var act_date = $scope.act_date.toISOString().slice(0, 19).replace('T', ' ');
			var timestamp = new Date().valueOf(); // get id based time
			var codeIndex = prefix;
			for (var i = licToGen - 1; i >= 0; i--) {
				var act_code = licensesAct + pad(codeIndex, 3);

				$scope.licenses.$add({
					"id"			: timestamp,
					"act_code"		: act_code,
					"organization" 	: $scope.genData.organization,
					"status"		: $scope.genData.status,
					"device_code"	: 0,
					"project"		: $scope.genData.project,
					"act_date"		: act_date
			    }).then(function() {
					// adds the new license to the view
					$scope.genData = ""; // clears the input fields
					$scope.genData.toGenerate = 1;
					// reset errors on the input
					$scope.licgenform.$setPristine();
					$scope.licgenform.$setUntouched();
				}, function(error) {
					Materialize.toast("Something went wrong! " + error, 4000, 'red');
				});

				codeIndex++;
			}
		}
	};
	$scope.handlers();
});

// nothing fancy custom directives // =====================================================/
// retrieves the licenses view from licenses.html
app.directive('licenses', function() {
  return {
  	restrict: 'E',
    templateUrl: 'js/templates/licenses.html'
  };
});

// app.directive('licmenu', function() {
//   return {
//     templateUrl: 'js/templates/lic-menu.html'
//   };
// });

app.directive('addlicense', function() {
  return {
  	restrict: 'E',
    templateUrl: 'js/templates/add-license.html'
  };
});

app.directive('genlicense', function() {
  return {
  	restrict: 'E',
    templateUrl: 'js/templates/gen-license.html'
  };
});

app.directive('deletelicense', function() {
  return {
  	restrict: 'E',
    templateUrl: 'js/templates/delete-license.html'
  };
});

}());

//# sourceMappingURL=site.js.map
