(window.webpackJsonp=window.webpackJsonp||[]).push([[9],{128:function(t,e,s){"use strict";s.r(e);var o={name:"RoleIndex",data:function(){return{showModal:!1,fields:[{name:"__sequence",title:"#",titleClass:"text-center",dataClass:"text-center",width:"10%"},{name:"name",sortField:"name",width:"30%"},{name:"description",sortField:"description",width:"30%"},{name:"__component:vue-table-action",title:"Actions",titleClass:"text-center",dataClass:"text-center",width:"30%"}],sortOrder:[{field:"name",sortField:"name",direction:"asc"}],role:{name:"",description:""}}},events:{"vue-table-view-item":function(t){this.role.name=t.name,this.role.description=t.description,this.showModal=!0}}},r=s(0),a=Object(r.a)(o,(function(){var t=this,e=t.$createElement,s=t._self._c||e;return s("div",{staticClass:"w-100"},[s("card",{scopedSlots:t._u([{key:"header",fn:function(){return[s("h6",{staticClass:"card__title"},[t._v("Role List")])]},proxy:!0}])},[t._v(" "),s("vue-table",{attrs:{"api-url":"/roles","api-url-delete":"/roles","edit-route-name":"roles.edit",fields:t.fields,"sort-order":t.sortOrder},scopedSlots:t._u([{key:"custom-actions",fn:function(){return[s("router-link",{staticClass:"btn btn--primary",attrs:{to:{name:"roles.create"}}},[s("i",{staticClass:"fa fa-plus"}),t._v(" Add New\n                ")])]},proxy:!0}])})],1),t._v(" "),t.showModal?s("modal",{attrs:{"header-class":"modal__header--primary"},on:{close:function(e){t.showModal=!1}},scopedSlots:t._u([{key:"header",fn:function(){return[s("h3",[t._v("Role Details")])]},proxy:!0},{key:"footer",fn:function(){return[s("button",{staticClass:"btn btn--primary",on:{click:function(e){t.showModal=!1}}},[t._v("OK")])]},proxy:!0}],null,!1,387087142)},[t._v(" "),s("form-group",{attrs:{label:"Name"}},[s("input",{staticClass:"form-group__input",attrs:{type:"text",disabled:""},domProps:{value:t.role.name}})]),t._v(" "),s("form-group",{attrs:{label:"Description"}},[s("input",{staticClass:"form-group__input",attrs:{type:"text",disabled:""},domProps:{value:t.role.description}})])],1):t._e()],1)}),[],!1,null,null,null);e.default=a.exports}}]);