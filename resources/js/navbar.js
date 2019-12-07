const menuButton = document.querySelector('.site-navigation__toggler');

menuButton.addEventListener('click', function () {
    menuButton.classList.toggle('site-navigation__toggler--close');
});
