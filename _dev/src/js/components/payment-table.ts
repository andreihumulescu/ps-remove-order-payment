function getPaymentTable() {
  return document.querySelectorAll(
    'table[data-role="payments-grid-table"] .text-right'
  );
}

function getPaymentTableData(buttonParent) {
  const date = buttonParent.querySelector(
    'td[data-role="date-column"'
  )?.textContent;
  const transactionId = buttonParent.querySelector(
    'td[data-role="transaction-id-column"'
  )?.textContent;

  return {
    date_add: date,
    transaction_id: transactionId,
  };
}

export { getPaymentTable, getPaymentTableData };
