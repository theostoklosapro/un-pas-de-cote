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

  document.getElementById('contact-form').addEventListener('submit', function(e) {
    e.preventDefault();
    const form = e.target;
    const data = new FormData(form);
  
    fetch(form.action, {
      method: 'POST',
      body: data
    })
    .then(response => {
      if (!response.ok) throw new Error('Erreur lors de l’envoi');
      return response.text();
    })
    .then(text => {
      document.getElementById('mail-sent-popup').style.display = 'block';
      document.getElementById('mail-sent-popup').style.top = window.scrollY + 100 + 'px';
      form.reset();
      setTimeout(() => {
        document.getElementById('mail-sent-popup').style.opacity = '0';
      }, 4000);
      setTimeout(() => {
        document.getElementById('mail-sent-popup').style.display = 'none';
      }, 5000);
    })
    .catch(err => {
      alert("Une erreur est survenue : " + err.message);
    });
  });

  document.getElementById('consent-label').addEventListener('click', () => {
    document.getElementById('consent-checkbox').checked = true;
  });
});