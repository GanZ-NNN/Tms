const programSwiper = new Swiper('.program-swiper', {
    slidesPerView: 3,
    spaceBetween: 20,
    loop: true,
    pagination: {
        el: '.swiper-pagination',
        clickable: true,
    },
    navigation: {
        nextEl: '.swiper-button-next',
        prevEl: '.swiper-button-prev',
    },
    breakpoints: {
        0: { slidesPerView: 1 },
        576: { slidesPerView: 1.5 },
        768: { slidesPerView: 2 },
        992: { slidesPerView: 3 },
    },
});
