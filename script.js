// search 
document.addEventListener('DOMContentLoaded', () => {
    const searchInput = document.getElementById('search-input');
    const gridItems = document.querySelectorAll('.grid-item');
  
    searchInput.addEventListener('input', () => {
        const searchValue = searchInput.value.toLowerCase();
        gridItems.forEach(item => {
            const title = item.getAttribute('data-title').toLowerCase();
            if (title.includes(searchValue)) {
                item.style.display = 'block';
            } else {
                item.style.display = 'none';
            }
        });
    });
// close button in grid
    const closeButtons = document.querySelectorAll('.close-btn');
    closeButtons.forEach(btn => {
        btn.addEventListener('click', () => {
            const overlay = btn.closest('.menu-overlay');
            if (overlay) {
                overlay.style.display = 'none';
            }
        });
    });
});

// toggle menu
function toggleMenu() {
    const menuOverlay = document.getElementById('menu-overlay');
    menuOverlay.style.display = menuOverlay.style.display === 'flex' ? 'none' : 'flex';
}


document.addEventListener('DOMContentLoaded', () => {
    const searchInput = document.getElementById('search-input');
    const gridItems = document.querySelectorAll('.grid-item');
  
    searchInput.addEventListener('input', () => {
        const searchValue = searchInput.value.toLowerCase();
        gridItems.forEach(item => {
            const title = item.getAttribute('data-title').toLowerCase();
            if (title.includes(searchValue)) {
                item.style.display = 'block';
            } else {
                item.style.display = 'none';
            }
        });
    });

    const closeButtons = document.querySelectorAll('.close-btn2');
    closeButtons.forEach(btn => {
        btn.addEventListener('click', () => {
            const gridItem = btn.closest('.grid-item');
            if (gridItem) {
                gridItem.style.display = 'none';
            }
        });
    });
});


//tv shows API
document.addEventListener("DOMContentLoaded", () => {
    fetchTVShows();
});

function fetchTVShows() {
    fetch('http://api.tvmaze.com/shows')
        .then(response => response.json())
        .then(data => {
            displayTVShows(data.slice(0, 6)); // Display only the first 6 shows
        })
        .catch(error => console.error('Error fetching TV shows:', error));
}

function displayTVShows(shows) {
    const container = document.getElementById('tv-grid-container');
    shows.forEach(show => {
        const showElement = document.createElement('div');
        showElement.classList.add('tv-grid-item');
        showElement.innerHTML = `
            <img src="${show.image ? show.image.medium : 'assets/no-image.jpg'}" alt="${show.name}">
            <div class="tv-grid-content">
                <h3>${show.name}</h3>
                <p>${show.summary ? show.summary.replace(/(<([^>]+)>)/gi, "") : 'No summary available.'}</p>
            </div>
        `;
        container.appendChild(showElement);
    });
}
// slideshow

let slideIndex = 0;
showSlides();

function showSlides() {
  let i;
  let slides = document.getElementsByClassName("mySlides");
  for (i = 0; i < slides.length; i++) {
    slides[i].style.display = "none";  
  }
  slideIndex++;
  if (slideIndex > slides.length) {slideIndex = 1}    
  slides[slideIndex-1].style.display = "block";  
  setTimeout(showSlides, 4000); // Change image every 4 seconds
}