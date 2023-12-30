document.addEventListener("DOMContentLoaded", function () {
    // Event listener for generating CV
    document.getElementById("cv-form").addEventListener("submit", function (e) {
        e.preventDefault(); // Prevent form submission for this example

        // Call a function to update the CV display
        updateCV();
    });

    // Initialize repeater for achievements
    $("#cv-form .achievements-items").repeater({
        show: function () {
            $(this).slideDown();
        },
        hide: function (deleteElement) {
            if (confirm("Are you sure you want to delete this element?")) {
                $(this).slideUp(deleteElement);
            }
        },
    });

    // Initialize repeater for educations
    $("#cv-form .educations-items").repeater({
        show: function () {
            $(this).slideDown();
        },
        hide: function (deleteElement) {
            if (confirm("Are you sure you want to delete this element?")) {
                $(this).slideUp(deleteElement);
            }
        },
    });

    // Initialize repeater for experiences
    $("#cv-form .experiences-items").repeater({
        show: function () {
            $(this).slideDown();
        },
        hide: function (deleteElement) {
            if (confirm("Are you sure you want to delete this element?")) {
                $(this).slideUp(deleteElement);
            }
        },
    });

    // Initialize repeater for projects
    $("#cv-form .projects-items").repeater({
        show: function () {
            $(this).slideDown();
        },
        hide: function (deleteElement) {
            if (confirm("Are you sure you want to delete this element?")) {
                $(this).slideUp(deleteElement);
            }
        },
    });

    // Initialize repeater for skills
    $("#cv-form .skills-items").repeater({
        show: function () {
            $(this).slideDown();
        },
        hide: function (deleteElement) {
            if (confirm("Are you sure you want to delete this element?")) {
                $(this).slideUp(deleteElement);
            }
        },
    });
});

// Function to update CV display
function updateCV() {
    // Get values from the form
    const firstName = document.getElementById("fullname_dsp");
    const middleName = document.getElementById("middlename_dsp");
    const lastName = document.getElementById("lastname_dsp");
    const image = document.getElementById("image_dsp");
    const designation = document.getElementById("designation_dsp");
    const phoneNo = document.getElementById("phoneno_dsp");
    const email = document.getElementById("email_dsp");
    const address = document.getElementById("address_dsp");
    const summary = document.getElementById("summary_dsp");

    // Update CV display
    firstName.textContent = document.querySelector(".firstname").value;
    middleName.textContent = document.querySelector(".middlename").value;
    lastName.textContent = document.querySelector(".lastname").value;
    // Update other fields similarly

    // Update the image
    const imageInput = document.querySelector(".image");
    if (imageInput.files && imageInput.files[0]) {
        const reader = new FileReader();
        reader.onload = function (e) {
            image.src = e.target.result;
        };
        reader.readAsDataURL(imageInput.files[0]);
    }

    // Update achievements
    const achievementsDisplay = document.getElementById("achievements_dsp");
    achievementsDisplay.innerHTML = "";
    document.querySelectorAll(".cv-form-row-achievement").forEach(function (item) {
        const title = item.querySelector(".achieve_title").value;
        const description = item.querySelector(".achieve_description").value;
        const achievementItem = document.createElement("div");
        achievementItem.textContent = `${title}: ${description}`;
        achievementsDisplay.appendChild(achievementItem);
    });

    // Update educations
    const educationsDisplay = document.getElementById("educations_dsp");
    educationsDisplay.innerHTML = "";
    document.querySelectorAll(".cv-form-row-education").forEach(function (item) {
        const school = item.querySelector(".edu_school").value;
        const degree = item.querySelector(".edu_degree").value;
        const city = item.querySelector(".edu_city").value;
        // Get other education details similarly
        const educationItem = document.createElement("div");
        educationItem.textContent = `${degree} in ${school}, ${city}`;
        educationsDisplay.appendChild(educationItem);
    });

    // Update experiences
    const experiencesDisplay = document.getElementById("experiences_dsp");
    experiencesDisplay.innerHTML = "";
    document.querySelectorAll(".cv-form-row-experience").forEach(function (item) {
        const title = item.querySelector(".exp_title").value;
        const organization = item.querySelector(".exp_organization").value;
        const location = item.querySelector(".exp_location").value;
        // Get other experience details similarly
        const experienceItem = document.createElement("div");
        experienceItem.textContent = `${title} at ${organization}, ${location}`;
        experiencesDisplay.appendChild(experienceItem);
    });

    // Update projects
    const projectsDisplay = document.getElementById("projects_dsp");
}