import{T as p,o as i,c as x,w as l,a as e,b as m,t as g,d as o,e as c,u as s,i as w,f as u,n,g as h}from"./app-f0d7f9c0.js";import{_ as k}from"./MainButton-87431bfc.js";import{_}from"./GuestLayout-d99622c6.js";import{_ as C}from"./InputError-5b64019f.js";import{_ as v}from"./TextInput-beb043c0.js";import"./AppHead-4fb5dcc8.js";const y=e("title",null,"Lupa Password - ",-1),V={class:"flex flex-col justify-center items-center lg:flex-row lg:border lg:rounded-3xl lg:shadow-lg bg-original-white-0 p-6"},j={key:0,class:"absolute mb-1"},B=e("div",{class:"flex justify-center items-center mb-6 text-original-teal-300"},[e("svg",{xmlns:"http://www.w3.org/2000/svg",width:"125",height:"125",viewBox:"0 0 185 185",fill:"none"},[e("path",{d:"M72.3382 76.1681L94.0795 95.386C96.872 97.8544 101.095 97.7536 103.766 95.1548L153.32 46.9502",stroke:"currentColor","stroke-width":"14.25","stroke-linecap":"round"}),e("path",{d:"M156.418 97.2362C155.343 110.591 150.111 123.274 141.457 133.504C132.804 143.733 121.164 150.994 108.171 154.269C95.179 157.543 81.4875 156.666 69.0195 151.759C56.5516 146.853 45.9336 138.165 38.6569 126.915C31.3801 115.664 27.81 102.417 28.4482 89.0341C29.0863 75.6508 33.9005 62.8035 42.2146 52.2967C50.5288 41.7898 61.9252 34.1511 74.8034 30.4534C87.6816 26.7557 101.394 27.1848 114.016 31.6804",stroke:"currentColor","stroke-width":"14.25","stroke-linecap":"round"})])],-1),L={class:"w-[75%] mx-auto mb-5 text-center font-medium text-base text-neutral-black-300"},S=e("h1",{class:"font-bold text-2xl text-center mb-5 text-neutral-black-300"},"Lupa Password?",-1),M=e("div",{class:"text-sm mb-7"},[e("p",{class:"text-center"}," Silahkan masukkan email akun Anda, dan kami akan mengirimkan tautan untuk membantu Anda kembali ke akun Anda. ")],-1),N=["onSubmit"],P={class:"mb-5"},E={__name:"ForgotPassword",props:{status:{type:String}},setup(a){const t=p({email:""}),d=()=>{t.post(route("password.email"))};return(f,r)=>(i(),x(_,null,{apphead:l(()=>[y]),default:l(()=>[e("div",V,[a.status?(i(),m("div",j,[B,e("p",L,g(a.status),1),o(s(w),{href:f.route("login"),as:"button",class:"mx-auto mb-3 w-full max-w-[284px] block justify-center px-4 py-2 border border-transparent rounded-lg font-semibold text-sm teal-button text-original-white-0 transition ease-in-out duration-150 hover:shadow-lg"},{default:l(()=>[c(" Kembali ke Login ")]),_:1},8,["href"])])):u("",!0),e("img",{src:"storage/images/welcome-doctor.png",class:n(["w-full h-full block max-w-lg my-4",{invisible:a.status}]),alt:""},null,2),e("div",{class:n(["w-full max-w-lg lg:w-96 flex flex-col justify-center items-center px-10 pt-2 pb-5",{invisible:a.status}])},[S,M,a.status?u("",!0):(i(),m("form",{key:0,class:"w-full flex flex-col justify-center",onSubmit:h(d,["prevent"])},[e("div",P,[o(v,{id:"email",type:"email",class:"mt-1 block w-full",modelValue:s(t).email,"onUpdate:modelValue":r[0]||(r[0]=b=>s(t).email=b),required:"",autofocus:"",autocomplete:"username",placeholder:"Masukkan email"},null,8,["modelValue"]),o(C,{class:"mt-2",message:s(t).errors.email},null,8,["message"])]),o(k,{class:n([{"opacity-25":s(t).processing},"teal-button text-original-white-0"]),disabled:s(t).processing},{default:l(()=>[c(" Reset Password ")]),_:1},8,["class","disabled"])],40,N))],2)])]),_:1}))}};export{E as default};
