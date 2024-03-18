
//functions for button.
$(document).ready(function () {
    // Add Package Form Submission
    $("form").on("submit", function (e) {
        e.preventDefault();
        if ($(this).attr("name") === "add_package") {
            // Extract data from the form
            const name = $("#name").val();
            const description = $("#description").val();
            const price = $("#price").val();
            const image_url = $("#image_url").val();

            // Create a data object to send via AJAX
            const data = {
                name: name,
                description: description,
                price: price,
                image_url: image_url,
            };

            // Send an AJAX request to add the package
            $.ajax({
                type: "POST",
                url: "add_package.php", // Replace with the actual URL
                data: data,
                success: function (response) {
                    // Refresh the package list on success
                    location.reload();
                },
                error: function (error) {
                    console.error(error);
                    // Handle error
                },
            });
        }
    });

    // Edit Button Click Handler
    $(".edit-button").on("click", function () {
        const packageId = $(this).data("id");

        // Open an edit modal for the selected package
        // Implement your edit modal and populate it with package data

        // When the edit form is submitted, send an AJAX request to update the package
        $("#edit-package-form").on("submit", function (e) {
            e.preventDefault();
            const editedName = $("#edited-name").val();
            const editedDescription = $("#edited-description").val();
            const editedPrice = $("#edited-price").val();
            const editedImageURL = $("#edited-image-url").val();

            const updatedData = {
                id: packageId,
                name: editedName,
                description: editedDescription,
                price: editedPrice,
                image_url: editedImageURL,
            };

            // Send an AJAX request to update the package
            $.ajax({
                type: "POST",
                url: "update_package.php", // Replace with the actual URL
                data: updatedData,
                success: function (response) {
                    // Refresh the package list on success
                    location.reload();
                },
                error: function (error) {
                    console.error(error);
                    // Handle error
                },
            });
        });
    });

    // Delete Button Click Handler
    $(".delete-button").on("click", function () {
        const packageId = $(this).data("id");

        // Open a confirmation modal for package deletion
        const confirmDelete = confirm("Are you sure you want to delete this package?");
        if (confirmDelete) {
            // Send an AJAX request to delete the package
            $.ajax({
                type: "POST",
                url: "delete_package.php", // Replace with the actual URL
                data: { id: packageId },
                success: function (response) {
                    // Refresh the package list on success
                    location.reload();
                },
                error: function (error) {
                    console.error(error);
                    // Handle error
                },
            });
        }
    });
});
