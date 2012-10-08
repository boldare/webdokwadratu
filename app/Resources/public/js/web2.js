// Sort function
jQuery.fn.sortElements = (function(){
    var sort = [].sort;
 
    return function(comparator, getSortable) {
        getSortable = getSortable || function(){return this;};

        var placements = this.map(function(){
            var sortElement = getSortable.call(this),
                parentNode = sortElement.parentNode,
 
                // Since the element itself will change position, we have
                // to have some way of storing its original position in
                // the DOM. The easiest way is to have a 'flag' node:
                nextSibling = parentNode.insertBefore(
                    document.createTextNode(''),
                    sortElement.nextSibling
                );
 
            return function() {
                if (parentNode === this) {
                    throw new Error(
                        "You can't sort elements if any one is a descendant of another."
                    );
                }
 
                // Insert before flag:
                parentNode.insertBefore(this, nextSibling);
                // Remove flag:
                parentNode.removeChild(nextSibling);
            };
        });
 
        return sort.call(this, comparator).each(function(i){
            placements[i].call(getSortable.call(this));
        });
    };
})();

// Main script content
$(function() {
    // Page redirecting on select change for mobile view
    var addr = 'option[value="' + window.location.pathname + '"]';
    $('select.menu').find(addr).attr('selected', true);
    
    $('select.menu').on('change', function(){
        window.location = $(this).val();
    });

    // Custom scrollbar init
    setTimeout(function(){
        $(".slider ul").niceScroll({
            autohidemode: false,
            cursorcolor:'#E1E1E1',
            cursorwidth: '8px',
            cursorborderradius: '4px',
            cursorminheight: '50'
        });
    }, 200);

    // Person gallery images swapping
    function swapPhoto(img) {
        var imgSrc = img.attr('src'),
            dest = $('.photos .main').find('img'),
            destSrc = dest.attr('src');

        dest.stop(true, true).animate({'opacity': '0'}, 200, function(){
            $(this).attr('src', imgSrc);
            $(this).stop(true, true).animate({'opacity': '1'}, 200);
        });

        img.stop(true, true).animate({'opacity': '0'}, 200, function(){
            $(this).attr('src', destSrc);
            $(this).stop(true, true).animate({'opacity': '0.5'}, 200);
        });
    };

    $('.photos .list').find('img').on('click', function(e){
        swapPhoto($(this));
    });

    // Filters handling
    web2.listClone = $('.tiles > ul > li').not('.filters').clone(true);

    $('#filter-industry, #filter-computer').coreUISelect({
        jScrollPane : {
           verticalDragMinHeight: 20,
           verticalDragMaxHeight: 20,
           showArrows : true
        }
     });

    $(document).on('change', '#filter-industry, #filter-computer', function(){
        web2.filterValue = $(this).val();
        $('.tiles').fadeOut(web2.duration, web2.filter);
    });

    // Sort handling
    $('.sorting').find('a').on('click', function(e){
        web2.order = $(this).data('sort');
        $('.tiles').fadeOut(web2.duration, web2.sort);
        e.preventDefault();
    });
});

var web2 = {
    duration: 500,

    filter: function(){
        if (web2.filterValue === 'all') {
            $('.tiles > ul > li').not('.filters').detach();
            $('.tiles > ul').append(web2.listClone).find('> li').css('margin', '0').show();
        }
        else {
            $('.tiles > ul > li').hide().each(function(){
                if ($(this).hasClass(web2.filterValue)) {
                    $(this).show();
                }
            });
        }

        $('.tiles > ul').find('.filters').show();
        $('.tiles').fadeIn(web2.duration);
    },

    sort: function(){
        if (web2.order === 'asc') {
            web2.sorted = $('.tiles > ul > li').sortElements(function(a, b){
                return $(a).data('name') > $(b).data('name') ? 1 : -1;
            });
        } else {
            web2.sorted = $('.tiles > ul > li').sortElements(function(a, b){
                return $(a).data('name') < $(b).data('name') ? 1 : -1;
            });
        }

        $('.tiles > ul > li').detach();
        $('.tiles > ul').append(web2.sorted).find('> li').css('margin', '0');
        $('.tiles').fadeIn(web2.duration);
    }
};