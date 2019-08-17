(window["webpackJsonp"] = window["webpackJsonp"] || []).push([[9],{

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/views/Poll/CreatePoll.vue?vue&type=script&lang=js&":
/*!*********************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/views/Poll/CreatePoll.vue?vue&type=script&lang=js& ***!
  \*********************************************************************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var vuex__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! vuex */ "./node_modules/vuex/dist/vuex.esm.js");
/* harmony import */ var _store__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ../../store */ "./resources/js/store/index.js");
/* harmony import */ var _core_Form__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../core/Form */ "./resources/js/core/Form.js");
/* harmony import */ var _store_actions_type__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ../../store/actions.type */ "./resources/js/store/actions.type.js");
function ownKeys(object, enumerableOnly) { var keys = Object.keys(object); if (Object.getOwnPropertySymbols) { var symbols = Object.getOwnPropertySymbols(object); if (enumerableOnly) symbols = symbols.filter(function (sym) { return Object.getOwnPropertyDescriptor(object, sym).enumerable; }); keys.push.apply(keys, symbols); } return keys; }

function _objectSpread(target) { for (var i = 1; i < arguments.length; i++) { var source = arguments[i] != null ? arguments[i] : {}; if (i % 2) { ownKeys(source, true).forEach(function (key) { _defineProperty(target, key, source[key]); }); } else if (Object.getOwnPropertyDescriptors) { Object.defineProperties(target, Object.getOwnPropertyDescriptors(source)); } else { ownKeys(source).forEach(function (key) { Object.defineProperty(target, key, Object.getOwnPropertyDescriptor(source, key)); }); } } return target; }

function _defineProperty(obj, key, value) { if (key in obj) { Object.defineProperty(obj, key, { value: value, enumerable: true, configurable: true, writable: true }); } else { obj[key] = value; } return obj; }

//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//




/* harmony default export */ __webpack_exports__["default"] = ({
  name: "CreatePoll",
  data: function data() {
    return {
      form: new _core_Form__WEBPACK_IMPORTED_MODULE_2__["default"]({
        question: null,
        description: null,
        group_id: null,
        max_check: 1,
        options: ['', '']
      })
    };
  },
  computed: _objectSpread({}, Object(vuex__WEBPACK_IMPORTED_MODULE_0__["mapGetters"])(["isAuthenticated", "currentUser"]), {
    canDelete: function canDelete() {
      return this.form.options.length > 2;
    },
    groupOptions: function groupOptions() {
      if (this.currentUser.groups !== undefined) {
        // TODO: Implement Conditions for Groups
        return this.currentUser.groups.filter(function (group) {
          return _store__WEBPACK_IMPORTED_MODULE_1__["ability"].can('create-poll', 'Poll');
        }).map(function (group) {
          return {
            value: group.id,
            text: group.name
          };
        });
      }
    },
    isSubmitEnabled: function isSubmitEnabled() {
      if (this.form.question === null || this.form.question === "") {
        return false;
      }

      if (this.form.description === null || this.form.description === "") {
        return false;
      }

      if (this.form.group_id === null) {
        return false;
      }

      if (this.form.max_check < 1 || this.form.max_check >= this.form.options.length) {
        return false;
      }

      for (var i = 0; i < this.form.options.length; i++) {
        if (this.form.options[i] === '') {
          return false;
        }
      }

      return true;
    }
  }),
  methods: {
    addPollOption: function addPollOption() {
      this.form.options.push('');
    },
    deletePollOption: function deletePollOption(index) {
      this.form.options.splice(index, 1);
    },
    submit: function submit() {
      var _this = this;

      var payload = this.form.data();
      var storeRequest = this.$store.dispatch(_store_actions_type__WEBPACK_IMPORTED_MODULE_3__["STORE_POLL"], payload);
      storeRequest.then(function () {
        _this.$router.push({
          name: "polls"
        });
      });
      storeRequest["catch"](function (errors) {});
      this.form.submit(storeRequest);
    }
  }
});

/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/views/Poll/CreatePoll.vue?vue&type=template&id=e4419608&scoped=true&":
/*!*************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/views/Poll/CreatePoll.vue?vue&type=template&id=e4419608&scoped=true& ***!
  \*************************************************************************************************************************************************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "render", function() { return render; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return staticRenderFns; });
var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c(
    "div",
    [
      _c(
        "can",
        { attrs: { I: "create-poll", a: "Poll" } },
        [
          _c(
            "b-card",
            {
              staticClass: "my-4",
              attrs: { "bg-variant": "secondary", "text-variant": "black" }
            },
            [
              _c("div", { staticClass: "d-flex justify-content-between" }, [
                _c("h3", { staticClass: "m-0" }, [
                  _vm._v("Abstimmung erstellen")
                ])
              ])
            ]
          ),
          _vm._v(" "),
          _c(
            "b-card",
            { staticClass: "mt-3" },
            [
              _c(
                "b-form",
                {
                  on: {
                    submit: function($event) {
                      $event.preventDefault()
                      return _vm.submit()
                    },
                    keydown: function($event) {
                      return _vm.form.errors.clear($event.target.name)
                    }
                  }
                },
                [
                  _c(
                    "b-form-group",
                    {
                      attrs: {
                        id: "question-group",
                        label: "Frage:",
                        "label-for": "question"
                      }
                    },
                    [
                      _c("b-form-input", {
                        attrs: {
                          id: "question",
                          required: "",
                          placeholder: "Gib die Frage der Abstimmung ein."
                        },
                        model: {
                          value: _vm.form.question,
                          callback: function($$v) {
                            _vm.$set(_vm.form, "question", $$v)
                          },
                          expression: "form.question"
                        }
                      }),
                      _vm._v(" "),
                      _c("b-form-invalid-feedback", {
                        attrs: {
                          "force-show": _vm.form.errors.has("question")
                        },
                        domProps: {
                          textContent: _vm._s(_vm.form.errors.get("question"))
                        }
                      })
                    ],
                    1
                  ),
                  _vm._v(" "),
                  _c(
                    "b-form-group",
                    {
                      attrs: {
                        id: "description-group",
                        label: "Beschreibung:",
                        "label-for": "description"
                      }
                    },
                    [
                      _c("b-form-textarea", {
                        attrs: {
                          id: "description",
                          rows: "3",
                          placeholder:
                            "Füge eine Beschreibung für die Abstimmung hinzu."
                        },
                        model: {
                          value: _vm.form.description,
                          callback: function($$v) {
                            _vm.$set(_vm.form, "description", $$v)
                          },
                          expression: "form.description"
                        }
                      }),
                      _vm._v(" "),
                      _c("b-form-invalid-feedback", {
                        attrs: {
                          "force-show": _vm.form.errors.has("description")
                        },
                        domProps: {
                          textContent: _vm._s(
                            _vm.form.errors.get("description")
                          )
                        }
                      })
                    ],
                    1
                  ),
                  _vm._v(" "),
                  _c(
                    "b-form-group",
                    {
                      attrs: {
                        id: "group-group",
                        label: "Gruppe für die Abstimmung:",
                        "label-for": "group"
                      }
                    },
                    [
                      _c("b-form-select", {
                        attrs: { id: "group", options: _vm.groupOptions },
                        model: {
                          value: _vm.form.group_id,
                          callback: function($$v) {
                            _vm.$set(_vm.form, "group_id", $$v)
                          },
                          expression: "form.group_id"
                        }
                      }),
                      _vm._v(" "),
                      _c("b-form-invalid-feedback", {
                        attrs: {
                          "force-show": _vm.form.errors.has("group_id")
                        },
                        domProps: {
                          textContent: _vm._s(_vm.form.errors.get("group_id"))
                        }
                      })
                    ],
                    1
                  ),
                  _vm._v(" "),
                  _c(
                    "b-form-group",
                    {
                      attrs: {
                        id: "max_check-group",
                        label: "Anzahl der auswählbaren Antworten:",
                        "label-for": "max_check"
                      }
                    },
                    [
                      _c("b-form-input", {
                        attrs: {
                          id: "max_check",
                          type: "number",
                          min: "1",
                          step: 1
                        },
                        model: {
                          value: _vm.form.max_check,
                          callback: function($$v) {
                            _vm.$set(_vm.form, "max_check", $$v)
                          },
                          expression: "form.max_check"
                        }
                      }),
                      _vm._v(" "),
                      _c("b-form-invalid-feedback", {
                        attrs: {
                          "force-show": _vm.form.errors.has("max_check")
                        },
                        domProps: {
                          textContent: _vm._s(_vm.form.errors.get("max_check"))
                        }
                      })
                    ],
                    1
                  ),
                  _vm._v(" "),
                  _c(
                    "b-form-group",
                    { attrs: { label: "Antwortmöglichkeiten:" } },
                    [
                      _vm._l(_vm.form.options, function(option, index) {
                        return _c(
                          "b-card",
                          {
                            key: index,
                            staticClass: "mb-2",
                            attrs: { "bg-variant": "secondary" }
                          },
                          [
                            _c(
                              "div",
                              { staticClass: "d-flex" },
                              [
                                _c("b-input", {
                                  attrs: {
                                    placeholder:
                                      "Titel der Antwortmöglichkeit eingeben."
                                  },
                                  model: {
                                    value: _vm.form.options[index],
                                    callback: function($$v) {
                                      _vm.$set(_vm.form.options, index, $$v)
                                    },
                                    expression: "form.options[index]"
                                  }
                                }),
                                _vm._v(" "),
                                _vm.canDelete
                                  ? _c(
                                      "b-button",
                                      {
                                        staticClass: "ml-3",
                                        attrs: { variant: "danger" },
                                        on: {
                                          click: function($event) {
                                            return _vm.deletePollOption(index)
                                          }
                                        }
                                      },
                                      [_vm._v("Löschen")]
                                    )
                                  : _vm._e()
                              ],
                              1
                            )
                          ]
                        )
                      }),
                      _vm._v(" "),
                      _c("b-form-invalid-feedback", {
                        attrs: { "force-show": _vm.form.errors.has("options") },
                        domProps: {
                          textContent: _vm._s(_vm.form.errors.get("questions"))
                        }
                      }),
                      _vm._v(" "),
                      _c(
                        "div",
                        { staticClass: "d-flex justify-content-end mt-4" },
                        [
                          _c(
                            "b-button",
                            {
                              attrs: { variant: "primary" },
                              on: { click: _vm.addPollOption }
                            },
                            [_vm._v("Weitere Antwortmöglichkeit hinzufügen")]
                          )
                        ],
                        1
                      )
                    ],
                    2
                  ),
                  _vm._v(" "),
                  _c("b-alert", {
                    staticClass: "mt-2 mb-4",
                    attrs: {
                      show: _vm.form.errors.has("common"),
                      variant: "danger"
                    },
                    domProps: {
                      textContent: _vm._s(_vm.form.errors.get("common"))
                    }
                  }),
                  _vm._v(" "),
                  _c(
                    "b-button",
                    {
                      attrs: {
                        type: "submit",
                        disabled: !_vm.isSubmitEnabled || _vm.form.errors.any(),
                        block: "",
                        variant: "success",
                        size: "lg"
                      }
                    },
                    [_vm._v("Abstimmung veröffentlichen")]
                  )
                ],
                1
              )
            ],
            1
          )
        ],
        1
      )
    ],
    1
  )
}
var staticRenderFns = []
render._withStripped = true



/***/ }),

/***/ "./resources/js/core/Errors.js":
/*!*************************************!*\
  !*** ./resources/js/core/Errors.js ***!
  \*************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function _defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } }

function _createClass(Constructor, protoProps, staticProps) { if (protoProps) _defineProperties(Constructor.prototype, protoProps); if (staticProps) _defineProperties(Constructor, staticProps); return Constructor; }

var Errors =
/*#__PURE__*/
function () {
  /**
   * Create a new Errors instance.
   */
  function Errors() {
    _classCallCheck(this, Errors);

    this.errors = {};
  }
  /**
   * Determine if an errors exists for the given field.
   *
   * @param {string} field
   */


  _createClass(Errors, [{
    key: "has",
    value: function has(field) {
      return this.errors.hasOwnProperty(field);
    }
    /**
     * Determine if we have any errors.
     */

  }, {
    key: "any",
    value: function any() {
      return Object.keys(this.errors).length > 0;
    }
    /**
     * Retrieve the error message for a field.
     *
     * @param {string} field
     */

  }, {
    key: "get",
    value: function get(field) {
      if (this.errors[field]) {
        return this.errors[field][0];
      }
    }
    /**
     * Record the new errors.
     *
     * @param {object} errors
     */

  }, {
    key: "record",
    value: function record(errors) {
      this.errors = errors;
    }
    /**
     * Clear one or all error fields.
     *
     * @param {string|null} field
     */

  }, {
    key: "clear",
    value: function clear() {
      var field = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : undefined;

      if (field) {
        delete this.errors[field];
        return;
      }

      this.errors = {};
    }
  }]);

  return Errors;
}();

/* harmony default export */ __webpack_exports__["default"] = (Errors);

/***/ }),

/***/ "./resources/js/core/Form.js":
/*!***********************************!*\
  !*** ./resources/js/core/Form.js ***!
  \***********************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _Errors__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./Errors */ "./resources/js/core/Errors.js");
function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function _defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } }

function _createClass(Constructor, protoProps, staticProps) { if (protoProps) _defineProperties(Constructor.prototype, protoProps); if (staticProps) _defineProperties(Constructor, staticProps); return Constructor; }



var Form =
/*#__PURE__*/
function () {
  /**
   * Create a new Form instance.
   *
   * @param {object} data
   */
  function Form(data) {
    _classCallCheck(this, Form);

    this.originalData = data;

    for (var field in data) {
      this[field] = data[field];
    }

    this.errors = new _Errors__WEBPACK_IMPORTED_MODULE_0__["default"]();
  }
  /**
   * Fetch all relevant data for the form.
   */


  _createClass(Form, [{
    key: "data",
    value: function data() {
      var data = {};

      for (var property in this.originalData) {
        data[property] = this[property];
      }

      return data;
    }
    /**
     * Reset the form fields.
     */

  }, {
    key: "reset",
    value: function reset() {
      for (var field in this.originalData) {
        this[field] = '';
      }

      this.errors.clear();
    }
    /**
     * Submit the form and listen for promises success or failure.
     *
     * @param {Promise} promise
     */

  }, {
    key: "submit",
    value: function submit(promise) {
      var _this = this;

      promise.then(function (data) {
        _this.onSuccess(data);
      })["catch"](function (errors) {
        _this.onFail(errors);
      });
    }
    /**
     * Handle a successful form submission.
     *
     * @param {object} data
     */

  }, {
    key: "onSuccess",
    value: function onSuccess(data) {
      this.reset();
    }
    /**
     * Handle a failed form submission.
     *
     * @param {object} errors
     */

  }, {
    key: "onFail",
    value: function onFail(errors) {
      this.errors.record(errors);
    }
  }]);

  return Form;
}();

/* harmony default export */ __webpack_exports__["default"] = (Form);

/***/ }),

/***/ "./resources/js/views/Poll/CreatePoll.vue":
/*!************************************************!*\
  !*** ./resources/js/views/Poll/CreatePoll.vue ***!
  \************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _CreatePoll_vue_vue_type_template_id_e4419608_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./CreatePoll.vue?vue&type=template&id=e4419608&scoped=true& */ "./resources/js/views/Poll/CreatePoll.vue?vue&type=template&id=e4419608&scoped=true&");
/* harmony import */ var _CreatePoll_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./CreatePoll.vue?vue&type=script&lang=js& */ "./resources/js/views/Poll/CreatePoll.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _CreatePoll_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _CreatePoll_vue_vue_type_template_id_e4419608_scoped_true___WEBPACK_IMPORTED_MODULE_0__["render"],
  _CreatePoll_vue_vue_type_template_id_e4419608_scoped_true___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  "e4419608",
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/views/Poll/CreatePoll.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/views/Poll/CreatePoll.vue?vue&type=script&lang=js&":
/*!*************************************************************************!*\
  !*** ./resources/js/views/Poll/CreatePoll.vue?vue&type=script&lang=js& ***!
  \*************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_CreatePoll_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib??ref--4-0!../../../../node_modules/vue-loader/lib??vue-loader-options!./CreatePoll.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/views/Poll/CreatePoll.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_CreatePoll_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/views/Poll/CreatePoll.vue?vue&type=template&id=e4419608&scoped=true&":
/*!*******************************************************************************************!*\
  !*** ./resources/js/views/Poll/CreatePoll.vue?vue&type=template&id=e4419608&scoped=true& ***!
  \*******************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_CreatePoll_vue_vue_type_template_id_e4419608_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../node_modules/vue-loader/lib??vue-loader-options!./CreatePoll.vue?vue&type=template&id=e4419608&scoped=true& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/views/Poll/CreatePoll.vue?vue&type=template&id=e4419608&scoped=true&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_CreatePoll_vue_vue_type_template_id_e4419608_scoped_true___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_CreatePoll_vue_vue_type_template_id_e4419608_scoped_true___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ })

}]);