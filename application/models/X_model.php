<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class X_model extends CI_Model
{

    /*
     *
     * Member related database functions
     *
     * */

    function __construct()
    {
        parent::__construct();
    }


    function create($add_fields, $external_sync = false)
    {

        //Set some defaults:
        if (!isset($add_fields['x__source']) || intval($add_fields['x__source']) < 1) {
            $add_fields['x__source'] = 14068; //GUEST MEMBER
        }

        //Only require transaction type:
        if (detect_missing_columns($add_fields, array('x__type'), $add_fields['x__source'])) {
            return false;
        }

        if(!in_array($add_fields['x__type'], $this->config->item('n___4593'))){
            $this->X_model->create(array(
                'x__message' => 'x->create() failed to create because of invalid transaction type @'.$add_fields['x__type'],
                'x__type' => 4246, //Platform Bug Reports
                'x__source' => $add_fields['x__source'],
                'x__metadata' => $add_fields,
            ));
            return false;
        }

        //Clean metadata is provided:
        if (isset($add_fields['x__metadata']) && is_array($add_fields['x__metadata'])) {
            $add_fields['x__metadata'] = serialize($add_fields['x__metadata']);
        } else {
            $add_fields['x__metadata'] = null;
        }

        //Set some defaults:
        if (!isset($add_fields['x__message'])) {
            $add_fields['x__message'] = null;
        }


        if (!isset($add_fields['x__time']) || is_null($add_fields['x__time'])) {
            //Time with milliseconds:
            $t = microtime(true);
            $micro = sprintf("%06d", ($t - floor($t)) * 1000000);
            $d = new DateTime(date('Y-m-d H:i:s.' . $micro, $t));
            $add_fields['x__time'] = $d->format("Y-m-d H:i:s.u");
        }

        if (!isset($add_fields['x__status'])|| is_null($add_fields['x__status'])) {
            $add_fields['x__status'] = 6176; //Transaction Published
        }

        //Set some zero defaults if not set:
        foreach(array('x__right', 'x__left', 'x__down', 'x__up', 'x__reference', 'x__spectrum') as $dz) {
            if (!isset($add_fields[$dz])) {
                $add_fields[$dz] = 0;
            }
        }

        //Lets log:
        $this->db->insert('table__x', $add_fields);


        //Fetch inserted id:
        $add_fields['x__id'] = $this->db->insert_id();


        //All good huh?
        if ($add_fields['x__id'] < 1) {

            //This should not happen:
            $this->X_model->create(array(
                'x__type' => 4246, //Platform Bug Reports
                'x__source' => $add_fields['x__source'],
                'x__message' => 'create() Failed to create',
                'x__metadata' => array(
                    'input' => $add_fields,
                ),
            ));

            return false;
        }

        //Sync algolia?
        if ($external_sync) {
            if ($add_fields['x__up'] > 0) {
                update_algolia(12274, $add_fields['x__up']);
            }

            if ($add_fields['x__down'] > 0) {
                update_algolia(12274, $add_fields['x__down']);
            }

            if ($add_fields['x__left'] > 0) {
                update_algolia(12273, $add_fields['x__left']);
            }

            if ($add_fields['x__right'] > 0) {
                update_algolia(12273, $add_fields['x__right']);
            }
        }


        //SOURCE SYNC Status
        if(in_array($add_fields['x__type'] , $this->config->item('n___12401'))){
            if($add_fields['x__down'] > 0){
                $e__id = $add_fields['x__down'];
            } elseif($add_fields['x__up'] > 0){
                $e__id = $add_fields['x__up'];
            }
            $this->E_model->match_x_status($add_fields['x__source'], array(
                'e__id' => $e__id,
            ));
        }

        //IDEA SYNC Status
        if(in_array($add_fields['x__type'] , $this->config->item('n___12400'))){
            if($add_fields['x__right'] > 0){
                $i__id = $add_fields['x__right'];
            } elseif($add_fields['x__left'] > 0){
                $i__id = $add_fields['x__left'];
            }
            $this->I_model->match_x_status($add_fields['x__source'], array(
                'i__id' => $i__id,
            ));
        }



        //See if this transaction type has any subscribers:
        if(in_array($add_fields['x__type'] , $this->config->item('n___5967')) && $add_fields['x__type']!=5967 /* Email Sent causes endless loop */){

            //Try to fetch subscribers:
            $e___5967 = $this->config->item('e___5967'); //Include subscription details
            $sub_emails = array();
            $sub_e__ids = array();
            foreach(explode(',', $e___5967[$add_fields['x__type']]['m__message']) as $subscriber_e__id){

                //Do not inform the member who just took the action:
                if($subscriber_e__id==$add_fields['x__source']){
                    continue;
                }

                //Try fetching subscribers email:
                foreach($this->X_model->fetch(array(
                    'x__status IN (' . join(',', $this->config->item('n___7359')) . ')' => null, //PUBLIC
                    'e__type IN (' . join(',', $this->config->item('n___7357')) . ')' => null, //PUBLIC
                    'x__type IN (' . join(',', $this->config->item('n___4592')) . ')' => null, //SOURCE LINKS
                    'x__up' => 3288, //Email
                    'x__down' => $subscriber_e__id,
                ), array('x__down')) as $e_email){
                    if(filter_var($e_email['x__message'], FILTER_VALIDATE_EMAIL)){
                        //All good, add to list:
                        array_push($sub_e__ids , $e_email['e__id']);
                        array_push($sub_emails , $e_email['x__message']);
                    }
                }
            }


            //Did we find any subscribers?
            if(count($sub_e__ids) > 0){

                //yes, start drafting email to be sent to them...
                $u_name = get_domain('m__title');
                if($add_fields['x__source'] > 0){
                    //Fetch member details:
                    $add_e = $this->E_model->fetch(array(
                        'e__id' => $add_fields['x__source'],
                    ));
                    if(count($add_e)){
                        $u_name = $add_e[0]['e__title'];
                    }
                }


                //Email Subject:
                $subject = 'Notification: '  . $u_name . ' ' . $e___5967[$add_fields['x__type']]['m__title'];

                //Compose email body, start with transaction content:
                $html_message = ( strlen($add_fields['x__message']) > 0 ? '<div>' .$add_fields['x__message'].'</div>' : '') . '<br />';

                $var_index = var_index();

                //Append transaction object transactions:
                foreach($this->config->item('e___11081') as $e__id => $m) {

                    if(!array_key_exists($e__id, $var_index) || !intval($add_fields[$var_index[$e__id]])){
                        continue;
                    }

                    if (in_array(6202 , $m['m__profile'])) {

                        //IDEA
                        $is = $this->I_model->fetch(array( 'i__id' => $add_fields[$var_index[$e__id]] ));
                        $html_message .= '<div>' . $m['m__title'] . ': <a href="'.$this->config->item('base_url').'/i/i_go/' . $is[0]['i__id'] . '" target="_parent">#'.$is[0]['i__id'].' '.$is[0]['i__title'].'</a></div>';

                    } elseif (in_array(6160 , $m['m__profile'])) {

                        //SOURCE
                        $es = $this->E_model->fetch(array( 'e__id' => $add_fields[$var_index[$e__id]] ));
                        if(count($es)){
                            $html_message .= '<div>' . $m['m__title'] . ': <a href="'.$this->config->item('base_url').'/@' . $es[0]['e__id'] . '" target="_parent">@'.$es[0]['e__id'].' '.$es[0]['e__title'].'</a></div>';
                        }

                    } elseif (in_array(4367 , $m['m__profile'])) {

                        //READ
                        $html_message .= '<div>' . $m['m__title'] . ' ID: <a href="'.$this->config->item('base_url').'/-12722?x__id=' . $add_fields[$var_index[$e__id]] . '" target="_parent">'.$add_fields[$var_index[$e__id]].'</a></div>';

                    }

                }

                //Finally append READ ID:
                $html_message .= '<div>TRANSACTION ID: <a href="'.$this->config->item('base_url').'/-12722?x__id=' . $add_fields['x__id'] . '">' . $add_fields['x__id'] . '</a></div>';

                //Inform how to change settings:
                $html_message .= '<div style="color: #999999; font-size:0.9em; margin-top:20px;">Manage your email notifications via <a href="'.$this->config->item('base_url').'/@5967" target="_blank">@5967</a></div>';

                //Send email:
                $this->X_model->email_sent($sub_emails, $subject, $html_message);

                //Log emails sent:
                foreach($sub_e__ids as $to_e__id){
                    $this->X_model->create(array(
                        'x__type' => 5967, //Transaction Carbon Copy Email
                        'x__source' => $to_e__id, //Sent to this u
                        'x__reference' => $add_fields['x__id'], //Save transaction

                        //Import potential Idea/source connections from transaction:
                        'x__right' => $add_fields['x__right'],
                        'x__left' => $add_fields['x__left'],
                        'x__down' => $add_fields['x__down'],
                        'x__up' => $add_fields['x__up'],
                    ));
                }
            }
        }

        //Return:
        return $add_fields;

    }

    function fetch($query_filters = array(), $join_objects = array(), $limit = 100, $limit_offset = 0, $order_columns = array('x__id' => 'DESC'), $select = '*', $group_by = null)
    {

        $this->db->select($select);
        $this->db->from('table__x');

        //IDA JOIN?
        if (in_array('x__left', $join_objects)) {
            $this->db->join('table__i', 'x__left=i__id','left');
        } elseif (in_array('x__right', $join_objects)) {
            $this->db->join('table__i', 'x__right=i__id','left');
        }

        //SOURCE JOIN?
        if (in_array('x__up', $join_objects)) {
            $this->db->join('table__e', 'x__up=e__id','left');
        } elseif (in_array('x__down', $join_objects)) {
            $this->db->join('table__e', 'x__down=e__id','left');
        } elseif (in_array('x__type', $join_objects)) {
            $this->db->join('table__e', 'x__type=e__id','left');
        } elseif (in_array('x__source', $join_objects)) {
            $this->db->join('table__e', 'x__source=e__id','left');
        }

        foreach($query_filters as $key => $value) {
            if (!is_null($value)) {
                $this->db->where($key, $value);
            } else {
                $this->db->where($key);
            }
        }

        if ($group_by) {
            $this->db->group_by($group_by);
        }

        foreach($order_columns as $key => $value) {
            $this->db->order_by($key, $value);
        }

        if ($limit > 0) {
            $this->db->limit($limit, $limit_offset);
        }
        $q = $this->db->get();
        return $q->result_array();
    }

    function update($id, $update_columns, $x__source = 0, $x__type = 0, $x__message = '')
    {

        $id = intval($id);
        if (count($update_columns) == 0) {
            return false;
        } elseif ($x__type>0 && !in_array($x__type, $this->config->item('n___4593'))) {
            $this->X_model->create(array(
                'x__message' => 'x->update() failed to update because of invalid transaction type @'.$x__type,
                'x__type' => 4246, //Platform Bug Reports
                'x__source' => $x__source,
                'x__metadata' => $update_columns,
            ));
            return false;
        }

        if($x__source > 0){
            //Fetch transaction before updating:
            $before_data = $this->X_model->fetch(array(
                'x__id' => $id,
            ));
        }

        //Update metadata if needed:
        if(isset($update_columns['x__metadata']) && is_array($update_columns['x__metadata'])){
            $update_columns['x__metadata'] = serialize($update_columns['x__metadata']);
        }

        //Set content to null if defined as empty:
        if(isset($update_columns['x__message']) && !strlen($update_columns['x__message'])){
            $update_columns['x__message'] = null;
        }

        //Update:
        $this->db->where('x__id', $id);
        $this->db->update('table__x', $update_columns);
        $affected_rows = $this->db->affected_rows();

        //Log changes if successful:
        if ($affected_rows > 0 && $x__source > 0 && $x__type > 0) {

            if(strlen($x__message) == 0){
                if(in_array($x__type, $this->config->item('n___10593') /* Statement */)){

                    //Since it's a statement we want to determine the change in content:
                    if($before_data[0]['x__message']!=$update_columns['x__message']){
                        $x__message .= update_description($before_data[0]['x__message'], $update_columns['x__message']);
                    }

                } else {

                    //Log modification transaction for every field changed:
                    foreach($update_columns as $key => $value) {
                        if($before_data[0][$key]==$value){
                            continue;
                        }

                        //Now determine what type is this:
                        if($key=='x__status'){

                            $e___6186 = $this->config->item('e___6186'); //Transaction Status
                            $x__message .= view_db_field($key) . ' updated from [' . $e___6186[$before_data[0][$key]]['m__title'] . '] to [' . $e___6186[$value]['m__title'] . ']'."\n";

                        } elseif($key=='x__type'){

                            $e___4593 = $this->config->item('e___4593'); //Transaction Types
                            $x__message .= view_db_field($key) . ' updated from [' . $e___4593[$before_data[0][$key]]['m__title'] . '] to [' . $e___4593[$value]['m__title'] . ']'."\n";

                        } elseif(in_array($key, array('x__up', 'x__down'))) {

                            //Fetch new/old source names:
                            $befores = $this->E_model->fetch(array(
                                'e__id' => $before_data[0][$key],
                            ));
                            $after_e = $this->E_model->fetch(array(
                                'e__id' => $value,
                            ));

                            $x__message .= view_db_field($key) . ' updated from [' . $befores[0]['e__title'] . '] to [' . $after_e[0]['e__title'] . ']' . "\n";

                        } elseif(in_array($key, array('x__left', 'x__right'))) {

                            //Fetch new/old Idea outcomes:
                            $before_i = $this->I_model->fetch(array(
                                'i__id' => $before_data[0][$key],
                            ));
                            $after_i = $this->I_model->fetch(array(
                                'i__id' => $value,
                            ));

                            $x__message .= view_db_field($key) . ' updated from [' . $before_i[0]['i__title'] . '] to [' . $after_i[0]['i__title'] . ']' . "\n";

                        } elseif(in_array($key, array('x__message', 'x__spectrum'))){

                            $x__message .= view_db_field($key) . ' updated from [' . $before_data[0][$key] . '] to [' . $value . ']'."\n";

                        } else {

                            //Should not log updates since not specifically programmed:
                            continue;

                        }
                    }
                }
            }

            //Determine fields that have changed:
            $fields_changed = array();
            foreach($update_columns as $key => $value) {
                if($before_data[0][$key]!=$value){
                    array_push($fields_changed, array(
                        'field' => $key,
                        'before' => $before_data[0][$key],
                        'after' => $value,
                    ));
                }
            }

            if(strlen($x__message) > 0 && count($fields_changed) > 0){
                //Value has changed, log transaction:
                $this->X_model->create(array(
                    'x__reference' => $id, //Transaction Reference
                    'x__source' => $x__source,
                    'x__type' => $x__type,
                    'x__message' => $x__message,
                    'x__metadata' => array(
                        'x__id' => $id,
                        'fields_changed' => $fields_changed,
                    ),
                    //Copy old values:
                    'x__up' => $before_data[0]['x__up'],
                    'x__down'  => $before_data[0]['x__down'],
                    'x__left' => $before_data[0]['x__left'],
                    'x__right'  => $before_data[0]['x__right'],
                ));
            }
        }

        return $affected_rows;
    }

    function max_spectrum($query_filters)
    {

        //Fetches the maximum order value
        $this->db->select('MAX(x__spectrum) as largest_order');
        $this->db->from('table__x');
        foreach($query_filters as $key => $value) {
            $this->db->where($key, $value);
        }
        $q = $this->db->get();
        $stats = $q->row_array();
        return ( count($stats) > 0 ? intval($stats['largest_order']) : 0 );

    }



    function email_sent($to_array, $subject, $html_message)
    {

        /*
         *
         * Send an email via our Amazon server
         *
         * */

        //Loadup amazon SES:
        require_once('application/libraries/aws/aws-autoloader.php');
        $this->CLIENT = new Aws\Ses\SesClient([
            'version' => 'latest',
            'region' => 'us-west-2',
            'credentials' => $this->config->item('cred_aws'),
        ]);

        $this->CLIENT->sendEmail(array(
            // Source is required
            'Source' => view_memory(6404,3288),
            // Destination is required
            'Destination' => array(
                'ToAddresses' => $to_array,
                'CcAddresses' => array(),
                'BccAddresses' => array(),
            ),
            // Message is required
            'Message' => array(
                // Subject is required
                'Subject' => array(
                    // Data is required
                    'Data' => $subject,
                    'Charset' => 'UTF-8',
                ),
                // Body is required
                'Body' => array(
                    'Text' => array(
                        // Data is required
                        'Data' => strip_tags($html_message),
                        'Charset' => 'UTF-8',
                    ),
                    'Html' => array(
                        // Data is required
                        'Data' => $html_message,
                        'Charset' => 'UTF-8',
                    ),
                ),
            ),
            'ReplyToAddresses' => array(view_memory(6404,3288)),
            'ReturnPath' => view_memory(6404,3288),
        ));

        return true;

    }


    function message_view($message_input, $is_read_mode, $member_e = array(), $message_i__id = 0, $simple_version = false)
    {

        /*
         *
         * The primary function that constructs messages based on the following inputs:
         *
         *
         * - $message_input:        The message text which may include source
         *                          references like "@123". This may NOT include
         *                          URLs as they must be first turned into an
         *                          source and then referenced within a message.
         *
         *
         * - $member_e:         The source object that this message is supposed
         *                          to be delivered to. May be an empty array for
         *                          when we want to show these messages to guests,
         *                          and it may contain the full source object or it
         *                          may only contain the source ID, which enables this
         *                          function to fetch further information from that
         *                          source as required based on its other parameters.
         *
         * */

        //This could happen with random messages
        if(strlen($message_input) < 1){
            return false;
        }

        //Validate message:
        $msg_validation = $this->X_model->message_compile($message_input, $is_read_mode, $member_e, 0, $message_i__id, false, $simple_version);


        //Did we have ane error in message validation?
        if (!$msg_validation['status'] || !isset($msg_validation['output_messages'])) {

            //Log Error Transaction:
            $this->X_model->create(array(
                'x__type' => 4246, //Platform Bug Reports
                'x__source' => (isset($member_e['e__id']) ? $member_e['e__id'] : 0),
                'x__message' => 'message_compile() returned error [' . $msg_validation['message'] . '] for input message [' . $message_input . ']',
                'x__metadata' => array(
                    'clean_message' => $message_input,
                    'member_e' => $member_e,
                    'message_i__id' => $message_i__id
                ),
            ));

            return false;
        }

        //Message validation passed...
        return $msg_validation['output_messages'];

    }


    function message_compile($message_input, $is_read_mode, $member_e = array(), $message_type_e__id = 0, $message_i__id = 0, $strict_validation = true, $simple_version = false)
    {

        /*
         *
         * This function is used to validate IDEA NOTES.
         *
         * See message_view() for more information on input variables.
         *
         * */


        //Try to fetch session if recipient not provided:
        if(!isset($member_e['e__id'])){
            $member_e = superpower_unlocked();
        }

        $e___6177 = $this->config->item('e___6177');
        $e___4485 = $this->config->item('e___4485');

        //Cleanup:
        $message_input = trim($message_input);
        $message_input = str_replace('’','\'',$message_input);

        //Start with basic input validation:
        if (strlen($message_input) < 1) {
            return array(
                'status' => 0,
                'message' => 'Missing Message',
            );
        } elseif ($strict_validation && strlen($message_input) > view_memory(6404,4485)) {
            return array(
                'status' => 0,
                'message' => 'Message is '.strlen($message_input).' characters long which is more than the allowed ' . view_memory(6404,4485) . ' characters',
            );
        } elseif (!preg_match('//u', $message_input)) {
            return array(
                'status' => 0,
                'message' => 'Message must be UTF8',
            );
        } elseif ($message_type_e__id > 0 && !in_array($message_type_e__id, $this->config->item('n___4485'))) {
            return array(
                'status' => 0,
                'message' => 'Invalid Message type ID',
            );
        }



        /*
         *
         * Source Creation within Message?
         *
         * */
        if($strict_validation && substr_count($message_input, '++')>0 && substr_count($message_input, '@')>=substr_count($message_input, '~')){
            //We Seem to have a creation mode:
            $e__title = one_two_explode('@','++',$message_input);
            $added_e = $this->E_model->verify_create($e__title, $member_e['e__id']);
            if(!$added_e['status']){
                return $added_e;
            } else {
                //New source added, replace text:
                $message_input = str_replace($e__title.'++', $added_e['new_e']['e__id'], $message_input);
            }
        }
        //Do we have a second source creation?
        if($strict_validation && substr_count($message_input, '@')==2 && substr_count($message_input, '++')==1){
            //We Seem to have a creation mode:
            $e__title = one_two_explode('@','++',$message_input);
            $added_e = $this->E_model->verify_create($e__title, $member_e['e__id']);
            if(!$added_e['status']){
                return $added_e;
            } else {
                //New source added, replace text:
                $message_input = str_replace($e__title.'++', $added_e['new_e']['e__id'], $message_input);
            }
        }



        /*
         *
         * Let's do a generic message reference validation
         * that does not consider $message_type_e__id if passed
         *
         * */
        $string_references = extract_e_references($message_input);

        if($strict_validation && $message_type_e__id > 0){

            if(in_array($message_type_e__id, $this->config->item('n___4986'))){
                //IDEA NOTES 2X SOURCE REFERENCES ALLOWED
                $min_e = 0;
                $max_e = 2;
            } elseif(in_array($message_type_e__id, $this->config->item('n___7551'))){
                //IDEA NOTES 1X SOURCE REFERENCE REQUIRED
                $min_e = 1;
                $max_e = 1;
            } else {
                $min_e = 0;
                $max_e = 0;
            }

            /*
             *
             * $message_type_e__id Validation
             * only in strict mode!
             *
             * */

            //URLs are the same as a source:
            $total_references = count($string_references['ref_e']) + count($string_references['ref_urls']);

            if($total_references<$min_e || $total_references>$max_e){
                return array(
                    'status' => 0,
                    'message' => 'You referenced '.$total_references.' source'.view__s($total_references).' but you must have '.$min_e.( $max_e!=$min_e ? '-'.$max_e : '' ).' source references.',
                );
            }
        }









        /*
         *
         * Transform URLs into Source
         *
         * */
        if ($strict_validation && count($string_references['ref_urls']) > 0) {

            foreach($string_references['ref_urls'] as $url_key => $input_url) {

                //No source, but we have a URL that we should turn into an source if not previously:
                $url_e = $this->E_model->url($input_url, ( isset($member_e['e__id']) ? $member_e['e__id'] : 0 ));

                //Did we have an error?
                if (!$url_e['status'] || !isset($url_e['e_url']['e__id']) || intval($url_e['e_url']['e__id']) < 1) {
                    return $url_e;
                }

                //Transform URL into a source:
                if(intval($url_e['e_url']['e__id']) > 0){

                    array_push($string_references['ref_e'], intval($url_e['e_url']['e__id']));

                    //Replace the URL with this new @source in message.
                    //This is the only valid modification we can do to $message_input before storing it in the DB:
                    $message_input = str_replace($input_url, '@' . $url_e['e_url']['e__id'], $message_input);

                    //Remove URL:
                    unset($string_references['ref_urls'][$url_key]);

                }
            }
        }


        /*
         *
         * Referenced Sources
         *
         * */


        //Start building the Output message body based on format:

        $message_input .= ' ';//Helps with accurate source reference replacement
        $output_body_message = htmlentities($message_input);
        $string_references = extract_e_references($message_input); //Do it again since it may be updated
        $referenced_key = 0;
        $e_reference_keys = array(
            0 => 'x__up',
            1 => 'x__down',
        );
        $e_reference_fields = array(
            'x__up'   => 0,
            'x__down' => 0,
        );

        if(count($string_references['ref_e']) > 2){
            return array(
                'status' => 0,
                'message' => 'You referenced '.count($string_references['ref_e']).' sources which is more than the allowed 2 references per line',
            );
        }

        foreach($string_references['ref_e'] as $referenced_e){

            //We have a reference within this message, let's fetch it to better understand it:
            $es = $this->E_model->fetch(array(
                'e__type IN (' . join(',', $this->config->item('n___7358')) . ')' => null, //ACTIVE
                'e__id' => $referenced_e,
            ));
            if (count($es) < 1) {
                return array(
                    'status' => 0,
                    'message' => 'The referenced source @' . $referenced_e . ' not found',
                );
            }

            //Set as source reference:
            $e_reference_key_val = $e_reference_keys[$referenced_key];
            $e_reference_fields[$e_reference_key_val] = intval($referenced_e);


            //See if this source has any parent transactions to be shown in this appendix
            $e_urls = array();
            $e_media_count = 0;
            $e_count = 0;
            $e_appendix = null;
            $first_segment = $this->uri->segment(1);
            $is_current_e = ( $first_segment == '@'.$referenced_e );
            $tooltip_info = null;


            //Determine what type of Media this reference has:
            if(!$simple_version && (!$is_current_e || $string_references['ref_time_found'])){

                foreach($this->X_model->fetch(array(
                    'e__type IN (' . join(',', $this->config->item('n___7357')) . ')' => null, //PUBLIC
                    'x__status IN (' . join(',', $this->config->item('n___7359')) . ')' => null, //PUBLIC
                    'x__type IN (' . join(',', $this->config->item('n___12822')) . ')' => null, //SOURCE LINK MESSAGE DISPLAY
                    'x__down' => $referenced_e,
                ), array('x__up'), 0, 0, array(
                    'x__type' => 'ASC', /* Text first */
                    'e__spectrum' => 'DESC',
                )) as $e_profile) {

                    if(in_array($e_profile['e__id'], $this->config->item('n___4755'))){
                        //Private Transactions Not Allowed:
                        continue;
                    }

                    $e_count++;

                    if (in_array($e_profile['x__type'], $this->config->item('n___13899'))) {

                        //TOOLTIP INFO
                        $tooltip_info .= ( strlen($tooltip_info) ? ' | ' : '' ).$e_profile['e__title'].': ' . $e_profile['x__message'];

                    } elseif (in_array($e_profile['x__type'], $this->config->item('n___12524'))) {

                        //SOURCE LINK VISUAL
                        $e_media_count++;
                        $e_appendix .= '<div class="e-appendix paddingup">' . view_x__message($e_profile['x__message'], $e_profile['x__type'], $message_input, $is_read_mode) . '</div>';

                    } elseif($e_profile['x__type'] == 4256 /* URL */) {

                        array_push($e_urls, $e_profile['x__message']);
                        $e_appendix .= '<div class="e-appendix paddingup inline-block"><a href="'.$e_profile['x__message'].'" target="_blank" class="ignore-click" title="' . $e_profile['e__title'] . '" data-toggle="tooltip" data-placement="top"><span class="icon-block-xs">'.view_e__icon($e_profile['e__icon']).'</span></a></div>';

                    } else {

                        //Text and Percentage, etc...
                        $e_appendix .= '<div class="e-appendix paddingup"><span class="icon-block-xs">' . $e_profile['e__icon'].'</span>' . $e_profile['e__title'].': ' . $e_profile['x__message'] . '</div>';

                    }
                }
            }







            //Append any appendix generated:
            $is_single_link = ( count($e_urls)==1 && !$e_media_count );

            $identifier_string = '@' . $referenced_e.($string_references['ref_time_found'] ? one_two_explode('@' . $referenced_e,' ',$message_input) : '' );
            $tooltip_class = ( $tooltip_info ? ' title="'.$tooltip_info.'" data-toggle="tooltip" data-placement="bottom"' : '' );


            $edit_btn = null;
            if(!$is_read_mode && source_of_e($es[0]['e__id'])){
                $e___11035 = $this->config->item('e___11035');
                $tooltip_class .= ' class="ignore-click trigger_13571_edit" e__id="' . $es[0]['e__id'] . '" ';
                $edit_btn = '<span e__id="' . $es[0]['e__id'] . '" class="ignore-click icon-block-img trigger_13571_edit" title="'.$e___11035[13571]['m__title'].'">'.view_e__icon($es[0]['e__icon']).'</span> ';
            }

            $on_its_own_line = false;
            $new_lines = 0;
            if($e_media_count > 0){
                foreach(explode("\n", $message_input) as $line){
                    if(strlen($line) > 0){
                        $new_lines++;
                    }
                    if(!$on_its_own_line && trim($line)==$identifier_string){
                        $on_its_own_line = true;
                    }
                }
            }

            if($is_single_link){

                $output_body_message = str_replace($identifier_string, $edit_btn.'<span '.$tooltip_class.'><a href="'.$e_urls[0].'" class="text__6197_'.$es[0]['e__id'].' ignore-click" target="_blank" ><u>' . $es[0]['e__title'] . '</u></a></span>', $output_body_message);

            } else {

                if($on_its_own_line){
                    if($new_lines <= 1){
                        $output_body_message = $e_appendix.str_replace($identifier_string, $edit_btn.'<span '.$tooltip_class.'><span class="subtle-line mini-grey text__6197_'.$es[0]['e__id'].'">' . $es[0]['e__title'] . '</span></span> ', $output_body_message);
                    } else {
                        $output_body_message = str_replace($identifier_string, $edit_btn.'<span '.$tooltip_class.'><span class="subtle-line mini-grey text__6197_'.$es[0]['e__id'].'">' . $es[0]['e__title'] . '</span></span> ', $output_body_message).$e_appendix;
                    }
                } else {
                    $output_body_message = str_replace($identifier_string, $edit_btn.'<span '.$tooltip_class.'><span class="text__6197_'.$es[0]['e__id'].'">' . $es[0]['e__title'] . '</span></span>', $output_body_message).$e_appendix;
                }

            }


            $referenced_key++;
        }


        //Return results:
        return array(
            'status' => 1,
            'clean_message' => trim($message_input),
            'output_messages' => ( strlen($output_body_message) ? '<div class="msg"><span>' . nl2br($output_body_message) . '</span></div>' : null ),
            //Source References:
            'x__up' => $e_reference_fields['x__up'],
            'x__down' => $e_reference_fields['x__down'],
        );
    }



    function find_previous($e__id, $top_i__id, $i__id)
    {

        //Fetch parents:
        foreach($this->X_model->fetch(array(
            'i__type IN (' . join(',', $this->config->item('n___7355')) . ')' => null, //PUBLIC
            'x__status IN (' . join(',', $this->config->item('n___7359')) . ')' => null, //PUBLIC
            'x__type IN (' . join(',', $this->config->item('n___4486')) . ')' => null, //IDEA LINKS
            'x__right' => $i__id,
        ), array('x__left')) as $i_previous) {

            //Validate Selection:
            $is_or_i = in_array($i_previous['i__type'], $this->config->item('n___6193'));
            $is_fixed_x = in_array($i_previous['x__type'], $this->config->item('n___12840'));
            if($e__id>0 && ($is_or_i || !$is_fixed_x) && !count($this->X_model->fetch(array(
                    'x__status IN (' . join(',', $this->config->item('n___7359')) . ')' => null, //PUBLIC
                    'x__type IN (' . join(',', $this->config->item('n___12326')) . ')' => null, //READ EXPANSIONS
                    'x__left' => $i_previous['i__id'],
                    'x__right' => $i__id,
                    'x__source' => $e__id,
                )))){
                continue;
            }

            //Did we find it?
            if($i_previous['i__id']==$top_i__id){
                return array($i_previous);
            }

            //Keep looking:
            $top_search = $this->X_model->find_previous($e__id, $top_i__id, $i_previous['i__id']);
            if(count($top_search)){
                array_push($top_search, $i_previous);
                return $top_search;
            }
        }

        //Did not find any parents:
        return array();

    }




    function find_next($e__id, $top_i__id, $i, $find_after_i__id = 0, $search_up = true, $top_completed = false)
    {

        $is_or_i = in_array($i['i__type'], $this->config->item('n___6193'));
        $found_trigger = false;
        foreach ($this->X_model->fetch(array(
            'x__left' => $i['i__id'],
            'x__type IN (' . join(',', $this->config->item('n___4486')) . ')' => null, //IDEA LINKS
            'x__status IN (' . join(',', $this->config->item('n___7359')) . ')' => null, //PUBLIC
            'i__type IN (' . join(',', $this->config->item('n___7355')) . ')' => null, //PUBLIC
        ), array('x__right'), 0, 0, array('x__spectrum' => 'ASC')) as $next_i) {

            //Validate Find After:
            if ($find_after_i__id && !$found_trigger) {
                if ($next_i['i__id'] == $find_after_i__id) {
                    $found_trigger = true;
                }
                continue;
            }

            //Validate Selection:
            $is_fixed_x = in_array($next_i['x__type'], $this->config->item('n___12840'));
            if(($is_or_i || !$is_fixed_x) && !count($this->X_model->fetch(array(
                    'x__status IN (' . join(',', $this->config->item('n___7359')) . ')' => null, //PUBLIC
                    'x__type IN (' . join(',', $this->config->item('n___12326')) . ')' => null, //READ EXPANSIONS
                    'x__left' => $i['i__id'],
                    'x__right' => $next_i['i__id'],
                    'x__source' => $e__id,
                )))){
                continue;
            }


            //Return this if everything is completed, or if this is incomplete:
            if($top_completed || !count($this->X_model->fetch(array(
                    'x__status IN (' . join(',', $this->config->item('n___7359')) . ')' => null, //PUBLIC
                    'x__type IN (' . join(',', $this->config->item('n___12229')) . ')' => null, //READ COMPLETE
                    'x__source' => $e__id,
                    'x__left' => $next_i['i__id'],
                )))){
                return intval($next_i['i__id']);
            }


            //Keep looking deeper:
            $found_next = $this->X_model->find_next($e__id, $top_i__id, $next_i, 0, false, $top_completed);
            if ($found_next) {
                return $found_next;
            }

        }


        if ($search_up && $top_i__id!=$i['i__id']) {
            //Check Previous/Up
            $current_previous = $i['i__id'];
            foreach (array_reverse($this->X_model->find_previous($e__id, $top_i__id, $i['i__id'])) as $p_i) {
                //Find the next siblings:
                $found_next = $this->X_model->find_next($e__id, $top_i__id, $p_i, $current_previous, false, $top_completed);
                if ($found_next) {
                    return $found_next;
                }
                $current_previous = $p_i['i__id'];
            }
        }


        //Nothing found:
        return 0;

    }


    function delete($x__id){

        $member_e = superpower_unlocked();
        if (!$member_e) {
            return array(
                'status' => 0,
                'message' => view_unauthorized_message(),
            );
        }

        $this->X_model->update($x__id, array(
            'x__status' => 6173, //DELETED
        ), $member_e['e__id'], 6155);

        return array(
            'status' => 1,
            'message' => 'Success',
        );

    }

    function start($e__id, $i__id, $recommender_i__id = 0){

        //Validate Idea ID:
        $is = $this->I_model->fetch(array(
            'i__id' => $i__id,
            'i__type IN (' . join(',', $this->config->item('n___7355')) . ')' => null, //PUBLIC
        ));
        if (count($is) != 1 || !i_is_startable($is[0])) {
            return 0;
        }

        $next_i__id = $i__id;


        //Make sure not previously added to this Member's reads:
        if(!count($this->X_model->fetch(array(
                'x__source' => $e__id,
                'x__left' => $i__id,
                'x__type IN (' . join(',', $this->config->item('n___12969')) . ')' => null, //MY READS
                'x__status IN (' . join(',', $this->config->item('n___7359')) . ')' => null, //PUBLIC
            )))){

            //Not added to their reads so far, let's go ahead and add it:
            $i_rank = 1;
            $home = $this->X_model->create(array(
                'x__type' => ( $recommender_i__id > 0 ? 7495 /* Member Idea Recommended */ : 4235 /* Member Idea Set */ ),
                'x__source' => $e__id, //Belongs to this Member
                'x__left' => $is[0]['i__id'], //The Idea they are adding
                'x__right' => $recommender_i__id, //Store the recommended idea
                'x__spectrum' => $i_rank, //Always place at the top of their reads
            ));

            //Can we auto complete since they have already read this idea?
            if(in_array($is[0]['i__type'], $this->config->item('n___12330'))){

                //YES, Mark as complete:
                $this->X_model->mark_complete($is[0]['i__id'], $is[0], array(
                    'x__type' => 4559, //READ MESSAGES
                    'x__source' => $e__id,
                ));

                //Now find next idea:
                $next_i__id = $this->X_model->find_next($e__id, $is[0]['i__id'], $is[0]);
            }

            //Move other ideas down in the read List:
            foreach($this->X_model->fetch(array(
                'x__id !=' => $home['x__id'], //Not the newly added idea
                'x__type IN (' . join(',', $this->config->item('n___12969')) . ')' => null, //MY READS
                'x__status IN (' . join(',', $this->config->item('n___7359')) . ')' => null, //PUBLIC
                'x__source' => $e__id, //Belongs to this Member
            ), array(), 0, 0, array('x__spectrum' => 'ASC')) as $current_i){

                //Increase rank:
                $i_rank++;

                //Update order:
                $this->X_model->update($current_i['x__id'], array(
                    'x__spectrum' => $i_rank,
                ), $e__id, 10681 /* Ideas Ordered Automatically  */);

            }

        }

        return $next_i__id;

    }




    function completion_recursive_up($e__id, $top_i__id, $i, $is_bottom_level = true){

        /*
         *
         * Let's see how many steps get unlocked @6410
         *
         * */

        //First let's make sure this entire Idea completed by member:
        $completion_rate = $this->X_model->completion_progress($e__id, $i);


        if($completion_rate['completion_percentage'] < 100){
            //Not completed, so can't go further up:
            return array();
        }


        //Look at Conditional Idea Transactions ONLY at this level:
        $i__metadata = unserialize($i['i__metadata']);
        if(isset($i__metadata['i___6283'][$i['i__id']]) && count($i__metadata['i___6283'][$i['i__id']]) > 0){

            //Make sure previous transaction unlocks have NOT happened before:
            $existing_expansions = $this->X_model->fetch(array(
                'x__status IN (' . join(',', $this->config->item('n___7359')) . ')' => null, //PUBLIC
                'x__type' => 6140, //READ UNLOCK LINK
                'x__source' => $e__id,
                'x__left' => $i['i__id'],
                'x__right IN (' . join(',', $i__metadata['i___6283'][$i['i__id']]) . ')' => null, //Limit to cached answers
            ));

            if(count($existing_expansions) > 0){

                //Oh we do have an expansion that previously happened! So skip this:
                /*
                 * This was being triggered but I am not sure if its normal or not!
                 * For now will comment out so no errors are logged
                 * TODO: See if you can make sense of this section. The question is
                 * if we would ever try to process a conditional step twice? If it
                 * happens, is it an error or not, and should simply be ignored?
                 *
                $this->X_model->create(array(
                    'x__left' => $i['i__id'],
                    'x__right' => $existing_expansions[0]['x__right'],
                    'x__message' => 'completion_recursive_up() detected duplicate Label Expansion entries',
                    'x__type' => 4246, //Platform Bug Reports
                    'x__source' => $e__id,
                ));
                */

                return array();

            }


            //Yes, Let's calculate u's score for this idea:
            $u_marks = $this->X_model->completion_marks($e__id, $i);




            //Detect potential conditional steps to be Unlocked:
            $found_match = 0;
            $locked_x = $this->X_model->fetch(array(
                'i__type IN (' . join(',', $this->config->item('n___7355')) . ')' => null, //PUBLIC
                'x__status IN (' . join(',', $this->config->item('n___7359')) . ')' => null, //PUBLIC
                'x__type IN (' . join(',', $this->config->item('n___12842')) . ')' => null, //IDEA LINKS ONE-WAY
                'x__left' => $i['i__id'],
                'x__right IN (' . join(',', $i__metadata['i___6283'][$i['i__id']]) . ')' => null, //Limit to cached answers
            ), array('x__right'), 0, 0);


            foreach($locked_x as $locked_x) {

                //See if it unlocks any of these ranges defined in the metadata:
                $x__metadata = unserialize($locked_x['x__metadata']);

                //Defines ranges:
                if(!isset($x__metadata['tr__conditional_score_min'])){
                    $x__metadata['tr__conditional_score_min'] = 0;
                }
                if(!isset($x__metadata['tr__conditional_score_max'])){
                    $x__metadata['tr__conditional_score_max'] = 0;
                }


                if($u_marks['steps_answered_score']>=$x__metadata['tr__conditional_score_min'] && $u_marks['steps_answered_score']<=$x__metadata['tr__conditional_score_max']){

                    //Found a match:
                    $found_match++;

                    //Unlock read:
                    $this->X_model->create(array(
                        'x__type' => 6140, //READ UNLOCK LINK
                        'x__source' => $e__id,
                        'x__left' => $i['i__id'],
                        'x__right' => $locked_x['i__id'],
                        'x__metadata' => array(
                            'completion_rate' => $completion_rate,
                            'u_marks' => $u_marks,
                            'condition_ranges' => $locked_x,
                        ),
                    ));

                }
            }

            //We must have exactly 1 match by now:
            if($found_match != 1){
                $this->X_model->create(array(
                    'x__message' => 'completion_recursive_up() found ['.$found_match.'] routing logic matches!',
                    'x__type' => 4246, //Platform Bug Reports
                    'x__source' => $e__id,
                    'x__left' => $i['i__id'],
                    'x__metadata' => array(
                        'completion_rate' => $completion_rate,
                        'u_marks' => $u_marks,
                        'conditional_ranges' => $locked_x,
                    ),
                ));
            }
        }


        //Now go up since we know there are more levels...
        if($is_bottom_level){
            //Go through parents ideas and detect intersects with member ideas
            foreach(array_reverse($this->X_model->find_previous($e__id, $top_i__id, $i['i__id'])) as $p_i) {
                $this->X_model->completion_recursive_up($e__id, $top_i__id, $p_i, false);
            }
        }


        return true;
    }


    function unlock_locked_step($e__id, $i){

        /*
         * A function that starts from a locked idea and checks:
         *
         * 1. List members who have completed ALL/ANY (Depending on AND/OR Lock) of its children
         * 2. If > 0, then goes up recursively to see if these completions unlock other completions
         *
         * */

        if(!i_unlockable($i)){
            return array(
                'status' => 0,
                'message' => 'Not a valid locked idea type and status',
            );
        }


        $is_next = $this->X_model->fetch(array(
            'x__status IN (' . join(',', $this->config->item('n___7359')) . ')' => null, //PUBLIC
            'i__type IN (' . join(',', $this->config->item('n___7355')) . ')' => null, //PUBLIC
            'x__type IN (' . join(',', $this->config->item('n___12840')) . ')' => null, //IDEA LINKS TWO-WAY
            'x__left' => $i['i__id'],
        ), array('x__right'), 0, 0, array('x__spectrum' => 'ASC'));
        if(count($is_next) < 1){
            return array(
                'status' => 0,
                'message' => 'Idea has no child ideas',
            );
        }



        /*
         *
         * Now we need to determine idea completion method.
         *
         * It's one of these two cases:
         *
         * AND Ideas are completed when all their children are completed
         *
         * OR Ideas are completed when a single child is completed
         *
         * */
        $requires_all_children = in_array($i['i__type'], $this->config->item('n___13987') /* REQUIRE ALL CHILDREN */ );

        //Generate list of members who have completed it:
        $qualified_completed = array();

        //Go through children and see how many completed:
        foreach($is_next as $count => $next_i){

            //Fetch members who completed this:
            if($count==0){

                //Always add all the first members to the full list:
                $qualified_completed = $this->X_model->fetch(array(
                    'x__status IN (' . join(',', $this->config->item('n___7359')) . ')' => null, //PUBLIC
                    'x__type IN (' . join(',', $this->config->item('n___6255')) . ')' => null, //READ COIN
                    'x__left' => $next_i['i__id'],
                ), array(), 0, 0, array(), 'COUNT(x__id) as totals');

                if($requires_all_children && count($qualified_completed)==0){
                    //No members found that would meet all children requirements:
                    break;
                }

            } else {

                //2nd Update onwards, by now we must have a base:
                if($requires_all_children){

                    //Update list of qualified members:
                    $qualified_completed = $this->X_model->fetch(array(
                        'x__status IN (' . join(',', $this->config->item('n___7359')) . ')' => null, //PUBLIC
                        'x__type IN (' . join(',', $this->config->item('n___6255')) . ')' => null, //READ COIN
                        'x__left' => $next_i['i__id'],
                    ), array(), 0, 0, array(), 'COUNT(x__id) as totals');

                }

            }
        }

        if(count($qualified_completed) > 0){
            return array(
                'status' => 0,
                'message' => 'No users found to have completed',
            );
        }

    }



    function mark_complete($top_i__id, $i, $add_fields) {

        //Always add Idea to x__left
        $add_fields['x__left'] = $i['i__id'];

        if (!isset($add_fields['x__message'])) {
            $add_fields['x__message'] = null;
        }

        //Log completion transaction:
        $new_x = $this->X_model->create($add_fields);


        //Check Auto Completes:
        $is_next_autoscan = array();
        if(in_array($i['i__type'], $this->config->item('n___7712'))){

            //IDEA TYPE SELECT NEXT
            $is_next_autoscan = $this->X_model->fetch(array(
                'x__status IN (' . join(',', $this->config->item('n___7359')) . ')' => null, //PUBLIC
                'x__type IN (' . join(',', $this->config->item('n___7704')) . ')' => null, //READ ANSWERED
                'x__source' => $add_fields['x__source'],
                'x__left' => $i['i__id'],
                'x__right >' => 0, //With an answer
            ), array('x__right'), 0);

        } elseif(in_array($i['i__type'], $this->config->item('n___13022'))){

            //IDEA TYPE ALL NEXT
            $is_next_autoscan = $this->X_model->fetch(array(
                'x__status IN (' . join(',', $this->config->item('n___7359')) . ')' => null, //PUBLIC
                'x__type IN (' . join(',', $this->config->item('n___12840')) . ')' => null, //IDEA LINKS TWO-WAY
                'x__left' => $i['i__id'],
            ), array('x__right'), 0);

        }

        foreach($is_next_autoscan as $next_i){

            //IS IT EMPTY?
            if(

                //Auto completable type?
                in_array($next_i['i__type'], $this->config->item('n___12330')) &&

                //No Messages
                !count($this->X_model->fetch(array(
                    'x__status IN (' . join(',', $this->config->item('n___7359')) . ')' => null, //PUBLIC
                    'x__type' => 4231, //IDEA NOTES Messages
                    'x__right' => $next_i['i__id'],
                ))) &&

                //One or less next
                count($this->X_model->fetch(array(
                    'x__status IN (' . join(',', $this->config->item('n___7359')) . ')' => null, //PUBLIC
                    'x__type IN (' . join(',', $this->config->item('n___12840')) . ')' => null, //IDEA LINKS TWO-WAY
                    'x__left' => $next_i['i__id'],
                ))) <= 1 &&

                //Not Already Completed:
                !count($this->X_model->fetch(array(
                    'x__status IN (' . join(',', $this->config->item('n___7359')) . ')' => null, //PUBLIC
                    'x__type IN (' . join(',', $this->config->item('n___12229')) . ')' => null, //READ COMPLETE
                    'x__source' => $add_fields['x__source'],
                    'x__left' => $next_i['i__id'],
                )))){

                //Mark as complete:
                $this->X_model->mark_complete($top_i__id, $next_i, array(
                    'x__type' => 4559, //READ MESSAGES
                    'x__source' => $add_fields['x__source'],
                ));

            }
        }


        //SOURCE APPEND?
        $detected_x_type = x_detect_type($add_fields['x__message']);
        if ($detected_x_type['status']) {

            foreach($this->X_model->fetch(array(
                'x__status IN (' . join(',', $this->config->item('n___7359')) . ')' => null, //PUBLIC
                'x__type' => 7545, //CERTIFICATES
                'x__right' => $i['i__id'],
            )) as $x_tag){

                //Generate stats:
                $x_added = 0;
                $x_edited = 0;
                $x_deleted = 0;


                //Assign tag if parent/child transaction NOT previously assigned:
                $existing_x = $this->X_model->fetch(array(
                    'x__status IN (' . join(',', $this->config->item('n___7359')) . ')' => null, //PUBLIC
                    'x__type IN (' . join(',', $this->config->item('n___4592')) . ')' => null, //SOURCE LINKS
                    'x__up' => $x_tag['x__up'], //CERTIFICATES saved here
                    'x__down' => $add_fields['x__source'],
                ));

                if(count($existing_x)){

                    //Transaction previously exists, see if content value is the same:
                    if($existing_x[0]['x__message'] == $add_fields['x__message'] && $existing_x[0]['x__type'] == $detected_x_type['x__type']){

                        //Everything is the same, nothing to do here:
                        continue;

                    } else {

                        $x_edited++;

                        //Content value has changed, update the transaction:
                        $this->X_model->update($existing_x[0]['x__id'], array(
                            'x__message' => $add_fields['x__message'],
                        ), $add_fields['x__source'], 10657 /* SOURCE LINK CONTENT UPDATE  */);

                        //Also, did the transaction type change based on the content change?
                        if($existing_x[0]['x__type'] != $detected_x_type['x__type']){
                            $this->X_model->update($existing_x[0]['x__id'], array(
                                'x__type' => $detected_x_type['x__type'],
                            ), $add_fields['x__source'], 10659 /* Member Transaction Updated Type */);
                        }

                    }

                } else {

                    //See if we need to delete single selectable transactions:
                    foreach($this->config->item('n___6204') as $single_select_e__id){
                        $single_selectable = $this->config->item('n___'.$single_select_e__id);
                        if(is_array($single_selectable) && count($single_selectable) && in_array($x_tag['x__up'], $single_selectable)){
                            //Delete other siblings, if any:
                            foreach($this->X_model->fetch(array(
                                'x__status IN (' . join(',', $this->config->item('n___7360')) . ')' => null, //ACTIVE
                                'x__type IN (' . join(',', $this->config->item('n___4592')) . ')' => null, //SOURCE LINKS
                                'x__up IN (' . join(',', $single_selectable) . ')' => null,
                                'x__up !=' => $x_tag['x__up'],
                                'x__down' => $add_fields['x__source'],
                            )) as $single_selectable_siblings_preset){
                                $x_deleted += $this->X_model->update($single_selectable_siblings_preset['x__id'], array(
                                    'x__status' => 6173, //Transaction Deleted
                                ), $add_fields['x__source'], 10673 /* Member Transaction Unpublished */);
                            }
                        }
                    }

                    //Create transaction:
                    $x_added++;
                    $this->X_model->create(array(
                        'x__type' => $detected_x_type['x__type'],
                        'x__message' => $add_fields['x__message'],
                        'x__source' => $add_fields['x__source'],
                        'x__up' => $x_tag['x__up'],
                        'x__down' => $add_fields['x__source'],
                    ));

                }

                //Track Tag:
                $this->X_model->create(array(
                    'x__type' => 12197, //Tag Member
                    'x__source' => $add_fields['x__source'],
                    'x__up' => $x_tag['x__up'],
                    'x__down' => $add_fields['x__source'],
                    'x__left' => $i['i__id'],
                    'x__message' => $x_added.' added, '.$x_edited.' edited & '.$x_deleted.' deleted with new content ['.$add_fields['x__message'].']',
                ));


                if($x_added>0 || $x_edited>0 || $x_deleted>0){
                    //See if Session needs to be updated:
                    $member_e = superpower_unlocked();
                    if($member_e && $member_e['e__id']==$add_fields['x__source']){
                        //Yes, update session:
                        $this->E_model->activate_session($member_e, true);
                    }
                }
            }
        }


        //Process completion automations:
        $this->X_model->completion_recursive_up($add_fields['x__source'], $top_i__id, $i);

        return $new_x;

    }

    function completion_marks($e__id, $i, $top_level = true)
    {

        //Fetch/validate read Common Ideas:
        $i__metadata = unserialize($i['i__metadata']);
        if(!isset($i__metadata['i___6168'])){

            //Should not happen, log error:
            $this->X_model->create(array(
                'x__message' => 'completion_marks() Detected user reads without i___6168 value!',
                'x__type' => 4246, //Platform Bug Reports
                'x__source' => $e__id,
                'x__left' => $i['i__id'],
            ));

            return 0;
        }

        //Generate flat steps:
        $flat_common_x = array_flatten($i__metadata['i___6168']);

        //Calculate common steps and expansion steps recursively for this u:
        $metadata_this = array(
            //Generic assessment marks stats:
            'steps_question_count' => 0, //The parent idea
            'steps_marks_min' => 0,
            'steps_marks_max' => 0,

            //Member answer stats:
            'steps_answered_count' => 0, //How many they have answered so far
            'steps_answered_marks' => 0, //Indicates completion score

            //Calculated at the end:
            'steps_answered_score' => 0, //Used to determine which label to be unlocked...
        );


        //Process Answer ONE:
        if(isset($i__metadata['i___6228']) && count($i__metadata['i___6228']) > 0){

            //We need expansion steps (OR Ideas) to calculate question/answers:
            //To save all the marks for specific answers:
            $question_i__ids = array();
            $answer_marks_index = array();

            //Go through these expansion steps:
            foreach($i__metadata['i___6228'] as $question_i__id => $answers_i__ids ){

                //Calculate local min/max marks:
                array_push($question_i__ids, $question_i__id);
                $metadata_this['steps_question_count'] += 1;
                $local_min = null;
                $local_max = null;

                //Calculate min/max points for this based on answers:
                foreach($this->X_model->fetch(array(
                    'i__type IN (' . join(',', $this->config->item('n___7355')) . ')' => null, //PUBLIC
                    'x__status IN (' . join(',', $this->config->item('n___7359')) . ')' => null, //PUBLIC
                    'x__type IN (' . join(',', $this->config->item('n___12840')) . ')' => null, //IDEA LINKS TWO-WAY
                    'x__left' => $question_i__id,
                    'x__right IN (' . join(',', $answers_i__ids) . ')' => null, //Limit to cached answers
                ), array('x__right')) as $i_answer){

                    //Extract Transaction Metadata:
                    $possible_answer_metadata = unserialize($i_answer['x__metadata']);

                    //Assign to this question:
                    $answer_marks_index[$i_answer['i__id']] = ( isset($possible_answer_metadata['tr__assessment_points']) ? intval($possible_answer_metadata['tr__assessment_points']) : 0 );

                    //Addup local min/max marks:
                    if(is_null($local_min) || $answer_marks_index[$i_answer['i__id']] < $local_min){
                        $local_min = $answer_marks_index[$i_answer['i__id']];
                    }
                    if(is_null($local_max) || $answer_marks_index[$i_answer['i__id']] > $local_max){
                        $local_max = $answer_marks_index[$i_answer['i__id']];
                    }
                }

                //Did we have any marks for this question?
                if(!is_null($local_min)){
                    $metadata_this['steps_marks_min'] += $local_min;
                }
                if(!is_null($local_max)){
                    $metadata_this['steps_marks_max'] += $local_max;
                }
            }



            //Now let's check member answers to see what they have done:
            $total_completion = $this->X_model->fetch(array(
                'x__source' => $e__id, //Belongs to this Member
                'x__type IN (' . join(',', $this->config->item('n___12229')) . ')' => null, //READ COMPLETE
                'x__left IN (' . join(',', $question_i__ids ) . ')' => null,
                'x__status IN (' . join(',', $this->config->item('n___7359')) . ')' => null, //PUBLIC
            ), array(), 0, 0, array(), 'COUNT(x__id) as total_completions');

            //Add to total answer count:
            $metadata_this['steps_answered_count'] += $total_completion[0]['total_completions'];

            //Go through answers:
            foreach($this->X_model->fetch(array(
                'x__source' => $e__id, //Belongs to this Member
                'x__type IN (' . join(',', $this->config->item('n___12326')) . ')' => null, //READ EXPANSIONS
                'x__left IN (' . join(',', $question_i__ids ) . ')' => null,
                'x__status IN (' . join(',', $this->config->item('n___7359')) . ')' => null, //PUBLIC
                'i__type IN (' . join(',', $this->config->item('n___7355')) . ')' => null, //PUBLIC
            ), array('x__right'), 500) as $answer_in) {

                //Fetch recursively:
                $recursive_stats = $this->X_model->completion_marks($e__id, $answer_in, false);

                $metadata_this['steps_answered_count'] += $recursive_stats['steps_answered_count'];
                $metadata_this['steps_answered_marks'] += $answer_marks_index[$answer_in['i__id']] + $recursive_stats['steps_answered_marks'];

            }
        }


        //Process Answer SOME:
        if(isset($i__metadata['i___12885']) && count($i__metadata['i___12885']) > 0){

            //We need expansion steps (OR Ideas) to calculate question/answers:
            //To save all the marks for specific answers:
            $question_i__ids = array();
            $answer_marks_index = array();

            //Go through these expansion steps:
            foreach($i__metadata['i___12885'] as $question_i__id => $answers_i__ids ){

                //Calculate local min/max marks:
                array_push($question_i__ids, $question_i__id);
                $metadata_this['steps_question_count'] += 1;
                $local_min = null;
                $local_max = null;

                //Calculate min/max points for this based on answers:
                foreach($this->X_model->fetch(array(
                    'i__type IN (' . join(',', $this->config->item('n___7355')) . ')' => null, //PUBLIC
                    'x__status IN (' . join(',', $this->config->item('n___7359')) . ')' => null, //PUBLIC
                    'x__type IN (' . join(',', $this->config->item('n___12840')) . ')' => null, //IDEA LINKS TWO-WAY
                    'x__left' => $question_i__id,
                    'x__right IN (' . join(',', $answers_i__ids) . ')' => null, //Limit to cached answers
                ), array('x__right')) as $i_answer){

                    //Extract Transaction Metadata:
                    $possible_answer_metadata = unserialize($i_answer['x__metadata']);

                    //Assign to this question:
                    $answer_marks_index[$i_answer['i__id']] = ( isset($possible_answer_metadata['tr__assessment_points']) ? intval($possible_answer_metadata['tr__assessment_points']) : 0 );

                    //Addup local min/max marks:
                    if(is_null($local_min) || $answer_marks_index[$i_answer['i__id']] < $local_min){
                        $local_min = $answer_marks_index[$i_answer['i__id']];
                    }
                }

                //Did we have any marks for this question?
                if(!is_null($local_min)){
                    $metadata_this['steps_marks_min'] += $local_min;
                }

                //Always Add local max:
                $metadata_this['steps_marks_max'] += $answer_marks_index[$i_answer['i__id']];

            }



            //Now let's check member answers to see what they have done:
            $total_completion = $this->X_model->fetch(array(
                'x__source' => $e__id, //Belongs to this Member
                'x__type IN (' . join(',', $this->config->item('n___12229')) . ')' => null, //READ COMPLETE
                'x__left IN (' . join(',', $question_i__ids ) . ')' => null,
                'x__status IN (' . join(',', $this->config->item('n___7359')) . ')' => null, //PUBLIC
            ), array(), 0, 0, array(), 'COUNT(x__id) as total_completions');

            //Add to total answer count:
            $metadata_this['steps_answered_count'] += $total_completion[0]['total_completions'];

            //Go through answers:
            foreach($this->X_model->fetch(array(
                'x__source' => $e__id, //Belongs to this Member
                'x__type IN (' . join(',', $this->config->item('n___12326')) . ')' => null, //READ EXPANSIONS
                'x__left IN (' . join(',', $question_i__ids ) . ')' => null,
                'x__status IN (' . join(',', $this->config->item('n___7359')) . ')' => null, //PUBLIC
                'i__type IN (' . join(',', $this->config->item('n___7355')) . ')' => null, //PUBLIC
            ), array('x__right'), 500) as $answer_in) {

                //Fetch recursively:
                $recursive_stats = $this->X_model->completion_marks($e__id, $answer_in, false);

                $metadata_this['steps_answered_count'] += $recursive_stats['steps_answered_count'];
                $metadata_this['steps_answered_marks'] += $answer_marks_index[$answer_in['i__id']] + $recursive_stats['steps_answered_marks'];

            }
        }



        if($top_level && $metadata_this['steps_answered_count'] > 0){

            $divider = ( $metadata_this['steps_marks_max'] - $metadata_this['steps_marks_min'] );

            if($divider > 0){
                //See assessment summary:
                $metadata_this['steps_answered_score'] = floor(( ($metadata_this['steps_answered_marks'] - $metadata_this['steps_marks_min']) / $divider )  * 100 );
            } else {
                //See assessment summary:
                $metadata_this['steps_answered_score'] = 0;
            }

        }


        //Return results:
        return $metadata_this;

    }



    function completion_progress($e__id, $i, $top_level = true)
    {

        if(!isset($i['i__metadata'])){
            return false;
        }

        //Fetch/validate reads Common Ideas:
        $i__metadata = unserialize($i['i__metadata']);
        if(!isset($i__metadata['i___6168'])){
            //Since it's not there yet we assume the idea it self only!
            $i__metadata['i___6168'] = array($i['i__id']);
        }


        //Generate flat steps:
        $flat_common_x = array_flatten($i__metadata['i___6168']);


        //Count totals:
        $common_totals = $this->I_model->fetch(array(
            'i__id IN ('.join(',',$flat_common_x).')' => null,
            'i__type IN (' . join(',', $this->config->item('n___7355')) . ')' => null, //PUBLIC
        ), 0, 0, array(), 'COUNT(i__id) as total_x, SUM(i__duration) as total_seconds');


        //Count completed so far:
        $common_completed = $this->X_model->fetch(array(
            'x__type IN (' . join(',', $this->config->item('n___12229')) . ')' => null, //READ COMPLETE
            'x__source' => $e__id, //Belongs to this Member
            'x__left IN (' . join(',', $flat_common_x ) . ')' => null,
            'x__status IN (' . join(',', $this->config->item('n___7359')) . ')' => null, //PUBLIC
            'i__type IN (' . join(',', $this->config->item('n___7355')) . ')' => null, //PUBLIC
        ), array('x__left'), 0, 0, array(), 'COUNT(i__id) as completed_x, SUM(i__duration) as completed_seconds');


        //Calculate common steps and expansion steps recursively for this u:
        $metadata_this = array(
            'steps_total' => intval($common_totals[0]['total_x']),
            'steps_completed' => intval($common_completed[0]['completed_x']),
            'seconds_total' => intval($common_totals[0]['total_seconds']),
            'seconds_completed' => intval($common_completed[0]['completed_seconds']),
        );


        //Expansion Answer ONE
        $answer_array = array();
        if(isset($i__metadata['i___6228']) && count($i__metadata['i___6228']) > 0) {
            $answer_array = array_merge($answer_array , array_flatten($i__metadata['i___6228']));
        }
        if(isset($i__metadata['i___12885']) && count($i__metadata['i___12885']) > 0) {
            $answer_array = array_merge($answer_array , array_flatten($i__metadata['i___12885']));
        }

        if(count($answer_array)){

            //Now let's check member answers to see what they have done:
            foreach($this->X_model->fetch(array(
                'x__type IN (' . join(',', $this->config->item('n___12326')) . ')' => null, //READ EXPANSIONS
                'x__source' => $e__id, //Belongs to this Member
                'x__left IN (' . join(',', $flat_common_x ) . ')' => null,
                'x__right IN (' . join(',', $answer_array) . ')' => null,
                'x__status IN (' . join(',', $this->config->item('n___7359')) . ')' => null, //PUBLIC
                'i__type IN (' . join(',', $this->config->item('n___7355')) . ')' => null, //PUBLIC
            ), array('x__right')) as $expansion_in) {

                //Fetch recursive:
                $recursive_stats = $this->X_model->completion_progress($e__id, $expansion_in, false);

                //Addup completion stats for this:
                $metadata_this['steps_total'] += $recursive_stats['steps_total'];
                $metadata_this['steps_completed'] += $recursive_stats['steps_completed'];
                $metadata_this['seconds_total'] += $recursive_stats['seconds_total'];
                $metadata_this['seconds_completed'] += $recursive_stats['seconds_completed'];
            }
        }


        //Expansion steps Recursive
        if(isset($i__metadata['i___6283']) && count($i__metadata['i___6283']) > 0){

            //Now let's check if member has unlocked any Miletones:
            foreach($this->X_model->fetch(array(
                'x__type' => 6140, //READ UNLOCK LINK
                'x__source' => $e__id, //Belongs to this Member
                'x__left IN (' . join(',', $flat_common_x ) . ')' => null,
                'x__right IN (' . join(',', array_flatten($i__metadata['i___6283'])) . ')' => null,
                'x__status IN (' . join(',', $this->config->item('n___7359')) . ')' => null, //PUBLIC
                'i__type IN (' . join(',', $this->config->item('n___7355')) . ')' => null, //PUBLIC
            ), array('x__right')) as $expansion_in) {

                //Fetch recursive:
                $recursive_stats = $this->X_model->completion_progress($e__id, $expansion_in, false);

                //Addup completion stats for this:
                $metadata_this['steps_total'] += $recursive_stats['steps_total'];
                $metadata_this['steps_completed'] += $recursive_stats['steps_completed'];
                $metadata_this['seconds_total'] += $recursive_stats['seconds_total'];
                $metadata_this['seconds_completed'] += $recursive_stats['seconds_completed'];

            }
        }


        if($top_level){

            /*
             *
             * Completing an reads depends on two factors:
             *
             * 1) number of steps (some may have 0 time estimate)
             * 2) estimated seconds (usual ly accurate)
             *
             * To increase the accurate of our completion % function,
             * We would also assign a default time to the average step
             * so we can calculate more accurately even if none of the
             * steps have an estimated time.
             *
             * */

            //Set default seconds per step:
            $metadata_this['completion_percentage'] = 0;
            $step_default_seconds = view_memory(6404,12176);


            //Calculate completion rate based on estimated time cost:
            if($metadata_this['steps_total'] > 0 || $metadata_this['seconds_total'] > 0){
                $metadata_this['completion_percentage'] = intval(floor( ($metadata_this['seconds_completed']+($step_default_seconds*$metadata_this['steps_completed'])) / ($metadata_this['seconds_total']+($step_default_seconds*$metadata_this['steps_total'])) * 100 ));
            }


            //Hack for now, TODO investigate later:
            if($metadata_this['completion_percentage'] > 100){
                $metadata_this['completion_percentage'] = 100;
            }

        }

        //Return results:
        return $metadata_this;

    }


    function ids($e__id, $i__id = 0){

        //Simply returns all the idea IDs for a u's reads:
        if($i__id > 0){

            if(!$e__id){
                return false;
            }

            return count($this->X_model->fetch(array(
                'x__left' => $i__id,
                'x__source' => $e__id,
                'x__type IN (' . join(',', $this->config->item('n___12969')) . ')' => null, //MY READS
                'x__status IN (' . join(',', $this->config->item('n___7359')) . ')' => null, //PUBLIC
            )));

        } else {

            $u_x_ids = array();
            if($e__id > 0){
                foreach($this->X_model->fetch(array(
                    'x__source' => $e__id,
                    'x__type IN (' . join(',', $this->config->item('n___12969')) . ')' => null, //MY READS
                    'x__status IN (' . join(',', $this->config->item('n___7359')) . ')' => null, //PUBLIC
                )) as $u_in){
                    array_push($u_x_ids, intval($u_in['x__left']));
                }
            }
            return $u_x_ids;

        }
    }




    function x_answer($e__id, $top_i__id, $question_i__id, $answer_i__ids){

        $is = $this->I_model->fetch(array(
            'i__id' => $question_i__id,
            'i__type IN (' . join(',', $this->config->item('n___7355')) . ')' => null, //PUBLIC
        ));
        $es = $this->E_model->fetch(array(
            'e__id' => $e__id,
            'e__type IN (' . join(',', $this->config->item('n___7357')) . ')' => null, //PUBLIC
        ));
        if (!count($is)) {
            return array(
                'status' => 0,
                'message' => 'Invalid idea ID',
            );
        } elseif (!count($es)) {
            return array(
                'status' => 0,
                'message' => 'Invalid source ID',
            );
        } elseif (!in_array($is[0]['i__type'], $this->config->item('n___7712'))) {
            return array(
                'status' => 0,
                'message' => 'Invalid Idea type [Must be Answer]',
            );
        } elseif (!count($answer_i__ids)) {
            return array(
                'status' => 0,
                'message' => 'Missing Answer',
            );
        }


        //Define completion transactions for each answer:
        if($is[0]['i__type'] == 6684){

            //ONE ANSWER
            $x__type = 6157; //Award Coin
            $i_x__type = 12336; //Save Answer

        } elseif($is[0]['i__type'] == 7231){

            //SOME ANSWERS
            $x__type = 7489; //Award Coin
            $i_x__type = 12334; //Save Answer

        }

        //Delete ALL previous answers:
        foreach($this->X_model->fetch(array(
            'x__status IN (' . join(',', $this->config->item('n___7359')) . ')' => null, //PUBLIC
            'x__type IN (' . join(',', $this->config->item('n___7704')) . ')' => null, //READ ANSWERED
            'x__source' => $e__id,
            'x__left' => $is[0]['i__id'],
        )) as $x_progress){
            $this->X_model->update($x_progress['x__id'], array(
                'x__status' => 6173, //Transaction Deleted
            ), $e__id, 12129 /* READ ANSWER DELETED */);
        }

        //Add New Answers
        $answers_newly_added = 0;
        foreach($answer_i__ids as $answer_i__id){
            $answers_newly_added++;
            $this->X_model->create(array(
                'x__type' => $i_x__type,
                'x__source' => $e__id,
                'x__left' => $is[0]['i__id'],
                'x__right' => $answer_i__id,
            ));
        }


        //Ensure we logged an answer:
        if(!$answers_newly_added){
            return array(
                'status' => 0,
                'message' => 'No answers saved.',
            );
        }

        //Issue READ/IDEA COIN:
        $this->X_model->mark_complete($top_i__id, $is[0], array(
            'x__type' => $x__type,
            'x__source' => $e__id,
        ));

        //All good, something happened:
        return array(
            'status' => 1,
            'message' => $answers_newly_added.' Selected. Going Next...',
        );

    }



}