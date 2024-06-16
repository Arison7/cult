interface ITest {
    fn: Function;
    errorMessage: string;
}

class Field {
    private tests: ITest[] = [];
    public passed = false;

    constructor(
        public input: HTMLInputElement,
        public img: HTMLImageElement,
        public error: HTMLDivElement
    ) {
        this.input.addEventListener("focusout", this.focusOut.bind(this));
    }
    public testPassing() {
        for (const test of this.tests) {
            if (!test.fn(this.input.value)) {
                this.passed = false;
                return;
            }
        }
        this.passed = true;
    }
    public focusOut() {
        this.error.textContent = "";
        this.runTests().then(passed => {
            if (passed) {
                this.passed = true;
                this.input.classList.add("border-green-600");
                this.input.classList.remove("border-red-600");
                this.img.src = "/images/ok.png";
            } else {
                this.passed = false;
                this.img.src = "/images/error.png";
                this.input.classList.add("border-red-600");
                this.input.classList.remove("border-green-600");
            }
        });
    }
    private async runTests(): Promise<boolean> {
        for (const test of this.tests) {
            try {
                const result = await test.fn(this.input.value); // Await the result of the async function

                if (!result) { // Check if the result is false
                    this.img.src = "/images/error.png";
                    this.input.classList.add("border-red-600");
                    this.input.classList.remove("border-green-600");
                    this.error.textContent = test.errorMessage;
                    return false;
                }
            } catch (error) {
                this.img.src = "/images/error.png";
                this.input.classList.add("border-red-600");
                this.input.classList.remove("border-green-600");
                this.error.textContent = "An error occurred while validating.";
                return false;
            }
        }
        return true;
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
    public addTest(test: ITest) {
        this.tests.push(test);
    }
}

window.onload = function () {
    const inputsNames: string[] = ["Name", "Email", "Pass", "PassRep"];
    const fields: Map<string, Field> = new Map();
    inputsNames.map((input) => {
        const inputElement = document.getElementById(
            "in" + input
        ) as HTMLInputElement;
        const imgElement = document.getElementById(
            "in" + input + "Img"
        ) as HTMLImageElement;
        const errorElement = document.getElementById(
            input + "Err"
        ) as HTMLDivElement;
        fields.set(input, new Field(inputElement, imgElement, errorElement));
    });

    const button = document.getElementById(
        "registerSubmit"
    ) as HTMLButtonElement;
    const form = document.getElementById("registerForm") as HTMLFormElement;
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

				continue
			}
		}
		if (allPassed) {
			button.classList.add("hover:bg-red-600");
		}else{
			event.preventDefault();
		}

	})
    const required: ITest = {
        fn: (value: string) => value !== "",
        errorMessage: "This field is required.*",
    };
    const uniqueNmae: ITest = {
        fn: async (value: string) => {
                try {
                    // Fetch the confirmation from the backend
                    const response = await fetch("/register/uniqueName?name=" + value);
                    const data = await response.json();

                    // Assuming the data returned is an array where the first element is a boolean
                    let output: [boolean] = data;
                    console.log(output[0]);
                    return output[0];  // Return the boolean value
                } catch (error) {
                    console.error('Error fetching data:', error);
                    return false;  // Or handle error appropriately
                }
            },
        errorMessage: "This Cultname is already taken.",
    };
    const unSupportedEmailCharacters: ITest = {
        fn: (value: string) => !value.match(/[^a-zA-Z0-9@!#$%&'*+-/=?^_`{|}~]/),
        errorMessage:
            "An email supports only the following chracters: upper/lower case letters(a-z, A-Z), numbers(0-9) and the following special characters: @!#$%&'*+-/=?^_`{|}~]/",
    };
    const atSignPresent: ITest = {
        fn: (value: string) => value.match(/@/g) !== null,
        errorMessage: "An email must contain an @ sign.",
    };
    const moreThanOneAtSign: ITest = {
        fn: (value: string) => value.match(/@/g)?.length === 1,
        errorMessage: "An email must contain only one @ sign.",
    };
    // Ensure the local part is valid
    const validLocalPart: ITest = {
        fn: (value: string) => {
            const localPart = value.split('@')[0];
            return localPart.length > 0;
        },
        errorMessage:
            "The local part has to be present (the part before the @ sign)",
    };

    //add test to check if the email has adress
	const hasDomain: ITest = {
		//check if there are at least two characters between the @ and the last dot
		fn: (value: string) => value.match(/@[a-zA-Z]{2,}\./),
		errorMessage:
			"An email must have a valid domain of at least two characters (the part after the @ sign and before the last dot).",
	}
    const hasDomainExtension: ITest = {
        fn: (value: string) => value.match(/\.[a-zA-Z]{2,}/),
        errorMessage:
            "An email must have a valid domain extension (e.g., .com, .org, .net).",
    };
    const passwordTooShort: ITest = {
        fn: (value: string) => value.length >= 8,
        errorMessage: "A password must be at least 8 characters long.",
    };

    const passwordHasUppercase: ITest = {
        fn: (value: string) => value.match(/[A-Z]/) !== null,
        errorMessage: "A password must contain at least one uppercase letter.",
    };

    const passwordHasNumber: ITest = {
        fn: (value: string) => value.match(/[0-9]/) !== null,
        errorMessage: "A password must contain at least one number.",
    };

    const passwordHasSymbol: ITest = {
        fn: (value: string) => value.match(/[!@#$%^&*]/) !== null,
        errorMessage:
            "A password must contain at least one of the following symbols: !@#$%^&*",
    };
	const passwordMatch: ITest = {
		fn: (value: string) => value === fields.get("Pass")?.input.value,
		errorMessage:
			"The passwords do not match.",
	};

    fields.forEach((field) => {
        field.addTest(required);
    });
    //name tests
    fields.get("Name")?.addTest(uniqueNmae);
    //email tests
    fields.get("Email")?.addTest(unSupportedEmailCharacters);
    fields.get("Email")?.addTest(atSignPresent);
    fields.get("Email")?.addTest(moreThanOneAtSign);
    fields.get("Email")?.addTest(validLocalPart);
	fields.get("Email")?.addTest(hasDomain);
    fields.get("Email")?.addTest(hasDomainExtension);

	//password tests
	fields.get("Pass")?.addTest(passwordTooShort);
	fields.get("Pass")?.addTest(passwordHasUppercase);
	fields.get("Pass")?.addTest(passwordHasNumber);
	fields.get("Pass")?.addTest(passwordHasSymbol);
	//password repeat tests
	fields.get("PassRep")?.addTest(passwordMatch);

};
