document.addEventListener("DOMContentLoaded", function () {
  // Attach blur event listeners to input fields for on-demand validation
  const firstName = document.getElementById("firstName");
  const lastName = document.getElementById("lastName");
  const dateOfBirth = document.getElementById("dateOfBirth");
  const phoneNumber = document.getElementById("phoneNumber");
  const email = document.getElementById("email");

  firstName.addEventListener("blur", function () {
    validateField(firstName, "First Name is required", value => value.trim() !== "");
  });

  lastName.addEventListener("blur", function () {
    validateField(lastName, "Last Name is required", value => value.trim() !== "");
  });

  dateOfBirth.addEventListener("blur", function () {
    validateField(dateOfBirth, "Date of Birth is required", value => value.trim() !== "");
  });

  phoneNumber.addEventListener("blur", function () {
    const phonePattern = /^[0-9]{10,15}$/;
    validateField(
      phoneNumber,
      "Please enter a valid phone number (10-15 digits)",
      value => phonePattern.test(value.trim())
    );
  });

  email.addEventListener("blur", function () {
    const emailPattern = /^[^ ]+@[^ ]+\.[a-z]{2,3}$/;
    validateField(
      email,
      "Please enter a valid email address",
      value => value.trim() === "" || emailPattern.test(value.trim())
    );
  });
});

// Helper function to validate individual fields
function validateField(inputElement, errorMessage, validationFn) {
  // Remove previous error message
  const errorMessages = inputElement.parentElement.querySelectorAll(".error-message");
  errorMessages.forEach(msg => msg.remove());

  // Validate the input field
  if (!validationFn(inputElement.value)) {
    displayError(inputElement, errorMessage);
  }
}

// Function to display error messages
function displayError(inputElement, message) {
  const error = document.createElement("div");
  error.className = "error-message text-danger";
  error.innerText = message;
  inputElement.parentElement.appendChild(error);
}
