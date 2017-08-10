import Select from "./fields/Select";

import download from './ui/download';

const $ = window.jQuery;
(function () {

    $(function () {
        if ($('body').hasClass('toplevel_page_telemetry_calendar')) {
            calendar();
        }
    });

})();