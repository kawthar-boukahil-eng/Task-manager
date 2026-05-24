/**
 * Velora — Auth page tab switching
 */
document.addEventListener('DOMContentLoaded', function () {
  const tabs = document.querySelectorAll('.auth-tab');
  const forms = document.querySelectorAll('.auth-form');
  const panelTitle = document.querySelector('.auth-panel-title');
  const panelSub = document.querySelector('.auth-panel-sub');

  function switchTab(target) {
    tabs.forEach(function (t) {
      const isActive = t.dataset.tab === target;
      t.classList.toggle('active', isActive);
      t.setAttribute('aria-selected', isActive ? 'true' : 'false');
    });

    forms.forEach(function (f) {
      f.classList.toggle('active', f.id === target + '-form');
    });

    if (panelTitle && panelSub) {
      if (target === 'signin') {
        panelTitle.textContent = 'Welcome back';
        panelSub.textContent = 'Sign in to continue to Velora.';
      } else {
        panelTitle.textContent = 'Create account';
        panelSub.textContent = 'Start your focused workspace today.';
      }
    }
  }

  tabs.forEach(function (tab) {
    tab.addEventListener('click', function () {
      switchTab(this.dataset.tab);
    });
  });

  const hash = window.location.hash.replace('#', '');
  switchTab(hash === 'signup' ? 'signup' : 'signin');

  window.toggle = function () {
    const active = document.querySelector('.auth-tab.active');
    switchTab(active && active.dataset.tab === 'signin' ? 'signup' : 'signin');
  };
});
