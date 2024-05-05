import { getRemovePaymentButtons } from "../components/remove-button";
import { getPaymentTableData } from "../components/payment-table";
import { getOrderReference } from "../components/utils";

function addListeners() {
    getRemovePaymentButtons().forEach((button) => {
        button.addEventListener('click', async function() {
            if (confirm(window.removeorderpayment.removePaymentText)) {
                const response = await fetch(window.removeorderpayment.removePaymentController, {
                    method: 'DELETE',
                    body: JSON.stringify(
                        {
                            order_reference: getOrderReference(),
                            ...getPaymentTableData(this.parentElement.parentElement),
                        }
                    )
                });
                const result = await response.json();
                window.alert(result.message);

                if (result.success) {
                    window.location.reload();
                }
            }
        });
    });
}

export {
    addListeners,
}