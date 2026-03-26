const cards = document.querySelectorAll('[data-init-work="card"]');
const heading = document.querySelector('[data-init-work="heading"]');
const prefersReducedMotion = window.PortfolioReveal.prefersReducedMotion;
const desktopTimelineQuery = window.matchMedia('(min-width: 1024px) and (pointer: fine)');

function initCompanyCarousel() {
    const carousel = document.querySelector('[data-company-carousel]');

    if (!carousel) {
        return;
    }

    const track = carousel.querySelector('[data-carousel-track]');
    const prevButton = carousel.querySelector('[data-carousel-prev]');
    const nextButton = carousel.querySelector('[data-carousel-next]');
    const dots = Array.from(carousel.querySelectorAll('[data-carousel-dot]'));
    const totalSlides = dots.length;
    const autoSlideDelay = 3200;
    let currentIndex = 0;
    let autoSlideTimer = null;

    if (!track || !prevButton || !nextButton || totalSlides === 0) {
        return;
    }

    function renderCarousel() {
        track.style.transform = `translateX(-${currentIndex * 100}%)`;

        dots.forEach(function(dot, index) {
            const isActive = index === currentIndex;
            dot.classList.toggle('active', isActive);
            dot.setAttribute('aria-current', isActive ? 'true' : 'false');
        });
    }

    function goToSlide(nextIndex) {
        currentIndex = (nextIndex + totalSlides) % totalSlides;
        renderCarousel();
    }

    function stopAutoSlide() {
        if (!autoSlideTimer) {
            return;
        }

        window.clearInterval(autoSlideTimer);
        autoSlideTimer = null;
    }

    function startAutoSlide() {
        if (prefersReducedMotion) {
            return;
        }

        stopAutoSlide();
        autoSlideTimer = window.setInterval(function() {
            goToSlide(currentIndex + 1);
        }, autoSlideDelay);
    }

    prevButton.addEventListener('click', function() {
        goToSlide(currentIndex - 1);
        startAutoSlide();
    });

    nextButton.addEventListener('click', function() {
        goToSlide(currentIndex + 1);
        startAutoSlide();
    });

    dots.forEach(function(dot, index) {
        dot.addEventListener('click', function() {
            goToSlide(index);
            startAutoSlide();
        });
    });

    renderCarousel();
    startAutoSlide();
}

function initFeaturedProjectAccordions() {
    const accordionItems = document.querySelectorAll('[data-featured-accordion]');

    accordionItems.forEach(function(item) {
        const trigger = item.querySelector('[data-featured-trigger]');

        if (!trigger) {
            return;
        }

        trigger.addEventListener('click', function() {
            const isOpen = item.classList.contains('is-open');
            item.classList.toggle('is-open', !isOpen);
            trigger.setAttribute('aria-expanded', String(!isOpen));
        });
    });
}

function setToggleLabel(toggle, view) {
    if (!toggle) {
        return;
    }

    const label = toggle.querySelector('span');

    if (!label) {
        return;
    }

    const isCompanyView = view === 'company';
    const labelEn = isCompanyView
        ? toggle.dataset.labelCompanyEn
        : toggle.dataset.labelProjectEn;
    const labelId = isCompanyView
        ? toggle.dataset.labelCompanyId
        : toggle.dataset.labelProjectId;

    toggle.dataset.view = view;
    label.textContent = labelEn;
    label.setAttribute('data-en', labelEn);
    label.setAttribute('data-id', labelId);
}

function revealPanelCards(panel) {
    const panelCards = Array.from(panel.querySelectorAll('[data-init-work="card"]'));

    panelCards.forEach(function(card, index) {
        window.PortfolioReveal.revealElement(card, 35 + (index * 28));
    });
}

function initWorkViewToggle() {
    const toggle = document.querySelector('[data-work-toggle]');

    if (!toggle) {
        return;
    }

    setToggleLabel(toggle, toggle.dataset.view || 'company');
}

window.addEventListener('DOMContentLoaded', function() {
    window.PortfolioReveal.revealElement(heading, 80);
    cards.forEach(function(card, index) {
        const panel = card.closest('[data-work-panel]');

        if (panel && panel.hidden) {
            return;
        }

        window.PortfolioReveal.revealElement(card, 180 + (index * 90));
    });

    initCompanyCarousel();
    initFeaturedProjectAccordions();
    initWorkViewToggle();

    const timelineSection = document.querySelector('.company-timeline-section');
    const timelineScroll = document.querySelector('.company-timeline-scroll');
    let isTimelineHovering = false;
    let isPointerDown = false;
    let isDraggingTimeline = false;
    let dragStartX = 0;
    let dragStartScrollLeft = 0;

    if (!timelineSection || !timelineScroll) {
        return;
    }

    timelineSection.addEventListener('mouseenter', function() {
        isTimelineHovering = true;
    });

    timelineSection.addEventListener('mouseleave', function() {
        isTimelineHovering = false;
    });

    timelineScroll.addEventListener('wheel', function(event) {
        if (!desktopTimelineQuery.matches || !isTimelineHovering) {
            return;
        }

        if (timelineScroll.scrollWidth <= timelineScroll.clientWidth) {
            return;
        }

        if (Math.abs(event.deltaY) <= Math.abs(event.deltaX)) {
            return;
        }

        const maxScrollLeft = timelineScroll.scrollWidth - timelineScroll.clientWidth;
        const nextScrollLeft = Math.min(
            maxScrollLeft,
            Math.max(0, timelineScroll.scrollLeft + event.deltaY)
        );

        if (nextScrollLeft === timelineScroll.scrollLeft) {
            return;
        }

        event.preventDefault();
        timelineScroll.scrollLeft = nextScrollLeft;
    }, { passive: false });

    timelineScroll.addEventListener('mousedown', function(event) {
        if (!desktopTimelineQuery.matches || event.button !== 0) {
            return;
        }

        isPointerDown = true;
        isDraggingTimeline = false;
        dragStartX = event.clientX;
        dragStartScrollLeft = timelineScroll.scrollLeft;
    });

    window.addEventListener('mousemove', function(event) {
        if (!isPointerDown || !desktopTimelineQuery.matches) {
            return;
        }

        const deltaX = event.clientX - dragStartX;

        if (!isDraggingTimeline && Math.abs(deltaX) > 6) {
            isDraggingTimeline = true;
            timelineScroll.classList.add('is-dragging');
        }

        if (!isDraggingTimeline) {
            return;
        }

        event.preventDefault();
        timelineScroll.scrollLeft = dragStartScrollLeft - deltaX;
    });

    window.addEventListener('mouseup', function() {
        if (!isPointerDown) {
            return;
        }

        isPointerDown = false;

        window.setTimeout(function() {
            isDraggingTimeline = false;
            timelineScroll.classList.remove('is-dragging');
        }, 0);
    });

    timelineScroll.addEventListener('mouseleave', function() {
        if (!isPointerDown) {
            return;
        }

        isPointerDown = false;
        isDraggingTimeline = false;
        timelineScroll.classList.remove('is-dragging');
    });

    timelineScroll.addEventListener('click', function(event) {
        if (!isDraggingTimeline) {
            return;
        }

        event.preventDefault();
        event.stopPropagation();
    }, true);
});
