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
/******/ 	return __webpack_require__(__webpack_require__.s = 0);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./resources/js/custom/password_validator.js":
/*!***************************************************!*\
  !*** ./resources/js/custom/password_validator.js ***!
  \***************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

var myPass = document.getElementById("password");
var passConf = document.getElementById("password-confirm");
var letter = document.getElementById("letter");
var capital = document.getElementById("capital");
var number = document.getElementById("number");
var length = document.getElementById("length");
var special = document.getElementById("special"); // When the users clicks on the password field, show the message box

myPass.onfocus = function () {
  document.getElementById("message").style.display = "block";
}; // When the users clicks outside of the password field, hide the message box


myPass.onblur = function () {
  document.getElementById("message").style.display = "none";
}; // When the users starts to type something inside the password field


myPass.onkeyup = function () {
  // Validate lowercase letters
  var lowerCaseLetters = /[a-z]/g;

  if (myPass.value.match(lowerCaseLetters)) {
    myPass.style.borderColor = 'green';
    letter.classList.remove("invalid");
    letter.classList.add("valid");
  } else {
    myPass.style.borderColor = 'red';
    letter.classList.remove("valid");
    letter.classList.add("invalid");
  } // Validate capital letters


  var upperCaseLetters = /[A-Z]/g;

  if (myPass.value.match(upperCaseLetters)) {
    myPass.style.borderColor = 'green';
    capital.classList.remove("invalid");
    capital.classList.add("valid");
  } else {
    myPass.style.borderColor = 'red';
    capital.classList.remove("valid");
    capital.classList.add("invalid");
  } // Validate numbers


  var numbers = /[0-9]/g;

  if (myPass.value.match(numbers)) {
    myPass.style.borderColor = 'green';
    number.classList.remove("invalid");
    number.classList.add("valid");
  } else {
    myPass.style.borderColor = 'red';
    number.classList.remove("valid");
    number.classList.add("invalid");
  } // Validate length


  if (myPass.value.length >= 8) {
    myPass.style.borderColor = 'green';
    length.classList.remove("invalid");
    length.classList.add("valid");
  } else {
    myPass.style.borderColor = 'red';
    length.classList.remove("valid");
    length.classList.add("invalid");
  } // Validate special characters


  var specialchar = /^(.*\W){1}.*$/g;

  if (myPass.value.match(specialchar)) {
    myPass.style.borderColor = 'green';
    special.classList.remove("invalid");
    special.classList.add("valid");
  } else {
    myPass.style.borderColor = 'red';
    special.classList.remove("valid");
    special.classList.add("invalid");
  }

  if (myPass.value != passConf.value) {
    document.getElementById("msg").style.display = "block";
    passConf.style.borderColor = 'red';
  } else {
    document.getElementById("msg").style.display = "none";
    passConf.style.borderColor = 'green';
  }
};

passConf.onkeyup = function () {
  if (passConf.value != myPass.value) {
    document.getElementById("msg").style.display = "block";
    passConf.style.borderColor = 'red';
  } else {
    document.getElementById("msg").style.display = "none";
    passConf.style.borderColor = 'green';
  }

  if (passConf.value == '') {
    document.getElementById("msg").style.display = "block";
    passConf.style.borderColor = 'red';
  }
};

/***/ }),

/***/ "./resources/sass/app.scss":
/*!*********************************!*\
  !*** ./resources/sass/app.scss ***!
  \*********************************/
/*! no static exports found */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),

/***/ "./resources/sass/sb-admin-2.scss":
/*!****************************************!*\
  !*** ./resources/sass/sb-admin-2.scss ***!
  \****************************************/
/*! no static exports found */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),

/***/ 0:
/*!********************************************************************************************************************!*\
  !*** multi ./resources/js/custom/password_validator.js ./resources/sass/app.scss ./resources/sass/sb-admin-2.scss ***!
  \********************************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

__webpack_require__(/*! C:\Users\Mig\Desktop\fortify\resources\js\custom\password_validator.js */"./resources/js/custom/password_validator.js");
__webpack_require__(/*! C:\Users\Mig\Desktop\fortify\resources\sass\app.scss */"./resources/sass/app.scss");
module.exports = __webpack_require__(/*! C:\Users\Mig\Desktop\fortify\resources\sass\sb-admin-2.scss */"./resources/sass/sb-admin-2.scss");


/***/ })

/******/ });