import{L as d}from"./LayoutGeneral.4af30ebe.js";import{P as p}from"./Pagination.c2ac00a9.js";import{S as h}from"./SearchFilter.9a56d1bb.js";import{P as u}from"./PollItem.c5166cde.js";import{N as o,r as l,o as r,c as s,a as t,F as f,h as _,b as i}from"./app.23e9e7df.js";import{_ as x}from"./_plugin-vue_export-helper.cdc0426e.js";import"./index.84098c49.js";import"./FlashMessages.c7afb112.js";import"./MenuGeneralMobile.dc795c36.js";import"./Icon.b98210b0.js";/* empty css            */const g={name:"Index",layout:d,components:{PollItem:u,Pagination:p,SearchFilter:h},props:{polls:Object,filters:Object},data(){return{form:{search:this.filters.search,trashed:this.filters.trashed}}},watch:{form:{handler:o.exports.throttle(function(){let e=o.exports.pickBy(this.form);this.$inertia.replace(this.route("polls.index.answered",Object.keys(e).length?e:{remember:"forget"}))},150),deep:!0}},methods:{reset(){this.form=o.exports.mapValues(this.form,()=>null)}},created(){this.$root.$emit("newTitle","Unbeantwortete Abstimmungen")}},b=t("header",null,[t("div",{class:"mx-auto max-w-7xl"},[t("h2",{class:"text-3xl font-bold leading-tight text-gray-900"}," Unbeantwortete Abstimmungen ")])],-1),y={class:"mt-6 overflow-hidden bg-white rounded-lg shadow"},w={class:"mt-6"};function k(e,P,a,v,I,$){const m=l("PollItem"),c=l("Pagination");return r(),s("div",null,[b,t("div",y,[t("ul",null,[(r(!0),s(f,null,_(a.polls.data,n=>(r(),s("li",{class:"border-t border-gray-200",key:n.id},[i(m,{poll:n},null,8,["poll"])]))),128))])]),t("div",w,[i(c,{links:a.polls.links,class:"my-2 my-md-4"},null,8,["links"])])])}const C=x(g,[["render",k]]);export{C as default};