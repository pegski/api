(function () {
    'use strict';

    // define variables
    var items = document.querySelectorAll(".timeline li");

    // check if an element is in viewport
    // http://stackoverflow.com/questions/123999/how-to-tell-if-a-dom-element-is-visible-in-the-current-viewport
    function isElementInViewport(el) {
        var rect = el.getBoundingClientRect();
        return (
            rect.top >= 0 &&
            rect.left >= 0 &&
            rect.bottom <= (window.innerHeight || document.documentElement.clientHeight) &&
            rect.right <= (window.innerWidth || document.documentElement.clientWidth)
        );
    }

    function callbackFunc() {
        for (var i = 0; i < items.length; i++) {
            if (isElementInViewport(items[i])) {
                items[i].classList.add("in-view");
            }
        }
    }

    function reqListener() {
        var response = JSON.parse(this.responseText);
        var pegsContainer = $('.pegski-recent-pegs');

        response.data.pegs.map(function (peg) {
            var description = '';
            var image = '/bundles/pegweb/img/kluut.jpg';

            if (peg.pegEvents.length > 0) {
                var eventWithImage = peg.pegEvents.find(function (event) {
                    return event.pictureUrl !== undefined && event.pictureUrl !== null;
                });
                if (eventWithImage) {
                    image = eventWithImage.pictureUrl;
                }
            }

            if (description.length > 15) description = description.substring(0, 15) + ' ...';

            pegsContainer.append(
                '<a href="' + Routing.generate('web_timeline', {'shortcode': peg.shortcode}) + '">' +
                '<div class="col-md-3"><div class="pegski-peg-block" style=""><div class="pegski-peg-image" style="background-image: url(\'' + image + '\');"></div><div class="pegski-peg-description"><i class="icon-noun_33349_cc" aria-hidden="true"></i> ' + description + ' <span class="peg-owner">' +
                peg.shortcode +
                '</span></div></div></div></a>'
            );
        });
    }

    function fetchPegs() {
        var fetchPegsQuery = `
            query GetAllPegs {
              pegs {
                shortcode
                pegEvents(type: TYPE_PICTURE, order: DESC) {
                  description
                  location
                  comment
                  pictureUrl
                }
              }
            }
        `;

        window.graphQLFetch(fetchPegsQuery, {}, reqListener);
    }

    fetchPegs();

    // listen for events
    window.addEventListener("load", callbackFunc);
    window.addEventListener("resize", callbackFunc);
    window.addEventListener("scroll", callbackFunc);

    $('#registerPeg').click(function (event) {
        event.preventDefault();

        var fetchPegsQuery = 'mutation NewPeg { createPeg { shortcode } }';
        window.graphQLFetch(fetchPegsQuery, {}, function () {
            var response = JSON.parse(this.responseText);
            var shortcode = response.data.createPeg.shortcode;
            window.location = Routing.generate('web_timeline', {'shortcode': shortcode});
        });
    });
})();
