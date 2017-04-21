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
	}, 20000);

	$scope.loggedIn();

}

function LoginCtrl($scope,$http, $state, toaster){

	$scope.form = {};

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

	$scope.form = {};

	$scope.signUp = function(valid){

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

function MyDashboardCtrl($scope, $http, toaster, $uibModal){

	$scope.form = {};

	$scope.createProject = function(){
		$scope.dialog =  $uibModal.open({
			templateUrl: 'editProject.html',
			scope: $scope,
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

				$scope.form = {};
				$scope.dialog.close();
				$scope.refreshProjects();

			}
		});

	};

	$scope.refreshProjects = function(){

		$http.get("backend/angular.php?type=php&include=Projects&function=listProjects").success(function(data){

			$scope.projects = data.data;

		});

	};

	setInterval(function() {
		$scope.refreshProjects();
	}, 60000);

	$scope.refreshProjects();

	$scope.deactivateProject = function(projectid){

		$http.get("backend/angular.php?type=php&include=Projects&function=deactivateProject&id="+projectid).success(function(data){

			if (data.errors)
				toaster.pop({ type: 'error', title: "Error!", body: data.errors});
			else{

				$scope.refreshProjects();

			}

		});

	};

	$scope.pauseProject = function(projectid){

		$http.get("backend/angular.php?type=php&include=Projects&function=pauseProject&id="+projectid).success(function(data){

			if (data.errors)
				toaster.pop({ type: 'error', title: "Error!", body: data.errors});
			else{

				$scope.refreshProjects();

			}

		});

	};

	$scope.startProject = function(projectid){

		$http.get("backend/angular.php?type=php&include=Projects&function=startProject&id="+projectid).success(function(data){

			if (data.errors)
				toaster.pop({ type: 'error', title: "Error!", body: data.errors});
			else{

				$scope.refreshProjects();

			}

		});

	};

	$scope.checkLogs = function(project){

		$scope.data = project;

		$scope.dialog = $uibModal.open({
			templateUrl: "checkLogs.html",
			scope: $scope
		});

	};

}

function MySettingsCtrl($scope,$http,toaster){

	$scope.form = {};

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
