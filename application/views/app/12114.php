<?php

//Calculates the weekly coins issued:
$e___14874 = $this->config->item('e___14874'); //COINS
$e___11035 = $this->config->item('e___11035'); //NAVIGATION
$last_x_days = 7;

$x__time_start_timestamp = mktime(0, 0, 0, date("n"), date("j")-$last_x_days, date("Y"));
$x__time_end_timestamp = mktime(23, 59, 59, date("n"), date("j")-1, date("Y"));

$x__time_start = date("Y-m-d H:i:s", $x__time_start_timestamp);
$x__time_end = date("Y-m-d H:i:s", $x__time_end_timestamp);

//Email Body
$plain_message = 'In the last '.$last_x_days.' day'.view__s($last_x_days).' '.$e___11035[14874]['m__title'].' grew:'."\n";

foreach($this->config->item('e___14874') as $x__type => $m) {

    //Calculate Growth Rate:
    if(substr_count($m['m__cover'], '6255')>0){
        $icon = '🔴';
    } elseif(substr_count($m['m__cover'], '12273')>0){
        $icon = '🟡';
    } elseif(substr_count($m['m__cover'], '12274')>0){
        $icon = '🔵';
    }

    $unique = count_unique_coins($x__type, null, $x__time_end);
    $this_week = count_unique_coins($x__type, $x__time_start, $x__time_end);
    $growth = format_percentage(($unique / ( $unique - $this_week ) * 100) - 100);
    $growth = ( $growth >= 0 ? '+' : '-' ).$growth.'%';

    //Add to UI:
    $plain_message .= "\n".$icon.' '.$m['m__title'].' '.$growth.' '.number_format($this_week, 0);

    //Primary Coin?
    if(in_array($x__type, $this->config->item('n___13776'))){
        $subject = $icon.' '.$m['m__title'].' '.$growth.' for the Week of '.date("M jS", $x__time_start_timestamp);
    }

}

$plain_message .= "\n"."\n".view_shuffle_message(12691);
$plain_message .= "\n".get_domain('m__title');





//Decide what to do with this?
if($is_u_request && !isset($_GET['email_trigger'])){

    echo '<div style="font-weight: bold; padding: 0 0 13px 0;">'.$subject.'</div>';
    echo nl2br($plain_message);
    echo '<div style="padding: 21px 0;"><a href="/-12114?email_trigger=1">Email Me This Report</a></div>';

} else {


    $subscriber_filters = array(
        'x__up' => 12114,
        'x__type IN (' . join(',', $this->config->item('n___4592')) . ')' => null, //SOURCE LINKS
        'x__status IN (' . join(',', $this->config->item('n___7359')) . ')' => null, //PUBLIC
        'e__type IN (' . join(',', $this->config->item('n___7357')) . ')' => null, //PUBLIC
    );

    //Should we limit the scope?
    if($is_u_request){
        $member_e = superpower_unlocked();
        $subscriber_filters['x__down'] = $member_e['e__id'];
    }


    $email_recipients = 0;
    //Send email to all subscribers:
    foreach($this->X_model->fetch($subscriber_filters, array('x__down')) as $subscribed_u){
        //Try fetching subscribers email:
        foreach($this->X_model->fetch(array(
            'x__status IN (' . join(',', $this->config->item('n___7359')) . ')' => null, //PUBLIC
            'x__type IN (' . join(',', $this->config->item('n___4592')) . ')' => null, //SOURCE LINKS
            'x__up' => 3288, //Email
            'x__down' => $subscribed_u['e__id'],
        )) as $e_email){
            if(filter_var($e_email['x__message'], FILTER_VALIDATE_EMAIL)){

                $this->X_model->send_dm(array($e_email['x__message']), $subject, 'Hi '.one_two_explode('',' ',$subscribed_u['e__title']).' 👋 '."\n\n".$plain_message);

                //Send & Log Email
                $invite_x = $this->X_model->create(array(
                    'x__type' => 12114,
                    'x__source' => $subscribed_u['e__id'],
                ));

                $email_recipients++;

                break;
            }
        }
    }

    echo 'Emailed Reports to '.$email_recipients.' Member'.view__s($email_recipients);

}