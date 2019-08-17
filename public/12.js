(window["webpackJsonp"] = window["webpackJsonp"] || []).push([[12],{

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/views/Polls.vue?vue&type=script&lang=js&":
/*!***********************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/views/Polls.vue?vue&type=script&lang=js& ***!
  \***********************************************************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var vuex__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! vuex */ "./node_modules/vuex/dist/vuex.esm.js");
/* harmony import */ var _store_actions_type__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ../store/actions.type */ "./resources/js/store/actions.type.js");
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


/* harmony default export */ __webpack_exports__["default"] = ({
  name: "Polls",
  mounted: function mounted() {
    this.$store.dispatch(_store_actions_type__WEBPACK_IMPORTED_MODULE_1__["FETCH_POLLS"]);
  },
  computed: _objectSpread({}, Object(vuex__WEBPACK_IMPORTED_MODULE_0__["mapGetters"])(["isAuthenticated", "isLoadingPolls", "polls", "unansweredPolls", "answeredPolls"]))
});

/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/views/Polls.vue?vue&type=template&id=71eb1d05&":
/*!***************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/views/Polls.vue?vue&type=template&id=71eb1d05& ***!
  \***************************************************************************************************************************************************************************************************/
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
        "b-card",
        {
          staticClass: "my-4",
          attrs: { "bg-variant": "secondary", "text-variant": "black" }
        },
        [
          _c(
            "div",
            { staticClass: "d-flex justify-content-between" },
            [
              _c("h3", { staticClass: "m-0" }, [
                _vm._v("Unbeantwortete Abstimmungen")
              ]),
              _vm._v(" "),
              _c(
                "can",
                { attrs: { I: "create-poll", a: "Poll" } },
                [
                  _c(
                    "b-button",
                    {
                      attrs: {
                        variant: "success",
                        to: { name: "polls.create" }
                      }
                    },
                    [_vm._v("Hinzufügen")]
                  )
                ],
                1
              )
            ],
            1
          )
        ]
      ),
      _vm._v(" "),
      _vm.isLoadingPolls
        ? _c(
            "div",
            { staticClass: "d-flex justify-content-center m-5" },
            [_c("b-spinner", { attrs: { label: "Lädt..." } })],
            1
          )
        : _vm._e(),
      _vm._v(" "),
      _vm._l(_vm.unansweredPolls, function(poll, index) {
        return _c(
          "b-card",
          { key: poll.id, staticClass: "mb-2" },
          [
            _c("h4", [
              _vm._v(_vm._s(poll.question)),
              _c("small", { staticClass: "ml-2 text-muted" }, [
                _c("br"),
                _vm._v("gestellt von "),
                _c("b", [_vm._v(_vm._s(poll.group.name))])
              ])
            ]),
            _vm._v(" "),
            _c("b-card-text", [
              _vm._v("\n            " + _vm._s(poll.description) + "\n        ")
            ]),
            _vm._v(" "),
            _c(
              "b-button",
              {
                attrs: {
                  to: { name: "polls.poll", params: { id: poll.id } },
                  variant: "primary"
                }
              },
              [_vm._v("Abstimmen")]
            )
          ],
          1
        )
      }),
      _vm._v(" "),
      _c(
        "b-card",
        {
          staticClass: "my-4",
          attrs: { "bg-variant": "secondary", "text-variant": "black" }
        },
        [
          _c("h3", { staticClass: "m-0" }, [
            _vm._v("Beantwortete Abstimmungen")
          ])
        ]
      ),
      _vm._v(" "),
      _vm.isLoadingPolls
        ? _c(
            "div",
            { staticClass: "d-flex justify-content-center m-5" },
            [_c("b-spinner", { attrs: { label: "Lädt..." } })],
            1
          )
        : _vm._e(),
      _vm._v(" "),
      _vm._l(_vm.answeredPolls, function(poll, index) {
        return _c(
          "b-card",
          { key: poll.id, staticClass: "mb-2" },
          [
            _c("h4", [
              _vm._v(_vm._s(poll.question)),
              _c("small", { staticClass: "ml-2 text-muted" }, [
                _c("br"),
                _vm._v("gestellt von "),
                _c("b", [_vm._v(_vm._s(poll.group.name))])
              ])
            ]),
            _vm._v(" "),
            _c("b-card-text", [
              poll.results.total === 1
                ? _c("div", [
                    _vm._v(
                      "\n                " +
                        _vm._s(poll.results.total) +
                        " Benutzer hat abgestimmt.\n            "
                    )
                  ])
                : _c("div", [
                    _vm._v(
                      "\n                " +
                        _vm._s(poll.results.total) +
                        " Benutzer haben abgestimmt.\n            "
                    )
                  ])
            ]),
            _vm._v(" "),
            _c(
              "b-button",
              {
                attrs: {
                  to: { name: "polls.poll", params: { id: poll.id } },
                  variant: "primary"
                }
              },
              [_vm._v("Ergebnisse ansehen")]
            )
          ],
          1
        )
      })
    ],
    2
  )
}
var staticRenderFns = []
render._withStripped = true



/***/ }),

/***/ "./resources/js/views/Polls.vue":
/*!**************************************!*\
  !*** ./resources/js/views/Polls.vue ***!
  \**************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _Polls_vue_vue_type_template_id_71eb1d05___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./Polls.vue?vue&type=template&id=71eb1d05& */ "./resources/js/views/Polls.vue?vue&type=template&id=71eb1d05&");
/* harmony import */ var _Polls_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./Polls.vue?vue&type=script&lang=js& */ "./resources/js/views/Polls.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _Polls_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _Polls_vue_vue_type_template_id_71eb1d05___WEBPACK_IMPORTED_MODULE_0__["render"],
  _Polls_vue_vue_type_template_id_71eb1d05___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/views/Polls.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/views/Polls.vue?vue&type=script&lang=js&":
/*!***************************************************************!*\
  !*** ./resources/js/views/Polls.vue?vue&type=script&lang=js& ***!
  \***************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Polls_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/babel-loader/lib??ref--4-0!../../../node_modules/vue-loader/lib??vue-loader-options!./Polls.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/views/Polls.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Polls_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/views/Polls.vue?vue&type=template&id=71eb1d05&":
/*!*********************************************************************!*\
  !*** ./resources/js/views/Polls.vue?vue&type=template&id=71eb1d05& ***!
  \*********************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Polls_vue_vue_type_template_id_71eb1d05___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../node_modules/vue-loader/lib??vue-loader-options!./Polls.vue?vue&type=template&id=71eb1d05& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/views/Polls.vue?vue&type=template&id=71eb1d05&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Polls_vue_vue_type_template_id_71eb1d05___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Polls_vue_vue_type_template_id_71eb1d05___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ })

}]);