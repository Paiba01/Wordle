//import KEYBOARD_INITIAL_STATE from "../assets/keyboardState.json";
const KEYBOARD_INITIAL_STATE = [
    { "key": "q", "state": "unused" },
    { "key": "w", "state": "unused" },
    { "key": "e", "state": "unused" },
    { "key": "r", "state": "unused" },
    { "key": "t", "state": "unused" },
    { "key": "y", "state": "unused" },
    { "key": "u", "state": "unused" },
    { "key": "i", "state": "unused" },
    { "key": "o", "state": "unused" },
    { "key": "p", "state": "unused" },
    { "key": "a", "state": "unused" },
    { "key": "s", "state": "unused" },
    { "key": "d", "state": "unused" },
    { "key": "f", "state": "unused" },
    { "key": "g", "state": "unused" },
    { "key": "h", "state": "unused" },
    { "key": "j", "state": "unused" },
    { "key": "k", "state": "unused" },
    { "key": "l", "state": "unused" },
    { "key": "ñ", "state": "unused" },
    { "key": "NEXT", "state": "special" },
    { "key": "z", "state": "unused" },
    { "key": "x", "state": "unused" },
    { "key": "c", "state": "unused" },
    { "key": "v", "state": "unused" },
    { "key": "b", "state": "unused" },
    { "key": "n", "state": "unused" },
    { "key": "m", "state": "unused" },
    { "key": "BACK", "state": "special" }
  ];


class WordleKeyboard extends HTMLElement {
  constructor() {
    super();
    this.attachShadow({ mode: "open" });
    this.letters = KEYBOARD_INITIAL_STATE;
  }

  static get styles() {
    return /* css */`
      :host {
      }
      .container {
        display: flex;
        justify-content: center;
        align-items: flex-start;
        flex-wrap: wrap;
        gap: 8px 4px;
        width: 450px;
        margin: 1em 0;
      }
      .letter {
        background: #777;
        color: #fff;
        font-family: Arial;
        font-weight: bold;
        padding: 20px 14px;
        border-radius: 4px;
        width: 12px;
        text-transform: uppercase;
        display: flex;
        justify-content: center;
        align-items: center;
        cursor: pointer;
        user-select: none;
      }
      .letter.special {
        width: 32px;
      }
      .letter.used {
        background: var(--used-color);
        color: #fff;
      }
      .letter.exist {
        background: var(--exist-color);
        color: #fff;
      }
      .letter.exact {
        background: var(--exact-color);
        color: #fff;
      }
    `;
  }

  setLetter(key, state) {
    const letter = this.letters.find(letter => letter.key === key);
    if (letter.state !== "exact") {
      letter.state = state;
    }
    this.render();
  }

  listeners() { //escuchamos a los elementos
    const keys = Array.from(this.shadowRoot.querySelectorAll(".letter"));
    keys.forEach(key => {
      key.addEventListener("click", () => {
        const detail = key.textContent.replace("NEXT", "enter").replace("BACK", "backspace");
        const options = { detail, bubbles: true, composed: true };
        const event = new CustomEvent("keyboard", options);
        this.dispatchEvent(event);
      });
    });
  }

  connectedCallback() {
    this.render();
  }

  render() {
    this.shadowRoot.innerHTML = /* html */`
    <style>${WordleKeyboard.styles}</style>
    <div class="container">
      ${this.letters.map(letter => `<div class="letter ${letter.state}">${letter.key}</div>`).join("")}
    </div>`;
    this.listeners();
  }
}

customElements.define("wordle-keyboard", WordleKeyboard);