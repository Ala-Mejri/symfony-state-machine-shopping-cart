import {Helper} from "./Helper";
import {RefreshHtmlHelper} from "./RefreshHtmlHelper";

export class Cart {

    public static clearItems(): void {
        let clearItemsButton = document.querySelector('#order-items #show_cart_clear');

        clearItemsButton?.addEventListener('click', async function (): Promise<void> {
            let clearItemsCheckbox: HTMLInputElement = document.querySelector('#order-items #show_cart_clearItems');

            clearItemsCheckbox.checked = true;
            await Cart.updateItemQuantity(clearItemsCheckbox);
        });
    }

    public static updateItemsQuantity(): void {
        let orderItemQuantityElements = document.querySelectorAll('#order-items [data-name="order-item-quantity"]');

        orderItemQuantityElements?.forEach(function (itemQuantityElement): void {
            itemQuantityElement.addEventListener('change', async function (event: Event): Promise<void> {
                let element: HTMLInputElement = event.target as HTMLInputElement;
                await Cart.updateItemQuantity(element);
            });
        });
    }

    public static removeItems(): void {
        let removeItemButtons = document.querySelectorAll('#order-items [data-id="remove-item"]');

        removeItemButtons?.forEach(function (removeItemButton): void {
            removeItemButton.addEventListener('click', async function (event: Event): Promise<void> {
                let element: HTMLElement = event.target as HTMLElement;
                await Cart.setItemQuantityToZero(element);
            });
        });
    }

    private static async setItemQuantityToZero(element: HTMLElement): Promise<void> {
        let orderItem: HTMLElement = element.closest('[itemscope]');
        let orderItemQuantity: HTMLInputElement = orderItem.querySelector('[data-name="order-item-quantity"]');

        orderItemQuantity.setAttribute('value', '0');
        orderItemQuantity.dispatchEvent(new Event('change'));
    }

    private static async updateItemQuantity(element: HTMLElement): Promise<void> {
        let html: Document = await this.getUpdatedFormHtml(element);

        RefreshHtmlHelper.refreshElementsOrRemoveIfNotFound(html, '#alerts-section');
        RefreshHtmlHelper.refreshElementsOrRemoveIfNotFound(html, '#cart-items-block');
        RefreshHtmlHelper.refreshElementsOrRemoveIfNotFound(html, '#order-total-block');

        this.refreshEventListener();
    }

    private static async getUpdatedFormHtml(element: HTMLElement): Promise<Document> {
        let form: HTMLFormElement = element.closest('form');

        return await Helper.updateForm(form);
    }

    private static refreshEventListener(): void {
        this.clearItems();
        this.updateItemsQuantity();
        this.removeItems();
    }
}