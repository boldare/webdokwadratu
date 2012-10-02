$(document).ready(function() {
    var addr = 'option[value="' + window.location.pathname + '"]';
    $('select.menu').find(addr).attr('selected', true);
    
    $('select.menu').on('change', function(){
        window.location = $(this).val();
    });

    var clickedButton;

    $('#list > li:visible').eq(6).addClass('clear');
    $('#list > li:visible').eq(12).addClass('clear');
    $('#list > li:visible').eq(18).addClass('clear');

    $(' > .select-dropdown > li > a', $('#filter-industry, #filter-computer')).click(web2.filterClickHandle);
    $('#sort-name > .select-dropdown > li > a').click(web2.sortClickHandle);

    // save original list
    web2.origList = $('#list > li').clone(true);

    $('.button').click(function (e) {
      $(this).children('.select-dropdown').slideToggle();
      clickedButton = $(this).children('.select-dropdown');
    });

    $('body').click(function () {
      var elements = $('.button').children('.select-dropdown');

      if (clickedButton !== undefined) {
        elements = elements.not(clickedButton);
      }

      elements.slideUp();
      clickedButton = undefined;
    });
});

var web2 = {
    duration: 1000,
    filter: null,
    order: null,
    origList: null,

    filterClickHandle: function(e) {
        e.preventDefault();

        web2.filter = $(this).data().value;

        $("#list").fadeOut(web2.duration, web2.filterHandle);
    },

    filterHandle: function() {
        $('#list > li.clear').removeClass('clear');

        if ('all' === web2.filter) {
            // restore original list
            $('#list > li').detach();
            $('#list').append(web2.origList);

            $('#list > li').show();
        }
        else {
            $('#list').children(':not(.' + web2.filter + ')').hide();
            $('#list').children('.' + web2.filter).show();
        }

        $('#list').fadeIn(web2.duration);

        $('#list > li:visible').eq(6).addClass('clear');
        $('#list > li:visible').eq(12).addClass('clear');
        $('#list > li:visible').eq(18).addClass('clear');
    },

    sortClickHandle: function(e) {
        e.preventDefault();
        web2.order = $(this).data().value;

        $("#list").fadeOut(web2.duration, web2.sortHandle);
    },

    sortHandle: function() {
        $('#list > li.clear').removeClass('clear');
        var orderCallback = null;

        if ('asc' === web2.order) {
            orderCallback = web2.cmpAsc;
        }
        else {
            orderCallback = web2.cmpDsc;
        }

        var sorted = $('#list > li').sort(orderCallback);

        $('#list > li').detach();
        $('#list').append(sorted);
        $('#list').fadeIn(web2.duration);

        $('#list > li:visible').eq(6).addClass('clear');
        $('#list > li:visible').eq(12).addClass('clear');
        $('#list > li:visible').eq(18).addClass('clear');
    },

    cmpAsc: function(o1, o2) {
        var o1 = $(o1);
        var o2 = $(o2);
        return ((o1.data().value == o2.data().value) ? 0 : ((o1.data().value > o2.data().value) ? 1 : -1));
    },

    cmpDsc: function(o1, o2) {
        var o1 = $(o1);
        var o2 = $(o2);
        return ((o1.data().value == o2.data().value) ? 0 : ((o1.data().value < o2.data().value) ? 1 : -1));
    }
};
