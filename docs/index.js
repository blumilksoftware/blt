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
        const content = this.innerHTML;
        this.innerHTML = `
            <div class="my-2 bg-black text-white text-sm px-4 py-3 rounded shadow-lg">
                <pre>${content}</pre>
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
    const defaultElement = document.querySelector('sidebar-element[href="elements/environment.html"]');
    loadContent("elements/environment.html", defaultElement);
    highlightActive(defaultElement);
});

document.querySelectorAll('sidebar-element').forEach(element => {
    element.addEventListener('click', function () {
        if (this.getAttribute('target') !== '_blank') {
            loadContent(this.getAttribute('href'), this);
        }
    });
});
