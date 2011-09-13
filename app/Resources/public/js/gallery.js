$.fn.gallery = function (placeholder, options) {
    options = options || { 'duration': 1000 };
    $(this).each(function (key, value) {
        $(value).galleryPreview(placeholder, options);
    });
};

$.fn.galleryPreview = function (placeholder, options) {
    var self = $(this);
    self.bind('click', function () {
        placeholder = $(placeholder);
        placeholder.fadeOut(options.duration, function() {
            placeholder.attr('src', self.attr('src'));
            placeholder.fadeIn(options.duration);
        });
    });
};

$(function() {
    $('img.photo-small').gallery('div.photo-big>img');
});

