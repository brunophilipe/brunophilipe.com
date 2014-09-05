function loadStyleSheet(path) {
    var head = document.getElementsByTagName('head')[0], // reference to document.head for appending/ removing link nodes
        link = document.createElement('link'); // create the link node
    link.setAttribute('href', path);
    link.setAttribute('rel', 'stylesheet');
    link.setAttribute('type', 'text/css');
    link.setAttribute('id', 'partystyle');

    var sheet, cssRules;
    // get the correct properties to check for depending on the browser
    if ('sheet' in link) {
        sheet = 'sheet';
        cssRules = 'cssRules';
    } else {
        sheet = 'styleSheet';
        cssRules = 'rules';
    }

    head.appendChild(link); // insert the link node into the DOM and start loading the style sheet

    startParty();

    return link; // return the link node;
}

function startParty() {
    $('.container').append("<audio id=\"player\" src=\"js/hoedown.mp3\" autoplay></audio>");
    $('.content').append("<p onClick=\"stopParty();\">stop</p>");

    var count = 0;

    window.setInterval(function() {
        if (count == 1) {
            $('#fb').css('background-color', '#f66');
        } else if (count == 10) {
            $('#fb').css('background-color', '');
        };
        count++;
    }, 200);
}

function stopParty() {
    $('#player').remove();
    $('#partystyle').remove();
}