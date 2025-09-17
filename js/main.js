// Hamburger menu toggle for small screens
document.addEventListener('DOMContentLoaded', function () {
  const hamburger = document.getElementById('hamburger-btn');
  const menu = document.getElementById('side-menu');

  hamburger.addEventListener('click', function () {
    menu.classList.toggle('open');
    // Optional: add a backdrop to close menu on click outside
    if (menu.classList.contains('open')) {
      document.body.insertAdjacentHTML('beforeend', '<div id="menu-backdrop" style="position:fixed;left:0;top:0;width:100vw;height:100vh;z-index:1499;background:rgba(0,0,0,0.16)"></div>');
      document.getElementById('menu-backdrop').addEventListener('click', function () {
        menu.classList.remove('open');
        this.remove();
      });
    } else {
      const backdrop = document.getElementById('menu-backdrop');
      if (backdrop) backdrop.remove();
    }
  });
});