import{L as k}from"./LayoutAdmin.399a60bd.js";import{T}from"./TextInput.154f4e84.js";import{L as B}from"./LoadingButton.218d3e7a.js";import"./chartjs-plugin-datalabels.esm.3a34eb58.js";import{_ as u}from"./_plugin-vue_export-helper.cdc0426e.js";import{H as C}from"./Header.c7cbfcd4.js";import{I as j}from"./Icon.b98210b0.js";import{r as i,o as n,c as d,a as e,b as l,k as x,i as v,w as r,n as w,t as h,e as y,F as I,h as E,d as _}from"./app.23e9e7df.js";import{C as O}from"./CardContainer.e62efa97.js";import{E as H}from"./EventCard.7176291e.js";import{T as L}from"./TextareaInput.560f93fb.js";import"./index.84098c49.js";import"./FlashMessages.c7afb112.js";/* empty css            */const M={components:{Icon:j}},S={class:"flex items-center justify-between max-w-3xl p-4 bg-red-600 rounded"},z={class:"flex items-center"},A={class:"text-white"};function D(o,s,t,f,g,c){const a=i("icon");return n(),d("div",S,[e("div",z,[l(a,{name:"trash",class:"flex-shrink-0 w-4 h-4 mr-2 fill-white"}),e("div",A,[x(o.$slots,"default")])]),e("button",{class:"text-white hover:underline",tabindex:"-1",type:"button",onClick:s[0]||(s[0]=m=>o.$emit("restore"))}," Wiederherstellen ")])}const N=u(M,[["render",D]]),V={name:"TabItem",props:{title:{type:String},href:{type:String},active:{type:Boolean,default:!1},hasIcon:{type:Boolean,default:!0}}},F={class:"-ml-0.5 mr-2 h-5 w-5 transition duration-150"};function P(o,s,t,f,g,c){const a=i("inertia-link");return n(),v(a,{href:t.href,class:w(["inline-flex items-center px-1 py-4 text-sm font-medium leading-5 transition duration-150 border-b-2 group focus:outline-none",t.active?"border-white text-white focus:text-red-100 focus:border-red-100":"border-transparent text-red-300 hover:text-white hover:border-white focus:text-white focus:border-white"]),"aria-current":t.active?"page":""},{default:r(()=>[e("div",F,[(n(),d("svg",{class:w(["transition duration-150 fill-current",t.active?"text-white group-focus:text-red-100":"text-red-300 hover:text-white group-hover:text-white group-focus:text-red-100"]),viewBox:"0 0 20 20",fill:"currentColor"},[x(o.$slots,"default")],2))]),e("span",null,h(t.title),1)]),_:3},8,["href","class","aria-current"])}const W=u(V,[["render",P]]),R={name:"LayoutEditOrganisation",components:{TabItem:W},props:{organisation:Object,endPath:String}},q={slot:"nav"},G={class:"mt-6"},J=e("div",{class:"sm:hidden"},[e("select",{"aria-label":"Selected tab",class:"block w-full form-select"},[e("option",{selected:""}," Allgemeines "),e("option",null," Benutzer ")])],-1),K={class:"hidden sm:block"},Q={class:"border-b border-red-500"},U={class:"flex -mb-px space-x-8"},X=e("path",{"fill-rule":"evenodd",d:"M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z","clip-rule":"evenodd"},null,-1);function Y(o,s,t,f,g,c){const a=i("TabItem"),m=i("Header");return n(),d("div",null,[l(m,{title:t.organisation.name},{default:r(()=>[e("div",q,[e("div",G,[J,e("div",K,[e("div",Q,[e("nav",U,[l(a,{title:"Allgemeines",href:o.route("admin.organisations.edit",[t.organisation.id]),active:t.endPath===""},{default:r(()=>[X]),_:1},8,["href","active"])])])])])])]),_:1},8,["title"]),e("main",null,[x(o.$slots,"default")])])}const Z=u(R,[["render",Y]]),ee={name:"Edit",metaInfo(){return{title:this.organisation.name}},layout:(o,s)=>o(k,[o(Z,{props:{organisation:s.context.props.organisation,endPath:""}},[s])]),components:{EventCard:H,CardContainer:O,TrashedMessage:N,TextareaInput:L,TextInput:T,LoadingButton:B,Header:C},props:{organisation:Object,events:Array},remember:"form",data(){return{sending:!1,form:{name:this.organisation.name,description:this.organisation.description}}},methods:{submit(){},destroy(){confirm("M\xF6chtest Du diese Organisation l\xF6schen?")&&this.$inertia.delete(this.route("admin.organisations.destroy",this.organisation.id))},restore(){confirm("M\xF6chtest Du diese Organisation wiederherstellen?")&&this.$inertia.put(this.route("admin.organisations.restore",this.organisation.id))}}},te={class:"pb-24"},oe=_(" Die Organisation wurde gel\xF6scht. "),ne={class:"mt-6 overflow-hidden rounded-lg shadow"},se={key:0,class:"relative w-full h-64 overflow-hidden rounded-t-lg"},ie=["src"],ae={class:"px-4 py-5 overflow-hidden bg-white sm:px-6"},re={class:"flex flex-wrap justify-between -mt-2 -ml-4 sm:flex-nowrap"},de={class:"flex flex-col items-center justify-center flex-shrink-0 w-32 mt-2 ml-4"},le=["src"],ce={class:"mt-2 ml-4"},me={class:"text-lg font-medium leading-6 text-gray-900"},he={class:"text-sm leading-5 text-gray-500"},ue={class:"flex flex-col justify-center flex-shrink-0 w-32 mt-2 ml-4"},_e=_("Folgen"),fe=_("Beitreten"),ge={class:"grid grid-cols-3 gap-6 mt-6"};function pe(o,s,t,f,g,c){const a=i("Header"),m=i("TrashedMessage"),b=i("WhiteButton"),$=i("EventCard");return n(),d("div",te,[l(a,{href:o.route("admin.organisations.index"),previousTitle:"Organisationen",class:"mb-8"},{default:r(()=>[_(h(t.organisation.name),1)]),_:1},8,["href"]),t.organisation.deleted_at?(n(),v(m,{key:0,class:"mb-6",onRestore:c.restore},{default:r(()=>[oe]),_:1},8,["onRestore"])):y("",!0),e("div",ne,[t.organisation.header_path?(n(),d("div",se,[e("img",{class:"absolute object-cover object-center w-full h-full",src:t.organisation.header_path},null,8,ie)])):y("",!0),e("div",ae,[e("div",re,[e("div",de,[e("img",{class:"object-scale-down object-center w-32 h-auto",src:t.organisation.logo_path,alt:""},null,8,le)]),e("div",ce,[e("h3",me,h(t.organisation.name),1),e("p",he,h(t.organisation.description),1)]),e("div",ue,[l(b,null,{default:r(()=>[_e]),_:1}),l(b,{class:"mt-2"},{default:r(()=>[fe]),_:1})])])])]),e("div",ge,[(n(!0),d(I,null,E(t.events,(p,ve)=>(n(),v($,{event:p,key:p.id,href:o.route("admin.organisations.events.edit",[t.organisation.id,p.id]),class:"col-span-1"},null,8,["event","href"]))),128))])])}const Le=u(ee,[["render",pe]]);export{Le as default};