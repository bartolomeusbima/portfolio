if (typeof AOS !== 'undefined') {
    AOS.init({
        duration: 700,
        easing: 'ease-out',
        once: true,
        offset: 40
    });
}

const accordionTriggers = document.querySelectorAll('[data-accordion-trigger]');

function toggleAccordion(trigger) {
    const item = trigger.closest('.project-accordion-item');
    const content = item ? item.querySelector('.project-accordion-content') : null;
    const isOpen = item ? item.classList.contains('is-open') : false;

    if (!item || !content) {
        return;
    }

    item.classList.toggle('is-open', !isOpen);
    trigger.setAttribute('aria-expanded', String(!isOpen));
    content.hidden = false;
}

accordionTriggers.forEach(function(trigger) {
    const item = trigger.closest('.project-accordion-item');
    const content = item ? item.querySelector('.project-accordion-content') : null;

    if (content && !item.classList.contains('is-open')) {
        content.hidden = false;
    }

    trigger.addEventListener('click', function() {
        toggleAccordion(trigger);
    });
});

const techStackLogoMap = {
    php: {
        label: 'PHP',
        src: '/assets/images/logos/php.svg'
    },
    python: {
        label: 'Python',
        src: '/assets/images/logos/python.svg'
    },
    flask: {
        label: 'Flask',
        src: '/assets/images/logos/flask.svg'
    },
    webix: {
        label: 'Webix',
        src: '/assets/images/logos/webix.svg'
    },
    bootstrap: {
        label: 'Bootstrap',
        src: '/assets/images/logos/bootstrap.svg'
    },
    'google-cloud': {
        label: 'Google Cloud',
        src: '/assets/images/logos/google-cloud.svg'
    },
    mysql: {
        label: 'MySQL',
        src: '/assets/images/logos/mysql.svg'
    },
    postgresql: {
        label: 'PostgreSQL',
        src: '/assets/images/logos/postgresql.svg'
    },
    oracle: {
        label: 'Oracle',
        src: '/assets/images/logos/oracle.svg'
    },
    'html-css-js': {
        label: 'HTML / CSS / JavaScript',
        src: '/assets/images/logos/html-css-js.svg'
    },
    hostinger: {
        label: 'Hostinger',
        src: '/assets/images/logos/hostinger.svg'
    },
    'rest-api': {
        label: 'REST API',
        src: '/assets/images/logos/rest-api.svg'
    }
};

function createTechStackLogoItem(key) {
    const logo = techStackLogoMap[key];
    const label = logo ? logo.label : key.replace(/-/g, ' ').replace(/\b\w/g, function(char) {
        return char.toUpperCase();
    });

    const item = document.createElement('div');
    item.className = 'tech-stack-logo';
    item.setAttribute('title', label);
    item.setAttribute('aria-label', label);

    if (logo) {
        const image = document.createElement('img');
        image.src = logo.src;
        image.alt = logo.label;
        item.appendChild(image);
    } else {
        item.classList.add('tech-stack-logo-text');
        item.textContent = label;
    }

    return item;
}

function buildTechStackMarquee(container) {
    const rawStack = container.dataset.techStack || '';
    const stack = rawStack
        .split(',')
        .map(function(item) {
            return item.trim().toLowerCase();
        })
        .filter(Boolean);

    if (!stack.length) {
        return;
    }

    const track = document.createElement('div');
    track.className = 'tech-stack-track';

    const group = document.createElement('div');
    group.className = 'tech-stack-group';

    stack.forEach(function(key) {
        const item = createTechStackLogoItem(key);

        if (item) {
            group.appendChild(item);
        }
    });

    if (!group.children.length) {
        return;
    }

    track.appendChild(group);
    container.innerHTML = '';
    container.appendChild(track);

    function syncTechStackMarquee() {
        const firstGroup = track.querySelector('.tech-stack-group');

        if (!firstGroup) {
            return;
        }

        while (track.children.length > 1) {
            track.removeChild(track.lastChild);
        }

        const baseWidth = Math.ceil(firstGroup.getBoundingClientRect().width);
        const containerWidth = Math.ceil(container.getBoundingClientRect().width);

        if (!baseWidth || !containerWidth) {
            return;
        }

        const repeatCount = Math.max(2, Math.ceil((containerWidth * 2) / baseWidth) + 1);

        for (let index = 1; index < repeatCount; index += 1) {
            track.appendChild(firstGroup.cloneNode(true));
        }

        container.style.setProperty('--tech-stack-loop-width', `${baseWidth}px`);
        track.style.animationDuration = `${Math.max(14, Math.round(baseWidth / 18))}s`;
    }

    requestAnimationFrame(syncTechStackMarquee);

    let resizeFrame = null;
    window.addEventListener('resize', function() {
        if (resizeFrame) {
            cancelAnimationFrame(resizeFrame);
        }

        resizeFrame = requestAnimationFrame(syncTechStackMarquee);
    });
}

document.querySelectorAll('[data-tech-stack]').forEach(buildTechStackMarquee);

