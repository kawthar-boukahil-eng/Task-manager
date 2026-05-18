/**
 * Smart Task Manager - UI Enhancements
 * Modern SaaS dashboard interactions and form validation
 */

document.addEventListener('DOMContentLoaded', function () {
  initializeUI();
  initializeFormValidation();
  updateTaskCount();
});

/**
 * Initialize UI enhancements
 */
function initializeUI() {
  // Add smooth transitions to task cards
  const taskCards = document.querySelectorAll('.task-card');
  taskCards.forEach((card, index) => {
    card.style.animationDelay = `${index * 50}ms`;
  });

  // Add focus states to form inputs
  const formInputs = document.querySelectorAll(
    '.form-control, .form-select, .form-textarea',
  );
  formInputs.forEach((input) => {
    input.addEventListener('focus', function () {
      this.style.borderColor = 'var(--primary)';
    });

    input.addEventListener('blur', function () {
      this.style.borderColor = 'var(--gray-300)';
    });
  });

  // Add hover effects to buttons
  const buttons = document.querySelectorAll('.btn');
  buttons.forEach((button) => {
    button.addEventListener('mouseenter', function () {
      this.style.transform = 'translateY(-2px)';
    });

    button.addEventListener('mouseleave', function () {
      this.style.transform = 'translateY(0)';
    });
  });
}

/**
 * Form validation and feedback
 */
function initializeFormValidation() {
  const taskForm = document.getElementById('taskForm');

  if (taskForm) {
    taskForm.addEventListener('submit', function (e) {
      if (!validateForm()) {
        e.preventDefault();
        showFormError('Please fill in all required fields');
      }
    });

    // Real-time validation feedback
    const titleInput = document.getElementById('title');
    const descriptionInput = document.getElementById('description');
    const prioritySelect = document.getElementById('priority');

    if (titleInput) {
      titleInput.addEventListener('input', function () {
        if (this.value.trim().length > 0) {
          this.style.borderColor = 'var(--success)';
        } else {
          this.style.borderColor = 'var(--gray-300)';
        }
      });
    }

    if (descriptionInput) {
      descriptionInput.addEventListener('input', function () {
        if (this.value.trim().length > 0) {
          this.style.borderColor = 'var(--success)';
        } else {
          this.style.borderColor = 'var(--gray-300)';
        }
      });
    }

    if (prioritySelect) {
      prioritySelect.addEventListener('change', function () {
        if (this.value !== '') {
          this.style.borderColor = 'var(--success)';
        } else {
          this.style.borderColor = 'var(--gray-300)';
        }
      });
    }
  }
}

/**
 * Validate form fields
 */
function validateForm() {
  const title = document.getElementById('title');
  const description = document.getElementById('description');
  const priority = document.getElementById('priority');

  if (!title || !title.value.trim()) return false;
  if (!description || !description.value.trim()) return false;
  if (!priority || !priority.value) return false;

  return true;
}

/**
 * Show form error message
 */
function showFormError(message) {
  const errorDiv = document.createElement('div');
  errorDiv.className = 'alert alert-danger alert-dismissible fade show';
  errorDiv.role = 'alert';
  errorDiv.innerHTML = `
    <strong>Validation Error:</strong> ${message}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  `;

  const taskForm = document.getElementById('taskForm');
  if (taskForm) {
    taskForm.parentElement.insertBefore(errorDiv, taskForm);

    // Auto-remove after 5 seconds
    setTimeout(() => {
      errorDiv.remove();
    }, 5000);
  }
}

/**
 * Update task count display
 */
function updateTaskCount() {
  const tasksList = document.getElementById('tasksList');
  const taskCountBadge = document.getElementById('taskCount');

  if (tasksList && taskCountBadge) {
    const taskCards = tasksList.querySelectorAll('.task-card');
    const count = taskCards.length;

    if (count === 0) {
      taskCountBadge.textContent = 'No tasks';
    } else if (count === 1) {
      taskCountBadge.textContent = '1 task';
    } else {
      taskCountBadge.textContent = `${count} tasks`;
    }
  }
}

/**
 * Smooth page transitions
 */
window.addEventListener('pageshow', function () {
  const fadeInElements = document.querySelectorAll('.fade-in');
  fadeInElements.forEach((element) => {
    element.style.animation = 'fadeIn 0.3s ease-out';
  });
});

/**
 * Add keyboard shortcuts
 */
document.addEventListener('keydown', function (e) {
  // Ctrl/Cmd + Enter to submit form
  if ((e.ctrlKey || e.metaKey) && e.key === 'Enter') {
    const taskForm = document.getElementById('taskForm');
    if (taskForm && validateForm()) {
      taskForm.submit();
    }
  }

  // Escape to clear form
  if (e.key === 'Escape') {
    const taskForm = document.getElementById('taskForm');
    if (taskForm) {
      taskForm.reset();
      document
        .querySelectorAll('.form-control, .form-select, .form-textarea')
        .forEach((input) => {
          input.style.borderColor = 'var(--gray-300)';
        });
    }
  }
});

/**
 * Add ripple effect to buttons
 */
document.querySelectorAll('.btn').forEach((button) => {
  button.addEventListener('click', function (e) {
    const ripple = document.createElement('span');
    const rect = this.getBoundingClientRect();
    const size = Math.max(rect.width, rect.height);
    const x = e.clientX - rect.left - size / 2;
    const y = e.clientY - rect.top - size / 2;

    ripple.style.width = ripple.style.height = size + 'px';
    ripple.style.left = x + 'px';
    ripple.style.top = y + 'px';
    ripple.classList.add('ripple');

    this.appendChild(ripple);

    setTimeout(() => ripple.remove(), 600);
  });
});
