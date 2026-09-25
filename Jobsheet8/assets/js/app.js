// Hamburger menu (JS-driven, menggantikan checkbox hack) 
function initNavToggle() {
    const toggleBtn = document.getElementById("nav-toggle-btn");
    const nav = document.querySelector("header nav");
    if (!toggleBtn || !nav) return;
    
    toggleBtn.addEventListener("click", function () {
        nav.classList.toggle("nav-open");
    });
}

// ===== Konfirmasi hapus (front-end only, belum ke server) =====
// Memakai event delegation di document karena baris tabel sekarang
// dirender dinamis via fetch (lihat buku.js/anggota.js) sehingga
// tombol .btn-hapus belum tentu ada saat DOMContentLoaded.
// function initHapusConfirm() {
//     document.addEventListener("click", function (e) {
//         const btn = e.target.closest(".btn-hapus");
//         if (!btn) return;

//         const row = btn.closest("tr");
//         const nama = row ? row.querySelector("td")?.textContent : "data ini";
//         const yakin = confirm("Yakin ingin menghapus \"" + nama + "\"?");
//         if (yakin && row) {
//             row.remove();
//         }
//     });
// }

function initHapusConfirm() {
    document.addEventListener("click", function (e) {
        console.log("Elemen yang di-klik saat ini:", e.target);

        // Apakah elemen yang diklik (atau komponen terdekatnya) adalah tombol hapus?
        const btn = e.target.closest(".btn-hapus");
        
        // Jika yang diklik bukan tombol hapus, abaikan (stop eksekusi fungsi ke bawah)
        if (!btn) return;

        // Jika benar tombol hapus, jalankan logika hapus baris tabel seperti biasa
        const row = btn.closest("tr");
        const nama = row ? row.querySelector("td")?.textContent : "data ini";
        const yakin = confirm("Yakin ingin menghapus \"" + nama + "\"?");
        if (yakin && row) {
            row.remove();
        }
    });
}

// ===== Filter/pencarian tabel real-time =====
function initTableFilter() {
    const input = document.getElementById("search-input");
    const table = document.querySelector(".table-responsive table");
    if (!input || !table) return;

    input.addEventListener("keyup", function () {
        const keyword = input.value.toLowerCase();
        const rows = table.querySelectorAll("tbody tr");
        rows.forEach(function (row) {
            const teks = row.textContent.toLowerCase();
            row.style.display = teks.includes(keyword) ? "" : "none";
        });
    });
}

//  Validasi form (client-side) 
function tampilkanError(input, pesan) {
    hapusError(input);
    const span = document.createElement("span");
    span.className = "error";
    span.textContent = pesan;
    input.insertAdjacentElement("afterend", span);
}

function hapusError(input) {
    const next = input.nextElementSibling;
    if (next && next.classList.contains("error")) {
        next.remove();
    }
}

function initValidasiForm() {
    const form = document.getElementById("form-tambah");
    if (!form) return;

    form.addEventListener("submit", function (e) {
        let valid = true;
      
        const fieldWajib = [
    {
        selector: "[name='judul'], [name='nama']",
        pesan: "Field ini wajib diisi."
    },
    {
        selector: "[name='pengarang']",
        pesan: "Pengarang wajib diisi."
    }
];

fieldWajib.forEach(function (field) {
    const input = form.querySelector(field.selector);

    if (!input) return;

    if (input.value.trim() === "") {
        tampilkanError(input, field.pesan);
        valid = false;
    } else {
        hapusError(input);
    }
});

const tahun = form.querySelector("[name='tahun']");
        if (tahun) {
            const nilai = parseInt(tahun.value, 10);
            if (isNaN(nilai) || nilai < 1900 || nilai > 2026) {
                tampilkanError(tahun, "Tahun harus di antara 1900-2026.");
                valid = false;
            } else {
                hapusError(tahun);
            }
}

        const stok = form.querySelector("[name='stok']");
        if (stok) {
            const nilai = parseInt(stok.value, 10);
            if (isNaN(nilai) || nilai < 0) {
                tampilkanError(stok, "Stok tidak boleh negatif.");
                valid = false;
            } else {
                hapusError(stok);
            }
        }

        const isbn = form.querySelector("[name='isbn']");
        if (isbn) {
            const nilai = isbn.value.trim();
            const polaISBN = /^[0-9-]+$/;

        if (nilai === "") {
        tampilkanError(isbn, "ISBN wajib diisi.");
        valid = false;
            } else if (!polaISBN.test(nilai)) {
                tampilkanError(isbn, "ISBN hanya boleh berisi angka dan tanda hubung (-).");
                valid = false;
            } else {
        hapusError(isbn);
    }
}
        
        // (pengecekan pengarang, tahun, stok dengan pola serupa)...

        if (!valid) {
            e.preventDefault();
        }
    });
}

document.addEventListener("DOMContentLoaded", function () {
    initNavToggle();
    initHapusConfirm();
    initTableFilter();
    initValidasiForm();
});
