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
            <div class="my-2 bg-black text-white text-sm px-4 py-3 rounded shadow-lg relative">
                <div class="absolute top-2 right-2 flex space-x-2">
                    <button class="text-xs hover:text-gray-600 dark:hover:text-gray-300 text-white px-2 py-4 rounded flex items-center" onclick="copyToClipboard(\`${gherkinText}\`, 'Gherkin')">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 17.25v3.375c0 .621-.504 1.125-1.125 1.125h-9.75a1.125 1.125 0 0 1-1.125-1.125V7.875c0-.621.504-1.125 1.125-1.125H6.75a9.06 9.06 0 0 1 1.5.124m7.5 10.376h3.375c.621 0 1.125-.504 1.125-1.125V11.25c0-4.46-3.243-8.161-7.5-8.876a9.06 9.06 0 0 0-1.5-.124H9.375c-.621 0-1.125.504-1.125 1.125v3.5m7.5 10.375H9.375a1.125 1.125 0 0 1-1.125-1.125v-9.25m12 6.625v-1.875a3.375 3.375 0 0 0-3.375-3.375h-1.5a1.125 1.125 0 0 1-1.125-1.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H9.75" />
                    </svg>
                        Copy Gherkin
                    </button>
                    <button class="text-xs hover:text-gray-600 dark:hover:text-gray-300 text-white px-2 py-2 rounded flex items-center" onclick="copyToClipboard(\`${phpText}\`, 'PHP')">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 17.25v3.375c0 .621-.504 1.125-1.125 1.125h-9.75a1.125 1.125 0 0 1-1.125-1.125V7.875c0-.621.504-1.125 1.125-1.125H6.75a9.06 9.06 0 0 1 1.5.124m7.5 10.376h3.375c.621 0 1.125-.504 1.125-1.125V11.25c0-4.46-3.243-8.161-7.5-8.876a9.06 9.06 0 0 0-1.5-.124H9.375c-.621 0-1.125.504-1.125 1.125v3.5m7.5 10.375H9.375a1.125 1.125 0 0 1-1.125-1.125v-9.25m12 6.625v-1.875a3.375 3.375 0 0 0-3.375-3.375h-1.5a1.125 1.125 0 0 1-1.125-1.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H9.75" />
                    </svg>
                        Copy PHP
                    </button>
                </div>
                <div class="mb-4 border-b border-gray-200 dark:border-gray-700">
                    <ul class="flex flex-wrap -mb-px text-sm font-medium text-center" id="default-tab"
                        data-tabs-toggle="#default-tab-content" role="tablist">
                        <li class="me-2" role="presentation">
                            <button class="inline-block p-4 border-b-2 hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300 rounded-t-lg" id="gherkin-tab"
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
                    <div class="p-4 bg-black" id="gherkin" role="tabpanel"
                         aria-labelledby="gherkin-tab">
                        <pre><code class="gherkin bg-black text-white">${gherkinText}</code></pre>
                    </div>
                    <div class="hidden p-4 bg-black" id="php" role="tabpanel"
                         aria-labelledby="php-tab">
                        <pre><code class="php bg-black text-white">${phpText}</code></pre>
                    </div>
                </div>
            </div>
       `;

        this.querySelectorAll('button[data-tabs-target]').forEach(button => {
            button.addEventListener('click', this.highlightActive.bind(this));
        });

        this.setDefaultActive();
        hljs.highlightAll();
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
            hljs.highlightElement(targetPanel.querySelector('code'));
        } else {
            console.error(`Element with selector "${target}" not found.`);
        }
    }
}

class CodeBlock extends HTMLElement {
    connectedCallback() {
        const content = this.innerHTML
        this.innerHTML = `
            <div class="relative my-2 bg-black text-white text-sm px-4 py-3 rounded shadow-lg">
                <button class="absolute top-2 right-2 text-xs hover:text-gray-600 dark:hover:text-gray-300 text-white px-2 py-1 rounded flex items-center" onclick="copyToClipboard(\`${content}\`)">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 17.25v3.375c0 .621-.504 1.125-1.125 1.125h-9.75a1.125 1.125 0 0 1-1.125-1.125V7.875c0-.621.504-1.125 1.125-1.125H6.75a9.06 9.06 0 0 1 1.5.124m7.5 10.376h3.375c.621 0 1.125-.504 1.125-1.125V11.25c0-4.46-3.243-8.161-7.5-8.876a9.06 9.06 0 0 0-1.5-.124H9.375c-.621 0-1.125.504-1.125 1.125v3.5m7.5 10.375H9.375a1.125 1.125 0 0 1-1.125-1.125v-9.25m12 6.625v-1.875a3.375 3.375 0 0 0-3.375-3.375h-1.5a1.125 1.125 0 0 1-1.125-1.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H9.75" />
                    </svg>
                    Copy
                </button>
                <pre><code class="php my-2 bg-black text-sm px-4 py-3 text-white rounded shadow-lg">${content}</code></pre>
            </div>
        `;
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
            hljs.highlightAll();
        });
}

function copyToClipboard(text, type) {
    navigator.clipboard.writeText(text).then(() => {
        showToast(`Copied ${type} to clipboard`);
    }).catch(err => {
        console.error('Failed to copy text: ', err);
    });
}

function showToast(message) {
    const toast = document.getElementById('toast');
    const toastMessage = document.getElementById('toast-message');
    toastMessage.textContent = message;
    toast.classList.remove('hidden');
    setTimeout(() => {
        hideToast();
    }, 3000);
}

function hideToast() {
    const toast = document.getElementById('toast');
    toast.classList.add('hidden');
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
