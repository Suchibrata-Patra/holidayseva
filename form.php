<div class="col-md-3">
            <h1 class="text-center mb-4">Invoice Entry Form</h1>

            <form method="POST">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="customer_name" class="form-label">Customer Name:</label>
                        <input type="text" name="customer_name" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label for="mobile_no" class="form-label">Mobile No:</label>
                        <input type="text" name="mobile_no" class="form-control" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="pickup_address" class="form-label">Pickup Address:</label>
                    <textarea name="pickup_address" class="form-control" required></textarea>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="tour_package" class="form-label">Tour Package:</label>
                        <input type="text" name="tour_package" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label for="pricing" class="form-label">Pricing:</label>
                        <input type="number" step="0.01" name="pricing" class="form-control" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="special_requirements" class="form-label">Special Requirements:</label>
                    <textarea name="special_requirements" class="form-control"></textarea>
                </div>

                <!-- New Fields -->
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="date_of_journey" class="form-label">Date of Journey:</label>
                        <input type="date" name="date_of_journey" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label for="no_of_adults" class="form-label">Number of Adults:</label>
                        <input type="number" name="no_of_adults" class="form-control" required>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="cars_provided" class="form-label">Cars Provided:</label>
                        <input type="text" name="cars_provided" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label for="no_of_cars" class="form-label">Number of Cars:</label>
                        <input type="number" name="no_of_cars" class="form-control" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="food_included" class="form-label">Food Included:</label>
                    <input type="checkbox" name="food_included" class="form-check-input">
                    <label class="form-check-label">Yes</label>
                </div>

                <div class="text-center">
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>