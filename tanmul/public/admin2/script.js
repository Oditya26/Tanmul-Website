// Selecting all side menu items
const allSideMenu = document.querySelectorAll('#sidebar .side-menu.top li a');

allSideMenu.forEach(item => {
  const li = item.parentElement;

  item.addEventListener('click', function () {
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

switchMode.addEventListener('change', function () {
  if (this.checked) {
	document.body.classList.add('dark');
  } else {
	document.body.classList.remove('dark');
  }
});

// Handle window resize for sidebar
if (window.innerWidth < 768) {
  sidebar.classList.add('hide');
}

window.addEventListener('resize', function () {
  if (this.innerWidth < 768) {
	sidebar.classList.add('hide');
  } else {
	sidebar.classList.remove('hide');
  }
});