import{o as s,b as o,F as r,aT as l,f as a,a as t,t as c}from"./app-f0d7f9c0.js";const d={key:0},_=t("h1",{class:"text-lg font-semibold text-secondhand-orange-300"},"Riwayat Alergi",-1),p={class:"mb-3"},h={class:"text-base font-medium text-secondhand-orange-300"},w={class:"w-full mx-auto text-base text-left text-neutral-grey-200"},y={class:"w-full"},g={class:"bg-original-white-0"},u=t("th",{scope:"row",class:"px-6 py-2 font-semibold whitespace-nowrap w-1/4"}," Jenis Alergi ",-1),b={class:"px-6 py-2 w-3/4"},x={key:0},f={key:1},k={key:0,class:"bg-original-white-0"},S=t("th",{scope:"row",class:"px-6 py-2 font-semibold whitespace-nowrap w-1/4"}," Clinical Status ",-1),m={key:0,class:"px-6 py-2 w-3/4"},j={class:"bg-original-white-0"},v=t("th",{scope:"row",class:"px-6 py-2 font-semibold whitespace-nowrap w-1/4"}," Verification Status ",-1),A={key:0,class:"px-6 py-2 w-3/4"},B={class:"bg-original-white-0"},V=t("th",{scope:"row",class:"px-6 py-2 font-semibold whitespace-nowrap w-1/4"}," Kategori ",-1),C={key:0,class:"px-6 py-2 w-3/4"},q={__name:"AllergyIntolerances",props:{object:{type:Object,required:!1}},setup(i){return(F,K)=>i.object?(s(),o("div",d,[_,(s(!0),o(r,null,l(i.object,(e,n)=>(s(),o("div",p,[t("h2",h,"Alergi: "+c(n+1),1),t("table",w,[t("tbody",y,[t("tr",g,[u,t("td",b,[e.code.coding?(s(),o("p",x,c(e.code.coding[0].display),1)):a("",!0),e.code.text?(s(),o("p",f,"Keterangan: "+c(e.code.text),1)):a("",!0)])]),e.bodySite?(s(),o("tr",k,[S,e.clinicalStatus?(s(),o("td",m,c(e.clinicalStatus.coding[0].display),1)):a("",!0)])):a("",!0),t("tr",j,[v,e.verificationStatus?(s(),o("td",A,c(e.verificationStatus.coding[0].display),1)):a("",!0)]),t("tr",B,[V,e.category?(s(),o("td",C,c(e.category[0]),1)):a("",!0)])])])]))),256))])):a("",!0)}};export{q as default};
