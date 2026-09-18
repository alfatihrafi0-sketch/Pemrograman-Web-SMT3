// // Mengambil & menampilkan Daftar Buku secara asinkron dari data/buku.json
// async function muatDaftarBuku() {
//     const tbody = document.querySelector(".table-responsive table tbody");
//     const loading = document.getElementById("loading-indicator");
//     if (!tbody) return;

//     loading.style.display = "block";
//     tbody.innerHTML = "";

//     try {

// Fungsi Generik 
async function ambilDataApi(urlPath) {
    const res = await fetch(urlPath);
    if (!res.ok) {
        throw new Error("Gagal mengambil data (status " + res.status + ")");
    }
    return await res.json();
}
// Fungsi khusus daftar buku
async function muatDaftarBuku() {
    const tbody = document.querySelector(".table-responsive table tbody");
    const loading = document.getElementById("loading-indicator");
    if (!tbody) return;

    loading.style.display = "block";
    tbody.innerHTML = "";

    try {

         // Simulasi delay jaringan
        // await new Promise((resolve) => setTimeout(resolve, 600));
        await new Promise((resolve) => setTimeout(resolve, 3000));

        // Memanggil fungsi generik dengan memasukkan path file JSON buku
        const daftarBuku = await ambilDataApi("../data/buku.json");

        daftarBuku.forEach(function (buku) {
            const tr = document.createElement("tr");
            tr.innerHTML =
                "<td>" + buku.judul + "</td>" +
                "<td>" + buku.pengarang + "</td>" +
                "<td>" + buku.tahun + "</td>" +
                "<td>" + buku.stok + "</td>" +
                "<td>" + buku.kategori + "</td>" + 
                "<td>" +
                "<button type=\"button\">Edit</button> " +
                "<button type=\"button\" class=\"btn-hapus\">Hapus</button>" +
                "</td>";
            tbody.appendChild(tr);
        });
    } catch (err) {
        tbody.innerHTML =
            "<tr><td colspan=\"6\">Gagal memuat data: " + err.message + "</td></tr>";
    } finally {
        loading.style.display = "none";
    }
}

// Tambahkan fungsi listener untuk tombol refresh
function initTombolRefresh() {
    const btnRefresh = document.getElementById("btn-refresh");
    if (btnRefresh) {
        btnRefresh.addEventListener("click", function () {
            // Memanggil ulang fungsi muatDaftarBuku yang sudah ada di atas
            muatDaftarBuku(); 
        });
    }
}

// Menjalankan fungsi pemicu saat dokumen html selesai dimuat 
document.addEventListener("DOMContentLoaded", function () {
    muatDaftarBuku();
    initTombolRefresh();
});