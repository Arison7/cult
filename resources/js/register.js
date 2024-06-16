"use strict";
var __awaiter = (this && this.__awaiter) || function (thisArg, _arguments, P, generator) {
    function adopt(value) { return value instanceof P ? value : new P(function (resolve) { resolve(value); }); }
    return new (P || (P = Promise))(function (resolve, reject) {
        function fulfilled(value) { try { step(generator.next(value)); } catch (e) { reject(e); } }
        function rejected(value) { try { step(generator["throw"](value)); } catch (e) { reject(e); } }
        function step(result) { result.done ? resolve(result.value) : adopt(result.value).then(fulfilled, rejected); }
        step((generator = generator.apply(thisArg, _arguments || [])).next());
    });
};
class Field {
    constructor(input, img, error) {
        this.input = input;
        this.img = img;
        this.error = error;
        this.tests = [];
        this.passed = false;
        this.input.addEventListener("focusout", this.focusOut.bind(this));
    }
    testPassing() {
        for (const test of this.tests) {
            if (!test.fn(this.input.value)) {
                this.passed = false;
                return;
            }
        }
        this.passed = true;
    }
    focusOut() {
        this.error.textContent = "";
        this.runTests().then(passed => {
            if (passed) {
                this.passed = true;
                this.input.classList.add("border-green-600");
                this.input.classList.remove("border-red-600");
                this.img.src = "/images/ok.png";
            }
            else {
                this.passed = false;
                this.img.src = "/images/error.png";
                this.input.classList.add("border-red-600");
                this.input.classList.remove("border-green-600");
            }
        });
    }
    runTests() {
        return __awaiter(this, void 0, void 0, function* () {
            for (const test of this.tests) {
                try {
                    const result = yield test.fn(this.input.value); // Await the result of the async function
                    if (!result) { // Check if the result is false
                        this.img.src = "/images/error.png";
                        this.input.classList.add("border-red-600");
                        this.input.classList.remove("border-green-600");
                        this.error.textContent = test.errorMessage;
                        return false;
                    }
                }
                catch (error) {
                    this.img.src = "/images/error.png";
                    this.input.classList.add("border-red-600");
                    this.input.classList.remove("border-green-600");
                    this.error.textContent = "An error occurred while validating.";
                    return false;
                }
            }
            return true;
        });
    }
    /*
    public focusOut() {
        this.error.textContent = "";
        for (const test of this.tests) {
            console.log(test.fn(this.input.value));

            if (!test.fn(this.input.value)) {
                this.img.src = "/images/error.png";
                this.input.classList.add("border-red-600");
                this.input.classList.remove("border-green-600");
                this.passed = false;
                this.error.textContent = test.errorMessage;
                return;
            }
        }
        this.passed = true;
        this.input.classList.add("border-green-600");
        this.input.classList.remove("border-red-600");
        this.img.src = "/images/ok.png";
    }
    */
    addTest(test) {
        this.tests.push(test);
    }
}
window.onload = function () {
    var _a, _b, _c, _d, _e, _f, _g, _h, _j, _k, _l, _m;
    const inputsNames = ["Name", "Email", "Pass", "PassRep"];
    const fields = new Map();
    inputsNames.map((input) => {
        const inputElement = document.getElementById("in" + input);
        const imgElement = document.getElementById("in" + input + "Img");
        const errorElement = document.getElementById(input + "Err");
        fields.set(input, new Field(inputElement, imgElement, errorElement));
    });
    const button = document.getElementById("registerSubmit");
    const form = document.getElementById("registerForm");
    form.addEventListener("change", () => {
        for (const [key, value] of fields) {
            //run all the tests again
            value.testPassing();
            if (!value.passed) {
                //grey out the button and prevent hover	
                button.disabled = true;
                button.classList.remove("hover:bg-red-600");
                return;
            }
        }
        button.classList.add("hover:bg-red-600");
        button.disabled = false;
    });
    form.addEventListener("submit", (event) => {
        console.log("submit");
        let allPassed = true;
        //rerun the tests and prevent the form from submitting if any of the tests fail
        for (const [key, value] of fields) {
            //run all the tests again
            value.focusOut();
            console.log(key, value.passed);
            if (!value.passed) {
                //grey out the button and prevent hover	
                button.disabled = true;
                allPassed = false;
                button.classList.remove("hover:bg-red-600");
                continue;
            }
        }
        if (allPassed) {
            button.classList.add("hover:bg-red-600");
        }
        else {
            event.preventDefault();
        }
    });
    const required = {
        fn: (value) => value !== "",
        errorMessage: "This field is required.*",
    };
    const uniqueNmae = {
        fn: (value) => __awaiter(this, void 0, void 0, function* () {
            try {
                // Fetch the confirmation from the backend
                const response = yield fetch("/register/uniqueName?name=" + value);
                const data = yield response.json();
                // Assuming the data returned is an array where the first element is a boolean
                let output = data;
                console.log(output[0]);
                return output[0]; // Return the boolean value
            }
            catch (error) {
                console.error('Error fetching data:', error);
                return false; // Or handle error appropriately
            }
        }),
        errorMessage: "This Cultname is already taken.",
    };
    const unSupportedEmailCharacters = {
        fn: (value) => !value.match(/[^a-zA-Z0-9@!#$%&'*+-/=?^_`{|}~]/),
        errorMessage: "An email supports only the following chracters: upper/lower case letters(a-z, A-Z), numbers(0-9) and the following special characters: @!#$%&'*+-/=?^_`{|}~]/",
    };
    const atSignPresent = {
        fn: (value) => value.match(/@/g) !== null,
        errorMessage: "An email must contain an @ sign.",
    };
    const moreThanOneAtSign = {
        fn: (value) => { var _a; return ((_a = value.match(/@/g)) === null || _a === void 0 ? void 0 : _a.length) === 1; },
        errorMessage: "An email must contain only one @ sign.",
    };
    // Ensure the local part is valid
    const validLocalPart = {
        fn: (value) => {
            const localPart = value.split('@')[0];
            return localPart.length > 0;
        },
        errorMessage: "The local part has to be present (the part before the @ sign)",
    };
    //add test to check if the email has adress
    const hasDomain = {
        //check if there are at least two characters between the @ and the last dot
        fn: (value) => value.match(/@[a-zA-Z]{2,}\./),
        errorMessage: "An email must have a valid domain of at least two characters (the part after the @ sign and before the last dot).",
    };
    const hasDomainExtension = {
        fn: (value) => value.match(/\.[a-zA-Z]{2,}/),
        errorMessage: "An email must have a valid domain extension (e.g., .com, .org, .net).",
    };
    const passwordTooShort = {
        fn: (value) => value.length >= 8,
        errorMessage: "A password must be at least 8 characters long.",
    };
    const passwordHasUppercase = {
        fn: (value) => value.match(/[A-Z]/) !== null,
        errorMessage: "A password must contain at least one uppercase letter.",
    };
    const passwordHasNumber = {
        fn: (value) => value.match(/[0-9]/) !== null,
        errorMessage: "A password must contain at least one number.",
    };
    const passwordHasSymbol = {
        fn: (value) => value.match(/[!@#$%^&*]/) !== null,
        errorMessage: "A password must contain at least one of the following symbols: !@#$%^&*",
    };
    const passwordMatch = {
        fn: (value) => { var _a; return value === ((_a = fields.get("Pass")) === null || _a === void 0 ? void 0 : _a.input.value); },
        errorMessage: "The passwords do not match.",
    };
    fields.forEach((field) => {
        field.addTest(required);
    });
    //name tests
    (_a = fields.get("Name")) === null || _a === void 0 ? void 0 : _a.addTest(uniqueNmae);
    //email tests
    (_b = fields.get("Email")) === null || _b === void 0 ? void 0 : _b.addTest(unSupportedEmailCharacters);
    (_c = fields.get("Email")) === null || _c === void 0 ? void 0 : _c.addTest(atSignPresent);
    (_d = fields.get("Email")) === null || _d === void 0 ? void 0 : _d.addTest(moreThanOneAtSign);
    (_e = fields.get("Email")) === null || _e === void 0 ? void 0 : _e.addTest(validLocalPart);
    (_f = fields.get("Email")) === null || _f === void 0 ? void 0 : _f.addTest(hasDomain);
    (_g = fields.get("Email")) === null || _g === void 0 ? void 0 : _g.addTest(hasDomainExtension);
    //password tests
    (_h = fields.get("Pass")) === null || _h === void 0 ? void 0 : _h.addTest(passwordTooShort);
    (_j = fields.get("Pass")) === null || _j === void 0 ? void 0 : _j.addTest(passwordHasUppercase);
    (_k = fields.get("Pass")) === null || _k === void 0 ? void 0 : _k.addTest(passwordHasNumber);
    (_l = fields.get("Pass")) === null || _l === void 0 ? void 0 : _l.addTest(passwordHasSymbol);
    //password repeat tests
    (_m = fields.get("PassRep")) === null || _m === void 0 ? void 0 : _m.addTest(passwordMatch);
};
