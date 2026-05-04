document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('formSiswa');
    if (!form) return;

    form.addEventListener('submit', function (e) {
        const nilaiRaport = parseFloat(form.querySelector('[name="nilai_raport"]')?.value);
        const penghasilan = parseFloat(form.querySelector('[name="penghasilan_ortu"]')?.value);
        const tanggungan  = parseInt(form.querySelector('[name="tanggungan_ortu"]')?.value);

        if (isNaN(nilaiRaport) || nilaiRaport < 0 || nilaiRaport > 100) {
            alert('Nilai raport harus antara 0 dan 100.');
            e.preventDefault(); return;
        }
        if (isNaN(penghasilan) || penghasilan < 0) {
            alert('Penghasilan orang tua tidak valid.');
            e.preventDefault(); return;
        }
        if (isNaN(tanggungan) || tanggungan < 0) {
            alert('Tanggungan orang tua tidak valid.');
            e.preventDefault(); return;
        }
    });
});
