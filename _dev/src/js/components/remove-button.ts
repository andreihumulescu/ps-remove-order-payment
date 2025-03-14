import createElement from "../elements/create-element";
import { getPaymentTable } from "./payment-table";
import { addListeners } from "../listeners/remove-button";

function displayRemovePaymentButtons() {
  if (getPaymentTable().length === 0) {
    return;
  }

  getPaymentTable().forEach((row) => {
    const removeButton = createElement("button", {
      className: "btn btn-sm btn-outline-secondary btn-remove-payment",
      text: "Remove",
    });
    row.append(removeButton);
  });

  addListeners();
}

function getRemovePaymentButtons() {
  return document.querySelectorAll(".btn-remove-payment");
}

export { displayRemovePaymentButtons, getRemovePaymentButtons };
