import{N as v}from"./NumberInput.d08a7237.js";import{T as x}from"./TextareaInput.5f7c6dab.js";import{T as b}from"./TextInput.81715bc7.js";import{P as y}from"./PrimaryButton.ca30f69e.js";import{S as I,C as V}from"./Checkbox.947d8963.js";import{g as a,i as e,z as c,l as n,m as i,p as S,j as r,o as l,F as U,A as w,y as C,t as p}from"./vendor.92b77dc9.js";import{_ as k}from"./plugin-vue_export-helper.21dcd24c.js";const N={name:"ResourceGeneralForm",components:{PrimaryButton:y,TextInput:b,TextareaInput:x,NumberInput:v,SelectInput:I,Checkbox:V},props:{form:{type:Object,required:!0}},setup(d,{emit:t}){return{de:"de",standardCode:"de",formats:["csv","json","geojson","text"]}}},T={class:"mt-8 bg-white rounded-lg shadow"},F={class:"px-4 py-5 sm:p-6 md:grid md:grid-cols-3 md:gap-6"},R=e("div",{class:"md:col-span-1"},[e("h3",{class:"text-lg font-medium leading-6 text-gray-900"}," Allgemeines "),e("p",{class:"mt-1 text-sm leading-5 text-gray-500"}," Trage die allgemeinen Informationen ein. ")],-1),A={class:"mt-5 md:mt-0 md:col-span-2"},B={class:"grid grid-cols-3 gap-6"},D={class:"col-span-3 sm:col-span-2"},j={class:"col-span-3 sm:col-span-2"},P=["value"],q={class:"col-span-6 sm:col-span-2"},z={key:0,class:"col-span-3 sm:col-span-2"},L={class:"px-4 py-3 text-right rounded-b-lg bg-gray-50 sm:px-6"},G=p(" Speichern "),E={class:"mt-8 bg-white rounded-lg shadow"},M={class:"px-4 py-5 sm:p-6 md:grid md:grid-cols-3 md:gap-6"},O=e("div",{class:"md:col-span-1"},[e("h3",{class:"text-lg font-medium leading-6 text-gray-900"}," Daten "),e("p",{class:"mt-1 text-sm leading-5 text-gray-500"}," F\xFCge eine Resource manuell hinzu oder gib eine Quelle ein. ")],-1),Q={class:"mt-5 md:mt-0 md:col-span-2"},H={class:"grid grid-cols-3 gap-6"},J={class:"col-span-3 sm:col-span-3"},K={class:"px-4 py-3 text-right rounded-b-lg bg-gray-50 sm:px-6"},W=p(" Speichern ");function X(d,t,o,g,Y,Z){const m=r("TextInput"),_=r("SelectInput"),f=r("Checkbox"),u=r("PrimaryButton");return l(),a("div",null,[e("div",T,[e("form",{onSubmit:t[4]||(t[4]=c((...s)=>d.submit&&d.submit(...s),["prevent"]))},[e("div",F,[R,e("div",A,[e("div",B,[e("div",D,[n(m,{label:"Name der Resource",placeholder:"Name",modelValue:o.form.name,"onUpdate:modelValue":t[0]||(t[0]=s=>o.form.name=s),errors:o.form.errors.name},null,8,["modelValue","errors"])]),e("div",j,[n(_,{label:"Format",modelValue:o.form.format,"onUpdate:modelValue":t[1]||(t[1]=s=>o.form.format=s),errors:o.form.errors.format},{default:i(()=>[(l(!0),a(U,null,w(g.formats,(s,h)=>(l(),a("option",{value:s,key:h},C(s.toUpperCase()),9,P))),128))]),_:1},8,["modelValue","errors"])]),e("div",q,[n(f,{id:"auto-import",label:"Auto-Import",hint:"Soll diese Resource automatisch aktualisiert werden, wenn eine URL hinterlegt ist?",modelValue:o.form.shouldAutoImport,"onUpdate:modelValue":t[2]||(t[2]=s=>o.form.shouldAutoImport=s)},null,8,["modelValue"])]),o.form.shouldAutoImport?(l(),a("div",z,[n(m,{label:"Update-Interval (in h)",type:"number",placeholder:"Interval",modelValue:o.form.autoUpdatingInterval,"onUpdate:modelValue":t[3]||(t[3]=s=>o.form.autoUpdatingInterval=s),min:1,max:1e4,errors:o.form.errors.auto_updating_interval},null,8,["modelValue","errors"])])):S("",!0)])])]),e("div",L,[n(u,{type:"submit"},{default:i(()=>[G]),_:1})])],32)]),e("div",E,[e("form",{onSubmit:t[5]||(t[5]=c(()=>{},["prevent"]))},[e("div",M,[O,e("div",Q,[e("div",H,[e("div",J,[n(m,{label:"Datenquelle",placeholder:"URL",hint:"F\xFCge eine Datenquelle hinzu, von der die Daten periodisch geladen werden."})])])])]),e("div",K,[n(u,{type:"submit"},{default:i(()=>[W]),_:1})])],32)])])}var re=k(N,[["render",X]]);export{re as default};