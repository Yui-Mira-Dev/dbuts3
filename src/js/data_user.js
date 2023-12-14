document.addEventListener('DOMContentLoaded', function () {
    const fileInput = document.getElementById('file-upload');
    const fileText = document.getElementById('file-name-info');

    function updateFileName() {
        if (fileInput.files.length > 0) {
            fileText.innerText = 'File yang dipilih: ' + fileInput.files[0].name;
        } else {
            fileText.innerText = 'Tidak ada file yang dipilih.';
        }
    }

    updateFileName();

    fileInput.addEventListener('change', updateFileName);
});

function confirmDelete(id) {
    if (confirm("Apakah Anda yakin ingin menghapus data ini?")) {
        window.location.href = "utils_form/hapus/hapus.php?id=" + id;
    }
}