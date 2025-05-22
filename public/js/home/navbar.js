const sections = ['vases', 'candles', 'flowers', 'wall-art'];
const navLinks = document.querySelectorAll('#navbar-links .nav-link');

function updateActiveLink() {
    let scrollPosition = window.scrollY + 120;

    sections.forEach((id, index) => {
        const section = document.getElementById(id);
        if (section && section.offsetTop <= scrollPosition &&
            section.offsetTop + section.offsetHeight > scrollPosition) {

            navLinks.forEach(link => link.classList.remove('active'));
            navLinks[index].classList.add('active');
        }
    });
}

window.addEventListener('scroll', updateActiveLink);