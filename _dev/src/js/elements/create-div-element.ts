import createElement from "./create-element";
import { Props } from "../types/create-element";

function createDivElement(props?: Props) {
    return createElement('div', props);
}

export default createDivElement;