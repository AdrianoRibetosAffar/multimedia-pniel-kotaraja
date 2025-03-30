// hidden navbar on scroll
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

// Data untuk statistik
const xValues = ["I", "II", "III", "IV", "V", "VI", "VII", "VIII", "IX", "X", "XI", "XII", "XIII", "XIV", "XV", "XVI"];
const yValues = [55, 49, 44, 24, 15, 16, 23, 30, 12, 20, 15, 18, 25, 10, 8, 5];
const barColors = [
    "#FFCE56", "#4BC0C0", "#9966FF", "#FF9F40", "#E7E9ED", "#FF6384", "#36A2EB", "#FFCE56", "#4BC0C0", "#9966FF", "#FF9F40", "#E7E9ED", "#FF6384", "#36A2EB", "#FFCE56", "#4BC0C0"
];

// Membuat diagram donat
// new Chart("statistikDonut", {
//     type: "bar",
//     data: {
//         labels: xValues,
//         datasets: [{
//             backgroundColor: barColors,
//             data: yValues
//         }]
//     },
//     options: {
//         responsive: true,
//         plugins: {
//             legend: {
//                 position: 'top',
//             },
//             title: {
//                 display: true,
//                 text: 'Statistik Jemaat per Rayon'
//             }
//         }
//     }
// });
new Chart("statistikDonut", {
    type: "bar",
    data: {
      labels: xValues,
      datasets: [{
        backgroundColor: barColors,
        data: yValues
      }]
    },
    options: {
      legend: {display: false},
      scales: {
        yAxes: [{
          ticks: {
            beginAtZero: true
          }
        }]
      },
  
      title: {
        display: true,
        text: "Statistik Jemaat Per Rayon",
      }
    }
  });

// Mengisi tabel secara dinamis
const tableBody = document.getElementById("statistikTableBody");

xValues.forEach((rayon, index) => {
    const row = document.createElement("tr");
    row.innerHTML = `
        <td>${index + 1}</td>
        <td>${rayon}</td>
        <td>${yValues[index]}</td>
    `;
    tableBody.appendChild(row);
});