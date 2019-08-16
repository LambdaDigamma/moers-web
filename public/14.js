(window["webpackJsonp"] = window["webpackJsonp"] || []).push([[14],{

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/views/Profile/ProfileSettings.vue?vue&type=script&lang=js&":
/*!*****************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/views/Profile/ProfileSettings.vue?vue&type=script&lang=js& ***!
  \*****************************************************************************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var vuex__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! vuex */ "./node_modules/vuex/dist/vuex.esm.js");
function _objectSpread(target) { for (var i = 1; i < arguments.length; i++) { var source = arguments[i] != null ? arguments[i] : {}; var ownKeys = Object.keys(source); if (typeof Object.getOwnPropertySymbols === 'function') { ownKeys = ownKeys.concat(Object.getOwnPropertySymbols(source).filter(function (sym) { return Object.getOwnPropertyDescriptor(source, sym).enumerable; })); } ownKeys.forEach(function (key) { _defineProperty(target, key, source[key]); }); } return target; }

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
  name: "ProfileSettings",
  computed: _objectSpread({}, Object(vuex__WEBPACK_IMPORTED_MODULE_0__["mapGetters"])(["currentUser"]))
});

/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/views/Profile/ProfileSettings.vue?vue&type=template&id=56471b97&scoped=true&":
/*!*********************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/views/Profile/ProfileSettings.vue?vue&type=template&id=56471b97&scoped=true& ***!
  \*********************************************************************************************************************************************************************************************************************************/
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
  return _c("div", { staticClass: "mt-5" }, [
    _c("hr", { staticClass: "my-4" }),
    _vm._v(" "),
    _c("h3", [_vm._v("Profil")]),
    _vm._v(" "),
    _c(
      "div",
      { staticClass: "my-4" },
      [
        _c(
          "b-form",
          [
            _c(
              "b-form-group",
              {
                attrs: {
                  id: "input-group-1",
                  label: "Name:",
                  "label-for": "input-1",
                  "label-cols": "2"
                }
              },
              [
                _c("b-form-input", {
                  attrs: {
                    id: "input-1",
                    required: "",
                    placeholder: "Namen eingeben"
                  },
                  model: {
                    value: _vm.currentUser.name,
                    callback: function($$v) {
                      _vm.$set(_vm.currentUser, "name", $$v)
                    },
                    expression: "currentUser.name"
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
                  id: "input-group-2",
                  label: "Bio:",
                  "label-for": "input-2",
                  "label-cols": "2"
                }
              },
              [
                _c("b-form-input", {
                  attrs: {
                    id: "input-2",
                    required: "",
                    placeholder: "Bio eingeben"
                  },
                  model: {
                    value: _vm.currentUser.description,
                    callback: function($$v) {
                      _vm.$set(_vm.currentUser, "description", $$v)
                    },
                    expression: "currentUser.description"
                  }
                })
              ],
              1
            ),
            _vm._v(" "),
            _c(
              "div",
              { staticClass: "d-flex justify-content-end" },
              [
                _c(
                  "b-button",
                  { attrs: { type: "submit", variant: "primary" } },
                  [_vm._v("Speichern")]
                )
              ],
              1
            )
          ],
          1
        )
      ],
      1
    ),
    _vm._v(" "),
    _c("hr", { staticClass: "my-4" }),
    _vm._v(" "),
    _c("h3", [_vm._v("Benutzerkonto")]),
    _vm._v(" "),
    _c(
      "div",
      { staticClass: "my-4" },
      [
        _c(
          "b-form",
          [
            _c(
              "b-form-group",
              {
                attrs: {
                  id: "input-group-1",
                  label: "E-Mail:",
                  "label-for": "input-1",
                  "label-cols": "2",
                  description:
                    "Deine E-Mail Adresse dient nur Verifikationszwecken. Sie wird nicht mit Dritten geteilt oder zu Werbezwecken genutzt."
                }
              },
              [
                _c("b-form-input", {
                  attrs: {
                    id: "input-1",
                    type: "email",
                    required: "",
                    placeholder: "E-Mail eingeben"
                  },
                  model: {
                    value: _vm.currentUser.email,
                    callback: function($$v) {
                      _vm.$set(_vm.currentUser, "email", $$v)
                    },
                    expression: "currentUser.email"
                  }
                })
              ],
              1
            ),
            _vm._v(" "),
            _c(
              "div",
              { staticClass: "d-flex justify-content-end" },
              [
                _c(
                  "b-button",
                  { attrs: { type: "submit", variant: "primary" } },
                  [_vm._v("Speichern")]
                )
              ],
              1
            )
          ],
          1
        ),
        _vm._v(" "),
        _c(
          "b-form",
          { staticClass: "mt-4" },
          [
            _c(
              "b-form-group",
              {
                attrs: {
                  id: "input-group-2",
                  label: "Neues Passwort:",
                  "label-for": "input-2",
                  "label-cols": "2"
                }
              },
              [
                _c("b-form-input", {
                  attrs: {
                    id: "input-2",
                    type: "password",
                    required: "",
                    placeholder: "Passwort"
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
                  id: "input-group-3",
                  label: "",
                  "label-for": "input-3",
                  "label-cols": "2"
                }
              },
              [
                _c("b-form-input", {
                  attrs: {
                    id: "input-3",
                    type: "password",
                    required: "",
                    placeholder: "Passwort bestätigen"
                  }
                })
              ],
              1
            ),
            _vm._v(" "),
            _c(
              "div",
              { staticClass: "d-flex justify-content-end" },
              [
                _c(
                  "b-button",
                  { attrs: { type: "submit", variant: "warning" } },
                  [_vm._v("Ändern")]
                )
              ],
              1
            )
          ],
          1
        )
      ],
      1
    ),
    _vm._v(" "),
    _c("hr", { staticClass: "my-4" }),
    _vm._v(" "),
    _c("h3", [_vm._v("Gefahrenbereich")]),
    _vm._v(" "),
    _c(
      "div",
      { staticClass: "mt-4" },
      [
        _c("h5", [_vm._v("Konto löschen")]),
        _vm._v(" "),
        _c("p", { staticClass: "text-muted my-2 mb-4" }, [
          _vm._v(
            "Du möchtest Dein Benutzerkonto und somit auch alle Deine Daten endgültig löschen?"
          )
        ]),
        _vm._v(" "),
        _c("b-button", { attrs: { variant: "danger", block: "" } }, [
          _vm._v("Benutzerkonto löschen")
        ])
      ],
      1
    )
  ])
}
var staticRenderFns = []
render._withStripped = true



/***/ }),

/***/ "./resources/js/views/Profile/ProfileSettings.vue":
/*!********************************************************!*\
  !*** ./resources/js/views/Profile/ProfileSettings.vue ***!
  \********************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _ProfileSettings_vue_vue_type_template_id_56471b97_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./ProfileSettings.vue?vue&type=template&id=56471b97&scoped=true& */ "./resources/js/views/Profile/ProfileSettings.vue?vue&type=template&id=56471b97&scoped=true&");
/* harmony import */ var _ProfileSettings_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./ProfileSettings.vue?vue&type=script&lang=js& */ "./resources/js/views/Profile/ProfileSettings.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _ProfileSettings_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _ProfileSettings_vue_vue_type_template_id_56471b97_scoped_true___WEBPACK_IMPORTED_MODULE_0__["render"],
  _ProfileSettings_vue_vue_type_template_id_56471b97_scoped_true___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  "56471b97",
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/views/Profile/ProfileSettings.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/views/Profile/ProfileSettings.vue?vue&type=script&lang=js&":
/*!*********************************************************************************!*\
  !*** ./resources/js/views/Profile/ProfileSettings.vue?vue&type=script&lang=js& ***!
  \*********************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_ProfileSettings_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib??ref--4-0!../../../../node_modules/vue-loader/lib??vue-loader-options!./ProfileSettings.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/views/Profile/ProfileSettings.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_ProfileSettings_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/views/Profile/ProfileSettings.vue?vue&type=template&id=56471b97&scoped=true&":
/*!***************************************************************************************************!*\
  !*** ./resources/js/views/Profile/ProfileSettings.vue?vue&type=template&id=56471b97&scoped=true& ***!
  \***************************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_ProfileSettings_vue_vue_type_template_id_56471b97_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../node_modules/vue-loader/lib??vue-loader-options!./ProfileSettings.vue?vue&type=template&id=56471b97&scoped=true& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/views/Profile/ProfileSettings.vue?vue&type=template&id=56471b97&scoped=true&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_ProfileSettings_vue_vue_type_template_id_56471b97_scoped_true___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_ProfileSettings_vue_vue_type_template_id_56471b97_scoped_true___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ })

}]);