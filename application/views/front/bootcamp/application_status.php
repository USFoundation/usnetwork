<?php 
echo '<div id="application_status" style="text-align:left !important; padding-left:5px !important;">';
echo '<h3>Bootcamp Applications</h3>';
echo '<p>Logged in as '.$udata['u_fname'].' '.$udata['u_lname'].'.</p>';

foreach($enrollments as $enrollment){
    
    //Determine the steps:
    $applied = (strlen($enrollment['ru_application_survey'])>0);
    $paid = ( $enrollment['ru_paid_sofar']>=$enrollment['cohort']['r_usd_price']);
    
    echo '<hr />';
    echo '<h4>'.$enrollment['bootcamp']['c_objective'].'</h4>';
    echo '<p>Complete these 3 steps to apply to this bootcamp:</h4>';
    
    
    //Account, always created at this point:
    echo '<div class="checkbox"><label style="text-decoration:line-through;"><input type="checkbox" disabled checked> Step 1: Initiate Application</label></div>';
    
    
    //Typeform Application:
    echo '<div class="checkbox"><label '.( $applied ? 'style="text-decoration: line-through;"' : '' ).'><input type="checkbox" disabled '.( $applied ? 'checked' : '' ).'> <a href="'.( $applied ? 'javasript:void(0);' : 'https://mench.typeform.com/to/'.$enrollment['cohort']['r_typeform_id'].'?u_key='.$u_key.'&u_id='.$enrollment['u_id'].'&u_email='.$enrollment['u_email'].'&u_fname='.urlencode($enrollment['u_fname']) ).'"> Step 2: Submit Application <i class="fa fa-chevron-right" aria-hidden="true"></i></a></label></div>';

    
    //Payment
    echo '<div class="checkbox"><label '.( $paid ? 'style="text-decoration: line-through;"' : '' ).'><input type="checkbox" disabled '.( $paid ? 'checked' : '' ).'> <a href="'.($paid ? 'javascript:void(0)' : 'javascript:$(\'#paypal_'.$enrollment['ru_id'].'\').submit()').';">Step 3: Pay $'.$enrollment['cohort']['r_usd_price'].' Tuition with CreditCard/Paypal <i class="fa fa-chevron-right" aria-hidden="true"></i></a></label></div>';
    if(!$paid){
        ?>
        
        <?php if(isset($_GET['pay_r_id']) && intval($_GET['pay_r_id']) && intval($_GET['pay_r_id'])==intval($enrollment['cohort']['r_id'])){ ?>
        <!-- Immediate redirect to paypal -->
        <script>
        $( document ).ready(function() {
        	$('#paypal_<?= $enrollment['ru_id'] ?>').submit();
        	//Hide content from within the page:
        	$('#application_status').html('<img src="/img/round_yellow_load.gif" class="loader" />');
        });
        </script>
        <?php } ?>
        
        <form action="https://www.paypal.com/cgi-bin/webscr" id="paypal_<?= $enrollment['ru_id'] ?>" method="post" target="_top" style="display:none;">
            <input type="hidden" name="cmd" value="_xclick">
            <input type="hidden" name="business" value="EYKXCMCJHEBA8">
            <input type="hidden" name="lc" value="US">
            <input type="hidden" name="item_name" value="Bootcamp Tuition: <?= $enrollment['bootcamp']['c_objective'] ?>">
            <input type="hidden" name="item_number" value="<?= $enrollment['ru_id'] ?>">
            <input type="hidden" name="custom_r_id" value="<?= $enrollment['cohort']['r_id'] ?>">
            <input type="hidden" name="custom_u_id" value="<?= $u_id ?>">
            <input type="hidden" name="custom_u_key" value="<?= $u_key ?>">
            <input type="hidden" name="amount" value="<?= ( $enrollment['cohort']['r_usd_price'] ? 1 : 1 ) ?>">
            <input type="hidden" name="currency_code" value="USD">
            <input type="hidden" name="button_subtype" value="services">
            <input type="hidden" name="no_note" value="1">
            <input type="hidden" name="no_shipping" value="1">
            <input type="hidden" name="rm" value="1">
            <input type="hidden" name="return" value="https://mench.co/application_status?status=1&message=<?= urlencode('Payment received.'); ?>&u_key=<?= $u_key ?>&u_id=<?= $u_id ?>">
            <input type="hidden" name="cancel_return" value="https://mench.co/application_status?status=0&message=<?= urlencode('Payment cancelled.'); ?>&u_key=<?= $u_key ?>&u_id=<?= $u_id ?>">
            <input type="hidden" name="bn" value="PP-BuyNowBF:btn_paynowCC_LG.gif:NonHosted">
            <input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_paynowCC_LG.gif" border="0" name="submit" alt="PayPal">
            <img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
        </form>
        
        <?php
    }
    
    
    //Instructor Approval:
    if($applied && $paid){
        //Now let them know the status of their application:
        echo status_bible('ru',$enrollment['ru_status'],0,'top');
    }
}
echo '</div>';
?>