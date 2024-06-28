# Security Assigment 1
## pages that can be only accessed by authenticated users
- dashboard or ./
## pages that can be only accessed by guests
- login or ./login
- register or ./register 
# Testing

Testing Plan 

 

User Stories to be Tested 

User Story 1: User Registration 

Paths: 

    Happy Path: A new user successfully registers with valid data. 

    Unhappy Path: A user attempts to register with an invalid email format. 

    Unhappy Path: A user attempts to register with mismatched passwords. 

    Unhappy Path: A user attempts to register with not strong enough passwords. 

 

System Tests: 

    Scenario 1: A new user successfully registers with valid data. 

    Scenario 2: Registration fails when the email format is invalid. 

    Scenario 3: Registration fails when the password and password confirmation do not match. 

    Scenario 4: Registration fails when the password doesn’t follow the strength requirements 

Unit Tests: 

    Functionality: Validate that the registration form captures the correct data and sends it to the backend. 

    Functionality: Ensure backend validation for valid email format, matching passwords and passwords strength 

User Story 2: User Login 

Paths: 

    Happy Path: A registered user successfully logs in with valid credentials. 

    Unhappy Path: A user attempts to log in with an incorrect password. 

    Unhappy Path: A user attempts to log in with a non-existent email. 

System Tests: 

    Scenario 1: A registered user successfully logs in with valid credentials. 

    Scenario 2: Login fails with an incorrect password. 

    Scenario 3: Login fails with a non-existent email. 

Unit Tests: 

    Functionality: Validate that the login form captures the correct data and sends it to the backend. 

    Functionality: Ensure backend authentication logic for valid credentials. 

Evaluation 

4.1 Describe a possible mistake/error that can be detected by your test(s) 

 
	the tests can show any errors in the validation of the data during registration as well as proper enforcement of those. Those tests should also help prevent mistakes when extending user’s functionality by ensuring that regardless of changes the basic functionality of registration and logining in works. 

4.2 Describe a possible mistake/error that cannot be detected by your test(s) 

 
	the tests cannot detect performance issues such as long login process . They also don’t test if the errors that user should get are visible nor they can detect whether the user receives all the instructions correctly. Those limitations comes mostly from the fact that the tests focus on functionality and validation and not performance or UE 

 
4.3 To what extent can you conclude that "everything works correctly"? Provide arguments! 

 
These tests provide a strong indication that the core functionalities of user registration and login work correctly under specified conditions. They verify that: 

    Valid data results in successful registration and login. 

    Invalid data triggers appropriate validation errors and prevents registration or login. 

Unfortunately the range they cover is rather basic. Areas not covered include: 

    Performance and scalability testing. 

    Security testing beyond basic validation. 

    Integration testing with other parts of the application. 

    Usability and accessibility testing. 

Thus, while thanks to those tests we can assess that the core functionality works on its own the lacking of bigger insight means that they are not sufficient to conclude “everything works correctly” outside of very basic conditions. 
 
Extra tests can could be done and I think would also be important would be testing views whether the error message is actually visible on the site. 

 

 

 

 

 

 