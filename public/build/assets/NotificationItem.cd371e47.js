import{_ as o}from"./_plugin-vue_export-helper.cdc0426e.js";import{o as a,c as n,a as t,t as i,d as c}from"./app.23e9e7df.js";/* empty css            */const d={name:"NotificationItem",props:{notification:{type:Object,required:!0}}},r={class:"block transition duration-150 ease-in-out hover:bg-gray-50 focus:outline-none focus:bg-gray-50"},l={class:"flex items-center px-4 py-4 sm:px-6"},m={class:"flex items-center flex-1 min-w-0"},_=t("div",{class:"flex-shrink-0"},[t("div",{class:"flex items-center justify-center w-12 h-12 bg-red-300 rounded-full"},[t("svg",{class:"w-8 h-8 text-red-500",viewBox:"0 0 20 20",fill:"currentColor"},[t("path",{d:"M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6zM10 18a3 3 0 01-3-3h6a3 3 0 01-3 3z"})])])],-1),f={class:"flex-1 min-w-0 px-4"},u={class:"text-lg font-medium leading-6 text-gray-900 truncate"},x={class:"text-sm leading-5 text-gray-700"},h=c(" erhalten am "),g=["datetime"],p={class:"flex items-center mt-1 text-sm leading-5 text-gray-500"};function v(s,y,e,b,w,M){return a(),n("a",r,[t("div",l,[t("div",m,[_,t("div",f,[t("div",null,[t("div",null,[t("h1",u,i(e.notification.data.title),1),t("div",x,[h,t("time",{datetime:e.notification.created_at},i(e.notification.created_at|s.moment("dddd, Do MMM [um] H:mm")),9,g)])]),t("div",p,[t("p",null,i(e.notification.data.description),1)])])])])])])}const V=o(d,[["render",v]]);export{V as default};