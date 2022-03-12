import col from "./components/col";
import row from "./components/row";
import search from "./components/search";
import inertable from "./components/inertable";
import simplePagination from "./components/simple-pagination";

export default {
  install(app, options) {
    app.component("v-row", row);
    app.component("v-col", col);
    app.component("v-search", search);
    app.component("v-inertable", inertable);
    app.component("v-simple-pagination", simplePagination);
  },
};
