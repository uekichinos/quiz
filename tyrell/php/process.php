<?php
/** config & define */
$no_people = $_POST['total'];
$cards = [1 => 'A', 2, 3, 4, 5, 6, 7, 8, 9,  10 => 'X', 11 => 'J', 12 => 'Q', 13 => 'K'];
$types = ['S', 'H', 'D', 'C'];
$fullset_cards = [];
$people_with_cards = [];
$iserror = false;

/** validate value from form */
if(!isset($no_people) || !is_numeric($no_people) || $no_people <= 0) {
    $return = array('status' => 'error', 'message' => 'Input value does not exist or value is invalid');
    $iserror = true;
}

if($iserror === false) {

    /** prepare to generate complete set of cards (4 x 13 = 52) */
    foreach($types as $type) {
        foreach($cards as $no => $card) {
            $fullset_cards[] = $type."-".($no != $card ? $card : $no);
        }
    }

    /** assign random cards to peoples */
    while (count($fullset_cards) > 0) {

        $count = 0;
        while($count < $no_people) {

            /** in case no more card, exit from loop */
            if(count($fullset_cards) <= 0) break;

            /** assign selected random card to $people_with_cards and unset */
            $rand = array_rand($fullset_cards, 1);
            $people_with_cards[$count][] = $fullset_cards[$rand];
            unset($fullset_cards[$rand]);

            $count++;
        }
    }

    $return = array('status' => 'success', 'records' => $people_with_cards);
}

/** print result */
echo json_encode($return);
exit;
?>