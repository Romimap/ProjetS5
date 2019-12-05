(function(){
    $('input').rating();
    $('.chart').easyPieChart({
        barColor: "#007bff",
        trackColor: "#e6e6e6",
        lineCap: "square",
        lineWidth: 5,
        size: $(".skills").find(".col-4").find("span").width()
    });
})(jQuery);