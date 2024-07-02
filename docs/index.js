class SidebarHeader extends HTMLElement {
    connectedCallback() {
        const content = this.innerHTML;
        this.innerHTML = `
            <li class="pl-3 py-2">
                <a href="#" class="text-gray-800 font-semibold">${content}</a>
            </li>
        `;
    }
}

class SidebarElement extends HTMLElement {
    static get observedAttributes() {
        return ["href", "target"];
    }

    connectedCallback() {
        const content = this.innerHTML;
        const href = this.getAttribute('href') || '#';
        const target = this.getAttribute('target') || '_self';
        if (target === '_blank') {
            this.innerHTML = `
                <li class="pl-3 py-2">
                    <a href="${href}" target="${target}">${content}</a>
                </li>
            `;
        } else {
            this.innerHTML = `
                <li class="pl-3 py-2">
                    <a href="${href}" target="${target}" onclick="event.preventDefault(); loadContent('${href}', this);">${content}</a>
                </li>
            `;
        }
    }
}

class ArticleHeader extends HTMLElement {
    connectedCallback() {
        const content = this.innerHTML;
        this.innerHTML = `
            <div class="border-b border-gray-200 py-4">
                <h3 class="text-2xl font-semibold leading-6 text-gray-900">${content}</h3>
            </div>
        `;
    }
}

class ArticleParagraphs extends HTMLElement {
    connectedCallback() {
        const content = this.innerHTML;
        this.innerHTML = `
            <div class="flex flex-col gap-4 my-6 leading-6 text-gray-600">${content}</div>
        `;
    }
}

class SectionHeader extends HTMLElement {
    connectedCallback() {
        const content = this.innerHTML;
        this.innerHTML = `
            <div class="bg-white my-2">
                <h3 class="text-base font-semibold leading-6 text-gray-900">${content}</h3>
            </div>
        `;
    }
}

class CodeSnippet extends HTMLElement {
    connectedCallback() {
        const gherkinText = this.getAttribute('gherkin');
        const phpText = this.getAttribute('php');

        this.innerHTML = `
            <div class="my-2 bg-black text-white text-sm px-4 py-3 rounded shadow-lg">
                <div class="mb-4 border-b border-gray-200 dark:border-gray-700">
                    <ul class="flex flex-wrap -mb-px text-sm font-medium text-center" id="default-tab"
                        data-tabs-toggle="#default-tab-content" role="tablist">
                        <li class="me-2" role="presentation">
                            <button class="inline-block p-4 border-b-2 rounded-t-lg" id="gherkin-tab"
                                    data-tabs-target="#gherkin" type="button" role="tab" aria-controls="gherkin"
                                    aria-selected="true">Gherkin
                            </button>
                        </li>
                        <li class="me-2" role="presentation">
                            <button
                                class="inline-block p-4 border-b-2 rounded-t-lg border-transparent hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300"
                                id="php-tab" data-tabs-target="#php" type="button" role="tab" aria-controls="php"
                                aria-selected="false">PHP
                            </button>
                        </li>
                    </ul>
                </div>
                <div id="default-tab-content">
                    <div class="p-4" id="gherkin" role="tabpanel"
                         aria-labelledby="gherkin-tab">
                        <pre>${gherkinText}</pre>
                    </div>
                    <div class="hidden p-4" id="php" role="tabpanel"
                         aria-labelledby="php-tab">
                        <pre>${phpText}</pre>
                    </div>
                </div>
            </div>
       `;

        this.querySelectorAll('button[data-tabs-target]').forEach(button => {
            button.addEventListener('click', this.highlightActive.bind(this));
        });

        this.setDefaultActive();
    }

    setDefaultActive() {
        const gherkinTab = this.querySelector('#gherkin-tab');
        const gherkinPanel = this.querySelector('#gherkin');

        if (gherkinTab && gherkinPanel) {
            gherkinTab.classList.add('border-blue-500', 'text-blue-600');
            gherkinTab.classList.remove('border-transparent');
            gherkinPanel.classList.remove('hidden');
        } else {
            console.error('Default Gherkin tab or panel not found.');
        }
    }

    highlightActive(event) {
        const tabButtons = this.querySelectorAll('button[data-tabs-target]');
        const tabPanels = this.querySelectorAll('#default-tab-content > div');

        tabButtons.forEach(button => {
            button.classList.remove('border-blue-500', 'text-blue-600');
            button.classList.add('border-transparent');
        });

        tabPanels.forEach(panel => {
            panel.classList.add('hidden');
        });

        const target = event.currentTarget.getAttribute('data-tabs-target');
        const targetPanel = this.querySelector(target);

        if (targetPanel) {
            event.currentTarget.classList.add('border-blue-500', 'text-blue-600');
            event.currentTarget.classList.remove('border-transparent');
            targetPanel.classList.remove('hidden');
        } else {
            console.error(`Element with selector "${target}" not found.`);
        }
    }
}
class CodeBlock extends HTMLElement {
    connectedCallback() {
        const content = this.innerHTML
        this.innerHTML = `
            <div class="my-2 bg-black text-white text-sm px-4 py-3 rounded shadow-lg">
              <pre>${content}</pre>
            </div>
        `
    }
}

customElements.define('sidebar-header', SidebarHeader);
customElements.define('sidebar-element', SidebarElement);
customElements.define('article-header', ArticleHeader);
customElements.define('article-paragraphs', ArticleParagraphs);
customElements.define('section-header', SectionHeader);
customElements.define('code-snippet', CodeSnippet);
customElements.define('code-block', CodeBlock);

function loadContent(page, element) {
    fetch(page)
        .then(response => response.text())
        .then(data => {
            document.getElementById("content").innerHTML = `
                <div class="flex-1 p-1 -mt-4">
                    ${data}
                </div>
            `;
            highlightActive(element);
        });
}

function highlightActive(element) {
    const sidebarElements = document.querySelectorAll('sidebar-element');
    sidebarElements.forEach(el => {
        const anchor = el.querySelector('a');
        anchor.classList.remove('text-sky-600', 'font-semibold');
        anchor.textContent = anchor.textContent.replace(/^# /, '');
    });
    const anchor = element.querySelector('a');
    anchor.classList.add('text-sky-600', 'font-semibold');
    anchor.textContent = `# ${anchor.textContent}`;
}

document.addEventListener("DOMContentLoaded", function () {
    const defaultElement = document.querySelector('sidebar-element[href="elements/overview.html"]');
    loadContent("elements/overview.html", defaultElement);
    highlightActive(defaultElement);
});

document.querySelectorAll('sidebar-element').forEach(element => {
    element.addEventListener('click', function () {
        if (this.getAttribute('target') !== '_blank') {
            loadContent(this.getAttribute('href'), this);
        }
    });
});