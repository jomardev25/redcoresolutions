import Vue from "vue";
import VueEvents from "vue-events";
import Vuelidate from "vuelidate";
import VuelidateErrorExtractor, {
    templates
} from "vuelidate-error-extractor";
import VueTableAction from "@/components/vuetable/VueTableAction";
import VueTable from "@/components/vuetable/Index";
import Multiselect from "vue-multiselect";

import validationMessages from "@/helpers/validationMessages";
import ButtonLoader from "@/components/form/ButtonLoader";
import Card from "@/components/Card";
import FormGroup from "@/components/form/FormGroup";
import MessageBox from "@/components/messagebox";
import Modal from "@/components/Modal";

import router from "@/router";
import store from "@/store";
import "@/directives";
import "@/loader";
import "@/permissions";

Vue.config.productionTip = false;
Vue.config.devtools = false;
Vue.prototype.$MessageBox = MessageBox;

Vue.use(VuelidateErrorExtractor, {
    template: FormGroup,
    messages: validationMessages
});

Vue.use(VueEvents);
Vue.use(Vuelidate);
Vue.component("ButtonLoader", ButtonLoader);
Vue.component("Card", Card);
Vue.component("FormWrapper", templates.FormWrapper);
Vue.component("Modal", Modal);
Vue.component("Multiselect", Multiselect);
Vue.component("VueTableAction", VueTableAction);
Vue.component("VueTable", VueTable);

window.onerror = function(message, source, line, column, error){
    store.dispatch("app/resetLoading");
    console.error("window.error:", message, source, line, column, error);
};

new Vue({
    router,
    store,
    el: "#app"
}).$mount("#app");
