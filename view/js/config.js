function config($stateProvider, $urlRouterProvider, $locationProvider,$ocLazyLoadProvider) {

  $urlRouterProvider.otherwise("/home");

  $stateProvider.state('home', {
		url: "/home",
		templateUrl: "backend/angular.php?type=view&include=home",
    resolve: {
      loadPlugin: function ($ocLazyLoad) {
        return $ocLazyLoad.load([
        {
          serie: true,
          name: 'toaster',
          files: ['view/js/toastr.min.js','view/css/toastr.min.css']
        }
        ])
      }
    }
	}).state('login', {
    url: "/login",
    templateUrl: "backend/angular.php?type=view&include=login",
    controller: "LoginCtrl",
    resolve: {
      loadPlugin: function ($ocLazyLoad) {
        return $ocLazyLoad.load([{
          serie: true,
          name: 'toaster',
          files: ['view/js/toastr.min.js','view/css/toastr.min.css']
        }
        ])
      }
    }
  }).state('sign-up', {
    url: "/sign-up",
    templateUrl: "backend/angular.php?type=view&include=signUp",
    controller: "SignupCtrl",
    resolve: {
      loadPlugin: function ($ocLazyLoad) {
        return $ocLazyLoad.load([
        {
          serie: true,
          name: 'toaster',
          files: ['view/js/toastr.min.js','view/css/toastr.min.css']
        }
        ])
      }
    }
  }).state('myAccount', {
    url: "/myaccount",
    abstract: true,
    templateUrl: "backend/angular.php?type=view&include=myAccount",
    resolve: {
      loadPlugin: function ($ocLazyLoad) {
        return $ocLazyLoad.load([
        {
          serie: true,
          name: 'toaster',
          files: ['view/js/toastr.min.js','view/css/toastr.min.css']
        }
        ])
      }
    }
  }).state('myAccount.dashboard', {
    url: "/dashboard/",
    templateUrl: "backend/angular.php?type=view&include=myAccount/dashboard",
    controller: "MyDashboardCtrl",
  }).state('myAccount.settings', {
    url: "/settings",
    templateUrl: "backend/angular.php?type=view&include=myAccount/settings",
    controller: "MySettingsCtrl",
  }).state('myAccount.logout', {
    url: "/logout",
    controller: "LogoutCtrl",
  });

}

angular.module('timetracking', [
    'ui.router',
    'oc.lazyLoad',
    'ngResource',
    'ui.bootstrap'
  ]).config(config);
