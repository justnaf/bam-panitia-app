import './bootstrap';

import Alpine from 'alpinejs';
import { Html5Qrcode, Html5QrcodeScanner } from "html5-qrcode";

window.Alpine = Alpine;
import('sweetalert2').then(module => {
    window.Swal = module.default;
});
window.Html5Qrcode = Html5Qrcode;
window.Html5QrcodeScanner = Html5QrcodeScanner;

// Dynamically import Chart.js
import('chart.js').then(module => {
    const { Chart, registerables } = module;
    Chart.register(...registerables);
    window.Chart = Chart;
    console.log("Chart.js loaded successfully!");
}).catch(error => console.error("Chart.js failed to load:", error));
Alpine.start();
