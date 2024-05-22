export class RefreshHtmlHelper {

    public static refreshElementsOrRemoveIfNotFound(html: Document, selector: string): void {
        const currentElements = document.querySelectorAll(selector);
        const newElements = html.querySelectorAll(selector);

        for (let i = 0; i < currentElements.length; i++) {
            currentElements[i].replaceWith(newElements[i] ?? '');
        }
    }
}
