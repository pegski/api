(function () {

    'use strict';

    window.latestEventWasInversed = false;

    function decodeHtmlString(htmlString) {
        return escapeHtml(htmlString);
    }

    function reqListener() {
        $('ul.timeline li').not(':first').remove();

        var response = JSON.parse(this.responseText);
        var timelineContainer = $('ul.timeline');

        if (response.data.peg === null) {
            $('.peg-not-found').show();
            return;
        }

        response.data.peg.pegEvents.map(function (pegEvent, index) {

            pegEvent.pictureUrl = pegEvent.pictureUrl ? decodeHtmlString(pegEvent.pictureUrl) : null;
            pegEvent.location = pegEvent.location ? decodeHtmlString(pegEvent.location) : null;
            pegEvent.comment = pegEvent.comment ? decodeHtmlString(pegEvent.comment) : null;

            var inversion = index % 2 == 0 ? "timeline-inverted" : "timeline";
            var avatar = pegEvent.avatarUrl !== null ? pegEvent.avatarUrl + '?s=200' : '/bundles/pegweb/img/peg_logo.png';
            var image = pegEvent.pictureUrl !== null ? '<img class="img-responsive" src="' + pegEvent.pictureUrl + '"/>' : '';
            var timeSinceEvent = pegEvent.happenedAt !== null ? getTimeSinceDateString(pegEvent.happenedAt) + ' ago' : '';
            var locationString = pegEvent.location !== null ? ' in <i class="fa fa-location-arrow"></i> ' + pegEvent.location : '';
            var comment = pegEvent.comment !== null ? pegEvent.comment : '';
            var badge = getIconClassForPegEvent(pegEvent);

            var avatarHtml = '<img src="' + avatar + '" class="img-responsive img-circle" />';
            if (pegEvent.profileUrl) {
                avatarHtml = '<a href="' + pegEvent.profileUrl + '" target="_blank">' +
                        avatarHtml +
                    '</a>';
            }

            window.latestEventWasInversed = index % 2 == 0;

            timelineContainer.append('<li class="' + inversion + '">' +
                '<div class="timeline-avatar">' + avatarHtml + '</div>' +
                '<div class="timeline-badge"><i class="glyphicon glyphicon-' + badge + '"></i></div>' +
                '<div class="timeline-panel">' +
                '<div class="timeline-heading"><p><small class="text-muted"><i class="glyphicon glyphicon-time"></i> ' + timeSinceEvent + locationString + '</small></p>' +
                '</div><div class="timeline-body">' + image + comment + '</div></div></li>');
        });
    }

    function fetchPeg() {

        var fetchPegsQuery = `
            query MyPeg($pegShortcode: String!) {
              peg(shortcode: $pegShortcode) {
                shortcode
                pegEvents {
                  pictureUrl
                  description
                  location
                  comment
                  happenedAt
                  type
                  avatarUrl
                  profileUrl
                }
              }
            }
        `;

        window.graphQLFetch(fetchPegsQuery, {pegShortcode: window.pegShortcode}, reqListener);
    }

    function getIconClassForPegEvent(pegEvent) {
        var badge = 'comment';

        if (pegEvent.type !== undefined && pegEvent.type.indexOf('Location') > 0) {
            badge = 'map-marker';
        } else if (pegEvent.type.indexOf('Picture') > 0) {
            badge = 'picture';
        }

        return badge;
    }

    function getTimeSinceDateString(dateString) {
        var oneMinute = 60 * 1000; // hours*minutes*seconds*milliseconds
        var oneHour = 60 * oneMinute;
        var oneDay = 24 * oneHour;
        var oneMonth = 30 * oneDay; // approximately
        var firstDate = new Date();
        var secondDate = new Date(dateString);

        var diffMinutes = Math.round(Math.abs((firstDate.getTime() - secondDate.getTime()) / (oneMinute)));
        if (diffMinutes < 60) {
            var timeString = diffMinutes > 1 ? ' minutes' : ' minute';
            return diffMinutes + timeString;
        }

        var diffHours = Math.round(Math.abs((firstDate.getTime() - secondDate.getTime()) / (oneHour)));
        if (diffHours < 23) {
            var timeString = diffHours > 1 ? ' hours' : ' hour';
            return diffHours + timeString;
        }

        var diffDays = Math.round(Math.abs((firstDate.getTime() - secondDate.getTime()) / (oneDay)));
        if (diffDays < 30) {
            var timeString = diffDays > 1 ? ' days' : ' day';
            return diffDays + timeString;
        }

        var diffMonths = Math.round(Math.abs((firstDate.getTime() - secondDate.getTime()) / (oneMonth)));
        var timeString = diffMonths > 1 ? ' months' : ' month';
        return diffMonths + timeString;

    }

    fetchPeg();

    $('#addEvent').click(function () {
        var inversion = window.latestEventWasInversed == false ? "timeline-inverted" : "timeline";

        var timelineContainer = $('ul.timeline');
        $(timelineContainer).find('#new-event').remove();

        timelineContainer.prepend(
            '<li id="newEvent" class="' + inversion + '">' +
            '<div class="timeline-badge"><i class="glyphicon glyphicon-file"></i></div>' +
            '<div class="timeline-panel">' +
            '<div class="timeline-heading"><p>Add a new event to the peg</p></div>' +
            '<div class="timeline-body"><form>' +
            '<p><input type="email" name="email" placeholder="Optional email (Not exposed)"></p>' +
            '<p><input type="text" name="location" placeholder="Location"></p>' +
            '<p><input type="url" name="picture" placeholder="Picture URL"></p>' +
            '<p><input type="text" name="comment" placeholder="Comment"></p>' +
            '<p><button type="submit" class="btn btn-primary">Save changes</button></p>' +
            '</form></div>' +
            '</div>' +
            '</li>'
        );

        $('#newEvent form').submit(function (event) {
            event.preventDefault();

            // get all the inputs into an array.
            var inputs = $('#newEvent form :input:not([type="submit"])');

            // get an associative array of just the values.
            var values = {};
            inputs.each(function () {
                values[this.name] = $(this).val();
                $(this).val('');
            });

            var query = `
                query CreateEvent(
                  $pegShortcode: String!,
                  $inputPictureUrl: String!,
                  $inputComment: String,
                  $inputLocation: String,
                  $inputEmail: String) {
                  peg(shortcode: $pegShortcode) {
                    shortcode
                    createPegPictureEvent(
                      comment: $inputComment,
                      pictureUrl: $inputPictureUrl,
                      location: $inputLocation,
                      email: $inputEmail) {
                      id
                    }
                  }
                }
            `;

            window.graphQLFetch(query, {
                pegShortcode: window.pegShortcode,
                inputComment: values['comment'],
                inputPictureUrl: values['picture'],
                inputLocation: values['location'],
                inputEmail: values['email']
            }, function () {
                fetchPeg();
            });


            $(event.currentTarget).closest('#newEvent').remove();
        });
    });
})();
