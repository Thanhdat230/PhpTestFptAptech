<?php

                    require_once "config.php";

                    $sql = "SELECT * FROM books";
                    global $mysqli;
                    if ($result = $mysqli->query($sql)) {
                        if ($result->num_rows > 0) {
                            echo '<table class="table table-bordered table-striped">';
                            echo "<thead>";
                            echo "<tr>";
                            echo "<th>Book code</th>";
                            echo "<th>Author</th>";
                            echo "<th>Book tittle</th>";
                            echo "<th>ISBN Book</th>";
                            echo "<th>Publishing year</th>";
                            echo "<th>Available</th>";
                            echo "</tr>";
                            echo "</thead>";
                            echo "<tbody>";
                            while ($row = $result->fetch_array()) {
                                echo "<tr>";
                                echo "<td>" . $row['bookid'] . "</td>";
                                echo "<td>" . $row['authorid'] . "</td>";
                                echo "<td>" . $row['tittle'] . "</td>";
                                echo "<td>" . $row['ISBN'] . "</td>";
                                echo "<td>" . $row['pub_year'] . "</td>";
                                echo "<td>" . $row['available'] . "</td>";
                                echo "<td>";
                                echo '<a href="read.php?id=' . $row['bookid'] . '" class="mr-3" title="View Record" 
                                            data-toggle="tooltip"><span class="fa fa-eye"></span></a>';
                                echo '<a href="update.php?id=' . $row['bookid'] . '" class="mr-3" title="Update Record"
                                            data-toggle="tooltip"><span class="fa fa-pencil"></span></a>';
                                echo '<a href="delete.php?id=' . $row['bookid'] . '" class="mr-3" title="Delete Record"
                                            data-toggle="tooltip"><span class="fa fa-trash"></span></a>';
                                echo "</td>";
                                echo "</tr>";
                            }
                            echo "</tbody>";
                            echo "</table>";

                            $result->free();
                        } else {
                            echo '<div class="alert alert-danger"><em>No records were found.</em></div>';
                        }
                    } else {
                        echo "Oops! Something went wrong. Please try again later.";
                    }

                    $mysqli->close();
                    ?>