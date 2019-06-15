<?php
require_once "pdo_constructor.php";

// Produce the available space of a storeroom, within the given time interval
// $bid is the branch id
// $rid is the room id
// $start is the start date
// $end is the date end
// produce a real number
function queryAvailableSpaceWithinDates($bid, $rid, $start, $end) {
    $sql = "select s.branchid as branchID, s.roomnum as roomNum, s.maxSpace, (s.maxSpace - used) as Available
                from storeroom s, (select branchid, roomnum, max(space) as used
                from usedspace
                where date between '$start' and '$end'
                group by branchid, roomnum) r
                where s.branchID = r.branchID and s.roomNum = r.roomNum";
    return $sql;
}

function queryBranchRoomsSelectedTypes($rglr, $flam, $frzn, $frgl)
{
    $types = "SELECT * FROM ItemType WHERE false OR ";
    if (isset($rglr)) {
        $types = $types . "typeName = 'RGLR' OR ";
    }
    if (isset($flam)) {
        $types = $types . "typeName = 'FLAM' OR ";
    }
    if (isset($frzn)) {
        $types = $types . "typeName = 'FRZN' OR ";
    }
    if (isset($frgl)) {
        $types = $types . "typeName = 'FRGL' OR ";
    }
    $types = $types . 'false';

    $sql = "SELECT branchID, roomNum, maxSpace FROM Storeroom S
        WHERE NOT EXISTS
        (SELECT T.typeName FROM (" . $types . ") T
         WHERE T.typeName NOT IN
         (SELECT R.typeName FROM Room_Type R
          WHERE R.branchID = S.branchID AND R.roomNum = S.roomNum))";
    return $sql;
}

function queryFilteredRooms($bid, $rid, $start, $end, $rglr, $flam, $frzn, $frgl) {
    $q1 = queryAvailableSpaceWithinDates($bid, $rid, $start, $end);
    $q2 = queryBranchRoomsSelectedTypes($rglr, $flam, $frzn, $frgl);
    $q3 = "(select a.branchID, a.roomNum, a.maxSpace, a.Available from (" . $q1 . ") a inner join (" . $q2 . ") z where a.branchID = z.branchID and a.roomNum = z.roomNum) b";
    $q4 = "select * from " . $q3 . " natural join Room_Type";
    return $q4;
};
