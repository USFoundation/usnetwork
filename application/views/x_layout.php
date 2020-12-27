<?php

$e___11035 = $this->config->item('e___11035'); //MENCH NAVIGATION
$e___13544 = $this->config->item('e___13544'); //IDEA TREE COUNT


//Determine Focus User:
$user_e = false;
if(isset($_GET['load__e']) && superpower_active(14005, true)){
    //Fetch This User
    $e_filters = $this->E_model->fetch(array(
        'e__id' => $_GET['load__e'],
        'e__type IN (' . join(',', $this->config->item('n___7358')) . ')' => null, //ACTIVE
    ));
    if(count($e_filters)){
        echo view__load__e($e_filters[0]);
        $user_e = $e_filters[0];
    }
}
if(!$user_e){
    $user_e = superpower_unlocked();
}
if(!isset($user_e['e__id']) ){
    $user_e['e__id'] = 0;
}




//Messages:
$messages = $this->X_model->fetch(array(
    'x__status IN (' . join(',', $this->config->item('n___7359')) . ')' => null, //PUBLIC
    'x__type' => 4231, //IDEA NOTES Messages
    'x__right' => $i_focus['i__id'],
), array(), 0, 0, array('x__spectrum' => 'ASC'));


//NEXT IDEAS
$is_next = $this->X_model->fetch(array(
    'x__status IN (' . join(',', $this->config->item('n___7359')) . ')' => null, //PUBLIC
    'i__type IN (' . join(',', $this->config->item('n___7355')) . ')' => null, //PUBLIC
    'x__type IN (' . join(',', $this->config->item('n___12840')) . ')' => null, //IDEA LINKS TWO-WAY
    'x__left' => $i_focus['i__id'],
), array('x__right'), 0, 0, array('x__spectrum' => 'ASC'));

$completion_rate['completion_percentage'] = 0;
$u_x_ids = $this->X_model->ids($user_e['e__id']);
$in_my_x = ( $user_e['e__id'] > 0 ? $this->X_model->i_home($i_focus['i__id'], $user_e) : false );
$sitemap_raw = array();
$sitemap_items = array();
$i = array(); //Assume main intent not yet completed, unless proven otherwise...
$i_completed = false; //Assume main intent not yet completed, unless proven otherwise...
$i_completion_percentage = 0; //Assume main intent not yet completed, unless proven otherwise...
$i_completion_rate = array();
$in_my_discoveries = in_array($i_focus['i__id'], $u_x_ids);
$previous_level_id = 0; //The ID of the Idea one level up, if any
$superpower_10939 = superpower_active(10939, true);
$x_completes = array();

if($in_my_x){
    //Fetch progress history:
    $x_completes = $this->X_model->fetch(array(
        'x__status IN (' . join(',', $this->config->item('n___7359')) . ')' => null, //PUBLIC
        'x__type IN (' . join(',', $this->config->item('n___12229')) . ')' => null, //DISCOVER COMPLETE
        'x__source' => $user_e['e__id'],
        'x__left' => $i_focus['i__id'],
    ));
}

$i_type_meet_requirement = in_array($i_focus['i__type'], $this->config->item('n___7309'));
$i_is_drip = in_array($i_focus['i__type'], $this->config->item('n___14383'));
$i_drip_mode = $i_is_drip && count($messages)>1 && (!$in_my_x || !count($x_completes)) && member_setting(14485)==14383;
$drip_msg_counter = 0;
$drip_msg_total = count($messages) + 1 /* For Title */;

?>

<script>
    var focus_i__type = <?= $i_focus['i__type'] ?>;
    var drip_msg_total = <?= $drip_msg_total ?>;
    var i_drip_pointer = 1; //Start at the first message
    var i_drip_mode_js = <?= intval($i_drip_mode) ?>;
</script>

<input type="hidden" id="focus_i__id" value="<?= $i_focus['i__id'] ?>" />
<script src="/application/views/x_layout.js?v=<?= view_memory(6404,11060) ?>" type="text/javascript"></script>

<?php

echo '<div class="container hideIfEmpty">';


if($in_my_x){

    //Add Current Discovery
    if($i_drip_mode){
        array_push($sitemap_items, view_i(14451, $i_focus, $in_my_x, null, false));
    }

    //Fetch Parents all the way to the Discovery Item
    if(!$in_my_discoveries){

        //Find it:
        $top_tree = $this->I_model->recursive_parents($i_focus['i__id'], true, true);

        foreach($top_tree as $grand_parent_ids) {
            foreach(array_intersect($grand_parent_ids, $u_x_ids) as $intersect) {
                foreach($grand_parent_ids as $count => $previous_i__id) {

                    if(filter_array($sitemap_raw, 'i__id', $previous_i__id)){
                        //Already There
                        break;
                    }

                    if($count==0){
                        //Reuse the first parent for the back button:
                        $previous_level_id = $previous_i__id;
                    }


                    $is_this = $this->I_model->fetch(array(
                        'i__id' => $previous_i__id,
                    ));

                    $completion_rate = $this->X_model->completion_progress($user_e['e__id'], $is_this[0]);
                    array_push($sitemap_raw, array(
                        'i__id' => $previous_i__id,
                        'i' => $is_this[0],
                        'completion_rate' => $completion_rate,
                    ));


                    if(in_array($previous_i__id, $u_x_ids)){
                        //We reached the top-level discovery:
                        $i_completed = $completion_rate['completion_percentage'] >= 100;
                        $i_completion_percentage = $completion_rate['completion_percentage'];
                        $i_completion_rate = $completion_rate;
                        $i = $is_this[0];
                        break;
                    }
                }
            }
        }

        foreach($sitemap_raw as $si) {
            array_push($sitemap_items, view_i(14450, $si['i'],  $in_my_x,null, false, $si['completion_rate']));
        }

    }
}


if($user_e['e__id']){

    //VIEW DISCOVER
    $this->X_model->create(array(
        'x__source' => $user_e['e__id'],
        'x__type' => 7610, //USER VIEWED IDEA
        'x__left' => $i_focus['i__id'],
        'x__spectrum' => fetch_cookie_order('7610_'.$i_focus['i__id']),
    ));

    if ($in_my_x) {

        //Auto go next?
        if(!count($x_completes) && !count($messages) && count($is_next)<2 && in_array($i_focus['i__type'], $this->config->item('n___12330'))){
            echo '<script> $(document).ready(function () { go_next(\'/x/x_next/'.$i_focus['i__id'].'\') }); </script>';
        }

        // % DONE
        $completion_rate = $this->X_model->completion_progress($user_e['e__id'], $i_focus);
        if($in_my_discoveries){
            $i_completed = $completion_rate['completion_percentage'] >= 100;
            $i_completion_percentage = $completion_rate['completion_percentage'];
            $i_completion_rate = $completion_rate;
        }


        if($i_type_meet_requirement){

            //Reverse check answers to see if they have previously unlocked a path:
            $unlocked_connections = $this->X_model->fetch(array(
                'i__type IN (' . join(',', $this->config->item('n___7355')) . ')' => null, //PUBLIC
                'x__status IN (' . join(',', $this->config->item('n___7359')) . ')' => null, //PUBLIC
                'x__type IN (' . join(',', $this->config->item('n___12326')) . ')' => null, //DISCOVER IDEA LINKS
                'x__right' => $i_focus['i__id'],
                'x__source' => $user_e['e__id'],
            ), array('x__left'), 1);

            if(count($unlocked_connections) > 0){

                //They previously have unlocked a path here!

                //Determine DISCOVER COIN type based on it's connection type's parents that will hold the appropriate discover coin.
                $x_completion_type_id = 0;
                foreach($this->config->item('e___12327') /* DISCOVER UNLOCKS */ as $e__id => $m){
                    if(in_array($unlocked_connections[0]['x__type'], $m['m__profile'])){
                        $x_completion_type_id = $e__id;
                        break;
                    }
                }

                //Could we determine the coin type?
                if($x_completion_type_id > 0){

                    //Yes, Issue coin:
                    array_push($x_completes, $this->X_model->mark_complete($i_focus, array(
                        'x__type' => $x_completion_type_id,
                        'x__source' => $user_e['e__id'],
                    )));

                } else {

                    //Oooops, we could not find it, report bug:
                    $this->X_model->create(array(
                        'x__type' => 4246, //Platform Bug Reports
                        'x__source' => $user_e['e__id'],
                        'x__message' => 'x_layout() found idea connector ['.$unlocked_connections[0]['x__type'].'] without a valid unlock method @12327',
                        'x__left' => $i_focus['i__id'],
                        'x__reference' => $unlocked_connections[0]['x__id'],
                    ));

                }

            } else {

                //Try to find paths to unlock:
                $unlock_paths = $this->I_model->unlock_paths($i_focus);

                //Set completion method:
                if(!count($unlock_paths)){

                    //No path found:
                    array_push($x_completes, $this->X_model->mark_complete($i_focus, array(
                        'x__type' => 7492, //TERMINATE
                        'x__source' => $user_e['e__id'],
                    )));

                }
            }
        }
    }
}





//Determine next path:
$is_discovarable = true;
if($in_my_x){

    $go_next_url = ( $i_completed ? '/x/i_next/' : '/x/x_next/' ) . $i_focus['i__id'];

} else {

    if(i_is_startable($i_focus)){

        //OPEN TO REGISTER
        $go_next_url = '/x/x_start/'.$i_focus['i__id'];

    } else {

        //Try to find the top registrable idea:
        $top_startable = $this->I_model->top_startable($i_focus);
        if(count($top_startable)){

            foreach($top_startable as $start_i){
                //OPEN TO REGISTER
                $is_discovarable = false;
                $go_next_url = '/'.$start_i['i__id'];
                break; //Ignore other possible pathways
            }

        } else {

            $go_next_url = null;

        }

    }
}






$show_percentage = $completion_rate['completion_percentage']>0 /* && $completion_rate['completion_percentage']<100 */ ;




//Idea Map:
echo '<div class="row">';
echo join('', array_reverse($sitemap_items));
echo '</div>';


/*
if($in_my_x && count($x_completes) && $i_drip_mode){
    //Show Discovery time:
    echo '<div class="headline"><span class="icon-block">'.$e___11035[14457]['m__icon'].'</span>'.str_replace('%S',view_time_difference(strtotime($x_completes[0]['x__time'])), $e___11035[14457]['m__title']).'</div>';
}
*/


if(!$i_drip_mode) {
    //HEADER
    echo '<h1>' . view_i_title($i_focus) . '</h1>';
}



//MESSAGES
foreach($messages as $message_x) {
    $drip_msg_counter++;
    echo '<div class="drip_msg drip_msg_'.$drip_msg_counter.' '.( $i_drip_mode && $drip_msg_counter>1 ? ' hidden ' : '' ).'">'.$this->X_model->message_view(
        $message_x['x__message'],
        true,
        $user_e
    ).'</div>';
}

if($i_drip_mode){ //|| (!$i_drip_mode && $i_is_drip)
    $drip_msg_counter++;
    echo '<div class="drip_msg drip_msg_'.$drip_msg_counter.( $i_drip_mode && $drip_msg_counter>1 ? ' hidden ' : '' ).'">';
    echo '<div class="headline" style="padding: 0;"><span class="icon-block">'.$e___11035[14384]['m__icon'].'</span>'.$e___11035[14384]['m__title'].'</div>';
    echo '<h1 style="padding: 21px 41px;">' . view_i_title($i_focus) . '</h1>';
    echo '</div>';
}



$fetch_13865 = $this->X_model->fetch(array(
    'x__right' => $i_focus['i__id'],
    'x__type' => 13865, //PREREQUISITES
    'x__status IN (' . join(',', $this->config->item('n___7359')) . ')' => null, //PUBLIC
    'e__type IN (' . join(',', $this->config->item('n___7357')) . ')' => null, //PUBLIC
), array('x__up'), 0);
$meets_13865 = !count($fetch_13865);

if(count($fetch_13865)){

    echo '<div class="headline" style="margin-top: 41px;"><span class="icon-block">'.$e___11035[13865]['m__icon'].'</span>'.$e___11035[13865]['m__title'].'</div>';

    $missing_13865 = 0;
    $e___13865 = $this->config->item('e___13865'); //PREREQUISITES
    echo '<div class="list-group" style="margin-bottom: 34px;">';
    foreach($fetch_13865 as $e_pre){

        $meets_this = ($user_e['e__id'] > 0 && count($this->X_model->fetch(array(
            'x__type IN (' . join(',', $this->config->item('n___4592')) . ')' => null, //SOURCE LINKS
            'x__status IN (' . join(',', $this->config->item('n___7359')) . ')' => null, //PUBLIC
            'x__up' => $e_pre['x__up'],
            'x__down' => $user_e['e__id'],
        ))));

        $meets_this_id = ( $meets_this ? 13875 : 13876 );

        echo '<div class="list-group-item no-left-padding"><span class="icon-block">'.$e___13865[$meets_this_id]['m__icon'].'</span>'.$e_pre['e__title'].'</div>';

        if(!$meets_this){
            $missing_13865++;
        }

    }
    echo '</div>';
    $meets_13865 = !$missing_13865;
}




//DISCOVER LAYOUT
$i_stats = i_stats($i_focus['i__metadata']);
$tab_group = 13291;
$tab_pills = '<ul class="nav nav-tabs nav-sm ">'; //'.superpower_active(13758).'
$tab_content = '';
$tab_pill_count = 0;

/*
if($in_my_x && count($this->X_model->fetch(array(
        'x__status IN (' . join(',', $this->config->item('n___7360')) . ')' => null, //ACTIVE
        'x__type' => 4983, //IDEA SOURCES
        'x__up' => 12896, //SAVE THIS IDAE
        'x__right' => $i_focus['i__id'],
    ))) && !count($this->X_model->fetch(array(
        'x__up' => $user_e['e__id'],
        'x__right' => $i_focus['i__id'],
        'x__type' => 12896, //SAVED
        'x__status IN (' . join(',', $this->config->item('n___7359')) . ')' => null, //PUBLIC
    )))){

    //Recommended to Save This Idea:
    echo '<div class="msg alert no-margin space-left">Save idea for quick access? <span class="inline-block">Tap <i class="far fa-bookmark black"></i></span></div>';

}
*/

foreach($this->config->item('e___'.$tab_group) as $x__type => $m){

    if(!$user_e['e__id'] && in_array($x__type, $this->config->item('n___13304'))){
        //Hide since Not logged in:
        continue;
    }

    //Have Needed Superpowers?
    $superpower_actives = array_intersect($this->config->item('n___10957'), $m['m__profile']);
    if(count($superpower_actives) && !superpower_unlocked(end($superpower_actives))){
        continue;
    }

    //Is this a caret menu?
    if(in_array(11040 , $m['m__profile'])){
        echo view_caret($x__type, $m, $i_focus['i__id']);
        continue;
    }

    $counter = null; //Assume no counters
    $ui = '';
    $href = 'href="javascript:void(0);" onclick="loadtab('.$tab_group.','.$x__type.')"';

    if($x__type==12273){

        //IDEAS
        $counter = count($is_next);

        $ui .= '<div class="drip_msg drip_msg_'.$drip_msg_counter.' '.($i_drip_mode && $drip_msg_counter>1 ? ' hidden ' : '' ).'">';

        if($in_my_x) {

            //PREVIOUSLY UNLOCKED:
            $unlocked_x = $this->X_model->fetch(array(
                'x__status IN (' . join(',', $this->config->item('n___7359')) . ')' => null, //PUBLIC
                'i__type IN (' . join(',', $this->config->item('n___7355')) . ')' => null, //PUBLIC
                'x__type' => 6140, //DISCOVER UNLOCK LINK
                'x__source' => $user_e['e__id'],
                'x__left' => $i_focus['i__id'],
            ), array('x__right'), 0);

            //Did we have any steps unlocked?
            if (count($unlocked_x) > 0) {
                $ui .= view_i_list(13978, $in_my_x, $i_focus, $unlocked_x, $user_e);
            }


            /*
             *
             * IDEA TYPE INPUT CONTROLLER
             * Now let's show the appropriate
             * inputs that correspond to the
             * idea type that enable the user
             * to move forward.
             *
             * */


            //LOCKED
            if ($i_type_meet_requirement) {

                //Requirement lock
                if (!count($x_completes) && !count($unlocked_connections) && count($unlock_paths)) {

                    //List Unlock paths:
                    $ui .= view_i_list(13979, $in_my_x, $i_focus, $unlock_paths, $user_e);

                }

                //List Children if any:
                $ui .= view_i_list(12211, $in_my_x, $i_focus, $is_next, $user_e);


            } elseif (in_array($i_focus['i__type'], $this->config->item('n___7712'))) {

                //SELECT ANSWER

                //Has no children:
                if (!count($is_next)) {

                    //Mark this as complete since there is no child to choose from:
                    if (!count($this->X_model->fetch(array(
                        'x__status IN (' . join(',', $this->config->item('n___7359')) . ')' => null, //PUBLIC
                        'x__type IN (' . join(',', $this->config->item('n___12229')) . ')' => null, //DISCOVER COMPLETE
                        'x__source' => $user_e['e__id'],
                        'x__left' => $i_focus['i__id'],
                    )))) {

                        array_push($x_completes, $this->X_model->mark_complete($i_focus, array(
                            'x__type' => 4559, //DISCOVER MESSAGES
                            'x__source' => $user_e['e__id'],
                        )));

                    }

                } else {

                    //First fetch answers based on correct order:
                    $x_selects = array();
                    foreach ($this->X_model->fetch(array(
                        'x__status IN (' . join(',', $this->config->item('n___7359')) . ')' => null, //PUBLIC
                        'i__type IN (' . join(',', $this->config->item('n___7355')) . ')' => null, //PUBLIC
                        'x__type IN (' . join(',', $this->config->item('n___12840')) . ')' => null, //IDEA LINKS TWO-WAY
                        'x__left' => $i_focus['i__id'],
                    ), array('x__right'), 0, 0, array('x__spectrum' => 'ASC')) as $x) {
                        //See if this answer was seleted:
                        if (count($this->X_model->fetch(array(
                            'x__status IN (' . join(',', $this->config->item('n___7359')) . ')' => null, //PUBLIC
                            'x__type IN (' . join(',', $this->config->item('n___12326')) . ')' => null, //DISCOVER IDEA LINK
                            'x__left' => $i_focus['i__id'],
                            'x__right' => $x['i__id'],
                            'x__source' => $user_e['e__id'],
                        )))) {
                            array_push($x_selects, $x);
                        }
                    }

                    if (count($x_selects) > 0) {
                        //MODIFY ANSWER
                        $ui .= '<div class="edit_select_answer">';

                        //List answers:
                        $ui .= view_i_list(13980, $in_my_x, $i_focus, $x_selects, $user_e);

                        $ui .= '<div class="doclear">&nbsp;</div>';

                        //EDIT ANSWER:
                        $ui .= '<div class="margin-top-down"><a class="btn btn-discover" href="javascript:void(0);" onclick="$(\'.edit_select_answer\').toggleClass(\'hidden\');">' . $e___11035[13495]['m__icon'] . ' ' . $e___11035[13495]['m__title'] . '</a></div>';

                        $ui .= '<div class="doclear">&nbsp;</div>';

                        $ui .= '</div>';
                    }


                    $ui .= '<div class="edit_select_answer ' . (count($x_selects) > 0 ? 'hidden' : '') . '">';
                    $ui .= '<div class="doclear">&nbsp;</div>';

                    //HTML:
                    if ($i_focus['i__type'] == 6684) {

                        $ui .= '<div class="pull-left headline"><span class="icon-block">'.$e___11035[13981]['m__icon'].'</span>'.$e___11035[13981]['m__title'].'</div>';

                    } elseif ($i_focus['i__type'] == 7231) {


                        $ui .= '<div class="pull-left headline"><span class="icon-block">'.$e___11035[13982]['m__icon'].'</span>'.$e___11035[13982]['m__title'].'</div>';

                        //Give option to Select None/All
                        /*
                        $ui .= '<div class="doclear">&nbsp;</div>';
                        $ui .= '<div class="pull-right right-adj inline-block" data-toggle="tooltip" data-placement="top" title="SELECT ALL OR NONE"><a href="javascript:void(0);" onclick="$(\'.answer-item i\').removeClass(\'far fa-circle\').addClass(\'fas fa-check-circle\');" style="text-decoration: underline;" title="'.$e___11035[13692]['m__title'].'">'.$e___11035[13692]['m__icon'].'</a>&nbsp;&nbsp;<a href="javascript:void(0);" onclick="$(\'.answer-item i\').removeClass(\'fas fa-check-circle\').addClass(\'far fa-circle\');" style="text-decoration: underline;" title="'.$e___11035[13693]['m__title'].'">'.$e___11035[13693]['m__icon'].'</a></div>';
                        */

                    }

                    $ui .= '<div class="doclear">&nbsp;</div>';


                    //Open for list to be printed:
                    $ui .= '<div class="list-group list-answers" i__type="' . $i_focus['i__type'] . '">';


                    //List children to choose from:
                    foreach ($is_next as $key => $next_i) {

                        //Has this been previously selected?
                        $previously_selected = count($this->X_model->fetch(array(
                            'x__status IN (' . join(',', $this->config->item('n___7359')) . ')' => null, //PUBLIC
                            'x__type IN (' . join(',', $this->config->item('n___12326')) . ')' => null, //DISCOVER IDEA LINKS
                            'x__left' => $i_focus['i__id'],
                            'x__right' => $next_i['i__id'],
                            'x__source' => $user_e['e__id'],
                        )));

                        $ui .= '<a href="javascript:void(0);" onclick="select_answer(' . $next_i['i__id'] . ')" selection_i__id="' . $next_i['i__id'] . '" class="x_select_' . $next_i['i__id'] . ' answer-item list-group-item itemdiscover no-left-padding">';


                        $ui .= '<table class="table table-sm" style="background-color: transparent !important; margin-bottom: 0;"><tr>';
                        $ui .= '<td class="icon-block check-icon" style="padding: 0 !important;"><i class="' . ($previously_selected ? 'fas fa-check-circle discover' : 'far fa-circle discover') . '"></i></td>';

                        $ui .= '<td style="width:100%; padding: 0 !important;">';
                        $ui .= '<b class="css__title i-url" style="margin-left:0;">' . view_i_title($next_i) . '</b>';
                        $ui .= '</td>';

                        $ui .= '</tr></table>';


                        $ui .= '</a>';
                    }


                    //Close list:
                    $ui .= '</div>';




                    if (count($x_selects) > 0) {

                        //Cancel:
                        $ui .= '<div class="inline-block margin-top-down"><a class="btn btn-discover" href="javascript:void(0);" onclick="$(\'.edit_select_answer\').toggleClass(\'hidden\');" title="' . $e___11035[13502]['m__title'] . '">' . $e___11035[13502]['m__icon'] . '</a></div>';

                        //Save Answers:
                        $ui .= '<div class="inline-block margin-top-down left-half-margin"><a class="btn btn-discover" href="javascript:void(0);" onclick="x_select(\'/x/x_next/'.$i_focus['i__id'].'\')">' . $e___11035[13524]['m__title'] . ' ' . $e___11035[13524]['m__icon'] . '</a></div>';

                    }

                    $ui .= '</div>';

                }

            } elseif ($i_focus['i__type'] == 6677) {

                //DISCOVER ONLY
                $ui .= view_i_list(12211, $in_my_x, $i_focus, $is_next, $user_e, ( count($is_next) > 1 ? view_i_time($i_stats, true) : '' ));


            } elseif ($i_focus['i__type'] == 6683) {

                //TEXT RESPONSE
                $ui .= '<div class="headline"><span class="icon-block">'.$e___11035[13980]['m__icon'].'</span>'.$e___11035[13980]['m__title'].'</div>';

                //Write `skip` if you prefer not to answer...
                $ui .= '<textarea class="border i_content padded x_input" placeholder="" id="x_reply">' . (count($x_completes) ? trim($x_completes[0]['x__message']) : '') . '</textarea>';

                if (count($x_completes)) {
                    //Next Ideas:
                    $ui .= view_i_list(12211, $in_my_x, $i_focus, $is_next, $user_e);
                }

                $ui .= '<script> $(document).ready(function () { set_autosize($(\'#x_reply\')); $(\'#x_reply\').focus(); }); </script>';


            } elseif ($i_focus['i__type'] == 7637) {

                //FILE UPLOAD
                $ui .= '<div class="userUploader">';
                $ui .= '<form class="box boxUpload" method="post" enctype="multipart/form-data">';

                $ui .= '<input class="inputfile" type="file" name="file" id="fileType' . $i_focus['i__type'] . '" />';


                if (count($x_completes)) {

                    $ui .= '<div class="file_saving_result">';

                    $ui .= '<div class="headline"><span class="icon-block">'.$e___11035[13980]['m__icon'].'</span>'.$e___11035[13977]['m__title'].'</div>';

                    $ui .= '<div class="previous_answer">' . $this->X_model->message_view($x_completes[0]['x__message'], true) . '</div>';

                    $ui .= '</div>';

                    //Any child ideas?
                    $ui .= view_i_list(12211, $in_my_x, $i_focus, $is_next, $user_e);

                } else {

                    //for when added:
                    $ui .= '<div class="file_saving_result"></div>';

                }

                //UPLOAD BUTTON:
                $ui .= '<div class="margin-top-down"><label class="btn btn-discover inline-block" for="fileType' . $i_focus['i__type'] . '" style="margin-left:5px;">' . $e___11035[13572]['m__icon'] . ' ' . $e___11035[13572]['m__title'] . '</label></div>';


                $ui .= '<div class="doclear">&nbsp;</div>';
                $ui .= '</form>';
                $ui .= '</div>';

            }

        } else {

            //NEXT IDEAS
            $ui .= view_i_list(12211, $in_my_x, $i_focus, $is_next, $user_e, ( count($is_next) ? view_i_time($i_stats, true) : '' )); //13542

            //IDEA PREVIOUS
            /*
            $is_previous = $this->X_model->fetch(array(
                'x__status IN (' . join(',', $this->config->item('n___7359')) . ')' => null, //PUBLIC
                'i__type IN (' . join(',', $this->config->item('n___7355')) . ')' => null, //PUBLIC
                'x__type IN (' . join(',', $this->config->item('n___4486')) . ')' => null, //IDEA LINKS
                'x__right' => $i_focus['i__id'],
                'x__left !=' => view_memory(6404,14002),
            ), array('x__left'), 0);
            if(count($is_previous)){
                $ui .= '<div style="padding-top: 34px;">';
                $ui .= view_i_list(12991, $in_my_x, $i_focus, $is_previous, $user_e);
                $ui .= '</div>';
            }
            */

        }

        $ui .= '</div>';

    } elseif($x__type==6255){

        $discovered = $this->X_model->fetch(array(
            'x__status IN (' . join(',', $this->config->item('n___7359')) . ')' => null, //PUBLIC
            'x__type IN (' . join(',', $this->config->item('n___6255')) . ')' => null, //DISCOVER COIN
            'x__left' => $i_focus['i__id'],
        ), array(), 0, 0, array(), 'COUNT(x__id) as totals');

        $counter = view_number($discovered[0]['totals']);

        if($counter > 0){
            $ui .= '<div class="list-group" style="margin-bottom:41px;">';
            foreach($this->X_model->fetch(array(
                'x__status IN (' . join(',', $this->config->item('n___7359')) . ')' => null, //PUBLIC
                'x__type IN (' . join(',', $this->config->item('n___6255')) . ')' => null, //DISCOVER COIN
                'x__left' => $i_focus['i__id'],
            ), array('x__source'), view_memory(6404,11064), 0, array( 'x__id' => 'DESC' )) as $discover_e){
                $ui .= view_e($discover_e);
            }
            $ui .= '</div>';
        }

    } elseif( $x__type==12274 || in_array($x__type, $this->config->item('n___4485')) ){

        //NOTES
        $note_x__type = ($x__type==12274 ? 4983 : $x__type );
        $notes = $this->X_model->fetch(array(
            'x__status IN (' . join(',', $this->config->item('n___7359')) . ')' => null, //PUBLIC
            'x__type' => $note_x__type,
            'x__right' => $i_focus['i__id'],
        ), array('x__source'), 0, 0, array('x__spectrum' => 'ASC'));
        $counter = count($notes);
        $is_editable = in_array($note_x__type, $this->config->item('n___14043'));
        $ui .= view_i_note_list($note_x__type, true, $i_focus, $notes, ( $user_e['e__id'] > 0 && $is_editable ), true);

    }


    if(!$counter && in_array($x__type, $this->config->item('n___13298'))){
        //Hide since Zero count:
        continue;
    }

    $default_active = ( $counter && in_array($x__type, $this->config->item('n___13300')) );
    $tab_pill_count++;


    $tab_pills .= '<li class="nav-item'.( in_array($x__type, $this->config->item('n___14103')) ? ' pull-right ' : '' ).'"><a '.$href.' class="nav-x tab-nav-'.$tab_group.' tab-head-'.$x__type.' '.( $default_active ? ' active ' : '' ).extract_icon_color($m['m__icon']).'" title="'.$m['m__title'].( strlen($m['m__message']) ? ' '.$m['m__message'] : '' ).'" data-toggle="tooltip" data-placement="top">&nbsp;'.$m['m__icon'].'&nbsp;'.( !$counter ? '' : '<span class="en-type-counter-'.$x__type.'">'.$counter.'</span>&nbsp;' ).'</a></li>';


    $tab_content .= '<div class="tab-content tab-group-'.$tab_group.' tab-data-'.$x__type.( $default_active ? '' : ' hidden ' ).'">';
    $tab_content .= $ui;
    $tab_content .= '</div>';

}
$tab_pills .= '</ul>';




if($tab_pill_count > 1){
    //DISCOVER TABS
    echo $tab_pills;
}

//Show All Tab Content:
echo $tab_content;

echo '</div>'; //CLOSE CONTAINER


if(!$in_my_x && !$i_drip_mode){

    $discovery_e = ( $is_discovarable ? 4235 : 14022 );

    //Get Started
    echo '<div class="container light-bg fixed-bottom">';
    echo '<div class="discover-controller">';
    echo '<div><a class="controller-nav btn btn-lrg btn-discover go-next" href="javascript:void(0);" onclick="go_next(\''.$go_next_url.'\')">'.$e___11035[$discovery_e]['m__title'].' '.$e___11035[$discovery_e]['m__icon'].'</a></div>';
    echo '</div>';
    echo '</div>';

} else {

    $buttons_found = 0;
    $buttons_ui = '';

    foreach($this->config->item('e___13289') as $e__id => $m) {


        $superpower_actives = array_intersect($this->config->item('n___10957'), $m['m__profile']);
        if(count($superpower_actives) && !superpower_unlocked(end($superpower_actives))){
            continue;
        }

        $control_btn = '';

        if($e__id==13877 && $in_my_x && !$in_my_discoveries){

            //Is Saved already by this user?
            $is_saved = count($this->X_model->fetch(array(
                'x__up' => $user_e['e__id'],
                'x__right' => $i_focus['i__id'],
                'x__type' => 12896, //SAVED
                'x__status IN (' . join(',', $this->config->item('n___7359')) . ')' => null, //PUBLIC
            )));

            $control_btn = '<span class="final_drip '.( $i_drip_mode && $drip_msg_counter>1 ? ' hidden ' : '' ).'"><a class="round-btn save_controller" href="javascript:void(0);" onclick="x_save('.$i_focus['i__id'].')" current_x_id="0"><span class="controller-nav toggle_saved '.( $is_saved ? '' : 'hidden' ).'">'.$e___11035[12896]['m__icon'].'</span><span class="controller-nav toggle_saved '.( $is_saved ? 'hidden' : '' ).'">'.$e___11035[12906]['m__icon'].'</span></a><span class="nav-title css__title">'.$m['m__title'].'</span></span>';

        } elseif($e__id==12991){

            //BACK
            $control_btn = '<a class="controller-nav round-btn" href="javascript:void(0);" onclick="go_previous(\''.( isset($_GET['previous_x']) && $_GET['previous_x']>0 ? '/'.$_GET['previous_x'] : ( $previous_level_id > 0 ? '/x/x_previous/'.$previous_level_id.'/'.$i_focus['i__id'] : home_url() ) ).'\')">'.$m['m__icon'].'</a><span class="nav-title css__title">'.$m['m__title'].'</span>';

        } elseif($e__id==12211){

            //NEXT
            $control_btn = '<a class="controller-nav round-btn go-next" href="javascript:void(0);" onclick="go_next(\''.$go_next_url.'\')">'.$m['m__icon'].'</a><span class="nav-title css__title">'.$m['m__title'].'</span>';

        }

        $buttons_ui .= '<div>'.( $control_btn ? $control_btn : '&nbsp;' ).'</div>';

        if($control_btn){
            $buttons_found++;
        }

    }

    if($buttons_found > 0){
        echo '<div class="container light-bg fixed-bottom">';
        echo '<div class="discover-controller">';
        echo $buttons_ui;
        echo '</div>';
        echo '</div>';
    }

}


?>