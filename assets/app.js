import $ from "jquery";
global.$ = global.jQuery = $;
// import { Chart, registerables } from 'chart.js'
// Chart.register(...registerables);
// window.Chart = Chart;
import { startStimulusApp } from "@symfony/stimulus-bridge";
export const app = startStimulusApp(
    require.context(
        "@symfony/stimulus-bridge/lazy-controller-loader!./controllers",
        true,
        /\.(j|t)sx?$/
    )
);

import "./styles/app.scss";
import "./js/header";
import "./js/dataTable";
import "./js/main";
import "../node_modules/datatables.net/js/jquery.dataTables.min.js";

import a2lix_lib from "@a2lix/symfony-collection/dist/a2lix_sf_collection.min";
a2lix_lib.sfCollection.init();
