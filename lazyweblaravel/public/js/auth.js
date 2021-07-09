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

/* ----------------------------- Login / Logout ----------------------------- */

/**
 *
 * @param {String} csrf
 * @param {String} accessToken
 * @param {String} provider
 * @param {String} redirectUrl
 */
window.authWithOauth2 = function (csrf, accessToken, provider, redirectUrl) {
  var authUri = '/auth/' + provider;
  fetch(authUri, {
    method: 'post',
    body: JSON.stringify({
      "accessToken": accessToken
    }),
    headers: {
      'Content-Type': 'application/json',
      'X-CSRF-TOKEN': csrf
    }
  }).then(function (response) {
    if (response.status === 200) {
      return response.json();
    }
  }).then(function (jsonData) {
    if (jsonData.authenticated == true) {
      window.location.href = redirectUrl;
    } else {
      window.alert(jsonData.error);
    }
  })["catch"](function (err) {
    console.error(err);
  });
};
/**
 * Login with username and password
 *
 * @param {String} csrf
 * @param {String} username
 * @param {String} password
 */


window.authWithUname = function (csrf, username, password, redirectUrl) {
  fetch('/auth', {
    method: 'post',
    body: JSON.stringify({
      "username": username,
      "password": password
    }),
    headers: {
      'Content-Type': 'application/json',
      'X-CSRF-TOKEN': csrf
    }
  }).then(function (response) {
    if (response.status === 200) {
      return response.json();
    }
  }).then(function (jsonData) {
    if (jsonData.authenticated == true) {
      window.location.href = redirectUrl;
    } else {
      window.alert(jsonData.error);
    }
  })["catch"](function (err) {
    console.error(err);
  });
};
/**
 * Logout
 *
 * @param {String} username
 * @param {String} password
 */


window.logout = function () {
  var config = {
    method: 'post',
    headers: {
      'Content-Type': 'application/json',
      'X-CSRF-TOKEN': csrf
    }
  };
  fetch('/logout', config).then(function (response) {
    if (response.status === 200) {
      return response.json();
    } else {
      window.alert("Logout Failed!");
    }
  }).then(function (jsonData) {
    window.location.reload(); //@Todo: Some logout verification message...
  })["catch"](function (err) {
    console.error(err);
  });
};
/* ------------------------------ Registration ------------------------------ */

/**
 * Send user registration request to the server.
 *
 * @param {String} csrf
 * @param {String} userInfo
 * @param {String} redirectUrl
 */


window.sendRegisterRequest = function (userInfo, redirectUrl) {
  var authUri = '/members/' + userInfo.username;
  var config = {
    method: 'post',
    body: JSON.stringify(userInfo),
    headers: {
      'Content-Type': 'application/json',
      'X-CSRF-TOKEN': csrf
    }
  };
  fetch(authUri, config).then(function (response) {
    if (response.status === 200) {
      return response.json();
    } else {
      window.alert("Registration Failed! Response Code: " + String(response.status));
    }
  }).then(function (jsonData) {
    if (jsonData.registered == true) {
      //window.alert("Successfully registered user!");
      window.location.href = '/email/verify';
    } else {
      window.alert(jsonData.error);
    }
  })["catch"](function (err) {
    console.error(err);
  });
};
/* ----------------------------- Cookie Handler ----------------------------- */

/**
 * Returns Cookie specified by key
 *
 * @param {String} key
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