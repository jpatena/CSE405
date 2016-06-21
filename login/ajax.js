// The following ajax function assumes that all data sent and received is in
// the form of a json encoded object sent using an http POST.

function ajax(url) {
    var httpRequest = new XMLHttpRequest();
    if (!httpRequest) {
        alert('Browser not supported.');
        return;
    }
    httpRequest.onreadystatechange = function() {
        if (httpRequest.readyState === XMLHttpRequest.DONE) {
            if (httpRequest.status === 200) {
                if (httpRequest.responseText.trim().length > 0) {
                    document.getElementById('error_message').innerHTML = httpRequest.responseText;
                }
            } else {
                alert('There was a problem with the request.');
                return;
            }
        }
    };
    httpRequest.open('POST', url);
    httpRequest.send();
}
