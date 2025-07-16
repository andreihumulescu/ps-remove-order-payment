function getOrderReference() {
  return document?.querySelector('strong[data-role="order-reference"]')
    ?.textContent;
}

export { getOrderReference };
