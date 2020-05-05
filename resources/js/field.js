Nova.booting((Vue, router, store) => {
    Vue.component("index-check-address", require("./components/IndexField"));
    Vue.component("detail-check-address", require("./components/DetailField"));
    Vue.component("form-check-address", require("./components/FormField"));
});
