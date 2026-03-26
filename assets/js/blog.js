window.addEventListener('DOMContentLoaded', function() {
    const blogHeading = document.querySelector('[data-init-blog="heading"]');
    const blogCards = document.querySelectorAll('[data-init-blog="card"]');

    window.PortfolioReveal.revealElement(blogHeading, 80);
    window.PortfolioReveal.revealSequence(blogCards, 180, 90);
});
