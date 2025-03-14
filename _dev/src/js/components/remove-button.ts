import createElement from '../elements/create-element';
import { getPaymentTable } from './payment-table';
import { getPaymentTableData } from '../components/payment-table';
import { getOrderReference } from '../components/utils';

function displayRemovePaymentButtons() {
  if (getPaymentTable().length === 0) {
    return;
  }

  getPaymentTable().forEach((row) => {
    const removeButton = createElement('button', {
      className: 'btn btn-sm btn-outline-secondary btn-remove-payment',
      text: 'Remove',
    });

    removeButton.addEventListener('click', async function () {
      if (confirm(window.removeorderpayment.removePaymentText)) {
        const response = await fetch(
          window.removeorderpayment.removePaymentController,
          {
            method: 'DELETE',
            body: JSON.stringify({
              order_reference: getOrderReference(),
              ...getPaymentTableData(this.parentElement.parentElement),
            }),
          },
        );
        const result = await response.json();
        window.alert(result.message);

        if (result.success) {
          window.location.reload();
        }
      }
    });

    row.append(removeButton);
  });
}

export { displayRemovePaymentButtons };
