<html ng-app="countryApp">
  <head>
    <meta charset="utf-8">
    <title>Angular.js Example</title>
    <script src="//cdnjs.cloudflare.com/ajax/libs/angular.js/1.2.1/angular.min.js"></script>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
    <link href="angular-xeditable-0.1.8/css/xeditable.css" rel="stylesheet">
    <script src="angular-xeditable-0.1.8/js/xeditable.js"></script>
    <!--
    dirPagination.js
    dirPagination.spec.js
    -->
    <script>
      var countryApp = angular.module('countryApp', ["xeditable"]);
      countryApp.filter('offset', function() {
        return function(input, start) {
          start = parseInt(start, 10);
          return input.slice(start);
        };
      });

      countryApp.controller('CountryCtrl', function ($scope, $http){
        $http.get('backend.php?function=select_all').success(function(data) {
          // console.log(data);
          $scope.countries = data.response;
        });
        $scope.sortField = 'population';
        $scope.reverse = true;

        /*
        * This function executes when we click save , 
        * it makes ajax to save data to db ,gets id of created record,
        * appends it to the countries in the scope
        */
        $scope.addCountry = function() {
          var dataObject = {
              name : $scope.countryName
              ,population  : $scope.countryPopulation
          };
          $http.post('backend.php?function=save', { "data" : dataObject}).
          success(function(data, status) {
            var latestCountry = {
                id:data.response,
                name:$scope.countryName,
                population:$scope.countryPopulation
            };
            $scope.countries.push(latestCountry);
            $scope.countryName = '';
            $scope.countryPopulation = '';
          })
          .
          error(function(data, status) {
            console.log("error");
          });
        }
        /*
        * This function executes when we click delete , 
        * it makes ajax to delete record from db
        * removes the country from countries in the scope
        */
        $scope.deleteCountry = function(country) {
            $http.post('backend.php?function=delete', { "id" : country.id}).
            success(function(data, status) {
              if (data.response === 1) {
                var i = $scope.countries.indexOf(country);
                $scope.countries.splice(i, 1);
              } else {
                console.log("error up");  
              }
            })
            .
            error(function(data, status) {
              console.log("error");
            });
        }

        $scope.saveEditedCountry = function(country) {
          $http.post('backend.php?function=edit', { "data" : country}).
            success(function(data, status) {
              console.log(data);
            })
            .
            error(function(data, status) {
              console.log("error");
            });
          
        }

        //for pagination
          $scope.itemsPerPage = 5;
          $scope.currentPage = 0;
          
          $scope.range = function() {
            var rangeSize = 2;
            var ret = [];
            var start;

            start = $scope.currentPage;
            if ( start > $scope.pageCount()-rangeSize ) {
              start = $scope.pageCount()-rangeSize+1;
            }

            for (var i=start; i<start+rangeSize; i++) {
              ret.push(i);
            }
            return ret;
          };

          $scope.prevPage = function() {
            if ($scope.currentPage > 0) {
              $scope.currentPage--;
            }
          };

          $scope.prevPageDisabled = function() {
            return $scope.currentPage === 0 ? "disabled" : "";
          };

          $scope.pageCount = function() {
            return Math.ceil($scope.countries.length/$scope.itemsPerPage)-1;
          };

          $scope.nextPage = function() {
            if ($scope.currentPage < $scope.pageCount()) {
              $scope.currentPage++;
            }
          };

          $scope.nextPageDisabled = function() {
            return $scope.currentPage === $scope.pageCount() ? "disabled" : "";
          };

          $scope.setPage = function(n) {
            $scope.currentPage = n;
          };
        //till here
      });
    </script>
  </head>
  <body ng-controller="CountryCtrl">
  <div class="table">
    Search:<input ng-model="query" type="text"/>
    <table>
      <tr>
        <th><a href="" ng-click="sortField ='name'; reverse = !reverse">Country</a></th>
        <th><a href="" ng-click="sortField = 'population'; reverse = !reverse">Population</a></th>
        <th>Actions</th>
      </tr>
      <tr ng-repeat="country in countries | filter:query | orderBy:sortField:reverse | offset: currentPage*itemsPerPage | limitTo: itemsPerPage" class="country{{country.id}}">
        <td><a href="#" editable-text="country.name" onaftersave="saveEditedCountry(country)">{{ country.name || "empty" }}</a></td>
        <td><a href="#" editable-text="country.population" onaftersave="saveEditedCountry(country)">{{ country.population || "empty" }}</a></td>
        <td><a href="javascript:void(0)" ng-click=deleteCountry(country)>Delete</a></td>
      </tr>
      <tr>
          <td colspan="3">
            <span ng-class="prevPageDisabled()">
              <a href ng-click="prevPage()">« Prev</a>
            </span>
            <span ng-repeat="n in range()" ng-class="{active: n == currentPage}" ng-click="setPage(n)">
              <a href="#">{{n+1}}</a>
            </span>
            <span ng-class="nextPageDisabled()">
              <a href ng-click="nextPage()">Next »</a>
            </span>
          </td>
      </tr>
    </table>
  </div>
  <button class="btn" ng-click="createCountryForm = ! createCountryForm">Add New Country</button>
  <div class="form" ng-show="createCountryForm">
    <h3>New Country</h3>
    <input type="text" ng-model="countryName" placeholder="Country Name..."/>
    <input type="text" ng-model="countryPopulation" placeholder="Country Population..."/>
    <button class="btn" ng-click=addCountry()>Save</button>  
  </div>
  <div class="editFormContainer"></div>    
  </body>
</html>
