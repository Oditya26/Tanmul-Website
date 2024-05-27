// Selecting all side menu items
const allSideMenu = document.querySelectorAll('#sidebar .side-menu.top li a');

allSideMenu.forEach(item => {
  const li = item.parentElement;

  item.addEventListener('click', function () {
    // Menyembunyikan sidebar saat menu diklik
    sidebar.classList.add('hide');

    allSideMenu.forEach(i => {
      i.parentElement.classList.remove('active');
    });
    li.classList.add('active');
  });
});

// Toggle sidebar
const menuBar = document.querySelector('#content nav .bx.bx-menu');
const sidebar = document.getElementById('sidebar');

menuBar.addEventListener('click', function () {
  sidebar.classList.toggle('hide');
});

// Switch mode
const switchMode = document.getElementById('switch-mode');

// Periksa apakah ada preferensi mode yang disimpan di localStorage
const savedMode = localStorage.getItem('mode');
if (savedMode) {
  switchMode.checked = savedMode === 'dark'; // Atur switch mode sesuai preferensi yang disimpan
  document.body.classList.toggle('dark', savedMode === 'dark'); // Atur tema sesuai preferensi yang disimpan
}

switchMode.addEventListener('change', function () {
  if (this.checked) {
    document.body.classList.add('dark');
    localStorage.setItem('mode', 'dark'); // Simpan preferensi mode ke localStorage
  } else {
    document.body.classList.remove('dark');
    localStorage.setItem('mode', 'light'); // Simpan preferensi mode ke localStorage
  }
});

// Handle window resize for sidebar
if (window.innerWidth < 2000) {
  sidebar.classList.add('hide');
}

window.addEventListener('resize', function () {
  if (this.innerWidth < 2000) {
    sidebar.classList.add('hide');
  } else {
    sidebar.classList.remove('hide');
  }
});