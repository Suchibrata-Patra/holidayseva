<style>
  @import url("https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap");
  
  body {
    font-family: "Inter", sans-serif;
    margin: 0;
    padding: 0;
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 100vh;
    background-color: #f9fafb;
  }
  
  .form-container {
    max-width: 600px;
    width: 90%;
    padding: 30px;
    background-color: #ffffff;
    border-radius: 0px;
    border: 0.5px solid #bababa;
  }
  
  .form-container h1 {
    font-size: 2rem;
    margin: 0 0 20px;
    color: #333;
    text-align: center;
    font-weight: 400;
  }
  
  form {
    display: grid;
    gap: 16px;
  }
  
  .form-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 16px;
  }
  
  label {
    display: block;
    font-size: 1.1rem;
    margin-bottom: 0px;
    color: #014283;
    font-weight: 500;
  }
  
  input,
  textarea {
    width: 100%;
    padding: 10px 14px;
    font-size: 0.95rem;
    border: 1px solid #dcdcdc;
    border-radius: 0px;
    background-color: #ffffff;
    transition: border-color 0.2s;
  }
  
  input:focus,
  textarea:focus {
    border-color: #007aff;
    outline: none;
    background-color: #fff;
  }
  
  textarea {
    resize: none;
    height: 80px;
  }
  
  button {
    padding: 12px;
    background-color: #007aff;
    color: white;
    font-size: 1rem;
    font-weight: 600;
    border: none;
    border-radius: 2px;
    cursor: pointer;
    transition: background-color 0.3s ease;
  }
  
  button:hover {
    background-color: #005bb5;
  }
  
  .toggle-container {
    display: flex;
    align-items: center;
    gap: 8px;
    
  }
  .switch {
    position: relative;
    display: inline-block;
    width: 34px;
    height: 20px;
  }
  
  .switch input {
    opacity: 0;
    width: 0;
    height: 0;
  }
  
  .slider {
    position: absolute;
    cursor: pointer;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: #ccc;
    transition: 0.4s;
    border-radius: 20px;
  }
  
  .slider:before {
    position: absolute;
    content: "";
    height: 14px;
    width: 14px;
    left: 3px;
    bottom: 3px;
    background-color: white;
    transition: 0.4s;
    border-radius: 50%;
  }
  
  input:checked + .slider {
    background-color: #007aff;
  }
  
  input:checked + .slider:before {
    transform: translateX(14px);
  }
  
  .checkbox-container {
    display: flex;
    align-items: center;
    gap: 8px;
  }
  
  .food-toggle-wrapper {
    display: flex;
    align-items: center;
    gap: 12px;
  }
  
  #meal_plan_field {
    display: flex;
    align-items: center;
  }
  
  #meal_plan {
    margin-left: 10px;
  }
  input:disabled {
    cursor: not-allowed; /* Changes the cursor to the disabled style */
    background-color: #f0f0f0; /* Optional: Add a gray background to indicate disabled state */
  }
</style>

<div class="form-container">
  <h1>Register Enquiry</h1>
  <form method="POST">
    <div class="form-row">
      <div>
        <label for="customer_name">Customer Name</label>
        <input type="text" id="customer_name" name="customer_name" placeholder="Enter customer name" required />
      </div>
      <div>
        <label for="mobile_no">Mobile No</label>
        <input type="text" id="mobile_no" name="mobile_no" placeholder="Enter mobile number" required />
      </div>
    </div>
    <div>
      <label for="pickup_address">Pickup Address</label>
      <textarea id="pickup_address" name="pickup_address" placeholder="Enter pickup address" required></textarea>
    </div>
    <div>
      <div>
        <label>Drop Address</label>
        <div class="toggle-container">
          <label class="switch">
            <input type="checkbox" id="drop_address_toggle" checked onchange="toggleAddress('drop_address_toggle', 'drop_address_field', 'drop_address')"/>
            <span class="slider round"></span>
          </label>
          Same as Pickup Address
        </div>
        <div id="drop_address_field" style="display: none">
          <!-- <label for="drop_address">Drop Address</label> -->
          <textarea id="drop_address" name="drop_address" placeholder="Enter drop address"></textarea>
        </div>
      </div>
    </div>
    <div class="form-row">
      <div>
        <label for="tour_package">Tour Package</label>
        <input type="text" id="tour_package" name="tour_package" placeholder="Enter tour package name" required />
      </div>
      <div>
        <label for="pricing">Pricing</label>
        <input type="number" id="pricing" name="pricing" placeholder="Enter Total Cost" required />
      </div>
    </div>
    <div class="form-row">
      <div>
        <label for="date_of_journey">Date of Journey</label>
        <input type="date" id="date_of_journey" name="date_of_journey" required />
      </div>
      <div>
        <label for="date_of_return">Date of Return</label>
        <input type="date" id="date_of_return" name="date_of_return" required />
      </div>
      <div>
        <label for="no_of_adults">Number of Adults</label>
        <input type="number" id="no_of_adults" name="no_of_adults" placeholder="Enter number of adults" required />
      </div>
      <div>
        <label for="no_of_children">Number of Children</label>
        <input type="number" id="no_of_children" name="no_of_children" placeholder="Enter number of Children" required />
      </div>
    </div>
    <div class="form-row">
      <div>
        <label for="cars_provided">Cars Provided</label>
        <input type="text" id="cars_provided" name="cars_provided" placeholder="Enter cars provided" required />
      </div>
      <div>
        <label for="no_of_cars">Number of Cars</label>
        <input type="number" id="no_of_cars" name="no_of_cars" placeholder="Enter number of cars" required />
      </div>
      <div>
        <label for="hotel_used">Hotel Required</label>
        <select id="hotel_used" name="hotel_used" required onchange="toggleRoomDetails()" style="padding: 5px 200px 5px 5px;">
          <option value="yes">Yes</option>
          <option value="no" selected>No</option>
        </select>
      </div>
      
      <div>
        <label for="hotel_room_details">Type of Rooms</label>
        <input type="text" id="hotel_room_details" name="hotel_room_details" placeholder="Not Required" required disabled />
      </div>
    </div>
    <div>
      <label for="special_requirements">Special Requirements</label>
      <textarea id="special_requirements" name="special_requirements" placeholder="Enter special requirements (If any)"></textarea>
    </div>
    <div class="food-toggle-wrapper">
      <div class="checkbox-container">
        <label class="switch">
          <input type="checkbox" id="food_included" name="food_included" onchange="toggleMealPlan()"/>
          <span class="slider round"></span>
        </label>
        Food Included ?
      </div>
      <div id="meal_plan_field" style="display: none">
        <select id="meal_plan" name="meal_plan" required>
          <option value="" disabled selected>Select a meal plan</option>
          <option value="breakfast_only">Breakfast Only</option>
          <option value="half_board">Half Board (Breakfast + Dinner)</option>
          <option value="full_board">Full Board (All Meals)</option>
        </select>
      </div>
    </div>
    <button type="submit">Save</button>
  </form>
</div>

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
