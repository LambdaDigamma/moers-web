import{H as y}from"./Header.2e288ca0.js";import{L as v}from"./LayoutGeneral.c195b571.js";import{L as I}from"./LoadingButton.b1245eef.js";import{I as q}from"./Icon.9132b7bb.js";import{j as c,o as i,g as d,i as e,y as r,l as h,w as L,G as P,q as V,z as f,F as C,A as O,n as g,p as k,m,t as u,x as S}from"./vendor.92b77dc9.js";import{_ as b}from"./plugin-vue_export-helper.21dcd24c.js";import{P as B}from"./PollResult.9a40db01.js";import"./index.9ddc5a14.js";import"./FlashMessages.f55ef714.js";import"./MenuGeneralMobile.0fcff5dc.js";import"./chartjs-plugin-datalabels.esm.50b1de3b.js";const j={name:"PollVote",components:{Icon:q,LoadingButton:I},props:{poll:{type:Object,required:!0}},data(){return{selectionIndex:[],query:"",sending:!1}},methods:{vote(){const t={poll_id:this.poll.id,options:this.selectionIndex};this.sending=!0,this.$inertia.post(this.route("polls.vote",this.poll.id),t,{onSuccess:()=>{this.sending=!1}})},abstain(){this.$inertia.post()},clickedOption(t){if(this.poll.is_radio)this.selectionIndex=[],this.selectionIndex.push(t);else if(this.selectionIndex.includes(t)){const o=this.selectionIndex.indexOf(t);this.selectionIndex.splice(o,1)}else this.selectionIndex.length<this.poll.max_check&&this.selectionIndex.push(t)}},computed:{filteredOptions(){if(this.query==="")return this.poll.options;{let t=this.query.toLowerCase();return this.poll.options.filter(function(o){return o.name.toLowerCase().includes(t)})}}}},A={class:"mt-0"},D={class:"text-2xl font-semibold dark:text-white"},H={class:"text-base font-normal dark:text-white"},N={class:"mt-2"},E={class:"flex items-stretch w-full my-3"},T={class:"flex items-center pl-1 rounded-l dark:bg-gray-800"},z={class:""},F=["onClick"],G={class:"px-2 py-2 dark:text-white"},K={key:0,class:"flex items-center justify-center w-24 dark:bg-green-700"},M=e("span",{class:"font-medium dark:text-white"},"Ausgew\xE4hlt",-1),R=[M],U={class:"mt-2 ml-1 dark:text-gray-600"},W=u(" Abstimmen "),Z=u(" Ich m\xF6chte mich enthalten. ");function J(t,o,s,w,n,a){const _=c("icon"),p=c("LoadingButton"),x=c("inertia-link");return i(),d("div",null,[e("div",A,[e("h1",D,r(s.poll.question),1),e("p",H,r(s.poll.description),1)]),e("form",{onSubmit:o[2]||(o[2]=f((...l)=>a.vote&&a.vote(...l),["prevent"]))},[e("div",N,[e("div",E,[e("div",T,[h(_,{name:"search",class:"w-4 h-4 m-2 dark:fill-white"})]),L(e("input",{onKeydown:o[0]||(o[0]=V(f(()=>{},["prevent"]),["enter"])),"onUpdate:modelValue":o[1]||(o[1]=l=>n.query=l),placeholder:"Suchen\u2026",type:"text",class:"w-full px-2 py-2 rounded-r md:px-2 md:py-3 focus:ring dark:text-white dark:bg-gray-600"},null,544),[[P,n.query]])]),e("div",z,[(i(!0),d(C,null,O(a.filteredOptions,l=>(i(),d("div",{class:g(["flex justify-between mt-1 border-4 border-transparent rounded dark:bg-gray-600",{"border-green-700":n.selectionIndex.includes(l.id)}]),key:l.id,onClick:ae=>a.clickedOption(l.id)},[e("span",G,r(l.name),1),n.selectionIndex.includes(l.id)?(i(),d("div",K,R)):k("",!0)],10,F))),128))]),e("p",U,[e("em",null,r(n.selectionIndex.length)+"/"+r(s.poll.max_check)+" Antworten ausgew\xE4hlt",1)])]),h(p,{disabled:n.selectionIndex.length!==s.poll.max_check,loading:n.sending,type:"submit",onSubmit:f(a.vote,["prevent"]),class:g(["px-3 py-2 font-semibold rounded-lg dark:text-white dark:bg-green-700",{"dark-hover:bg-green-800":n.selectionIndex.length===s.poll.max_check}])},{default:m(()=>[W]),_:1},8,["disabled","loading","onSubmit","class"])],32),h(x,{href:t.route("polls.abstain",this.poll.id),method:"post",class:"block mt-3 dark:text-white"},{default:m(()=>[Z]),_:1},8,["href"])])}var Q=b(j,[["render",J]]);const X={name:"Show",components:{PollResult:B,PollVote:Q,Header:y},layout:v,props:{poll:Object,nextPoll:Object},created(){this.$root.$emit("newTitle","Details")}},Y={class:"lg:w-1/2"},$=u(" Details "),ee={key:0,class:"flex flex-row my-3"},te=u(" Zur n\xE4chsten Abstimmung "),se={class:"p-3 mb-6 rounded-lg shadow-lg dark:bg-gray-700"},oe={key:1},ne={class:"text-xl font-bold md:text-3xl dark:text-white"},le={class:"text-base dark:text-white"},ie=e("h2",{class:"mt-3 mb-0 text-lg font-semibold dark:text-white"}," Ergebnisse: ",-1),re=e("p",{class:"mt-2 font-medium dark:text-white"}," Die Ergebnisse werden auf Wunsch bis auf weiteres versteckt gehalten. ",-1);function de(t,o,s,w,n,a){const _=c("Header"),p=c("inertia-link"),x=c("PollVote");return i(),d("div",Y,[h(_,{href:t.route("polls.index"),"previous-title":"Abstimmungen"},{default:m(()=>[$]),_:1},8,["href"]),s.nextPoll&&s.poll.results!==null?(i(),d("div",ee,[h(p,{href:t.route("polls.show",s.nextPoll.id),class:"block px-3 py-2 text-base font-semibold rounded-lg dark:bg-yellow-500 dark:text-black"},{default:m(()=>[te]),_:1},8,["href"])])):k("",!0),e("div",se,[s.poll.results===null?(i(),S(x,{key:0,poll:s.poll},null,8,["poll"])):(i(),d("div",oe,[e("h1",ne,r(s.poll.question),1),e("p",le,r(s.poll.description),1),ie,re]))])])}var we=b(X,[["render",de]]);export{we as default};