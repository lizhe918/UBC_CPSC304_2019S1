<?php
require_once "pdo_constructor.php";

$startDate = date('Y', strtotime('-1 year')) . '-01-01';
$endDate = date("Y") . '-12-31';

function seasonMinMax($fn, $r1, $r2, $r3, $r4)
{
    switch ($fn) {
        case $r1:
            return 'Winter';
        case $r2:
            return 'Spring';
        case $r3:
            return 'Summer';
        case $r4:
            return 'Autumn';
        default:
    }
}

$username = $_COOKIE['zyxwdirector'];
$sql = "SELECT * FROM Director WHERE username = '$username'";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC);
$eid = $user['employID'];
$sql = "SELECT * FROM Employee WHERE employID = '$eid'";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$director = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>
        <?php
        echo $username . "'s Dashboard";
        ?>
    </title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="./css/usermain.css">
    <link rel="stylesheet" type="text/css" href="./css/footer.css">
    <link rel="stylesheet" type="text/css" href="./css/profile.css">
    <link rel="stylesheet" type="text/css" href="./css/table.css">
    <link rel="stylesheet" type="text/css" href="./css/navbar.css">
    <link rel="stylesheet" type="text/css" href="./css/logout.css">
    <link rel="stylesheet" type="text/css" href="./css/input_button.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

</head>

<body>
    <section class="navbar" style="z-index: 101;">
        <div class="items" id="mainbar">
            <a href="./index.php#home" id="brandlabel">ZYXW STORAGE</a>
            <a href="./index.php#about">ABOUT</a>
            <a href="./index.php#contact">CONTACT</a>
            <a href="./plans.php">PLANS</a>
            <a href="./elogin.php">EMPLOYEE</a>
            <a href="./logout.php" id="logout">LOG OUT</a>
            <a href="javascript:void(0);" class="icon" onclick="mobileExpandMain()">
                <i class="fa fa-bars"></i>
            </a>
        </div>
    </section>
    <section class="row">
        <div class="column profile">
            <h1>Welcome!</h1>
            <div class="username">
                <h2>
                    <?php
                    echo ($director['fName'] . " " . $director['lName']);
                    ?>
                </h2>
                <p>
                    <?php
                    echo ($_COOKIE['zyxwdirector']);
                    ?>
                </p>
            </div>
            <div class="info">
                <p><img src="https://img.icons8.com/metro/420/phone.png">
                    <?php
                    echo ($director['phoneNum']);
                    ?>
                </p>
                <p><img src="https://cdn4.iconfinder.com/data/icons/maps-and-navigation-solid-icons-vol-1/72/19-512.png">
                    <?php
                    echo ($director['address']);
                    ?>
                </p>
                <p><img src="https://cdn3.iconfinder.com/data/icons/business-office-1-2/256/Identity_Document-512.png">
                    <?php
                    echo ($director['SINNum']);
                    ?>
                </p>
                <p><img src="https://cdn1.iconfinder.com/data/icons/education-set-01/512/email-open-512.png">
                    <?php
                    echo ($director['email']);
                    ?>
                </p>
                <a class="linkbutton" href="mupdate.php">Edit Profile</a>
            </div>
        </div>
        <div class="column function">
            <div class="navbar" style="position: relative;">
                <div class="items" id="funcbar">
                    <a href="dviewa.php">Dashboard</a>
                    <a href="dviewe.php">Employees</a>
                    <a href="dviewb.php">Branches</a>
                    <a href="dviews.php">Storerooms</a>
                    <a href="dviewc.php">Customers</a>
                    <a href="dviewt.php">Transactions</a>

                    <a href="javascript:void(0);" class="icon" onclick="mobileExpandFunc()">
                        <i class="fa fa-bars"></i>
                    </a>
                </div>
            </div>
            <div class="tableblock" style="background-color: white;">
                <h2>At a Glance</h2>
                <div class="thetable" style="width: 90%; padding-bottom: 0;">
                    <table class="entities" style="width:100%">
                        <tr>
                            <th>New Customers | YTD</th>
                            <th>Total Revenue (CAD)</th>
                            <th>Average Weekly Revenue (CAD)</th>
                        </tr>
                        <?php

                        $q1 = "SELECT COUNT(DISTINCT username) AS count FROM Customer C, ItemInfo I, Agreement A
                        WHERE I.agrmtNum = A.agrmtNum AND C.username = I.owner
                        AND startDay BETWEEN '$startDate' AND '$endDate'";
                        $q2 = "SELECT SUM(amount) AS rev FROM Payment P, Agreement A WHERE A.payment = P.payNum
                        AND startDay BETWEEN '$startDate' AND '$endDate'";
                        $q3 = "SELECT SUM(amount) AS rev FROM Payment P, Reservation R WHERE R.payment = P.payNum
                        AND startDay BETWEEN '$startDate' AND '$endDate'";
                        $q5 = "SELECT COUNT(*) AS count FROM (SELECT username FROM Customer C, ItemInfo I, Agreement A
                        WHERE I.agrmtNum = A.agrmtNum AND C.username = I.owner
                        AND startDay BETWEEN '$startDate' AND '$endDate'
                        GROUP BY username
                        HAVING COUNT(username) > 1) AS R";
                        $q6 = "SELECT COUNT(*) as count FROM Branch";
                        $q7 = "SELECT COUNT(DISTINCT C.username) as count FROM Customer C, ItemInfo I, Agreement A WHERE I.agrmtNum = A.agrmtNum
                        AND C.username = I.owner AND startDay BETWEEN '$startDate' AND '$endDate'";
                        $s1 = $pdo->prepare($q1);
                        $s2 = $pdo->prepare($q2);
                        $s3 = $pdo->prepare($q3);
                        $s5 = $pdo->prepare($q5);
                        $s6 = $pdo->prepare($q6);
                        $s7 = $pdo->prepare($q7);
                        $s1->execute();
                        $s2->execute();
                        $s3->execute();
                        $s5->execute();
                        $s6->execute();
                        $s7->execute();
                        $r1 = $s1->fetch(PDO::FETCH_ASSOC);
                        $r2 = $s2->fetch(PDO::FETCH_ASSOC);
                        $r3 = $s3->fetch(PDO::FETCH_ASSOC);
                        $r5 = $s5->fetch(PDO::FETCH_ASSOC);
                        $r6 = $s6->fetch(PDO::FETCH_ASSOC);
                        $r7 = $s7->fetch(PDO::FETCH_ASSOC);

                        echo "<tr><td>";
                        echo ($r1 = $r1['count']);
                        echo "</td><td rowspan='3'>";
                        echo ($r4 = $r2['rev'] + $r3['rev']);
                        echo ("</td><td>");
                        echo (number_format($r4 / 52, 2, '.', ''));
                        echo ("</td></tr><tr><th>Returning Customers | YTD</th><th>Average Branch Revenue (CAD) | YTD</th><tr><td>");
                        echo ($r5 = $r5['count']);
                        echo "</td><td>";
                        echo ($r4 / $r6['count']);

                        $new = $r1;
                        $returning = $r5;
                        $allc = $r7['count'];
                        $belowtarget = 36000 - $r4;
                        ?>
                    </table>
                    <h3>Analysis</h3>
                    <?php
                    $d1 = date('Y', strtotime('-1 year')) . '-12-21';
                    $d2 = date('Y') . '-03-19';
                    $q1 = "SELECT COUNT(*) FROM Agreement WHERE startDay BETWEEN '$d1' AND '$d2'";
                    $s1 = $pdo->prepare($q1);
                    $s1->execute();
                    $r1 = $s1->fetch(PDO::FETCH_ASSOC);
                    $d1 = date('Y') . '-03-20';
                    $d2 = date('Y') . '-06-21';
                    $q1 = "SELECT COUNT(*) FROM Agreement WHERE startDay BETWEEN '$d1' AND '$d2'";
                    $s1 = $pdo->prepare($q1);
                    $s1->execute();
                    $r2 = $s1->fetch(PDO::FETCH_ASSOC);
                    $d1 = date('Y') . '-06-22';
                    $d2 = date('Y') . '-09-23';
                    $q1 = "SELECT COUNT(*) FROM Agreement WHERE startDay BETWEEN '$d1' AND '$d2'";
                    $s1 = $pdo->prepare($q1);
                    $s1->execute();
                    $r3 = $s1->fetch(PDO::FETCH_ASSOC);
                    $d1 = date('Y') . '-09-24';
                    $d2 = date('Y') . '-12-21';
                    $q1 = "SELECT COUNT(*) FROM Agreement WHERE startDay BETWEEN '$d1' AND '$d2'";
                    $s1 = $pdo->prepare($q1);
                    $s1->execute();
                    $r4 = $s1->fetch(PDO::FETCH_ASSOC);
                    $q5 = "SELECT A.branchID AS branchID, RT.typeName, SUM(free) AS free FROM Room_Type RT, (SELECT branchID, roomNum, (maxSpace - sum) AS free
                    FROM (SELECT U.BranchID, U.roomNum, maxSpace, SUM(space) as sum FROM UsedSpace U, Storeroom S WHERE U.roomNum = S.roomNum
                    AND U.branchID = S.branchID GROUP BY U.branchID, U.roomNum, maxSpace) A) A WHERE A.branchID = RT.branchID AND A.roomNum = RT.roomNum
                    GROUP BY A.branchID, A.roomNum, typeName ORDER BY A.branchID, typeName";
                    $s5 = $pdo->prepare($q5);
                    $s5->execute();
                    while ($r5 = $s5->fetch(PDO::FETCH_ASSOC)) {
                        $bid = $r5['branchID'];
                        $tn = $r5['typeName'];
                        $free = $r5['free'];
                        if ($free < 30) {
                            echo '<p>There is limited ' . $tn . ' space left at branch ' . $bid . '. Requires attention immediately!</p>';
                        }
                    }

                    if ($returning / $allc < 0.35) {
                        echo '<p>Your YTD ratio of repeat customers is low. Focus on customer retention!</p>';
                    }
                    if ($new / $allc < 0.2) {
                        echo '<p>Your YTD ratio of new customers is low. Focus on marketing!</p>';
                    }
                    $d1 = date('Y-m-d');
                    if (($d1 > date('Y') . '-10-01') && ($d1 < date('Y') . '12-31')) {
                        echo '<p>The end of the year is approaching. The company is below the YTD sales target by $' . $belowtarget . '. Focus on upselling!</p>';
                    }
                    echo '<p>Customers are storing the most items during the ' . seasonMinMax(max($r1, $r2, $r3, $r4), $r1, $r2, $r3, $r4) . ' and the least items during ' . seasonMinMax(min($r1, $r2, $r3, $r4), $r1, $r2, $r3, $r4) . '.</p>';

                    ?>

                </div>
                <br>
                <hr>

                <h2>Top Performers</h2>
                <h3>By Location</h3>
                <div class="thetable" style="width: 90%;">
                    <table class="entities" style="width: 100%;">
                        <tr>
                            <th>Branch ID</th>
                            <th>Branch Address</th>
                            <th>Revenue (CAD)</th>
                        </tr>
                        <?php
                        $q1 = "SELECT BB.BranchID, address, rev FROM Branch, (SELECT AA.branch AS branchID, (AA.r1 + B.r2) AS rev FROM (SELECT I.branch, SUM(amount) AS R1
                        FROM Payment P, Agreement A, ItemInfo I WHERE A.payment = P.payNum AND I.agrmtNum = A.agrmtNum
                        AND startDay BETWEEN '$startDate' AND '$endDate'
                        GROUP BY branch) AS AA INNER JOIN (SELECT R.branch, SUM(amount) AS R2 FROM Payment P, Reservation R WHERE R.payment = P.payNum
                        AND startDay BETWEEN '$startDate' AND '$endDate'
                        GROUP BY R.branch) B on AA.branch = B.branch) AS BB
                        WHERE BB.branchID = Branch.branchID
                        ORDER BY rev DESC";
                        $s1 = $pdo->prepare($q1);
                        $s1->execute();

                        for ($i = 0; $i < 3; $i++) {
                            $row = $s1->fetch(PDO::FETCH_ASSOC);
                            echo "<tr><td>";
                            echo ($row['branchID']);
                            echo ("</td><td>");
                            echo ($row['address']);
                            echo ("</td><td>");
                            echo ($row['rev']);
                        }
                        ?>
                    </table>
                    <br>
                    <h3>By Item Types</h3>
                    <table class="entities" style="width: 100%;">
                        <tr>
                            <th>Item Type</th>
                            <th>Revenue</th>
                        </tr>
                        <?php
                        $q1 = "SELECT typeName, SUM(amount) AS rev FROM ItemClass I, (SELECT A.agrmtNum, I.itemNum, A.amount FROM Item I,
                        (SELECT A.Payment, A.agrmtNum, P.amount FROM Agreement A, Payment P WHERE A.payment = P.payNum
                        AND A.startDay BETWEEN '$startDate' AND '$endDate') A WHERE I.agrmtNum = A.agrmtNum) A
                        WHERE I.itemNum = A.itemNum GROUP BY typeName ORDER BY rev DESC";
                        $s1 = $pdo->prepare($q1);
                        $s1->execute();
                        while ($row = $s1->fetch(PDO::FETCH_ASSOC)) {
                            echo "<tr><td>";
                            echo ($row['typeName']);
                            echo ("</td><td>");
                            echo ($row['rev']);
                        }
                        ?>
                    </table>
                    <br>
                    <h3>Top Grossing Customers</h3>
                    <table class="entities" style="width: 100%;">
                        <tr>
                            <th>Username</th>
                            <th>Name</th>
                            <th>Main Branch</th>
                            <th>Transactions</th>
                            <th>Amount Spent (CAD) | YTD</th>
                        </tr>
                        <?php
                        $q1 = "SELECT A3.owner, C.fName, C.lName, A3.address, SUM(A3.rev) AS rev, COUNT(A3.branch) AS count FROM Customer C, (SELECT A2.owner, BB.address, A2.rev, A2.branch 
                        FROM Branch BB, (SELECT A1.owner, A1.branch, A1.amount AS rev FROM
                        (SELECT I.owner, P1.payNum, P1.amount, I.branch FROM Agreement A, Payment P1, ItemInfo I WHERE A.payment = P1.payNum AND I.agrmtNum = A.agrmtNum
                        AND A.startDay BETWEEN '2019-01-01' AND '2019-12-31'
                        UNION
                        SELECT R.reserver, P.payNum, P.amount, R.branch FROM Reservation R, Payment P WHERE R.payment = P.payNum AND R.startDay BETWEEN '2019-01-01'
                        AND '2019-12-31') A1) A2 WHERE BB.branchID = A2.branch) A3 WHERE C.username = A3.owner GROUP BY C.fName, C.lName, A3.owner, A3.address ORDER BY rev DESC";
                        $s1 = $pdo->prepare($q1);
                        $s1->execute();
                        for ($i = 0; $i < 3; $i++) {
                            $row = $s1->fetch(PDO::FETCH_ASSOC);
                            echo "<tr><td>";
                            echo ($row['owner']);
                            echo "</td><td>";
                            echo ($row['fName'] . ' ' . $row['lName']);
                            echo ("</td><td>");
                            echo ($row['address']);
                            echo ("</td><td>");
                            echo ($row['count']);
                            echo ("</td><td>");
                            echo ($row['rev']);
                        }
                        ?>
                    </table>
                    <br>
                    <hr>
                    <h2>Worst Performers</h2>
                    <h3>By Location</h3>
                    <table class="entities" style="width: 100%;">
                        <tr>
                            <th>Branch ID</th>
                            <th>Branch Address</th>
                            <th>Revenue (CAD)</th>
                        </tr>
                        <?php
                        $q1 = "SELECT BB.branchID, address, rev FROM Branch, (SELECT AA.branch AS branchID, (AA.r1 + B.r2) AS rev FROM (SELECT I.branch, SUM(amount) AS R1
                        FROM Payment P, Agreement A, ItemInfo I WHERE A.payment = P.payNum AND I.agrmtNum = A.agrmtNum
                        AND startday BETWEEN '$startDate' AND '$endDate'
                        GROUP BY branch) AS AA INNER JOIN (SELECT R.Branch, SUM(amount) AS R2 FROM Payment P, Reservation R WHERE R.payment = P.payNum
                        AND startday BETWEEN '$startDate' AND '$endDate'
                        GROUP BY R.branch) B on AA.branch = B.branch) AS BB
                        WHERE BB.branchID = Branch.branchID
                        ORDER BY rev ASC";
                        $s1 = $pdo->prepare($q1);
                        $s1->execute();

                        for ($i = 0; $i < 3; $i++) {
                            $row = $s1->fetch(PDO::FETCH_ASSOC);
                            echo "<tr><td>";
                            echo ($row['branchID']);
                            echo ("</td><td>");
                            echo ($row['address']);
                            echo ("</td><td>");
                            echo ($row['rev']);
                        }
                        ?>
                    </table>
                </div>

            </div>
        </div>
    </section>





    <section class="footer-container">
        <div class="footer">
            <a href="https://github.com/lizhe918/UBC_CPSC304_2019S1">
                <img src="https://image.flaticon.com/icons/svg/25/25231.svg">
            </a>
            <a href="https://www.ubc.ca/">
                <img src="https://bcchdigital.ca/wp-content/uploads/2018/11/ubc-emblem-black.png">
            </a>
            <a href="https://www.cs.ubc.ca/">
                <img src="https://avatars0.githubusercontent.com/u/22601447?s=200&v=4">
            </a>
        </div>
    </section>
    <script>
        function mobileExpandMain() {
            var x = document.getElementById("mainbar");
            if (x.className === "items") {
                x.className += " responsive";
            } else {
                x.className = "items";
            }
        }

        function mobileExpandFunc() {
            var x = document.getElementById("funcbar");
            if (x.className === "items") {
                x.className += " responsive";
            } else {
                x.className = "items";
            }
        }
    </script>
</body>

</html>
