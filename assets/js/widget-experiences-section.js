jQuery(document).ready(function() {
    // Function to update the large image section
    function updateLargeImageSection(postData) {
        // Update the background image of .large-image-section
        jQuery('.large-image-section').css('background-image', 'url(' + postData.img_url + ')');

        // Update the title in .active-image-heading
        jQuery('.active-image-heading').text(postData.title);

        // Update the description in .active-image-desc
        jQuery('.active-image-desc').text(postData.short_desc);

        // Update the button link in .active-image-btn
        jQuery('.active-image-btn>a').attr('href',postData.discover_more_link);
    }

    var firstPostData = jQuery('.img-option-card').first().data('post-data');
    if (firstPostData) {
        updateLargeImageSection(firstPostData);
    }

    // Event listener for clicks on the .img-option-card elements
    jQuery('.img-option-card').on('click', function() {
        // Get the post data from the clicked card
        const postData = jQuery(this).data('post-data');

        // Call the function to update the large image section
        updateLargeImageSection(postData);
    });

    jQuery('.image-options-slider').slick({
        slidesToShow: 3,  // Show 3 slides at a time
        slidesToScroll: 1, // Scroll one slide at a time
        infinite: true,    // Infinite scrolling
        arrows: true,      // Show navigation arrows
        dots: true,        // Show pagination dots
        responsive: [
            {
                breakpoint: 1250,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 1,
                }
            },
            {
                breakpoint: 767,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 1
                }
            }
        ]
    });    

    function updateMarginLeft() {
        // Get the current screen width
        const screenWidth = jQuery(window).width();
    
        // Calculate the container width (90vw or max 1440px)
        const containerWidth = Math.min(screenWidth * 0.9, 1440);
    
        // Calculate the left margin for '.child'
        const marginLeft = (screenWidth - containerWidth) / 2;
    
        // Apply the calculated margin-left to the '.child' element
        jQuery('.experiences-section-child').css('margin-left', marginLeft + 'px');
    }
    
    if(innerWidth > 1024) {
        // Initial calculation on page load
        updateMarginLeft();
        
        // Update on window resize
        jQuery(window).on('resize', updateMarginLeft);
    }

});
