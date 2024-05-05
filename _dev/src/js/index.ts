import { displayRemovePaymentButtons } from "./components/remove-button";

(function ready(fn) {
    if (document.readyState !== 'loading') {
      fn();
    } else {
      document.addEventListener('DOMContentLoaded', fn);
    }
})(init)

function init() {
    displayRemovePaymentButtons();
}
