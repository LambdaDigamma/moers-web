import{L as g}from"./LayoutGeneral.4af30ebe.js";import{E as x}from"./EventCard.7176291e.js";import{P as y}from"./PrimaryButton.4a6bd237.js";import{z as c,r as h,o as n,c as a,a as t,t as o,F as k,h as w,e as d,b as m,w as u,d as r,l as b,i as p}from"./app.23e9e7df.js";import{_ as M}from"./_plugin-vue_export-helper.cdc0426e.js";import"./index.84098c49.js";import"./FlashMessages.c7afb112.js";import"./MenuGeneralMobile.dc795c36.js";import"./Icon.b98210b0.js";/* empty css            */const D={name:"Show",components:{PrimaryButton:y,EventCard:x},layout:g,props:{event:Object},computed:{prettifiedDate(){if(this.event.start_date!==null&&this.event.end_date!==null){const s=c(this.event.start_date),i=c(this.event.end_date);return s.year()===i.year()&&s.month()===i.month()&&s.days()===i.days()?s.format("dddd, DD.MM. HH:mm")+" - "+i.format("HH:mm"):s.format("dddd, DD.MM. HH:mm")+" - "+i.format("dddd, DD.MM. HH:mm")}else if(this.event.start_date){const s=c(this.event.start_date);return s.hours()===0&&s.minutes()===0&&s.seconds()===0?s.format("dddd, DD.MM."):s.format("dddd, DD.MM. HH:mm")}else return"Datum noch nicht bekannt"},subtitle(){if(this.event.organisation&&this.event.entry)return this.event.organisation.name+" \u2022 "+this.event.entry.name;if(this.event.organisation)return this.event.organisation.name}}},H={class:"mt-6"},z={class:"flex flex-row"},B={class:"flex-1 w-0"},j={class:"bg-white rounded-lg shadow"},V={id:"image-container"},C=["src"],P={class:"px-4 py-5 sm:p-6"},N=t("div",{class:"flex items-baseline"},[t("div",{class:"text-xs font-semibold tracking-wide text-gray-600 uppercase"})],-1),L={class:"mt-0 text-base font-semibold leading-6 text-gray-900 lg:text-xl"},S={class:"mt-0"},E={class:"text-xs font-medium text-gray-500 md:text-sm"},A={key:0,class:"border-t border-gray-200"},F={class:"px-4 py-5 sm:p-6"},G={class:"flex-shrink-0 ml-8 w-80"},O={key:0,class:"flex flex-col justify-end"},T={class:"bg-white rounded-lg shadow"},q={key:0,class:"relative h-40"},I=["src"],J={class:"flex flex-col px-4 py-5 sm:p-6"},K={class:"relative"},Q=t("span",{class:"text-sm font-medium leading-5 text-gray-500 truncate"},"Veranstalter",-1),R={class:"text-xl font-semibold"},U={class:"text-sm text-gray-700 truncate-2-lines"},W=r(" Anzeigen "),X=t("div",{class:"absolute top-0 right-0 z-40 -mt-10"},[t("div",{class:"p-3 bg-gray-700 rounded-md shadow-lg"},[t("svg",{fill:"none",stroke:"currentColor","stroke-linecap":"round","stroke-linejoin":"round","stroke-width":"2",viewBox:"0 0 24 24",class:"w-6 h-6 text-white"},[t("path",{"stroke-linecap":"round","stroke-linejoin":"round","stroke-width":"2",d:"M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"})])])],-1),Y={key:1,class:"flex flex-col justify-end mt-12"},Z={class:"bg-white rounded-lg shadow"},$={key:0,class:"relative h-40"},tt=["src"],et={class:"flex flex-col px-4 py-5 sm:p-6"},st={class:"relative"},nt=t("span",{class:"text-sm font-medium leading-5 text-gray-500 truncate"},"Veranstaltungsort",-1),ot={class:"mt-0 text-xl font-semibold"},at={class:"text-sm leading-5 text-gray-700"},it=t("br",null,null,-1),dt=r(" Anzeigen "),rt=b('<div class="absolute top-0 right-0 z-40 -mt-10"><div class="p-3 bg-gray-700 rounded-md shadow-lg"><svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" class="w-6 h-6 text-white"><path d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg></div></div>',1);function lt(s,i,e,ct,_t,v){const f=h("MarkdownPresentation"),_=h("PrimaryButton");return n(),a("div",H,[t("div",z,[t("div",B,[t("div",j,[t("div",V,[t("img",{class:"w-full rounded-t-lg",src:e.event.header_url,alt:""},null,8,C)]),t("div",P,[N,t("h1",L,o(e.event.name),1),t("div",S,[t("span",E,o(v.prettifiedDate),1)])]),e.event.page?(n(),a("div",A,[t("div",F,[(n(!0),a(k,null,w(e.event.page.blocks,l=>(n(),a("div",{key:l.id},[l.type==="markdown"?(n(),p(f,{key:0,block:l},null,8,["block"])):d("",!0)]))),128))])])):d("",!0)])]),t("div",G,[e.event.organisation?(n(),a("div",O,[t("div",T,[e.event.organisation&&e.event.organisation.header_url?(n(),a("div",q,[t("img",{class:"absolute inset-0 object-cover w-full h-full rounded-t-lg",src:e.event.organisation.header_url,alt:""},null,8,I)])):d("",!0),t("div",J,[t("div",K,[Q,t("h1",R,o(e.event.organisation.name),1),t("p",U,o(e.event.organisation.description),1),m(_,{class:"mt-3",block:""},{default:u(()=>[W]),_:1}),X])])])])):d("",!0),e.event.entry?(n(),a("div",Y,[t("div",Z,[e.event.entry&&e.event.entry.header_url?(n(),a("div",$,[t("img",{class:"absolute inset-0 object-cover w-full h-full rounded-t-lg",src:e.event.entry.header_url,alt:""},null,8,tt)])):d("",!0),t("div",et,[t("div",st,[nt,t("h1",ot,o(e.event.entry.name),1),t("span",at,[r(o(e.event.entry.street)+" "+o(e.event.entry.house_number),1),it,r(" "+o(e.event.entry.postcode)+" "+o(e.event.entry.place),1)]),m(_,{class:"mt-3",block:""},{default:u(()=>[dt]),_:1}),rt])])])])):d("",!0)])])])}const bt=M(D,[["render",lt]]);export{bt as default};