import{I as k}from"./Icon.b98210b0.js";import{_ as c}from"./_plugin-vue_export-helper.cdc0426e.js";import{r as u,o as i,c as p,a as r,b as o,w as a,n as d,i as l,e as h}from"./app.23e9e7df.js";import{M,a as g}from"./index.84098c49.js";const b={components:{Icon:k},props:{url:String},methods:{isUrl(...e){return e[0]===""?this.url==="":e.filter(s=>this.url.startsWith(s)).length}}},w={class:"md:mb-4"},y={class:"md:mb-4"};function U(e,s,m,f,v,t){const n=u("icon"),_=u("inertia-link");return i(),p("div",null,[r("div",w,[o(_,{class:"flex items-center py-2 group hover:no-underline",href:e.route("dashboard")},{default:a(()=>[o(n,{name:"dashboard",class:d(["w-4 h-4 mr-2",t.isUrl("dashboard")?"fill-white":"fill-gray-700 md:fill-gray-600 group-hover:fill-white"])},null,8,["class"]),r("div",{class:d(t.isUrl("dashboard")?"text-white":"text-gray-700 md:text-gray-600 group-hover:text-white")}," \xDCbersicht ",2)]),_:1},8,["href"])]),r("div",y,[o(_,{class:"flex items-center py-2 group hover:no-underline",href:e.route("polls.index")},{default:a(()=>[o(n,{name:"pie-chart",class:d(["w-4 h-4 mr-2",t.isUrl("polls")?"fill-white":"fill-gray-700 md:fill-gray-600 group-hover:fill-white"])},null,8,["class"]),r("div",{class:d(t.isUrl("polls")?"text-white":"text-gray-700 md:text-gray-600 group-hover:text-white")}," Abstimmungen ",2)]),_:1},8,["href"])])])}const K=c(b,[["render",U]]),$={name:"MenuGeneralDesktop",components:{MenuItemDesktop:M},props:{url:String},methods:{isUrl(...e){return e[0]===""?this.url==="":e.filter(s=>this.url.startsWith(s)).length!==0}}},V={class:"space-y-1"},z=r("path",{"stroke-linecap":"round","stroke-linejoin":"round","stroke-width":"2",d:"M3 12l9-9 9 9M5 10v10a1 1 0 001 1h3a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1h3a1 1 0 001-1V10M9 21h6"},null,-1),N=r("path",{"stroke-linecap":"round","stroke-linejoin":"round","stroke-width":"2",d:"M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"},null,-1),j=r("path",{"stroke-linecap":"round","stroke-linejoin":"round","stroke-width":"2",d:"M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"},null,-1),x=r("path",{"stroke-linecap":"round","stroke-linejoin":"round","stroke-width":"2",d:"M15 11a3 3 0 11-6 0 3 3 0 016 0z"},null,-1),I=r("path",{"stroke-linecap":"round","stroke-linejoin":"round","stroke-width":"2",d:"M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"},null,-1);function E(e,s,m,f,v,t){const n=u("MenuItemDesktop");return i(),p("div",V,[o(n,{title:"\xDCbersicht",href:e.route("dashboard"),active:t.isUrl("dashboard")},{default:a(()=>[z]),_:1},8,["href","active"]),e.$page.props.menuEntries.events?(i(),l(n,{key:0,title:"Veranstaltungen",href:e.route("events.index"),active:t.isUrl("events")},{default:a(()=>[N]),_:1},8,["href","active"])):h("",!0),e.$page.props.menuEntries.entries?(i(),l(n,{key:1,title:"Karte",href:e.route("entries.index"),active:t.isUrl("entries")},{default:a(()=>[j,x]),_:1},8,["href","active"])):h("",!0),e.$page.props.menuEntries.help?(i(),l(n,{key:2,title:"Helfen",href:e.route("help.index"),active:t.isUrl("help")},{default:a(()=>[I]),_:1},8,["href","active"])):h("",!0)])}const q=c($,[["render",E]]),D={name:"MenuGeneralMobile",components:{MenuItemMobile:g},props:{url:String},methods:{isUrl(...e){return e[0]===""?this.url==="":e.filter(s=>this.url.startsWith(s)).length!==0},navigated(){this.$emit("navigated")}}},G=r("path",{"stroke-linecap":"round","stroke-linejoin":"round","stroke-width":"2",d:"M3 12l9-9 9 9M5 10v10a1 1 0 001 1h3a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1h3a1 1 0 001-1V10M9 21h6"},null,-1),H=r("path",{"stroke-linecap":"round","stroke-linejoin":"round","stroke-width":"2",d:"M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"},null,-1),L=r("path",{"stroke-linecap":"round","stroke-linejoin":"round","stroke-width":"2",d:"M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"},null,-1);function B(e,s,m,f,v,t){const n=u("MenuItemMobile");return i(),p("div",null,[o(n,{title:"\xDCbersicht",href:e.route("dashboard"),active:t.isUrl("dashboard"),onNav:t.navigated},{default:a(()=>[G]),_:1},8,["href","active","onNav"]),e.$page.props.menuEntries.help?(i(),l(n,{key:0,title:"Helfen",href:e.route("help.index"),active:t.isUrl("help"),onNav:t.navigated},{default:a(()=>[H]),_:1},8,["href","active","onNav"])):h("",!0),e.$page.props.menuEntries.events?(i(),l(n,{key:1,title:"Veranstaltungen",href:e.route("events.index"),active:t.isUrl("events"),onNav:t.navigated},{default:a(()=>[L]),_:1},8,["href","active","onNav"])):h("",!0)])}const F=c(D,[["render",B]]);export{q as M,F as a,K as b};