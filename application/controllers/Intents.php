<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Intents extends CI_Controller
{

    function __construct()
    {
        parent::__construct();

        $this->output->enable_profiler(FALSE);
    }

    function test($in_id){
        $all = $this->Platform_model->in_fetch_recursive_parents($in_id, 0);
        echo_json(array(
            'flatter' => array_flatten($all),
            'all' => $all,
        ));
    }

    //Loaded as default function of the default controller:
    function index()
    {

        $session_en = $this->session->userdata('user');

        if ((isset($_SERVER['SERVER_NAME']) && $_SERVER['SERVER_NAME'] == 'mench.co')) {

            //Go to mench.com for now:
            return redirect_message('https://mench.com');

        } else {

            //Fetch home page intent:
            $home_ins = $this->Database_model->in_fetch(array(
                'in_id' => $this->config->item('in_home_page'),
            ));

            //How many featured intents do we have?
            $featured_ins = $this->Database_model->ln_fetch(array(
                'ln_status' => 2, //Published
                'in_status' => 2, //Published
                'ln_type_entity_id' => 4228, //Fixed Intent Links
                'ln_parent_intent_id' => $this->config->item('in_featured'), //Feature Mench Intentions
            ), array('in_child'), 0, 0, array('ln_order' => 'ASC'));

            if(count($home_ins)<1 && count($featured_ins) > 0){

                //Go to the first featured intent:
                redirect_message('/'.$featured_ins[0]['ln_child_intent_id']);

            } elseif(count($home_ins) > 0){

                //Show index page:
                $this->load->view('view_shared/public_header', array(
                    'title' => echo_in_outcome($home_ins[0]['in_outcome'], true),
                ));
                $this->load->view('view_intents/in_home_featured_ui', array(
                    'in' => $home_ins[0],
                    'featured_ins' => $featured_ins,
                ));
                $this->load->view('view_shared/public_footer');

            } else {

                //Oooopsi, unable to load the home page intent

            }
        }
    }


    function in_landing_page($in_id)
    {

        /*
         *
         * Loads public landing page that Students can use
         * to review intents before adding to Action Plan
         *
         * */

        //Fetch user session:
        $session_en = en_auth(array(1308));

        //Fetch data:
        $ins = $this->Database_model->in_fetch(array(
            'in_id' => $in_id,
        ));

        //Make sure we found it:
        if ( count($ins) < 1) {
            return redirect_message('/', '<div class="alert alert-danger" role="alert">Intent #' . $in_id . ' not found</div>');
        } elseif ( $ins[0]['in_status'] < 2) {
            return redirect_message('/', '<div class="alert alert-danger" role="alert">Intent #' . $in_id . ' is not published yet</div>');
        }

        //Load home page:
        $this->load->view('view_shared/public_header', array(
            'title' => $ins[0]['in_outcome'],
            'session_en' => $session_en,
            'in' => $ins[0],
        ));
        $this->load->view('view_intents/in_landing_page', array(
            'in' => $ins[0],
            'session_en' => $session_en,
        ));
        $this->load->view('view_shared/public_footer');

    }



    function assessment_marks_reports(){

        //Authenticate Miner:
        $session_en = en_auth(array(1308));
        $fixed_fields = $this->config->item('fixed_fields');

        if (!$session_en) {
            return echo_json(array(
                'status' => 0,
                'message' => 'Invalid Session. Refresh the Page to Continue',
            ));
        } elseif (!isset($_POST['starting_in']) || intval($_POST['starting_in']) < 1) {
            return echo_json(array(
                'status' => 0,
                'message' => 'Missing Starting Intent',
            ));
        } elseif (!isset($_POST['depth_levels']) || intval($_POST['depth_levels']) < 1) {
            return echo_json(array(
                'status' => 0,
                'message' => 'Missing Depth',
            ));
        } elseif (!isset($_POST['status_min']) || intval($_POST['status_min']) < -1 || intval($_POST['status_min']) > 2) {
            return echo_json(array(
                'status' => 0,
                'message' => 'Minimum status fall between -1 and 2',
            ));
        }

        //Fetch/Validate intent:
        $ins = $this->Database_model->in_fetch(array(
            'in_id' => $_POST['starting_in'],
            'in_status >=' => $_POST['status_min'],
        ));
        if(count($ins) != 1){
            return echo_json(array(
                'status' => 0,
                'message' => 'Could not find intent #'.$_POST['starting_in'].' with a minimum in_status='.$_POST['status_min'],
            ));
        }


        //Return report:
        return echo_json(array(
            'status' => 1,
            'message' => '<h3>'.$fixed_fields['in_type'][$ins[0]['in_type']]['s_icon'].' '.$fixed_fields['in_status'][$ins[0]['in_status']]['s_icon'].' '.$ins[0]['in_outcome'].'</h3>'.echo_in_answer_scores($_POST['starting_in'], $_POST['depth_levels'], $_POST['status_min'], $_POST['depth_levels'], $ins[0]['in_type']),
        ));

    }

    function in_miner_ui($in_id)
    {

        /*
         *
         * Main intent view that Miners use to manage the
         * intent networks.
         *
         * */

        if($in_id == 0){
            //Set to default:
            $in_id = $this->config->item('in_miner_start');
        }

        //Authenticate Miner, redirect if failed:
        $session_en = en_auth(array(1308), true);

        //Fetch intent with 2 levels of children:
        $ins = $this->Database_model->in_fetch(array(
            'in_id' => $in_id,
        ), array('in__parents','in__grandchildren'));

        //Make sure we found it:
        if ( count($ins) < 1) {
            return redirect_message('/intents/' . $this->config->item('in_miner_start'), '<div class="alert alert-danger" role="alert">Intent #' . $in_id . ' not found</div>');
        }

        //Update session count and log link:
        $new_order = ( $this->session->userdata('miner_session_count') + 1 );
        $this->session->set_userdata('miner_session_count', $new_order);
        $this->Database_model->ln_create(array(
            'ln_miner_entity_id' => $session_en['en_id'],
            'ln_type_entity_id' => 4993, //Miner Opened Intent
            'ln_child_intent_id' => $in_id,
            'ln_order' => $new_order,
        ));

        //Load views:
        $this->load->view('view_shared/platform_header', array( 'title' => $ins[0]['in_outcome'].' | Intents' ));
        $this->load->view('view_intents/in_miner_ui', array( 'in' => $ins[0] ));
        $this->load->view('view_shared/platform_footer');

    }



    function in_link_or_create()
    {

        /*
         *
         * Either creates an intent link between in_parent_id & in_link_child_id
         * OR will create a new intent with outcome in_outcome and then link it
         * to in_parent_id (In this case in_link_child_id=0)
         *
         * */

        //Authenticate Miner:
        $session_en = en_auth(array(1308));
        if (!$session_en) {
            return echo_json(array(
                'status' => 0,
                'message' => 'Invalid Session. Refresh the Page to Continue',
            ));
        } elseif (!isset($_POST['in_parent_id']) || intval($_POST['in_parent_id']) < 1) {
            return echo_json(array(
                'status' => 0,
                'message' => 'Missing Parent Intent ID',
            ));
        } elseif (!isset($_POST['is_parent']) || !in_array(intval($_POST['is_parent']), array(0,1))) {
            return echo_json(array(
                'status' => 0,
                'message' => 'Missing Is Parent setting',
            ));
        } elseif (!isset($_POST['next_level']) || !in_array(intval($_POST['next_level']), array(2,3))) {
            return echo_json(array(
                'status' => 0,
                'message' => 'Invalid Intent Level',
            ));
        } elseif (!isset($_POST['in_outcome']) || !isset($_POST['in_link_child_id']) || ( strlen($_POST['in_outcome']) < 1 && intval($_POST['in_link_child_id']) < 1)) {
            return echo_json(array(
                'status' => 0,
                'message' => 'Missing either Intent Outcome OR Child Intent ID',
            ));
        } elseif (strlen($_POST['in_outcome']) > $this->config->item('in_outcome_max')) {
            return echo_json(array(
                'status' => 0,
                'message' => 'Intent outcome cannot be longer than '.$this->config->item('in_outcome_max').' characters',
            ));
        }

        //All seems good, go ahead and try creating the intent:
        return echo_json($this->Platform_model->in_link_or_create($_POST['in_parent_id'], intval($_POST['is_parent']), $_POST['in_outcome'], $_POST['in_link_child_id'], $_POST['next_level'], $session_en['en_id']));

    }






    function in_migrate()
    {

        //Authenticate Miner:
        $session_en = en_auth(array(1308));
        if (!$session_en) {
            return echo_json(array(
                'status' => 0,
                'message' => 'Invalid Session. Sign In again to Continue.',
            ));
        } elseif (!isset($_POST['ln_id']) || intval($_POST['ln_id']) < 1) {
            return echo_json(array(
                'status' => 0,
                'message' => 'Invalid ln_id',
            ));
        } elseif (!isset($_POST['in_id']) || intval($_POST['in_id']) < 1) {
            return echo_json(array(
                'status' => 0,
                'message' => 'Invalid in_id',
            ));
        } elseif (!isset($_POST['from_in_id']) || intval($_POST['from_in_id']) < 1) {
            return echo_json(array(
                'status' => 0,
                'message' => 'Missing from_in_id',
            ));
        } elseif (!isset($_POST['to_in_id']) || intval($_POST['to_in_id']) < 1) {
            return echo_json(array(
                'status' => 0,
                'message' => 'Missing to_in_id',
            ));
        }


        //Fetch all three intents to ensure they are all valid and use them for link logging:
        $this_in = $this->Database_model->in_fetch(array(
            'in_id' => intval($_POST['in_id']),
        ));
        $from_in = $this->Database_model->in_fetch(array(
            'in_id' => intval($_POST['from_in_id']),
        ));
        $to_in = $this->Database_model->in_fetch(array(
            'in_id' => intval($_POST['to_in_id']),
            'in_status >=' => 0, //New+
        ));

        if (!isset($this_in[0]) || !isset($from_in[0]) || !isset($to_in[0])) {
            return echo_json(array(
                'status' => 0,
                'message' => 'Invalid intent IDs',
            ));
        }

        //Make the move:
        $this->Database_model->ln_update(intval($_POST['ln_id']), array(
            'ln_parent_intent_id' => $to_in[0]['in_id'],
        ), $session_en['en_id']);

        //Return success
        echo_json(array(
            'status' => 1,
        ));
    }

    function in_modify_save()
    {

        //Authenticate Miner:
        $session_en = en_auth(array(1308));
        $ln_id = intval($_POST['ln_id']);
        $ln_in_link_id = 0; //If >0 means linked intent is being updated...

        //Validate intent:
        $ins = $this->Database_model->in_fetch(array(
            'in_id' => intval($_POST['in_id']),
        ), array('in__parents'));

        if (!$session_en) {
            return echo_json(array(
                'status' => 0,
                'message' => 'Session Expired',
            ));
        } elseif (!isset($_POST['in_id']) || intval($_POST['in_id']) < 1) {
            return echo_json(array(
                'status' => 0,
                'message' => 'Invalid Intent ID',
            ));
        } elseif (intval($_POST['level'])==1 && intval($_POST['ln_id'])>0) {
            return echo_json(array(
                'status' => 0,
                'message' => 'Level 1 intent should not have a link',
            ));
        } elseif (!isset($_POST['tr__conditional_score_min']) || !isset($_POST['tr__conditional_score_max'])) {
            return echo_json(array(
                'status' => 0,
                'message' => 'Missing Score Min/Max Variables',
            ));
        } elseif (!isset($_POST['tr__assessment_points'])) {
            return echo_json(array(
                'status' => 0,
                'message' => 'Missing assessment points',
            ));
        } elseif (!isset($_POST['level']) || intval($_POST['level']) < 1 || intval($_POST['level']) > 3) {
            return echo_json(array(
                'status' => 0,
                'message' => 'Invalid level',
            ));
        } elseif (!isset($_POST['in_outcome']) || strlen($_POST['in_outcome']) < 1) {
            return echo_json(array(
                'status' => 0,
                'message' => 'Missing Outcome',
            ));
        } elseif (strlen($_POST['in_outcome']) > $this->config->item('in_outcome_max')) {
            return echo_json(array(
                'status' => 0,
                'message' => 'Intent outcome cannot be longer than '.$this->config->item('in_outcome_max').' characters',
            ));
        } elseif (!isset($_POST['in_seconds_cost']) || intval($_POST['in_seconds_cost']) < 0) {
            return echo_json(array(
                'status' => 0,
                'message' => 'Missing Time Estimate',
            ));
        } elseif (intval($_POST['in_seconds_cost']) > $this->config->item('in_seconds_cost_max')) {
            return echo_json(array(
                'status' => 0,
                'message' => 'Maximum estimated time is ' . round(($this->config->item('in_seconds_cost_max') / 3600), 2) . ' hours for each intent. If larger, break the intent down into smaller intents.',
            ));
        } elseif (!isset($_POST['apply_recursively'])) {
            return echo_json(array(
                'status' => 0,
                'message' => 'Missing Recursive setting',
            ));
        } elseif (!isset($_POST['in_requirement_entity_id'])) {
            return echo_json(array(
                'status' => 0,
                'message' => 'Missing Completion Entity ID',
            ));
        } elseif (!isset($_POST['in_dollar_cost']) || doubleval($_POST['in_dollar_cost']) < 0) {
            return echo_json(array(
                'status' => 0,
                'message' => 'Missing Cost Estimate',
            ));
        } elseif (!isset($_POST['in_status'])) {
            return echo_json(array(
                'status' => 0,
                'message' => 'Missing Intent Status',
            ));
        } elseif (intval($_POST['in_dollar_cost']) < 0 || doubleval($_POST['in_dollar_cost']) > 300) {
            return echo_json(array(
                'status' => 0,
                'message' => 'Cost estimate must be $0-5000 USD',
            ));
        } elseif (!isset($_POST['in_type'])) {
            return echo_json(array(
                'status' => 0,
                'message' => 'Missing Completion Settings',
            ));
        } elseif (count($ins) < 1) {
            return echo_json(array(
                'status' => 0,
                'message' => 'Intent Not Found',
            ));
        } elseif($ln_id > 0 && intval($_POST['ln_type_entity_id']) == 4229){
            //Conditional links, we require range values:
            if(strlen($_POST['tr__conditional_score_min']) < 1 || !is_numeric($_POST['tr__conditional_score_min'])){
                return echo_json(array(
                    'status' => 0,
                    'message' => 'Missing MIN range, enter 0 or greater',
                ));
            } elseif(strlen($_POST['tr__conditional_score_max']) < 1 || !is_numeric($_POST['tr__conditional_score_max'])){
                return echo_json(array(
                    'status' => 0,
                    'message' => 'Missing MAX range, enter 0 or greater',
                ));
            } elseif(doubleval($_POST['tr__conditional_score_min']) > doubleval($_POST['tr__conditional_score_max'])){
                return echo_json(array(
                    'status' => 0,
                    'message' => 'MIN range cannot be larger than MAX',
                ));
            }
        }




        //calculate Verb ID:
        $_POST['in_verb_entity_id'] = detect_starting_verb_id($_POST['in_outcome']);

        //Prep new variables:
        $in_update = array(
            'in_status' => intval($_POST['in_status']),
            'in_outcome' => trim($_POST['in_outcome']),
            'in_seconds_cost' => intval($_POST['in_seconds_cost']),
            'in_requirement_entity_id' => intval($_POST['in_requirement_entity_id']),
            'in_verb_entity_id' => $_POST['in_verb_entity_id'],
            'in_dollar_cost' => doubleval($_POST['in_dollar_cost']),
            'in_type' => intval($_POST['in_type']),
        );

        //Prep current intent metadata:
        $in_metadata = unserialize($ins[0]['in_metadata']);

        //Determines if Intent has been removed OR unlinked:
        $remove_from_ui = 0; //Assume not
        $remove_redirect_url = null;

        //Did anything change?
        $status_update_children = 0;

        //Check to see which variables actually changed:
        foreach ($in_update as $key => $value) {

            //Did this value change?
            if ($value == $ins[0][$key]) {

                //No it did not! Remove it!
                unset($in_update[$key]);

            } else {

                if ($key == 'in_outcome') {

                    //Check to make sure starts with a verb:
                    if($in_update['in_verb_entity_id'] < 1){

                        //Not a acceptable starting word:
                        return echo_json(array(
                            'status' => 0,
                            'message' => 'Verb is not yet supported. Manage supported verbs via entity @5008'.( en_auth(array(1281)) ? ' or use the /force command to add this verb to the supported list.' : '' ),
                        ));

                    }

                    //Check to make sure it's not a duplicate outcome:
                    $duplicate_outcome_ins = $this->Database_model->in_fetch(array(
                        'in_id !=' => $ins[0]['in_id'],
                        'in_status >=' => 0, //New+
                        'LOWER(in_outcome)' => strtolower($value),
                    ));

                    if(count($duplicate_outcome_ins) > 0){
                        //This is a duplicate, disallow:
                        return echo_json(array(
                            'status' => 0,
                            'message' => 'Outcome ['.$value.'] already in use by intent #'.$duplicate_outcome_ins[0]['in_id'],
                        ));
                    } else {
                        //Cleanup outcome before saving:
                        $_POST[$key] = trim($_POST[$key]);
                    }

                } elseif ($key == 'in_status') {

                    //Has intent been removed?
                    if($value < 0){

                        //Intent has been removed:
                        $remove_from_ui = 1;

                        //Did we remove the main intent?
                        if($_POST['level']==1){
                            //Yes, redirect to a parent intent if we have any:
                            if(count($ins[0]['in__parents']) > 0){
                                $remove_redirect_url = '/intents/' . $ins[0]['in__parents'][0]['in_id'];
                            } else {
                                //No parents, redirect to default intent:
                                $remove_redirect_url = '/intents/' . $this->config->item('in_miner_start');
                            }
                        }

                        //Unlink intent links:
                        $links_removed = $this->Platform_model->in_unlink($_POST['in_id'] , $session_en['en_id']);

                        //Treat as if no link (Since it was removed):
                        $ln_id = 0;
                    }

                    if(intval($_POST['apply_recursively'])){

                        //Intent status has changed and there is a recursive update request:
                        $status_update_children = $this->Platform_model->in_recursive_update($_POST['in_id'], 'in_status', $ins[0]['in_status'], $in_update['in_status'], $session_en['en_id']);

                        //Set message in session to inform miner:
                        $this->session->set_flashdata('flash_message', '<div class="alert alert-success" role="alert">' . 'Successfully updated '.$status_update_children.' intent'.echo__s($status_update_children).' recursively.</div>');

                    }
                }

                //This field has been updated, update one field at a time:
                $this->Database_model->in_update($_POST['in_id'], array( $key => $_POST[$key] ), true, $session_en['en_id']);

            }
        }





        //Assume link is not updated:
        $link_was_updated = false;

        //Does this request has an intent link?
        if($ln_id > 0){

            //Validate Link and inputs:
            $lns = $this->Database_model->ln_fetch(array(
                'ln_id' => $ln_id,
                'ln_type_entity_id IN (' . join(',', $this->config->item('en_ids_4486')) . ')' => null, //Intent Link Connectors
                'ln_status >=' => 0, //New+
            ), array(( $_POST['is_parent'] ? 'in_child' : 'in_parent')));
            if(count($lns) < 1){
                return echo_json(array(
                    'status' => 0,
                    'message' => 'Invalid link ID',
                ));
            }

            //Prep link Metadata to see if the conditional score variables have changed:
            $ln_update = array(
                'ln_type_entity_id'     => intval($_POST['ln_type_entity_id']),
                'ln_status'         => intval($_POST['ln_status']),
            );




            //Validate the input for updating linked intent:
            if(substr($_POST['tr_in_link_update'], 0, 1)=='#'){
                $parts = explode(' ', $_POST['tr_in_link_update']);
                $ln_in_link_id = intval(str_replace('#', '', $parts[0]));
            }
            if($ln_in_link_id > 0){

                //Did we find it?
                if($ln_in_link_id==$lns[0]['ln_parent_intent_id'] || $ln_in_link_id==$lns[0]['ln_child_intent_id']){
                    return echo_json(array(
                        'status' => 0,
                        'message' => 'Intent already linked here',
                    ));
                }

                //Validate intent:
                $linked_ins = $this->Database_model->in_fetch(array(
                    'in_id' => $ln_in_link_id,
                ));
                if(count($linked_ins)==0){
                    return echo_json(array(
                        'status' => 0,
                        'message' => 'Newly linked intent not found',
                    ));
                }

                //All good, make the move:
                $ln_update[( $_POST['is_parent'] ? 'ln_child_intent_id' : 'ln_parent_intent_id')] = $ln_in_link_id;
                $ln_update['ln_order'] = 9999; //Place at the bottom of this new list
                $remove_from_ui = 1;
                //Did we move it on another intent on the same page? If so reload to show accurate info:
                if(in_array($ln_in_link_id, $_POST['top_level_ins'])){
                    //Yes, refresh the page:
                    $remove_redirect_url = '/intents/' . $_POST['top_level_ins'][0]; //First item is the main intent
                }
            } elseif(strlen($_POST['tr_in_link_update']) > 0 && !($_POST['tr_in_link_update']==$lns[0]['in_outcome'])){
                //The value changed in an unknown way...
                return echo_json(array(
                    'status' => 0,
                    'message' => 'Unknown '.( $_POST['is_parent'] ? 'child' : 'parent').' intent. Leave as-is or select intent from search suggestions.',
                ));
            }


            //Prep variables:
            $ln_metadata = ( strlen($lns[0]['ln_metadata']) > 0 ? unserialize($lns[0]['ln_metadata']) : array() );

            //Check to see if anything changed in the link?
            $link_meta_updated = ( (($ln_update['ln_type_entity_id'] == 4228 && (
                        !isset($ln_metadata['tr__assessment_points']) ||
                        !(intval($ln_metadata['tr__assessment_points'])==intval($_POST['tr__assessment_points']))
                    ))) || (($ln_update['ln_type_entity_id'] == 4229 && (
                        !isset($ln_metadata['tr__conditional_score_min']) ||
                        !isset($ln_metadata['tr__conditional_score_max']) ||
                        !(doubleval($ln_metadata['tr__conditional_score_max'])==doubleval($_POST['tr__conditional_score_max'])) ||
                        !(doubleval($ln_metadata['tr__conditional_score_min'])==doubleval($_POST['tr__conditional_score_min']))
                    ))));



            foreach ($ln_update as $key => $value) {

                //Did this value change?
                if ($value == $lns[0][$key]) {

                    //No it did not! Remove it!
                    unset($ln_update[$key]);

                } else {

                    if($key=='ln_status' && $value < 0){
                        $remove_from_ui = 1;
                    }

                }

            }

            //Was anything updated?
            if(count($ln_update) > 0 || $link_meta_updated){
                $link_was_updated = true;
            }



            //Did anything change?
            if( $link_was_updated ){

                if($link_meta_updated && (!isset($ln_update['ln_status']) || $ln_update['ln_status'] >= 0)){
                    $ln_update['ln_metadata'] = array_merge( $ln_metadata, array(
                        'tr__conditional_score_min' => doubleval($_POST['tr__conditional_score_min']),
                        'tr__conditional_score_max' => doubleval($_POST['tr__conditional_score_max']),
                        'tr__assessment_points' => intval($_POST['tr__assessment_points']),
                    ));
                }

                //Also update the timestamp & new miner:
                $ln_update['ln_timestamp'] = date("Y-m-d H:i:s");
                $ln_update['ln_miner_entity_id'] = $session_en['en_id'];

                //Update links:
                $this->Database_model->ln_update($ln_id, $ln_update, $session_en['en_id']);
            }

        }



        $return_data = array(
            'status' => 1,
            'message' => '<i class="fas fa-check"></i> Saved',
            'remove_from_ui' => $remove_from_ui,
            'formatted_in_outcome' => ( isset($in_update['in_outcome']) ? echo_in_outcome($in_update['in_outcome']) : null ),
            'remove_redirect_url' => $remove_redirect_url,
            'status_update_children' => $status_update_children,
            'in__metadata_max_steps' => -( isset($in_metadata['in__metadata_max_steps']) ? $in_metadata['in__metadata_max_steps'] : 0 ),
        );


        //Did we have an intent link update? If so, update the last updated UI:
        if($link_was_updated){

            //Fetch last intent Link:
            $lns = $this->Database_model->ln_fetch(array(
                'ln_id' => $ln_id,
            ), array('en_miner'));

        }

        //Show success:
        return echo_json($return_data);

    }

    function in_review_metadata($in_id){
        //Fetch Intent:
        $ins = $this->Database_model->in_fetch(array(
            'in_id' => $in_id,
        ));
        if(count($ins) > 0){
            echo_json(unserialize($ins[0]['in_metadata']));
        } else {
            echo 'Intent #'.$in_id.' not found!';
        }
    }

    function in_sort_save()
    {

        //Authenticate Miner:
        $session_en = en_auth(array(1308));
        if (!$session_en) {
            echo_json(array(
                'status' => 0,
                'message' => 'Invalid Session. Sign In again to Continue.',
            ));
        } elseif (!isset($_POST['in_id']) || intval($_POST['in_id']) < 1) {
            echo_json(array(
                'status' => 0,
                'message' => 'Invalid in_id',
            ));
        } elseif (!isset($_POST['new_ln_orders']) || !is_array($_POST['new_ln_orders']) || count($_POST['new_ln_orders']) < 1) {
            echo_json(array(
                'status' => 0,
                'message' => 'Nothing passed for sorting',
            ));
        } else {

            //Validate Parent intent:
            $parent_ins = $this->Database_model->in_fetch(array(
                'in_id' => intval($_POST['in_id']),
            ));
            if (count($parent_ins) < 1) {
                echo_json(array(
                    'status' => 0,
                    'message' => 'Invalid in_id',
                ));
            } else {

                //Fetch for the record:
                $children_before = $this->Database_model->ln_fetch(array(
                    'ln_parent_intent_id' => intval($_POST['in_id']),
                    'ln_type_entity_id IN (' . join(',', $this->config->item('en_ids_4486')) . ')' => null, //Intent Link Connectors
                    'ln_status >=' => 0,
                ), array('in_child'), 0, 0, array('ln_order' => 'ASC'));

                //Update them all:
                foreach ($_POST['new_ln_orders'] as $rank => $ln_id) {
                    $this->Database_model->ln_update(intval($ln_id), array(
                        'ln_order' => intval($rank),
                    ), $session_en['en_id']);
                }

                //Fetch again for the record:
                $children_after = $this->Database_model->ln_fetch(array(
                    'ln_parent_intent_id' => intval($_POST['in_id']),
                    'ln_type_entity_id IN (' . join(',', $this->config->item('en_ids_4486')) . ')' => null, //Intent Link Connectors
                    'ln_status >=' => 0,
                ), array('in_child'), 0, 0, array('ln_order' => 'ASC'));

                //Display message:
                echo_json(array(
                    'status' => 1,
                    'message' => '<i class="fas fa-check"></i> Sorted',
                ));
            }
        }
    }

    function in_help_messages()
    {

        /*
         *
         * A function to display Platform Tips to give Miners
         * more information on each field and their use-case.
         *
         * */

        //Validate Miner:
        $session_en = en_auth(array(1308));
        if (!$session_en) {
            return echo_json(array(
                'success' => 0,
                'message' => 'Session Expired',
            ));
        } elseif (!isset($_POST['in_id']) || intval($_POST['in_id']) < 1) {
            return echo_json(array(
                'success' => 0,
                'message' => 'Missing Intent ID',
            ));
        }

        //Fetch Intent Note Messages for this intent:
        $on_start_messages = $this->Database_model->ln_fetch(array(
            'ln_status' => 2, //Published
            'ln_type_entity_id' => 4231, //Intent Note Messages
            'ln_child_intent_id' => $_POST['in_id'],
        ), array(), 0, 0, array('ln_order' => 'ASC'));

        if (count($on_start_messages) < 1) {
            return echo_json(array(
                'status' => 0,
                'message' => 'Intent Missing Intent Note Messages',
            ));
        }

        $_GET['log_miner_messages'] = 1; //Will log miner messages which normally do not get logged (so we prevent Intent Note editing logs)

        $tip_messages = null;
        foreach ($on_start_messages as $ln) {
            //What type of message is this?
            $tip_messages .= $this->Communication_model->dispatch_message($ln['ln_content'], $session_en, false, array(), array(
                'ln_parent_intent_id' => $_POST['in_id'],
            ));
        }

        //Return results:
        return echo_json(array(
            'status' => 1,
            'tip_messages' => $tip_messages,
        ));
    }


    function in_messages_iframe($in_id)
    {

        //Authenticate as a Miner:
        $session_en = en_auth(array(1308));
        if (!$session_en) {
            //Display error:
            die('<span style="color:#FF0000;">Error: Invalid Session. Sign In again to continue.</span>');
        } elseif (intval($in_id) < 1) {
            die('<span style="color:#FF0000;">Error: Invalid Intent id.</span>');
        }

        //Don't show the heading here as we're loading inside an iframe:
        $_GET['skip_header'] = 1;

        //Load view:
        $this->load->view('view_shared/platform_header', array(
            'title' => 'Intent #' . $in_id . ' Messages',
        ));
        $this->load->view('view_intents/in_messages_frame', array(
            'in_id' => $in_id,
        ));
        $this->load->view('view_shared/platform_footer');

    }


    function in_new_message_from_text()
    {

        //Authenticate Miner:
        $session_en = en_auth(array(1308));

        if (!$session_en) {

            return echo_json(array(
                'status' => 0,
                'message' => 'Session Expired. Sign In and Try again.',
            ));

        } elseif (!isset($_POST['in_id']) || intval($_POST['in_id']) < 1) {

            return echo_json(array(
                'status' => 0,
                'message' => 'Invalid Intent ID',
            ));

        } elseif (!isset($_POST['focus_ln_type_entity_id']) || intval($_POST['focus_ln_type_entity_id']) < 1) {

            return echo_json(array(
                'status' => 0,
                'message' => 'Missing Message Type',
            ));

        }


        //Fetch/Validate the intent:
        $ins = $this->Database_model->in_fetch(array(
            'in_id' => intval($_POST['in_id']),
            'in_status >=' => 0, //New+
        ));
        if(count($ins)<1){
            return echo_json(array(
                'status' => 0,
                'message' => 'Invalid Intent',
            ));
        }

        //Make sure message is all good:
        $msg_validation = $this->Communication_model->dispatch_validate_message($_POST['ln_content'], array(), false, array(), $_POST['focus_ln_type_entity_id'], $_POST['in_id']);

        if (!$msg_validation['status']) {
            //There was some sort of an error:
            return echo_json($msg_validation);
        }

        //Create Message:
        $ln = $this->Database_model->ln_create(array(
            'ln_status' => 0, //New
            'ln_miner_entity_id' => $session_en['en_id'],
            'ln_order' => 1 + $this->Database_model->ln_max_order(array(
                    'ln_status >=' => 0, //New+
                    'ln_type_entity_id' => intval($_POST['focus_ln_type_entity_id']),
                    'ln_child_intent_id' => intval($_POST['in_id']),
                )),
            //Referencing attributes:
            'ln_type_entity_id' => intval($_POST['focus_ln_type_entity_id']),
            'ln_parent_entity_id' => $msg_validation['ln_parent_entity_id'],
            'ln_parent_intent_id' => $msg_validation['ln_parent_intent_id'],
            'ln_child_intent_id' => intval($_POST['in_id']),
            'ln_content' => $msg_validation['input_message'],
        ), true);

        //Print the challenge:
        return echo_json(array(
            'status' => 1,
            'message' => echo_in_message_manage(array_merge($ln, array(
                'ln_child_entity_id' => $session_en['en_id'],
            ))),
        ));
    }


    function in_new_message_from_attachment()
    {

        //Authenticate Miner:
        $session_en = en_auth(array(1308));
        if (!$session_en) {

            return echo_json(array(
                'status' => 0,
                'message' => 'Invalid Session. Refresh to Continue',
            ));

        } elseif (!isset($_POST['in_id']) || !isset($_POST['focus_ln_type_entity_id'])) {

            return echo_json(array(
                'status' => 0,
                'message' => 'Missing intent data.',
            ));

        } elseif (!isset($_POST['upload_type']) || !in_array($_POST['upload_type'], array('file', 'drop'))) {

            return echo_json(array(
                'status' => 0,
                'message' => 'Unknown upload type.',
            ));

        } elseif (!isset($_FILES[$_POST['upload_type']]['tmp_name']) || strlen($_FILES[$_POST['upload_type']]['tmp_name']) == 0 || intval($_FILES[$_POST['upload_type']]['size']) == 0) {

            return echo_json(array(
                'status' => 0,
                'message' => 'Unknown error while trying to save file.',
            ));

        } elseif ($_FILES[$_POST['upload_type']]['size'] > ($this->config->item('en_file_max_size') * 1024 * 1024)) {

            return echo_json(array(
                'status' => 0,
                'message' => 'File is larger than ' . $this->config->item('en_file_max_size') . ' MB.',
            ));

        }

        //Validate Intent:
        $ins = $this->Database_model->in_fetch(array(
            'in_id' => $_POST['in_id'],
        ));
        if(count($ins)<1){
            return echo_json(array(
                'status' => 0,
                'message' => 'Invalid Intent ID',
            ));
        }

        //See if this message type has specific input requirements:
        $valid_file_types = array(4258, 4259, 4260, 4261); //This must be a valid file type:  Video, Image, Audio or File

        //Attempt to save file locally:
        $file_parts = explode('.', $_FILES[$_POST['upload_type']]["name"]);
        $temp_local = "application/cache/temp_files/" . md5($file_parts[0] . $_FILES[$_POST['upload_type']]["type"] . $_FILES[$_POST['upload_type']]["size"]) . '.' . $file_parts[(count($file_parts) - 1)];
        move_uploaded_file($_FILES[$_POST['upload_type']]['tmp_name'], $temp_local);


        //Attempt to store in Mench Cloud on Amazon S3:
        if (isset($_FILES[$_POST['upload_type']]['type']) && strlen($_FILES[$_POST['upload_type']]['type']) > 0) {
            $mime = $_FILES[$_POST['upload_type']]['type'];
        } else {
            $mime = mime_content_type($temp_local);
        }

        $new_file_url = trim(upload_to_cdn($temp_local, $_FILES[$_POST['upload_type']], true));

        //What happened?
        if (!$new_file_url) {
            //Oops something went wrong:
            return echo_json(array(
                'status' => 0,
                'message' => 'Failed to save file to Mench cloud',
            ));
        }


        //Save URL and connect it to the Mench CDN entity:
        $url_entity = $this->Platform_model->en_sync_url($new_file_url, $session_en['en_id'], 4396 /* Mench CDN Entity */);

        //Did we have an error?
        if (!$url_entity['status']) {
            //Oops something went wrong, return error:
            return $url_entity;
        }


        //Create message:
        $ln = $this->Database_model->ln_create(array(
            'ln_status' => 0, //New
            'ln_miner_entity_id' => $session_en['en_id'],
            'ln_type_entity_id' => $_POST['focus_ln_type_entity_id'],
            'ln_parent_entity_id' => $url_entity['en_url']['en_id'],
            'ln_child_intent_id' => intval($_POST['in_id']),
            'ln_content' => '@' . $url_entity['en_url']['en_id'], //Just place the entity reference as the entire message
            'ln_order' => 1 + $this->Database_model->ln_max_order(array(
                'ln_type_entity_id' => $_POST['focus_ln_type_entity_id'],
                'ln_child_intent_id' => $_POST['in_id'],
            )),
        ));


        //Fetch full message for proper UI display:
        $new_messages = $this->Database_model->ln_fetch(array(
            'ln_id' => $ln['ln_id'],
        ));

        //Echo message:
        echo_json(array(
            'status' => 1,
            'message' => echo_in_message_manage(array_merge($new_messages[0], array(
                'ln_child_entity_id' => $session_en['en_id'],
            ))),
        ));
    }


    function in_load_data()
    {

        /*
         *
         * An AJAX function that is triggered every time a Miner
         * selects to modify an intent. It will check the
         * completion requirements of an intent so it can
         * check proper boxes to help Miner modify the intent.
         *
         * */

        $session_en = en_auth(array(1308));
        if (!$session_en) {
            return echo_json(array(
                'status' => 0,
                'message' => 'Invalid Session. Refresh.',
            ));
        } elseif (!isset($_POST['in_id']) || intval($_POST['in_id']) < 1) {
            return echo_json(array(
                'status' => 0,
                'message' => 'Missing Intent ID',
            ));
        } elseif (!isset($_POST['ln_id'])) {
            return echo_json(array(
                'status' => 0,
                'message' => 'Missing Intent Link ID',
            ));
        }

        //Fetch Intent:
        $ins = $this->Database_model->in_fetch(array(
            'in_id' => $_POST['in_id'],
        ));
        if(count($ins) < 1){
            return echo_json(array(
                'status' => 0,
                'message' => 'Invalid Intent ID',
            ));
        }

        //Prep metadata:
        $ins[0]['in_metadata'] = ( strlen($ins[0]['in_metadata']) > 0 ? unserialize($ins[0]['in_metadata']) : array());


        if(intval($_POST['ln_id'])>0){

            //Fetch intent link:
            $lns = $this->Database_model->ln_fetch(array(
                'ln_id' => $_POST['ln_id'],
                'ln_type_entity_id IN (' . join(',', $this->config->item('en_ids_4486')) . ')' => null, //Intent Link Connectors
                'ln_status >=' => 0, //New+
            ), array(( $_POST['is_parent'] ? 'in_child' : 'in_parent' )));

            if(count($lns) < 1){
                return echo_json(array(
                    'status' => 0,
                    'message' => 'Invalid Intent Link ID',
                ));
            }

            //Add link connector:
            $lns[0]['ln_metadata'] = ( strlen($lns[0]['ln_metadata']) > 0 ? unserialize($lns[0]['ln_metadata']) : array());

            //Make sure points are set:
            if(!isset($lns[0]['ln_metadata']['tr__assessment_points'])){
                $lns[0]['ln_metadata']['tr__assessment_points'] = 0;
            }

        }




        //Adjust formats:
        $ins[0]['in_dollar_cost'] = number_format(doubleval($ins[0]['in_dollar_cost']), 2);

        //Return results:
        return echo_json(array(
            'status' => 1,
            'in' => $ins[0],
            'ln' => ( isset($lns[0]) ? $lns[0] : array() ),
        ));

    }



    function in_message_sort()
    {

        //Authenticate Miner:
        $session_en = en_auth(array(1308));
        if (!$session_en) {

            return echo_json(array(
                'status' => 0,
                'message' => 'Session Expired. Sign In and try again',
            ));

        } elseif (!isset($_POST['new_ln_orders']) || !is_array($_POST['new_ln_orders']) || count($_POST['new_ln_orders']) < 1) {

            //Do not treat this case as error as it could happen in moving Messages between types:
            return echo_json(array(
                'status' => 1,
                'message' => 'There was nothing to sort',
            ));

        }

        //Update all link orders:
        $sort_count = 0;
        foreach ($_POST['new_ln_orders'] as $ln_order => $ln_id) {
            if (intval($ln_id) > 0) {
                $sort_count++;
                //Log update and give credit to the session Miner:
                $this->Database_model->ln_update($ln_id, array(
                    'ln_order' => intval($ln_order),
                ), $session_en['en_id']);
            }
        }

        //Return success:
        return echo_json(array(
            'status' => 1,
            'message' => $sort_count . ' Sorted', //Does not matter as its currently not displayed in UI
        ));
    }

    function in_message_modify()
    {

        //Authenticate Miner:
        $session_en = en_auth(array(1308));
        if (!$session_en) {
            return echo_json(array(
                'status' => 0,
                'message' => 'Invalid Session. Refresh.',
            ));
        } elseif (!isset($_POST['ln_id']) || intval($_POST['ln_id']) < 1) {
            return echo_json(array(
                'status' => 0,
                'message' => 'Missing Link ID',
            ));
        } elseif (!isset($_POST['new_message_ln_status'])) {
            return echo_json(array(
                'status' => 0,
                'message' => 'Missing Message Status',
            ));
        } elseif (!isset($_POST['ln_content'])) {
            return echo_json(array(
                'status' => 0,
                'message' => 'Missing Message',
            ));
        } elseif (!isset($_POST['in_id']) || intval($_POST['in_id']) < 1) {
            return echo_json(array(
                'status' => 0,
                'message' => 'Invalid Intent ID',
            ));
        }

        //Validate Intent:
        $ins = $this->Database_model->in_fetch(array(
            'in_id' => $_POST['in_id'],
        ));
        if (count($ins) < 1) {
            return echo_json(array(
                'status' => 0,
                'message' => 'Intent Not Found',
            ));
        }

        //Validate Message:
        $messages = $this->Database_model->ln_fetch(array(
            'ln_id' => intval($_POST['ln_id']),
            'ln_status >=' => 0,
        ));
        if (count($messages) < 1) {
            return echo_json(array(
                'status' => 0,
                'message' => 'Message Not Found',
            ));
        }


        //Did the message status change?
        if($messages[0]['ln_status'] != $_POST['new_message_ln_status']){

            //Are we deleting this message?
            if($_POST['new_message_ln_status'] == -1){

                //yes, do so and return results:
                $affected_rows = $this->Database_model->ln_update(intval($_POST['ln_id']), array( 'ln_status' => $_POST['new_message_ln_status'] ), $session_en['en_id']);

                //Return success:
                if($affected_rows > 0){
                    return echo_json(array(
                        'status' => 1,
                        'message' => 'Successfully removed',
                    ));
                } else {
                    return echo_json(array(
                        'status' => 0,
                        'message' => 'Error trying to remove message',
                    ));
                }

            } elseif($_POST['new_message_ln_status'] == 2){

                //We're publishing, make sure potential entity references are also published:
                $msg_references = extract_message_references($_POST['ln_content']);

                if (count($msg_references['ref_entities']) > 0) {

                    //We do have an entity reference, what's its status?
                    $ref_ens = $this->Database_model->en_fetch(array(
                        'en_id' => $msg_references['ref_entities'][0],
                    ));

                    if(count($ref_ens)>0 && $ref_ens[0]['en_status']<2){
                        return echo_json(array(
                            'status' => 0,
                            'message' => 'You cannot published this message because its referenced entity is not yet published',
                        ));
                    }
                }
            }
        }



        //Validate new message:
        $msg_validation = $this->Communication_model->dispatch_validate_message($_POST['ln_content'], array(), false, array(), $messages[0]['ln_type_entity_id'], $_POST['in_id']);
        if (!$msg_validation['status']) {
            //There was some sort of an error:
            return echo_json($msg_validation);
        }


        //All good, lets move on:
        //Define what needs to be updated:
        $to_update = array(
            'ln_status' => $_POST['new_message_ln_status'],
            'ln_content' => $msg_validation['input_message'],
            'ln_parent_entity_id' => $msg_validation['ln_parent_entity_id'],
            'ln_parent_intent_id' => $msg_validation['ln_parent_intent_id'],
        );

        //Now update the DB:
        $this->Database_model->ln_update(intval($_POST['ln_id']), $to_update, $session_en['en_id']);

        //Re-fetch the message for display purposes:
        $new_messages = $this->Database_model->ln_fetch(array(
            'ln_id' => intval($_POST['ln_id']),
        ));

        $fixed_fields = $this->config->item('fixed_fields');

        //Print the challenge:
        return echo_json(array(
            'status' => 1,
            'message' => $this->Communication_model->dispatch_message($msg_validation['input_message'], $session_en, false, array(), array(), $_POST['in_id']),
            'message_new_status_icon' => '<span title="' . $fixed_fields['ln_status'][$to_update['ln_status']]['s_name'] . ': ' . $fixed_fields['ln_status'][$to_update['ln_status']]['s_desc'] . '" data-toggle="tooltip" data-placement="top">' . $fixed_fields['ln_status'][$to_update['ln_status']]['s_icon'] . '</span>', //This might have changed
            'success_icon' => '<span><i class="fas fa-check"></i> Saved</span>',
        ));
    }




    function cron__sync_common_base($in_id = 0)
    {

        /*
         *
         * Updates common base metadata for published intents
         *
         * */

        boost_power();
        $start_time = time();
        $filters = array(
            'in_status' => 2,
        );
        if($in_id > 0){
            $filters['in_id'] = $in_id;
        }

        $published_ins = $this->Database_model->in_fetch($filters);
        foreach($published_ins as $published_in){
            $tree = $this->Platform_model->in_metadata_common_base($published_in);
        }

        $total_time = time() - $start_time;
        $success_message = 'Common Base Metadata updated for '.count($published_ins).' published intent'.echo__s(count($published_ins)).'.';
        if (isset($_GET['redirect']) && strlen($_GET['redirect']) > 0) {
            //Now redirect;
            $this->session->set_flashdata('flash_message', '<div class="alert alert-success" role="alert">' . $success_message . '</div>');
            header('Location: ' . $_GET['redirect']);
        } else {
            //Show json:
            echo_json(array(
                'message' => $success_message,
                'total_time' => echo_time_minutes($total_time),
                'item_time' => round(($total_time/count($published_ins)),1).' Seconds',
                'last_tree' => $tree,
            ));
        }
    }


    function cron__sync_extra_insights($in_id = 0)
    {

        /*
         *
         * Updates tree insights (like min/max steps, time & cost)
         * based on its common and expansion tree.
         *
         * */

        boost_power();
        $start_time = time();
        $update_count = 0;

        if($in_id > 0){

            //Increment count by 1:
            $update_count++;

            //Start with common base:
            foreach($this->Database_model->in_fetch(array('in_id' => $in_id)) as $published_in){
                $this->Platform_model->in_metadata_common_base($published_in);
            }

            //Update extra insights:
            $tree = $this->Platform_model->in_metadata_extra_insights($in_id);

        } else {

            //Update all featured intentions and their tree:
            foreach ($this->Database_model->in_fetch(array('in_status' => 2)) as $published_in) {
                $tree = $this->Platform_model->in_metadata_extra_insights($published_in['in_id']);
                if($tree){
                    $update_count++;
                }
            }

        }



        $end_time = time() - $start_time;
        $success_message = 'Extra Insights Metadata updated for '.$update_count.' intent'.echo__s($update_count).'.';

        if (isset($_GET['redirect']) && strlen($_GET['redirect']) > 0) {
            //Now redirect;
            $this->session->set_flashdata('flash_message', '<div class="alert alert-success" role="alert">' . $success_message . '</div>');
            header('Location: ' . $_GET['redirect']);
        } else {
            //Show json:
            echo_json(array(
                'message' => $success_message,
                'total_time' => echo_time_minutes($end_time),
                'item_time' => round(($end_time/$update_count),1).' Seconds',
                'last_tree' => $tree,
            ));
        }
    }

}