class SidebarHeader extends HTMLElement {
    connectedCallback() {
        const content = this.innerHTML
        this.innerHTML = `
            <li class="pl-3 py-2">
              <a href="#" class="text-gray-800 font-semibold">${content}</a>
            </li>
        `
    }
}
class SidebarElement extends HTMLElement {
    static get observedAttributes() {
        return ["href", "target"];
    }

    connectedCallback() {
        const content = this.innerHTML
        this.innerHTML = `
            <li class="pl-3 py-2">
              <a href="${this.getAttribute('href') || '#'}" target="${this.getAttribute('target') || '_self'}">${content}</a>
            </li>
        `
    }
}

class ArticleHeader extends HTMLElement {
    connectedCallback() {
        const content = this.innerHTML
        this.innerHTML = `
            <div class="border-b border-gray-200 py-4">
                <h3 class="text-2xl font-semibold leading-6 text-gray-900">${content}</h3>
            </div>
        `
    }
}

class ArticleParagraphs extends HTMLElement {
    connectedCallback() {
        const content = this.innerHTML
        this.innerHTML = `
            <div class="flex flex-col gap-4 my-6 leading-6 text-gray-600">${content}</div>
        `
    }
}

class SectionHeader extends HTMLElement {
    connectedCallback() {
        const content = this.innerHTML
        this.innerHTML = `
            <div class="bg-white my-2">
              <h3 class="text-base font-semibold leading-6 text-gray-900">${content}</h3>
            </div>
        `
    }
}

class CodeSnippet extends HTMLElement {
    connectedCallback() {
        const content = this.innerHTML
        this.innerHTML = `
            <div class="my-2 bg-black text-white text-sm px-4 py-3 rounded shadow-lg">
              <pre>${content}</pre>
            </div>
        `
    }
}

customElements.define('sidebar-header', SidebarHeader)
customElements.define('sidebar-element', SidebarElement)
customElements.define('article-header', ArticleHeader)
customElements.define('article-paragraphs', ArticleParagraphs)
customElements.define('section-header', SectionHeader)
customElements.define('code-snippet', CodeSnippet)
