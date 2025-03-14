/******/ (() => { // webpackBootstrap
/******/ 	"use strict";
/******/ 	var __webpack_modules__ = ({

/***/ 452:
/***/ ((__unused_webpack_module, exports) => {


Object.defineProperty(exports, "__esModule", ({ value: true }));
exports.getPaymentTableData = exports.getPaymentTable = void 0;
function getPaymentTable() {
    return document.querySelectorAll('table[data-role="payments-grid-table"] .text-right');
}
exports.getPaymentTable = getPaymentTable;
function getPaymentTableData(buttonParent) {
    var _a, _b, _c;
    var date = (_a = buttonParent.querySelector('td[data-role="date-column"')) === null || _a === void 0 ? void 0 : _a.textContent;
    var transactionId = (_b = buttonParent.querySelector('td[data-role="transaction-id-column"')) === null || _b === void 0 ? void 0 : _b.textContent;
    var amount = (_c = buttonParent.querySelector('td[data-role="amount-column"')) === null || _c === void 0 ? void 0 : _c.textContent;
    return {
        date_add: date,
        transaction_id: transactionId,
        amount: Number.parseFloat(amount === null || amount === void 0 ? void 0 : amount.replace(/[^\d\.]*/g, '')),
    };
}
exports.getPaymentTableData = getPaymentTableData;


/***/ }),

/***/ 8:
/***/ (function(__unused_webpack_module, exports, __webpack_require__) {


var __assign = (this && this.__assign) || function () {
    __assign = Object.assign || function(t) {
        for (var s, i = 1, n = arguments.length; i < n; i++) {
            s = arguments[i];
            for (var p in s) if (Object.prototype.hasOwnProperty.call(s, p))
                t[p] = s[p];
        }
        return t;
    };
    return __assign.apply(this, arguments);
};
var __awaiter = (this && this.__awaiter) || function (thisArg, _arguments, P, generator) {
    function adopt(value) { return value instanceof P ? value : new P(function (resolve) { resolve(value); }); }
    return new (P || (P = Promise))(function (resolve, reject) {
        function fulfilled(value) { try { step(generator.next(value)); } catch (e) { reject(e); } }
        function rejected(value) { try { step(generator["throw"](value)); } catch (e) { reject(e); } }
        function step(result) { result.done ? resolve(result.value) : adopt(result.value).then(fulfilled, rejected); }
        step((generator = generator.apply(thisArg, _arguments || [])).next());
    });
};
var __generator = (this && this.__generator) || function (thisArg, body) {
    var _ = { label: 0, sent: function() { if (t[0] & 1) throw t[1]; return t[1]; }, trys: [], ops: [] }, f, y, t, g;
    return g = { next: verb(0), "throw": verb(1), "return": verb(2) }, typeof Symbol === "function" && (g[Symbol.iterator] = function() { return this; }), g;
    function verb(n) { return function (v) { return step([n, v]); }; }
    function step(op) {
        if (f) throw new TypeError("Generator is already executing.");
        while (g && (g = 0, op[0] && (_ = 0)), _) try {
            if (f = 1, y && (t = op[0] & 2 ? y["return"] : op[0] ? y["throw"] || ((t = y["return"]) && t.call(y), 0) : y.next) && !(t = t.call(y, op[1])).done) return t;
            if (y = 0, t) op = [op[0] & 2, t.value];
            switch (op[0]) {
                case 0: case 1: t = op; break;
                case 4: _.label++; return { value: op[1], done: false };
                case 5: _.label++; y = op[1]; op = [0]; continue;
                case 7: op = _.ops.pop(); _.trys.pop(); continue;
                default:
                    if (!(t = _.trys, t = t.length > 0 && t[t.length - 1]) && (op[0] === 6 || op[0] === 2)) { _ = 0; continue; }
                    if (op[0] === 3 && (!t || (op[1] > t[0] && op[1] < t[3]))) { _.label = op[1]; break; }
                    if (op[0] === 6 && _.label < t[1]) { _.label = t[1]; t = op; break; }
                    if (t && _.label < t[2]) { _.label = t[2]; _.ops.push(op); break; }
                    if (t[2]) _.ops.pop();
                    _.trys.pop(); continue;
            }
            op = body.call(thisArg, _);
        } catch (e) { op = [6, e]; y = 0; } finally { f = t = 0; }
        if (op[0] & 5) throw op[1]; return { value: op[0] ? op[1] : void 0, done: true };
    }
};
var __importDefault = (this && this.__importDefault) || function (mod) {
    return (mod && mod.__esModule) ? mod : { "default": mod };
};
Object.defineProperty(exports, "__esModule", ({ value: true }));
exports.displayRemovePaymentButtons = void 0;
var create_element_1 = __importDefault(__webpack_require__(745));
var payment_table_1 = __webpack_require__(452);
var payment_table_2 = __webpack_require__(452);
var utils_1 = __webpack_require__(834);
function displayRemovePaymentButtons() {
    if ((0, payment_table_1.getPaymentTable)().length === 0) {
        return;
    }
    (0, payment_table_1.getPaymentTable)().forEach(function (row) {
        var removeButton = (0, create_element_1.default)('button', {
            className: 'btn btn-sm btn-outline-secondary btn-remove-payment',
            text: 'Remove',
        });
        removeButton.addEventListener('click', function () {
            return __awaiter(this, void 0, void 0, function () {
                var response, result;
                return __generator(this, function (_a) {
                    switch (_a.label) {
                        case 0:
                            if (!confirm(window.removeorderpayment.removePaymentText)) return [3 /*break*/, 3];
                            return [4 /*yield*/, fetch(window.removeorderpayment.removePaymentController, {
                                    method: 'DELETE',
                                    body: JSON.stringify(__assign({ order_reference: (0, utils_1.getOrderReference)() }, (0, payment_table_2.getPaymentTableData)(this.parentElement.parentElement))),
                                })];
                        case 1:
                            response = _a.sent();
                            return [4 /*yield*/, response.json()];
                        case 2:
                            result = _a.sent();
                            window.alert(result.message);
                            if (result.success) {
                                window.location.reload();
                            }
                            _a.label = 3;
                        case 3: return [2 /*return*/];
                    }
                });
            });
        });
        row.append(removeButton);
    });
}
exports.displayRemovePaymentButtons = displayRemovePaymentButtons;


/***/ }),

/***/ 834:
/***/ ((__unused_webpack_module, exports) => {


Object.defineProperty(exports, "__esModule", ({ value: true }));
exports.getOrderReference = void 0;
function getOrderReference() {
    return document.querySelector('strong[data-role="order-reference"]')
        .textContent;
}
exports.getOrderReference = getOrderReference;


/***/ }),

/***/ 745:
/***/ ((__unused_webpack_module, exports) => {


Object.defineProperty(exports, "__esModule", ({ value: true }));
function createElement(elementType, props) {
    var el = document.createElement(elementType);
    var className = props.className, text = props.text, innerHtml = props.innerHtml, attributes = props.attributes;
    if (className) {
        el.className = className;
    }
    if (text) {
        el.textContent = text;
    }
    if (innerHtml) {
        el.innerHTML = innerHtml;
    }
    if (attributes) {
        attributes.forEach(function (attr) {
            var name = Object.keys(attr)[0];
            var value = Object.values(attr)[0];
            el.setAttribute(name, value);
        });
    }
    return el;
}
exports["default"] = createElement;


/***/ })

/******/ 	});
/************************************************************************/
/******/ 	// The module cache
/******/ 	var __webpack_module_cache__ = {};
/******/ 	
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/ 		// Check if module is in cache
/******/ 		var cachedModule = __webpack_module_cache__[moduleId];
/******/ 		if (cachedModule !== undefined) {
/******/ 			return cachedModule.exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = __webpack_module_cache__[moduleId] = {
/******/ 			// no module.id needed
/******/ 			// no module.loaded needed
/******/ 			exports: {}
/******/ 		};
/******/ 	
/******/ 		// Execute the module function
/******/ 		__webpack_modules__[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/ 	
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/ 	
/************************************************************************/
var __webpack_exports__ = {};
// This entry needs to be wrapped in an IIFE because it needs to be isolated against other entry modules.
(() => {
var exports = {};
var __webpack_unused_export__;

__webpack_unused_export__ = ({ value: true });
var remove_button_1 = __webpack_require__(8);
(function ready(fn) {
    if (document.readyState !== "loading") {
        fn();
    }
    else {
        document.addEventListener("DOMContentLoaded", fn);
    }
})(init);
function init() {
    (0, remove_button_1.displayRemovePaymentButtons)();
}

})();

// This entry needs to be wrapped in an IIFE because it needs to be isolated against other entry modules.
(() => {
// extracted by mini-css-extract-plugin

})();

/******/ })()
;