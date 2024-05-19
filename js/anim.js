let swiper = new Swiper('.mySwiper', {
  autoplay: true,
  pagination: {
    el: '.swiper-pagination',
    type: 'progressbar',
  },
})

let swiper2 = new Swiper('.mySwiper-2', {
  slidesPerView: 3,
  centeredSlides: false,
  spaceBetween: 30,
  grabCursor: true,
  autoplay: true,
})

let swiper3 = new Swiper('.mySwiper-3', {
  slidesPerView: 3,
  centeredSlides: false,
  spaceBetween: 30,
  grabCursor: true,
})

let swiper4 = new Swiper('.mySwiper-4', {
  slidesPerView: 3,
  centeredSlides: false,
  spaceBetween: 30,
  grabCursor: true,
})

let swiper7 = new Swiper('.mySwiper-7', {
  autoplay: true,
  slidesPerView: 1,
  centeredSlides: false,
  spaceBetween: 30,
  grabCursor: true,
})

const scroll = new LocomotiveScroll({
  el: document.querySelector('[data-scroll-container]'),
  smooth: true,
})

// menu
let menuTimeLine = gsap.timeline({})
gsap.set('.mobile-menu', {
  x: 500,
  duration: 0.5,
  scale: 1.5,
  opacity: 0,
  ease: 'power2.out',
})
menuTimeLine.to('.mobile-menu', {
  x: 0,
  duration: 0.5,
  opacity: 1,
  scale: 1,
  ease: 'power2.out',
})
menuTimeLine.pause()
// menu open
if (document.querySelector('.menu'))
  document.querySelector('.menu').addEventListener('click', function (e) {
    scroll.stop()
    menuTimeLine.play()
  })
// menu close
if (document.querySelector('.close-menu'))
  document.querySelector('.close-menu').addEventListener('click', function (e) {
    scroll.start()
    menuTimeLine.reverse()
  })

// cart menu
let cartTimeLine = gsap.timeline({})
gsap.set('.cart-menu', {
  x: window.innerWidth,
  scale: 1.5,
})
gsap.set('.cart-menu-backdrop', {
  x: window.innerWidth + 500,
  scale: 1.5,
  opacity: 0,
})
cartTimeLine.to('.cart-menu-backdrop', {
  x: 0,
  duration: 0.3,
  scale: 1,
  opacity: 1,
  ease: 'power2.out',
})
cartTimeLine.to('.cart-menu', {
  x: 0,
  duration: 0.5,
  scale: 1,
  ease: 'power2.out',
})
cartTimeLine.pause()
if (document.querySelector('.cart'))
  document.querySelector('.cart').addEventListener('click', function (e) {
    scroll.stop()
    cartTimeLine.play()
  })
if (document.querySelector('.cart-close'))
  document.querySelector('.cart-close').addEventListener('click', function (e) {
    scroll.start()
    cartTimeLine.reverse()
  })
if (document.querySelector('.cart-menu-backdrop'))
  document
    .querySelector('.cart-menu-backdrop')
    .addEventListener('click', function (e) {
      if (e.target !== this) return
      scroll.start()
      cartTimeLine.reverse()
    })

// boot animations
let bootTimeLine = gsap.timeline({})
gsap.set('.logo', { filter: 'blur(10px)' })
bootTimeLine.to('.logo', {
  filter: 'blur(0px)',
  duration: 2,
})
gsap.set('.dd-title', {
  y: 40,
})
gsap.set('.mySwiper .desc', {
  opacity: 0,
})
bootTimeLine.to(
  '.dd-title',
  {
    y: 0,
    zIndex: 50,
    stagger: {
      amount: 0.4,
    },
    duration: 0.5,
  },
  '<',
)

bootTimeLine.to(
  '.mySwiper .desc',
  {
    opacity: 1,
    stagger: {
      amount: 0.5,
    },
    duration: 1,
  },
  '<',
)

// accodians
document.querySelectorAll('.link-title').forEach((el) => {
  el.addEventListener('click', () => {
    console.log('clikced')
  })
})

// dashboard
let dashboardTimeLine = gsap.timeline({})
dashboardTimeLine.to('.first', {
  x: -document.querySelector('.first').offsetWidth,
})
dashboardTimeLine.pause()

if (document.querySelector('.open-dashboard'))
  document
    .querySelector('.open-dashboard')
    .addEventListener('click', function () {
      dashboardTimeLine.play()
    })
if (document.querySelector('.close-dashboard'))
  document
    .querySelector('.close-dashboard')
    .addEventListener('click', function () {
      dashboardTimeLine.reverse()
    })

// accordians
document.querySelectorAll('.link-title').forEach((el) => {
  el.addEventListener('click', (e) => {
    let targetContent = el.nextSibling.nextSibling
    console.log(targetContent.style.maxHeight)
    if (!targetContent.style.maxHeight)
      gsap.to(targetContent, {
        maxHeight: targetContent.scrollHeight,
        opacity: 1,
      })
    else
      gsap.to(targetContent, {
        maxHeight: null,
        opacity: 0,
      })
  })
})
