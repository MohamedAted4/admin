document.addEventListener("DOMContentLoaded", function() {
    const studentsSwitch = document.getElementById("studentsSwitch");
    const departmentsSwitch = document.getElementById("departmentsSwitch");
    const coursesSwitch = document.getElementById("coursesSwitch");
    const content = document.getElementById("content");

    // Function to fetch and display student information
    function displayStudents() {
        fetch('/students')
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                // Replace the content with the students' information
                let html = "<h2>Students</h2>";
                if (data.length > 0) {
                    html += "<ul>";
                    data.forEach(student => {
                        html += `<li>${student.student_name} (${student.student_id}) - GPA: ${student.c_gpa}</li>`;
                    });
                    html += "</ul>";
                } else {
                    html += "<p>No students found.</p>";
                }
                content.innerHTML = html;
            })
            .catch(error => {
                console.error('Error fetching data:', error);
                content.innerHTML = `<p>Error fetching data. Please try again later.</p>`;
            });
    }

    // Function to fetch and display department information
    function displayDepartments() {
        fetch('/departments')
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                // Replace the content with the departments' information
                let html = "<h2>Departments</h2>";
                if (data.length > 0) {
                    html += "<ul>";
                    data.forEach(department => {
                        html += `<li>${department.department_name} (${department.department_code})</li>`;
                    });
                    html += "</ul>";
                } else {
                    html += "<p>No departments found.</p>";
                }
                content.innerHTML = html;
            })
            .catch(error => {
                console.error('Error fetching data:', error);
                content.innerHTML = `<p>Error fetching data. Please try again later.</p>`;
            });
    }

    // Function to fetch and display course information
    function displayCourses() {
        fetch('/courses')
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                // Replace the content with the courses' information
                let html = "<h2>Courses</h2>";
                if (data.length > 0) {
                    html += "<ul>";
                    data.forEach(course => {
                        html += `<li>${course.course_name} (${course.course_code}) - Department: ${course.department_name}</li>`;
                    });
                    html += "</ul>";
                } else {
                    html += "<p>No courses found.</p>";
                }
                content.innerHTML = html;
            })
            .catch(error => {
                console.error('Error fetching data:', error);
                content.innerHTML = `<p>Error fetching data. Please try again later.</p>`;
            });
    }

    // Event listener for the students switch
    studentsSwitch.addEventListener("click", function() {
        // Display students section
        displayStudents();
        // Highlight the active switch
        studentsSwitch.classList.add('active');
        departmentsSwitch.classList.remove('active');
        coursesSwitch.classList.remove('active');
    });

    // Event listener for the departments switch
    departmentsSwitch.addEventListener("click", function() {
        // Display departments section
        displayDepartments();
        // Highlight the active switch
        studentsSwitch.classList.remove('active');
        departmentsSwitch.classList.add('active');
        coursesSwitch.classList.remove('active');
    });

    // Event listener for the courses switch
    coursesSwitch.addEventListener("click", function() {
        // Display courses section
        displayCourses();
        // Highlight the active switch
        studentsSwitch.classList.remove('active');
        departmentsSwitch.classList.remove('active');
        coursesSwitch.classList.add('active');
    });

    // Initial display (default to students)
    displayStudents();
    studentsSwitch.classList.add('active');
});
