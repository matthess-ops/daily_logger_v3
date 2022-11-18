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

eval("console.log(\"check hour boxes function called\");\n\nvar checkHourButtons = function checkHourButtons() {\n  var hourButtons = document.getElementsByName('hourButton');\n  hourButtons.forEach(function (hourButton) {\n    hourButton.addEventListener('click', function () {\n      var firstCheckBoxToCheck = hourButton.value * 4 - 1;\n      var secondCheckBoxToCheck = hourButton.value * 4 - 2;\n      var thirdCheckBoxToCheck = hourButton.value * 4 - 3;\n      var fourthCheckBoxToCheck = hourButton.value * 4 - 4;\n      var checkBoxesToCheck = [firstCheckBoxToCheck, secondCheckBoxToCheck, thirdCheckBoxToCheck, fourthCheckBoxToCheck];\n      checkBoxesToCheck.forEach(function (checkBoxToCheck) {\n        document.getElementById(\"boxOn_\" + checkBoxToCheck).checked = true;\n      });\n    });\n  });\n};\n\ncheckHourButtons();//# sourceURL=[module]\n//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbIndlYnBhY2s6Ly8vLi9yZXNvdXJjZXMvanMvY2hlY2tIb3VyQm94ZXMuanM/NzBlMSJdLCJuYW1lcyI6WyJjb25zb2xlIiwibG9nIiwiY2hlY2tIb3VyQnV0dG9ucyIsImhvdXJCdXR0b25zIiwiZG9jdW1lbnQiLCJnZXRFbGVtZW50c0J5TmFtZSIsImZvckVhY2giLCJob3VyQnV0dG9uIiwiYWRkRXZlbnRMaXN0ZW5lciIsImZpcnN0Q2hlY2tCb3hUb0NoZWNrIiwidmFsdWUiLCJzZWNvbmRDaGVja0JveFRvQ2hlY2siLCJ0aGlyZENoZWNrQm94VG9DaGVjayIsImZvdXJ0aENoZWNrQm94VG9DaGVjayIsImNoZWNrQm94ZXNUb0NoZWNrIiwiY2hlY2tCb3hUb0NoZWNrIiwiZ2V0RWxlbWVudEJ5SWQiLCJjaGVja2VkIl0sIm1hcHBpbmdzIjoiQUFBQUEsT0FBTyxDQUFDQyxHQUFSLENBQVksa0NBQVo7O0FBR0EsSUFBTUMsZ0JBQWdCLEdBQUcsU0FBbkJBLGdCQUFtQixHQUFJO0VBQ3pCLElBQU1DLFdBQVcsR0FBR0MsUUFBUSxDQUFDQyxpQkFBVCxDQUEyQixZQUEzQixDQUFwQjtFQUNBRixXQUFXLENBQUNHLE9BQVosQ0FBb0IsVUFBQUMsVUFBVSxFQUFJO0lBQzlCQSxVQUFVLENBQUNDLGdCQUFYLENBQTRCLE9BQTVCLEVBQW9DLFlBQUk7TUFDcEMsSUFBTUMsb0JBQW9CLEdBQUdGLFVBQVUsQ0FBQ0csS0FBWCxHQUFtQixDQUFuQixHQUF1QixDQUFwRDtNQUNBLElBQU1DLHFCQUFxQixHQUFHSixVQUFVLENBQUNHLEtBQVgsR0FBbUIsQ0FBbkIsR0FBdUIsQ0FBckQ7TUFDQSxJQUFNRSxvQkFBb0IsR0FBR0wsVUFBVSxDQUFDRyxLQUFYLEdBQW1CLENBQW5CLEdBQXVCLENBQXBEO01BQ0EsSUFBTUcscUJBQXFCLEdBQUdOLFVBQVUsQ0FBQ0csS0FBWCxHQUFtQixDQUFuQixHQUF1QixDQUFyRDtNQUNBLElBQU1JLGlCQUFpQixHQUFHLENBQ3RCTCxvQkFEc0IsRUFFdEJFLHFCQUZzQixFQUd0QkMsb0JBSHNCLEVBSXRCQyxxQkFKc0IsQ0FBMUI7TUFPQUMsaUJBQWlCLENBQUNSLE9BQWxCLENBQTBCLFVBQUNTLGVBQUQsRUFBcUI7UUFDM0NYLFFBQVEsQ0FBQ1ksY0FBVCxDQUNJLFdBQVdELGVBRGYsRUFFRUUsT0FGRixHQUVZLElBRlo7TUFHSCxDQUpEO0lBS0gsQ0FqQkQ7RUFrQkgsQ0FuQkQ7QUFvQkgsQ0F0QkQ7O0FBdUJBZixnQkFBZ0IiLCJmaWxlIjoiLi9yZXNvdXJjZXMvanMvY2hlY2tIb3VyQm94ZXMuanMuanMiLCJzb3VyY2VzQ29udGVudCI6WyJjb25zb2xlLmxvZyhcImNoZWNrIGhvdXIgYm94ZXMgZnVuY3Rpb24gY2FsbGVkXCIpO1xuXG5cbmNvbnN0IGNoZWNrSG91ckJ1dHRvbnMgPSAoKT0+e1xuICAgIGNvbnN0IGhvdXJCdXR0b25zID0gZG9jdW1lbnQuZ2V0RWxlbWVudHNCeU5hbWUoJ2hvdXJCdXR0b24nKVxuICAgIGhvdXJCdXR0b25zLmZvckVhY2goaG91ckJ1dHRvbiA9PiB7XG4gICAgICAgIGhvdXJCdXR0b24uYWRkRXZlbnRMaXN0ZW5lcignY2xpY2snLCgpPT57XG4gICAgICAgICAgICBjb25zdCBmaXJzdENoZWNrQm94VG9DaGVjayA9IGhvdXJCdXR0b24udmFsdWUgKiA0IC0gMTtcbiAgICAgICAgICAgIGNvbnN0IHNlY29uZENoZWNrQm94VG9DaGVjayA9IGhvdXJCdXR0b24udmFsdWUgKiA0IC0gMjtcbiAgICAgICAgICAgIGNvbnN0IHRoaXJkQ2hlY2tCb3hUb0NoZWNrID0gaG91ckJ1dHRvbi52YWx1ZSAqIDQgLSAzO1xuICAgICAgICAgICAgY29uc3QgZm91cnRoQ2hlY2tCb3hUb0NoZWNrID0gaG91ckJ1dHRvbi52YWx1ZSAqIDQgLSA0O1xuICAgICAgICAgICAgY29uc3QgY2hlY2tCb3hlc1RvQ2hlY2sgPSBbXG4gICAgICAgICAgICAgICAgZmlyc3RDaGVja0JveFRvQ2hlY2ssXG4gICAgICAgICAgICAgICAgc2Vjb25kQ2hlY2tCb3hUb0NoZWNrLFxuICAgICAgICAgICAgICAgIHRoaXJkQ2hlY2tCb3hUb0NoZWNrLFxuICAgICAgICAgICAgICAgIGZvdXJ0aENoZWNrQm94VG9DaGVjayxcbiAgICAgICAgICAgIF07XG5cbiAgICAgICAgICAgIGNoZWNrQm94ZXNUb0NoZWNrLmZvckVhY2goKGNoZWNrQm94VG9DaGVjaykgPT4ge1xuICAgICAgICAgICAgICAgIGRvY3VtZW50LmdldEVsZW1lbnRCeUlkKFxuICAgICAgICAgICAgICAgICAgICBcImJveE9uX1wiICsgY2hlY2tCb3hUb0NoZWNrXG4gICAgICAgICAgICAgICAgKS5jaGVja2VkID0gdHJ1ZTtcbiAgICAgICAgICAgIH0pO1xuICAgICAgICB9KVxuICAgIH0pO1xufVxuY2hlY2tIb3VyQnV0dG9ucygpXG4iXSwic291cmNlUm9vdCI6IiJ9\n//# sourceURL=webpack-internal:///./resources/js/checkHourBoxes.js\n");

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