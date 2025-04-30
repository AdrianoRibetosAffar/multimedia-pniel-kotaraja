// Menggunakan JavaScript untuk menyembunyikan navbar saat scroll ke bawah dan menampilkannya saat scroll ke atas
let lastScrollTop = 0;
const navbar = document.getElementById('mainNav');

window.addEventListener('scroll', function () {
    const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
    if (scrollTop > lastScrollTop) {
        // Scroll ke bawah, sembunyikan navbar
        navbar.classList.add('hidden');
    } else {
        // Scroll ke atas, tampilkan navbar
        navbar.classList.remove('hidden');
    }
    lastScrollTop = scrollTop;
    });
