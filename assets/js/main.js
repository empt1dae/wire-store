// Toast notifications
const toastRootId = 'toast-root';
function ensureToastRoot() {
  let root = document.getElementById(toastRootId);
  if (!root) {
    root = document.createElement('div');
    root.id = toastRootId;
    root.className = 'toast';
    document.body.appendChild(root);
  }
  return root;
}
export function showToast(message, type = 'info', timeout = 3000) {
  const root = ensureToastRoot();
  const el = document.createElement('div');
  const icons = {
    success: '✓',
    error: '✕',
    warning: '⚠',
    info: 'ℹ'
  };
  el.className = `toast-item ${type}`;
  el.innerHTML = `
    <div style="display:flex; align-items:center; gap:10px;">
      <span style="font-size:18px;">${icons[type] || icons.info}</span>
      <span>${message}</span>
    </div>
    <button class="btn icon-btn" aria-label="Close" style="background:transparent; border:none; color:inherit; padding:0; width:24px; height:24px;">✕</button>
  `;
  root.appendChild(el);
  const remove = () => {
    el.style.transform = 'translateX(400px)';
    el.style.opacity = '0';
    setTimeout(() => el.remove(), 300);
  };
  el.querySelector('button')?.addEventListener('click', remove);
  setTimeout(remove, timeout);
}

// Simple helper to handle Add-to-Cart AJAX
export async function addToCart(productId, qty = 1) {
  try {
    const res = await fetch('includes/cart_api.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
      body: new URLSearchParams({ action: 'add', id: String(productId), qty: String(qty) }),
      credentials: 'same-origin'
    });
    const data = await res.json();
    if (data.success) {
      showToast('Product added to cart successfully!', 'success');
      const counter = document.querySelector('[data-cart-count]');
      if (counter) {
        counter.textContent = data.count;
        counter.style.animation = 'pulse 0.5s ease';
        setTimeout(() => counter.style.animation = '', 500);
      }
    } else {
      showToast(data.message || 'Failed to add to cart', 'error');
    }
  } catch (e) {
    showToast('Network error', 'error');
  }
}

// Client-side validation helper
export function validateForm(form) {
  let ok = true;
  for (const input of form.querySelectorAll('[required]')) {
    if (!input.value.trim()) { ok = false; input.classList.add('error'); }
    else input.classList.remove('error');
  }
  return ok;
}


