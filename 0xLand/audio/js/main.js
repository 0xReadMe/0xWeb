const navBtn = document.querySelector('#nav__btn');
const navMenu = document.querySelector('#nav__m-menu');

navBtn.addEventListener('click', (e) => {
  if (!navMenu.classList.contains('active')) {
    navMenu.classList.add('active');
    navMenu.style.transform = 'translateY(0)';
    navBtn.innerHTML = '&#215;';
  } else {
    navMenu.classList.remove('active');
    navMenu.style.transform = 'translateY(-100%)';
    navBtn.innerHTML = '&#x2261;';
  }
});


const photos = document.querySelectorAll('.slider > img');

photos.forEach((photo) => {
  photo.addEventListener('mousemove', (e) => {
    photos.forEach((photo) => {
      photo.style.transform = 'scale(0.8)';
      photo.style.zIndex = '0';
    });
    photo.style.transform = 'scale(1)';
    photo.style.zIndex = '1';
  });
});