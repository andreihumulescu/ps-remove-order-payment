export {};

type RemoveOrderPayment = {
  removePaymentController: string;
  removePaymentText: string;
};

declare global {
  interface Window {
    removeorderpayment: RemoveOrderPayment;
  }
}
