/**
 * Velora — UI Interactions (unified app shell)
 */

document.addEventListener('DOMContentLoaded', function () {
  document.body.classList.remove('app-loading');
  initSidebar();
  initFormValidation();
  initRipple();
  initStarButtons();
  initTaskFilters();
  updateTaskCount();
});

/* ── SIDEBAR ──────────────────────────────────── */
function initSidebar() {
  const toggle = document.getElementById('sidebarToggle');
  const sidebar = document.querySelector('.sidebar');
  const overlay = document.getElementById('sidebarOverlay');

  if (!toggle || !sidebar) return;

  function openSidebar() {
    sidebar.classList.add('open');
    if (overlay) overlay.classList.add('active');
    toggle.setAttribute('aria-expanded', 'true');
    document.body.style.overflow = 'hidden';
  }

  function closeSidebar() {
    sidebar.classList.remove('open');
    if (overlay) overlay.classList.remove('active');
    toggle.setAttribute('aria-expanded', 'false');
    document.body.style.overflow = '';
  }

  toggle.addEventListener('click', function () {
    sidebar.classList.contains('open') ? closeSidebar() : openSidebar();
  });

  if (overlay) overlay.addEventListener('click', closeSidebar);

  sidebar.querySelectorAll('.sidebar-nav-link').forEach(function (link) {
    link.addEventListener('click', function () {
      if (window.innerWidth <= 768) closeSidebar();
    });
  });

  window.addEventListener('resize', function () {
    if (window.innerWidth > 768) closeSidebar();
  });
}

/* ── FORM VALIDATION ──────────────────────────── */
function initFormValidation() {
  const form = document.getElementById('taskForm');
  if (!form) return;

  form.querySelectorAll('.form-control, .form-select, textarea').forEach(function (el) {
    el.addEventListener('input', function () {
      this.style.borderColor = this.value.trim()
        ? 'var(--success)'
        : '';
    });
    el.addEventListener('blur', function () {
      if (!this.value.trim()) this.style.borderColor = '';
    });
  });

  document.addEventListener('keydown', function (e) {
    if ((e.ctrlKey || e.metaKey) && e.key === 'Enter') {
      const submit = form.querySelector('[name="add_task"], [name="update_task"]');
      if (submit) form.submit();
    }
  });

  document.addEventListener('keydown', function (e) {
    if (e.key === 'Escape' && form.querySelector('[name="add_task"]')) {
      form.reset();
      form.querySelectorAll('.form-control, .form-select, textarea').forEach(function (el) {
        el.style.borderColor = '';
      });
    }
  });
}

/* ── RIPPLE ───────────────────────────────────── */
function initRipple() {
  document.querySelectorAll('.btn').forEach(function (btn) {
    btn.addEventListener('click', function (e) {
      const rect = this.getBoundingClientRect();
      const size = Math.max(rect.width, rect.height);
      const x = e.clientX - rect.left - size / 2;
      const y = e.clientY - rect.top - size / 2;
      const r = document.createElement('span');
      r.className = 'ripple';
      r.style.cssText = 'width:' + size + 'px;height:' + size + 'px;left:' + x + 'px;top:' + y + 'px;';
      this.appendChild(r);
      setTimeout(function () { r.remove(); }, 600);
    });
  });
}

/* ── STAR BUTTONS ─────────────────────────────── */
function initStarButtons() {
  document.querySelectorAll('.btn-star').forEach(function (btn) {
    btn.addEventListener('click', function (e) {
      e.preventDefault();
      const el = this;
      el.classList.add('animating');
      el.classList.toggle('starred');
      setTimeout(function () {
        window.location.href = el.getAttribute('href');
      }, 220);
    });
  });
}

/* ── TASK FILTERS (client-side) ───────────────── */
function initTaskFilters() {
  const filterBar = document.getElementById('taskFilter');
  const list = document.getElementById('tasksList');
  if (!filterBar || !list) return;

  const cards = list.querySelectorAll('.task-card');
  const emptyFilter = document.getElementById('emptyStateFilter');
  const emptyDefault = document.getElementById('emptyStateDefault');

  if (!cards.length) return;

  filterBar.querySelectorAll('.filter-chip').forEach(function (chip) {
    chip.addEventListener('click', function () {
      const filter = this.dataset.filter;

      filterBar.querySelectorAll('.filter-chip').forEach(function (c) {
        c.classList.toggle('active', c === chip);
      });

      let visible = 0;

      cards.forEach(function (card) {
        const priority = card.dataset.priority;
        const starred = card.dataset.starred === '1';
        let show = true;

        if (filter === 'starred') {
          show = starred;
        } else if (filter !== 'all') {
          show = priority === filter;
        }

        card.classList.toggle('is-hidden', !show);
        if (show) visible++;
      });

      if (emptyFilter) {
        emptyFilter.style.display = visible === 0 ? 'block' : 'none';
      }
      if (emptyDefault) {
        emptyDefault.style.display = 'none';
      }

      updateTaskCount();
    });
  });
}

/* ── TASK COUNT ───────────────────────────────── */
function updateTaskCount() {
  const list = document.getElementById('tasksList');
  const badge = document.getElementById('taskCount');
  if (!list || !badge) return;

  const cards = list.querySelectorAll('.task-card:not(.is-hidden)');
  const n = cards.length;

  if (n === 0) {
    badge.textContent = 'No active tasks';
  } else if (n === 1) {
    badge.textContent = '1 active';
  } else {
    badge.textContent = n + ' active';
  }
}
