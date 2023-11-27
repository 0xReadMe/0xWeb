var showPopup = true;

$(document).ready(function(){
    $(".gallery-list-item").on("mouseenter", showGalleryPreview);
    $(".gallery-extended-list-item").on("mouseenter", showGalleryPreview);

    $(".gallery-imgs-container").click(showGalleryPhoto);
    $(".gallery-extended-close").click(hideGalleryPhoto);

    $(".gallery-navigation_prev").click(galleryPrev);
    $(".gallery-navigation_next").click(galleryNext);

    $(".gallery-extended-img-nav_type-prev").click(galleryPrev);
    $(".gallery-extended-img-nav_type-next").click(galleryNext);

    $(".simple-with-more-rubricator-link-27kbj").click(showSearchPopup);
    $("body").click(hideSearchPopup);
});

function showGalleryPreview(){
    index = $(this).attr("data-index");

    $(".gallery-list-item").removeClass("gallery-list-item_selected");
    $(".gallery-list-item:eq(" + index + ")").addClass("gallery-list-item_selected");

    $(".gallery-extended-list-item").removeClass("gallery-extended-list-item_selected");
    $(".gallery-extended-list-item:eq(" + index + ")").addClass("gallery-extended-list-item_selected");

    if (index == 0)
        $(".gallery-img-wrapper.js-gallery-img-wrapper").filter(":first").attr("style", "margin-left: 0%;");
    else
        $(".gallery-img-wrapper.js-gallery-img-wrapper").filter(":first").attr("style", "margin-left: -" + 100 * index + "%;");

    $(".gallery-extended-img-frame").removeClass("gallery-extended-img-frame_state-selected");
    $(".gallery-extended-img-frame:eq(" + index + ")").addClass("gallery-extended-img-frame_state-selected");
    
    $(".gallery-extended-list-item").removeClass("gallery-extended-list-item_selected");
    $(".gallery-extended-list-item[data-index='" + index + "']").addClass("gallery-extended-list-item_selected");
}

function showGalleryPhoto(){
    $(".js-gallery-extended").removeClass("gallery-extended_state-hide");
    $(".js-gallery-extended").addClass("gallery-extended_state-show");

    index = $(".gallery-list-item_selected").attr("data-index");

    $(".gallery-extended-img-frame").removeClass("gallery-extended-img-frame_state-selected");
    $(".gallery-extended-img-frame:eq(" + index + ")").addClass("gallery-extended-img-frame_state-selected");
}

function hideGalleryPhoto(){
    $(".js-gallery-extended").removeClass("gallery-extended_state-show");
    $(".js-gallery-extended").addClass("gallery-extended_state-hide");
}

function galleryPrev(){
    index = $(".gallery-list-item_selected").attr("data-index");

    if (index > 0)
        index--;
    else
        index = $(".gallery-list-item").length - 1;

    $(".gallery-list-item").removeClass("gallery-list-item_selected");
    $(".gallery-list-item:eq(" + index + ")").addClass("gallery-list-item_selected");

    if (index == 0)
        $(".gallery-img-wrapper.js-gallery-img-wrapper").filter(":first").attr("style", "margin-left: 0%;");
    else
        $(".gallery-img-wrapper.js-gallery-img-wrapper").filter(":first").attr("style", "margin-left: -" + 100 * index + "%;");

    $(".gallery-extended-img-frame").removeClass("gallery-extended-img-frame_state-selected");
    $(".gallery-extended-img-frame:eq(" + index + ")").addClass("gallery-extended-img-frame_state-selected");

    $(".gallery-extended-list-item").removeClass("gallery-extended-list-item_selected");
    $(".gallery-extended-list-item[data-index='" + index + "']").addClass("gallery-extended-list-item_selected");
}

function galleryNext(){
    index = $(".gallery-list-item_selected").attr("data-index");

    if (index < $(".gallery-list-item").length - 1)
        index++;
    else
        index = 0;

    $(".gallery-list-item").removeClass("gallery-list-item_selected");
    $(".gallery-list-item:eq(" + index + ")").addClass("gallery-list-item_selected");

    if (index == 0)
        $(".gallery-img-wrapper.js-gallery-img-wrapper").filter(":first").attr("style", "margin-left: 0%;");
    else
        $(".gallery-img-wrapper.js-gallery-img-wrapper").filter(":first").attr("style", "margin-left: -" + 100 * index + "%;");

    $(".gallery-extended-img-frame").removeClass("gallery-extended-img-frame_state-selected");
    $(".gallery-extended-img-frame:eq(" + index + ")").addClass("gallery-extended-img-frame_state-selected");

    $(".gallery-extended-list-item").removeClass("gallery-extended-list-item_selected");
    $(".gallery-extended-list-item[data-index='" + index + "']").addClass("gallery-extended-list-item_selected");
}

function showSearchPopup(){
    if ($(".simple-with-more-rubricator-more-popup-2fDTp").attr("style") != "display: block;"){
        $(".simple-with-more-rubricator-more-popup-2fDTp").attr("style", "display: block;");
        showPopup = true;
    } else {
        $(".simple-with-more-rubricator-more-popup-2fDTp").attr("style", "display: none;");
    }
}

function hideSearchPopup(){
    if (showPopup){
        showPopup = false;
        return;
    }

    $(".simple-with-more-rubricator-more-popup-2fDTp").attr("style", "display: none;");
}