(window["webpackJsonp"] = window["webpackJsonp"] || []).push([[0],{

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/Poll/PollChart.vue?vue&type=script&lang=js&":
/*!*************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/Poll/PollChart.vue?vue&type=script&lang=js& ***!
  \*************************************************************************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var chart_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! chart.js */ "./node_modules/chart.js/dist/Chart.js");
/* harmony import */ var chart_js__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(chart_js__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var chartjs_plugin_datalabels__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! chartjs-plugin-datalabels */ "./node_modules/chartjs-plugin-datalabels/dist/chartjs-plugin-datalabels.js");
/* harmony import */ var chartjs_plugin_datalabels__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(chartjs_plugin_datalabels__WEBPACK_IMPORTED_MODULE_1__);
//
//
//
//
//
//


/* harmony default export */ __webpack_exports__["default"] = ({
  name: "PollChart",
  props: {
    chartData: {
      type: Array,
      required: true
    },
    chartLabels: {
      type: Array,
      required: true
    }
  },
  data: function data() {
    return {
      pollData: {
        type: 'pie',
        data: {
          labels: this.chartLabels,
          datasets: [{
            data: this.chartData,
            backgroundColor: ['blue', 'red', 'green', 'purple', 'orange', 'yellow', 'teal']
          }]
        },
        options: {
          responsive: true,
          legend: {
            display: true,
            position: "bottom",
            labels: {
              fontColor: "#333"
            }
          },
          tooltips: {
            enabled: false
          },
          plugins: {
            datalabels: {
              formatter: function formatter(value, ctx) {
                var sum = 0;
                var dataArr = ctx.chart.data.datasets[0].data;
                dataArr.map(function (data) {
                  sum += data;
                });
                return (value * 100 / sum).toFixed(2) + "%";
              },
              color: '#fff'
            }
          }
        }
      }
    };
  },
  methods: {
    createChart: function createChart(chartId, chartData) {
      var ctx = document.getElementById(chartId);
      var myChart = new chart_js__WEBPACK_IMPORTED_MODULE_0___default.a(ctx, {
        plugins: [chartjs_plugin_datalabels__WEBPACK_IMPORTED_MODULE_1___default.a],
        type: chartData.type,
        data: chartData.data,
        options: chartData.options
      });
    }
  },
  mounted: function mounted() {
    this.createChart('poll-chart', this.pollData);
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/Poll/PollResult.vue?vue&type=script&lang=js&":
/*!**************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/Poll/PollResult.vue?vue&type=script&lang=js& ***!
  \**************************************************************************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _PollChart__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./PollChart */ "./resources/js/components/Poll/PollChart.vue");
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
  name: "PollResult",
  components: {
    PollChart: _PollChart__WEBPACK_IMPORTED_MODULE_0__["default"]
  },
  props: {
    poll: {
      type: Object,
      required: true
    }
  },
  data: function data() {
    return {
      chartData: this.poll.results.votes.map(function (vote) {
        return vote.votes;
      }),
      chartLabels: this.poll.results.votes.map(function (vote) {
        return vote.name;
      })
    };
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/PollVote.vue?vue&type=script&lang=js&":
/*!*******************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/PollVote.vue?vue&type=script&lang=js& ***!
  \*******************************************************************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _store_actions_type__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../store/actions.type */ "./resources/js/store/actions.type.js");
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
  name: "PollVote",
  props: {
    poll: {
      type: Object,
      required: true
    }
  },
  data: function data() {
    return {
      selectionIndex: [],
      test: {}
    };
  },
  methods: {
    clickedOption: function clickedOption(id) {
      if (this.poll.is_radio) {
        this.selectionIndex = [];
        this.selectionIndex.push(id);
      } else {
        if (this.selectionIndex.includes(id)) {
          var index = this.selectionIndex.indexOf(id);
          this.selectionIndex.splice(index, 1);
        } else {
          if (this.selectionIndex.length < this.poll.max_check) {
            this.selectionIndex.push(id);
          }
        }
      }
    },
    vote: function vote() {
      var payload = {
        poll_id: this.poll.id,
        options: this.selectionIndex
      };
      this.$store.dispatch(_store_actions_type__WEBPACK_IMPORTED_MODULE_0__["VOTE_POLL"], payload);
    },
    abstain: function abstain() {
      this.$store.dispatch(_store_actions_type__WEBPACK_IMPORTED_MODULE_0__["ABSTAIN_POLL"], this.poll.id);
    }
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/views/Poll.vue?vue&type=script&lang=js&":
/*!**********************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/views/Poll.vue?vue&type=script&lang=js& ***!
  \**********************************************************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _store__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../store */ "./resources/js/store/index.js");
/* harmony import */ var _components_PollVote__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ../components/PollVote */ "./resources/js/components/PollVote.vue");
/* harmony import */ var vuex__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! vuex */ "./node_modules/vuex/dist/vuex.esm.js");
/* harmony import */ var _store_actions_type__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ../store/actions.type */ "./resources/js/store/actions.type.js");
/* harmony import */ var _components_Poll_PollResult__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ../components/Poll/PollResult */ "./resources/js/components/Poll/PollResult.vue");
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





/* harmony default export */ __webpack_exports__["default"] = ({
  name: "Poll",
  components: {
    PollVote: _components_PollVote__WEBPACK_IMPORTED_MODULE_1__["default"],
    PollResult: _components_Poll_PollResult__WEBPACK_IMPORTED_MODULE_4__["default"]
  },
  props: {
    id: {
      type: Number,
      required: true
    }
  },
  beforeRouteEnter: function beforeRouteEnter(to, from, next) {
    Promise.all([_store__WEBPACK_IMPORTED_MODULE_0__["default"].dispatch(_store_actions_type__WEBPACK_IMPORTED_MODULE_3__["FETCH_POLL"], to.params.id)]).then(function () {
      next();
    });
  },
  computed: _objectSpread({}, Object(vuex__WEBPACK_IMPORTED_MODULE_2__["mapGetters"])(["currentUser", "isAuthenticated", "isLoadingPoll", "poll"]))
});

/***/ }),

/***/ "./node_modules/css-loader/index.js?!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/PollVote.vue?vue&type=style&index=0&id=440db034&scoped=true&lang=css&":
/*!**************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/css-loader??ref--6-1!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src??ref--6-2!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/PollVote.vue?vue&type=style&index=0&id=440db034&scoped=true&lang=css& ***!
  \**************************************************************************************************************************************************************************************************************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

exports = module.exports = __webpack_require__(/*! ../../../node_modules/css-loader/lib/css-base.js */ "./node_modules/css-loader/lib/css-base.js")(false);
// imports


// module
exports.push([module.i, "\n.list-group-item.active[data-v-440db034] {\n    background-color: #00ff008e;\n    border-color: inherit;\n    color: black;\n}\n.list-group-item[data-v-440db034]:hover {\n    background-color: lightgray;\n    cursor: pointer;\n}\n\n", ""]);

// exports


/***/ }),

/***/ "./node_modules/moment/locale sync recursive (de(\\.js)?)$":
/*!******************************************************!*\
  !*** ./node_modules/moment/locale sync (de(\.js)?)$ ***!
  \******************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

var map = {
	"./de": "./node_modules/moment/locale/de.js",
	"./de.js": "./node_modules/moment/locale/de.js"
};


function webpackContext(req) {
	var id = webpackContextResolve(req);
	return __webpack_require__(id);
}
function webpackContextResolve(req) {
	if(!__webpack_require__.o(map, req)) {
		var e = new Error("Cannot find module '" + req + "'");
		e.code = 'MODULE_NOT_FOUND';
		throw e;
	}
	return map[req];
}
webpackContext.keys = function webpackContextKeys() {
	return Object.keys(map);
};
webpackContext.resolve = webpackContextResolve;
module.exports = webpackContext;
webpackContext.id = "./node_modules/moment/locale sync recursive (de(\\.js)?)$";

/***/ }),

/***/ "./node_modules/style-loader/index.js!./node_modules/css-loader/index.js?!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/PollVote.vue?vue&type=style&index=0&id=440db034&scoped=true&lang=css&":
/*!******************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/style-loader!./node_modules/css-loader??ref--6-1!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src??ref--6-2!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/PollVote.vue?vue&type=style&index=0&id=440db034&scoped=true&lang=css& ***!
  \******************************************************************************************************************************************************************************************************************************************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {


var content = __webpack_require__(/*! !../../../node_modules/css-loader??ref--6-1!../../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../../node_modules/postcss-loader/src??ref--6-2!../../../node_modules/vue-loader/lib??vue-loader-options!./PollVote.vue?vue&type=style&index=0&id=440db034&scoped=true&lang=css& */ "./node_modules/css-loader/index.js?!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/PollVote.vue?vue&type=style&index=0&id=440db034&scoped=true&lang=css&");

if(typeof content === 'string') content = [[module.i, content, '']];

var transform;
var insertInto;



var options = {"hmr":true}

options.transform = transform
options.insertInto = undefined;

var update = __webpack_require__(/*! ../../../node_modules/style-loader/lib/addStyles.js */ "./node_modules/style-loader/lib/addStyles.js")(content, options);

if(content.locals) module.exports = content.locals;

if(false) {}

/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/Poll/PollChart.vue?vue&type=template&id=3e0fc49a&scoped=true&":
/*!*****************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/Poll/PollChart.vue?vue&type=template&id=3e0fc49a&scoped=true& ***!
  \*****************************************************************************************************************************************************************************************************************************/
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
  return _vm._m(0)
}
var staticRenderFns = [
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("div", [_c("canvas", { attrs: { id: "poll-chart" } })])
  }
]
render._withStripped = true



/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/Poll/PollResult.vue?vue&type=template&id=0bf820de&scoped=true&":
/*!******************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/Poll/PollResult.vue?vue&type=template&id=0bf820de&scoped=true& ***!
  \******************************************************************************************************************************************************************************************************************************/
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
    "b-card",
    [
      _c("div", { staticClass: "mb-5" }, [
        _c("h4", [_vm._v(_vm._s(_vm.poll.question))]),
        _vm._v(" "),
        _c("p", { staticClass: "text-justify" }, [
          _vm._v(_vm._s(_vm.poll.description))
        ])
      ]),
      _vm._v(" "),
      _c("PollChart", {
        attrs: { chartData: _vm.chartData, chartLabels: _vm.chartLabels }
      }),
      _vm._v(" "),
      _c(
        "b-list-group",
        { staticClass: "mt-3" },
        [
          _c(
            "b-list-group-item",
            { staticClass: "d-flex align-items-center" },
            [
              _vm.poll.results.total === 1
                ? _c("p", { staticClass: "m-0 font-weight-bold" }, [
                    _vm._v(
                      "\n                Eine Person hat schon abgestimmt.\n            "
                    )
                  ])
                : _c("p", { staticClass: "m-0 font-weight-bold" }, [
                    _vm._v(
                      "\n                " +
                        _vm._s(_vm.poll.results.total) +
                        " Personen haben schon abgestimmt.\n            "
                    )
                  ])
            ]
          ),
          _vm._v(" "),
          _vm._l(_vm.poll.results.votes, function(vote, index) {
            return _c(
              "b-list-group-item",
              { key: index, staticClass: "d-flex align-items-center" },
              [
                _c(
                  "b-container",
                  [
                    _c(
                      "b-row",
                      [
                        _c(
                          "b-col",
                          { attrs: { cols: "2" } },
                          [
                            _c("b-badge", { attrs: { variant: "secondary" } }, [
                              _vm._v("Stimmen: " + _vm._s(vote.votes))
                            ])
                          ],
                          1
                        ),
                        _vm._v(" "),
                        _c("b-col", { attrs: { cols: "10" } }, [
                          _vm._v(
                            "\n                        " +
                              _vm._s(vote.name) +
                              "\n                    "
                          )
                        ])
                      ],
                      1
                    )
                  ],
                  1
                )
              ],
              1
            )
          })
        ],
        2
      )
    ],
    1
  )
}
var staticRenderFns = []
render._withStripped = true



/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/PollVote.vue?vue&type=template&id=440db034&scoped=true&":
/*!***********************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/PollVote.vue?vue&type=template&id=440db034&scoped=true& ***!
  \***********************************************************************************************************************************************************************************************************************/
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
      _c("div", { staticClass: "mt-4" }, [
        _c("h4", [_vm._v(_vm._s(_vm.poll.question))]),
        _vm._v(" "),
        _c("p", [_vm._v(_vm._s(_vm.poll.description))])
      ]),
      _vm._v(" "),
      _c(
        "div",
        [
          _c(
            "b-list-group",
            _vm._l(_vm.poll.options, function(option) {
              return _c(
                "b-list-group-item",
                {
                  key: option.id,
                  on: {
                    click: function($event) {
                      return _vm.clickedOption(option.id)
                    }
                  }
                },
                [
                  _vm.selectionIndex.includes(option.id)
                    ? _c("b-badge", { attrs: { variant: "success" } }, [
                        _vm._v("Ausgewählt")
                      ])
                    : _vm._e(),
                  _vm._v(
                    "\n                " +
                      _vm._s(option.name) +
                      "\n            "
                  )
                ],
                1
              )
            }),
            1
          ),
          _vm._v(" "),
          _c("p", { staticClass: "text-muted mt-2 ml-2" }, [
            _c("em", [
              _vm._v(
                _vm._s(_vm.selectionIndex.length) +
                  "/" +
                  _vm._s(_vm.poll.max_check) +
                  " Antworten ausgewählt"
              )
            ])
          ])
        ],
        1
      ),
      _vm._v(" "),
      _c(
        "b-button",
        {
          attrs: {
            disabled: !(_vm.selectionIndex.length === _vm.poll.max_check),
            block: "",
            variant: "success",
            size: "lg"
          },
          on: { click: _vm.vote }
        },
        [_vm._v("Abstimmen")]
      ),
      _vm._v(" "),
      _c(
        "div",
        { staticClass: "mt-2" },
        [
          _c(
            "b-link",
            {
              on: {
                click: function($event) {
                  $event.preventDefault()
                  return _vm.abstain($event)
                }
              }
            },
            [_vm._v("Ich möchte mich enthalten.")]
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

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/views/Poll.vue?vue&type=template&id=0bd07fde&":
/*!**************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/views/Poll.vue?vue&type=template&id=0bd07fde& ***!
  \**************************************************************************************************************************************************************************************************/
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
        [_c("h3", { staticClass: "m-0" }, [_vm._v("Abstimmung")])]
      ),
      _vm._v(" "),
      _vm.isLoadingPoll
        ? _c(
            "div",
            { staticClass: "d-flex justify-content-center m-5" },
            [_c("b-spinner", { attrs: { label: "Lädt..." } })],
            1
          )
        : _vm._e(),
      _vm._v(" "),
      _vm.poll
        ? _c(
            "div",
            [
              _vm.poll.results === null
                ? _c("PollVote", { attrs: { poll: _vm.poll } })
                : _c("PollResult", { attrs: { poll: _vm.poll } })
            ],
            1
          )
        : _vm._e()
    ],
    1
  )
}
var staticRenderFns = []
render._withStripped = true



/***/ }),

/***/ "./resources/js/components/Poll/PollChart.vue":
/*!****************************************************!*\
  !*** ./resources/js/components/Poll/PollChart.vue ***!
  \****************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _PollChart_vue_vue_type_template_id_3e0fc49a_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./PollChart.vue?vue&type=template&id=3e0fc49a&scoped=true& */ "./resources/js/components/Poll/PollChart.vue?vue&type=template&id=3e0fc49a&scoped=true&");
/* harmony import */ var _PollChart_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./PollChart.vue?vue&type=script&lang=js& */ "./resources/js/components/Poll/PollChart.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _PollChart_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _PollChart_vue_vue_type_template_id_3e0fc49a_scoped_true___WEBPACK_IMPORTED_MODULE_0__["render"],
  _PollChart_vue_vue_type_template_id_3e0fc49a_scoped_true___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  "3e0fc49a",
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/Poll/PollChart.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/components/Poll/PollChart.vue?vue&type=script&lang=js&":
/*!*****************************************************************************!*\
  !*** ./resources/js/components/Poll/PollChart.vue?vue&type=script&lang=js& ***!
  \*****************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_PollChart_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib??ref--4-0!../../../../node_modules/vue-loader/lib??vue-loader-options!./PollChart.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/Poll/PollChart.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_PollChart_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/components/Poll/PollChart.vue?vue&type=template&id=3e0fc49a&scoped=true&":
/*!***********************************************************************************************!*\
  !*** ./resources/js/components/Poll/PollChart.vue?vue&type=template&id=3e0fc49a&scoped=true& ***!
  \***********************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_PollChart_vue_vue_type_template_id_3e0fc49a_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../node_modules/vue-loader/lib??vue-loader-options!./PollChart.vue?vue&type=template&id=3e0fc49a&scoped=true& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/Poll/PollChart.vue?vue&type=template&id=3e0fc49a&scoped=true&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_PollChart_vue_vue_type_template_id_3e0fc49a_scoped_true___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_PollChart_vue_vue_type_template_id_3e0fc49a_scoped_true___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ }),

/***/ "./resources/js/components/Poll/PollResult.vue":
/*!*****************************************************!*\
  !*** ./resources/js/components/Poll/PollResult.vue ***!
  \*****************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _PollResult_vue_vue_type_template_id_0bf820de_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./PollResult.vue?vue&type=template&id=0bf820de&scoped=true& */ "./resources/js/components/Poll/PollResult.vue?vue&type=template&id=0bf820de&scoped=true&");
/* harmony import */ var _PollResult_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./PollResult.vue?vue&type=script&lang=js& */ "./resources/js/components/Poll/PollResult.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _PollResult_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _PollResult_vue_vue_type_template_id_0bf820de_scoped_true___WEBPACK_IMPORTED_MODULE_0__["render"],
  _PollResult_vue_vue_type_template_id_0bf820de_scoped_true___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  "0bf820de",
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/Poll/PollResult.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/components/Poll/PollResult.vue?vue&type=script&lang=js&":
/*!******************************************************************************!*\
  !*** ./resources/js/components/Poll/PollResult.vue?vue&type=script&lang=js& ***!
  \******************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_PollResult_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib??ref--4-0!../../../../node_modules/vue-loader/lib??vue-loader-options!./PollResult.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/Poll/PollResult.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_PollResult_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/components/Poll/PollResult.vue?vue&type=template&id=0bf820de&scoped=true&":
/*!************************************************************************************************!*\
  !*** ./resources/js/components/Poll/PollResult.vue?vue&type=template&id=0bf820de&scoped=true& ***!
  \************************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_PollResult_vue_vue_type_template_id_0bf820de_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../node_modules/vue-loader/lib??vue-loader-options!./PollResult.vue?vue&type=template&id=0bf820de&scoped=true& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/Poll/PollResult.vue?vue&type=template&id=0bf820de&scoped=true&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_PollResult_vue_vue_type_template_id_0bf820de_scoped_true___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_PollResult_vue_vue_type_template_id_0bf820de_scoped_true___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ }),

/***/ "./resources/js/components/PollVote.vue":
/*!**********************************************!*\
  !*** ./resources/js/components/PollVote.vue ***!
  \**********************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _PollVote_vue_vue_type_template_id_440db034_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./PollVote.vue?vue&type=template&id=440db034&scoped=true& */ "./resources/js/components/PollVote.vue?vue&type=template&id=440db034&scoped=true&");
/* harmony import */ var _PollVote_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./PollVote.vue?vue&type=script&lang=js& */ "./resources/js/components/PollVote.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _PollVote_vue_vue_type_style_index_0_id_440db034_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./PollVote.vue?vue&type=style&index=0&id=440db034&scoped=true&lang=css& */ "./resources/js/components/PollVote.vue?vue&type=style&index=0&id=440db034&scoped=true&lang=css&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");






/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_3__["default"])(
  _PollVote_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _PollVote_vue_vue_type_template_id_440db034_scoped_true___WEBPACK_IMPORTED_MODULE_0__["render"],
  _PollVote_vue_vue_type_template_id_440db034_scoped_true___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  "440db034",
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/PollVote.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/components/PollVote.vue?vue&type=script&lang=js&":
/*!***********************************************************************!*\
  !*** ./resources/js/components/PollVote.vue?vue&type=script&lang=js& ***!
  \***********************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_PollVote_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/babel-loader/lib??ref--4-0!../../../node_modules/vue-loader/lib??vue-loader-options!./PollVote.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/PollVote.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_PollVote_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/components/PollVote.vue?vue&type=style&index=0&id=440db034&scoped=true&lang=css&":
/*!*******************************************************************************************************!*\
  !*** ./resources/js/components/PollVote.vue?vue&type=style&index=0&id=440db034&scoped=true&lang=css& ***!
  \*******************************************************************************************************/
/*! no static exports found */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_style_loader_index_js_node_modules_css_loader_index_js_ref_6_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_6_2_node_modules_vue_loader_lib_index_js_vue_loader_options_PollVote_vue_vue_type_style_index_0_id_440db034_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/style-loader!../../../node_modules/css-loader??ref--6-1!../../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../../node_modules/postcss-loader/src??ref--6-2!../../../node_modules/vue-loader/lib??vue-loader-options!./PollVote.vue?vue&type=style&index=0&id=440db034&scoped=true&lang=css& */ "./node_modules/style-loader/index.js!./node_modules/css-loader/index.js?!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/PollVote.vue?vue&type=style&index=0&id=440db034&scoped=true&lang=css&");
/* harmony import */ var _node_modules_style_loader_index_js_node_modules_css_loader_index_js_ref_6_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_6_2_node_modules_vue_loader_lib_index_js_vue_loader_options_PollVote_vue_vue_type_style_index_0_id_440db034_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_node_modules_style_loader_index_js_node_modules_css_loader_index_js_ref_6_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_6_2_node_modules_vue_loader_lib_index_js_vue_loader_options_PollVote_vue_vue_type_style_index_0_id_440db034_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_0__);
/* harmony reexport (unknown) */ for(var __WEBPACK_IMPORT_KEY__ in _node_modules_style_loader_index_js_node_modules_css_loader_index_js_ref_6_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_6_2_node_modules_vue_loader_lib_index_js_vue_loader_options_PollVote_vue_vue_type_style_index_0_id_440db034_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_0__) if(__WEBPACK_IMPORT_KEY__ !== 'default') (function(key) { __webpack_require__.d(__webpack_exports__, key, function() { return _node_modules_style_loader_index_js_node_modules_css_loader_index_js_ref_6_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_6_2_node_modules_vue_loader_lib_index_js_vue_loader_options_PollVote_vue_vue_type_style_index_0_id_440db034_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_0__[key]; }) }(__WEBPACK_IMPORT_KEY__));
 /* harmony default export */ __webpack_exports__["default"] = (_node_modules_style_loader_index_js_node_modules_css_loader_index_js_ref_6_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_6_2_node_modules_vue_loader_lib_index_js_vue_loader_options_PollVote_vue_vue_type_style_index_0_id_440db034_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_0___default.a); 

/***/ }),

/***/ "./resources/js/components/PollVote.vue?vue&type=template&id=440db034&scoped=true&":
/*!*****************************************************************************************!*\
  !*** ./resources/js/components/PollVote.vue?vue&type=template&id=440db034&scoped=true& ***!
  \*****************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_PollVote_vue_vue_type_template_id_440db034_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../node_modules/vue-loader/lib??vue-loader-options!./PollVote.vue?vue&type=template&id=440db034&scoped=true& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/PollVote.vue?vue&type=template&id=440db034&scoped=true&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_PollVote_vue_vue_type_template_id_440db034_scoped_true___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_PollVote_vue_vue_type_template_id_440db034_scoped_true___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ }),

/***/ "./resources/js/views/Poll.vue":
/*!*************************************!*\
  !*** ./resources/js/views/Poll.vue ***!
  \*************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _Poll_vue_vue_type_template_id_0bd07fde___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./Poll.vue?vue&type=template&id=0bd07fde& */ "./resources/js/views/Poll.vue?vue&type=template&id=0bd07fde&");
/* harmony import */ var _Poll_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./Poll.vue?vue&type=script&lang=js& */ "./resources/js/views/Poll.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _Poll_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _Poll_vue_vue_type_template_id_0bd07fde___WEBPACK_IMPORTED_MODULE_0__["render"],
  _Poll_vue_vue_type_template_id_0bd07fde___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/views/Poll.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/views/Poll.vue?vue&type=script&lang=js&":
/*!**************************************************************!*\
  !*** ./resources/js/views/Poll.vue?vue&type=script&lang=js& ***!
  \**************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Poll_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/babel-loader/lib??ref--4-0!../../../node_modules/vue-loader/lib??vue-loader-options!./Poll.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/views/Poll.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Poll_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/views/Poll.vue?vue&type=template&id=0bd07fde&":
/*!********************************************************************!*\
  !*** ./resources/js/views/Poll.vue?vue&type=template&id=0bd07fde& ***!
  \********************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Poll_vue_vue_type_template_id_0bd07fde___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../node_modules/vue-loader/lib??vue-loader-options!./Poll.vue?vue&type=template&id=0bd07fde& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/views/Poll.vue?vue&type=template&id=0bd07fde&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Poll_vue_vue_type_template_id_0bd07fde___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Poll_vue_vue_type_template_id_0bd07fde___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ })

}]);