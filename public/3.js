(window["webpackJsonp"] = window["webpackJsonp"] || []).push([[3],{

/***/ "./resources/js/common/api.service.js":
/*!********************************************!*\
  !*** ./resources/js/common/api.service.js ***!
  \********************************************/
/*! exports provided: default, OrganisationService, EventService, PollService */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "OrganisationService", function() { return OrganisationService; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "EventService", function() { return EventService; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "PollService", function() { return PollService; });
/* harmony import */ var vue__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! vue */ "./node_modules/vue/dist/vue.common.js");
/* harmony import */ var vue__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(vue__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var axios__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! axios */ "./node_modules/axios/index.js");
/* harmony import */ var axios__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(axios__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var vue_axios__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! vue-axios */ "./node_modules/vue-axios/dist/vue-axios.min.js");
/* harmony import */ var vue_axios__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(vue_axios__WEBPACK_IMPORTED_MODULE_2__);
/* harmony import */ var _auth_service__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./auth.service */ "./resources/js/common/auth.service.js");
/* harmony import */ var _config__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ./config */ "./resources/js/common/config.js");
function _defineProperty(obj, key, value) { if (key in obj) { Object.defineProperty(obj, key, { value: value, enumerable: true, configurable: true, writable: true }); } else { obj[key] = value; } return obj; }






var ApiService = {
  init: function init() {
    vue__WEBPACK_IMPORTED_MODULE_0___default.a.use(vue_axios__WEBPACK_IMPORTED_MODULE_2___default.a, axios__WEBPACK_IMPORTED_MODULE_1___default.a);
    vue__WEBPACK_IMPORTED_MODULE_0___default.a.axios.defaults.baseURL = "/api/v2/";
  },
  setHeader: function setHeader() {
    var csrfToken = document.head.querySelector('meta[name="csrf-token"]');

    if (csrfToken) {
      vue__WEBPACK_IMPORTED_MODULE_0___default.a.axios.defaults.headers.common['X-CSRF-TOKEN'] = csrfToken.content;
    }

    var authToken = _auth_service__WEBPACK_IMPORTED_MODULE_3__["default"].getToken();

    if (authToken && authToken !== "") {
      vue__WEBPACK_IMPORTED_MODULE_0___default.a.axios.defaults.headers.common['Authorization'] = "Bearer ".concat(authToken);
    }

    vue__WEBPACK_IMPORTED_MODULE_0___default.a.axios.defaults.headers.common['Accept'] = 'application/json';
    vue__WEBPACK_IMPORTED_MODULE_0___default.a.axios.defaults.headers.common['Content-Type'] = 'application/json';
    vue__WEBPACK_IMPORTED_MODULE_0___default.a.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
  },
  query: function query(resource, params) {
    return vue__WEBPACK_IMPORTED_MODULE_0___default.a.axios.get(resource, params)["catch"](function (error) {
      throw new Error("[MM] ApiService ".concat(error));
    });
  },
  get: function get(resource) {
    var slug = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : "";
    return vue__WEBPACK_IMPORTED_MODULE_0___default.a.axios.get("".concat(resource, "/").concat(slug))["catch"](function (error) {
      throw new Error("[MM] ApiService ".concat(error));
    });
  },
  post: function post(resource, params) {
    return vue__WEBPACK_IMPORTED_MODULE_0___default.a.axios.post("".concat(resource), params);
  },
  update: function update(resource, slug, params) {
    return vue__WEBPACK_IMPORTED_MODULE_0___default.a.axios.put("".concat(resource, "/").concat(slug), params);
  },
  put: function put(resource, params) {
    return vue__WEBPACK_IMPORTED_MODULE_0___default.a.axios.put("".concat(resource), params);
  },
  "delete": function _delete(resource) {
    return vue__WEBPACK_IMPORTED_MODULE_0___default.a.axios["delete"](resource)["catch"](function (error) {
      throw new Error("[MM] ApiService ".concat(error));
    });
  }
};
/* harmony default export */ __webpack_exports__["default"] = (ApiService);
var OrganisationService = _defineProperty({
  get: function get() {
    return ApiService.get("organisations");
  }
}, "get", function get(id) {
  return ApiService.get("organisations", id);
});
var EventService = {
  get: function get() {
    return ApiService.get("advEvents/keyed");
  }
};
var PollService = _defineProperty({
  get: function get() {
    return ApiService.get("polls");
  }
}, "get", function get(id) {
  return ApiService.get("polls", id);
});

/***/ }),

/***/ "./resources/js/common/auth.service.js":
/*!*********************************************!*\
  !*** ./resources/js/common/auth.service.js ***!
  \*********************************************/
/*! exports provided: getToken, saveToken, destroyToken, default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "getToken", function() { return getToken; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "saveToken", function() { return saveToken; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "destroyToken", function() { return destroyToken; });
var ID_TOKEN_KEY = "id_token";
var getToken = function getToken() {
  return window.localStorage.getItem(ID_TOKEN_KEY);
};
var saveToken = function saveToken(token) {
  window.localStorage.setItem(ID_TOKEN_KEY, token);
};
var destroyToken = function destroyToken() {
  window.localStorage.removeItem(ID_TOKEN_KEY);
};
/* harmony default export */ __webpack_exports__["default"] = ({
  getToken: getToken,
  saveToken: saveToken,
  destroyToken: destroyToken
});

/***/ }),

/***/ "./resources/js/common/config.js":
/*!***************************************!*\
  !*** ./resources/js/common/config.js ***!
  \***************************************/
/*! exports provided: API_URL, default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "API_URL", function() { return API_URL; });
var API_URL = "https://meinmoers.lambdadigamma.com/api/v2";
/* harmony default export */ __webpack_exports__["default"] = (API_URL);

/***/ }),

/***/ "./resources/js/store/actions.type.js":
/*!********************************************!*\
  !*** ./resources/js/store/actions.type.js ***!
  \********************************************/
/*! exports provided: CHECK_AUTH, LOGIN, LOGOUT, REGISTER, UPDATE_USER, FETCH_ORGANISATIONS, FETCH_ORGANISATION, FETCH_EVENTS, FETCH_POLLS, FETCH_POLL */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "CHECK_AUTH", function() { return CHECK_AUTH; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "LOGIN", function() { return LOGIN; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "LOGOUT", function() { return LOGOUT; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "REGISTER", function() { return REGISTER; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "UPDATE_USER", function() { return UPDATE_USER; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "FETCH_ORGANISATIONS", function() { return FETCH_ORGANISATIONS; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "FETCH_ORGANISATION", function() { return FETCH_ORGANISATION; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "FETCH_EVENTS", function() { return FETCH_EVENTS; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "FETCH_POLLS", function() { return FETCH_POLLS; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "FETCH_POLL", function() { return FETCH_POLL; });
/* Module: Auth */
var CHECK_AUTH = "checkAuth";
var LOGIN = "login";
var LOGOUT = "logout";
var REGISTER = "register";
var UPDATE_USER = "updateUser";
/* Module: Organisations */

var FETCH_ORGANISATIONS = "fetchOrganisations";
/* Module: Organisation */

var FETCH_ORGANISATION = "fetchOrganisation";
/* Module: Events */

var FETCH_EVENTS = "fetchEvents";
/* Module: Polls */

var FETCH_POLLS = "fetchPolls";
/* Module: Poll */

var FETCH_POLL = "fetchPoll";

/***/ }),

/***/ "./resources/js/store/index.js":
/*!*************************************!*\
  !*** ./resources/js/store/index.js ***!
  \*************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var vue__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! vue */ "./node_modules/vue/dist/vue.common.js");
/* harmony import */ var vue__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(vue__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var vuex__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! vuex */ "./node_modules/vuex/dist/vuex.esm.js");
/* harmony import */ var _modules_auth_module__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./modules/auth.module */ "./resources/js/store/modules/auth.module.js");
/* harmony import */ var _modules_organisations_module__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./modules/organisations.module */ "./resources/js/store/modules/organisations.module.js");
/* harmony import */ var _modules_organisation_module__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ./modules/organisation.module */ "./resources/js/store/modules/organisation.module.js");
/* harmony import */ var _modules_events_module__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! ./modules/events.module */ "./resources/js/store/modules/events.module.js");
/* harmony import */ var _modules_polls_module__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__(/*! ./modules/polls.module */ "./resources/js/store/modules/polls.module.js");
/* harmony import */ var _modules_poll_module__WEBPACK_IMPORTED_MODULE_7__ = __webpack_require__(/*! ./modules/poll.module */ "./resources/js/store/modules/poll.module.js");








vue__WEBPACK_IMPORTED_MODULE_0___default.a.use(vuex__WEBPACK_IMPORTED_MODULE_1__["default"]);
/* harmony default export */ __webpack_exports__["default"] = (new vuex__WEBPACK_IMPORTED_MODULE_1__["default"].Store({
  modules: {
    auth: _modules_auth_module__WEBPACK_IMPORTED_MODULE_2__["default"],
    organisations: _modules_organisations_module__WEBPACK_IMPORTED_MODULE_3__["default"],
    organisation: _modules_organisation_module__WEBPACK_IMPORTED_MODULE_4__["default"],
    events: _modules_events_module__WEBPACK_IMPORTED_MODULE_5__["default"],
    polls: _modules_polls_module__WEBPACK_IMPORTED_MODULE_6__["default"],
    poll: _modules_poll_module__WEBPACK_IMPORTED_MODULE_7__["default"]
  }
}));

/***/ }),

/***/ "./resources/js/store/modules/auth.module.js":
/*!***************************************************!*\
  !*** ./resources/js/store/modules/auth.module.js ***!
  \***************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _common_api_service__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../../common/api.service */ "./resources/js/common/api.service.js");
/* harmony import */ var _common_auth_service__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ../../common/auth.service */ "./resources/js/common/auth.service.js");
/* harmony import */ var _actions_type__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../actions.type */ "./resources/js/store/actions.type.js");
/* harmony import */ var _mutations_type__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ../mutations.type */ "./resources/js/store/mutations.type.js");
var _actions, _mutations;

function _defineProperty(obj, key, value) { if (key in obj) { Object.defineProperty(obj, key, { value: value, enumerable: true, configurable: true, writable: true }); } else { obj[key] = value; } return obj; }





var state = {
  errors: null,
  user: {},
  isAuthenticated: !!_common_auth_service__WEBPACK_IMPORTED_MODULE_1__["default"].getToken()
};
var getters = {
  currentUser: function currentUser(state) {
    return state.user;
  },
  isAuthenticated: function isAuthenticated(state) {
    return state.isAuthenticated;
  }
};
var actions = (_actions = {}, _defineProperty(_actions, _actions_type__WEBPACK_IMPORTED_MODULE_2__["LOGIN"], function (context, credentials) {
  return new Promise(function (resolve, reject) {
    _common_api_service__WEBPACK_IMPORTED_MODULE_0__["default"].post("auth/login", credentials).then(function (_ref) {
      var data = _ref.data;
      context.commit(_mutations_type__WEBPACK_IMPORTED_MODULE_3__["SET_AUTH"], data);
      resolve(data);
    })["catch"](function (_ref2) {
      var response = _ref2.response;
      context.commit(_mutations_type__WEBPACK_IMPORTED_MODULE_3__["SET_ERROR"], response.data.errors);
      reject(response.data.errors);
    });
  });
}), _defineProperty(_actions, _actions_type__WEBPACK_IMPORTED_MODULE_2__["LOGOUT"], function (context) {
  context.commit(_mutations_type__WEBPACK_IMPORTED_MODULE_3__["PURGE_AUTH"]);
}), _defineProperty(_actions, _actions_type__WEBPACK_IMPORTED_MODULE_2__["REGISTER"], function (context, credentials) {
  return new Promise(function (resolve, reject) {
    _common_api_service__WEBPACK_IMPORTED_MODULE_0__["default"].post("users", {
      user: credentials
    }).then(function (_ref3) {
      var data = _ref3.data;
      context.commit(_mutations_type__WEBPACK_IMPORTED_MODULE_3__["SET_AUTH"], data.user);
      resolve(data);
    })["catch"](function (_ref4) {
      var response = _ref4.response;
      context.commit(_mutations_type__WEBPACK_IMPORTED_MODULE_3__["SET_ERROR"], response.data.errors);
      reject(response);
    });
  });
}), _defineProperty(_actions, _actions_type__WEBPACK_IMPORTED_MODULE_2__["CHECK_AUTH"], function (context) {
  if (_common_auth_service__WEBPACK_IMPORTED_MODULE_1__["default"].getToken()) {
    _common_api_service__WEBPACK_IMPORTED_MODULE_0__["default"].setHeader();
    _common_api_service__WEBPACK_IMPORTED_MODULE_0__["default"].get("auth/user").then(function (_ref5) {
      var data = _ref5.data;
      context.commit(_mutations_type__WEBPACK_IMPORTED_MODULE_3__["SET_USER"], data);
    })["catch"](function (_ref6) {
      var response = _ref6.response;
      context.commit(_mutations_type__WEBPACK_IMPORTED_MODULE_3__["SET_ERROR"], response.data.errors);
    });
  } else {
    context.commit(_mutations_type__WEBPACK_IMPORTED_MODULE_3__["PURGE_AUTH"]);
  }
}), _defineProperty(_actions, _actions_type__WEBPACK_IMPORTED_MODULE_2__["UPDATE_USER"], function (context, payload) {
  var email = payload.email,
      username = payload.username,
      password = payload.password;
  var user = {
    email: email,
    username: username
  };

  if (password) {
    user.password = password;
  }

  return _common_api_service__WEBPACK_IMPORTED_MODULE_0__["default"].put("user", user).then(function (_ref7) {
    var data = _ref7.data;
    context.commit(_mutations_type__WEBPACK_IMPORTED_MODULE_3__["SET_AUTH"], data.user);
    return data;
  });
}), _actions);
var mutations = (_mutations = {}, _defineProperty(_mutations, _mutations_type__WEBPACK_IMPORTED_MODULE_3__["SET_ERROR"], function (state, error) {
  state.errors = error;
}), _defineProperty(_mutations, _mutations_type__WEBPACK_IMPORTED_MODULE_3__["SET_AUTH"], function (state, data) {
  state.isAuthenticated = true;
  state.user = data;
  state.errors = {};
  _common_auth_service__WEBPACK_IMPORTED_MODULE_1__["default"].saveToken(data.token);
}), _defineProperty(_mutations, _mutations_type__WEBPACK_IMPORTED_MODULE_3__["SET_USER"], function (state, data) {
  state.user = data;
  state.errors = {};
}), _defineProperty(_mutations, _mutations_type__WEBPACK_IMPORTED_MODULE_3__["PURGE_AUTH"], function (state) {
  state.isAuthenticated = false;
  state.user = {};
  state.errors = {};
  _common_auth_service__WEBPACK_IMPORTED_MODULE_1__["default"].destroyToken();
}), _mutations);
/* harmony default export */ __webpack_exports__["default"] = ({
  state: state,
  actions: actions,
  mutations: mutations,
  getters: getters
});

/***/ }),

/***/ "./resources/js/store/modules/events.module.js":
/*!*****************************************************!*\
  !*** ./resources/js/store/modules/events.module.js ***!
  \*****************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _common_api_service__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../../common/api.service */ "./resources/js/common/api.service.js");
/* harmony import */ var _actions_type__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ../actions.type */ "./resources/js/store/actions.type.js");
/* harmony import */ var _mutations_type__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../mutations.type */ "./resources/js/store/mutations.type.js");
function _defineProperty(obj, key, value) { if (key in obj) { Object.defineProperty(obj, key, { value: value, enumerable: true, configurable: true, writable: true }); } else { obj[key] = value; } return obj; }




var state = {
  events: [],
  isLoadingEvents: true
};
var getters = {
  events: function events(state) {
    return state.events;
  },
  isLoadingEvents: function isLoadingEvents(state) {
    return state.isLoadingEvents;
  }
};

var actions = _defineProperty({}, _actions_type__WEBPACK_IMPORTED_MODULE_1__["FETCH_EVENTS"], function (_ref) {
  var commit = _ref.commit;
  return _common_api_service__WEBPACK_IMPORTED_MODULE_0__["EventService"].get().then(function (_ref2) {
    var data = _ref2.data;
    commit(_mutations_type__WEBPACK_IMPORTED_MODULE_2__["SET_EVENTS"], data);
  })["catch"](function (error) {
    throw new Error(error);
  });
});

var mutations = _defineProperty({}, _mutations_type__WEBPACK_IMPORTED_MODULE_2__["SET_EVENTS"], function (state, events) {
  state.events = events;
  state.isLoadingEvents = false;
});

/* harmony default export */ __webpack_exports__["default"] = ({
  state: state,
  getters: getters,
  actions: actions,
  mutations: mutations
});

/***/ }),

/***/ "./resources/js/store/modules/organisation.module.js":
/*!***********************************************************!*\
  !*** ./resources/js/store/modules/organisation.module.js ***!
  \***********************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @babel/runtime/regenerator */ "./node_modules/@babel/runtime/regenerator/index.js");
/* harmony import */ var _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _common_api_service__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ../../common/api.service */ "./resources/js/common/api.service.js");
/* harmony import */ var _actions_type__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../actions.type */ "./resources/js/store/actions.type.js");
/* harmony import */ var _mutations_type__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ../mutations.type */ "./resources/js/store/mutations.type.js");


function _defineProperty(obj, key, value) { if (key in obj) { Object.defineProperty(obj, key, { value: value, enumerable: true, configurable: true, writable: true }); } else { obj[key] = value; } return obj; }

function asyncGeneratorStep(gen, resolve, reject, _next, _throw, key, arg) { try { var info = gen[key](arg); var value = info.value; } catch (error) { reject(error); return; } if (info.done) { resolve(value); } else { Promise.resolve(value).then(_next, _throw); } }

function _asyncToGenerator(fn) { return function () { var self = this, args = arguments; return new Promise(function (resolve, reject) { var gen = fn.apply(self, args); function _next(value) { asyncGeneratorStep(gen, resolve, reject, _next, _throw, "next", value); } function _throw(err) { asyncGeneratorStep(gen, resolve, reject, _next, _throw, "throw", err); } _next(undefined); }); }; }




var state = {
  organisation: {}
};
var getters = {
  organisation: function organisation() {
    return state.organisation;
  }
};

var actions = _defineProperty({}, _actions_type__WEBPACK_IMPORTED_MODULE_2__["FETCH_ORGANISATION"], function () {
  var _ref = _asyncToGenerator(
  /*#__PURE__*/
  _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default.a.mark(function _callee(context, id) {
    var _ref2, data;

    return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default.a.wrap(function _callee$(_context) {
      while (1) {
        switch (_context.prev = _context.next) {
          case 0:
            _context.next = 2;
            return _common_api_service__WEBPACK_IMPORTED_MODULE_1__["OrganisationService"].get(id);

          case 2:
            _ref2 = _context.sent;
            data = _ref2.data;
            context.commit(_mutations_type__WEBPACK_IMPORTED_MODULE_3__["SET_ORGANISATION"], data);
            return _context.abrupt("return", data);

          case 6:
          case "end":
            return _context.stop();
        }
      }
    }, _callee);
  }));

  return function (_x, _x2) {
    return _ref.apply(this, arguments);
  };
}());

var mutations = _defineProperty({}, _mutations_type__WEBPACK_IMPORTED_MODULE_3__["SET_ORGANISATION"], function (state, organisation) {
  state.organisation = organisation;
});

/* harmony default export */ __webpack_exports__["default"] = ({
  state: state,
  getters: getters,
  actions: actions,
  mutations: mutations
});

/***/ }),

/***/ "./resources/js/store/modules/organisations.module.js":
/*!************************************************************!*\
  !*** ./resources/js/store/modules/organisations.module.js ***!
  \************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _common_api_service__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../../common/api.service */ "./resources/js/common/api.service.js");
/* harmony import */ var _actions_type__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ../actions.type */ "./resources/js/store/actions.type.js");
/* harmony import */ var _mutations_type__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../mutations.type */ "./resources/js/store/mutations.type.js");
function _defineProperty(obj, key, value) { if (key in obj) { Object.defineProperty(obj, key, { value: value, enumerable: true, configurable: true, writable: true }); } else { obj[key] = value; } return obj; }




var state = {
  organisations: [],
  isLoading: true
};
var getters = {
  organisations: function organisations(state) {
    return state.organisations;
  },
  isLoading: function isLoading(state) {
    return state.isLoading;
  }
};

var actions = _defineProperty({}, _actions_type__WEBPACK_IMPORTED_MODULE_1__["FETCH_ORGANISATIONS"], function (_ref) {
  var commit = _ref.commit;
  return _common_api_service__WEBPACK_IMPORTED_MODULE_0__["OrganisationService"].get().then(function (_ref2) {
    var data = _ref2.data;
    commit(_mutations_type__WEBPACK_IMPORTED_MODULE_2__["SET_ORGANISATIONS"], data);
  })["catch"](function (error) {
    throw new Error(error);
  });
});

var mutations = _defineProperty({}, _mutations_type__WEBPACK_IMPORTED_MODULE_2__["SET_ORGANISATIONS"], function (state, organisations) {
  state.organisations = organisations;
  state.isLoading = false;
});

/* harmony default export */ __webpack_exports__["default"] = ({
  state: state,
  getters: getters,
  actions: actions,
  mutations: mutations
});

/***/ }),

/***/ "./resources/js/store/modules/poll.module.js":
/*!***************************************************!*\
  !*** ./resources/js/store/modules/poll.module.js ***!
  \***************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @babel/runtime/regenerator */ "./node_modules/@babel/runtime/regenerator/index.js");
/* harmony import */ var _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _common_api_service__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ../../common/api.service */ "./resources/js/common/api.service.js");
/* harmony import */ var _actions_type__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../actions.type */ "./resources/js/store/actions.type.js");
/* harmony import */ var _mutations_type__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ../mutations.type */ "./resources/js/store/mutations.type.js");


function _defineProperty(obj, key, value) { if (key in obj) { Object.defineProperty(obj, key, { value: value, enumerable: true, configurable: true, writable: true }); } else { obj[key] = value; } return obj; }

function asyncGeneratorStep(gen, resolve, reject, _next, _throw, key, arg) { try { var info = gen[key](arg); var value = info.value; } catch (error) { reject(error); return; } if (info.done) { resolve(value); } else { Promise.resolve(value).then(_next, _throw); } }

function _asyncToGenerator(fn) { return function () { var self = this, args = arguments; return new Promise(function (resolve, reject) { var gen = fn.apply(self, args); function _next(value) { asyncGeneratorStep(gen, resolve, reject, _next, _throw, "next", value); } function _throw(err) { asyncGeneratorStep(gen, resolve, reject, _next, _throw, "throw", err); } _next(undefined); }); }; }




var state = {
  poll: {},
  isLoadingPoll: true
};
var getters = {
  poll: function poll() {
    return state.poll;
  },
  isLoadingPoll: function isLoadingPoll(state) {
    return state.isLoadingPoll;
  }
};

var actions = _defineProperty({}, _actions_type__WEBPACK_IMPORTED_MODULE_2__["FETCH_POLL"], function () {
  var _ref = _asyncToGenerator(
  /*#__PURE__*/
  _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default.a.mark(function _callee(context, id) {
    var _ref2, data;

    return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default.a.wrap(function _callee$(_context) {
      while (1) {
        switch (_context.prev = _context.next) {
          case 0:
            _context.next = 2;
            return _common_api_service__WEBPACK_IMPORTED_MODULE_1__["PollService"].get(id);

          case 2:
            _ref2 = _context.sent;
            data = _ref2.data;
            context.commit(_mutations_type__WEBPACK_IMPORTED_MODULE_3__["SET_POLL"], data);
            return _context.abrupt("return", data);

          case 6:
          case "end":
            return _context.stop();
        }
      }
    }, _callee);
  }));

  return function (_x, _x2) {
    return _ref.apply(this, arguments);
  };
}());

var mutations = _defineProperty({}, _mutations_type__WEBPACK_IMPORTED_MODULE_3__["SET_POLL"], function (state, poll) {
  state.isLoadingPoll = false;
  state.poll = poll;
});

/* harmony default export */ __webpack_exports__["default"] = ({
  state: state,
  getters: getters,
  actions: actions,
  mutations: mutations
});

/***/ }),

/***/ "./resources/js/store/modules/polls.module.js":
/*!****************************************************!*\
  !*** ./resources/js/store/modules/polls.module.js ***!
  \****************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _common_api_service__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../../common/api.service */ "./resources/js/common/api.service.js");
/* harmony import */ var _actions_type__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ../actions.type */ "./resources/js/store/actions.type.js");
/* harmony import */ var _mutations_type__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../mutations.type */ "./resources/js/store/mutations.type.js");
function _defineProperty(obj, key, value) { if (key in obj) { Object.defineProperty(obj, key, { value: value, enumerable: true, configurable: true, writable: true }); } else { obj[key] = value; } return obj; }




var state = {
  polls: [],
  isLoadingPolls: true
};
var getters = {
  polls: function polls(state) {
    return state.polls;
  },
  isLoadingPolls: function isLoadingPolls(state) {
    return state.isLoadingPolls;
  }
};

var actions = _defineProperty({}, _actions_type__WEBPACK_IMPORTED_MODULE_1__["FETCH_POLLS"], function (_ref) {
  var commit = _ref.commit;
  return _common_api_service__WEBPACK_IMPORTED_MODULE_0__["PollService"].get().then(function (_ref2) {
    var data = _ref2.data;
    commit(_mutations_type__WEBPACK_IMPORTED_MODULE_2__["SET_POLLS"], data);
  })["catch"](function (error) {
    throw new Error(error);
  });
});

var mutations = _defineProperty({}, _mutations_type__WEBPACK_IMPORTED_MODULE_2__["SET_POLLS"], function (state, polls) {
  state.polls = polls;
  state.isLoadingPolls = false;
});

/* harmony default export */ __webpack_exports__["default"] = ({
  state: state,
  getters: getters,
  actions: actions,
  mutations: mutations
});

/***/ }),

/***/ "./resources/js/store/mutations.type.js":
/*!**********************************************!*\
  !*** ./resources/js/store/mutations.type.js ***!
  \**********************************************/
/*! exports provided: RESET_STATE, SET_ERROR, FETCH_EVENTS_START, PURGE_AUTH, SET_AUTH, SET_USER, SET_ORGANISATIONS, SET_ORGANISATION, SET_EVENTS, SET_POLLS, SET_POLL */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "RESET_STATE", function() { return RESET_STATE; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "SET_ERROR", function() { return SET_ERROR; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "FETCH_EVENTS_START", function() { return FETCH_EVENTS_START; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "PURGE_AUTH", function() { return PURGE_AUTH; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "SET_AUTH", function() { return SET_AUTH; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "SET_USER", function() { return SET_USER; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "SET_ORGANISATIONS", function() { return SET_ORGANISATIONS; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "SET_ORGANISATION", function() { return SET_ORGANISATION; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "SET_EVENTS", function() { return SET_EVENTS; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "SET_POLLS", function() { return SET_POLLS; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "SET_POLL", function() { return SET_POLL; });
var RESET_STATE = "resetModuleState";
var SET_ERROR = "setError";
var FETCH_EVENTS_START = "setLoading";
/* Module: Auth */

var PURGE_AUTH = "logOut";
var SET_AUTH = "setToken";
var SET_USER = "setUser";
/* Module: Organisations */

var SET_ORGANISATIONS = "setOrganisations";
/* Module: Organisation */

var SET_ORGANISATION = "setOrganisation";
/* Module: Events */

var SET_EVENTS = "setEvents";
/* Module: Polls */

var SET_POLLS = "setPolls";
/* Module: Poll */

var SET_POLL = "setPoll";

/***/ })

}]);