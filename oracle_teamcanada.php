<!--This code is rebased off of the tutorial 7 code and reworked to fit our database -->

<html>
    <head>
        <title>CPSC 304 Team Canada Demonstration</title>
    </head>

    <body>
        <h1>CPSC 304 Team Canada Database Query Engine</h1>

        <!-- Insert -->
        <h2>Insert Values into Sport Table</h2>
        <form method="POST" action="oracle_teamcanada.php"> <!--refresh page when submitted-->
            <input type="hidden" id="insertQueryRequest" name="insertQueryRequest">
            Name of sport: <input type="text" name="insSportName"> <br /><br />
            Name of facility: <input type="text" name="insFacilityUsed"> <br /><br />

            <input type="submit" value="Insert" name="insertSubmit"></p>
        </form>

        <hr />

        <!-- Update -->
        <h2>Update facility used by a sport</h2>
        <p>The values are case sensitive and if you enter in the wrong case, the update statement will not do anything.</p>

        <form method="POST" action="oracle_teamcanada.php"> <!--refresh page when submitted-->
            <input type="hidden" id="updateQueryRequest" name="updateQueryRequest">
            New facility name: <input type="text" name="newName"> <br /><br />
            Name of sport whose facility you're updating: <input type="text" name="sportName"> <br /><br />

            <input type="submit" value="Update" name="updateSubmit"></p>
        </form>

        <hr />

        <!-- Delete -->
        <h2>Delete a Sponsor</h2>
        <p>The values are case sensitive and if you enter in the wrong case, the delete statement will not do anything.</p>
        <form method="POST" action="oracle_teamcanada.php">
            <input type="hidden" id="deleteTupleRequest" name="deleteTupleRequest">
            Sponsor name: <input type="text" name="sponsorName"> <br /><br />
            Year sponsored: <input type="text" name="yearSponsored"> <br /><br />

            <p><input type="submit" value="Delete" name="reset"></p>
        </form>

        <hr />

        <h2>Print the Tuples in Sport Table</h2>
        <form method="GET" action="oracle_teamcanada.php"> <!--refresh page when submitted-->
            <input type="hidden" id="displaySportTuples" name="displaySportTuples">
            <input type="submit" name="displaySportTuples"></p>
        </form>

        <hr />

        <h2>Print the Tuples in the Sponsor Table</h2>
        <form method="GET" action="oracle_teamcanada.php">
            <input type="hidden" id="displaySponsorTuples" name="displaySponsorTuples">
            <input type="submit" name="displaySponsorTuples"></p>
        </form>

        <hr />

        <h2>Print the Tuples in the Funds Table</h2>
        <form method="GET" action="oracle_teamcanada.php">
            <input type="hidden" id="displayFundsTuples" name="displayFundsTuples">
            <input type="submit" name="displayFundsTuples"></p>
        </form>

        <hr />

        <!-- Selection -->
        <h2>Selection</h2>
        <p>Select the tuples in Competitor where the competitor played in a team sport</p>
        <form method="GET" action="oracle_teamcanada.php">
        <input type="hidden" id="deleteTupleRequest" name="deleteTupleRequest">
            <p>Select manner of play:
                <select name="mannerOfPlay">
                    <option value="Team">Team</option>
                    <option value="Individual">Individual</option>
                </select>
            </p>
            <p><input type="submit" name="selection"></p>
        </form>

        <hr />

        <!-- Projection -->
        <h2>Projection</h2>
        <p>Select which column to return in OlympicGames for Olympic games held in winter</p>
        <form method="GET" action="oracle_teamcanada.php">
        <input type="hidden" id="deleteTupleRequest" name="deleteTupleRequest">
            <p>Select column:
                <select name="column">
                    <option value="location">Location</option>
                    <option value="year">Year</option>
                    <option value="*">All columns</option>
                </select>
            </p>
            <p><input type="submit" name="projection"></p>
        </form>

        <hr />

        <!-- Join -->
        <h2>Execute Join Query</h2>
        <h3>Select all the Canadian athletes that participated
            in the 2021 Olympics that won a Bronze Medal
        </h3>
        <form method="GET" action="oracle_teamcanada.php">
            <input type="hidden" id="joinQuery" name="joinQuery">
            <input type="submit" name="joinQuery"></p>
        </form>

        <hr />
        
        <!-- Aggregation Group By -->
        <h2>Execute Group By Query</h2>
        <h3>Select the highest compensation given to an athlete based on the medal material
        </h3>
        <form method="GET" action="oracle_teamcanada.php">
            <input type="hidden" id="groupByQuery" name="groupByQuery">
            <input type="submit" name="groupByQuery"></p>
        </form>

        <hr />

        <!-- Aggregation Having -->
        <h2>Execute Having Query</h2>
        <h3>Return the company names that sponsored more than 1 athlete
        </h3>
        <form method="GET" action="oracle_teamcanada.php">
            <input type="hidden" id="havingQuery" name="havingQuery">
            <input type="submit" name="havingQuery"></p>
        </form>

        <hr />

        <!-- Division -->
        <h2>Execute Division Query</h2>
        <h3>Find the competitorID of competitors who have won all the different medals (gold, silver, and bronze)</h3>
        <form method="GET" action="oracle_teamcanada.php"> <!--refresh page when submitted-->
            <input type="hidden" id="divisionQuery" name="divisionQuery">
            <input type="submit" name="divisionQuery"></p>

        <hr />
        
        <!-- Nest Aggregation -->
        <h2>Execute Nested Query</h2>
        <h3>Find the average engagement for a media type that has a smaller engagement count than
            the average of all media companies
        </h3>
        <form method="GET" action="oracle_teamcanada.php">
            <input type="hidden" id="nestedQuery" name="nestedQuery">
            <input type="submit" name="nestedQuery"></p>
        </form>

        <?php
		//this tells the system that it's no longer just parsing html; it's now parsing PHP

        $success = True; //keep track of errors so it redirects the page only if there are no errors
        $db_conn = NULL; // edit the login credentials in connectToDB()
        $show_debug_alert_messages = False; // set to True if you want alerts to show you which methods are being triggered (see how it is used in debugAlertMessage())

        function debugAlertMessage($message) {
            global $show_debug_alert_messages;

            if ($show_debug_alert_messages) {
                echo "<script type='text/javascript'>alert('" . $message . "');</script>";
            }
        }

        function executePlainSQL($cmdstr) { //takes a plain (no bound variables) SQL command and executes it
            //echo "<br>running ".$cmdstr."<br>";
            global $db_conn, $success;

            $statement = OCIParse($db_conn, $cmdstr);

            if (!$statement) {
                echo "<br>Cannot parse the following command: " . $cmdstr . "<br>";
                $e = OCI_Error($db_conn); // For OCIParse errors pass the connection handle
                echo htmlentities($e['message']);
                $success = False;
            }

            $r = OCIExecute($statement, OCI_DEFAULT);
            if (!$r) {
                echo "<br>Cannot execute the following command: " . $cmdstr . "<br>";
                $e = oci_error($statement); // For OCIExecute errors pass the statementhandle
                echo htmlentities($e['message']);
                $success = False;
            }

			return $statement;
		}

        function executeBoundSQL($cmdstr, $list) {
            /* Sometimes the same statement will be executed several times with different values for the variables involved in the query.
		In this case you don't need to create the statement several times. Bound variables cause a statement to only be
		parsed once and you can reuse the statement. This is also very useful in protecting against SQL injection.
		See the sample code below for how this function is used */

			global $db_conn, $success;
			$statement = OCIParse($db_conn, $cmdstr);

            if (!$statement) {
                echo "<br>Cannot parse the following command: " . $cmdstr . "<br>";
                $e = OCI_Error($db_conn);
                echo htmlentities($e['message']);
                $success = False;
            }

            foreach ($list as $tuple) {
                foreach ($tuple as $bind => $val) {
                    //echo $val;
                    //echo "<br>".$bind."<br>";
                    OCIBindByName($statement, $bind, $val);
                    unset ($val); //make sure you do not remove this. Otherwise $val will remain in an array object wrapper which will not be recognized by Oracle as a proper datatype
				}

                $r = OCIExecute($statement, OCI_DEFAULT);
                if (!$r) {
                    echo "<br>Cannot execute the following command: " . $cmdstr . "<br>";
                    $e = OCI_Error($statement); // For OCIExecute errors, pass the statementhandle
                    echo htmlentities($e['message']);
                    echo "<br>";
                    $success = False;
                }
            }
        }

        function printSportTable($result) { //prints results from a select statement
            echo "<br>Retrieved data from Sport Table:<br>";
            echo "<table>";
            echo "<tr><th>SPORTNAME</th><th>FACILITYUSED</th></tr>";

            while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
                echo "<tr><td>" . $row["SPORTNAME"] . "</td><td>" . $row["FACILITYUSED"] . "</td></tr>"; //or just use "echo $row[0]"
            }

            echo "</table>";
        }

        function printSponsorTable($result) {
            echo "<br>Retrieved data from Sponsor Table:<br>";
            echo "<table>";
            echo "<tr><th>COMPANYNAME</th><th>YEARSPONSORED</th><th>MONETARYAMOUNT</th></tr>";

            while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
                echo "<tr><td>" . $row["COMPANYNAME"] . "</td><td>" . $row["YEARSPONSORED"] . "</td><td>" . $row["MONETARYAMOUNT"] . "</td></tr>"; //or just use "echo $row[0]"
            }

            echo "</table>";
        }

        function printFundsTable($result) {
            echo "<br>Retrieved data from Funds Table:<br>";
            echo "<table>";
            echo "<tr><th>YEARSPONSORED</th><th>COMPANYNAME</th><th>COMPETITORID</th></tr>";

            while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
                echo "<tr><td>" . $row["YEARSPONSORED"] . "</td><td>" . $row["COMPANYNAME"] . "</td><td>" . $row["COMPETITORID"] . "</td></tr>";
            }

            echo "</table>";
        }

        function printCompetitorTable($result) {
            echo "<br>Retrieved data from Competitor Table:<br>";
            echo "<table>";
            echo "<tr><th>COMPETITORID</th><th>MANNEROFPLAY</th></tr>";

            while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
                echo "<tr><td>" . $row["COMPETITORID"] . "</td><td>" . $row["MANNEROFPLAY"] . "</td></tr>";
            }

            echo "</table>";
        }

        function printOlympicGamesTable($result) {
            echo "<br>Retrieved data from OlympicGames Table:<br>";
            echo "<table>";
            echo "<tr><th>YEAR</th><th>LOCATION</th><th>SEASON</th></tr>";

            while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
                echo "<tr><td>" . $row["YEAR"] . "</td><td>" . $row["LOCATION"] . "</td><td>" . $row["SEASON"] . "</td></tr>";
            }

            echo "</table>";
        }

        function printCompetitorID($result) { //prints results from a select statement
            echo "<br>Result of division query:<br>";
            echo "<table>";
            echo "<tr><th>COMPETITORID</th></tr>";

            while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
                echo "<tr><td>" . $row["COMPETITORID"] . "</td></tr>"; //or just use "echo $row[0]"
            }

            echo "</table>";
        }

        function printJoinResult($result) { //prints results from a select statement
            echo "<br>Result of join query:<br>";
            echo "<table>";
            echo "<tr><th>EMPLOYEEID</th></tr>";

            while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
                echo "<tr><td>" . $row["EMPLOYEEID"] . "</td></tr>"; //or just use "echo $row[0]"
            }

            echo "</table>";
        }

        function printGroupByResult($result) { //prints results from a select statement
            echo "<br>Result of groupBy query:<br>";
            echo "<table>";
            echo "<tr><th>MATERIAL</th><th>MAX(COMPENSATION)</th></tr>";

            while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
                echo "<tr><td>" . $row["MATERIAL"] . "</td><td>" . $row["MAX(COMPENSATION)"] . "</td></tr>"; //or just use "echo $row[0]"
            }

            echo "</table>";
        }

        function printHavingResult($result) { //prints results from a select statement
            echo "<br>Result of group by having query:<br>";
            echo "<table>";
            echo "<tr><th>COMPANYNAME</th><th>COUNT(*)</th></tr>";

            while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
                echo "<tr><td>" . $row["COMPANYNAME"] . "</td><td>" . $row["COUNT(*)"] . "</td></tr>"; //or just use "echo $row[0]"
            }

            echo "</table>";
        }

        function printNestedResult($result) { //prints results from a select statement
            echo "<br>Result of group by nested query:<br>";
            echo "<table>";
            echo "<tr><th>AVG(ENGAGEMENT)</th><th>MEDIATYPE</th></tr>";

            while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
                echo "<tr><td>" . $row["AVG(ENGAGEMENT)"] . "</td><td>" . $row["MEDIATYPE"] . "</td></tr>"; //or just use "echo $row[0]"
            }

            echo "</table>";
        }

        function connectToDB() {
            global $db_conn;

            // Your username is ora_(CWL_ID) and the password is a(student number). For example,
			// ora_platypus is the username and a12345678 is the password.
            $db_conn = OCILogon("ora_lindxma", "a94939758", "dbhost.students.cs.ubc.ca:1522/stu");

            if ($db_conn) {
                debugAlertMessage("Database is Connected");
                return true;
            } else {
                debugAlertMessage("Cannot connect to Database");
                $e = OCI_Error(); // For OCILogon errors pass no handle
                echo htmlentities($e['message']);
                return false;
            }
        }

        function disconnectFromDB() {
            global $db_conn;

            debugAlertMessage("Disconnect from Database");
            OCILogoff($db_conn);
        }

        // UPDATE
        function handleUpdateRequest() {
            global $db_conn;

            $sport_name = $_POST['sportName'];
            $new_name = $_POST['newName'];

            executePlainSQL("UPDATE Sport SET facilityUsed='" . $new_name . "' WHERE sportName='" . $sport_name . "'");
            OCICommit($db_conn);
        }

        // DELETE REQUEST
        function handleDeleteRequest() {
            global $db_conn;

            $sponsor_name = $_POST['sponsorName'];
            $year_sponsored = $_POST['yearSponsored'];

            executePlainSQL("DELETE FROM Sponsor WHERE companyName='" . $sponsor_name . "' AND yearSponsored='" . $year_sponsored ."'");
            OCICommit($db_conn);
        }

        // INSERT REQUEST
        function handleInsertRequest() {
            global $db_conn;

            //Getting the values from user and insert data into the table
            $tuple = array (
                ":bind1" => $_POST['insSportName'],
                ":bind2" => $_POST['insFacilityUsed']
            );

            $alltuples = array (
                $tuple
            );

            executeBoundSQL("insert into Sport values (:bind1, :bind2)", $alltuples);
            OCICommit($db_conn);
        }

        function handleSportDisplayRequest() {
            global $db_conn;

            $result = executePlainSQL("SELECT * FROM Sport");
            echo "<br>". printSportTable($result) . "<br>";
        }

        function handleSponsorDisplayRequest() {
            global $db_conn;

            $result = executePlainSQL("SELECT * FROM Sponsor");
            echo "<br>". printSponsorTable($result) . "<br>";
        }

        function handleFundsDisplayRequest() {
            global $db_conn;

            $result = executePlainSQL("SELECT * FROM Funds");
            echo "<br>". printFundsTable($result) . "<br>";
        }

        //Selection
        function handleSelectionRequest() {
            global $db_conn;
            $manner_of_play = $_GET['mannerOfPlay'];

            $result = executePlainSQL("SELECT * FROM Competitor WHERE mannerOfPlay='" . $manner_of_play . "'");
            echo "<br>". printCompetitorTable($result) . "<br>";
        }

        // Projection
        function handleProjectionRequest() {
            global $db_conn;
            $column = $_GET['column'];

            $result = executePlainSQL("SELECT '" . $column . "' FROM OlympicGames WHERE season= 'Winter'");
            echo "<br>". printOlympicGamesTable($result) . "<br>";
        }

        // Division Query
        function handleDivisionRequest() {
            global $db_conn;

            $result = executePlainSQL(
                "SELECT C.competitorID
                FROM Competitor C
                WHERE NOT EXISTS ((SELECT DISTINCT M.material
                                FROM Medal M)
                                MINUS
                                (SELECT W.material
                                FROM Wins W
                                WHERE W.competitorID = C.competitorID))");
            echo "<br>". printCompetitorID($result) . "<br>";
        }

        // Join query
        function handleJoinRequest() {
            global $db_conn;

            $result = executePlainSQL(
                "SELECT EmployeeID
                                FROM Wins w, Competitor c, Athlete a
                                Where w.competitionwonat = '2021 Olympics' AND w.material = 'Bronze'
                                AND c.competitorID = w.competitorID AND c.competitorID = a.competitorID
                                ");
            echo "<br>". printJoinResult($result) . "<br>";
        }

        // Group By query
        function handleGroupByRequest() {
            global $db_conn;

            $result = executePlainSQL(
                "SELECT material, max(compensation)
                From medal
                Group by material
                ");
            echo "<br>". printGroupByResult($result) . "<br>";
        }

        // Group By Having
        function handleHavingRequest() {
            global $db_conn;

            $result = executePlainSQL(
                "SELECT distinct companyname, count(*)
                From funds
                Group by companyname
                Having count(*) > 1
                ");
            echo "<br>". printHavingResult($result) . "<br>";
        }

            // Group By Having
            function handleNestedRequest() {
            global $db_conn;

                $result = executePlainSQL(
                "SELECT avg(engagement), mediaType 
                From mediabroadcast_broadcastedby
                Group by mediaType
                Having avg(engagement) < (SELECT avg(engagement)
                From mediabroadcast_broadcastedby)
                ");
            echo "<br>". printNestedResult($result) . "<br>";
        }

        // HANDLE ALL POST ROUTES
	    // A better coding practice is to have one method that reroutes your requests accordingly. It will make it easier to add/remove functionality.
        function handlePOSTRequest() {
            if (connectToDB()) {
                if (array_key_exists('resetTablesRequest', $_POST)) {
                    handleResetRequest();
                } else if (array_key_exists('updateQueryRequest', $_POST)) {
                    handleUpdateRequest();
                } else if (array_key_exists('insertQueryRequest', $_POST)) {
                    handleInsertRequest();
                } else if (array_key_exists('deleteTupleRequest', $_POST)) {
                    handleDeleteRequest();
                } else if (array_key_exists('selection', $_GET)) {
                    handleSelectionRequest();
                }

                disconnectFromDB();
            }
        }

        // HANDLE ALL GET ROUTES
	// A better coding practice is to have one method that reroutes your requests accordingly. It will make it easier to add/remove functionality.
        function handleGETRequest() {
            if (connectToDB()) {
                if (array_key_exists('countTuples', $_GET)) {
                    handleCountRequest();
                } else if (array_key_exists('displaySportTuples', $_GET)) {
                    handleSportDisplayRequest();
                } else if (array_key_exists('divisionQuery', $_GET)) {
                    handleDivisionRequest();
                } else if (array_key_exists('displaySponsorTuples', $_GET)) {
                    handleSponsorDisplayRequest();
                } else if (array_key_exists('displayFundsTuples', $_GET)) {
                    handleFundsDisplayRequest();
                } else if (array_key_exists('joinQuery', $_GET)) {
                    handleJoinRequest();
                } else if (array_key_exists('groupByQuery', $_GET)) {
                    handleGroupByRequest();
                } else if (array_key_exists('havingQuery', $_GET)) {
                    handleHavingRequest();
                } else if (array_key_exists('mannerOfPlay', $_GET)) {
                    handleSelectionRequest();
                } else if (array_key_exists('selection', $_GET)) {
                    handleSelectionRequest();
                } else if (array_key_exists('column', $_GET)) {
                    handleProjectionRequest();
                } else if (array_key_exists('projection', $_GET)) {
                    handleProjectionRequest();
                } else if (array_key_exists('nestedQuery', $_GET)) {
                    handleNestedRequest();
                }


                disconnectFromDB();
            }
        }

	if (isset($_POST['reset']) || isset($_POST['updateSubmit']) || isset($_POST['insertSubmit'])) {
      handlePOSTRequest();
    } else if (
        isset($_GET['displaySportTuples'])
        || isset($_GET['divisionQuery'])
        || isset($_GET['joinQuery'])
        || isset($_GET['groupByQuery'])
        || isset($_GET['havingQuery'])
        || isset($_GET['nestedQuery'])
        || isset($_GET['displayFundsTuples'])
        || isset($_GET['displaySponsorTuples'])
        || isset($_GET['mannerOfPlay'])
        || isset($_GET['column']))
    {
      handleGETRequest();
    }
		?>
	</body>
</html>