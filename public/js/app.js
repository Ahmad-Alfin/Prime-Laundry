// public/js/app.js

function openMemberModal(packageName, price) {
    console.log("Tombol paket berhasil diklik!");
    
    // Cari element modal berdasarkan ID modal kamu di HTML
    // Contoh penanganan modal Bootstrap standar:
    const memberModal = document.getElementById('memberModal'); 
    if (memberModal) {
        // Jika kamu pakai Bootstrap 5 (tanpa jQuery):
        // var modal = new bootstrap.Modal(memberModal);
        // modal.show();
        
        // Skenario cadangan jika kamu pakai modal custom CSS (mengubah class/style display):
        memberModal.style.display = 'flex';
    } else {
        alert("Pop-up pendaftaran member sedang dipersiapkan!");
    }
}