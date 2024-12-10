<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Website ni Salapantan</title>
    <link rel="stylesheet" type="text/css" href="style.css">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            background: linear-gradient(135deg, #00796b, #018A7AFF);
            color: #333;
            line-height: 1.6;
        }

        /* Main container */
        #container {
            width: 90%;
            margin: 20px auto;
            display: flex;
            flex-wrap: wrap;
            box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.1);
            background-color: #fff;
            border-radius: 8px;
            overflow: hidden;
        }

        header, nav, footer {
            background-color: #333;
            color: white;
            padding: 15px;
            text-align: center;
        }

        nav a {
            color: white;
            margin: 0 15px;
            text-decoration: none;
            font-weight: bold;
            transition: color 0.3s ease;
        }

        nav a:hover {
            color: #C0C0C0FF;
        }

        footer {
            font-size: 0.8em;
        }

        #homepage {
            display: flex;
            flex-wrap: wrap;
            width: 100%;
        }

        #content, #sidebar {
            padding: 30px;
            background-color: #fff;
            margin: 10px;
            border-radius: 8px;
            flex: 1;
        }

        #sidebar {
            flex: 0.3;
            background: linear-gradient(135deg, #018A7AFF, #00796b);
            color: white;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #00796b;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        tr:hover {
            background-color: #f1f1f1;
            transition: background-color 0.3s ease;
        }

        .btn {
            display: inline-block;
            padding: 10px 20px;
            background-color: #00796b;
            color: white;
            border-radius: 5px;
            text-decoration: none;
            font-weight: bold;
            transition: background-color 0.3s ease;
        }

        .btn:hover {
            background-color: #B9B9B9FF;
        }

        .error {
            color: red;
            font-weight: bold;
        }

        @media screen and (max-width: 768px) {
            #homepage {
                flex-direction: column;
            }

            #sidebar {
                flex: 1;
                margin-top: 20px;
            }
        }

        @media screen and (max-width: 480px) {
            #container {
                width: 100%;
            }

            #content, #sidebar {
                padding: 20px;
            }
        }
    </style>
</head>
<body>
    <div id="container">
        <!-- Include header, navigation, and sidebar info -->
        <?php include('header.php'); ?>
        <?php include('nav.php'); ?>

        <!-- Main content and sidebar layout -->
        <div id="homepage">
            <!-- Main content area (Registered Users) -->
            <div id="content">
                <h2>Registered Users</h2>
                <p>
                <?php
                    // Include database connection file
                    require('mysqli_connect.php');
                
                    // SQL query to retrieve users, emails, and registration dates
                    $q = "SELECT users_id, fname, email, DATE_FORMAT(registration_date, '%M %d, %Y') AS regdate
                          FROM users ORDER BY registration_date ASC";
                    
                    // Execute the query
                    $result = @mysqli_query($dbcon, $q);

                    // Check if query returned results
                    if ($result) {
                        // Start HTML table
                        echo '<table>
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Registration Date</th>
                                    <th>Actions</th>
                                </tr>';

                        // Fetch each row of data
                        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                            $user_id = htmlspecialchars($row['user_id'] ?? ''); // Ensure no warning and safely handle missing user_id
                            echo '<tr>
                                    <td>' . htmlspecialchars($row['fname'] ?? 'N/A') . '</td>
                                    <td>' . htmlspecialchars($row['email'] ?? 'N/A') . '</td>
                                    <td>' . htmlspecialchars($row['regdate'] ?? 'N/A') . '</td>
                                    <td><a href="edit_users.php?id=' . $user_id . '">Edit</a></td>
                                    <td><a href="delete_user.php?id=' . $user_id . '">Delete</a></td>
                                  </tr>';
                        }
                        // Close the table
                        echo '</table>';

                        // Free the result
                        mysqli_free_result($result);
                    } else {
                        // If query fails, show an error message
                        echo '<p class="error">The current users could not be retrieved due to a system error. 
                              Please report this incident to the SysAdmin. Error Code: 17</p>';
                    }

                    // Close the database connection
                    mysqli_close($dbcon);
                ?>
                </p>
            </div>

            <!-- Sidebar area (additional content, like user info or ads) -->
            <div id="sidebar">
                <h3>Important Information</h3>
                <p>Check out our latest updates and events here.</p>
                <!-- Call-to-action button -->
                <a href="#" class="btn">Learn More</a>
            </div>
        </div>

        <!-- Include footer -->
        <?php include('footer.php'); ?>
    </div>
</body>
</html>
