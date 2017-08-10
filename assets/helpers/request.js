let cache = {};
let $ = window.jQuery;
/**
 * Makes sure all the requests are cached
 * @param data
 * @returns {*}
 */
export default function (data) {
    let cacheKey = JSON.stringify(data);
    if (cache[cacheKey]) {
        return cache[cacheKey];
    }
    let req = $.ajax({
        dataType: "json",
        url: window.ajaxurl,
        data: data,
        method: 'POST'
    });
    //  let req = $.getJSON(window.ajaxurl, data);
    cache[cacheKey] = req;
    return req;
}