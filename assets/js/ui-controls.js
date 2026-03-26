(function () {
    const langIdBtn = document.getElementById('langIdBtn');
    const langEnBtn = document.getElementById('langEnBtn');
    const langToggle = document.querySelector('[data-lang-toggle]');
    const langLabel = document.querySelector('[data-lang-label]');
    const themeToggle = document.getElementById('themeToggle') || document.querySelector('[data-theme-toggle]');
    const themeIcon = document.getElementById('themeIcon') || document.querySelector('[data-theme-icon]');

    const sunIcon = `
        <svg viewBox="-0.06 -0.06 0.72 0.72" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMinYMin meet" class="jam jam-sun">
            <path d="M0.3 0.39a0.09 0.09 0 1 0 0 -0.18 0.09 0.09 0 0 0 0 0.18m0 0.06a0.15 0.15 0 1 1 0 -0.3 0.15 0.15 0 0 1 0 0.3m0 -0.45a0.03 0.03 0 0 1 0.03 0.03v0.06a0.03 0.03 0 0 1 -0.06 0V0.03a0.03 0.03 0 0 1 0.03 -0.03m0 0.48a0.03 0.03 0 0 1 0.03 0.03v0.06a0.03 0.03 0 0 1 -0.06 0v-0.06a0.03 0.03 0 0 1 0.03 -0.03M0.03 0.27h0.06a0.03 0.03 0 1 1 0 0.06H0.03a0.03 0.03 0 0 1 0 -0.06m0.48 0h0.06a0.03 0.03 0 0 1 0 0.06h-0.06a0.03 0.03 0 0 1 0 -0.06m0.002 -0.182a0.03 0.03 0 0 1 0 0.042l-0.042 0.042a0.03 0.03 0 1 1 -0.042 -0.042l0.042 -0.042a0.03 0.03 0 0 1 0.042 0M0.173 0.427a0.03 0.03 0 0 1 0 0.042L0.13 0.512a0.03 0.03 0 1 1 -0.042 -0.042l0.042 -0.042a0.03 0.03 0 0 1 0.042 0zM0.13 0.088l0.042 0.042a0.03 0.03 0 0 1 -0.042 0.042L0.088 0.13A0.03 0.03 0 0 1 0.13 0.088zm0.339 0.339 0.042 0.042a0.03 0.03 0 0 1 -0.042 0.042l-0.042 -0.042a0.03 0.03 0 1 1 0.042 -0.042"/>
        </svg>
    `;

    const moonIcon = `
        <svg viewBox="0 0 0.72 0.72" xmlns="http://www.w3.org/2000/svg">
            <path d="M0.649 0.39a0.03 0.03 0 0 0 -0.032 -0.004 0.242 0.242 0 0 1 -0.101 0.022 0.244 0.244 0 0 1 -0.244 -0.243 0.258 0.258 0 0 1 0.007 -0.06A0.03 0.03 0 0 0 0.24 0.071a0.304 0.304 0 1 0 0.42 0.351 0.03 0.03 0 0 0 -0.011 -0.032m-0.285 0.201A0.244 0.244 0 0 1 0.212 0.157v0.008a0.304 0.304 0 0 0 0.304 0.304 0.294 0.294 0 0 0 0.063 -0.007 0.243 0.243 0 0 1 -0.215 0.13Z"/>
        </svg>
    `;

    let currentLang = localStorage.getItem('portfolio-lang') || 'en';
    let currentTheme = localStorage.getItem('portfolio-theme') || 'dark';

    function updateElementContent(element, value) {
        if (typeof value !== 'string') {
            return;
        }

        element.textContent = value;
    }

    function updateLanguage(lang) {
        document.documentElement.lang = lang === 'id' ? 'id' : 'en';

        document.querySelectorAll('[data-en]').forEach(function (el) {
            const nextText = lang === 'id' ? el.dataset.id : el.dataset.en;

            updateElementContent(el, nextText);
        });

        if (langIdBtn) {
            langIdBtn.classList.toggle('active', lang === 'id');
        }

        if (langEnBtn) {
            langEnBtn.classList.toggle('active', lang === 'en');
        }

        if (langLabel) {
            langLabel.textContent = lang.toUpperCase();
        }

        currentLang = lang;
        localStorage.setItem('portfolio-lang', lang);
    }

    function updateTheme(theme) {
        const isDark = theme === 'dark';
        const isLight = theme === 'light';

        document.body.classList.toggle('dark-mode', isDark);
        document.body.classList.toggle('light-mode', isLight);

        if (themeIcon) {
            themeIcon.innerHTML = isDark ? moonIcon : sunIcon;
        }

        currentTheme = theme;
        localStorage.setItem('portfolio-theme', theme);
    }

    if (langIdBtn) {
        langIdBtn.addEventListener('click', function () {
            updateLanguage('id');
        });
    }

    if (langEnBtn) {
        langEnBtn.addEventListener('click', function () {
            updateLanguage('en');
        });
    }

    if (langToggle) {
        langToggle.addEventListener('click', function () {
            updateLanguage(currentLang === 'en' ? 'id' : 'en');
        });
    }

    if (themeToggle) {
        themeToggle.addEventListener('click', function () {
            updateTheme(currentTheme === 'dark' ? 'light' : 'dark');
        });
    }

    updateLanguage(currentLang);
    updateTheme(currentTheme);

    window.PortfolioUI = {
        get language() {
            return currentLang;
        },
        get theme() {
            return currentTheme;
        },
        updateLanguage: updateLanguage,
        updateTheme: updateTheme
    };
})();
