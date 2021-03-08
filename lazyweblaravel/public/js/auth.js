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
/******/ 	return __webpack_require__(__webpack_require__.s = 1);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./resources/js/auth.js":
/*!******************************!*\
  !*** ./resources/js/auth.js ***!
  \******************************/
/*! no static exports found */
/***/ (function(module, exports) {

/* -------------------------------------------------------------------------- */

/*                               Login Functions                              */

/* -------------------------------------------------------------------------- */

/**
 *  Todo
 * @param {*} csrf
 * @param {*} token
 * @param {*} authenticator
 */
window.authWithOauth2 = function (csrf, accessToken, provider, redirectUrl) {
  /* Sign in and return to previous url on success. */
  var loginRequest = new XMLHttpRequest();
  var authUri = '/auth/' + provider;
  console.log(accessToken);
  console.log(authUri);
  loginRequest.open('POST', authUri, true);
  loginRequest.setRequestHeader('Content-Type', 'application/json');
  loginRequest.setRequestHeader('X-CSRF-TOKEN', csrf);

  loginRequest.onload = function () {
    console.log(loginRequest.responseText);
    /*
    if (response.authenticated == true) {
        console.log("Successfully authenticated by LazyWeb!");
        window.location.href = redirectUrl;
    }
    else {
        console.log("Login Failed!");
    }
    */
  };

  loginRequest.send(JSON.stringify({
    "accessToken": accessToken
  }));
};
/**
 * Login with username and password
 *
 * @param {*} csrf
 * @param {*} username
 * @param {*} password
 */


window.authWithUname = function (csrf, username, password, redirectUrl) {
  /* Sign in and return to previous url on success. */
  var loginRequest = new XMLHttpRequest();
  loginRequest.open('POST', '/auth', true);
  loginRequest.setRequestHeader('Content-Type', 'application/json');
  loginRequest.setRequestHeader('X-CSRF-TOKEN', csrf);

  loginRequest.onload = function () {
    console.log(loginRequest.responseText);
    var response = JSON.parse(loginRequest.responseText);

    if (response.authenticated == true) {
      console.log("Successfully authenticated by LazyWeb!");
      window.location.href = redirectUrl;
    } else {
      console.log("Login Failed!");
    }
  };

  loginRequest.send(JSON.stringify({
    "username": username,
    "password": password
  }));
};
/* -------------------------------------------------------------------------- */

/*                          Cookie Handler Functions                          */

/* -------------------------------------------------------------------------- */

/**
 * Returns Cookie specified by key
 *
 * @param {*} key
 */


window.getCookie = function (key) {
  cookies = decodeURIComponent(document.cookie).split(';');

  for (var i = 0; i < cookies.length; i++) {
    cookie_item = cookies[i].trim();

    if (cookie_item.includes(String(key))) {
      result = cookie_item.split(String(key)).trim();
    }
  }

  return result;
};

/***/ }),

/***/ 1:
/*!************************************!*\
  !*** multi ./resources/js/auth.js ***!
  \************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! C:\Users\Jihoon Lee\Desktop\LazyWeb\lazyweblaravel\resources\js\auth.js */"./resources/js/auth.js");


/***/ })

/******/ });