/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId]) {
/******/ 			return installedModules[moduleId].exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, { enumerable: true, get: getter });
/******/ 		}
/******/ 	};
/******/
/******/ 	// define __esModule on exports
/******/ 	__webpack_require__.r = function(exports) {
/******/ 		if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 			Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 		}
/******/ 		Object.defineProperty(exports, '__esModule', { value: true });
/******/ 	};
/******/
/******/ 	// create a fake namespace object
/******/ 	// mode & 1: value is a module id, require it
/******/ 	// mode & 2: merge all properties of value into the ns
/******/ 	// mode & 4: return value when already ns object
/******/ 	// mode & 8|1: behave like require
/******/ 	__webpack_require__.t = function(value, mode) {
/******/ 		if(mode & 1) value = __webpack_require__(value);
/******/ 		if(mode & 8) return value;
/******/ 		if((mode & 4) && typeof value === 'object' && value && value.__esModule) return value;
/******/ 		var ns = Object.create(null);
/******/ 		__webpack_require__.r(ns);
/******/ 		Object.defineProperty(ns, 'default', { enumerable: true, value: value });
/******/ 		if(mode & 2 && typeof value != 'string') for(var key in value) __webpack_require__.d(ns, key, function(key) { return value[key]; }.bind(null, key));
/******/ 		return ns;
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "/";
/******/
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 3);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./resources/js/checkHourBoxes.js":
/*!****************************************!*\
  !*** ./resources/js/checkHourBoxes.js ***!
  \****************************************/
/*! no static exports found */
/***/ (function(module, exports) {

eval("console.log(\"check hour boxes function called\");\n\nvar checkHourButtons = function checkHourButtons() {\n  var hourButtons = document.getElementsByName('hourButton');\n  hourButtons.forEach(function (hourButton) {\n    hourButton.addEventListener('click', function () {\n      var firstCheckBoxToCheck = hourButton.value * 4 - 1;\n      var secondCheckBoxToCheck = hourButton.value * 4 - 2;\n      var thirdCheckBoxToCheck = hourButton.value * 4 - 3;\n      var fourthCheckBoxToCheck = hourButton.value * 4 - 4;\n      var checkBoxesToCheck = [firstCheckBoxToCheck, secondCheckBoxToCheck, thirdCheckBoxToCheck, fourthCheckBoxToCheck];\n      checkBoxesToCheck.forEach(function (checkBoxToCheck) {\n        document.getElementById(\"boxOn_\" + checkBoxToCheck).checked = true;\n      });\n    });\n  });\n};\n\ncheckHourButtons();\n\nvar textstuff = function textstuff() {\n  console.log(\"textstuff called\");\n};\n\nfunction test() {\n  console.log(\"werkt\");\n}//# sourceURL=[module]\n//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbIndlYnBhY2s6Ly8vLi9yZXNvdXJjZXMvanMvY2hlY2tIb3VyQm94ZXMuanM/NzBlMSJdLCJuYW1lcyI6WyJjb25zb2xlIiwibG9nIiwiY2hlY2tIb3VyQnV0dG9ucyIsImhvdXJCdXR0b25zIiwiZG9jdW1lbnQiLCJnZXRFbGVtZW50c0J5TmFtZSIsImZvckVhY2giLCJob3VyQnV0dG9uIiwiYWRkRXZlbnRMaXN0ZW5lciIsImZpcnN0Q2hlY2tCb3hUb0NoZWNrIiwidmFsdWUiLCJzZWNvbmRDaGVja0JveFRvQ2hlY2siLCJ0aGlyZENoZWNrQm94VG9DaGVjayIsImZvdXJ0aENoZWNrQm94VG9DaGVjayIsImNoZWNrQm94ZXNUb0NoZWNrIiwiY2hlY2tCb3hUb0NoZWNrIiwiZ2V0RWxlbWVudEJ5SWQiLCJjaGVja2VkIiwidGV4dHN0dWZmIiwidGVzdCJdLCJtYXBwaW5ncyI6IkFBQUFBLE9BQU8sQ0FBQ0MsR0FBUixDQUFZLGtDQUFaOztBQUdBLElBQU1DLGdCQUFnQixHQUFHLFNBQW5CQSxnQkFBbUIsR0FBSTtFQUN6QixJQUFNQyxXQUFXLEdBQUdDLFFBQVEsQ0FBQ0MsaUJBQVQsQ0FBMkIsWUFBM0IsQ0FBcEI7RUFDQUYsV0FBVyxDQUFDRyxPQUFaLENBQW9CLFVBQUFDLFVBQVUsRUFBSTtJQUM5QkEsVUFBVSxDQUFDQyxnQkFBWCxDQUE0QixPQUE1QixFQUFvQyxZQUFJO01BQ3BDLElBQU1DLG9CQUFvQixHQUFHRixVQUFVLENBQUNHLEtBQVgsR0FBbUIsQ0FBbkIsR0FBdUIsQ0FBcEQ7TUFDQSxJQUFNQyxxQkFBcUIsR0FBR0osVUFBVSxDQUFDRyxLQUFYLEdBQW1CLENBQW5CLEdBQXVCLENBQXJEO01BQ0EsSUFBTUUsb0JBQW9CLEdBQUdMLFVBQVUsQ0FBQ0csS0FBWCxHQUFtQixDQUFuQixHQUF1QixDQUFwRDtNQUNBLElBQU1HLHFCQUFxQixHQUFHTixVQUFVLENBQUNHLEtBQVgsR0FBbUIsQ0FBbkIsR0FBdUIsQ0FBckQ7TUFDQSxJQUFNSSxpQkFBaUIsR0FBRyxDQUN0Qkwsb0JBRHNCLEVBRXRCRSxxQkFGc0IsRUFHdEJDLG9CQUhzQixFQUl0QkMscUJBSnNCLENBQTFCO01BT0FDLGlCQUFpQixDQUFDUixPQUFsQixDQUEwQixVQUFDUyxlQUFELEVBQXFCO1FBQzNDWCxRQUFRLENBQUNZLGNBQVQsQ0FDSSxXQUFXRCxlQURmLEVBRUVFLE9BRkYsR0FFWSxJQUZaO01BR0gsQ0FKRDtJQUtILENBakJEO0VBa0JILENBbkJEO0FBb0JILENBdEJEOztBQXVCQWYsZ0JBQWdCOztBQUVoQixJQUFNZ0IsU0FBUyxHQUFHLFNBQVpBLFNBQVksR0FBSTtFQUVsQmxCLE9BQU8sQ0FBQ0MsR0FBUixDQUFZLGtCQUFaO0FBQ0gsQ0FIRDs7QUFNQSxTQUFTa0IsSUFBVCxHQUFnQjtFQUNabkIsT0FBTyxDQUFDQyxHQUFSLENBQVksT0FBWjtBQUF5QiIsImZpbGUiOiIuL3Jlc291cmNlcy9qcy9jaGVja0hvdXJCb3hlcy5qcy5qcyIsInNvdXJjZXNDb250ZW50IjpbImNvbnNvbGUubG9nKFwiY2hlY2sgaG91ciBib3hlcyBmdW5jdGlvbiBjYWxsZWRcIik7XHJcblxyXG5cclxuY29uc3QgY2hlY2tIb3VyQnV0dG9ucyA9ICgpPT57XHJcbiAgICBjb25zdCBob3VyQnV0dG9ucyA9IGRvY3VtZW50LmdldEVsZW1lbnRzQnlOYW1lKCdob3VyQnV0dG9uJylcclxuICAgIGhvdXJCdXR0b25zLmZvckVhY2goaG91ckJ1dHRvbiA9PiB7XHJcbiAgICAgICAgaG91ckJ1dHRvbi5hZGRFdmVudExpc3RlbmVyKCdjbGljaycsKCk9PntcclxuICAgICAgICAgICAgY29uc3QgZmlyc3RDaGVja0JveFRvQ2hlY2sgPSBob3VyQnV0dG9uLnZhbHVlICogNCAtIDE7XHJcbiAgICAgICAgICAgIGNvbnN0IHNlY29uZENoZWNrQm94VG9DaGVjayA9IGhvdXJCdXR0b24udmFsdWUgKiA0IC0gMjtcclxuICAgICAgICAgICAgY29uc3QgdGhpcmRDaGVja0JveFRvQ2hlY2sgPSBob3VyQnV0dG9uLnZhbHVlICogNCAtIDM7XHJcbiAgICAgICAgICAgIGNvbnN0IGZvdXJ0aENoZWNrQm94VG9DaGVjayA9IGhvdXJCdXR0b24udmFsdWUgKiA0IC0gNDtcclxuICAgICAgICAgICAgY29uc3QgY2hlY2tCb3hlc1RvQ2hlY2sgPSBbXHJcbiAgICAgICAgICAgICAgICBmaXJzdENoZWNrQm94VG9DaGVjayxcclxuICAgICAgICAgICAgICAgIHNlY29uZENoZWNrQm94VG9DaGVjayxcclxuICAgICAgICAgICAgICAgIHRoaXJkQ2hlY2tCb3hUb0NoZWNrLFxyXG4gICAgICAgICAgICAgICAgZm91cnRoQ2hlY2tCb3hUb0NoZWNrLFxyXG4gICAgICAgICAgICBdO1xyXG5cclxuICAgICAgICAgICAgY2hlY2tCb3hlc1RvQ2hlY2suZm9yRWFjaCgoY2hlY2tCb3hUb0NoZWNrKSA9PiB7XHJcbiAgICAgICAgICAgICAgICBkb2N1bWVudC5nZXRFbGVtZW50QnlJZChcclxuICAgICAgICAgICAgICAgICAgICBcImJveE9uX1wiICsgY2hlY2tCb3hUb0NoZWNrXHJcbiAgICAgICAgICAgICAgICApLmNoZWNrZWQgPSB0cnVlO1xyXG4gICAgICAgICAgICB9KTtcclxuICAgICAgICB9KVxyXG4gICAgfSk7XHJcbn1cclxuY2hlY2tIb3VyQnV0dG9ucygpXHJcblxyXG5jb25zdCB0ZXh0c3R1ZmYgPSAoKT0+e1xyXG5cclxuICAgIGNvbnNvbGUubG9nKFwidGV4dHN0dWZmIGNhbGxlZFwiKVxyXG59XHJcblxyXG5cclxuZnVuY3Rpb24gdGVzdCgpIHtcclxuICAgIGNvbnNvbGUubG9nKFwid2Vya3RcIikgICAgfVxyXG4iXSwic291cmNlUm9vdCI6IiJ9\n//# sourceURL=webpack-internal:///./resources/js/checkHourBoxes.js\n");

/***/ }),

/***/ 3:
/*!**********************************************!*\
  !*** multi ./resources/js/checkHourBoxes.js ***!
  \**********************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! C:\Users\desktop\Desktop\daily_logger_v3\daily_logger_v3\resources\js\checkHourBoxes.js */"./resources/js/checkHourBoxes.js");


/***/ })

/******/ });