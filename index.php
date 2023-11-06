<!DOCTYPE html>
<html lang="en">
<head>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="styles.css">
</head>
<body>
<video autoplay loop muted id="background-video">
  <source src="stdomvid.mp4" type="video/mp4">
  Your browser does not support the video tag.
</video>

<div class="form-container">
<img class="logo" src="logo-header.png" alt="Logo">
  <button onclick="document.getElementById('id01').style.display='block'"><b>Get Queue</b></button>
</div>

<div id="id01" class="modal">
  <form class="modal-content animate" action="/action_page.php" method="post">
    <div class="imgcontainer">
      <span onclick="document.getElementById('id01').style.display='none'" class="close" title="Close Modal">&times;</span>
    </div>
    <div class="container">
      <br>
      <label for="customerType"><h4>Type of Customer:</h4></label>
      <select id="customerType" name="customerType" required>
        <option value="" disabled selected>Select Type of Customer</option>
        <option value="Regular">Regular Customer</option>
        <option value="Priority">Priority Customer</option>
      </select>
      <div id="priorityMessage" style="display: none; color: black;">
    <b class="priority-message"><i> (For PWD, Senior Citizens, and Pregnant Women)</i></b>
  </div>
      <br>
      <label for="chooseService"><h4>Choose Service:</h4></label>
      <select id="chooseService" name="chooseService" required>
        <option value="" disabled selected>Select Service</option>
        <option value="Payment">Payment</option>
        <option value="Claiming of Receipt">Claiming of Receipt</option>
      </select>
      <br>
      <label for="paymentFor"><h4>Payment For:</h4></label>
      <select id="paymentFor" name="paymentFor" required>
        <option value="" disabled selected>Select Payment For</option>
        <option value="Tuition">Tuition</option>
        <option value="Books and Uniforms">Books and Uniforms</option>
        <option value="Other School Activities and Fees">Other School Activities and Fees</option>
      </select>
      <br>
      <label for="modePayment"><h4>Mode of Payment:</h4></label>
      <select id="modePayment" name="modePayment" required>
        <option value="" disabled selected>Select Mode of Payment</option>
        <option value="Cash">Cash</option>
        <option value="Card/QR Scan">Card/QR Scan</option>
        <option value="Online Fund Transfer">Online Fund Transfer</option>
        <option value="Bank Deposit/Payment Center">Bank Deposit/Payment Center</option>
      </select>
      <br>
  
<label for="name"><h4>Customer Name:</h4></label>
    <input type="text" id="name" name="name" required oninput="validateName()">
    <span id="nameError" style="color: red;"></span>
    <label for="email"><h4>Email:</h4></label>
<input type="email" id="email" name="email" required oninput="validateEmail()">
<span id="emailError" style="color: red;"></span>
<p style="color: gray;">(Optional: Provide only when you want to be notified about your queue.)</p> <!-- Optional message -->

     
    </div>
    <div class="container" style="background-color:#f1f1f1">
      <button type="button" onclick="cancelTransaction()" class="cancelBtn" style="background-color: #B70404;">Back</button>
      <button type="button" onclick="showSelectedAttributes()" class="submitBtn" style="background-color: #54B435;">Submit</button>
    </div>
  </form>
</div>

<!-- New Modal -->
<div id="newModal" class="new-modal">
  <div class="new-modal-content">
    <span onclick="hideNewModal()" class="new-modal-close" title="Close Modal">&times;</span>
    <h3 class="new-modal-logo">Provided Details:</h3>
    <p><b>Type of Customer: </b><span id="selectedCustomerType"></span></p>
    <p><b>Choose Service: </b><span id="selectedChooseService"></span></p>
    <p><b>Payment For:</b> <span id="selectedPaymentFor"></span></p>
    <p><b>Mode of Payment: </b><span id="selectedModePayment"></span></p>
    <p><b>Customer Name: </b><span id="selectedCustomerName"></span></p>
    <p><b>Email: </b><span id="selectedEmail"></span></p>


    <!-- New button for processing the queue -->
    <button onclick="processQueue()" class="processBtn" style="background-color: #54B435;">Process Queue</button>
  </div>
</div>

<script>
var modal = document.getElementById('id01');
var newModal = document.getElementById('newModal');

function showPriorityMessage() {
  var priorityMessage = document.getElementById('priorityMessage');
  priorityMessage.style.display = 'block';
}

// Event listener for the "Type of Customer" dropdown
document.getElementById('customerType').addEventListener('change', function() {
  var selectedValue = this.value;

  if (selectedValue === 'Priority') {
    showPriorityMessage();
  } else {
    // Hide the message if a different option is selected
    document.getElementById('priorityMessage').style.display = 'none';
  }
});


function showSelectedAttributes() {
     // Ensure name and email are valid before proceeding
     if (!validateName() || !validateEmail()) {
        alert('Invalid Input.');
        return; // If name or email is invalid, do not proceed
    }

   
  // Get selected values from the form
  var customerType = document.getElementById('customerType').value;
  var chooseService = document.getElementById('chooseService').value;
  var paymentFor = document.getElementById('paymentFor').value;
  var modePayment = document.getElementById('modePayment').value;
  var customerName = document.getElementById('name').value;
  var email = document.getElementById('email').value;
  var displayedEmail = email !== '' ? email : 'Not provided';
  
  // Check if all required fields are selected
  if (customerType && chooseService && paymentFor && modePayment && customerName) {
    // Set values in the new modal
    document.getElementById('selectedCustomerType').innerText = customerType;
    document.getElementById('selectedChooseService').innerText = chooseService;
    document.getElementById('selectedPaymentFor').innerText = paymentFor;
    document.getElementById('selectedModePayment').innerText = modePayment;
    document.getElementById('selectedCustomerName').innerText = customerName;
    document.getElementById('selectedEmail').innerText = email;
    document.getElementById('selectedEmail').innerText = displayedEmail;

 
    // Display the new modal
    newModal.style.display = 'block';
  } else {
    // Display an error message or handle the case where not all required fields are selected
    alert('Please provide all the details needed.');
  }
}

function hideNewModal() {
  newModal.style.display = 'none';
}
function originalModal(){
    id01.style.display = "none";
}

function cancelTransaction() {
     // Reset all form fields to their default values
  document.getElementById('customerType').value = "";
  document.getElementById('chooseService').value = "";
  document.getElementById('paymentFor').value = "";
  document.getElementById('modePayment').value = "";
  document.getElementById('name').value = "";
  document.getElementById('email').value = "";


  // Hide the priority message if it was displayed
  document.getElementById('priorityMessage').style.display = 'none';
  // Close the modal
  originalModal();
}

function processQueue() {
  // Get selected values from the form
  var customerType = document.getElementById('selectedCustomerType').innerText;
  var chooseService = document.getElementById('selectedChooseService').innerText;
  var paymentFor = document.getElementById('selectedPaymentFor').innerText;
  var modePayment = document.getElementById('selectedModePayment').innerText;
  var customerName = document.getElementById('selectedCustomerName').innerText;

  
  // Make an AJAX request to insert values into the database
  var xhr = new XMLHttpRequest();
  xhr.open('POST', 'insert_into_database.php', true);
  xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

  xhr.onreadystatechange = function () {
    if (xhr.readyState === XMLHttpRequest.DONE) {
      if (xhr.status === 200) {
        var response = JSON.parse(xhr.responseText);

        if (response.success) {
          alert('Queue processed successfully. Queue Number: ' + response.queueNumber);
          // Additional logic, if needed
        } else {
          alert('Error processing queue: ' + response.error);
        }
      } else {
        alert('Error: ' + xhr.status);
      }
    }
  };

  // Send the data to the server
// Send the data to the server
var data = 'customerType=' + encodeURIComponent(customerType) +
  '&chooseService=' + encodeURIComponent(chooseService) +
  '&paymentFor=' + encodeURIComponent(paymentFor) +
  '&modePayment=' + encodeURIComponent(modePayment) +
  '&name=' + encodeURIComponent(customerName) +
  '&email=' + encodeURIComponent(document.getElementById('email').value);
xhr.send(data);

  
       // Reset all form fields to their default values
       document.getElementById('customerType').value = "";
  document.getElementById('chooseService').value = "";
  document.getElementById('paymentFor').value = "";
  document.getElementById('modePayment').value = "";
  document.getElementById('name').value = "";
  document.getElementById('email').value = "";


  // Hide the priority message if it was displayed
  document.getElementById('priorityMessage').style.display = 'none';
  // Close the new modal
  hideNewModal();
  originalModal();
  var confirmation = confirm('Queue processed successfully. Queue Number: ' + response.queueNumber);
  
  if (confirmation) {
    // If the user confirms, you can add additional logic here
    // For example, you can redirect to another page or perform other actions
    // Example: window.location.href = 'another_page.php';
  } else {
    // If the user cancels, you can handle it here
    // Example: alert('Queue processing was canceled.');
  }
}



function validateForm() {
  // Check the validity of all form elements
  var form = document.querySelector('form');
  if (!form.checkValidity()) {
    // If any form element is invalid, prevent form submission
    alert('Please correct the errors in the form.');
    return false;
  }
}


function validateName() {
    var name = document.getElementById('name').value;
    var nameError = document.getElementById('nameError');
    var nameRegex = /^[A-Za-z\s]+$/;  // regular expression for only letters and spaces

    if (nameRegex.test(name)) {
        nameError.textContent = ''; // Clear the error message
        return true; // Name is valid
    } else {
        nameError.textContent = 'Invalid characters detected. Only letters and spaces are allowed.';
        return false; // Name is invalid
    }
}

// Add an event listener to the form for validation
document.querySelector('form').addEventListener('submit', function(event) {
  var nameInput = document.getElementById('name');
  if (!validateName(nameInput)) {
    event.preventDefault(); // Prevent form submission if validation fails
  }
});

function validateEmail() {
    var email = document.getElementById('email').value;
    var emailError = document.getElementById('emailError');
    var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/; // regular expression for email validation

    if (email === '' || emailRegex.test(email)) { // Allow empty email or valid email
        emailError.textContent = ''; // Clear the error message
        return true; // Email is valid or empty
    } else {
        emailError.textContent = 'Please enter a valid email address or leave it blank.';
        return false; // Email is invalid
    }
}


// Add this part in the event listener which is validating the form
document.querySelector('form').addEventListener('submit', function(event) {
  if (!validateEmail()) {
    event.preventDefault(); // Prevent form submission if email validation fails
  }
});


function setVideoSize() {
  var video = document.getElementById('background-video');
  var windowWidth = window.innerWidth;
  var windowHeight = window.innerHeight;

  var videoAspectRatio = 16 / 9; // Adjust this according to your video's aspect ratio

  if (windowWidth / windowHeight > videoAspectRatio) {
    video.style.width = 'auto';
    video.style.height = '100%';
  } else {
    video.style.width = '100%';
    video.style.height = 'auto';
  }
}

// Listen for window resize events to adjust video size
window.addEventListener('resize', setVideoSize);

// Initial call to set video size
setVideoSize();

// Close modal if clicked outside
window.onclick = function(event) {
  if (event.target == modal) {
    modal.style.display = "none";
  }
  if (event.target == newModal) {
    newModal.style.display = 'none';
  }
}

</script>

</body>
</html>