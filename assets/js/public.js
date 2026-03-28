(function($) {
    'use strict';
    
    $(document).ready(function() {
        // Add any public-facing JavaScript functionality here
        
        // Example: Add hover effects to dietary badges
        $('.dietary-badge').hover(
            function() {
                $(this).css('transform', 'scale(1.05)');
            },
            function() {
                $(this).css('transform', 'scale(1)');
            }
        );
    });
    
})(jQuery);
