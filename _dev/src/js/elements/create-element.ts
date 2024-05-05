import { Props } from "../types/create-element";

function createElement(elementType: string, props?: Props) {
    const el = document.createElement(elementType);
    const { className, text, innerHtml, attributes } = props;
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
        attributes.forEach(attr => {
            const name = Object.keys(attr)[0];
            const value = Object.values(attr)[0];
            el.setAttribute(name, value);
        });
    }


    return el;
}

export default createElement;