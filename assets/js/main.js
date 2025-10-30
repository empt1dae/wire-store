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
export function showToast(message, type = 'info', timeout = 2500) {
  const root = ensureToastRoot();
  const el = document.createElement('div');
  el.className = `toast-item ${type === 'error' ? 'error' : ''}`;
  el.innerHTML = `<span>${message}</span><button class="btn icon-btn" aria-label="Close">✕</button>`;
  root.appendChild(el);
  const remove = () => el.remove();
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
      showToast('Product added to cart');
      const counter = document.querySelector('[data-cart-count]');
      if (counter) counter.textContent = data.count;
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


