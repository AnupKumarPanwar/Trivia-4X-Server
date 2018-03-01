angular.module('starter.controllers', [])

.controller('HomeCtrl', function($scope, $state) {

    $scope.getStarted=function()
    {
      $state.go('login');
    }

})

.controller('LoginCtrl', function($scope, $state) {

	$scope.goToOTP=function()
	{
		$state.go('otp');
	}

	$scope.goToSignup=function()
	{
		$state.go('signup');
	}
});