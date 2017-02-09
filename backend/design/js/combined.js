/**
 * Created by Jurii on 07.02.2017.
 */

// Turn on automatic storage of JSON objects passed as the cookie value. Assumes JSON.stringify and JSON.parse:
$.cookie.json = true;
// проверка localStorage
if (!store.enabled) {
    alert('Local storage is not supported by your browser. Please disable "Private Mode", or upgrade to a modern browser.');
}
