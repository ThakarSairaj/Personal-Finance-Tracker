function toggleTheme() {
    document.body.classList.toggle('dark');
    const header = document.querySelector('header');
    header.classList.toggle('dark');
    const navLinks = document.querySelectorAll('.nav-links li a');
    navLinks.forEach(link => {
        link.classList.toggle('dark');
    });
}
