
<script src="/application/views/app/7264.js?v=1.0" type="text/javascript"></script>

<?php

if(!isset($_GET['i__id']) || !intval($_GET['i__id'])){

    echo 'Missing Idea ID (Append ?i__id=ID in URL)';

} else {

    //IDEA MARKS BIRDS EYE

    //Give an overview of the point transactions in a hierchial format to enable members to overview:
    $_GET['depth_levels']   = ( isset($_GET['depth_levels']) && intval($_GET['depth_levels']) > 0 ? $_GET['depth_levels'] : 3 );

    echo '<form method="GET" action="">';

    echo '<div class="score_range_box">
                <div class="form-group"
                     style="max-width:550px; margin:1px 0 10px; display: inline-block;">
                    <div class="input-group border">
                        <span class="input-group-addon addon-lean addon-grey" style="color:#222222; font-weight: 300;">Start at #</span>
                        <input style="padding-left:3px; min-width:56px;" type="number" min="1" step="1" name="i__id" id="i__id" value="'.$_GET['i__id'].'" class="form-control">
                        <span class="input-group-addon addon-lean addon-grey" style="color:#222222; font-weight: 300; border-left: 1px solid #999999;"> and go </span>
                        <input style="padding-left:3px; min-width:56px;" type="number" min="1" step="1" name="depth_levels" id="depth_levels" value="'.$_GET['depth_levels'].'" class="form-control">
                        <span class="input-group-addon addon-lean addon-grey" style="color:#222222; font-weight: 300; border-left: 1px solid #999999; border-right:0px solid #FFF;"> levels deep.</span>
                    </div>
                </div>
                <input type="submit" class="btn btn-12273" value="Go" style="display: inline-block; margin-top: -41px;" />
            </div>';

    echo '</form>';

    //Load the report via Ajax here on page load:
    echo '<div id="app_7264"></div>';

}