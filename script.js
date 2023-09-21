var swiper2 = new Swiper(".my-swiper", {
  effect: "coverflow",
  grabCursor: true,
  centeredSlides: true,
  slidesPerView: "auto",
  coverflowEffect: {
    rotate: 0,
    stretch: 0,
    depth: 100,
    modifier: 1,
    slideShadows: true,
  },
  
  autoplay: {
    delay: 5000,
    disableOnInteraction: false,
  },
});