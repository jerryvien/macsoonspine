function validateForm() {
    let isValid = true;
  
    // Clear all previous error messages
    const errorMessages = document.querySelectorAll(".error-message");
    errorMessages.forEach(msg => msg.remove());
  
    // First Name Validation
    const firstName = document.getElementById("firstName");
    if (firstName.value.trim() === "") {
      displayError(firstName, "First Name is required");
      isValid = false;
    }
  
    // Last Name Validation
    const lastName = document.getElementById("lastName");
    if (lastName.value.trim() === "") {
      displayError(lastName, "Last Name is required");
      isValid = false;
    }
  
    // Date of Birth Validation
    const dateOfBirth = document.getElementById("dateOfBirth");
    if (dateOfBirth.value.trim() === "") {
      displayError(dateOfBirth, "Date of Birth is required");
      isValid = false;
    }
  
    // Phone Number Validation
    const phoneNumber = document.getElementById("phoneNumber");
    const phonePattern = /^[0-9]{10,15}$/; // Example pattern for phone numbers
    if (!phonePattern.test(phoneNumber.value.trim())) {
      displayError(phoneNumber, "Please enter a valid phone number (10-15 digits)");
      isValid = false;
    }
  
    // Email Validation
    const email = document.getElementById("email");
    const emailPattern = /^[^ ]+@[^ ]+\.[a-z]{2,3}$/;
    if (email.value.trim() !== "" && !emailPattern.test(email.value.trim())) {
      displayError(email, "Please enter a valid email address");
      isValid = false;
    }
  
    return isValid;
  }
  
  // Function to display error messages
  function displayError(inputElement, message) {
    const error = document.createElement("div");
    error.className = "error-message text-danger";
    error.innerText = message;
    inputElement.parentElement.appendChild(error);
  }
  