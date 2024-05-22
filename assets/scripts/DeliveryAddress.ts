import {Helper} from "./Helper";

export class DeliveryAddress {

    public static updateForm(): void {
        let deliveryAddressCountry: Element = document.querySelector('[id$="_delivery_address_country"]');

        deliveryAddressCountry?.addEventListener('change', async function (event: Event): Promise<void> {
            let element: Element = event.target as Element;

            await DeliveryAddress.handleFormUpdate(element);
        });
    }

    private static async handleFormUpdate(element: Element): Promise<void> {
        const deliveryAddressCitySelector = '[id$="_delivery_address_city"]';
        let form: HTMLFormElement = element.closest('form');
        let html: Document = await Helper.updateForm(form);

        await this.addOrRemoveTaxNumberInput(html, deliveryAddressCitySelector);

        return await this.replaceCities(html, deliveryAddressCitySelector);
    }

    private static async addOrRemoveTaxNumberInput(html: Document, deliveryAddressCitySelector: string): Promise<void> {
        const deliveryAddressTaxNumberSelector = '[id$="_delivery_address_tax_number"]';

        let newFormTaxNumberInput: Element = html.querySelector(deliveryAddressTaxNumberSelector);

        if (!newFormTaxNumberInput) {
            return await this.removeTaxNumberInput(deliveryAddressTaxNumberSelector);
        }

        return await this.addTaxNumberInput(deliveryAddressTaxNumberSelector, deliveryAddressCitySelector, newFormTaxNumberInput);
    }

    private static async removeTaxNumberInput(deliveryAddressTaxNumberSelector: string): Promise<void> {
        let formTaxNumberInput = document.querySelector(deliveryAddressTaxNumberSelector);
        formTaxNumberInput?.closest('.mt-6').remove();
    }

    private static async addTaxNumberInput(deliveryAddressTaxNumberSelector: string, deliveryAddressCitySelector: string, newFormTaxNumberInput: Element): Promise<void> {
        if (document.querySelector(deliveryAddressTaxNumberSelector)) {
            return;
        }

        let inputBlock = newFormTaxNumberInput.closest('.mt-6');

        document.querySelector(deliveryAddressCitySelector).parentElement.after(inputBlock);
    }

    private static async replaceCities(html: Document, deliveryAddressCitySelector: string): Promise<void> {
        let formCityInput = document.querySelector(deliveryAddressCitySelector);

        formCityInput.replaceWith(html.querySelector(deliveryAddressCitySelector));
    }
}