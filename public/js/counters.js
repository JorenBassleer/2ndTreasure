function animateValue(id, start, end, duration) {
    var range = end - start;
    var current = start;
    var increment = end > start? 1 : -1;
    var stepTime = Math.abs(Math.floor(duration / range));
    var obj = document.getElementById(id);
    var timer = setInterval(function() {
        current += increment;
        obj.innerHTML = current;
        if (current == end) {
            clearInterval(timer);
        }
    }, stepTime);
}

$(function() {
    animateValue("kg-donated", 0, $('#kg-donated').attr('data-target'), 5000);
    animateValue("goodiebags-created", 0, $('#goodiebags-created').attr('data-target'), 5000);
    animateValue("people-helped", 0, $('#people-helped').attr('data-target'), 5000);
});