document.addEventListener('DOMContentLoaded', function () {
    const sidebar = document.getElementById('sidebar');
    const sidebarToggle = document.getElementById('sidebarToggle');

    if (sidebar && sidebarToggle) {
        sidebarToggle.addEventListener('click', function () {
            sidebar.classList.toggle('show');
        });
    }

    document.querySelectorAll('.btn-delete').forEach(function (button) {
        button.addEventListener('click', function (event) {
            const message = button.dataset.confirm || 'Yakin ingin menghapus data ini?';

            if (!window.confirm(message)) {
                event.preventDefault();
            }
        });
    });

    const cartRows = document.querySelectorAll('[data-cart-row]');

    if (cartRows.length > 0) {
        const formatRupiah = function (value) {
            return 'Rp ' + Number(value || 0).toLocaleString('id-ID', {
                maximumFractionDigits: 0,
            });
        };

        const updateCartTotal = function () {
            let total = 0;

            cartRows.forEach(function (row) {
                const price = Number(row.dataset.unitPrice || 0);
                const input = row.querySelector('.cart-qty-input');
                const qty = Number(input ? input.value : 0);
                total += price * qty;
            });

            document.querySelectorAll('[data-cart-total]').forEach(function (target) {
                target.textContent = formatRupiah(total);
            });
        };

        cartRows.forEach(function (row) {
            const form = row.querySelector('.qty-form');
            const input = row.querySelector('.cart-qty-input');
            const subtotal = row.querySelector('[data-cart-subtotal]');
            const submitButton = row.querySelector('.qty-submit');
            const price = Number(row.dataset.unitPrice || 0);
            let saveTimer = null;

            if (!form || !input || !subtotal) {
                return;
            }

            if (submitButton) {
                submitButton.classList.add('d-none');
            }

            const normalizeQty = function () {
                const min = Number(input.min || 1);
                const max = Number(input.max || 999999);
                let qty = Number(input.value || min);

                if (qty < min) {
                    qty = min;
                }

                if (qty > max) {
                    qty = max;
                }

                input.value = qty;
                return qty;
            };

            const saveQty = function () {
                const formData = new FormData(form);

                fetch(form.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                    },
                })
                    .then(function (response) {
                        return response.json();
                    })
                    .then(function (data) {
                        if (!data.success) {
                            return;
                        }

                        if (typeof data.jumlah !== 'undefined') {
                            input.value = data.jumlah;
                        }

                        if (data.subtotalFormatted) {
                            subtotal.textContent = data.subtotalFormatted;
                        }

                        if (data.totalFormatted) {
                            document.querySelectorAll('[data-cart-total]').forEach(function (target) {
                                target.textContent = data.totalFormatted;
                            });
                        }

                        if (typeof data.cartCount !== 'undefined') {
                            document.querySelectorAll('.cart-count-badge').forEach(function (badge) {
                                badge.textContent = data.cartCount;
                            });
                        }
                    })
                    .catch(function () {});
            };

            const handleQtyChange = function () {
                const qty = normalizeQty();
                subtotal.textContent = formatRupiah(price * qty);
                updateCartTotal();

                window.clearTimeout(saveTimer);
                saveTimer = window.setTimeout(saveQty, 350);
            };

            input.addEventListener('input', handleQtyChange);
            input.addEventListener('change', handleQtyChange);

            form.addEventListener('submit', function (event) {
                event.preventDefault();
                handleQtyChange();
            });
        });
    }
});
