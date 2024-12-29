<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
<style>
  /* General Styles */
  .form-container {
    display: flex;
    flex-direction: column;
    gap: 10px;
  }

  .form-title {
    margin: 0;
    text-align: center;
    font-size: 2rem;
    font-weight: 400;
    color: black;
  }

  .form-group {
    display: flex;
    gap: 10px;
  }

  .form-label {
    flex: 1;
    color: #0a4082;
  }

  .form-input,
  .form-textarea,
  .form-button {
    width: 100%;
    padding: 6px;
    /* Increased padding for better look */
    border: 0.4px solid rgb(211, 211, 211);
    border-radius: 0px;
    box-sizing: border-box;
    color:rgb(0, 0, 0);
    font-size: 1rem;
    /* Ensures consistent width and padding */
  }

  .form-textarea {
    height: 60px;
  }

  .form-button {
    background: #007aff;
    color: #ffffff;
    border: none;
    cursor: pointer;
    text-align: center;
  }

  .button-group {
    display: flex;
    justify-content: space-between;
    gap: 10px;
    margin-top: 10px;
  }
  #editModal::-webkit-scrollbar {
    display: none;
  }
  
</style>

<div id="editModal" style="
display: none; 
position: fixed; 
top: 50%; 
left: 50%; 
transform: translate(-50%, -50%); 
width: 40%; 
background: #fff; 
border: 0.4px solid rgb(211, 211, 211); 
border-radius: 0px; 
padding: 30px; 
font-family: Arial, sans-serif; 
font-size: 14px; 
color: rgb(211, 211, 211);
max-height:95vh;
overflow-y:auto;
scrol
">


<div method="POST" action="" style="display: flex; flex-direction: column; gap: 10px;">
    <!-- <button onclick="closeEditModal()" style="position: fixed;right: 20px;top:20px;font-size: 1.5rem;background:rgb(234, 234, 234);border-radius: 50px;padding: 5px 13px;border:none;font-weight: 200;"> X </button> -->
    <button onclick="closeEditModal()" style="position: fixed; right: 20px; top: 20px; font-size: 1rem;color:black;background-color:none ;border-radius: 50px; padding: 5px 5px 0 5px; border: none; font-weight: 200;">
    <!-- Material Icon for close -->
    <span class="material-icons">close</span>
  </button>
    <form method="POST" action="" class="form-container">
      <input type="hidden" id="update_invoice_id" name="update_invoice_id">
      <h3 class="form-title">Edit Booking</h3>      
      <div style="display: flex; align-items: center;background:rgb(255, 255, 255);padding-left: 0px;">
        <span style="color: rgb(2, 57, 135); font-weight: 400;font-size: 1rem;padding-right: 5px;">Customer ID : </span>
        <input type="text" id="user_id" name="user_id"  style="cursor: pointer;font-size: 1rem;border: none;font-weight: 400;color:rgb(0, 0, 0);font-size: 1rem;background-color:none;" >
      </div>
      <div class="form-group"> 
        <label class="form-label">Customer Name:
          <input type="text" id="customer_name" name="customer_name" class="form-input"  style="cursor:pointer"; readonly>
        </label>
        <label class="form-label">Mobile No:
          <input type="text" id="mobile_no" name="mobile_no" class="form-input" style="cursor:pointer"; readonly>
        </label>
        
      </div>

      <div class="form-group">
        <label class="form-label">Pickup Address:
          <input type="text" id="pickup_address" name="pickup_address" class="form-input"  style="cursor:pointer"; readonly>
        </label>
        <label class="form-label">Drop Address:
          <input type="text" id="drop_address" name="drop_address" class="form-input"  style="cursor:pointer"; readonly>
        </label>
      </div>

      <div class="form-group">
        <label class="form-label">Pricing:
          <input type="text" id="pricing" name="pricing" class="form-input">
        </label>
        <label class="form-label" style="background-color: rgb(221, 237, 255);color: black;padding:5px;">Token Amount:
          <input type="text" id="token_paid" name="token_paid" class="form-input">
        </label>
      </div>

      <label class="form-label">Tour Package:
        <input type="text" id="tour_package" name="tour_package" class="form-input"  style="cursor:pointer"; >
      </label>
      <div class="form-group">
        <label class="form-label">Journey:
          <input type="date" id="date_of_journey" name="date_of_journey" class="form-input"  style="cursor:pointer"; readonly>
        </label>
        <label class="form-label">Return:
          <input type="date" id="date_of_return" name="date_of_return" class="form-input"  style="cursor:pointer"; readonly>
        </label>
        
      </div>

      <div class="form-group">
      <label class="form-label">No of Adults:
          <input type="number" id="no_of_adults" name="no_of_adults" class="form-input"  style="cursor:pointer"; readonly>
        </label>
      <label class="form-label">No of child:
          <input type="number" id="no_of_children" name="no_of_children" class="form-input"  style="cursor:pointer"; readonly>
        </label>
        <label class="form-label">Cars Provided:
          <input type="text" id="cars_provided" name="cars_provided" class="form-input"  style="cursor:pointer"; readonly>
        </label>
        <label class="form-label">Number of Cars:
          <input type="number" id="no_of_cars" name="no_of_cars" class="form-input"  style="cursor:pointer"; readonly>
        </label>
      </div>

      <label class="form-label">Special Requirements:
        <textarea id="special_requirements" name="special_requirements" class="form-textarea" readonly></textarea>
      </label>
      <div class="form-group">
        <label class="form-label">Hotel Used:
          <input type="text" id="hotel_used" name="hotel_used" class="form-input"  style="cursor:pointer"; readonly>
        </label>
        <label class="form-label">Room Details:
          <input type="text" id="hotel_room_details" name="hotel_room_details" class="form-input"  style="cursor:pointer"; readonly>
        </label>
        
      </div>
      <div class="form-group">
        <label class="form-label toggle-label">
          Food Included:
          <input type="checkbox" id="food_included" name="food_included" class="toggle-checkbox">
          <input type="checkbox" id="food_included" name="food_included" class="toggle-checkbox">
          <span class="toggle-slider"></span>
        </label>
        <label class="form-label">Meal Type:
          <input type="text" id="meal_type" name="meal_type" class="form-input">
        </label>
      </div>

      <div class="button-group">
        <button type="submit" class="form-button">Save</button>
        <button type="button" onclick="closeEditModal()" class="form-button">Cancel</button>
      </div>
    </form>
  </div>

  <style>
    /* Container for the toggle */
    .toggle-label {
      display: flex;
      align-items: center;
      font-size: 16px;
    }
  
    /* Hide the default checkbox */
    .toggle-checkbox {
      display: none;
    }
  
    /* Toggle slider container */
    .toggle-slider {
      margin-left: 10px;
      position: relative;
      width: 50px;
      height: 25px;
      background-color: #ccc;
      border-radius: 25px;
      cursor: pointer;
      transition: background-color 0.3s;
    }
  
    /* Slider circle */
    .toggle-slider::before {
      content: "";
      position: absolute;
      top: 3px;
      left: 3px;
      width: 19px;
      height: 19px;
      background-color: white;
      border-radius: 50%;
      transition: transform 0.3s;
    }
  
    /* Checked state */
    .toggle-checkbox:checked + .toggle-slider {
      background-color: #389dea;
    }
  
    .toggle-checkbox:checked + .toggle-slider::before {
      transform: translateX(25px);
    }
  </style>
  
  <script>
  function toggleAddress(toggleId, fieldId, inputId) {
const toggleSwitch = document.getElementById(toggleId);
const field = document.getElementById(fieldId);
const input = document.getElementById(inputId);
const pickupAddress = document.getElementById("pickup_address").value;
const defaultAddress = document.getElementById("drop_address").value; // New field for default value

if (toggleSwitch.checked) {
  field.style.display = "none";
  input.value = pickupAddress; // Use pickup address when toggle is on
} else {
  field.style.display = "block";
  input.value = defaultAddress; // Use default value when toggle is off
}
}




function toggleMealPlan() {
  const toggleSwitch = document.getElementById("food_included");
  const mealPlanField = document.getElementById("meal_plan_field");
  const mealPlanInput = document.getElementById("meal_plan");

  if (toggleSwitch.checked) {
    mealPlanField.style.display = "block"; // Show the dropdown
    mealPlanInput.required = true; // Mark as required when visible
  } else {
    mealPlanField.style.display = "none"; // Hide the dropdown
    mealPlanInput.value = ""; // Clear the selection
    mealPlanInput.required = false; // Remove required attribute
  }
}
function toggleRoomDetails() {
    const hotelUsedDropdown = document.getElementById('hotel_used');
    const roomDetailsField = document.getElementById('hotel_room_details');

    if (hotelUsedDropdown.value === 'no') {
      roomDetailsField.disabled = true;
      roomDetailsField.value = ''; // Clear the field value when disabling
    } else {
      roomDetailsField.disabled = false;
    }
  }

  // Initialize the field state on page load
  document.addEventListener('DOMContentLoaded', toggleRoomDetails);

window.onload = function () {
  const dropToggle = document.getElementById("drop_address_toggle");
  dropToggle.checked = true;
  toggleAddress('drop_address_toggle', 'drop_address_field', 'drop_address');
  toggleMealPlan(); // Apply the initial state for the food toggle
};

</script>
