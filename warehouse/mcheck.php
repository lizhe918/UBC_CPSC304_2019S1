<?php
require_once "pdo_constructor.php";

/*
 *  Return the tuples with branchID, room number ($rid), the room's maximum space, and available space
 *  between two given dates ($start, $end) where the available space is greater than the reserve space ($rsv).
 */
function queryAvailableSpaceWithinDates($start, $end, $rsv)
{
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
 *  Return all empty rooms that are greater than the reserve space
 */
function queryEmptyRooms($rsv)
{
    $sql = "select distinct sr.branchid, sr.roomnum, sr.maxSpace, sr.maxSpace as Available
    from storeroom sr
    where sr.maxSpace >= $rsv and not exists (
        select 1 from usedspace us
        where sr.branchid = us.branchid
          and sr.roomnum = us.roomnum
    )";
    return $sql;
}

/*
 *  Intersect the tables returned from the queries from
 *  queryAvailableSpaceWithinDates() and queryBranchRoomsSelectedTypes()
 *  and return the necessary tuple information.
 */
function queryFilteredRooms($start, $end, $rsv, $rglr, $flam, $frzn, $frgl)
{
    $q1 = queryAvailableSpaceWithinDates($start, $end, $rsv);
    $q2 = queryBranchRoomsSelectedTypes($rglr, $flam, $frzn, $frgl);
    $q3 = queryEmptyRooms($rsv);
    // union $q1 and $q2, returns tuples that are available between specified dates and empty rooms
    $q4 = $q1 . " union " . $q3;
    // return tuples that meet the previous requirement and can store the chosen types of items
    $q5 = "select a.branchid, a.roomnum, a.maxspace, a.available from (" . $q4 . ") a inner join (" . $q2 . ") z where a.branchid = z.branchid and a.roomnum = z.roomnum";
    // join with room_type and return the previous attributes + the room's type
    $q6 = "select b.branchid, b.roomnum, typename, b.maxspace, b.available from (" . $q5 . ") b inner join room_type rt where rt.branchid = b.branchid and rt.roomnum = b.roomnum";
    $q7 = "select br.address as address, sr.roomnum as roomNum, c.typename as typeName, sr.maxspace as maxSpace, c.available as available from (" . $q6 . ") c inner join branch br, storeroom sr where br.branchid = sr.branchid and sr.branchid = c.branchid and sr.roomnum = c.roomnum";
    return $q7;
}
