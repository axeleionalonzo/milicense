(function() {

// Initialize Firebase
var config = {
	apiKey: "AIzaSyBKDwt-a8kALwrcRhouksA0Z43vSYdEjVo",
	authDomain: "milicense-cb415.firebaseapp.com",
	databaseURL: "https://milicense-cb415.firebaseio.com",
	projectId: "milicense-cb415",
	storageBucket: "milicense-cb415.appspot.com",
	messagingSenderId: "65541478293"
};
// Get a reference to the database service
firebase.initializeApp(config);

var app = angular.module('licenseApp', ['chieffancypants.loadingBar', 'firebase', 'ngRoute'], function($interpolateProvider) {
	$interpolateProvider.startSymbol('[[');
	$interpolateProvider.endSymbol(']]');
});

// let's create a re-usable factory that generates the $firebaseAuth instance
app.factory("Auth", ["$firebaseAuth", function($firebaseAuth) {
  var ref = firebase.auth();
  return $firebaseAuth(ref);
}]);

app.config(function(cfpLoadingBarProvider) {
	cfpLoadingBarProvider.includeSpinner = false; // toggle spinner
	cfpLoadingBarProvider.includeBar = true; // toggle loading bar
});

app.controller('mainController', function($scope, $interval, $http, $filter, $timeout, $firebaseObject, $firebaseArray) {

	$scope.sidebarID = "";

	// get auth methods from database
	var auth = firebase.auth();

	auth.onAuthStateChanged(function(user) {
		if (user) {
			$scope.session = user; // user is logged in
			$scope.email = user.email;
			if (window.location.pathname !== "/license") window.location.href = '/license';
			$scope.sidebarID = "wrapper";
			$('#sidebar-wrapper').delay(700).show(0);
		} else {
			if (window.location.pathname == "/license") window.location.href = '/auth/login';
			$scope.sidebarID = "";
		}
	});

	$scope.greet = "Hello!";
	$scope.welcome = ["Hola!","Indo!","Bonjour!","Ciao!","Ola!","Namaste!","Salaam!","Konnichiwa!","Merhaba!","Jambo!","Ni Hau!","Hallo!","Hello!","Kamusta!"];
	$scope.greet = $scope.welcome[Math.floor(Math.random() * $scope.welcome.length)];
	$scope.errorCode = false;

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
			$scope.greet = "The internet police is checking your account. Have a great day!";
		}).catch(function(error) {
			// An error happened.
			// Handle Errors here.
			console.log(error);
			$scope.errorCode = error.code;
			$scope.errorMessage = error.message;
		});;
	});


	// download the data into a local object
	var ref = firebase.database().ref();

	$scope.licenses = [];
	$scope.genData = [];
	$scope.activation_date = "...";
	$scope.genData.status = 0;
	$scope.license = "";
	$scope.sortType = 'activation_date'; // set the default sort type
	$scope.sortReverse = false; // set the default sort order
	$scope.searchLicense = ""; // set the default search/filter term
	$scope.placeholder = "I'm feeling lucky"; // set the default search/filter term
	$scope.licenses = $firebaseArray(ref.child("licenses")); // populate licenses from firebase
	$scope.email = "user@mi.com";

	var pholder = ref.child('greetings');

	pholder.on('value', snap => $scope.placeholder = snap.val()); // sync object changes using on()

	// controls the ticking time on adding a license
	var tick = function() {
		$scope.activation_date = new Date();
	}

	// removes validation when modal is closed
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

		$("#exportlicense").click(function (e) {
			var blob = new Blob([document.getElementById('exportData').innerHTML], {
				type: "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet;charset=utf-8"
				});
				saveAs(blob, "Report.xls");
			// window.open('data:application/vnd.ms-excel,' + $('#exportData').html());
			// e.preventDefault();
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
		var activation_date = $scope.activation_date.toISOString().slice(0, 19).replace('T', ' ');
		var timestamp = new Date().valueOf(); // get id based time

		$scope.licenses.$add({
			"id":					timestamp,
			"activation_code": 		$scope.newLic.activation_code,
			"organization":			$scope.newLic.organization,
			"status":				$scope.newLic.status = 0,
			"device_code":			$scope.newLic.device_code = "",
			"expiration_date":		$filter('date')($scope.newLic.expiration_date, "yyyy-MM-dd"),
			"app_version":			$scope.newLic.app_version = "",
			"device_model":			$scope.newLic.device_model = "",
			"device_manufacturer":	$scope.newLic.device_manufacturer = "",
			"project":				$scope.newLic.project,
			"activation_date":		activation_date
		}).then(function() {

			$("#addLicenseModal").modal("close");

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
	// makes the table row editable
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
			"id":					licenseData.id,
			"activation_code":		licenseData.activation_code = licenseData.activation_code ? licenseData.activation_code : "",
			"organization":			licenseData.organization = licenseData.organization ? licenseData.organization : "",
			"status":				licenseData.status = licenseData.status ? licenseData.status : 0,
			"device_code":			licenseData.device_code = licenseData.device_code ? licenseData.device_code : "",
			"expiration_date":		licenseData.expiration_date = licenseData.expiration_date ? licenseData.expiration_date : "",
			"app_version":			licenseData.app_version = licenseData.app_version ? licenseData.app_version : "",
			"device_model":			licenseData.device_model = licenseData.device_model ? licenseData.device_model : "",
			"device_manufacturer":	licenseData.device_manufacturer = licenseData.device_manufacturer ? licenseData.device_manufacturer : "",
			"expiration_date":		licenseData.expiration_date = licenseData.expiration_date ? licenseData.expiration_date : "",
			"project":				licenseData.project = licenseData.project ? licenseData.project : "",
			"activation_date":		licenseData.activation_date = licenseData.activation_date ? licenseData.activation_date : ""
		};

		// Write the new post's data simultaneously in the posts list and the user's post list.
		var updates = {};
		updates['/licenses/' + id] = postData;

		ref.update(updates).then(function() {
		}, function(error) {
			Materialize.toast("Something went wrong! " + error, 4000, 'red');
		});
	};

	// gets the selected license ready for deletion
	$scope.toDelete = function(license) {
		var id = license.$id;
		var licenseData = $scope.licenses.$getRecord(id);

		licenseData.confirmDelete = true;

		// for security, we need to remove toDelete licenses after 3 seconds
		if (license.confirmDelete) {
			$timeout(function() {
				license.confirmDelete = false;
			}, 3000);
		}

		$scope.deleteindex = license;
	};

	// deletes the motha fucka license :D
	$scope.deleteLicense = function(license) {

		$scope.licenses.$remove(license)
	};

	// generates license(s)
	$scope.generate = function() {

		var licToGen = $scope.genData.toGenerate;
		var licensesAct = $scope.genData.activation_code;
		var prefix = $scope.genData.prefix;

		if (licToGen) {
			var activation_date = $scope.activation_date.toISOString().slice(0, 19).replace('T', ' ');
			var timestamp = new Date().valueOf(); // get id based time
			var codeIndex = prefix;
			for (var i = licToGen - 1; i >= 0; i--) {
				var activation_code = licensesAct + pad(codeIndex, 3);

				$scope.licenses.$add({
					"id"				: timestamp,
					"activation_code"	: activation_code,
					"organization" 		: $scope.genData.organization,
					"status"			: $scope.genData.status,
					"device_code"		: "",
					"expiration_date"	: $filter('date')($scope.genData.expiration_date, "yyyy-MM-dd"),
					"app_version"		: $scope.genData.app_version = "",
					"device_model"		: $scope.genData.device_model = "",
					"device_manufacturer"	: $scope.genData.device_manufacturer = "",
					"project"			: $scope.genData.project,
					"activation_date"	: activation_date
				}).then(function() {

					$("#genLicenseModal").modal("close");

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
//	 return {
//	 templateUrl: 'js/templates/lic-menu.html'
//	 };
// });

app.directive('addlicense', function() {
	return {
		restrict: 'E',
	templateUrl: 'js/templates/add-license.html',
	controller: function () {
		$( document ).ready(function(){
			$('.datepicker').pickadate({
				selectMonths: true, // Creates a dropdown to control month
				selectYears: 15 // Creates a dropdown of 15 years to control year
			});
		});
	}
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

app.directive('ngEnter', function() {
	return function(scope, element, attrs) {
	element.bind("keydown keypress", function(event) {
	if (event.which === 13) {
	scope.$apply(function() {
	scope.$eval(attrs.ngEnter, {'event': event});
	});
	event.preventDefault();
	}
	});
	};
});

}());
