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
});
