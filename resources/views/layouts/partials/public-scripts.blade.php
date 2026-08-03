<script>
(function () {
  const burger = document.getElementById('publicBurger');
  const menu = document.getElementById('publicMobMenu');
  const closeBtn = document.getElementById('publicMobClose');
  const userWrap = document.getElementById('publicNavUser');
  const userBtn = document.getElementById('publicNavUserBtn');

  function openMenu() {
    if (!menu) return;
    menu.classList.add('open');
    document.body.style.overflow = 'hidden';
  }

  function closeMenu() {
    if (!menu) return;
    menu.classList.remove('open');
    document.body.style.overflow = '';
  }

  if (burger) burger.addEventListener('click', () => {
    menu && menu.classList.contains('open') ? closeMenu() : openMenu();
  });
  if (closeBtn) closeBtn.addEventListener('click', closeMenu);
  if (menu) {
    menu.addEventListener('click', (e) => {
      if (e.target === menu) closeMenu();
    });
  }

  if (userWrap && userBtn) {
    userBtn.addEventListener('click', (e) => {
      e.stopPropagation();
      const open = userWrap.classList.toggle('open');
      userBtn.setAttribute('aria-expanded', open ? 'true' : 'false');
    });
    document.addEventListener('click', (e) => {
      if (!userWrap.contains(e.target)) {
        userWrap.classList.remove('open');
        userBtn.setAttribute('aria-expanded', 'false');
      }
    });
  }

  document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') {
      closeMenu();
      if (userWrap) {
        userWrap.classList.remove('open');
        if (userBtn) userBtn.setAttribute('aria-expanded', 'false');
      }
    }
  });
})();
</script>
