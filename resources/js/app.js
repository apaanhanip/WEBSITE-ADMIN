import './bootstrap';

// Image preview for menu upload
document.addEventListener('DOMContentLoaded', () => {
    const imageInput = document.getElementById('menu-image');
    const imagePreview = document.getElementById('image-preview');

    if (imageInput && imagePreview) {
        imageInput.addEventListener('change', (e) => {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = (ev) => {
                    imagePreview.src = ev.target.result;
                    imagePreview.classList.remove('hidden');
                };
                reader.readAsDataURL(file);
            }
        });
    }

    // Order status update (AJAX)
    document.querySelectorAll('.order-status-select').forEach((select) => {
        select.addEventListener('change', async function () {
            const orderId = this.dataset.orderId;
            const url = this.dataset.url;
            const original = this.dataset.original;

            try {
                const response = await fetch(url, {
                    method: 'PATCH',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify({ status: this.value }),
                });

                const data = await response.json();

                if (data.success) {
                    const badge = document.getElementById(`status-badge-${orderId}`);
                    if (badge) {
                        badge.className = `badge badge-${data.status_color}`;
                        badge.textContent = data.status_label;
                    }
                    this.dataset.original = this.value;
                    if (typeof Toast !== 'undefined') {
                        Toast.fire({ icon: 'success', title: data.message });
                    }
                } else {
                    this.value = original;
                }
            } catch {
                this.value = original;
            }
        });
    });

    // Order detail modal
    document.querySelectorAll('.btn-order-detail').forEach((btn) => {
        btn.addEventListener('click', async function () {
            const url = this.dataset.url;
            const modal = document.getElementById('order-modal');
            const content = document.getElementById('order-modal-content');

            content.innerHTML = '<div class="flex justify-center py-12"><div class="h-8 w-8 animate-spin rounded-full border-4 border-coffee-200 border-t-coffee-700"></div></div>';
            modal.classList.remove('hidden');

            try {
                const response = await fetch(url, {
                    headers: { Accept: 'application/json', 'X-Requested-With': 'XMLHttpRequest' },
                });
                const data = await response.json();
                content.innerHTML = data.html;
            } catch {
                content.innerHTML = '<p class="text-center text-red-600 py-8">Gagal memuat detail pesanan.</p>';
            }
        });
    });

    document.querySelectorAll('[data-close-modal]').forEach((el) => {
        el.addEventListener('click', () => {
            document.getElementById('order-modal')?.classList.add('hidden');
        });
    });
});
