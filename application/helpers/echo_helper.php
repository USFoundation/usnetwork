<?php





function echo_next_u($page,$limit,$u__outbound_count){
    //We have more child entities than what was listed here.
    //Give user a way to access them:
    echo '<a class="load-more list-group-item" href="javascript:void(0);" onclick="entity_load_more('.$page.')">';

    //Right content:
    echo '<span class="pull-right"><span class="badge badge-secondary"><i class="fas fa-search-plus"></i></span></span>';

    //Regular section:
    $max_entities = (($page+1)*$limit);
    $max_entities = ( $max_entities>$u__outbound_count ? $u__outbound_count : $max_entities );
    echo 'Load '.(($page*$limit)+1).'-'.$max_entities.' from '.$u__outbound_count.' total';

    echo '</a>';
}

function echo_social_profiles($social_profiles){
    $ui = null;
    foreach($social_profiles as $sp){
        $ui .= '<a href="'.$sp['url'].'" target="_blank" class="social-link"><i class="'.$sp['fa_icon'].'"></i></a>';
    }
    return $ui;
}



function echo_x($u, $x){

    $CI =& get_instance();
    $social_urls = $CI->config->item('social_urls');
    $udata = $CI->session->userdata('user');
    $can_edit = ($udata['u_id']==$u['u_id'] || array_key_exists(1281, $udata['u__inbounds']));

    $ui = null;
    $ui .= '<div id="x_'.$x['x_id'].'" class="list-group-item url-item">';

    //Right content:
    $ui .= '<span class="pull-right">';

    if($can_edit && strlen($x['x_clean_url'])>0 && !($x['x_url']==$x['x_clean_url'])){
        //We have detected a different URL behind the scene:
        $ui .= '<a class="badge badge-secondary" href="'.$x['x_clean_url'].'" target="_blank" data-toggle="tooltip" data-placement="left" title="Redirects to another URL"><i class="fas fa-route"></i></a> ';
    }

    //This is an image and can be set as Cover photo, or may have already been set so...
    if($x['x_id']==$u['u_cover_x_id']){
        //Already set as the cover photo:
        $ui .= '<span class="badge badge-secondary grey current-cover" data-toggle="tooltip" data-placement="left" title="Currently set as Cover Photo"><i class="fas fa-file-check"></i></span> ';
    } elseif($x['x_type']==4 && $x['x_status']>0 && $can_edit){
        //Could be set as the cover photo:
        $ui .= '<a class="badge badge-secondary add-cover" href="javascript:void(0);" onclick="x_cover_set('.$x['x_id'].')" data-toggle="tooltip" data-placement="left" title="Set this image as Cover Photo"><i class="fas fa-file-image"></i></a> ';
    }

    //User can always remove a URL:
    if($can_edit){
        $ui .= '<a class="badge badge-secondary" href="javascript:void(0);" onclick="x_delete('.$x['x_id'].')" data-toggle="tooltip" data-placement="left" title="Delete this URL"><i class="fas fa-trash-alt" title="ID '.$x['x_id'].'"></i></a>';
    }

    $ui .= '</span>';


    //Regular section:
    $ui .= '<a href="'.$x['x_url'].'" target="_blank" '.( strlen($x['x_url'])>0 && !($x['x_url']==$x['x_url']) ? '' : '' ).'>';
    $ui .= '<span class="url_truncate">'.echo_clean_url($x['x_url']).'</span>';

    //Is this a social URL?
    foreach($social_urls as $url=>$fa_icon){
        if(substr_count($x['x_url'],$url)>0){
            $ui .= '<i class="'.$fa_icon.'" data-toggle="tooltip" data-placement="top" title="Verified Domain"></i> ';
            break;
        }
    }


    $ui .= '<i class="fas fa-external-link-square"></i></a>';

    //Can we display this URL?
    if($x['x_type']==1){
        $ui .= '<div style="margin-top:7px;">'.echo_embed($x['x_clean_url'],$x['x_clean_url']).'</div>';
    } elseif($x['x_type']>1){
        $ui .= '<div style="margin-top:7px;">'.echo_content_url($x['x_clean_url'],$x['x_type']).'</div>';
    }

    $ui .= '</div>';

    return $ui;
}


function echo_u($u, $level, $can_edit, $is_inbound=false){

    $ui = null;
    $ui .= '<div id="u_'.$u['u_id'].'" entity-id="'.$u['u_id'].'" is-inbound="'.( $is_inbound ? 1 : 0 ).'" class="list-group-item u-item '.( $level==1 ? 'top_entity' : 'ur_'.$u['ur_id'] ).'">';

    //Right content:
    $ui .= '<span class="pull-right">';

    if($can_edit) {

        if($level==2){
            $ui .= '<a class="badge badge-secondary" href="javascript:ur_unlink('.$u['ur_id'].')" style="margin:-2px 3px 0 0; width:40px;"><i class="fas fa-trash-alt"></i></a>';
        }

        $ui .= '<a class="badge badge-secondary" href="/entities/'.$u['u_id'].'/modify" style="margin:-2px 3px 0 0; width:40px;" data-toggle="tooltip" data-placement="left" title="Engagement Score">'.( $u['u__e_score']>0 ? '<span class="btn-counter">'.echo_big_num($u['u__e_score']).'</span>' : '' ).'<i class="fas fa-cog"></i></a>';
    }


    if($level==1){
        //Level 1:
        $ui .= '<span class="badge badge-secondary grey" style="width:40px;"><span class="btn-counter li-outbound-count">'.$u['u__outbound_count'].'</span><i class="fas fa-sign-out-alt rotate90"></i></span>';
    } else {
        //Level 2:
        $ui .= '<a class="badge badge-secondary" href="/entities/'.$u['u_id'].'" style="width:40px;">'.(isset($u['u__outbound_count']) && $u['u__outbound_count']>0 ? '<span class="btn-counter">'.$u['u__outbound_count'].'</span>' : '').'<i class="'.( $is_inbound ? 'fas fa-sign-in-alt' : 'fas fa-sign-out-alt rotate90' ).'"></i></a>';
    }


    $ui .= '</span>';



    if($level==1){

        //Regular section:
        $CI =& get_instance();
        $ui .= echo_cover($u, 'profile-icon2');
        $ui .= '<b id="u_title" class="u_full_name">' . $u['u_full_name'] . '</b>';
        $ui .= ' <span class="obj-id">@' . $u['u_id'] . '</span>';

        //Do they have any social profiles in their link?
        $ui .= echo_social_profiles($CI->Db_model->x_social_fetch($u['u_id']));

//Check last engagement ONLY IF admin:
        if ($can_edit) {
            //Check last engagement:
            $last_eng = $CI->Db_model->e_fetch(array(
                '(e_inbound_u_id=' . $u['u_id'] . ')' => null,
            ), 1);

            if (count($last_eng) > 0) {
                $ui .= ' &nbsp;<a href="/cockpit/browse/engagements?e_u_id=' . $u['u_id'] . '" style="display: inline-block;" data-toggle="tooltip" data-placement="right" title="Last engaged ' . echo_diff_time($last_eng[0]['e_timestamp']) . ' ago. Click to see all engagements"><i class="fas fa-exchange rotate45"></i> <b>' . echo_diff_time($last_eng[0]['e_timestamp']) . ' &raquo;</b></a>';
            }
        }

        //Visibly show bio for level 1:
        $ui .= '<div>' . $u['u_bio'] . '</div>';

    } else {

        //Regular section:
        $ui .= echo_cover($u,'micro-image', 1).' ';
        if(strlen($u['u_bio'])>0){
            $ui .= '<span class="u_full_name" data-toggle="tooltip" data-placement="right" title="'.$u['u_bio'].'" style="border-bottom:1px dotted #3C4858; cursor:help;">'.$u['u_full_name'].'</span>';
        } else {
            $ui .= '<span class="u_full_name">'.$u['u_full_name'].'</span>';
        }

    }





    $ui .= '</div>';

    return $ui;
}



function echo_t($t){
    echo '<div class="list-group-item">';

    //Right content:
    echo '<span class="pull-right">';
    echo '<a class="badge badge-primary stnd-btn" href="https://www.paypal.com/activity/payment/'.$t['t_paypal_id'].'" target="_blank"><i class="fab fa-paypal"></i> <i class="fas fa-external-link-square"></i></a>';
    echo '</span>';

    //Regular section:
    echo $t['t_total'].' '.$t['t_currency'];

    echo '</div>';
}

function echo_rank($rank){
    if($rank==1){
        return '🥇';
    } elseif($rank==2){
        return '🥈';
    } elseif($rank==3){
        return '🥉';
    } else {
        return echo_ordinal($rank);
    }
}

function echo_tip($c_id){
    echo '<span id="hb_'.$c_id.'" class="help_button belowh2-btn" intent-id="'.$c_id.'"></span>';
    echo '<div class="help_body belowh2-bdy maxout" id="content_'.$c_id.'"></div>';
}








function echo_min_from_sec($sec_int){
    $min = 0;
    $sec = fmod($sec_int,60);
    if($sec_int>=60){
        $min = floor($sec_int/60);
    }
    return ( $min ? $min.'m' : '' ).( $sec ? ( $min ? ' ' : '' ).$sec.'s' : '' );
}

function echo_content_url($x_clean_url,$x_type){
    if($x_type==4){
        return '<img src="'.$x_clean_url.'" style="max-width:100%" />';
    } elseif($x_type==3){
        return '<audio controls><source src="'.$x_clean_url.'" type="audio/mpeg"></audio>';
    } elseif($x_type==2){
        return '<video width="100%" onclick="this.play()" controls><source src="'.$x_clean_url.'" type="video/mp4"></video>';
    } elseif($x_type==5){
        return '<a href="'.$x_clean_url.'" class="btn btn-primary" target="_blank"><i class="fas fa-cloud-download"></i> Download File</a>';
    } else {
        return false;
    }
}

function echo_embed($url,$full_message=null,$require_image=false,$return_array=false){

    //$require_image is for Finding the cover photo in YouTube content

    $clean_url = null;
    $embed_code = null;
    $prefix_message = null;

    if(!$full_message){
        $full_message = $url;
    }

    //See if $url has a valid embed video in it, and transform it if it does:
    if(substr_count($url,'youtube.com/watch?v=')==1 || substr_count($url,'youtu.be/')==1 || substr_count($url,'youtube.com/embed/')==1){

        //Seems to be youtube:
        if(substr_count($url,'youtube.com/embed/')==1){

            //We might have start and end here too!
            $video_id = trim(one_two_explode('youtube.com/embed/','?',$url));

        } elseif(substr_count($url,'youtube.com/watch?v=')==1){

            $video_id = trim(one_two_explode('youtube.com/watch?v=','&',$url));

        } elseif(substr_count($url,'youtu.be/')==1){

            $video_id = trim(one_two_explode('youtu.be/','?',$url));

        }

        //This should be 11 characters!
        if(strlen($video_id)==11){

            //Set the Clean URL:
            $clean_url = 'https://www.youtube.com/watch?v='.$video_id;

            if($require_image){

                $embed_code = '<img src="https://img.youtube.com/vi/'.$video_id.'/0.jpg" class="yt-container" style="padding-bottom:0; margin:-28px 0px;" />';

            } else {
                //We might also find these in the URL:
                $start_sec = 0;
                $end_sec = 0;
                if(substr_count($url,'start=')>0){
                    $start_sec = intval(one_two_explode('start=','&',$url));
                    $clean_url = $clean_url.'&start='.$start_sec;
                }
                if(substr_count($url,'end=')>0){
                    $end_sec = intval(one_two_explode('end=','&',$url));
                    $clean_url = $clean_url.'&end='.$end_sec;
                }

                //Inform Student that this video has been sliced:
                if($start_sec || $end_sec){
                    $embed_code .= '<div class="video-prefix"><i class="fab fa-youtube" style="color:#ff0202;"></i> Watch from <b>'.($start_sec ? echo_min_from_sec($start_sec) : 'start').'</b> to <b>'.($end_sec ? echo_min_from_sec($end_sec) : 'end').'</b>:</div>';
                }

                $embed_code .= '<div class="yt-container video-sorting" style="margin-top:5px;"><iframe src="//www.youtube.com/embed/'.$video_id.'?theme=light&color=white&keyboard=1&autohide=2&modestbranding=1&showinfo=0&rel=0&iv_load_policy=3&start='.$start_sec.( $end_sec ? '&end='.$end_sec : '' ).'" frameborder="0" allowfullscreen class="yt-video"></iframe></div>';
            }

        }

    } elseif(substr_count($url,'vimeo.com/')==1 && !$require_image){

        //Seems to be Vimeo:
        $video_id = trim(one_two_explode('vimeo.com/','?',$url));

        //This should be an integer!
        if(intval($video_id)==$video_id){
            $clean_url = 'https://vimeo.com/'.$video_id;
            $embed_code = '<div class="yt-container video-sorting" style="margin-top:5px;"><iframe src="https://player.vimeo.com/video/'.$video_id.'?title=0&byline=0" class="yt-video" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe></div>';
        }

    } elseif(substr_count($url,'wistia.com/medias/')==1 && !$require_image){

        //Seems to be Wistia:
        $video_id = trim(one_two_explode('wistia.com/medias/','?',$url));
        $clean_url = trim(one_two_explode('','?',$url));
        $embed_code = '<script src="https://fast.wistia.com/embed/medias/'.$video_id.'.jsonp" async></script><script src="https://fast.wistia.com/assets/external/E-v1.js" async></script><div class="wistia_responsive_padding video-sorting" style="padding:56.25% 0 0 0;position:relative;"><div class="wistia_responsive_wrapper" style="height:100%;left:0;position:absolute;top:0;width:100%;"><div class="wistia_embed wistia_async_'.$video_id.' seo=false videoFoam=true" style="height:100%;width:100%">&nbsp;</div></div></div>';

    }

    if($return_array){

        //Return all aspects of this parsed URL:
        return array(
            'status' => ( $embed_code ? 1 : 0 ),
            'embed_code' => $embed_code,
            'clean_url' => $clean_url,
        );

    } else {
        //Just return the embed code:
        if($embed_code){
            return trim(str_replace($url,$embed_code,$full_message));
        } else {
            //Not matched with an embed rule:
            return false;
        }
    }



}




function echo_i($i,$u_full_name=null,$fb_format=false){

    //Must be one of these types:
    if(!isset($i['i_media_type']) || !in_array($i['i_media_type'],array('text','video','audio','image','file'))){
        return false;
    }


    //Do a quick hack to make these two variables inter-changable:
    if(isset($i['i_outbound_c_id']) && $i['i_outbound_c_id']>0 && !isset($i['e_outbound_c_id'])){
        $i['e_outbound_c_id'] = $i['i_outbound_c_id'];
    } elseif(isset($i['e_outbound_c_id']) && $i['e_outbound_c_id']>0 && !isset($i['i_outbound_c_id'])){
        $i['i_outbound_c_id'] = $i['e_outbound_c_id'];
    }


    $CI =& get_instance();

    if(!$fb_format){
        //HTML format:
        $div_style = ' style="padding:0; margin:0; font-family: Lato, Helvetica, sans-serif; font-size:16px;"'; //We do this for email templates that do not support CSS and also for internal website...
        $ui = '';
        $ui .= '<div class="i_content">';
    } else {
        //This is what will be returned to be sent via messenger:
        $fb_message = array();
    }

    //Proceed to Send Message:
    if($i['i_media_type']=='text' && strlen($i['i_message'])>0){


        //Do we have a {first_name} replacement?
        if($u_full_name){
            //Tweak the name:
            $i['i_message'] = str_replace('{first_name}', one_two_explode('',' ',$u_full_name), $i['i_message']);
        }

        if($i['i_outbound_u_id']>0){
            //This message has a reference:
            //Query this entity:
            $us = $CI->Db_model->u_fetch(array(
                'u_id' => $i['i_outbound_u_id'],
            ));
            $i['i_message'] = str_replace('@'.$i['i_outbound_u_id'], '<a href="/entities/'.$us[0]['u_id'].'">'.$us[0]['u_full_name'].'</a>', $i['i_message']);
        }


        //Does this message include a special command?
        $button_url = null;
        $button_title = null;
        $command = null;

        //Do we have any commands?
        if(substr_count($i['i_message'],'{button}')>0){

            $button_title = 'Open in 🚩Action Plan';
            $command = '{button}';
            $button_url = 'https://mench.com/my/actionplan'; //We assume a basic link to Action Plan

            if(isset($i['i_outbound_c_id']) && isset($i['e_b_id']) && isset($i['e_r_id'])){

                //Validate this to make sure it's all Good:
                $bs = fetch_action_plan_copy($i['e_b_id'],$i['e_r_id']);
                $c_data = extract_level( $bs[0], $i['i_outbound_c_id'] );

                //Does this intent belong to this Bootcamp/Class?
                if($c_data){
                    //Everything looks good:
                    $button_url = 'https://mench.com/my/actionplan/'.$i['e_b_id'].'/'.$i['i_outbound_c_id'];
                }
            }

        } elseif(substr_count($i['i_message'],'{enrollments}')>0 && isset($i['e_outbound_u_id'])) {

            //Fetch salt:
            $application_status_salt = $CI->config->item('application_status_salt');
            //append their My Account Button/URL:
            $button_title = '🎟️ My Bootcamps';
            $button_url = 'https://mench.co/my/applications?u_key=' . md5($i['e_outbound_u_id'] . $application_status_salt) . '&u_id=' . $i['e_outbound_u_id'];
            $command = '{enrollments}';

        } elseif(substr_count($i['i_message'],'{passwordreset}')>0 && isset($i['e_outbound_u_id'])) {

            //append their My Account Button/URL:
            $timestamp = time();
            $button_title = '👉 Set New Password';
            $button_url = 'https://mench.com/my/reset_pass?u_id='.$i['e_outbound_u_id'].'&timestamp='.$timestamp.'&p_hash=' . md5($i['e_outbound_u_id'] . 'p@ssWordR3s3t' . $timestamp);
            $command = '{passwordreset}';

        } elseif(substr_count($i['i_message'],'{messenger}')>0 && isset($i['e_outbound_u_id']) && isset($i['e_b_id'])) {

            //Fetch Facebook Page from Bootcamp:
            $bs = $CI->Db_model->b_fetch(array(
                'b.b_id' => $i['e_b_id'],
            ));

            if(isset($bs[0]['b_fp_id']) && $bs[0]['b_fp_id']>0 && isset($i['e_outbound_u_id']) && $i['e_outbound_u_id']>0){
                $button_url = $CI->Comm_model->fb_activation_url($i['e_outbound_u_id'],$bs[0]['b_fp_id']);
                if($button_url) {
                    //append their My Account Button/URL:
                    $button_title = '🤖 Activate Chatline';
                    $command = '{messenger}';
                }
            }

        }





        //Does this message also have a URL?
        if(isset($i['i_url']) && isset($i['i_id']) && intval($i['i_id'])>0 && strlen($i['i_url'])>0){

            $website = $CI->config->item('website');
            $masked_url = $website['url'].'ref/'.$i['i_id'];

            if($fb_format){

                //Messenger format, simply replace the link with a trackable one UNLESS the link is to our own domain:
                if(substr_count(strtolower($i['i_url']),'mench.com')==0){
                    $i['i_message'] = trim(str_replace($i['i_url'],$masked_url,$i['i_message']));
                } else {
                    //Clean the URL:
                    $i['i_message'] = trim(str_replace($i['i_url'],echo_clean_url($i['i_url']),$i['i_message']));
                }

            } else {

                //Is this a supported embed video URL?
                $embed_html = echo_embed($i['i_url'],$i['i_message']);
                if($embed_html){
                    $i['i_message'] = $embed_html;

                    //Facebook Messenger Webview adds an additional button to view full screen:
                    if(isset($i['show_new_window'])){
                        //HTML media format:
                        $i['i_message'] .= '<div><a href="https://mench.com/webview_video/'.$i['i_id'].'" target="_blank">Full Screen in New Window ↗️</a></div>';
                    }

                } else {
                    //HTML format:
                    $i['i_message'] = trim(str_replace($i['i_url'],'<a href="'.$masked_url.'" target="_blank"><span>'.echo_clean_url($i['i_url']).'</span><i class="fas fa-external-link-square" style="font-size: 0.8em; text-decoration:none; padding-left:4px;"></i></a>',$i['i_message']));
                }

            }
        }




        if($command){

            //Append the button to the message:
            if($fb_format){

                //Remove the command from the message:
                $i['i_message'] = trim(str_replace($command, '', $i['i_message']));

                //Return Messenger array:
                $fb_message = array(
                    'attachment' => array(
                        'type' => 'template',
                        'payload' => array(
                            'template_type' => 'button',
                            'text' => $i['i_message'],
                            'buttons' => array(
                                array(
                                    'title' => $button_title,
                                    'type' => 'web_url',
                                    'url' => $button_url,
                                    'webview_height_ratio' => 'tall',
                                    'webview_share_button' => 'hide',
                                    'messenger_extensions' => true,
                                ),
                            ),
                        ),
                    ),
                    'metadata' => 'system_logged', //Prevents from duplicate logging via the echo webhook
                );

            } else {
                //HTML format replaces the button with the command:
                $i['i_message'] = trim(str_replace($command, '<div class="msg" style="padding-top:15px;"><a href="'.$button_url.'" target="_blank"><b>'.$button_title.'</b></a></div>', $i['i_message']));
                //Return HTML code:
                $ui .= '<div class="msg" '.$div_style.'>'.nl2br($i['i_message']).'</div>';
            }

        } else {

            //Regular without any special commands in it!
            //Now return the template:
            if($fb_format){
                //Messenger array:
                $fb_message = array(
                    'text' => $i['i_message'],
                    'metadata' => 'system_logged', //Prevents from duplicate logging via the echo webhook
                );
            } else {
                //HTML format:
                $ui .= '<div class="msg" '.$div_style.'>'.nl2br($i['i_message']).'</div>';
            }

        }

    } elseif(in_array($i['i_media_type'],array('video','audio','image','file')) && strlen($i['i_url'])>0) {

        //Valid media file with URL:
        if($fb_format){

            $payload = array();

            //Do we have this saved in FB Servers?
            if(isset($i['e_fp_id']) && $i['e_fp_id']>0 && isset($i['i_id']) && $i['i_id']>0){

                //See if we have a cached version of this file for this page:
                $synced_media_files = $CI->Db_model->sy_fetch(array(
                    'sy_i_id' => $i['i_id'],
                    'sy_fp_id' => $i['e_fp_id'],
                ));

                if(isset($synced_media_files[0]['sy_fb_att_id']) && $synced_media_files[0]['sy_fb_att_id']>0){
                    //Yesss, use that:
                    $payload = array(
                        'attachment_id' => $synced_media_files[0]['sy_fb_att_id'],
                    );
                }
            }

            if(count($payload)<1){
                //Use standard file:
                $payload = array(
                    'url' => $i['i_url'],
                    'is_reusable' => false,
                );
            }

            //Messenger array:
            $fb_message = array(
                'attachment' => array(
                    'type' => $i['i_media_type'],
                    'payload' => $payload,
                ),
                'metadata' => 'system_logged', //Prevents from duplicate logging via the echo webhook
            );

        } else {

            //HTML media format:
            $ui .= '<div '.$div_style.'>'.format_e_text_value('/attach '.$i['i_media_type'].':'.$i['i_url']).'</div>';

            //Facebook Messenger Webview adds an additional button to view full screen:
            if(isset($i['show_new_window']) && $i['i_media_type']=='video'){
                //HTML media format:
                $ui .= '<div><a href="https://mench.com/webview_video/'.$i['i_id'].'" target="_blank">Full Screen in New Window ↗️</a></div>';
            }

        }

    } else {

        //Something was wrong:
        return false;

    }

    //Log engagement if Facebook and return:
    if($fb_format && count($fb_message)>0){

        //Return Facebook Message to be sent out:
        return $fb_message;

    } elseif(!$fb_format) {

        //This must be HTML if we're still here, return:
        $ui .= '</div>';
        return $ui;

    } else {

        //Should not happen!
        return false;

    }
}



function echo_message($i){

    $ui = '';
    $ui .= '<div class="list-group-item is-msg is_level2_sortable all_msg msg_'.$i['i_status'].'" id="ul-nav-'.$i['i_id'].'" iid="'.$i['i_id'].'">';
    $ui .= '<input type="hidden" class="i_media_type" value="'.$i['i_media_type'].'" />';
    $ui .= '<div style="overflow:visible !important;">';

    //Type & Delivery Method:
    $ui .= '<div class="'.($i['i_media_type']=='text'?'edit-off text_message':'').'" id="msg_body_'.$i['i_id'].'" style="margin:5px 0 0 0;">';
    $ui .= echo_i($i);
    $ui .= '</div>';


    if($i['i_media_type']=='text'){
        //Text editing:
        $ui .= '<textarea onkeyup="changeMessageEditing('.$i['i_id'].')" name="i_message" id="message_body_'.$i['i_id'].'" class="edit-on hidden msg msgin" placeholder="Write Message..." style="margin-top: 4px;">'.$i['i_message'].'</textarea>';
    }

    //Editing menu:
    $ui .= '<ul class="msg-nav">';
    //$ui .= '<li class="edit-off"><i class="fas fa-clock"></i> 4s Ago</li>';
    $ui .= '<li class="the_status edit-off" style="margin: 0 6px 0 -3px;">'.echo_status('i_status',$i['i_status'],1,'right').'</li>';
    if($i['i_media_type']=='text'){
        $CI =& get_instance();
        $message_max = $CI->config->item('message_max');
        $ui .= '<li class="edit-on hidden"><span id="charNumEditing'.$i['i_id'].'">0</span>/'.$message_max.'</li>';
    }
    $ui .= '<li class="edit-off"><span class="on-hover i_uploader">'.echo_cover($i,null,true, 'data-toggle="tooltip" title="Last modified by '.$i['u_full_name'].' about '.echo_diff_time($i['i_timestamp']).' ago" data-placement="right"').'</span></li>';

    $ui .= '<li class="edit-off" style="margin: 0 0 0 8px;"><span class="on-hover"><i class="fas fa-bars sort_message" iid="'.$i['i_id'].'" style="color:#3C4858;"></i></span></li>';
    $ui .= '<li class="edit-off" style="margin-right: 10px; margin-left: 6px;"><span class="on-hover"><a href="javascript:i_delete('.$i['i_id'].');"><i class="fas fa-trash-alt" style="margin:0 7px 0 5px;"></i></a></span></li>';
    if($i['i_media_type']=='text'){
        $ui .= '<li class="edit-off" style="margin-left:-4px;"><span class="on-hover"><a href="javascript:msg_start_edit('.$i['i_id'].','.$i['i_status'].');"><i class="fas fa-pen-square"></i></a></span></li>';
    }
    //Right side reverse:
    $ui .= '<li class="pull-right edit-on hidden"><a class="btn btn-primary" href="javascript:message_save_updates('.$i['i_id'].','.$i['i_status'].');" style="text-decoration:none; font-weight:bold; padding: 1px 8px 4px;"><i class="fas fa-check"></i></a></li>';
    $ui .= '<li class="pull-right edit-on hidden"><a class="btn btn-hidden" href="javascript:msg_cancel_edit('.$i['i_id'].');"><i class="fas fa-times" style="color:#3C4858"></i></a></li>';
    $ui .= '<li class="pull-right edit-on hidden">'.echo_dropdown_status('i_status','i_status_'.$i['i_id'],$i['i_status'],array(-1,0),'dropup',1).'</li>';
    $ui .= '<li class="pull-right edit-updates"></li>'; //Show potential errors

    $ui .= '</ul>';

    $ui .= '</div>';
    $ui .= '</div>';

    return $ui;
}


function echo_cover($u,$img_class=null,$return_anyways=false,$tooltip_content=null){
    if($u['u_cover_x_id']>0 && isset($u['x_url'])){
        return '<img src="'.$u['x_url'].'" class="'.$img_class.'" '.$tooltip_content.' />';
    } elseif($return_anyways) {
        return '<i class="fas fa-at" '.$tooltip_content.' ></i>';
    } else {
        return null;
    }
}

function echo_link($text){
    return preg_replace('!(((f|ht)tp(s)?://)[-a-zA-Zа-яА-Я()0-9@:%_+.~#?&;//=]+)!i', '<a href="$1" target="_blank"><u>$1</u></a>', $text);
}


function echo_completion_report($us_eng){
    echo echo_status('e_status',$us_eng['e_status']);
    echo '<div style="margin:10px 0 10px;"><span class="status-label" style="color:#3C4858;"><i class="fas fa-clock initial"></i>Completion Time:</span> '.echo_time($us_eng['e_timestamp']).' PST</div>';
    echo '<div style="margin-bottom:10px;"><span class="status-label" style="color:#3C4858;"><i class="fas fa-comment-dots initial"></i>Your Comments:</span> '.( strlen($us_eng['e_text_value'])>0 ? echo_link(nl2br(htmlentities($us_eng['e_text_value']))) : 'None' ).'</div>';
}


function echo_clean_url($url){
    return rtrim(str_replace('http://','',str_replace('https://','',str_replace('www.','',$url))),'/');
}



function echo_hours($decimal_hours,$micro=false,$plus=false){

    if($decimal_hours<=0){

        return '0'.($micro?'m':' Minutes ');

    } elseif($decimal_hours<=1.50){

        $original_hours = $decimal_hours*60;
        $decimal_hours = round($original_hours);
        return $decimal_hours.($plus?'+':'').($micro?'m':' Minutes');

    } else {

        //Just round-up:
        $original_hours = $decimal_hours;
        $decimal_hours = round($original_hours);
        return $decimal_hours.($plus?'+':'').($micro?'h':' Hour'.echo__s($original_hours));

    }

}


function echo_object($object,$id){
    //Loads the name (and possibly URL) for $object with id=$id
    $CI =& get_instance();
    $id = intval($id);

    if($id>0){
        //Used mainly for engagement tracking
        $website = $CI->config->item('website');

        if($object=='c'){
            //Fetch intent/Step:
            $cs = $CI->Db_model->c_fetch(array(
                'c.c_id' => $id,
            ));
            if(isset($cs[0])){
                return '<a href="'.$website['url'].'intents/'.$cs[0]['c_id'].'">'.$cs[0]['c_outcome'].'</a>';
            }

        } elseif($object=='u'){
            if($id<=0){
                return 'System';
            } else {
                $matching_users = $CI->Db_model->u_fetch(array(
                    'u_id' => $id,
                ));
                if(isset($matching_users[0])){
                    //TODO Link to profile or chat widget link maybe?
                    return '<a href="'.$website['url'].'entities/'.$id.'" title="User ID '.$id.'">'.$matching_users[0]['u_full_name'].'</a>';
                }
            }

        } elseif($object=='x' && $id>0){

            $matching_urls = $CI->Db_model->x_fetch(array(
                'x_id' => $id,
            ));
            if(isset($matching_urls[0])){
                return '<a href="'.$matching_urls[0]['x_url'].'" title="Reference ID '.$id.'" target="_blank">'.echo_clean_url($matching_urls[0]['x_url']).'</a>';
            }

        }
        //We would not do the other engagement types...
    }

    //Still here? Return default:
    if($id>0){
        return '#'.$id;
    } else {
        return NULL;
    }
}



function echo_diff_time($t,$second_time=null){
    if(!$second_time){
        $second_time = time(); //Now
    } else {
        $second_time = strtotime(substr($second_time,0,19));
    }

    $time = $second_time - ( is_int($t) ? $t : strtotime(substr($t,0,19)) ); // to get the time since that moment
    $is_future = ( $time<0 );
    $time = abs($time);
    $tokens = array (
        31536000 => 'Year',
        2592000 => 'Month',
        604800 => 'Week',
        86400 => 'Day',
        3600 => 'Hour',
        60 => 'Minute',
        1 => 'Second'
    );

    foreach ($tokens as $unit => $text) {
        if ($time<$unit && $unit>1) continue;
        if($unit>=2592000 && fmod(($time / $unit),1)>=0.33 && fmod(($time / $unit),1)<=.67){
            $numberOfUnits = number_format(($time / $unit),1);
        } else {
            $numberOfUnits = number_format(($time / $unit),0);
        }

        if($numberOfUnits<1 && $unit==1){
            $numberOfUnits = 1; //Change "0 seconds" to "1 second"
        }

        return $numberOfUnits.' '.$text.(($numberOfUnits>1)?'s':'');
    }
}

function echo_time($t,$format=0,$adjust_seconds=0){
    if(!$t){
        return 'NOW';
    }

    $timestamp = ( is_numeric($t) ? $t : strtotime(substr($t,0,19)) ) + $adjust_seconds; //Added this last part to consider the end of days for dates
    $year = ( date("Y")==date("Y",$timestamp) );
    if($format==0){
        return date(( $year ? "M j, g:i a" : "M j, Y, g:i a" ),$timestamp);
    } elseif($format==1){
        return date(( $year ? "j M" : "j M Y" ),$timestamp);
    } elseif($format==2){
        return date(( $year ? "D M j " : "j M Y" ),$timestamp);
    } elseif($format==3){
        return $timestamp;
    } elseif($format==4){
        return date(( $year ? "M j" : "M j Y" ),$timestamp);
    } elseif($format==5){
        return date(( $year ? "D M j" : "D M j Y" ),$timestamp);
    } elseif($format==6){
        return date("Y/m/d",$timestamp);
    } elseif($format==7){
        return date(( $year ? "D M j, g:i a" : "D M j, Y, g:i a" ),$timestamp);
    } elseif($format==8){
        return date(( $year ? "M j" : "M j Y" ),$timestamp);
    }
}



function echo_status($object=null,$status=null,$micro_status=false,$data_placement='bottom'){

    //IF you make any changes, make sure to also reflect in the echo_status.php as well
    $CI =& get_instance();
    $status_index = $CI->config->item('object_statuses');

    //Return results:
    if(is_null($object)){

        //Everything
        return $status_index;

    } elseif(is_null($status)){

        //Object Specific
        if(is_array($object) && count($object)>0){
            return $object;
        } else {
            return ( isset($status_index[$object]) ? $status_index[$object] : false );
        }

    } else {

        $status = intval($status);
        if(is_array($object) && count($object)>0){
            $result = $object[$status];
        } else {
            $result = $status_index[$object][$status];
        }

        if(!$result){
            //Could not find matching item
            return false;
        } else {
            //We have two skins for displaying statuses:
            if(is_null($data_placement) && $micro_status){
                return ( isset($result['s_icon']) ? '<i class="'.$result['s_icon'].' initial"></i> ' : '<i class="fas fa-sliders-h initial"></i> ' );
            } else {
                return '<span class="status-label" '.( isset($result['s_desc']) && !is_null($data_placement) ? 'data-toggle="tooltip" data-placement="'.$data_placement.'" title="'.$result['s_desc'].'" style="border-bottom:1px dotted #444; padding-bottom:1px;"':'style="cursor:pointer;"').'>'.( isset($result['s_icon']) ? '<i class="'.$result['s_icon'].' initial"></i> ' : '<i class="fas fa-sliders-h initial"></i> ' ).($micro_status?'':$result['s_name']).'</span>';
            }

        }
    }
}


function echo_estimated_time($c_time_estimate,$show_icon=1,$micro=false,$c_id=0,$c_time_intent=0){

    if($c_time_estimate>0 || $c_id){

        $ui = '<span class="title-sub" style="text-transform:none !important;">';

        if($c_id){

            $ui .= '<span class="slim-time" id="t_estimate_'.$c_id.'" tree-hours="'.$c_time_estimate.'" intent-hours="'.$c_time_intent.'">'.echo_hours( $c_time_estimate,true).'</span>';

            if($show_icon){
                $ui .= ' <i class="fas fa-clock"></i>';
            }

        } else {

            if($show_icon){
                $ui .= '<i class="fas fa-clock"></i>';
            }
            if($c_time_estimate<1){
                //Minutes:
                $ui .= round($c_time_estimate*60).($micro?'m':' Minutes');
            } else {
                //Hours:
                $ui .= round($c_time_estimate,0).($micro?'h':' Hour'.(round($c_time_estimate,1)==1?'':'s'));
            }
        }

        $ui .= '</span>';
        return $ui;
    }

    //No time:
    return null;

}

function echo_support_chat(){
    $CI =& get_instance();
    $fb_settings = $CI->config->item('fb_settings');
    ?>
    <div style="margin:30px auto; display:block; max-width:285px;">
        <div class="fb-send-to-messenger"
             messenger_app_id="<?= $fb_settings['app_id'] ?>"
             page_id="<?= $fb_settings['page_id'] ?>"
             data-ref="helloworld"
             color="blue"
             cta_text="GET_STARTED_IN_MESSENGER"
             size="xlarge">Loading...</div>

        <div style="font-size:0.9em; padding:10px 0 0 3px; margin-bottom: 0;">
            <p style="line-height:130%; font-size:1em !important;"><b>7-Day free trial, then $7 per week</b>.<br /><span style="display: inline-block;">No credit</span> card needed. Cancel anytime.</p>
        </div>
    </div>


    <script>
        FB.Event.subscribe('send_to_messenger', function(e) {
            // callback for events triggered by the plugin
        });
    </script>
    <?php
}






function echo_actionplan($c, $level, $c_inbound_id=0, $is_inbound=false){

    $CI =& get_instance();
    $udata = $CI->session->userdata('user');

    if($level==1){

        //Bootcamp Outcome:
        $ui = '<div class="list-group-item">';

    } else {

        //ATTENTION: DO NOT CHANGE THE ORDER OF data-link-id & intent-id AS the sorting logic depends on their exact position to sort!
        //CHANGE WITH CAUTION!
        $ui = '<div id="cr_'.$c['cr_id'].'" data-link-id="'.$c['cr_id'].'" intent-id="'.$c['c_id'].'" parent-intent-id="'.$c_inbound_id.'" intent-level="'.$level.'" class="list-group-item '.( $level==3 ? 'is_level3_sortable' : 'is_level2_sortable' ).' intent_line_'.$c['c_id'].'">';

    }

    //Right content
    $ui .= '<span class="pull-right" style="'.( $level<3 ? 'margin-right: 8px;' : '' ).'">';

    $ui .= '<i class="c_is_any_icon'.$c['c_id'].' '.( $c['c_is_any'] ? 'fas fa-code-merge' : 'fas fa-sitemap' ).'" style="font-size:0.9em; width:28px; padding-right:3px; text-align:center;"></i>';


    $ui .= '<a href="#messages-'.$c['c_id'].'" onclick="i_load_frame('.$c['c_id'].')" class="badge badge-primary" style="width:40px;" title="'.$c['c__tree_messages'].' Messages in tree"><span class="btn-counter" id="messages-counter-'.$c['c_id'].'">'.$c['c__this_messages'].'</span><i class="fas fa-comment-dots"></i></a>';

    $ui .= '<a class="badge badge-primary" onclick="load_modify('.$c['c_id'].','.( isset($c['cr_id']) ? $c['cr_id'] : 0 ).')" style="margin:-2px -8px 0 2px; width:40px;" href="#modify-'.$c['c_id'].'-'.( isset($c['cr_id']) ? $c['cr_id'] : 0 ).'"><span class="btn-counter">'.echo_estimated_time($c['c__tree_hours'],0,1, $c['c_id'], $c['c_time_estimate']).'</span><i class="fas fa-cog"></i></a> &nbsp;';


    $ui .= '&nbsp;<'.( $level>1 || $c['c__is_orphan'] ? 'a href="/intents/'.$c['c_id'].'" class="badge badge-primary"' :'span class="badge badge-primary grey"').' style="display:inline-block; margin-right:-1px; width:40px;"><span class="btn-counter outbound-counter-'.$c['c_id'].'">'.($c['c__tree_inputs']+$c['c__tree_outputs']-1).'</span><i class="'.( $is_inbound ? 'fas fa-sign-in-alt' : 'fas fa-sign-out-alt rotate90' ).'"></i></'.( $level>1 || $c['c__is_orphan'] ? 'a' :'span').'> ';

    //Keep an eye out for inner message counter changes:
    $ui .= '</span> ';



    $c_settings = ' c_require_url_to_complete="'.$c['c_require_url_to_complete'].'" c_require_notes_to_complete="'.$c['c_require_notes_to_complete'].'" c_is_any="'.$c['c_is_any'].'" c_is_output="'.$c['c_is_output'].'" ';


    //Sorting & Then Left Content:
    if($level>1 && !$is_inbound) {
        $ui .= '<i class="fas fa-bars"></i> &nbsp;';
    }


    if($level==1){

        //Bootcamp Outcome:
        $ui .= '<span><b id="b_objective" style="font-size: 1.3em;">';
        $ui .= '<i class="c_is_output_icon'.$c['c_id'].' '.( $c['c_is_output'] ? 'fas fa-check-square' : 'fas fa-lightbulb-on' ).'"></i> ';
        $ui .= '<span class="c_outcome_'.$c['c_id'].'" '.$c_settings.'>'.$c['c_outcome'].'</span>';
        $ui .= '</b></span>';

    } elseif($level==2){

        //Task:
        $ui .= '<span class="inline-level">';

        $ui .= '<a href="javascript:ms_toggle('.$c['cr_id'].');"><i id="handle-'.$c['cr_id'].'" class="fal fa-plus-square"></i></a> &nbsp;';

        $ui .= '<span class="inline-level-'.$level.'">#'.$c['cr_outbound_rank'].'</span> ';
        $ui .= '<i class="c_is_output_icon'.$c['c_id'].' '.( $c['c_is_output'] ? 'fas fa-check-square' : 'fas fa-lightbulb-on' ).'" style="width:20px; text-align:center;"></i>';
        $ui .= '</span>';

        $ui .= '<b id="title_'.$c['cr_id'].'" class="cdr_crnt c_outcome_'.$c['c_id'].'" outbound-rank="'.$c['cr_outbound_rank'].'" '.$c_settings.'>'.$c['c_outcome'].'</b> ';

    } elseif ($level==3){

        //Steps
        $ui .= '<span class="inline-level inline-level-'.$level.'">#'.$c['cr_outbound_rank'].'</span> ';
        $ui .= '<i class="c_is_output_icon'.$c['c_id'].' '.( $c['c_is_output'] ? 'fas fa-check-square' : 'fas fa-lightbulb-on' ).'" style="font-size: 0.9em; width:20px; text-align:center;"></i> ';
        $ui .= '<span id="title_'.$c['cr_id'].'" class="c_outcome_'.$c['c_id'].'" outbound-rank="'.$c['cr_outbound_rank'].'" '.$c_settings.'>'.$c['c_outcome'].'</span> ';

    }


    if($level==1 && !$c['c__is_orphan']){
        $ui .= ' <a href="/'.$c['c_id'].'" style="padding-left:5px;" target="_blank"><i class="fas fa-external-link"></i></a>';
    }


    //Any Tree?
    if($level==2){

        $ui .= '<div id="list-cr-'.$c['cr_id'].'" class="cr-class-'.$c['cr_id'].' list-group step-group hidden list-level-3" intent-id="'.$c['c_id'].'">';
        //This line enables the in-between list moves to happen for empty lists:
        $ui .= '<div class="is_level3_sortable dropin-box" style="height:1px;">&nbsp;</div>';


        if(isset($c['c__child_intents']) && count($c['c__child_intents'])>0){
            foreach($c['c__child_intents'] as $key=>$sub_intent){
                $ui .= echo_actionplan($sub_intent, ($level+1), $c['c_id'], $is_inbound);
            }
        }


        //Step Input field:
        $ui .= '<div class="list-group-item list_input new-step-input">
            <div class="input-group">
                <div class="form-group is-empty"  style="margin: 0; padding: 0;"><form action="#" onsubmit="new_intent('.$c['c_id'].',3);" intent-id="'.$c['c_id'].'"><input type="text" class="form-control autosearch intentadder-level-3" maxlength="70" id="addintent-cr-'.$c['cr_id'].'" intent-id="'.$c['c_id'].'" placeholder="Add #Intent"></form></div>
                <span class="input-group-addon" style="padding-right:8px;">
                    <span data-toggle="tooltip" title="or press ENTER ;)" data-placement="top" onclick="new_intent('.$c['c_id'].',3);" class="badge badge-primary pull-right" intent-id="'.$c['c_id'].'" style="cursor:pointer; margin: 13px -6px 1px 13px;">
                        <div><i class="fas fa-plus"></i></div>
                    </span>
                </span>
            </div>
        </div>';


        $ui .= '</div>';
    }


    $ui .= '</div>';
    return $ui;

}


function echo_json($array){
    header('Content-Type: application/json');
    echo json_encode($array);
}





function echo_ordinal($number){
    $ends = array('th','st','nd','rd','th','th','th','th','th','th');
    if (($number %100) >= 11 && ($number%100) <= 13){
        return $number. 'th';
    } else {
        return $number. $ends[$number % 10];
    }
}

function echo__s($count,$is_es=0){
    return ( $count==1?'':( $is_es ? 'es' : 's'));
}


function echo_dropdown_status($object,$input_name,$current_status_id,$exclude_ids=array(),$direction='dropdown',$mini=0){

    $CI =& get_instance();
    $udata = $CI->session->userdata('user');
    $inner_tooltip = ($direction=='dropup'?null:'top');

    if(is_array($object)){
        $statuses = $object;
    } else {
        $statuses = echo_status($object,null,false,'bottom');
    }
    $now = echo_status($object,$current_status_id,$mini,$inner_tooltip);

    $return_ui = '';
    $return_ui .= '<input type="hidden" id="'.$input_name.'" value="'.$current_status_id.'" />';
    $return_ui .= '<div style="display:inline-block;" class="'.$direction.'">';
    $return_ui .= '<a href="#" style="margin: 0; background-color:#FFF;" class="btn btn-simple dropdown-toggle border" id="ui_'.$input_name.'" data-toggle="dropdown">';
    $return_ui .= ( $now ? $now : 'Select...' );
    $return_ui .= '<b class="caret"></b></a><ul class="dropdown-menu">';

    $count = 0;
    foreach($statuses as $intval=>$status){
        $count++;
        $return_ui .= '<li><a href="javascript:update_dropdown(\''.$input_name.'\','.$intval.','.$count.');">'.echo_status($object,$intval,0,$inner_tooltip).'</a></li>';
        $return_ui .= '<li style="display:none;" class="'.$input_name.'_'.$intval.'" id="'.$input_name.'_'.$count.'">'.echo_status($object,$intval,$mini,$inner_tooltip).'</li>'; //For UI replacement
    }
    $return_ui .= '</ul></div>';
    return $return_ui;
}

