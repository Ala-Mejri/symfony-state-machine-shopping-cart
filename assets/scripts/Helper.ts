export class Helper {

    public static async ajaxCall(url: string, method: string, data: string): Promise<string> {
        let req: Response = await fetch(url, {
            method: method,
            body: data,
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
                'charset': 'utf-8',
                'X-Requested-With': 'XMLHttpRequest',
            }
        });

        return await req.text();
    }

    public static async updateForm(form: HTMLFormElement): Promise<Document> {
        let data = new FormData(form);

        let requestBody = '';
        data.forEach(function myFunction(attributeValue: FormDataEntryValue, attributeName: string): void {
            requestBody = requestBody + '&' + attributeName + '=' + attributeValue;
        });

        const ajaxResponse = await this.ajaxCall(form.action, form.method, requestBody);

        return this.parseTextToHtml(ajaxResponse);
    }

    private static parseTextToHtml(text: string): Document {
        let parser = new DOMParser();

        return parser.parseFromString(text, 'text/html');
    }
}