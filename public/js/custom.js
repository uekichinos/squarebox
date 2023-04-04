/* close success/error notification */
function closeAlert(event) {
    document.querySelectorAll("div[notify='" + event + "']").forEach(function (e) {
        e.parentElement.removeChild(e);
    });
}