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
                <h2>At A Glance</h2>
                <div class="thetable" style="width: 90%; padding-bottom: 0;">
                    <table class="entities" style="width:100%">
                        <tr>
                            <th>New Customers | YTD</th>
                            <th>Total Revenue (CAD)</th>
                            <th>Average Weekly Revenue (CAD)</th>
                        </tr>
                        <?php

                        $q1 = "SELECT count(DISTINCT username) as count FROM customer c, iteminfo i, agreement a
                        WHERE i.agrmtNum = a.agrmtNum AND c.username = i.owner
                        AND startday BETWEEN '$startDate' AND '$endDate'";
                        $q2 = "SELECT sum(amount) as rev FROM payment p, agreement a WHERE a.payment = p.payNum
                        AND startday BETWEEN '$startDate' AND '$endDate'";
                        $q3 = "SELECT sum(amount) as rev FROM payment p, reservation r WHERE r.payment = p.payNum
                        AND startday BETWEEN '$startDate' AND '$endDate'";
                        $q5 = "SELECT count(*) as count FROM (SELECT username as count FROM customer c, iteminfo i, agreement a
                        WHERE i.agrmtNum = a.agrmtNum AND c.username = i.owner
                        AND startday BETWEEN '$startDate' AND '$endDate'
                        group by username
                        having count(username) > 1) as r";
                        $q6 = "SELECT count(*) as count FROM branch";
                        $q7 = "SELECT count(*) as count FROM customer where '$startDate' AND '$endDate'";
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
                    $q1 = "SELECT count(*) FROM agreement a WHERE startDay BETWEEN '$d1' AND '$d2'";
                    $s1 = $pdo->prepare($q1);
                    $s1->execute();
                    $r1 = $s1->fetch(PDO::FETCH_ASSOC);
                    $d1 = date('Y') . '-03-20';
                    $d2 = date('Y') . '-06-21';
                    $q1 = "SELECT count(*) FROM agreement a WHERE startDay BETWEEN '$d1' AND '$d2'";
                    $s1 = $pdo->prepare($q1);
                    $s1->execute();
                    $r2 = $s1->fetch(PDO::FETCH_ASSOC);
                    $d1 = date('Y') . '-06-22';
                    $d2 = date('Y') . '-09-23';
                    $q1 = "SELECT count(*) FROM agreement a WHERE startDay BETWEEN '$d1' AND '$d2'";
                    $s1 = $pdo->prepare($q1);
                    $s1->execute();
                    $r3 = $s1->fetch(PDO::FETCH_ASSOC);
                    $d1 = date('Y') . '-09-24';
                    $d2 = date('Y') . '-12-21';
                    $q1 = "SELECT count(*) FROM agreement a WHERE startDay BETWEEN '$d1' AND '$d2'";
                    $s1 = $pdo->prepare($q1);
                    $s1->execute();
                    $r4 = $s1->fetch(PDO::FETCH_ASSOC);
                    $q5 = "SELECT a.branchID as branchID, rt.typeName, sum(free) as free FROM room_type rt, (SELECT branchID, roomNum, (maxSpace - sum) as free 
                    FROM (SELECT u.branchID, u.roomNum, maxSpace, sum(space) as sum FROM usedspace u, storeroom s WHERE u.roomNum = s.roomNum 
                    AND u.branchID = s.branchID GROUP BY u.branchID, u.roomNum, maxSpace) a) a WHERE a.branchID = rt.branchID AND a.roomNum = rt.roomNum 
                    GROUP BY a.branchID, a.roomNum, typeName ORDER BY a.branchID, typeName";
                    $s5 = $pdo->prepare($q5);
                    $s5->execute();
                    while ($r5 = $s5->fetch(PDO::FETCH_ASSOC)) {
                        $bid = $r5['branchID'];
                        $tn = $r5['typeName'];
                        $free = $r5['free'];
                        if ($free < 30) {
                            echo '<p>There is limited ' . $tn . ' space left at Branch ' . $bid . '. Requires attention immediately!</p>';
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
                        $q1 = "SELECT bb.branchID, address, rev FROM branch, (SELECT aa.branch as branchID, (aa.r1 + b.r2) as rev FROM (SELECT i.branch, sum(amount) as r1 
                        FROM payment p, agreement a, iteminfo i WHERE a.payment = p.payNum AND i.agrmtNum = a.agrmtNum
                        AND startday BETWEEN '$startDate' AND '$endDate'
                        GROUP BY branch) as aa INNER JOIN (SELECT r.branch, sum(amount) as r2 FROM payment p, reservation r WHERE r.payment = p.payNum
                        AND startday BETWEEN '$startDate' AND '$endDate'
                        GROUP BY r.branch) b on aa.branch = b.branch) as bb
                        WHERE bb.branchID = branch.branchID
                        ORDER BY rev desc";
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
                        $q1 = "SELECT typeName, sum(amount) as rev FROM itemclass i, (SELECT a.agrmtNum, i.itemNum, a.amount FROM item i, 
                        (SELECT a.payment, a.agrmtNum, p.amount FROM agreement a, payment p WHERE a.payment = p.payNum
                        AND a.startDay BETWEEN '$startDate' AND '$endDate') a WHERE i.agrmtNum = a.agrmtNum) a 
                        WHERE i.itemNum = a.itemNum GROUP BY typeName ORDER BY rev DESC";
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
                        $q1 = "SELECT a.owner, c.fName, c.lName, a.address, sum(a.rev) as rev, count(a.branch) as c FROM customer c, (SELECT a.owner, b.address, a.rev,a.branch FROM branch b, (SELECT a.owner, a.branch, a.amount as rev FROM 
                        (SELECT i.owner, p.payNum, p.amount, i.branch FROM agreement a, payment p, iteminfo i WHERE a.payment = p.payNum AND i.agrmtNum = a.agrmtNum 
                        AND a.startDay BETWEEN '2019-01-01' AND '2019-12-31' 
                        UNION
                        SELECT r.reserver, p.payNum, p.amount, r.branch FROM reservation r, payment p WHERE r.payment = p.payNum AND r.startDay BETWEEN '2019-01-01' 
                        AND '2019-12-31') a) a WHERE b.branchID = a.branch) a WHERE c.username = a.owner GROUP BY c.fName, c.lName, a.owner, a.address ORDER BY rev DESC";
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
                            echo ($row['c']);
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
                        $q1 = "SELECT bb.branchID, address, rev FROM branch, (SELECT aa.branch as branchID, (aa.r1 + b.r2) as rev FROM (SELECT i.branch, sum(amount) as r1 
                        FROM payment p, agreement a, iteminfo i WHERE a.payment = p.payNum AND i.agrmtNum = a.agrmtNum
                        AND startday BETWEEN '$startDate' AND '$endDate'
                        GROUP BY branch) as aa INNER JOIN (SELECT r.branch, sum(amount) as r2 FROM payment p, reservation r WHERE r.payment = p.payNum
                        AND startday BETWEEN '$startDate' AND '$endDate'
                        GROUP BY r.branch) b on aa.branch = b.branch) as bb
                        WHERE bb.branchID = branch.branchID
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