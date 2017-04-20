function MainCtrl($scope,$http,$state){

	$scope.loggedIn = function(){

		$http.get("backend/angular.php?type=php&include=Users&function=loggedIn").success(function(data){

			if (data.loggedin == true && data.data)
				$scope.user = data.data;
			else if(typeof $scope.user !== "undefined"){
				delete $scope.user;
				$state.go("home");
			}

		});

	};

	$scope.$on("loggedIn", function(){

		$scope.loggedIn();

	});

	setInterval(function() {
		$scope.loggedIn();
	}, 5000);

	$scope.loggedIn();

}

function LoginCtrl($scope,$http, $state, toaster){

	$scope.login = function(valid){

		if (!valid)
			return false;

		$http.post("backend/angular.php?type=php&include=Login&function=login", $scope.form).success(function(data){

			if (data.errors)
				toaster.pop({ type: 'error', title: "Error!", body: data.errors});
			else{
				$scope.$emit("loggedIn");
				$state.go("myAccount.dashboard");
			}

		});

	};

}

function SignupCtrl($scope,$http,toaster,$state){

	$scope.signUp = function(valid){

		console.log("asd");

		if (!valid)
			return false;

		$http({
	    method: 'POST',
	    url: "backend/angular.php?type=php&include=Signup&function=signupSQL",
	    data: $scope.form,
		}).success(function(data) {

			if (data.errors)
				toaster.pop({ type: 'error', title: "Error!", body: data.errors});
			else{

				$scope.$emit("loggedIn");
				$state.go("myAccount.dashboard");

			}
		});

	};

}

function MyDashboardCtrl($scope, ngDialog){

	$scope.createProject = function(){
		$scope.dialog = ngDialog.open({
			template: "editProject.html"
		});
	};

	$scope.submit = function(){

		$http({
	    method: 'POST',
	    url: "backend/angular.php?type=php&include=Projects&function=newProject",
	    data: $scope.form,
		}).success(function(data) {

			if (data.errors)
				toaster.pop({ type: 'error', title: "Error!", body: data.errors});
			else{

				$scope.dialog.close();
				$scope.refreshProject();

			}
		});

	};

	$scope.refreshProjects = function(){

		$http.get("backend/angular.php?type=php&include=Projects&function=listProjects").success(function(data){

			$scope.projects = data.data;

		});

	};

	$scope.refreshProjects();

}

function MySettingsCtrl($scope,$http,toaster){

	$scope.changePassword = function(valid){

		if (!valid)
			return false;

		$http({
	    method: 'POST',
	    url: "backend/angular.php?type=php&include=Settings&function=changePassword",
	    data: $scope.form,
		}).success(function(data) {

			if (data.errors)
				toaster.pop({ type: 'error', title: "Error!", body: data.errors});
			else{

				$scope.form = {};
				toaster.pop({type: 'success', title: "Success!", body: "Your password has been changed."});

			}
		});

	};

}

function LogoutCtrl($scope,$http,$state){

	$http.get("backend/angular.php?type=php&include=Users&function=logout").success(function(){

		$scope.$emit("loggedIn");
		$state.go("home");

	});

}

angular.module('timetracking')
.controller('MainCtrl', MainCtrl)
.controller('LoginCtrl', LoginCtrl)
.controller('SignupCtrl', SignupCtrl)
.controller('MyDashboardCtrl', MyDashboardCtrl)
.controller('MySettingsCtrl', MySettingsCtrl)
.controller('LogoutCtrl', LogoutCtrl);
