import{_ as r}from"./_plugin-vue_export-helper.cdc0426e.js";import{o as i,c as s,i as d,w as o,k as u,s as f,p as c,n as m}from"./app.b7fec2ed.js";const x={name:"WhiteButton",inheritAttrs:!1,props:{size:{validator:function(t){return["xs","sm","md","lg","xl"].indexOf(t)!==-1},default:"md"},href:{type:String,required:!1,default:null},buttonType:{validator:function(t){return["button","reset","submit"].indexOf(t)!==-1},default:null,required:!1},disabled:{type:Boolean,default:!1},block:{type:Boolean,default:!1},target:{type:String,required:!1,default:()=>""}},computed:{type(){return this.href?"inertia-link":"button"}},methods:{clickedButton:function(t){this.disabled||this.$emit("click",t)}}};function y(t,n,e,g,b,a){return i(),s("span",{class:m(["inline-flex rounded-md shadow-sm",{"w-full justify-center":e.block}])},[(i(),d(c(a.type),f({class:"inline-flex items-center font-medium text-gray-700 transition duration-150 ease-in-out bg-white border border-gray-300"},t.$attrs,{href:e.href,type:e.buttonType,class:{"px-2.5 py-1.5 text-xs leading-4 rounded":e.size==="xs","px-3 py-2 text-sm leading-4 rounded-md":e.size==="sm","px-4 py-2 text-sm leading-6 rounded-md":e.size==="md","px-4 py-2 text-base leading-6 rounded-md":e.size==="lg","px-6 py-3 text-base leading-6 rounded-md":e.size==="xl","hover:text-gray-500 focus:outline-none focus:border-blue-300 focus:ring-blue active:text-gray-800 active:bg-gray-50":!e.disabled,"opacity-50":e.disabled,"w-full justify-center":e.block},target:e.target,onClick:n[0]||(n[0]=l=>a.clickedButton(l))}),{default:o(()=>[u(t.$slots,"default")]),_:3},16,["href","type","class","target"]))],2)}const p=r(x,[["render",y]]);export{p as W};