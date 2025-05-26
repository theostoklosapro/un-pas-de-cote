document.addEventListener('DOMContentLoaded', () => {
  const body = document.querySelector('body');
  const menuOpener = document.querySelector('.js-menu-mobile-opener');
  const menuCloser = document.querySelector('.js-menu-mobile-closer');
  const menuMobile = document.querySelector('#menu-mobile');

  menuOpener.addEventListener('click', () => {
    const menuMobileLink = document.querySelectorAll('.menu-mobile-link')
    menuMobile.classList.add('open');
    body.classList.add('menu-mobile-open');

    menuMobileLink.forEach(link => link.addEventListener('click', () => {
      menuMobile.classList.remove('open');
      body.classList.remove('menu-mobile-open');
    }))
  });

  menuCloser.addEventListener('click', () => {
    menuMobile.classList.remove('open');
    body.classList.remove('menu-mobile-open');
  });

  if (document.getElementById('consent-label')) {
    document.getElementById('consent-label').addEventListener('click', () => {
      document.getElementById('consent-checkbox').checked = true;
    });
  }
});