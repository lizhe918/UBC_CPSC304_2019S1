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
    $q4 = "select brr.address, c.roomNum, c.typeName, c.maxSpace, c.Available from (select b.branchID, b.roomNum, rt.typeName, b.maxSpace, b.Available from (select a.branchID, a.roomNum, a.maxSpace, a.Available from (" . $q1 . ") a inner join (" . $q2 . ") z where a.branchID = z.branchID and a.roomNum = z.roomNum";
    $sql = $q4 . ") b inner join room_type rt where b.branchid = rt.branchid and b.roomnum = rt.roomnum
            union		
            select y.branchid, y.roomnum, rtt.typename, y.maxSpace, y.Available from (" . $q3 . ") y inner join room_type rtt		
            where rtt.branchID = y.branchID and rtt.roomNum = y.roomNum) c		
            inner join branch brr, storeroom stt where stt.branchID = brr.branchID and stt.branchID = c.branchID and stt.roomNum = c.roomNum";
    return $sql;
}
