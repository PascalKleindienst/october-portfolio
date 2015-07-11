+function ($) {
    "use strict";

    /**
     * Filter Function
     * @param $grid
     * @param groups
     */
    function filter($grid, groups) {
        $grid.shuffle( 'shuffle', function($el) {
            if (groups.length > 0) {
                for (var i = 0; i < groups.length; i++) {
                    if ($.inArray(groups[i], $el.data('groups')) === -1) {
                        return false;
                    }
                }
            }
            return true;
        });
    }

    /**
     * Get the filter from hash
     * @returns {Array|{index: number, input: string}|*|string}
     */
    function getHashFilter() {
        var hash = location.hash;
        // get filter=filterName
        var matches = location.hash.match( /filter=([^&]+)/i );
        var hashFilter = matches && matches[1];
        return hashFilter && decodeURIComponent( hashFilter );
    }

    $(function() {
        var $grid = $('.portfolio-item-list'),
            $filters = $('.portfolio-filters');

        // filters
        $filters.find('button').on('click', function() {
            var groups = [],
                $active;

            $(this).toggleClass('active');
            $active = $filters.find('.active');

            // At least one checkbox is checked, clear the array and loop through the checked checkboxes
            // to build an array of strings
            if ($active.length !== 0) {
                $active.each(function() {
                    groups.push($(this).data('group'));
                });
            }

            if ($(this).data('group') === 'all') {
                groups = [];
                $active.removeClass('active');
            }

            // set filter in hash
            window.location.hash = 'filter=' + encodeURIComponent( groups.join(',') );

            // Filter elements
            filter($grid, groups);
        });

        // init shuffle.js
        $grid.shuffle({
            itemSelector: '.item'
        });

        // listen for hash chanegs
        $(window).bind( 'hashchange', function( event ) {
            var hashFilter = getHashFilter();
            if ( hashFilter ) {
                var filters = hashFilter.split(',');
                $filters.find('button').each(function(i, el) {
                    if ($.inArray($(el).data('group'), filters) !== -1) {
                        $(el).addClass('active');
                    }
                });
                filter($grid, filters);
            }
        });

        $(window).trigger("hashchange");
    });
}(window.jQuery);