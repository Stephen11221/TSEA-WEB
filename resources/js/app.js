const navToggle = document.querySelector('[data-nav-toggle]');
const navPanel = document.querySelector('[data-nav-panel]');

if (navToggle && navPanel) {
    navToggle.addEventListener('click', () => {
        const isOpen = navPanel.classList.toggle('open');
        navToggle.setAttribute('aria-expanded', String(isOpen));
    });

    navPanel.querySelectorAll('a').forEach((link) => {
        link.addEventListener('click', () => {
            navPanel.classList.remove('open');
            navToggle.setAttribute('aria-expanded', 'false');
        });
    });
}
