var nodeArray = [
    document.querySelector('.main-text'),
    document.querySelector('.header-image'),
    document.querySelector('.arrow-from-header-image'),
    document.querySelector('.video-section'),
    document.querySelector('.step:nth-of-type(1)'),
    document.querySelector('.step:nth-of-type(2)'),
    document.querySelector('.step:nth-of-type(3)'),
    document.querySelector('.step:nth-of-type(4)'),
    document.querySelector('.how-it-works-section .google-play-buttons'),
    document.querySelector('.about-items-row:nth-child(1)'),
    document.querySelector('.about-items-row:nth-child(2)')
];
ScrollReveal().reveal(nodeArray, { reset: true, interval: 400 });
ScrollReveal().reveal(nodeArray, { delay: 200 });
ScrollReveal().reveal(nodeArray, { duration: 2000 });
$(document).ready(function(){
    var questions = $(".faq-question");
    $(".faq-answer").each(function() {$(this).hide();});
    questions.each(function(index) {
        $(this).click(function() {
            if ($("#answer" + (index + 1)).is(":hidden")) {
                $("#answer" + (index + 1)).slideDown();
                $(this).parent().addClass("faq-item-expanded")
            } else {
                $("#answer" + (index + 1)).slideUp();
                $(this).parent().removeClass("faq-item-expanded")
            }
        });
    });
    const mySiema = new Siema({
        selector: '.slides',
        duration: 1000,
        easing: 'ease-out',
        perPage: 1,
        startIndex: 0,
        draggable: false,
        multipleDrag: true,
        threshold: 20,
        loop: true,
        rtl: false,
        onInit: () => {},
        onChange: () => {},
    });
    $('.slider-left-button').click(function() {
        mySiema.prev();
    });
    $('.slider-right-button').click(function() {
        mySiema.next();
    });
    var n = 0;
    $('.menu').click(function(){
        n++;
        if (n % 2 == 0) {
            $(".submenu").hide();
        } else {
            $(".submenu").show();
        }
    });
});
