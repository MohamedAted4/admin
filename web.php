<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ADNIN Website</title>
    
    <style>
        body 
        {
            background-image: url("1.jpg");
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
}

        .container {
            background-color: rgba(255, 255, 255, 0.8);
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            width: 80%;
            max-width: 1000px;
        }

        h1 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }

        #searchInput {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }

        #insertButton {
            display: block;
            margin: 0 auto 20px auto;
            background-color: #28a745;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        #insertButton:hover {
            background-color: #218838;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th, td {
            text-align: left;
            padding: 10px;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #007bff;
            color: white;
        }

        tr:hover {
            background-color: #f1f1f1;
        }

        .operationButton {
            width: 80px;
            margin-right: 5px;
            color: #fff;
            padding: 5px 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .deleteBtn {
            background-color: #dc3545; /* Red color for delete */
        }

        .deleteBtn:hover {
            background-color: #c82333;
        }

        .updateBtn {
            background-color: #007bff; /* Blue color for update */
        }

        .updateBtn:hover {
            background-color: #0056b3;
        }

        .highlight {
            background-color: #ffc107;
        }

        @media screen and (max-width: 600px) {
            .container {
                width: 90%;
            }

            table, th, td {
                display: block;
                width: 100%;
            }

            tr {
                margin-bottom: 10px;
                border-bottom: 1px solid #ddd;
            }

            th, td {
                text-align: left;
                display: block;
                text-align: right;
            }

            th::before {
                float: left;
                font-weight: bold;
            }
        }

        #message {
            display: none;
            color: green;
            font-weight: bold;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>User Information</h1>
        <input type="text" id="searchInput" placeholder="Search for user name OR ID">
        <button id="insertButton" class="operationButton">Insert</button>
        <table id="userTable">
            <thead>
                <tr>
                    <th>User Name</th>
                    <th>User ID</th>
                    <th>Email</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    // Establish a connection to the MySQL database
                    $servername = "localhost";
                    $username   = "root";
                    $password   = "217200";
                    $dbname     = "IOT";
                    
                    // Create connection
                    $conn = mysqli_connect($servername, $username, $password, $dbname);
                    
                    // Check connection
                    if ($conn->connect_error) {
                        die("Connection failed: " . $conn->connect_error);
                    }
                    
                    // Execute the SQL query
                    $sql = "SELECT 
                                CONCAT(first_name, ' ', last_name) AS user_name,
                                user_id,
                                Gmail
                            FROM 
                                user";
                    $result = $conn->query($sql);
                    
                    // Check if there are any results
                    if ($result->num_rows > 0) {
                        // Output data of each row
                        while($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $row["user_name"] . "</td>";
                            echo "<td>" . $row["user_id"] . "</td>";
                            echo "<td>" . $row["Gmail"] . "</td>";
                            echo "<td>
                                    <button class='operationButton updateBtn'>Update</button>
                                    <button class='operationButton deleteBtn'>Delete</button>
                                </td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='4'>0 results</td></tr>";
                    }
                    
                    // Close the connection
                    $conn->close();
                ?>
            </tbody>
        </table>
        <p id="noResults" style="display: none;">No results found</p>
        <p id="message"></p>
    </div>

    <script>
    function filterTable() {
        const searchInput = document.getElementById('searchInput').value.toLowerCase();
        const rows = document.querySelectorAll('#userTable tbody tr');
        rows.forEach(row => {
            const userName = row.cells[0].textContent.toLowerCase();
            const userID = row.cells[1].textContent.toLowerCase();
            if (userName.includes(searchInput) || userID.includes(searchInput)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    }

    document.getElementById('searchInput').addEventListener('input', filterTable);

    function openOperationPage(operation, userID = null) {
        const url = operation + '.php' + (userID ? '?userID=' + encodeURIComponent(userID) : '');
        window.location.href = url;
    }

    function deleteData(userID) {
        fetch('delete.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: 'userID=' + encodeURIComponent(userID)
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.text();
        })
        .then(data => {
            const messageElement = document.getElementById('message');
            messageElement.textContent = "Delete successful";
            messageElement.style.display = "block";
            filterTable(); // Optionally re-filter the table after deletion
        })
        .catch(error => {
            console.error('There was a problem with the fetch operation:', error);
        });
    }

    const tableRows = document.querySelectorAll('tbody tr');
    tableRows.forEach(row => {
        row.addEventListener('click', () => {
            row.classList.toggle('highlight');
        });
    });

    const updateButtons = document.querySelectorAll('.updateBtn');
    updateButtons.forEach(button => {
        button.addEventListener('click', (event) => {
            event.stopPropagation();
            const userID = button.parentElement.parentElement.querySelector('td:nth-child(2)').textContent;
            openOperationPage('update', userID);
        });
    });

    const deleteButtons = document.querySelectorAll('.deleteBtn');
    deleteButtons.forEach(button => {
        button.addEventListener('click', (event) => {
            event.stopPropagation();
            const userID = button.parentElement.parentElement.querySelector('td:nth-child(2)').textContent;
            deleteData(userID);
        });
    });

    const insertButton = document.getElementById('insertButton');
    insertButton.addEventListener('click', () => {
        openOperationPage('insert');
    });
    </script>
</body>
</html>
