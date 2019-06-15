<?php
require_once "pdo_constructor.php";

/*
 *  Return the tuples with branchID, room number ($rid), the room's maximum space, and available space
 *  between two given dates ($start, $end) where the available space is greater than the reserve space ($rsv).
 */
function queryAvailableSpaceWithinDates($start, $end, $rsv) {
    $sql = "select s.branchid as branchID, s.roomnum as roomNum, s.maxSpace, (s.maxSpace - used) as Available
                from storeroom s, (select branchid, roomnum, max(space) as used
                from usedspace
                where date between '$start' and '$end'
                group by branchid, roomnum) r
                where s.branchID = r.branchID and s.roomNum = r.roomNum and (s.maxSpace - used) >= $rsv";
    return $sql;
}

/*
 *  Return the tuples for room types that have been flagged.
 */
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

/*
 *  Intersect the tables returned from the queries from
 *  queryAvailableSpaceWithinDates() and queryBranchRoomsSelectedTypes()
 *  and return the necessary tuple information.
 */
function queryFilteredRooms($start, $end, $rsv, $rglr, $flam, $frzn, $frgl) {
    $q1 = queryAvailableSpaceWithinDates($start, $end, $rsv);
    $q2 = queryBranchRoomsSelectedTypes($rglr, $flam, $frzn, $frgl);
    $q3 = "(select a.branchID, a.roomNum, a.maxSpace, a.Available from (" . $q1 . ") a inner join (" . $q2 . ") z where a.branchID = z.branchID and a.roomNum = z.roomNum) b";
    $q4 = "select address, c.roomNum, typeName, c.maxSpace, Available from (select b.branchID, roomNum, typeName, maxSpace, Available from " . $q3 . 
            " natural join Room_Type) c inner join branch br, storeroom sr where br.branchID = sr.branchID and sr.roomNum = c.roomNum and c.branchID = sr.branchID";
    return $q4;
};
