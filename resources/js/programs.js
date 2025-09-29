import Swiper from 'swiper';
import 'swiper/css';
import 'swiper/css/navigation';
import 'swiper/css/pagination';

const programSwiper = new Swiper('.program-swiper', {
    slidesPerView: 1,
    spaceBetween: 20,
    loop: false,
    pagination: {
        el: '.swiper-pagination',
        clickable: true,
    },
    navigation: {
        nextEl: '.swiper-button-next',
        prevEl: '.swiper-button-prev',
    },
    breakpoints: {
        0: { slidesPerView: 1, spaceBetween: 10 },
        576: { slidesPerView: 1.5, spaceBetween: 15 },
        768: { slidesPerView: 2, spaceBetween: 20 },
        992: { slidesPerView: 3, spaceBetween: 25 },
    },
});

// "ดูหลักสูตรทั้งหมด" button
document.getElementById('viewAllBtn')?.addEventListener('click', function(e){
    e.preventDefault();

    // แสดงหลักสูตรที่ซ่อนอยู่
    document.querySelectorAll('.extra-course').forEach(el => el.classList.remove('d-none'));

    this.style.display = 'none'; // ซ่อนปุ่ม

    programSwiper.update(); // อัปเดต Swiper หลังโชว์เพิ่ม
});
