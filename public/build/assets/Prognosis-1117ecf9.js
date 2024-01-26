import{r as i,aD as q,o as f,b as v,a as t,d as o,u as b,w as D,f as h,g as I,bE as c,e as $}from"./app-f0d7f9c0.js";import{s as _}from"./default-7ffdeea9.js";import{_ as O}from"./MainButtonSmall-93327a9a.js";import{_ as w}from"./TextInput-beb043c0.js";import{_ as n}from"./InputError-5b64019f.js";import{_ as r}from"./InputLabel-1f97d873.js";const U=["onSubmit"],L={class:"my-2 w-full"},N=t("h3",{class:"font-semibold text-secondhand-orange-300 mt-2"},"Prognosis",-1),B={class:"flex space-x-2"},E={class:"w-full md:w-7/12"},R={class:"flex"},A={class:"w-full md:w-5/12"},M={class:"flex"},F={class:"flex mt-3 space-x-2"},G={class:"w-full md:w-7/12"},H={class:"flex"},Z={class:"w-full md:w-5/12"},z={class:"flex"},J={class:"flex mt-3"},K={class:"w-full"},Q={class:"flex"},W={class:"flex justify-end"},X={class:"mt-2 mr-3"},Y={key:0,class:"text-sm text-original-teal-300"},ee={key:1,class:"text-sm text-thirdouter-red-300"},ne={__name:"Prognosis",props:{practitioner_reference:{type:Object,required:!1},subject_reference:{type:Object,required:!1},encounter_reference:{type:Object,required:!0}},setup(C){const d=C,e=i([{description:"",problem:null,summary:"",finding:null,investigation:null,prognosisCodeableConcept:null}]),u=i(!1),p=i(!1),V=()=>{const a=new Date().toISOString().replace("Z","+00:00").replace(/\.\d{3}/,""),l={resourceType:"ClinicalImpression",status:"completed",description:e.value.description,subject:d.subject_reference,encounter:d.encounter_reference,effectiveDateTime:a,date:a,assessor:d.practitioner_reference,investigation:[{code:{coding:[{system:e.value.investigation.system,code:e.value.investigation.code,display:e.value.investigation.display}]}}],summary:e.value.summary,finding:[{itemCodeableConcept:{coding:[{system:e.value.finding.system,code:e.value.finding.code,display:e.value.finding.display_en}]}}],prognosisCodeableConcept:[{coding:[{system:e.value.prognosisCodeableConcept.system,code:e.value.prognosisCodeableConcept.code,display:e.value.prognosisCodeableConcept.display}]}]};c.post(route("integration.store",{res_type:l.resourceType}),l).then(s=>{u.value=!0,setTimeout(()=>{u.value=!1},3e3)}).catch(s=>{console.error("Error creating user:",s),p.value=!0,setTimeout(()=>{p.value=!1},3e3)})},k=async a=>{const{data:l}=await c.get(route("terminologi.icd10",{search:a})),s=l;for(const T in s){const g=s[T],S=`${g.display_id} | Code: ${g.code}`;g.label=S}return s},y=i(null),j=async()=>{const{data:a}=await c.get(route("terminologi.get"),{params:{resourceType:"ClinicalImpression",attribute:"prognosisCodeableConcept"}});y.value=a},x=i(null),P=async()=>{const{data:a}=await c.get(route("terminologi.get"),{params:{resourceType:"ClinicalImpressionInvestigation",attribute:"code"}});x.value=a},m={container:"relative mx-auto w-full flex items-center justify-end box-border cursor-pointer border-2 border-neutral-grey-0 ring-0 shadow-sm rounded-xl bg-white text-sm leading-snug outline-none",search:"w-full absolute inset-0 outline-none border-0 ring-0 focus:ring-original-teal-300 focus:ring-2 appearance-none box-border text-sm font-sans bg-white rounded-xl pl-3.5 rtl:pl-0 rtl:pr-3.5",placeholder:"flex items-center h-full absolute left-0 top-0 pointer-events-none bg-transparent leading-snug pl-3.5 text-gray-500 rtl:left-auto rtl:right-0 rtl:pl-0 rtl:pr-3.5",option:"flex items-center justify-start box-border text-left cursor-pointer text-sm leading-snug py-1.5 px-3",optionPointed:"text-white bg-original-teal-300",optionSelected:"text-white bg-original-teal-300",optionDisabled:"text-gray-300 cursor-not-allowed",optionSelectedPointed:"text-white bg-original-teal-300 opacity-90",optionSelectedDisabled:"text-green-100 bg-original-teal-300 bg-opacity-50 cursor-not-allowed"};return q(()=>{j(),P()}),(a,l)=>(f(),v("div",null,[t("form",{onSubmit:I(V,["prevent"])},[t("div",L,[N,t("div",B,[t("div",E,[o(r,{for:"description",value:"Deskripsi"}),t("div",R,[o(w,{modelValue:e.value.description,"onUpdate:modelValue":l[0]||(l[0]=s=>e.value.description=s),id:"description",type:"text",class:"text-sm mt-1 block w-full",placeholder:"Deskripsi",required:""},null,8,["modelValue"])]),o(n,{class:"mt-1"})]),t("div",A,[o(r,{for:"investigation",value:"Investigasi"}),t("div",M,[o(b(_),{modelValue:e.value.investigation,"onUpdate:modelValue":l[1]||(l[1]=s=>e.value.investigation=s),mode:"single",placeholder:"Investigasi",object:!0,options:x.value,label:"display",valueProp:"code","track-by":"code",class:"mt-1",classes:m,required:""},null,8,["modelValue","options"])]),o(n,{class:"mt-1"})])]),t("div",F,[t("div",G,[o(r,{for:"finding",value:"Temuan"}),t("div",H,[o(b(_),{modelValue:e.value.finding,"onUpdate:modelValue":l[2]||(l[2]=s=>e.value.finding=s),mode:"single",placeholder:"Temuan","filter-results":!1,object:!0,"min-chars":1,"resolve-on-load":!1,delay:1e3,searchable:!0,options:k,label:"label",valueProp:"code","track-by":"code",class:"mt-1",classes:m,required:""},null,8,["modelValue"])]),o(n,{class:"mt-1"})]),t("div",Z,[o(r,{for:"prognosisCodeableConcept",value:"Hasil Prognosis"}),t("div",z,[o(b(_),{modelValue:e.value.prognosisCodeableConcept,"onUpdate:modelValue":l[3]||(l[3]=s=>e.value.prognosisCodeableConcept=s),mode:"single",placeholder:"Problem",object:!0,options:y.value,label:"display",valueProp:"code","track-by":"code",class:"mt-1",classes:m,required:""},null,8,["modelValue","options"])]),o(n,{class:"mt-1"})])]),t("div",J,[t("div",K,[o(r,{for:"summary",value:"Ringkasan"}),t("div",Q,[o(w,{modelValue:e.value.summary,"onUpdate:modelValue":l[4]||(l[4]=s=>e.value.summary=s),id:"summary",type:"text",class:"text-sm mt-1 block w-full",placeholder:"Ringkasan",required:""},null,8,["modelValue"])]),o(n,{class:"mt-1"})])])]),t("div",W,[t("div",X,[o(O,{type:"submit",class:"teal-button text-original-white-0"},{default:D(()=>[$("Submit")]),_:1})])]),u.value?(f(),v("p",Y,"Sukses!")):h("",!0),p.value?(f(),v("p",ee,"Gagal!")):h("",!0)],40,U)]))}};export{ne as default};
