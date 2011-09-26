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
        self.fadeOut(options.duration);
        placeholder.fadeOut(options.duration, function() {
            var src = placeholder.attr('src');
            placeholder.attr('src', self.attr('src'));
            self.attr('src', src);

            self.fadeIn(options.duration);
            placeholder.fadeIn(options.duration);
        });
    });
};

$(function() {
    $('img.photo-small').gallery('div.photo-big>img');
});

