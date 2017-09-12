<?php

    // set up building instant
    $build01 = new Building();
    $build01->title = "อาคารที่พักอาศัยข้าราชการศาลยุติธรรม ซอยเสนานิคม 1";
    $b1l1 = new LevelGroup("ระดับปฏิบัติงาน",[9]);
    $b1l2 = new LevelGroup("ระดับปฏิบัติการ",[6]);
    $b1l3 = new LevelGroup("ระดับชำนาญงาน และชำนาญการขึ้นไป",[1,2,3,4,5,8]);
    $build01->groups = array($b1l1,$b1l2,$b1l3);

    $build02 = new Building();
    $build02->title = "อาคารชุดที่พักอาศัยข้าราชการศาลยุติธรรม จำนวน 50 หน่วย (ตลิ่งชัน)";
    $b2l1 = new LevelGroup("ระดับปฏิบัติงาน / ชำนาญงาน / ปฏิบัติการ",[6,8,9]);
    $b2l2 = new LevelGroup("ระดับชำนาญการ / ชำนาญการพิเศษ",[5,4]);
    $build02->groups = array($b2l1,$b2l2);

    $build03 = new Building();
    $build03->title = "อาคารชุดที่พักอาศัยข้าราชการศาลยุติธรรม จำนวน 96 หน่วย (ตลิ่งชัน)";
    $b3l1 = new LevelGroup("ระดับปฏิบัติงาน",[9]);
    $b3l2 = new LevelGroup("ระดับชำนาญงาน / ปฏิบัติการ",[6,8]);
    $build03->groups = array($b3l1,$b3l2);

    //user this
    $buildings = array($build01,$build02,$build03);

    
?>