document.addEventListener('DOMContentLoaded', function () {
    var versionInfo = document.getElementById('versionInfo');
    var infoModal = new bootstrap.Modal(document.getElementById('infoModal'));

    versionInfo.addEventListener('click', function (e) {
        e.preventDefault();
        infoModal.show();
    });
});
